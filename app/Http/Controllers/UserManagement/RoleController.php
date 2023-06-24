<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UserManagement\Role;
use App\Models\UserManagement\Permission;
use App\Models\UserManagement\RolePermission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $routes_permissions = [
                "roles.index" => ['create-role', 'view-role', 'update-role', 'delete-role'],
                "roles.get" => ['create-role', 'view-role', 'update-role', 'delete-role'],
                "roles.get.permissions" => ['create-role', 'view-role', 'update-role', 'delete-role'],
                "roles.create" => ['create-role'],
                "roles.store" => ['create-role'],
                "roles.show" => ['view-role'],
                "roles.edit" => ['update-role'],
                "roles.update" => ['update-role'],
                "roles.update.permissions" => ['update-role'],
                "roles.destroy" => ['delete-role'],
            ];
            if($request->user()->canany($routes_permissions[Route::currentRouteName()])){
                return $next($request);
            }
            abort(403);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user_management.roles.index');
    }

    /*
    AJAX request
    */
    public function get(Request $request){
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $selected_rows = $request->selected_rows ? $request->selected_rows : [];

        // Total records
        $totalRecords = Role::select('count(*) as allcount')
                            ->where('name','!=','Super Admin')
                            ->where('status','=','active')
                            ->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')
                                        ->where(function($q) use($searchValue) {
                                            $q->where('name', 'like', '%' .$searchValue . '%');
                                        })
                                        ->where('name','!=','Super Admin')
                                        ->where('status','=','active')
                                        ->count();
        if($rowperpage==-1){
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = Role::orderBy($columnName,$columnSortOrder)
                        ->where(function($q) use($searchValue) {
                            $q->where('name', 'like', '%' .$searchValue . '%');
                        })
                        ->where('name','!=','Super Admin')
                        ->where('status','=','active')
                        ->select('roles.*')
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();

        $data_arr = array();

        foreach($records as $record){
            $checked = "";
            if(in_array($record->id, $selected_rows)){
                $checked = 'checked=""';
            }
            $checkbox = '<label class="custom-control custom-control-sm custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="'.$record->id.'" '.$checked.'>
                            <span class="custom-control-label"></span>
                        </label>';

            $id = $record->id;
            $name = $record->name;

            $data_view_route = route("roles.show",$record->id);
            $data_edit_route = route("roles.edit",$record->id);
            $data_update_route = route("roles.update",$record->id);

            if($request->user()->canany(['view-role','update-role'])) {
                if($request->user()->can('update-role')){
                    $id = '<a href="javascript:void(0)" class="edit-role" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="edit-role" style="vertical-align: sub;" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->name.'</a>';
                } else if($request->user()->can('view-role')) {
                    $id = '<a href="javascript:void(0)" class="view-role" data-view-route="'.$data_view_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="view-role" style="vertical-align: sub;" data-view-route="'.$data_view_route.'">'.$record->name.'</a>';
                }
            }

            $action = '<div class="btn-group">';
            if($request->user()->can('view-role')) {
                $action .= '<button class="btn btn-space btn-info btn-sm view-role" data-view-route="'.$data_view_route.'">
                            <i class="icon mdi mdi-eye"></i>
                        </button>';
            }
            if($request->user()->can('update-role')) {
                $action .= '<button class="btn btn-space btn-primary btn-sm edit-role" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">
                            <i class="icon mdi mdi-edit"></i>
                        </button>';
            }
            if($request->user()->can('delete-role')) {
                $data_delete_route = route("roles.destroy",$record->id);
                $action .= '<button class="btn btn-space btn-danger btn-sm delete" data-delete-route="'.$data_delete_route.'">
                                <i class="icon mdi mdi-delete"></i>
                            </button>';
            }
            $action .= '</div>';

            $data_arr[] = array(
                "checkbox" => $checkbox,
                "id" => $id,
                "name" => $name,
                "action" => $action
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /*
    AJAX request
    */
    public function getPermissions(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $rolePermissions = $role->permissions->pluck('permission.id')->toArray();

        $response = "";
        $permissions = Permission::all();
        foreach($permissions as $permission):
            $checked = '';
            if(in_array($permission->id,$rolePermissions)){
                $checked = 'checked=""';
            }
            $response .= '<tr>
                        <td>'.$permission->name.'</td>
                        <td class="text-center">
                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" type="checkbox" name="permissions[]" value="'.$permission->id.'" '.$checked.'>
                                <span class="custom-control-label custom-control-color"></span>
                            </label>
                        </td>
                    </tr>';
        endforeach;

        return response()->json(['success' => true, 'data' => $response], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::where('name',$request->name)->where('status','deleted')->first();
        if(!$role){
            $request->validate([
                'name' => 'required|unique:roles,name',
            ]);
            $role = new Role();
        } else {
            $role->status = "active";
        }

        $role->name = $request->name;
        $role->save();

        return response()->json(['success' => true, 'data' => ''], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $role->id;
        $data["name"] = $role->name;

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $role->id;
        $data["name"] = $role->name;
        $data["destroy"] = route('roles.destroy',$role->id);
        $data["update_role"] = route('roles.update',$role->id);
        $data["role_permissions"] = route('roles.get.permissions',$role->id);
        $data["update_role_permissions"] = route('roles.update.permissions',$role->id);

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        RolePermission::where('role_id',$id)->delete();

        $permissions = $request->permissions;
        if($permissions && is_array($permissions) && sizeof($permissions)>0){
            for($i=0; $i<sizeof($permissions); $i++){
                $rolePermission = new RolePermission();
                $rolePermission->role_id = $id;
                $rolePermission->permission_id = $permissions[$i];
                $rolePermission->created_by = Auth::id();
                $rolePermission->updated_by = Auth::id();
                $rolePermission->save();
            }
        }

        return response()->json(['success' => true, 'data' => ''], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $request->validate([
            'name' => 'required',
        ]);


        if(strtolower($request->name)!=strtolower($role->name)){
            $request->validate([
                'name' => 'required|unique:roles,name',
            ]);
        }


        $role->name = $request->name;
        $role->save();


        return response()->json(['success' => true, 'data' => ''], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json([
                'success' => false,
                'errors' => 'Role not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        if($role){
            $hasRelation = false;
            foreach ($role->relationMethods as $relationMethod) {
                if ($role->$relationMethod()->count() > 0) {
                    if($relationMethod=="users"){
                        foreach($role->$relationMethod as $role_user){
                            if($role_user->user->where('status','active')->count()>1){
                                $hasRelation = true;
                                break;
                            }
                        }
                    } else {
                        $hasRelation = true;
                        break;
                    }
                }
            }

            if(!$hasRelation){
                //$role->delete();
                $role->status = "deleted";
                $role->updated_by = Auth::id();
                $role->save();
                session()->flash('success', 'Role is deleted.');
                return response()->json(['success' => true, 'data' => []], 200);
            } else {
                session()->flash('error', 'Role cannot be deleted');
            }
        }

        return response()->json(['error' => true, 'data' => 'Role is associated with a user'], 200);
    }
}
