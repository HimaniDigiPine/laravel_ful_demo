<html lang="en">

    <!-- Head Start -->
    <head>

        <base href=""/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demo of Laravel Full Example</title>

        <link rel="shortcut icon" href="{{ asset('admin-assets/images/logos/favicon.ico') }}" />

        <!--begin::Fonts(mandatory for all pages)-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->

        <!--begin::Vendor Stylesheets(used for this page only)-->
        <link href="{{ asset('admin-assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Vendor Stylesheets-->

        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('admin-assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->

        <script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
            if (window.top !== window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
        

    </head>
    <!-- Head End -->


    <!-- Body Start -->
    <body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">

        <script>
            var defaultThemeMode = "light";
            var themeMode;

            if (document.documentElement) {
                if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if (localStorage.getItem("data-bs-theme") !== null) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }

                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
                        ? "dark"
                        : "light";
                }

                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>

        <!--begin::Root-->
        <div class="d-flex flex-column flex-root" id="kt_app_root">

            <!--end::Page bg image-->
            <style>
                body {
                    background-image: url("{{asset('admin-assets/images/auth/bg10.jpeg')}}");
                }

                [data-bs-theme="dark"] body {
                    background-image: url("{{asset('admin-assets/images/auth/bg10-dark.jpeg')}}");
                }
            </style>
            <!--end::Page bg image-->


            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">

                 <!--begin::Aside-->
                <div class="d-flex flex-lg-row-fluid">
                    <!--begin::Content-->
                    <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                        <!--begin::Image-->
                        <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('admin-assets/images/auth/agency.png')}}" alt="" />
                        <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('admin-assets/images/auth/agency-dark.png')}}" alt="" />
                        <!--end::Image-->
                        <!--begin::Title-->
                        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
                        <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                        <br />and provides some background information about
                        <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                        <br />work following this is a transcript of the interview.</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--begin::Aside-->

                <!--begin::Body-->
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                    <!--begin::Wrapper-->
                    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                        <!--begin::Content-->
                        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">

                            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                                <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form"  method="POST" action="{{ route('password.confirm') }}">
                                     @csrf
                                    <!--begin::Heading-->
                                    <div class="text-center mb-10">
                                        <!--begin::Title-->
                                        <h1 class="text-dark fw-bolder mb-3">Confirm Password ?</h1>
                                        <!--end::Title-->
                                        <!--begin::Link-->
                                        <div class="text-gray-500 fw-semibold fs-6">Please confirm your password before continuing.</div>
                                        <!--end::Link-->
                                    </div>
                                    <!--begin::Heading-->
                                    
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-8" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
                                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                    <i class="ki-duotone ki-eye-slash fs-2"></i>
                                                    <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <!--end::Input wrapper-->
                                            <!--begin::Meter-->
                                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                            </div>
                                            <!--end::Meter-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Hint-->
                                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Input group=-->

                                    
                                    <!--begin::Actions-->
                                    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                        <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                            <!--begin::Indicator label-->
                                            <span class="indicator-label">Confirm Password</span>
                                            <!--end::Indicator label-->
                                            <!--begin::Indicator progress-->
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            <!--end::Indicator progress-->
                                        </button>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                        <a href="../../demo1/dist/authentication/layouts/overlay/sign-in.html" class="btn btn-light">Cancel</a>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Footer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Languages-->
                                <div class="me-10">
                                    <!--begin::Toggle-->
                                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{asset('admin-assets/images/flags/united-states.svg')}}" alt="" />
                                        <span data-kt-element="current-lang-name" class="me-1">English</span>
                                        <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                                    </button>
                                    <!--end::Toggle-->
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('admin-assets/images/flags/united-states.svg')}}" alt="" />
                                                </span>
                                                <span data-kt-element="lang-name">English</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('admin-assets/images/flags/spain.svg')}}" alt="" />
                                                </span>
                                                <span data-kt-element="lang-name">Spanish</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('admin-assets/images/flags/germany.svg')}}" alt="" />
                                                </span>
                                                <span data-kt-element="lang-name">German</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('admin-assets/images/flags/japan.svg')}}" alt="" />
                                                </span>
                                                <span data-kt-element="lang-name">Japanese</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('admin-assets/images/flags/france.svg')}}" alt="" />
                                                </span>
                                                <span data-kt-element="lang-name">French</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Languages-->
                                <!--begin::Links-->
                                <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                    <a href="../../demo1/dist/pages/team.html" target="_blank">Terms</a>
                                    <a href="../../demo1/dist/pages/pricing/column.html" target="_blank">Plans</a>
                                    <a href="../../demo1/dist/pages/contact.html" target="_blank">Contact Us</a>
                                </div>
                                <!--end::Links-->
                            </div>
                            <!--end::Footer-->
                         </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Body-->

            </div>
            <!--end::Authentication - Sign-in-->

        </div>
        <!--end::Root-->

        <!--begin::Javascript-->
        <script>var hostUrl = "assets/";</script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
         <script src="{{asset('admin-assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{asset('admin-assets/js/scripts.bundle.js')}}"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{asset('admin-assets/js/custom/authentication/reset-password/reset-password.js')}}"></script>
        <!--end::Custom Javascript-->

        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <!--end::Javascript-->


    </body>
    <!-- Body End -->


</html>
<script>
$(document).ready(function () {

    if (typeof $.fn.validate !== "function") {
        console.error("jQuery Validate is not loaded");
        return;
    }

    $("#kt_password_reset_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Enter a valid email address"
            },
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form) {
            form.submit(); // allows normal form submission
        }
    });
});
</script>