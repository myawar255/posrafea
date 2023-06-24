@extends('layouts.app')

@section('page_title', __('Users') )

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('pos/assets/lib/datatables/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
@endsection

@section('page_head')
    <div class="page-head">
        <h2 class="page-head-title">Users</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item">User Management</li>
                <li class="breadcrumb-item active">Users</li>
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
                        @can('create-user')
                        <div class="row m-0">
                            <div class="col-md-12 p-2 text-right">
                                <button class="btn btn-space btn-primary btn-sm" data-toggle="modal" data-target="#add-user" type="button">
                                    <i class="icon icon-left mdi mdi-plus"></i>Add New
                                </button>
                            </div>
                        </div>
                        @endcan
                        <table class="table table-striped table-hover be-table-responsive" id="users" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:5%;">
                                        <label class="custom-control custom-control-sm custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>National ID Card Number</th>
                                    <th>Role(s)</th>
                                    <th>Is Active?</th>
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

    @can('create-user')
    <!-- START OF ADD NEW USER MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="add-user" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form id="create-user-validation" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Add New User</h3>
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
                            <input type="file" name="profile_picture" style="display: none;">
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
                                    <label>Email</label>
                                    <input class="form-control form-control-xs" type="email" name="email" placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>National ID Card Number</label>
                                    <input class="form-control form-control-xs" type="text" name="national_id_card_number" placeholder="Enter national id card number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Is Active?</label>
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="is_active" value="1">
                                        <span class="custom-control-label custom-control-color"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control form-control-xs" type="password" name="password" placeholder="Enter password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control form-control-xs" type="password" name="password_confirmation" placeholder="Enter confirm password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary store-user" type="button">Save</button>
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
    <!-- END OF ADD NEW USER MODAL -->
    @endcan

    @can('view-user')
    <!-- START OF VIEW USER MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="view-user" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form>
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">View User</h3>
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
                                    <label>Email</label>
                                    <input class="form-control form-control-xs" type="email" name="email" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>National ID Card Number</label>
                                    <input class="form-control form-control-xs" type="text" name="national_id_card_number" readonly="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Is Active?</label>
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="is_active" value="1" disabled="">
                                        <span class="custom-control-label custom-control-color"></span>
                                    </label>
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
    <!-- END OF VIEW USER MODAL -->
    @endcan

    @can('update-user')
    <!-- START OF EDIT USER MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="edit-user" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form id="edit-user-validation">
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Edit User</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="btn-group btn-group-justified btn-space" role="group">
                        @can('delete-user')
                            <a class="btn btn-danger delete" href="javascript:void(0)">Delete User</a>
                        @endcan
                        <a class="btn btn-warning edit-roles" href="javascript:void(0)">Edit Roles</a>
                        <a class="btn btn-success edit-permissions" href="javascript:void(0)">Edit Permissions</a>
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
                            <input type="file" name="profile_picture" style="display: none;">
                            <input type="hidden" name="old_profile_picture">
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
                                    <label>Email</label>
                                    <input class="form-control form-control-xs" type="email" name="email" placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>National ID Card Number</label>
                                    <input class="form-control form-control-xs" type="text" name="national_id_card_number" placeholder="Enter national id card number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Is Active?</label>
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="is_active" value="1">
                                        <span class="custom-control-label custom-control-color"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control form-control-xs" type="password" name="password" placeholder="Enter password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control form-control-xs" type="password" name="password_confirmation" placeholder="Enter confirm password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary update-user" type="button">Save</button>
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
    <!-- END OF EDIT USER MODAL -->

    <!-- START OF EDIT USER ROLES MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="edit-user-roles" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form>
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Edit User Roles</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Role(s)</th>
                                    <th class="text-center">
                                        <label class="custom-control custom-checkbox custom-control-inline">
                                            <input class="custom-control-input select-all-roles" type="checkbox">
                                            <span class="custom-control-label custom-control-color"></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary update-roles" type="button">Save</button>
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
    <!-- END OF EDIT USER ROLES MODAL -->

    <!-- START OF EDIT USER PERMISSIONS MODAL -->
    <div class="modal fade colored-header colored-header-primary" id="edit-user-permissions" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content be-loading">
                <form>
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Edit User Permissions</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="py-4" rowspan="2">Permission(s)</th>
                                    <th class="text-center py-1">Grant</th>
                                    <th class="text-center py-1">Revoke</th>
                                </tr>
                                <tr>
                                    <th class="text-center py-1">
                                        <label class="custom-control custom-checkbox custom-control-inline">
                                            <input class="custom-control-input grant-all-permissions" type="checkbox">
                                            <span class="custom-control-label custom-control-color"></span>
                                        </label>
                                    </th>
                                    <th class="text-center py-1">
                                        <label class="custom-control custom-checkbox custom-control-inline">
                                            <input class="custom-control-input revoke-all-permissions" type="checkbox">
                                            <span class="custom-control-label custom-control-color"></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary update-permissions" type="button">Save</button>
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
    <!-- END OF EDIT USER PERMISSIONS MODAL -->
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

	<script type="text/javascript">
		$(document).ready(function(){
			//-initialize the javascript

            var reload_timeout = 1500;
            var selected_rows = [];
            //Table init
            let users = $('#users').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "searchDelay": 1000,
                "ajax": {
                    "url": "{{route('users.get')}}",
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
                        { "data": 'email' },
                        { "data": 'nic' },
                        { "data": 'roles' },
                        { "data": 'is_active' },
                        { "data": 'action' },
                    ],
                "order": [[ 1, "asc" ]],
                "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [0,5,6,7]
                    },
                    { "className": "select-checkbox", targets: [0] },
                    { "className": "user-avatar user-info", targets: [2]},
                    { "className": "text-center", targets: [6] },
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
                        var data = users.rows({filter: 'applied', page: 'current'}).every( function ( idx, data, node ) {
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
                        var data = users.rows({filter: 'applied', page: 'current'}).every( function ( idx, data, node ) {
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
            users.on("click", "td.select-checkbox", function(e) {
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

            @can('view-user')
            /* VIEW USER CODE */
            users.on("click", ".view-user", function(e) {
                var route = $(this).attr("data-view-route");
                var modal = $("#view-user");
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
                            $(modal).find("h3.modal-title").html("View User (#"+data.data.id+" - "+data.data.name+")");
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
                                    $(select).val(data_values[i]).trigger("chosen:updated");
                                }
                                textarea = $(form).find("textarea[name="+data_keys[i]+"]");
                                if(textarea.length>0){
                                    $(textarea).val(data_values[i]);
                                }
                                if(data_keys[i]=="profile_picture"){
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
            /* VIEW USER CODE */
            @endcan

            @can('update-user')
            /* EDIT USER CODE */
            users.on("click", ".edit-user", function(e) {
                var route = $(this).attr("data-edit-route");
                var modal = $("#edit-user");
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
                            $(modal).find("h3.modal-title").html("Edit User (#"+data.data.id+" - "+data.data.name+")");
                            $(modal).find("form").attr("action",data.data.update_user);
                            @can('delete-user')
                                $(modal).find("a.delete").attr("data-delete-route",data.data.destroy);
                            @endcan
                            $(modal).find("a.edit-roles").attr("data-edit-roles-route",data.data.user_roles);
                            $("#edit-user-roles").find("form").attr("action",data.data.update_user_roles);
                            $(modal).find("a.edit-permissions").attr("data-edit-permissions-route",data.data.user_permissions);
                            $("#edit-user-permissions").find("form").attr("action",data.data.update_user_permissions);
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
                                    $(select).val(data_values[i]).trigger("chosen:updated");
                                }
                                textarea = $(form).find("textarea[name="+data_keys[i]+"]");
                                if(textarea.length>0){
                                    $(textarea).val(data_values[i]);
                                }
                                if(data_keys[i]=="profile_picture"){
                                    if(data_values[i]!=""){
                                        $(form).find("img.profile-picture").attr("src","{{ asset('storage') }}/"+data_values[i]);
                                        $(form).find("img.profile-picture").attr("alt",data.data.name);
                                        $(form).find("input[name=old_profile_picture]").val(data_values[i]);
                                    } else {
                                        $(form).find("img.profile-picture").attr("src","{{ asset('pos/assets/img/140x140.png') }}");
                                        $(form).find("img.profile-picture").attr("alt","Placeholder");
                                        $(form).find("input[name=old_profile_picture]").val("");
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

            @can('delete-user')
            $("#users, #edit-user").on("click", ".delete", function(){
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
                                    text: 'User successfully deleted',
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
            @can('update-user')
            $("#edit-user").on("click", ".update-user", function(){
                var modal = $("#edit-user");
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
                                text: 'User updated successfully.',
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
            /* EDIT USER CODE */

            /* EDIT USER ROLES CODE */
            $("#edit-user").on("click", ".edit-roles", function(){
                var editRolesBtn = this;
                var data_edit_roles_route = $(editRolesBtn).attr("data-edit-roles-route");
                var modal = $("#edit-user-roles");
                $.ajax({
                    /* the route pointing to the post function */
                    url: data_edit_roles_route,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: "",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal('show');
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            $(modal).find("tbody").html(data.data);
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
            $("#edit-user-roles").on("click", ".update-roles", function(){
                var updateRolesBtn = this;
                var modal = $("#edit-user-roles");
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
                                text: 'Roles updated successfully.',
                                class_name: 'color success'
                            });
                            $(modal).modal('hide');
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
            $("input.select-all-roles").on("click", function(){
                if($(this).prop("checked")){
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(1) input[type=checkbox]").prop("checked", true);
                    });
                } else {
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(1) input[type=checkbox]").prop("checked", false);
                    });
                }
            });
            $('#edit-user-roles').on('hidden.bs.modal', function () {
                $("input.select-all-roles").prop("checked", false);
            });
            /* EDIT USER ROLES CODE */

            /* EDIT USER PERMISSIONS CODE */
            $("#edit-user").on("click", ".edit-permissions", function(){
                var editPermissionsBtn = this;
                var data_edit_permissions_route = $(editPermissionsBtn).attr("data-edit-permissions-route");
                var modal = $("#edit-user-permissions");
                $.ajax({
                    /* the route pointing to the post function */
                    url: data_edit_permissions_route,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: "",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(modal).modal('show');
                        $(modal).find(".be-loading").addClass("be-loading-active");
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data.success) {
                            $(modal).find("tbody").html(data.data);
                            $(modal).find("input.grant-permission").unbind("click").on("click", function(){
                                if($(this).prop("checked")){
                                    $(this).closest("tr").find("input.revoke-permission").prop("checked",false);
                                }
                                $("input.revoke-all-permissions").prop("checked",false);
                                $("input.grant-all-permissions").prop("checked",false);
                            });
                            $(modal).find("input.revoke-permission").unbind("click").on("click", function(){
                                if($(this).prop("checked")){
                                    $(this).closest("tr").find("input.grant-permission").prop("checked",false);
                                }
                                $("input.revoke-all-permissions").prop("checked",false);
                                $("input.grant-all-permissions").prop("checked",false);
                            });
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
            $("#edit-user-permissions").on("click", ".update-permissions", function(){
                var updatePermissionsBtn = this;
                var modal = $("#edit-user-permissions");
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
                                text: 'Permissions updated successfully.',
                                class_name: 'color success'
                            });
                            $(modal).modal('hide');
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
            $("input.grant-all-permissions").on("click", function(){
                if($(this).prop("checked")){
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(1) input[type=checkbox]").prop("checked", true);
                        $(this).find("td:eq(2) input[type=checkbox]").prop("checked", false);
                        $("input.revoke-all-permissions").prop("checked", false);
                    });
                } else {
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(1) input[type=checkbox]").prop("checked", false);
                    });
                }
            });
            $("input.revoke-all-permissions").on("click", function(){
                if($(this).prop("checked")){
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(2) input[type=checkbox]").prop("checked", true);
                        $(this).find("td:eq(1) input[type=checkbox]").prop("checked", false);
                        $("input.grant-all-permissions").prop("checked", false);
                    });
                } else {
                    $(this).closest("table").find("tbody tr").each(function(){
                        $(this).find("td:eq(2) input[type=checkbox]").prop("checked", false);
                    });
                }
            });
            $('#edit-user-permissions').on('hidden.bs.modal', function () {
                $("input.grant-all-permissions").prop("checked", false);
                $("input.revoke-all-permissions").prop("checked", false);
            });
            /* EDIT USER PERMISSIONS CODE */
            @endcan

            @can('create-user')
            /* ADD NEW USER CODE */
            $("#add-user").on("click", ".store-user", function(){
                var modal = $("#add-user");
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
                                text: 'User added successfully.',
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
            $('#add-user').on('hidden.bs.modal', function(e) {
                $(this).find('form')[0].reset();
                var input_file_div = $(this).find("form div.input-file");
                $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
            });
            /* ADD NEW USER CODE */
            @endcan

            $("div.input-file div.file-action-buttons button.change-picture").on("click", function(){
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").click();
            });
            $("div.input-file div.file-action-buttons button.delete-picture").on("click", function(){
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").val('');
                $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
                $(input_file_div).find("input[name=old_profile_picture]").val("");
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
                    var old_profile_picture = $(input_file_div).find("input[name=old_profile_picture]").val();
                    if(old_profile_picture!=""){
                        $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('storage') }}/"+old_profile_picture);
                    } else {
                        $(input_file_div).find("img.picture-preview").attr("src", "{{ asset('pos/assets/img/140x140.png') }}");
                    }
                }
            });
		});
	</script>
@endsection
