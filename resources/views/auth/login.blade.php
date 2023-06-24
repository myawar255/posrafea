<x-guest-layout>
    <div class="splash-container">
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header">
                <img class="logo-img" src="{{ asset('pos/assets/img/logo-xx.png') }}" alt="logo" width="102" height="27">
                <span class="splash-description">Please enter your user information.</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" :value="old('email')" autofocus placeholder="{{ __('Email') }}">
                    </div>
                    <div class="form-group position-relative">
                        <input class="form-control custom-input-attachment" type="password" name="password" autocomplete="current-password" placeholder="{{ __('Password') }}">
                        <div class="custom-input-attachment">
                            <a href="javascript:void(0);" class="password-show-icon">
                                <i class="icon-th mdi mdi-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="form-group row login-tools">
                        <div class="col-6 login-remember">
                            <label class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember">
                                <span class="custom-control-label">{{ __('Remember Me') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group login-submit">
                        <button type="submit" class="btn btn-primary btn-xl" data-dismiss="modal">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
