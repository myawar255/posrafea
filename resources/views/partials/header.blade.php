		<nav class="navbar navbar-expand fixed-top be-top-header">
			<div class="container-fluid">
				<div class="be-navbar-header">
					<a class="navbar-brand" href="{{ route('dashboard') }}"></a>
				</div>
				<div class="be-right-navbar">
					<ul class="nav navbar-nav float-right be-user-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(Auth::user()->profile_photo)
								    <img src="{{ Auth::user()->profile_photo }}" alt="{{ Auth::user()->name }}" />
                                @else
                                <img src="{{ asset('pos/assets/img/avatar.png') }}" alt="{{ Auth::user()->name }}" />
                                @endif
								<span class="user-name">{{ Auth::user()->name }}</span>
							</a>
							<div class="dropdown-menu" role="menu">
								<div class="user-info">
									<div class="user-name">{{ Auth::user()->name }}</div>
								</div>
								<a class="dropdown-item" href="{{ route('users.edit.password') }}">
									<span class="icon mdi mdi-key"></span>Change Password
								</a>
								<a class="dropdown-item logout" href="{{ route('logout') }}" onclick="event.preventDefault(); $(this).children('form').submit();">
									<span class="icon mdi mdi-power"></span>{{ __('Logout') }}
									<!-- Authentication -->
									<form method="POST" action="{{ route('logout') }}">
										@csrf
									</form>
								</a>
							</div>
						</li>
					</ul>
					<div class="page-title"><span>@yield('page_title')</span></div>
				</div>
			</div>
		</nav>
