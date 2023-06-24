<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('zassets/img/logo-fav.png') }}">
        <title>User Management</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
        <link rel="stylesheet" href="{{ asset('pos/assets/css/app.css') }}" type="text/css"/>
        <link rel="stylesheet" href="{!! asset('pos/css/custom.css') !!}?v=1.0" type="text/css"/>
    </head>
    <body class="be-splash-screen">
        <!--<div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>-->
        <div class="be-wrapper be-login">
            <div class="be-content">
                <div class="main-content container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{ asset('pos/assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('pos/assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>

        <!-- CUSTOM JS -->
        <script src="{!! asset('pos/js/validation.js') !!}?v=1.1" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                //-initialize the javascript
                App.init();

                @if ($errors->any())
                    @php
                        $i = 0;
                        $error_string = "";
                        foreach($errors->all() as $error):
                            $error_string .= ($i+1) . ". " . $error . "<br>";
                            $i++;
                        endforeach;
                    @endphp
                    $.gritter.add({
                        title: '',
                        text: "{!! $error_string !!}",
                        class_name: 'color danger'
                    });
                @endif
            });
        </script>
    </body>
</html>
