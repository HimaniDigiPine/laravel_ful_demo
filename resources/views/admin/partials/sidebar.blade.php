<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

	<!--begin::Logo-->
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<!--begin::Logo image-->
		<a href="">
			<img alt="Logo" src="{{ asset('admin-assets/images/logos/default-dark.svg') }}" class="h-25px app-sidebar-logo-default" />
			<img alt="Logo" src="{{ asset('admin-assets/images/logos/default-small.svg') }}" class="h-20px app-sidebar-logo-minimize" />
		</a>
		<!--end::Logo image-->
		<!--begin::Sidebar toggle-->
		<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
			<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Sidebar toggle-->
	</div>
	<!--end::Logo-->

	<!--begin::sidebar menu-->
	<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
		<!--begin::Menu wrapper-->
		<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
			<!--begin::Scroll wrapper-->
			<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

				<!--begin::Menu-->
				<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
					

					@if(in_array(auth()->user()->role, ['admin', 'staff']))
					<!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('home') }}">
	                        <span class="menu-icon">
		                        <i class="ki-duotone ki-code fs-2">
			                        <span class="path1"></span>
			                        <span class="path2"></span>
			                        <span class="path3"></span>
			                        <span class="path4"></span>
		                        </i>
	                        </span>
	                        <span class="menu-title">Dashboard</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item--> 

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('admin.categories.index') }}">
	                        <span class="menu-icon">
		                        <i class="ki-duotone ki-code fs-2">
			                        <span class="path1"></span>
			                        <span class="path2"></span>
			                        <span class="path3"></span>
			                        <span class="path4"></span>
		                        </i>
	                        </span>
	                        <span class="menu-title">Category</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item--> 

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('admin.subcategories.index') }}">
	                        <span class="menu-icon">
		                        <i class="ki-duotone ki-code fs-2">
			                        <span class="path1"></span>
			                        <span class="path2"></span>
			                        <span class="path3"></span>
			                        <span class="path4"></span>
		                        </i>
	                        </span>
	                        <span class="menu-title">SubCategory</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item--> 

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('admin.products.index') }}">
	                        <span class="menu-icon">
		                        <i class="ki-duotone ki-code fs-2">
			                        <span class="path1"></span>
			                        <span class="path2"></span>
			                        <span class="path3"></span>
			                        <span class="path4"></span>
		                        </i>
	                        </span>
	                        <span class="menu-title">Product</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item--> 

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('admin.galleries.index') }}">
	                        <span class="menu-icon">
		                        <i class="ki-duotone ki-code fs-2">
			                        <span class="path1"></span>
			                        <span class="path2"></span>
			                        <span class="path3"></span>
			                        <span class="path4"></span>
		                        </i>
	                        </span>
	                        <span class="menu-title">Galleries</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item--> 

                    @endif

                    <ul class="menu-nav">
					    @if(in_array(auth()->user()->role, ['admin']))
					        <li class="menu-item">
					            <a href="{{ route('hello.admin') }}" class="menu-link">
					                <span class="menu-text">Hello Admin</span>
					            </a>
					        </li>
					    @endif

					    @if(in_array(auth()->user()->role, ['admin', 'staff']))
					        <li class="menu-item">
					            <a href="{{ route('hello.staff') }}" class="menu-link">
					                <span class="menu-text">Hello Staff</span>
					            </a>
					        </li>
					    @endif

					    @if(in_array(auth()->user()->role, ['admin', 'staff', 'user']))
					        <li class="menu-item">
					            <a href="{{ route('hello.user') }}" class="menu-link">
					                <span class="menu-text">Hello User</span>
					            </a>
					        </li>
					    @endif
					</ul>

				</div>
				<!--end::Menu-->

			</div>
			<!--end::Scroll wrapper-->
		</div>
		<!--end::Menu wrapper-->
	</div>
	<!--end::sidebar menu-->

	<!--begin::Footer-->
	<div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
		<a href="https://preview.keenthemes.com/html/metronic/docs" class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
			<span class="btn-label">Docs & Components</span>
			<i class="ki-duotone ki-document btn-icon fs-2 m-0">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</a>
	</div>
	<!--end::Footer-->


</div>
<!--end::Sidebar-->					
					
