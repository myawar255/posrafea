@extends('layouts.app')

@section('page_title', __('Product Management'))

@section('page_level_styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('pos/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('pos/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pos/assets/lib/datatables/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/jquery.gritter/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/select2/css/select2.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .plus_ingredient {
            font-size: 20px;
            font-weight: bolder;
        }

        .unit_name {
            vertical-align: sub !important;
            font-size: smaller !important;
        }

        .select2-container--default .select2-selection--single {
            height: 40px !important;
        }
    </style>
@endsection

@section('page_head')
    <div class="page-head">
        <h2 class="page-head-title">Add New Bill</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item active">Billing/Add Bill</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container">

        <form method="POST" action="{{ route('billing.store') }}">
            @csrf
            <div class="row">

                <div class="row w-100 mt-3">

                    <div class="col-12">
                        <i class="icon icon-left mdi mdi-plus plus plus_ingredient float-right"
                            onclick="add_more_products()"></i>
                    </div>
                </div>
                {{-- @dd($stock_units) --}}
                <div class="col-md-4  mt-3">
                    <div class="form-group">
                        <label>Select Product </label>
                        <select id="single" class="form-control product" name="product_id[]" style="height: 40px">
                            <option></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}-0">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label>price</label>
                        <input class="form-control form-control-xs price_0" type="number" name="price[]" id="product_price"
                            placeholder="Enter price" disabled style="height: 40px">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control form-control-xs " onkeyup="QuantityKeyUp()" type="number" name="product_quantity[]"
                            placeholder="Enter quantity" style="height: 40px">
                    </div>
                </div>
                <div class="add_products"></div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label>Grand Total</label>
                        <input class="form-control form-control-xs totalQTY" type="number" name="total"
                            style="height: 40px">
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button class="btn btn-primary store-stock" type="submit">Save</button>
            </div>
        </form>
    </div>

    {{-- @dd($stock_units) --}}
@endsection

@section('page_level_scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net/js/jquery.dataTables.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"
        type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/dataTables.buttons.min.js') }}"
        type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.flash.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/jszip/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/pdfmake/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/pdfmake/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.colVis.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.print.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.html5.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-responsive/js/dataTables.responsive.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"
        type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/app-table-filters.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/js/app-ui-notifications.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        $(".product").select2({
            placeholder: "Select Your Product",
            allowClear: true
        });

        $(document).on('change', '.product', function() {
            // $('.product').change(function() {
            const rawselectedProductId = $(this).val();
            console.log('rawselectedProductId: ', rawselectedProductId);
            var splitString = rawselectedProductId.split('-');

            // Retrieve the name and value from the splitString array
            var selectedProductId = splitString[0];
            var counter = splitString[1];
            const priceInput = $(`.price_${counter}`);
            const productData = {!! json_encode($products) !!};

            const selectedProduct = productData.find(product => product.id == selectedProductId);
            console.log('selectedProduct: ', selectedProduct);
            if (selectedProduct) {
                priceInput.val(selectedProduct.price);
            } else {
                priceInput.val('');
            }
            calculatePrice()
        });

        function QuantityKeyUp() {
            console.log("aawdwad");
            calculatePrice()
        }

        var count = 1;
        function add_more_products() {
            count++;
            var url = '{{ route('add_more_products', ':count') }}';
            url = url.replace(':count', count);

            $.ajax({
                type: 'GET',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                    $('.add_products').append(data)
                    $(".product").select2()
                },
            });
        }


        function removeProductField(count) {
            console.log('count: ', count);
            $('.product_' + count).remove();
            calculatePrice()
        }

        function calculatePrice() {
            var price = $('[name="price\\[\\]"]');
            var qty = $('[name="product_quantity\\[\\]"]');
            var totalPrice = 0;

            price.each(function(index) {
                var priceValue = parseFloat($(this).val());
                var qtyValue = parseFloat(qty.eq(index).val());

                if (!isNaN(priceValue) && !isNaN(qtyValue)) {
                    totalPrice += priceValue * qtyValue;
                }
            });

            console.log('Total Price: ', totalPrice);
            $('.totalQTY').val(totalPrice)
        }
    </script>



@endsection
