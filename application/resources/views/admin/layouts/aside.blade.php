<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
                <!--begin:Menu item-->
                <div class="menu-item menu-accordion" style="margin-left: -11px;">
                    <!--begin:Menu link-->
                    <a class="menu-link {{Request::is('admin/home')?'active':''}}" href="{{route('admin.home')}}">
                        <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
											<span class="menu-title">Dashboards</span>
										</span>
                    </a>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <!--end:Menu sub-->
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Request::is(['admin/user/list', 'admin/user/add', 'admin/user/edit/*', 'admin/user/details/*'])?'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link" {{Request::is('admin/user/add')?'active':''}}">
											<span class="menu-icon">
												<i class="ki-outline ki-profile-user fs-2"></i>
											</span>
											<span class="menu-title">Users</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is('admin/user/list')?'active':''}}" href="{{route('admin.user.list')}}" title="User List" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Request::is(['admin/meter/list', 'admin/meter/add', 'admin/meter/edit/*', 'admin/meter/details/*'])?'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                    <span class="menu-icon">
												<i class="ki-outline ki-devices fs-2"></i>
											</span>
                    <span class="menu-title">Meters</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is('admin/meter/list')?'active':''}}" href="{{route('admin.meter.list')}}" title="Meter List" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Request::is(['admin/bill/list', 'admin/bill/add', 'admin/bill/edit/*', 'admin/bill/details/*'])?'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                    <span class="menu-icon">
												<i class="ki-outline ki-document fs-2"></i>
											</span>
                    <span class="menu-title">Bills</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is('admin/bill/list')?'active':''}}" href="{{route('admin.bill.list')}}" title="Bill List" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Request::is(['admin/bill/list', 'admin/bill/add', 'admin/bill/edit/*', 'admin/bill/details/*'])?'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                    <span class="menu-icon">
												<i class="ki-outline ki-truck fs-2"></i>
											</span>
                    <span class="menu-title">Tankers</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is('admin/bill/list')?'active':''}}" href="#" title="Bill List" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Request::is(['admin/bill-settings/list', 'admin/role/list', 'admin/role/add', 'admin/role/list/*', 'admin/role/edit/*'])?'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                    <span class="menu-icon">
												<i class="ki-outline ki-setting-2 fs-2"></i>
											</span>
                    <span class="menu-title">Admin Settings</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is(['admin/role/list', 'admin/role/add', 'admin/role/list/*', 'admin/role/edit/*'])?'active':''}}" href="{{route('admin.role.list')}}" title="Roles" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">Role Management</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{Request::is('admin/bill-settings/list')?'active':''}}" href="{{route('admin.bill-settings.list')}}" title="Bill setting List" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">Bill Settings</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    </div>
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
            <!--begin::Teames-->

            <!--end::Teames-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
