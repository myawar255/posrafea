			<div class="be-left-sidebar">
				<div class="left-sidebar-wrapper"><a class="left-sidebar-toggle" href="#">Menu</a>
					<div class="left-sidebar-spacer">
						<div class="left-sidebar-scroll">
							<div class="left-sidebar-content">
								<ul class="sidebar-elements">
									<li class="divider">Menu</li>
									<li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
										<a href="{{ route('dashboard') }}">
											<i class="icon mdi mdi-home"></i>
											<span>{{ __('Dashboard') }}</span>
										</a>
									</li>
                                    @canany(['create-user','view-user','update-user','delete-user',
                                            'create-role','view-role','update-role','delete-role'
                                    ])
                                    <li class="parent {{ (request()->routeIs('users.index') ||
                                    request()->routeIs('roles.index')) ? 'active open' : '' }}">
                                        <a href="#">
                                            <i class="icon mdi mdi-accounts"></i>
                                            <span>User Management</span>
                                        </a>
                                        <ul class="sub-menu">
                                            @canany(['create-user','view-user','update-user','delete-user'])
                                                <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                                                    <a href="{{ route('users.index') }}">Users</a>
                                                </li>
                                            @endcanany
                                            @canany(['create-role','view-role','update-role','delete-role'])
                                                <li class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                                    <a href="{{ route('roles.index') }}">Roles</a>
                                                </li>
                                            @endcanany
                                        </ul>
                                    </li>
                                    @endcanany
                                    @canany(['create-stock-unit','view-stock-unit','update-stock-unit','delete-stock-unit'
                                    ])
                                    <li class="parent {{ (request()->routeIs('stock_unit.index') ||
                                        request()->routeIs('listing_categories.index')) ? 'active open' : '' }}">
                                        <a href="#" title="Catalogue Management">
                                            <i class="icon mdi mdi-view-list-alt"></i>
                                            <span>Catalogue</span>
                                        </a>
                                        <ul class="sub-menu">
                                            @canany(['create-stock-unit','view-stock-unit','update-stock-unit','delete-stock-unit'])
                                                <li class="{{ request()->routeIs('stock_unit.index') ? 'active' : '' }}">
                                                    <a href="{{ route('stock_unit.index') }}" title="Stock Unit">Stock Unit</a>
                                                </li>
                                            @endcanany
                                        </ul>
                                    </li>
                                    @endcanany
                                    @canany(['create-stock','view-stock','update-stock','delete-stock'])
									<li class="{{ request()->routeIs('stock.index') ? 'active' : '' }}">
										<a href="{{ route('stock.index') }}" title="Stock">
											<i class="icon mdi mdi-accounts"></i>
											<span>Stock Management</span>
										</a>
									</li>
                                    @endcanany
                                    {{-- @canany(['create-stock','view-stock','update-stock','delete-stock']) --}}
									<li class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
										<a href="{{ route('product.index') }}" title="Product">
											<i class="icon mdi mdi-accounts"></i>
											<span>Product Management</span>
										</a>
									</li>
                                    {{-- @endcanany --}}
                                    {{-- @canany(['create-stock','view-stock','update-stock','delete-stock']) --}}
									<li class="{{ request()->routeIs('billing.index') ? 'active' : '' }}">
										<a href="{{ route('billing.index') }}" title="Billing">
											<i class="icon mdi mdi-accounts"></i>
											<span>Billing Management</span>
										</a>
									</li>
                                    {{-- @endcanany --}}
                                    <li class="parent {{ (request()->routeIs('users.edit.password')) ? 'active open' : '' }}">
                                        <a href="#">
                                            <i class="icon mdi mdi-settings"></i>
                                            <span>Settings</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="{{ request()->routeIs('users.edit.password') ? 'active' : '' }}">
                                                <a href="{{ route('users.edit.password') }}">Change Password</a>
                                            </li>
                                        </ul>
                                    </li>
									<li>
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); $('a.logout').click();">
											<i class="icon mdi mdi-power"></i>
											<span>{{ __('Logout') }}</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
