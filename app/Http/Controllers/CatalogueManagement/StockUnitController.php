<?php

namespace App\Http\Controllers\CatalogueManagement;

use App\Http\Controllers\Controller;
use App\Models\CatalogueManagement\CatStockUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StockUnitController extends Controller
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
                "stock_unit.index" => ['create-stock-unit', 'view-stock-unit', 'update-stock-unit', 'delete-stock-unit'],
                "stock_unit.get" => ['create-stock-unit', 'view-stock-unit', 'update-stock-unit', 'delete-stock-unit'],
                "stock_unit.get.permissions" => ['create-stock-unit', 'view-stock-unit', 'update-stock-unit', 'delete-stock-unit'],
                "stock_unit.create" => ['create-stock-unit'],
                "stock_unit.store" => ['create-stock-unit'],
                "stock_unit.show" => ['view-stock-unit'],
                "stock_unit.edit" => ['update-stock-unit'],
                "stock_unit.update" => ['update-stock-unit'],
                "stock_unit.destroy" => ['delete-stock-unit'],
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
        return view('catalogue_management.stock_unit.index');
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
        $totalRecords = CatStockUnit::select('count(*) as allcount')->count();

        $totalRecordswithFilter = CatStockUnit::select('count(*) as allcount')
                                        ->where(function($q) use($searchValue) {
                                            $q->where('name', 'like', '%' .$searchValue . '%');
                                        })
                                        ->count();
        if($rowperpage==-1){
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = CatStockUnit::orderBy($columnName,$columnSortOrder)
                        ->where(function($q) use($searchValue) {
                            $q->where('name', 'like', '%' .$searchValue . '%');
                        })
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

            $data_view_route = route("stock_unit.show",$record->id);
            $data_edit_route = route("stock_unit.edit",$record->id);
            $data_update_route = route("stock_unit.update",$record->id);

            if($request->user()->canany(['view-stock-unit','update-stock-unit'])) {
                if($request->user()->can('update-stock-unit')){
                    $id = '<a href="javascript:void(0)" class="edit-stock-unit" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="edit-stock-unit" style="vertical-align: sub;" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$name.'</a>';
                } else if($request->user()->can('view-stock-unit')) {
                    $id = '<a href="javascript:void(0)" class="view-stock-unit" data-view-route="'.$data_view_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="view-stock-unit" style="vertical-align: sub;" data-view-route="'.$data_view_route.'">'.$name.'</a>';
                }
            }

            $action = '<div class="btn-group">';
            if($request->user()->can('view-stock-unit')) {
                $action .= '<button class="btn btn-space btn-info btn-sm view-stock-unit" data-view-route="'.$data_view_route.'">
                            <i class="icon mdi mdi-eye"></i>
                        </button>';
            }
            if($request->user()->can('update-stock-unit')) {
                $action .= '<button class="btn btn-space btn-primary btn-sm edit-stock-unit" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">
                            <i class="icon mdi mdi-edit"></i>
                        </button>';
            }
            if($request->user()->can('delete-stock-unit')) {
                $data_delete_route = route("stock_unit.destroy",$record->id);
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
            'name' => 'required|unique:App\Models\CatalogueManagement\CatStockUnit,name',
        ]);

        $stock_unit = new CatStockUnit();
        $stock_unit->name = $request->name;
        $stock_unit->save();

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
        $stock_unit = CatStockUnit::find($id);
        if(!$stock_unit){
            return response()->json([
                'success' => false,
                'errors' => 'Stock unit not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $stock_unit->id;
        $data["name"] = $stock_unit->name;

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
        $stock_unit = CatStockUnit::find($id);
        if(!$stock_unit){
            return response()->json([
                'success' => false,
                'errors' => 'Stock unit not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $stock_unit->id;
        $data["name"] = $stock_unit->name;
        $data["destroy"] = route('stock_unit.destroy',$stock_unit->id);
        $data["update_stock_unit"] = route('stock_unit.update',$stock_unit->id);

        return response()->json(['success' => true, 'data' => $data], 200);
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
        $stock_unit = CatStockUnit::find($id);
        if(!$stock_unit){
            return response()->json([
                'success' => false,
                'errors' => 'Stock unit not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $request->validate([
            'name' => 'required',
        ]);


        if(strtolower($request->name)!=strtolower($stock_unit->name)){
            $request->validate([
                'name' => 'required|unique:App\Models\CatalogueManagement\CatStockUnit,name',
            ]);
        }


        $stock_unit->name = $request->name;
        $stock_unit->save();


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
        $stock_unit = CatStockUnit::find($id);
        if(!$stock_unit){
            return response()->json([
                'success' => false,
                'errors' => 'Stock unit not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        if($stock_unit){
            $hasRelation = false;
            foreach ($stock_unit->relationMethods as $relationMethod) {
                if ($stock_unit->$relationMethod()->count() > 0) {
                    $hasRelation = true;
                    break;
                }
            }

            if(!$hasRelation){
                $stock_unit->delete();
                session()->flash('success', 'Stock unit is deleted.');
                return response()->json(['success' => true, 'data' => []], 200);
            } else {
                session()->flash('error', 'Stock unit cannot be deleted');
            }
        }

        return response()->json(['error' => true, 'data' => []], 200);
    }
}
