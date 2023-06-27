<?php

namespace App\Http\Controllers\BillingManagement;

use App\Http\Controllers\Controller;
use App\Models\BillingManagment\BillingManagment;
use App\Models\ProductBilling\ProductBilling;
use App\Models\ProductManagement;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class BillingManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('billing_management.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = ProductManagement::all();
        return view('billing_management.add_invoice', compact('products'));
    }

    public  function add_more_products($count = null)
    {
        $products = ProductManagement::all();

        return view('billing_management.add_more_products', compact('count', 'products'));
    }

    public  function get_billing(Request $request)
    {
// dd("here");
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
        $totalRecords = BillingManagment::select('count(*) as allcount')
            ->count();
        $totalRecordswithFilter = BillingManagment::select('count(*) as allcount')
            ->where(function ($q) use ($searchValue) {
                $q->where('id', 'like', '%' . $searchValue . '%');
            })
            ->count();
        if ($rowperpage == -1) {
            $rowperpage = $totalRecordswithFilter;
        }

        // Fetch records
        $records = BillingManagment::orderBy($columnName, $columnSortOrder)
            ->where(function ($q) use ($searchValue) {
                $q->where('id', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = "";
            if (in_array($record->id, $selected_rows)) {
                $checked = 'checked=""';
            }
            $checkbox = '<label class="custom-control custom-control-sm custom-checkbox">
                             <input class="custom-control-input" type="checkbox" value="' . $record->id . '" ' . $checked . '>
                             <span class="custom-control-label"></span>
                         </label>';

            $id = $record->id;

            $data_view_route = route("stock.show", $record->id);
            $data_edit_route = route("stock.edit", $record->id);
            $data_update_route = route("stock.update", $record->id);

            if ($request->user()->canany(['view-stock', 'update-stock'])) {
                if ($request->user()->can('update-stock')) {
                    $id = '<a href="javascript:void(0)" class="edit-stock" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '">' . $record->id . '</a>';
                    $name = '<a href="javascript:void(0)" class="edit-stock" style="vertical-align: sub;" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '"></a>';
                } else if ($request->user()->can('view-stock')) {
                    $id = '<a href="javascript:void(0)" class="view-stock" data-view-route="' . $data_view_route . '">' . $record->id . '</a>';
                    $name = '<a href="javascript:void(0)" class="view-stock" style="vertical-align: sub;" data-view-route="' . $data_view_route . '"></a>';
                }
            }

            $action = '<div class="btn-group">';
            if ($request->user()->can('view-stock')) {
                $action .= '<button class="btn btn-space btn-info btn-sm view-stock" data-view-route="' . $data_view_route . '">
                             <i class="icon mdi mdi-eye"></i>
                         </button>';
            }
            if ($request->user()->can('update-stock')) {
                $action .= '<button class="btn btn-space btn-primary btn-sm edit-stock" data-edit-route="' . $data_edit_route . '" data-edit-route="' . $data_update_route . '">
                             <i class="icon mdi mdi-edit"></i>
                         </button>';
            }
            if ($request->user()->can('delete-stock')) {
                $data_delete_route = route("stock.destroy", $record->id);
                $action .= '<button class="btn btn-space btn-danger btn-sm delete" data-delete-route="' . $data_delete_route . '" >
                                 <i class="icon mdi mdi-delete"></i>
                             </button>';
            }
            $action .= '</div>';

            if ($record->image) {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="' . (asset('storage/' . $record->image)) . '" alt="' . $record->name . '">' . $name;
            } else {
                $name = '<img class="mt-0 mt-md-2 mt-lg-0" src="' . (asset('wulo/assets/img/avatar6.png')) . '" alt="' . $record->name . '">' . $name;
            }


            $price = $record->total;

            $data_arr[] = array(
                "checkbox" => $checkbox,
                "id" => $id,
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $bill = new BillingManagment();
        $bill->total = $request->total;
        $bill->save();

        foreach ($request->product_id as $key => $product_raw) {
            $product = explode('-', $product_raw);
            $billing_product = new ProductBilling();
            $billing_product->product_management_id = $product[0];
            $billing_product->billing_management_id = $bill->id;
            $billing_product->quantity = $request->product_quantity[$key];
            $billing_product->save();
        }

        return redirect()->route('billing.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
