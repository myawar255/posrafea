<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('zzassets/img/logo-fav.png') }}">
        <!--<title>{{ config('app.name', 'Laravel') }}</title>-->
        <title>@yield('page_title')</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}"/>

        <!-- CUSTOM CSS -->
        <link rel="stylesheet" href="{{ asset('pos/css/custom.css') }}" type="text/css"/>
        @yield('page_level_styles')
        <link rel="stylesheet" href="{{ asset('pos/assets/css/app.css') }}" type="text/css"/>

        @livewireStyles
    </head>
  <body>
        <div class="be-wrapper">

            {{-- @include('partials.header') --}}

            {{-- @include('partials.sidebar') --}}

            <div class="be-content">
                @yield('page_head')
                <div class="main-content container-fluid">
                    @yield('content')
                </div>
            </div>

        </div>

        @yield('modals')

        <!-- START OF CONFIRMATION MODAL -->
        <div class="modal fade colored-header colored-header-primary" id="confirmation-dialog" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content be-loading">
                    <div class="modal-header modal-header-colored">
                        <h3 class="modal-title">Confirmation</h3>
                        <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="confirmation">
                                <p>Are you sure?</p>
                                <div class="row">
                                    <div class="col-6">
                                        <a class="btn btn-space btn-secondary w-100" data-dismiss="modal">No</a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-space btn-danger w-100 confirmation-yes">YES</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="be-spinner">
                        <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://-www.w3.org/2000/svg">
                            <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF CONFIRMATION MODAL -->

        <script src="{{ asset('pos/assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/js/app.js') }}" type="text/javascript"></script>

        <!-- Custom Js -->
        <script src="{{ asset('pos/js/custom.js') }}" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                //-initialize the javascript
                App.init();
            });
        </script>

        @yield('page_level_scripts')

        @livewireScripts

    </body>
</html>
