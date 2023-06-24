@extends('layouts.app')

@section('page_title', __('Change Password') )

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
@endsection

@section('page_head')
    <div class="page-head">
        <h2 class="page-head-title">Change Password</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update.password') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative">
                            <label for="current_password">Current Password</label>
                            <input class="form-control custom-input-attachment" id="current_password" name="current_password" type="password" placeholder="Enter current password">
                            <div class="custom-input-attachment custom-input-attachment-with-label-top">
                                <a href="javascript:void(0);" class="password-show-icon">
                                    <i class="icon-th mdi mdi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="form-group position-relative">
                            <label for="password">New Password</label>
                            <input class="form-control custom-input-attachment" id="password" name="password" type="password" placeholder="Enter new password">
                            <div class="custom-input-attachment custom-input-attachment-with-label-top">
                                <a href="javascript:void(0);" class="password-show-icon">
                                    <i class="icon-th mdi mdi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="form-group position-relative">
                            <label for="password_confirmation">Confirm Password</label>
                            <input class="form-control custom-input-attachment" id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter confirm password">
                            <div class="custom-input-attachment custom-input-attachment-with-label-top">
                                <a href="javascript:void(0);" class="password-show-icon">
                                    <i class="icon-th mdi mdi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12">
                                <p class="text-right">
                                    <button class="btn btn-space btn-primary" type="submit">Submit</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_level_scripts')
    <script src="{{ asset('pos/assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/js/app-ui-notifications.js') }}" type="text/javascript"></script>
    <!-- CUSTOM JS -->
    <script src="{!! asset('pos/js/validation.js') !!}?v=1.1" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			//-initialize the javascript

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

            @if (session()->has('success'))
                $.gritter.add({
                    title: '',
                    text: "Password successfully changed",
                    class_name: 'color success'
                });
            @endif
		});
	</script>
@endsection
