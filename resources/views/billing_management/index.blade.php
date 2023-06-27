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
    <style>
        .plus_ingredient {
            font-size: 20px;
            font-weight: bolder;
        }

        .unit_name {
            vertical-align: sub !important;
            font-size: smaller !important;
        }
    </style>
@endsection

@section('page_head')
    <div class="page-head">
        <h2 class="page-head-title">Billing Management</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item active">Billing</li>
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
                                    <a href="{{route('billing.create')}}" class="btn btn-space btn-primary btn-sm" type="button">
                                        <i class="icon icon-left mdi mdi-plus"></i>Add New
                                    </a>
                                </div>
                            </div>
                        @endcan
                        <table class="table table-striped table-hover be-table-responsive" id="product"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:5%;">
                                        <label class="custom-control custom-control-sm custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"><span
                                                class="custom-control-label"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Price</th>
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
    {{-- @dd($stock_units) --}}
@endsection
@section('modals')



    {{-- @can('view-stock') --}}
        <!-- START OF VIEW product MODAL -->
        <div class="modal fade colored-header colored-header-primary" id="view-invoice" tabindex="-1" role="dialog"
            data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content be-loading">
                    <form>
                        <div class="modal-header modal-header-colored">
                            <h3 class="modal-title">View Invoice</h3>
                            <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span
                                    class="mdi mdi-close"></span></button>
                        </div>
                        <div class="modal-body view_model">

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary md-close close" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    <div class="be-spinner">
                        <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://-www.w3.org/2000/svg">
                            <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33"
                                r="30" class="circle"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF VIEW STOCK MODAL -->
    {{-- @endcan --}}


@endsection

@section('page_level_scripts')
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

    <script type="text/javascript">
        $(document).ready(function() {
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
            let stock = $('#product').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "searchDelay": 1000,
                "ajax": {
                    "url": "{{ route('get_billing') }}",
                    "method": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data": function(d) {
                        d.selected_rows = selected_rows;
                    }
                },
                "columns": [{
                        "data": 'checkbox'
                    },
                    {
                        "data": 'id'
                    },
                    {
                        "data": 'price'
                    },
                    {
                        "data": 'action'
                    },
                ],
                "order": [
                    [1, "asc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 3]
                    },
                    {
                        "className": "select-checkbox",
                        targets: [0]
                    },
                    {
                        "className": "user-avatar user-info",
                        targets: [2]
                    }
                    //{ "className": "text-center", targets: [6] },
                ],
                "scrollY": 300,
                "scrollX": true,
                "scrollCollapse": true,
                "colReorder": {
                    fixedColumnsLeft: 3,
                    fixedColumnsRight: 1
                },
                "fixedColumns": {
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
                        attr: {
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
                        attr: {
                            "data-original-title": 'Export to Excel',
                        },
                        className: 'btn btn-success show-tooltip',
                        exportOptions: {
                            columns: ':visible:not(:first-child):not(:last-child)'
                        },
                        filename: "{{ rand() . date('YmdHis') }}",
                        title: function() {
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
                        attr: {
                            "data-original-title": 'Export to PDF',
                        },
                        className: 'btn btn-danger show-tooltip',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: ':visible:not(:first-child):not(:last-child)'
                        },
                        filename: "{{ rand() . date('YmdHis') }}",
                        title: function() {
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
                if (e.target.tagName == "INPUT") {
                    if ($(this).hasClass("selected")) {
                        var data = stock.rows({
                                filter: 'applied',
                                page: 'current'
                            }).every(function(idx, data, node) {
                                var checkbox = $(this.node()).find('td:eq(' + column_index +
                                    ') input[type="checkbox"]');
                                var value = $(checkbox).val();
                                var index = selected_rows.indexOf(value);
                                if (index != -1) {
                                    selected_rows.splice(index, 1);
                                }
                                return $(checkbox).prop('checked', false);
                            })
                            .data()
                            .toArray();

                        $(this).removeClass("selected");
                    } else {
                        // Select All Current Column Checkboxes
                        //$(this).find("input[type=checkbox]").prop('checked', true);
                        var data = stock.rows({
                                filter: 'applied',
                                page: 'current'
                            }).every(function(idx, data, node) {
                                var checkbox = $(this.node()).find('td:eq(' + column_index +
                                    ') input[type="checkbox"]');
                                var value = $(checkbox).val();
                                var index = selected_rows.indexOf(value);
                                if (index == -1) {
                                    selected_rows.push(value);
                                }
                                return $(checkbox).prop('checked', true);
                            })
                            .data()
                            .toArray();

                        $(this).addClass("selected");
                    }
                }
            });
            stock.on("click", "td.select-checkbox", function(e) {
                if (e.target.tagName == "INPUT") {
                    var checkbox = $(this).find("input[type=checkbox]");
                    var value = $(checkbox).val();
                    var index = selected_rows.indexOf(value);

                    if (!$(checkbox).prop('checked')) {
                        $(".dataTable th.select-checkbox").removeClass("selected");
                        if (index != -1) {
                            selected_rows.splice(index, 1);
                        }
                    } else {
                        if (index == -1) {
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
                        success: function(data) {
                            console.log('data: ', data);
                            // if (data.success) {
                            $('.view_model').html(data);

                            $(modal).find(".be-loading").removeClass("be-loading-active");
                            // }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.responseJSON.exception) {
                                error_string = "Something went wrong";
                                if (jqXHR.responseJSON.message != "") {
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
                                for (i = 0; i < errors_keys.length; i++) {
                                    errors_string += (i + 1) + ". " + error_values[i] + "<br>";
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
                        success: function(data) {
                            console.log('data: ', data[1]);

                            $(modal).find("h3.modal-title").html("Edit Stock (#" + data[1]
                                .id + " - " + data[1].name + ")");
                            $(modal).find("form").attr("action", data[1].update_product);
                            @can('delete-stock')
                                $(modal).find("a.delete").attr("data-delete-route", data[1]
                                    .destroy);
                            @endcan

                            $('.edit_model').html(data[0]);
                            $('.select2me').select2();
                            $(modal).find(".be-loading").removeClass("be-loading-active");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.responseJSON.exception) {
                                error_string = "Something went wrong";
                                if (jqXHR.responseJSON.message != "") {
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
                                for (i = 0; i < errors_keys.length; i++) {
                                    errors_string += (i + 1) + ". " + error_values[i] + "<br>";
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
                $("#stock, #edit-stock, #delete_product").on("click", ".delete", function() {
                    var deleteBtn = this;
                    $("#confirmation-dialog .confirmation-yes").unbind("click").on("click", function() {
                        var data_delete_route = $(deleteBtn).attr("data-delete-route");
                        var modal = $(this).closest("div.modal");
                        var form_data = new FormData();
                        form_data.append("_method", "DELETE");
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
                                $(modal).find(".be-loading").addClass(
                                    "be-loading-active");
                            },
                            /* remind that 'data' is the response of the AjaxController */
                            success: function(data) {
                                $(modal).modal('hide');
                                $.gritter.add({
                                    title: '',
                                    text: 'Stock successfully deleted',
                                    class_name: 'color success'
                                });
                                location.reload();

                                $(modal).find(".be-loading").removeClass(
                                    "be-loading-active");
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                if (jqXHR.responseJSON.exception) {
                                    error_string = "Something went wrong";
                                    if (jqXHR.responseJSON.message != "") {
                                        error_string = jqXHR.responseJSON.message;
                                    }
                                    $.gritter.add({
                                        title: '',
                                        text: error_string,
                                        class_name: 'color danger'
                                    });
                                    setTimeout(() => {
                                        window.location.href =
                                            "{{ route('dashboard') }}";
                                    }, reload_timeout);
                                } else {
                                    $(modal).find(".be-loading").removeClass(
                                        "be-loading-active");
                                    var errors = jqXHR.responseJSON.errors;
                                    var errors_keys = Object.keys(errors);
                                    var error_values = Object.values(errors);
                                    var errors_string = "";
                                    for (i = 0; i < errors_keys.length; i++) {
                                        errors_string += (i + 1) + ". " + error_values[
                                            i] + "<br>";
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
                $("#edit-stock").on("click", ".update-stock", function() {
                    var modal = $("#edit-stock");
                    var form = $(modal).find("form");
                    var action = $(form).attr("action");
                    var form_data = new FormData(form[0]);
                    form_data.append("_method", "PUT");
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
                        success: function(data) {
                            if (data.success) {
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
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.responseJSON.exception) {
                                error_string = "Something went wrong";
                                if (jqXHR.responseJSON.message != "") {
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
                                for (i = 0; i < errors_keys.length; i++) {
                                    errors_string += (i + 1) + ". " + error_values[i] + "<br>";
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
                $("#add-stock").on("click", ".store-stock", function() {
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
                        success: function(data) {
                            if (data.success) {
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
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.responseJSON.exception) {
                                error_string = "Something went wrong";
                                if (jqXHR.responseJSON.message != "") {
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
                                for (i = 0; i < errors_keys.length; i++) {
                                    errors_string += (i + 1) + ". " + error_values[i] + "<br>";
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
                    $(input_file_div).find("img.picture-preview").attr("src",
                        "{{ asset('pos/assets/img/140x140.png') }}");
                });
                /* ADD NEW STOCK CODE */
            @endcan

            $("div.input-file div.file-action-buttons button.change-picture").on("click", function() {
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").click();
            });
            $("div.input-file div.file-action-buttons button.delete-picture").on("click", function() {
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").val('');
                $(input_file_div).find("img.picture-preview").attr("src",
                    "{{ asset('pos/assets/img/140x140.png') }}");
                $(input_file_div).find("input[name=old_image]").val("");
            });
            $("div.input-file input[type=file]").on("change", function() {
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                var input_file_div = $(this).closest("div.input-file");
                if (regex.test($(this).val().toLowerCase())) {
                    if (typeof(FileReader) != "undefined") {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(input_file_div).find("img.picture-preview").attr("src", e.target.result);
                        }
                        reader.readAsDataURL($(this)[0].files[0]);
                    }
                } else {
                    var old_image = $(input_file_div).find("input[name=old_image]").val();
                    if (old_image != "") {
                        $(input_file_div).find("img.picture-preview").attr("src",
                            "{{ asset('storage') }}/" + old_image);
                    } else {
                        $(input_file_div).find("img.picture-preview").attr("src",
                            "{{ asset('pos/assets/img/140x140.png') }}");
                    }
                }
            });
        });
    </script>

    <script>
        var count = 1;

        function add_more_ingreddients() {
            count++;
            var url = '{{ route('add_more_ingredients', ':count') }}';
            url = url.replace(':count', count);

            $.ajax({
                type: 'GET',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                    $('.add_ingredients').append(data)
                    $('.select2me').select2();

                },
            });
        }

        function add_ingreddients() {
            count++;
            var url = '{{ route('add_more_ingredients', ':count') }}';
            url = url.replace(':count', count);

            $.ajax({
                type: 'GET',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                    $('.ingredients').append(data)
                    $('.select2me').select2();

                },
            });
        }
        function loadInvoice(id) {
            var url = '{{ route('billing.show', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                type: 'GET',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('.view_model').html(data)
                },
            });
        }

        function removeClubField(count) {
            $('.ingredient_' + count).remove();
        }


        function removeInvoice(id) {
            console.log('id: ', id);
            $("#confirmation-dialog .confirmation-yes").unbind("click").on("click", function() {
                var modal = $(this).closest("div.modal");
                var form_data = new FormData();
                form_data.append("_method", "DELETE");
                var url = '{{ route('billing.destroy', ':id') }}';
                url = url.replace(':id', id);
                $.ajax({
                    /* the route pointing to the post function */

                    url: url,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).find(".be-loading").addClass(
                            "be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function(data) {
                        $(modal).modal('hide');
                        $.gritter.add({
                            title: '',
                            text: 'Stock successfully deleted',
                            class_name: 'color success'
                        });
                        location.reload();

                        $(modal).find(".be-loading").removeClass(
                            "be-loading-active");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON.exception) {
                            error_string = "Something went wrong";
                            if (jqXHR.responseJSON.message != "") {
                                error_string = jqXHR.responseJSON.message;
                            }
                            $.gritter.add({
                                title: '',
                                text: error_string,
                                class_name: 'color danger'
                            });
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('dashboard') }}";
                            }, reload_timeout);
                        } else {
                            $(modal).find(".be-loading").removeClass(
                                "be-loading-active");
                            var errors = jqXHR.responseJSON.errors;
                            var errors_keys = Object.keys(errors);
                            var error_values = Object.values(errors);
                            var errors_string = "";
                            for (i = 0; i < errors_keys.length; i++) {
                                errors_string += (i + 1) + ". " + error_values[
                                    i] + "<br>";
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
                $(this).closest("td").find("form.delete-form").submit();
            });
            $("#confirmation-dialog").modal("show");
        }

        $(".close").click(function() {
            $('#add-stock').modal('hide')
            $('#view-stock').modal('hide')
            $('#edit-stock').modal('hide')
        });
    </script>



@endsection
