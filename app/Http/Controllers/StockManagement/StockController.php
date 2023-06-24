<?php

namespace App\Http\Controllers\StockManagement;

use App\Http\Controllers\Controller;
use App\Models\CatalogueManagement\CatStockUnit;
use App\Models\StockManagement\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use File;
use Validator;

class StockController extends Controller
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
                "stock.index" => ['create-stock', 'view-stock', 'update-stock', 'delete-stock'],
                "stock.get" => ['create-stock', 'view-stock', 'update-stock', 'delete-stock'],
                "stock.create" => ['create-stock'],
                "stock.store" => ['create-stock'],
                "stock.show" => ['view-stock'],
                "stock.edit" => ['update-stock'],
                "stock.update" => ['update-stock'],
                "stock.destroy" => ['delete-stock'],
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
        $cat_stock_unit = CatStockUnit::all();
        return view('stock_management.index')->with(compact('cat_stock_unit'));
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
        $totalRecords = Stock::select('count(*) as allcount')
                            ->where('stock_status','!=','deleted')
                            ->count();
        $totalRecordswithFilter = Stock::select('count(*) as allcount')
                                        ->where(function($q) use($searchValue) {
                                            $q->where('name', 'like', '%' .$searchValue . '%');
                                        })
                                        ->where('stock_status','!=','deleted')
                                        ->count();
        if($rowperpage==-1){
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = Stock::orderBy($columnName,$columnSortOrder)
                        ->where(function($q) use($searchValue) {
                            $q->where('name', 'like', '%' .$searchValue . '%');
                        })
                        ->where('stock_status','!=','deleted')
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

            $data_view_route = route("stock.show",$record->id);
            $data_edit_route = route("stock.edit",$record->id);
            $data_update_route = route("stock.update",$record->id);

            if($request->user()->canany(['view-stock','update-stock'])) {
                if($request->user()->can('update-stock')){
                    $id = '<a href="javascript:void(0)" class="edit-stock" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="edit-stock" style="vertical-align: sub;" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">'.$name.'</a>';
                } else if($request->user()->can('view-stock')) {
                    $id = '<a href="javascript:void(0)" class="view-stock" data-view-route="'.$data_view_route.'">'.$record->id.'</a>';
                    $name = '<a href="javascript:void(0)" class="view-stock" style="vertical-align: sub;" data-view-route="'.$data_view_route.'">'.$name.'</a>';
                }
            }

            $action = '<div class="btn-group">';
            if($request->user()->can('view-stock')) {
                $action .= '<button class="btn btn-space btn-info btn-sm view-stock" data-view-route="'.$data_view_route.'">
                            <i class="icon mdi mdi-eye"></i>
                        </button>';
            }
            if($request->user()->can('update-stock')) {
                $action .= '<button class="btn btn-space btn-primary btn-sm edit-stock" data-edit-route="'.$data_edit_route.'" data-edit-route="'.$data_update_route.'">
                            <i class="icon mdi mdi-edit"></i>
                        </button>';
            }
            if($request->user()->can('delete-stock')) {
                $data_delete_route = route("stock.destroy",$record->id);
                $action .= '<button class="btn btn-space btn-danger btn-sm delete" data-delete-route="'.$data_delete_route.'" >
                                <i class="icon mdi mdi-delete"></i>
                            </button>';
            }
            $action .= '</div>';

            if($record->image){
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="'.(asset('storage/'.$record->image)).'" alt="'.$record->name.'">'.$name;
            } else {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="'.(asset('wulo/assets/img/avatar6.png')).'" alt="'.$record->name.'">'.$name;
            }

            $unit = $record->unit ? $record->unit->name : "";
            $quantity = $record->quantity;

            $data_arr[] = array(
                "checkbox" => $checkbox,
                "id" => $id,
                "name" => $name,
                "unit" => $unit,
                "quantity" => $quantity,
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
        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            'unit_id' => 'required|exists:App\Models\CatalogueManagement\CatStockUnit,id',
            'quantity' => 'required',
            'image' => $image_rule,
        ]);

        $image = "";
        if($request->file('image')) {
            // https://stackoverflow.com/questions/31893439/image-validation-in-laravel-5-intervention
            // https://hdtuto.com/article/laravel-57-image-upload-with-validation-example
            // Build the input for validation
            $fileArray = ['image' => $request->file('image')];

            // Tell the validator that this file should be an image
            $rules = [
                'image' => $image_rule
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            // Check to see if validation fails or passes
            if (!$validator->fails()){
                $fileExtension = $request->file('image')->extension();
                $fileName = rand() . date('dmYHis') . "." . $fileExtension;
                $image = "stock/".$fileName;
                $request->file('image')->storeAs('stock', $fileName, 'public');
            }
        }

        $stock = new Stock();
        $stock->name = $request->name;
        $stock->unit_id = $request->unit_id;
        $stock->quantity = $request->quantity;

        if($image != ""){
            $stock->image = $image;
        }

        $stock->stock_status = "created";
        $stock->save();

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
        $stock = Stock::find($id);
        if(!$stock){
            return response()->json([
                'success' => false,
                'errors' => 'Stock not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $stock->id;
        $data["name"] = $stock->name;
        $data["unit_id"] = $stock->unit_id;
        $data["quantity"] = $stock->quantity;
        $data["image"] = $stock->image ?: "";

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
        $stock = Stock::find($id);
        if(!$stock){
            return response()->json([
                'success' => false,
                'errors' => 'Stock not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $data = [];
        $data["id"] = $stock->id;
        $data["name"] = $stock->name;
        $data["unit_id"] = $stock->unit_id;
        $data["quantity"] = $stock->quantity;
        $data["image"] = $stock->image ?: "";
        $data["destroy"] = route('stock.destroy',$stock->id);
        $data["update_stock"] = route('stock.update',$stock->id);

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
        $stock = Stock::find($id);
        if(!$stock){
            return response()->json([
                'success' => false,
                'errors' => 'Stock not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            'unit_id' => 'required|exists:App\Models\CatalogueManagement\CatStockUnit,id',
            'quantity' => 'required',
            'image' => $image_rule,
        ]);

        $image = "";
        if($request->file('image')) {
            // https://stackoverflow.com/questions/31893439/image-validation-in-laravel-5-intervention
            // https://hdtuto.com/article/laravel-57-image-upload-with-validation-example
            // Build the input for validation
            $fileArray = ['image' => $request->file('image')];

            // Tell the validator that this file should be an image
            $rules = [
                'image' => $image_rule
            ];

            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            // Check to see if validation fails or passes
            if (!$validator->fails()){
                $fileExtension = $request->file('image')->extension();
                $fileName = rand() . date('dmYHis') . "." . $fileExtension;
                $image = "stock/".$fileName;
                $request->file('image')->storeAs('stock', $fileName, 'public');
            }
        }

        if($image == "" && $request->old_image == ""){
            $this->deleteFile($stock->image);
            $stock->image = "";
        }


        $stock->name = $request->name;
        $stock->unit_id = $request->unit_id;
        $stock->quantity = $request->quantity;

        if($image != ""){
            $stock->image = $image;
        }

        $stock->stock_status = "updated";
        $stock->save();


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
        $stock = Stock::find($id);
        if(!$stock){
            return response()->json([
                'success' => false,
                'errors' => 'Stock not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        if($stock){
            $hasRelation = false;
            foreach ($stock->relationMethods as $relationMethod) {
                if ($stock->$relationMethod()->count() > 0) {
                    $hasRelation = true;
                    break;
                }
            }

            if(!$hasRelation){
                $stock->stock_status = "deleted";
                $stock->save();
                session()->flash('success', 'Stock is deleted.');
                return response()->json(['success' => true, 'data' => []], 200);
            } else {
                session()->flash('error', 'Stock cannot be deleted');
            }
        }

        return response()->json(['error' => true, 'data' => []], 200);
    }

    public function deleteFile($file){
        $path = public_path('storage/'.$file);
        if(File::exists($path)) {
            File::delete($path);
        }
    }
}
