<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\UserManagement\Role;
use App\Models\UserManagement\Permission;
use App\Models\UserManagement\UserRole;
use App\Models\UserManagement\UserPermission;
use Illuminate\Support\Facades\Auth;
use File;
use Validator;

class UserController extends Controller
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
                "users.index" => ['create-user', 'view-user', 'update-user', 'delete-user'],
                "users.get" => ['create-user', 'view-user', 'update-user', 'delete-user'],
                "users.get.roles" => ['create-user', 'view-user', 'update-user', 'delete-user'],
                "users.get.permissions" => ['create-user', 'view-user', 'update-user', 'delete-user'],
                "users.create" => ['create-user'],
                "users.store" => ['create-user'],
                "users.show" => ['view-user'],
                "users.edit" => ['update-user'],
                "users.update" => ['update-user'],
                "users.update.roles" => ['update-user'],
                "users.update.permissions" => ['update-user'],
                "users.destroy" => ['delete-user'],
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
        return view('user_management.users.index');
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
        $totalRecords = User::select('count(*) as allcount')
                            ->where("status","active")
                            ->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
                                        ->where("status","active")
                                        ->where(function($q) use($searchValue) {
                                            $q->where('name', 'like', '%' .$searchValue . '%')
                                            ->orWhere('email', 'like', '%' .$searchValue . '%')
                                            ->orWhere('national_id_card_number', 'like', '%' .$searchValue . '%');
                                        })
                                        ->count();
        if($rowperpage==-1){
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = User::orderBy($columnName,$columnSortOrder)
                        ->where(function($q) use($searchValue) {
                            $q->where('name', 'like', '%' .$searchValue . '%')
                            ->orWhere('email', 'like', '%' .$searchValue . '%')
                            ->orWhere('national_id_card_number', 'like', '%' .$searchValue . '%');
                        })
                        ->select('users.*')
                        ->where("status","active")
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

            $is_super_admin_or_self = false;
            $user_roles = $record->userRoles->pluck('role.name')->toArray();

            if($request->user()->id == $record->id || in_array("Super Admin", $user_roles)){
                $is_super_admin_or_self = true;
            }

            $data_view_route = route("users.show",$record->id);
            $data_edit_route = route("users.edit",$record->id);
            $data_update_route = route("users.update",$record->id);

            if($request->user()->canany(['view-user','update-user'])) {
                if($request->user()->can('update-user') && !$is_super_admin_or_self){
                    $id = '<a href="javascript:void(0)" class="edit-user" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="edit-user" style="vertical-align: sub;" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->name.'</a>';
                } else if($is_super_admin_or_self && $request->user()->can('view-user')) {
                    $id = '<a href="javascript:void(0)" class="view-user" data-view-route="'.$data_view_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="view-user" style="vertical-align: sub;" data-view-route="'.$data_view_route.'">'.$record->name.'</a>';
                }
            }

            $nic = $record->national_id_card_number;
            $email = $record->email;
            $userRoles = implode(",", $record->userRoles->pluck('role.name')->toArray());
            $checked = "";
            if($record->is_active==1){
                $checked = 'checked=""';
            }
            $is_active = '<label class="checkbox">
                            <input type="checkbox" value="" '.$checked.' disabled="">
                        </label>';

            $action = '<div class="btn-group">';
            if($request->user()->can('view-user')) {
                $action .= '<button class="btn btn-space btn-info btn-sm view-user" data-view-route="'.$data_view_route.'">
                            <i class="icon mdi mdi-eye"></i>
                        </button>';
            }
            if($request->user()->can('update-user') && !$is_super_admin_or_self) {
                $action .= '<button class="btn btn-space btn-primary btn-sm edit-user" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">
                            <i class="icon mdi mdi-edit"></i>
                        </button>';
            }
            if($request->user()->can('delete-user') && !$is_super_admin_or_self) {
                $data_delete_route = route("users.destroy",$record->id);
                $action .= '<button class="btn btn-space btn-danger btn-sm delete" data-delete-route="'.$data_delete_route.'">
                                <i class="icon mdi mdi-delete"></i>
                            </button>';
                /*$action .= '<form class="delete" action="'.route("users.destroy",$record->id).'" method="POST" style="display: none;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>';*/
            }
            $action .= '</div>';

            if($record->profile_picture){
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="'.(asset('storage/'.$record->profile_picture)).'" alt="'.$record->name.'">'.$name;
            } else {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="'.(asset('pos/assets/img/avatar6.png')).'" alt="'.$record->name.'">'.$name;
            }

            $data_arr[] = array(
                "checkbox" => $checkbox,
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "nic" => $nic,
                "roles" => $userRoles,
                "is_active" => $is_active,
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
    public function getRoles(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $userRoles = $user->userRoles->pluck('role.id')->toArray();

        $response = "";
        $roles = Role::where('name','!=','Super Admin')->get();
        foreach($roles as $role):
            $checked = '';
            if(in_array($role->id,$userRoles)){
                $checked = 'checked=""';
            }
            $response .= '<tr>
                            <td>'.$role->name.'</td>
                            <td class="text-center">
                                <label class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input" type="checkbox" name="roles[]" value="'.$role->id.'" '.$checked.'>
                                    <span class="custom-control-label custom-control-color"></span>
                                </label>
                            </td>
                        </tr>';
        endforeach;

        return response()->json(['success' => true, 'data' => $response], 200);
    }

    /*
    AJAX request
    */
    public function getPermissions(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $userRoles = $user->userRoles->pluck('role.id')->toArray();

        $userGrantedPermissions = $user->userPermissions->where('granted',1)->pluck('permission.id')->toArray();
        $userRevokedPermissions = $user->userPermissions->where('granted',0)->pluck('permission.id')->toArray();

        $response = "";
        $permissions = Permission::all();
        foreach($permissions as $permission):
            $permission_roles = $permission->roles->pluck('role.id')->toArray();
            $class = "danger";
            if(sizeof(array_intersect($userRoles,$permission_roles))>0){
                $class = "success";
            }

            $checked = '';
            if(in_array($permission->id,$userGrantedPermissions)){
                $checked = 'checked=""';
            }
            $revoked_checked = '';
            if(in_array($permission->id,$userRevokedPermissions)){
                $revoked_checked = 'checked=""';
            }
            $response .= '<tr class="'.$class.'">
                            <td>'.$permission->name.'</td>
                            <td class="text-center">
                                <label class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input grant-permission" type="checkbox" name="granted[]" value="'.$permission->id.'" '.$checked.'>
                                    <span class="custom-control-label custom-control-color"></span>
                                </label>
                            </td>
                            <td class="text-center">
                                <label class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input revoke-permission" type="checkbox" name="revoked[]" value="'.$permission->id.'" '.$revoked_checked.'>
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
        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'national_id_card_number' => 'required|unique:users,national_id_card_number',
            'profile_picture' => $image_rule,
        ]);

        $profilePicture = "";
        if($request->file('profile_picture')) {
            // https://stackoverflow.com/questions/31893439/image-validation-in-laravel-5-intervention
            // https://hdtuto.com/article/laravel-57-image-upload-with-validation-example
            // Build the input for validation
            $fileArray = ['profile_picture' => $request->file('profile_picture')];

            // Tell the validator that this file should be an image
            $rules = [
                'profile_picture' => $image_rule
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            // Check to see if validation fails or passes
            if (!$validator->fails()){
                $fileExtension = $request->file('profile_picture')->extension();
                $fileName = rand() . date('dmYHis') . "." . $fileExtension;
                $profilePicture = "users/profile/".$fileName;
                $request->file('profile_picture')->storeAs('users/profile', $fileName, 'public');
            }
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->national_id_card_number = $request->national_id_card_number;

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        if($profilePicture != ""){
            $user->profile_picture = $profilePicture;
        }

        $user->is_active = $request->is_active ? 1 : 0;

        $user->created_by = Auth::id();
        $user->updated_by = Auth::id();
        $user->save();


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
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $user->id;
        $data["name"] = $user->name;
        $data["national_id_card_number"] = $user->national_id_card_number;
        $data["email"] = $user->email;
        $data["is_active"] = $user->is_active;
        $data["profile_picture"] = $user->profile_picture ?: "";

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
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $user->id;
        $data["name"] = $user->name;
        $data["national_id_card_number"] = $user->national_id_card_number;
        $data["email"] = $user->email;
        $data["is_active"] = $user->is_active;
        $data["profile_picture"] = $user->profile_picture ?: "";
        $data["destroy"] = route('users.destroy',$user->id);
        $data["update_user"] = route('users.update',$user->id);
        $data["user_roles"] = route('users.get.roles',$user->id);
        $data["update_user_roles"] = route('users.update.roles',$user->id);
        $data["user_permissions"] = route('users.get.permissions',$user->id);
        $data["update_user_permissions"] = route('users.update.permissions',$user->id);

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        UserRole::where('user_id',$id)->delete();

        $roles = $request->roles;
        if($roles && is_array($roles) && sizeof($roles)>0){
            for($i=0; $i<sizeof($roles); $i++){
                $userRole = new UserRole();
                $userRole->user_id = $id;
                $userRole->role_id = $roles[$i];
                $userRole->created_by = Auth::id();
                $userRole->updated_by = Auth::id();
                $userRole->save();
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
    public function updatePermissions(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        UserPermission::where('user_id',$id)->delete();

        $granted = $request->granted;
        if($granted && is_array($granted) && sizeof($granted)>0){
            for($i=0; $i<sizeof($granted); $i++){
                $userPermission = new UserPermission();
                $userPermission->user_id = $id;
                $userPermission->permission_id = $granted[$i];
                $userPermission->granted = 1;
                $userPermission->created_by = Auth::id();
                $userPermission->updated_by = Auth::id();
                $userPermission->save();
            }
        }

        $revoked = $request->revoked;
        if($revoked && is_array($revoked) && sizeof($revoked)>0){
            for($i=0; $i<sizeof($revoked); $i++){
                $userPermission = new UserPermission();
                $userPermission->user_id = $id;
                $userPermission->permission_id = $revoked[$i];
                $userPermission->granted = 0;
                $userPermission->created_by = Auth::id();
                $userPermission->updated_by = Auth::id();
                $userPermission->save();
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
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'national_id_card_number' => 'required',
            'profile_picture' => $image_rule,
        ]);

        if($request->password){
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);
        }

        if(strtolower($request->email)!=strtolower($user->email)){
            $request->validate([
                'email' => 'required|unique:users,email',
            ]);
        }
        if(strtolower($request->national_id_card_number)!=strtolower($user->national_id_card_number)){
            $request->validate([
                'national_id_card_number' => 'required|unique:users,national_id_card_number',
            ]);
        }

        $profilePicture = "";
        if($request->file('profile_picture')) {
            // https://stackoverflow.com/questions/31893439/image-validation-in-laravel-5-intervention
            // https://hdtuto.com/article/laravel-57-image-upload-with-validation-example
            // Build the input for validation
            $fileArray = ['profile_picture' => $request->file('profile_picture')];

            // Tell the validator that this file should be an image
            $rules = [
                'profile_picture' => $image_rule
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            // Check to see if validation fails or passes
            if (!$validator->fails()){
                $fileExtension = $request->file('profile_picture')->extension();
                $fileName = rand() . date('dmYHis') . "." . $fileExtension;
                $profilePicture = "users/profile/".$fileName;
                $request->file('profile_picture')->storeAs('users/profile', $fileName, 'public');
            }
        }

        if($profilePicture == "" && $request->old_profile_picture == ""){
            $this->deleteFile($user->profile_picture);
            $user->profile_picture = "";
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->national_id_card_number = $request->national_id_card_number;

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        if($profilePicture != ""){
            $user->profile_picture = $profilePicture;
        }

        $user->is_active = $request->is_active ? 1 : 0;

        $user->updated_by = Auth::id();

        $user->save();


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
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'success' => false,
                'errors' => 'User not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $userRoles = $user->userRoles->pluck('role.name')->toArray();
        if($user && $user->id!=Auth::id() && !in_array("Super Admin", $userRoles)){
            $hasRelation = false;
            foreach ($user->relationMethods as $relationMethod) {
                if ($user->$relationMethod()->count() > 0) {
                    $hasRelation = true;
                    break;
                }
            }

            if(!$hasRelation){
                $user->status = "deleted";
                $user->updated_by = Auth::id();
                $user->save();
                session()->flash('success', 'User is deleted.');
                return response()->json(['success' => true, 'data' => []], 200);
            } else {
                session()->flash('error', 'User cannot be deleted');
            }
        }

        return response()->json(['error' => true, 'data' => []], 200);
        //return redirect(route('users.index'));
    }

    public function deleteFile($file){
        $path = public_path('storage/'.$file);
        if(File::exists($path)) {
            File::delete($path);
        }
    }
}
