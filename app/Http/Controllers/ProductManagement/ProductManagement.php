<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\CatalogueManagement\CatStockUnit;
use App\Models\ProductManagement as ModelsProductManagement;
use App\Models\ProductStock;
use App\Models\StockManagement\Stock;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */

    //  public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         $routes_permissions = [
    //             "stock.index" => ['create-stock', 'view-stock', 'update-stock', 'delete-stock'],
    //             "stock.get" => ['create-stock', 'view-stock', 'update-stock', 'delete-stock'],
    //             "stock.create" => ['create-stock'],
    //             "stock.store" => ['create-stock'],
    //             "stock.show" => ['view-stock'],
    //             "stock.edit" => ['update-stock'],
    //             "stock.update" => ['update-stock'],
    //             "stock.destroy" => ['delete-stock'],
    //         ];
    //         if($request->user()->canany($routes_permissions[Route::currentRouteName()])){
    //             return $next($request);
    //         }
    //         abort(403);
    //     });
    // }
    public function index($id = null)
    {
        $stock_units = Stock::join('cat_stock_unit', 'cat_stock_unit.id', '=', 'stock.unit_id')
            ->select('cat_stock_unit.name as unit_name', 'stock.unit_id', 'stock.name', 'stock.quantity', 'stock.image', 'stock.stock_status', 'stock.created_by', 'stock.updated_by', 'stock.created_at', 'stock.updated_at', 'stock.id')
            ->get();

        $product_id = ModelsProductManagement::find($id);


        return view('product_management.index', compact('stock_units', 'product_id'));
    }

    public function get(Request $request)
    {
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
        $totalRecords = ModelsProductManagement::select('count(*) as allcount')
            ->where('product_status', '!=', 'deleted')
            ->count();
        $totalRecordswithFilter = ModelsProductManagement::select('count(*) as allcount')
            ->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            })
            ->where('product_status', '!=', 'deleted')
            ->count();

        if ($rowperpage == -1) {
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = ModelsProductManagement::orderBy($columnName, $columnSortOrder)
            ->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            })
            ->where('product_status', '!=', 'deleted')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            // dd($record->stock);
            $checked = "";
            if (in_array($record->id, $selected_rows)) {
                $checked = 'checked=""';
            }
            $checkbox = '<label class="custom-control custom-control-sm custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="' . $record->id . '" ' . $checked . '>
                            <span class="custom-control-label"></span>
                        </label>';

            $id = $record->id;
            $name = $record->name;
            // dd($name);



            $data_view_route = route("product.show", $record->id);
            $data_edit_route = route("product.edit", $record->id);
            $data_update_route = route("product.update", $record->id);

            // if($request->user()->canany(['view-stock','update-stock'])) {
            // if($request->user()->can('update-stock')){
            $id = '<a href="javascript:void(0)" class="edit-stock" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '">' . $record->id . '</a>';
            $name = '<a href="javascript:void(0)" class="edit-stock" style="vertical-align: sub;" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '">' . $name . '</a>';
            // } else if($request->user()->can('view-stock')) {
            $id = '<a href="javascript:void(0)" class="view-stock" data-view-route="' . $data_view_route . '">' . $record->id . '</a>';
            $name = '<a href="javascript:void(0)" class="view-stock" style="vertical-align: sub;" data-view-route="' . $data_view_route . '">' . $name . '</a>';
            // }
            // }

            $action = '<div class="btn-group">';
            // if($request->user()->can('view-stock')) {
            $action .= '<button class="btn btn-space btn-info btn-sm view-stock" data-view-route="' . $data_view_route . '">
                            <i class="icon mdi mdi-eye"></i>
                        </button>';
            // }
            // if($request->user()->can('update-stock')) {
            $action .= '<button class="btn btn-space btn-primary btn-sm edit-stock" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '">
                            <i class="icon mdi mdi-edit"></i>
                        </button>';
            // }
            // if($request->user()->can('delete-stock')) {
            $data_delete_route = route("product.destroy", $record->id);
            $action .= '<button class="btn btn-space btn-danger btn-sm delete" onclick="removeProduct(' . $record->id . ' )" data-toggle="modal" data-target="#confirmation-dialog" >
                                <i class="icon mdi mdi-delete"></i>
                            </button>';
            // }
            $action .= '</div>';

            if ($record->image) {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="' . (asset('storage/images/product/' . $record->image)) . '" alt="' . $record->name . '">' . $name;
            } else {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="' . (asset('pos/assets/img/logo-fav.png')) . '" alt="' . $record->name . '">' . $name;
            }

            $price = $record->price;
            // $quantity = $record->quantity;

            $data_arr[] = array(
                "checkbox" => $checkbox,
                "id" => $id,
                "name" => $name,
                "price" => $price,
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


    public  function add_more_ingredients($count = null)
    {
        // $stocks=Stock::all();
        // $units=CatStockUnit::all();

        $stock_units = Stock::join('cat_stock_unit', 'cat_stock_unit.id', '=', 'stock.unit_id')
            ->select('cat_stock_unit.name as unit_name', 'stock.unit_id', 'stock.name', 'stock.quantity', 'stock.image', 'stock.stock_status', 'stock.created_by', 'stock.updated_by', 'stock.created_at', 'stock.updated_at', 'stock.id')
            ->get();
        // dd($stocks);

        return view('product_management.add_more_ingredients', compact('count', 'stock_units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    dd($request->all());
        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            //    'unit_id' => 'required|exists:App\Models\CatalogueManagement\CatStockUnit,id',
            'stock_quantity' => 'required',
            'image' => $image_rule,
        ]);

        // $image = "";
        // if ($request->file('image')) {
        //     $fileArray = ['image' => $request->file('image')];
        //     $rules = [
        //         'image' => $image_rule
        //     ];

        //     $validator = Validator::make($fileArray, $rules);

        //     if (!$validator->fails()) {
        //         $fileExtension = $request->file('image')->extension();
        //         $fileName = rand() . date('dmYHis') . "." . $fileExtension;
        //         $image = "product/" . $fileName;
        //         $request->file('image')->storeAs('product', $fileName, 'public');
        //     }


        // }

        $product = new ModelsProductManagement();
        $product->name = $request->name;
        $product->price = $request->price;
        if ($request->image) {
            $imageName = "product_" . time() . '_.' . $request->image->extension();
            $request->image->storeAs('public/images/product', $imageName);
            $product->image = $imageName;
        }
        $product->product_status = "created";
        $product->save();
        $stocks = $request->input('stock');
        $quantity = $request->input('stock_quantity');


        foreach ($stocks as $key => $stock) {
            ProductStock::create([
                'product_management_id' => $product->id,
                'stock_id' => $stock,
                'quantity' => $quantity[$key],
            ]);
        }

        return response()->json(['success' => true, 'data' => ''], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ModelsProductManagement::find($id);
        return view('product_management.show_ingredients', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock_units = Stock::join('cat_stock_unit', 'cat_stock_unit.id', '=', 'stock.unit_id')
            ->select('cat_stock_unit.name as unit_name', 'stock.unit_id', 'stock.name', 'stock.quantity', 'stock.image', 'stock.stock_status', 'stock.created_by', 'stock.updated_by', 'stock.created_at', 'stock.updated_at', 'stock.id')
            ->get();
        $product = ModelsProductManagement::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'errors' => 'product not found.'

            ], 400); // 400 being the HTTP code for an invalid request.
        }
        $data = [];
        $data["id"] = $product->id;
        $data["name"] = $product->name;
        $data["destroy"] = route('product.destroy', $product->id);
        $data["update_product"] = route('product.update', $product->id);
        $html = view('product_management.edit_product', compact('product', 'stock_units'))->render();
        return [$html, $data];
    }

    public function delete_ingredient($id)
    {

        $ingredient = ProductStock::find($id);
        $ingredient->delete();
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
        // dd($request->all());
        $product =  ModelsProductManagement::find($request->id);


        $image_rule = 'nullable|mimes:jpeg,png,jpg|max:1024'; // max 1024kb
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => $image_rule,
        ]);

        $image = "";
        if ($request->file('image')) {
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
            // if (!$validator->fails()) {
            //     $fileExtension = $request->file('image')->extension();
            //     $fileName = rand() . date('dmYHis') . "." . $fileExtension;
            //     $image = "public/images/product/" . $fileName;
            //     $request->file('image')->storeAs('public/images/product', $fileName, 'public');
            // }
            if ($request->image) {
                $image = "product_" . time() . '_.' . $request->image->extension();
                $request->image->storeAs('public/images/product', $image);
                $product->image = $image;
            }
        }


        if ($image == "" && $request->old_image == "") {
            $this->deleteFile($product->image);
            $product->image = "";
        }

        $product->name = $request->name;
        $product->price = $request->price;
        if ($image == "" && $request->old_image == "") {
            $this->deleteFile($product->image);
            $product->image = "";
        }
        $product->product_status = "updated";
        $product->save();
        $stocks = $request->input('stock');
        $quantity = $request->input('stock_quantity');

        if (!empty($stocks) && !empty($quantity)) {

            foreach ($stocks as $key => $stock) {
                if (!empty($stock) && !empty($quantity[$key])) {
                ProductStock::create([
                    'product_management_id' => $product->id,
                    'stock_id' => $stock,
                    'quantity' => $quantity[$key],
                ]);
            }
            }

        }


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
        $product = ModelsProductManagement::find($id);
        $product->stock()->detach();
        $product->delete();
        return 'Product Deleted Successfully';
    }

    public function deleteFile($file)
    {
        $path = public_path('storage/product/' . $file);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
