@extends('layouts.app')

@section('page_title', __('Stock Management') )

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('pos/assets/lib/datatables/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/select2/css/select2.min.css') }}"/>
@endsection

@section('page_head')
    <div class="page-head">
        <h2 class="page-head-title">Stock Management</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item active">Stock</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="noSwipe">
                        @can('create-stock')
                        <div class="row m-0">
                            <div class="col-md-12 p-2 text-right">
                                <button class="btn btn-space btn-primary btn-sm" data-toggle="modal" data-target="#add-stock" type="button">
                                    <i class="icon icon-left mdi mdi-plus"></i>Add New
                                </button>
                            </div>
                        </div>
                        @endcan
                        <table class="table table-striped table-hover be-table-responsive" id="stock" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:5%;">
                                        <label class="custom-control custom-control-sm custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th style="width:10%;"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("modals")

    @can('create-stock')
    <!-- START OF ADD NEW STOCK MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="add-stock" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form id="create-stock-validation" action="{{ route('stock.store') }}">
                    @csrf
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Add New Stock</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center input-file">
                            <div class="file-action">
                                <img class="rounded-circle mr-2 mb-2 picture-preview profile-picture" src="{{ asset('pos/assets/img/140x140.png') }}" alt="Placeholder" width="140" height="140">
                                <div class="rounded-circle mr-2 mb-2 file-action-buttons">
                                    <button class="btn btn-space btn-primary btn-xs change-picture" type="button">
                                        <i class="icon mdi mdi-edit"></i>
                                    </button>
                                    <button class="btn btn-space btn-danger btn-xs delete-picture" type="button">
                                        <i class="icon mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="image" style="display: none;">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control form-control-xs" type="text" name="name" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select name="unit_id" class="select2 select2-sm">
                                        <option></option>
                                        @foreach ($cat_stock_unit as $stock_unit)
                                            <option value="{{ $stock_unit->id }}">{{ $stock_unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control form-control-xs" type="number" name="quantity" placeholder="Enter quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary store-stock" type="button">Save</button>
                    </div>
                </form>
                <div class="be-spinner">
                    <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://-www.w3.org/2000/svg">
                        <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF ADD NEW STOCK MODAL -->
    @endcan

    @can('view-stock')
    <!-- START OF VIEW STOCK MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="view-stock" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form>
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">View Stock</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img class="rounded-circle mr-2 mb-2 profile-picture" src="{{ asset('pos/assets/img/140x140.png') }}" alt="Placeholder" width="140" height="140">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control form-control-xs" type="text" name="name" readonly="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select name="unit_id" class="select2 select2-sm" disabled="">
                                        <option></option>
                                        @foreach ($cat_stock_unit as $stock_unit)
                                            <option value="{{ $stock_unit->id }}">{{ $stock_unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control form-control-xs" type="number" name="quantity" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                    </div>
                </form>
                <div class="be-spinner">
                    <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://-www.w3.org/2000/svg">
                        <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF VIEW STOCK MODAL -->
    @endcan

    @can('update-stock')
    <!-- START OF EDIT STOCK MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="edit-stock" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form id="edit-stock-validation">
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Edit Stock</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    @can('delete-stock')
                    <div class="btn-group btn-group-justified btn-space" role="group">
                        <a class="btn btn-danger delete" href="javascript:void(0)">Delete Stock</a>
                    </div>
                    @endcan
                    <div class="modal-body">
                        <div class="text-center input-file">
                            <div class="file-action">
                                <img class="rounded-circle mr-2 mb-2 picture-preview profile-picture" src="{{ asset('pos/assets/img/140x140.png') }}" alt="Placeholder" width="140" height="140">
                                <div class="rounded-circle mr-2 mb-2 file-action-buttons">
                                    <button class="btn btn-space btn-primary btn-xs change-picture" type="button">
                                        <i class="icon mdi mdi-edit"></i>
                                    </button>
                                    <button class="btn btn-space btn-danger btn-xs delete-picture" type="button">
                                        <i class="icon mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="image" style="display: none;">
                            <input type="hidden" name="old_image">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control form-control-xs" type="text" name="name" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select name="unit_id" class="select2 select2-sm">
                                        <option></option>
                                        @foreach ($cat_stock_unit as $stock_unit)
                                            <option value="{{ $stock_unit->id }}">{{ $stock_unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control form-control-xs" type="number" name="quantity" placeholder="Enter quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary update-stock" type="button">Save</button>
                    </div>
                </form>
                <div class="be-spinner">
                    <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://-www.w3.org/2000/svg">
                        <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT STOCK MODAL -->
    @endcan
@endsection

@section('page_level_scripts')
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/jszip/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/pdfmake/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/pdfmake/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.colVis.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('pos/assets/lib/datatables/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/app-table-filters.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/js/app-ui-notifications.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/lib/select2/js/select2.full.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			//-initialize the javascript

            @can('create-stock')
                //Select2
                $("#add-stock .select2").select2({
                    width: '100%',
                    placeholder: 'Select',
                    dropdownParent: $('#add-stock')
                });
            @endcan

            @can('update-stock')
                //Select2
                $("#edit-stock .select2").select2({
                    width: '100%',
                    placeholder: 'Select',
                    dropdownParent: $('#edit-stock')
                });
            @endcan

            @can('view-stock')
                //Select2
                $("#view-stock .select2").select2({
                    width: '100%',
                    placeholder: 'Select',
                    dropdownParent: $('#view-stock')
                });
            @endcan

            var reload_timeout = 1500;
            var selected_rows = [];
            //Table init
            let stock = $('#stock').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "searchDelay": 1000,
                "ajax": {
                    "url": "{{route('stock.get')}}",
                    "method": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data": function (d) {
                        d.selected_rows = selected_rows;
                    }
                },
                "columns": [
                        { "data": 'checkbox' },
                        { "data": 'id' },
                        { "data": 'name' },
                        { "data": 'unit' },
                        { "data": 'quantity' },
                        { "data": 'action' },
                    ],
                "order": [[ 1, "asc" ]],
                "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [0,5]
                    },
                    { "className": "select-checkbox", targets: [0] },
                    { "className": "user-avatar user-info", targets: [2]}
                    //{ "className": "text-center", targets: [6] },
                ],
                "scrollY": 300,
                "scrollX": true,
                "scrollCollapse": true,
                "colReorder": {
                    fixedColumnsLeft: 3,
                    fixedColumnsRight: 1
                },
                "fixedColumns":   {
                    "left": 3,
                    "right": 1
                },

                // https://datatables.net/extensions/buttons/examples/column_visibility/simple.html
                // https://datatables.net/extensions/buttons/examples/column_visibility/layout.html
                // https://datatables.net/forums/discussion/63687/hide-columns-after-reorder
                // https://datatables.net/reference/option/dom
                dom: "<'row be-datatable-header'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                        "<'row be-datatable-body'<'col-sm-12'tr>>" +
                        "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
                // https://datatables.net/extensions/buttons/examples/html5/simple.html
                // https://datatables.net/reference/option/buttons.buttons.attr
                "buttons": [
                    //'excel', 'csv', 'pdf', 'copy'
                    {
                        extend: 'colvis',
                        text: '<span class="mdi mdi-view-column" style="font-size: 25px; vertical-align: middle;"></span>',
                        //titleAttr: 'Column Visibility',
                        attr:  {
                            "data-original-title": 'Column Picker',
                        },
                        className: 'btn btn-primary show-tooltip',
                        columns: ':not(:first-child):not(:nth-child(2)):not(:nth-child(3)):not(:last-child)',
                        collectionLayout: 'fixed columns',
                        collectionTitle: 'Column visibility control',
                        // https://stackoverflow.com/questions/45299188/how-can-i-remove-default-button-class-of-a-datatables-button
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                    //'colvis',
                    {
                        extend: 'excelHtml5',
                        text: '<span class="mdi mdi-file" style="font-size: 25px; vertical-align: middle;"></span> Excel',
                        //titleAttr: 'Export Excel',
                        attr:  {
                            "data-original-title": 'Export to Excel',
                        },
                        className: 'btn btn-success show-tooltip',
                        exportOptions: {
                            columns: ':visible:not(:first-child):not(:last-child)'
                        },
                        filename: "{{ rand().date('YmdHis') }}",
                        title: function(){
                            return prompt('Enter Report Title:');
                        },
                        // https://stackoverflow.com/questions/45299188/how-can-i-remove-default-button-class-of-a-datatables-button
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="mdi mdi-collection-pdf" style="font-size: 25px; vertical-align: middle;"></span> PDF',
                        //titleAttr: 'Export PDF',
                        attr:  {
                            "data-original-title": 'Export to PDF',
                        },
                        className: 'btn btn-danger show-tooltip',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: ':visible:not(:first-child):not(:last-child)'
                        },
                        filename: "{{ rand().date('YmdHis') }}",
                        title: function(){
                            return prompt('Enter Report Title:');
                        },
                        // https://stackoverflow.com/questions/45299188/how-can-i-remove-default-button-class-of-a-datatables-button
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                ]
            }).columns.adjust().draw();

            // https://stackoverflow.com/questions/42570465/datatables-select-all-checkbox
            // https://datatables.net/forums/discussion/62033/how-do-i-check-all-checkboxes
            // http://live.datatables.net/mutavegi/6/edit
            // https://datatables.net/forums/discussion/66027/rows-every-only-for-visible-rows
            // https://datatables.net/forums/discussion/24424/column-header-element-is-not-sized-correctly-when-scrolly-is-set-in-the-table-setup
            $(".dataTable").on("click", "th.select-checkbox", function(e) {
                var column_index = $(this).index();
                if(e.target.tagName == "INPUT"){
                    if ($(this).hasClass("selected")) {
                        var data = stock.rows({filter: 'applied', page: 'current'}).every( function ( idx, data, node ) {
                            var checkbox = $(this.node()).find('td:eq('+column_index+') input[type="checkbox"]');
                            var value = $(checkbox).val();
                            var index = selected_rows.indexOf(value);
                            if(index!=-1){
                                selected_rows.splice(index, 1);
                            }
                            return $(checkbox).prop('checked',false);
                        } )
                        .data()
                        .toArray();

                        $(this).removeClass("selected");
                    } else {
                        // Select All Current Column Checkboxes
                        //$(this).find("input[type=checkbox]").prop('checked', true);
                        var data = stock.rows({filter: 'applied', page: 'current'}).every( function ( idx, data, node ) {
                            var checkbox = $(this.node()).find('td:eq('+column_index+') input[type="checkbox"]');
                            var value = $(checkbox).val();
                            var index = selected_rows.indexOf(value);
                            if(index==-1){
                                selected_rows.push(value);
                            }
                            return $(checkbox).prop('checked',true);
                        } )
                        .data()
                        .toArray();

                        $(this).addClass("selected");
                    }
                }
            });
            stock.on("click", "td.select-checkbox", function(e) {
                if(e.target.tagName == "INPUT"){
                    var checkbox = $(this).find("input[type=checkbox]");
                    var value = $(checkbox).val();
                    var index = selected_rows.indexOf(value);

                    if(!$(checkbox).prop('checked')){
                        $(".dataTable th.select-checkbox").removeClass("selected");
                        if(index!=-1){
                            selected_rows.splice(index, 1);
                        }
                    } else {
                        if(index==-1){
                            selected_rows.push(value);
                        }
                    }
                }
            });

            @can('view-stock')
            /* VIEW STOCK CODE */
            stock.on("click", ".view-stock", function(e) {
                var route = $(this).attr("data-view-route");
                var modal = $("#view-stock");
                var form = $(modal).find("form");

                $.ajax({
                    /* the route pointing to the post function */
                    url: route,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: "",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal("show");
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            var data_keys = Object.keys(data.data);
                            var data_values = Object.values(data.data);
                            $(modal).find("h3.modal-title").html("View Stock (#"+data.data.id+" - "+data.data.name+")");
                            for(i=1; i<data_keys.length; i++){
                                var input = $(form).find("input[name="+data_keys[i]+"]");
                                if(input.length>0 && $(input).attr("type")!="file" &&
                                $(input).attr("type")!="checkbox" &&
                                $(input).attr("name")!="image"){
                                    $(input).val(data_values[i]);
                                }
                                if($(input).attr("type")=="checkbox"){
                                    if(data_values[i]==1){
                                        $(input).prop("checked",true);
                                    } else {
                                        $(input).prop("checked",false);
                                    }
                                }

                                select = $(form).find("select[name="+data_keys[i]+"]");
                                if($(select).length>0){
                                    $(select).val(data_values[i]).trigger("change");
                                }
                                textarea = $(form).find("textarea[name="+data_keys[i]+"]");
                                if(textarea.length>0){
                                    $(textarea).val(data_values[i]);
                                }
                                if(data_keys[i]=="image"){
                                    if(data_values[i]!=""){
                                        $(form).find("img.profile-picture").attr("src","{{ asset('storage') }}/"+data_values[i]);
                                        $(form).find("img.profile-picture").attr("alt",data.data.name);
                                    } else {
                                        $(form).find("img.profile-picture").attr("src","{{ asset('pos/assets/img/140x140.png') }}");
                                        $(form).find("img.profile-picture").attr("alt","Placeholder");
                                    }
                                }
                            }
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if(jqXHR.responseJSON.exception){
                            error_string = "Something went wrong";
                            if(jqXHR.responseJSON.message!=""){
                                error_string = jqXHR.responseJSON.message;
                            }
                            $.gritter.add({
                                title: '',
                                text: error_string,
                                class_name: 'color danger'
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            }, reload_timeout);
                        } else {
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                            var errors = jqXHR.responseJSON.errors;
                            var errors_keys = Object.keys(errors);
                            var error_values = Object.values(errors);
                            var errors_string = "";
                            for(i=0; i<errors_keys.length; i++){
                                errors_string += (i+1) + ". " + error_values[i] + "<br>";
                            }
                            $.gritter.add({
                                title: '',
                                text: errors_string,
                                class_name: 'color danger'
                            });
                        }
                        //$(modal).modal('hide');
                    }
                });
            });
            /* VIEW STOCK CODE */
            @endcan

            @can('update-stock')
            /* EDIT STOCK CODE */
            stock.on("click", ".edit-stock", function(e) {
                var route = $(this).attr("data-edit-route");
                var modal = $("#edit-stock");
                var form = $(modal).find("form");
                $(form).attr("action", $(this).attr("data-update-route"));

                $.ajax({
                    /* the route pointing to the post function */
                    url: route,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: "",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal("show");
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            var data_keys = Object.keys(data.data);
                            var data_values = Object.values(data.data);
                            $(modal).find("h3.modal-title").html("Edit Stock (#"+data.data.id+" - "+data.data.name+")");
                            $(modal).find("form").attr("action",data.data.update_stock);
                            @can('delete-stock')
                                $(modal).find("a.delete").attr("data-delete-route",data.data.destroy);
                            @endcan
                            for(i=1; i<data_keys.length; i++){
                                var input = $(form).find("input[name="+data_keys[i]+"]");
                                if(input.length>0 && $(input).attr("type")!="file" &&
                                $(input).attr("type")!="checkbox" &&
                                $(input).attr("name")!="image"){
                                    $(input).val(data_values[i]);
                                }
                                if($(input).attr("type")=="checkbox"){
                                    if(data_values[i]==1){
                                        $(input).prop("checked",true);
                                    } else {
                                        $(input).prop("checked",false);
                                    }
                                }
                                select = $(form).find("select[name="+data_keys[i]+"]");
                                if($(select).length>0){
                                    $(select).val(data_values[i]).trigger("change");
                                }
                                textarea = $(form).find("textarea[name="+data_keys[i]+"]");
                                if(textarea.length>0){
                                    $(textarea).val(data_values[i]);
                                }
                                if(data_keys[i]=="image"){
                                    if(data_values[i]!=""){
                                        $(form).find("img.profile-picture").attr("src","{{ asset('storage') }}/"+data_values[i]);
                                        $(form).find("img.profile-picture").attr("alt",data.data.name);
                                        $(form).find("input[name=old_image]").val(data_values[i]);
                                    } else {
                                        $(form).find("img.profile-picture").attr("src","{{ asset('pos/assets/img/140x140.png') }}");
                                        $(form).find("img.profile-picture").attr("alt","Placeholder");
                                        $(form).find("input[name=old_image]").val("");
                                    }
                                }
                            }
                        }
                        $(modal).find(".be-loading").removeClass("be-loading-active");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if(jqXHR.responseJSON.exception){
                            error_string = "Something went wrong";
                            if(jqXHR.responseJSON.message!=""){
                                error_string = jqXHR.responseJSON.message;
                            }
                            $.gritter.add({
                                title: '',
                                text: error_string,
                                class_name: 'color danger'
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            }, reload_timeout);
                        } else {
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                            var errors = jqXHR.responseJSON.errors;
                            var errors_keys = Object.keys(errors);
                            var error_values = Object.values(errors);
                            var errors_string = "";
                            for(i=0; i<errors_keys.length; i++){
                                errors_string += (i+1) + ". " + error_values[i] + "<br>";
                            }
                            $.gritter.add({
                                title: '',
                                text: errors_string,
                                class_name: 'color danger'
                            });
                        }
                        //$(modal).modal('hide');
                    }
                });
            });
            @endcan

            @can('delete-stock')
            $("#stock, #edit-stock").on("click", ".delete", function(){
                var deleteBtn = this;
                $("#confirmation-dialog .confirmation-yes").unbind("click").on("click", function(){
                    var data_delete_route = $(deleteBtn).attr("data-delete-route");
                    var modal = $(this).closest("div.modal");
                    var form_data = new FormData();
                    form_data.append("_method","DELETE");
                    $.ajax({
                        /* the route pointing to the post function */
                        url: data_delete_route,
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: form_data,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $(modal).find(".be-loading").addClass("be-loading-active");
                        },
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            if(data.success) {
                                $(modal).modal('hide');
                                $.gritter.add({
                                    title: '',
                                    text: 'Stock successfully deleted',
                                    class_name: 'color success'
                                });
                                location.reload();
                            } else {
                                $.gritter.add({
                                    title: '',
                                    text: 'Something went wrong.',
                                    class_name: 'color danger'
                                });
                            }
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if(jqXHR.responseJSON.exception){
                                error_string = "Something went wrong";
                                if(jqXHR.responseJSON.message!=""){
                                    error_string = jqXHR.responseJSON.message;
                                }
                                $.gritter.add({
                                    title: '',
                                    text: error_string,
                                    class_name: 'color danger'
                                });
                                setTimeout(() => {
                                    window.location.href = "{{ route('dashboard') }}";
                                }, reload_timeout);
                            } else {
                                $(modal).find(".be-loading").removeClass("be-loading-active");
                                var errors = jqXHR.responseJSON.errors;
                                var errors_keys = Object.keys(errors);
                                var error_values = Object.values(errors);
                                var errors_string = "";
                                for(i=0; i<errors_keys.length; i++){
                                    errors_string += (i+1) + ". " + error_values[i] + "<br>";
                                }
                                $.gritter.add({
                                    title: '',
                                    text: errors_string,
                                    class_name: 'color danger'
                                });
                            }
                            //$(modal).modal('hide');
                        }
                    });
                    $(deleteBtn).closest("td").find("form.delete-form").submit();
                });
                $("#confirmation-dialog").modal("show");
            });
            @endcan
            @can('update-stock')
            $("#edit-stock").on("click", ".update-stock", function(){
                var modal = $("#edit-stock");
                var form = $(modal).find("form");
                var action = $(form).attr("action");
                var form_data = new FormData(form[0]);
                form_data.append("_method","PUT");
                $.ajax({
                    /* the route pointing to the post function */
                    url: action,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal('show');
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            $.gritter.add({
                                title: '',
                                text: 'Stock updated successfully.',
                                class_name: 'color success'
                            });
                            $(modal).modal('hide');
                            location.reload();
                        } else {
                            $.gritter.add({
                                title: '',
                                text: 'Something went wrong.',
                                class_name: 'color danger'
                            });
                        }
                        $(modal).find(".be-loading").removeClass("be-loading-active");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if(jqXHR.responseJSON.exception){
                            error_string = "Something went wrong";
                            if(jqXHR.responseJSON.message!=""){
                                error_string = jqXHR.responseJSON.message;
                            }
                            $.gritter.add({
                                title: '',
                                text: error_string,
                                class_name: 'color danger'
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            }, reload_timeout);
                        } else {
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                            var errors = jqXHR.responseJSON.errors;
                            var errors_keys = Object.keys(errors);
                            var error_values = Object.values(errors);
                            var errors_string = "";
                            for(i=0; i<errors_keys.length; i++){
                                errors_string += (i+1) + ". " + error_values[i] + "<br>";
                            }
                            $.gritter.add({
                                title: '',
                                text: errors_string,
                                class_name: 'color danger'
                            });
                        }
                        //$(modal).modal('hide');
                    }
                });
            });
            /* EDIT stock CODE */
            @endcan

            @can('create-stock')
            /* ADD NEW STOCK CODE */
            $("#add-stock").on("click", ".store-stock", function(){
                var modal = $("#add-stock");
                var form = $(modal).find("form");
                var action = $(form).attr("action");
                var form_data = new FormData(form[0]);
                $.ajax({
                    /* the route pointing to the post function */
                    url: action,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal('show');
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            $.gritter.add({
                                title: '',
                                text: 'Stock added successfully.',
                                class_name: 'color success'
                            });
                            $(modal).modal('hide');
                            location.reload();
                        } else {
                            $.gritter.add({
                                title: '',
                                text: 'Something went wrong.',
                                class_name: 'color danger'
                            });
                        }
                        $(modal).find(".be-loading").removeClass("be-loading-active");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if(jqXHR.responseJSON.exception){
                            error_string = "Something went wrong";
                            if(jqXHR.responseJSON.message!=""){
                                error_string = jqXHR.responseJSON.message;
                            }
                            $.gritter.add({
                                title: '',
                                text: error_string,
                                class_name: 'color danger'
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            }, reload_timeout);
                        } else {
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                            var errors = jqXHR.responseJSON.errors;
                            var errors_keys = Object.keys(errors);
                            var error_values = Object.values(errors);
                            var errors_string = "";
                            for(i=0; i<errors_keys.length; i++){
                                errors_string += (i+1) + ". " + error_values[i] + "<br>";
                            }
                            $.gritter.add({
                                title: '',
                                text: errors_string,
                                class_name: 'color danger'
                            });
                        }
                        //$(modal).modal('hide');
                    }
                });
            });
            $('#add-stock').on('hidden.bs.modal', function(e) {
                $(this).find('form')[0].reset();
                var input_file_div = $(this).find("form div.input-file");
                $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
            });
            /* ADD NEW STOCK CODE */
            @endcan

            $("div.input-file div.file-action-buttons button.change-picture").on("click", function(){
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").click();
            });
            $("div.input-file div.file-action-buttons button.delete-picture").on("click", function(){
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").val('');
                $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
                $(input_file_div).find("input[name=old_image]").val("");
            });
            $("div.input-file input[type=file]").on("change", function(){
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                var input_file_div = $(this).closest("div.input-file");
		        if (regex.test($(this).val().toLowerCase())) {
                    if (typeof (FileReader) != "undefined") {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $(input_file_div).find("img.picture-preview").attr("src", e.target.result);
                        }
                        reader.readAsDataURL($(this)[0].files[0]);
                    }
                } else {
                    var old_image = $(input_file_div).find("input[name=old_image]").val();
                    if(old_image!=""){
                        $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('storage') }}/"+old_image);
                    } else {
                        $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
                    }
                }
            });
		});
	</script>
@endsection
