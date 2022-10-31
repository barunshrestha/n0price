<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 9 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>NoPrice | Signup Page</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('css/pages/login/classic/login-3.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
                style="background-image: url('{{ asset('media/bg/bg-11.jpg') }}');">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-6">
                        <a href="#">
                            {{-- Logo here --}}
                        </a>
                    </div>

                    <div class="login-signin">
                        <div class="mb-20">
                            <h3 class="text-muted font-weight-bold">Sign Up</h3>

                            <div class="text-muted font-weight-bold">Enter your details to create your account</div>

                        </div>
                        <form class="form" action="{{ route('register') }}" method="POST">
                            @if (session('fail'))
                                <div class="alert alert-danger d-flex" role="alert">
                                    <div class="alert-text">{!! session('fail') !!}</div>
                                    <div class="alert-close ml-auto">
                                        <i class="flaticon2-cross kt-icon-sm text-white" data-dismiss="alert"></i>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success d-flex" role="alert">
                                    <div class="alert-text">{!! session('success') !!}</div>
                                    <div class="alert-close ml-auto">
                                        <i class="flaticon2-cross kt-icon-sm text-white" data-dismiss="alert"></i>
                                    </div>
                                </div>
                                @endif
                                @csrf
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8 @error('name')is-invalid @enderror" type="text"
                                    placeholder="Fullname" name="name" />                                
                                @error('name')
                                <div class="d-flex mt-2 invalid-feedback">
                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                    <div class="text-danger mx-3"> {{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8 @error('email')is-invalid @enderror" type="text"
                                    placeholder="Email" name="email" autocomplete="off" />
                                    @error('email')
                                <div class="d-flex mt-2 invalid-feedback">
                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                    <div class="text-danger mx-3"> {{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8 @error('password')is-invalid @enderror" type="password"
                                    placeholder="Password" name="password" />
                                    @error('password')
                                    <div class="d-flex mt-2 invalid-feedback">
                                        <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                        <div class="text-danger mx-3"> {{ $message }}</div>
                                    </div>
                                    @enderror
                            </div>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                    placeholder="Confirm Password" name="rpassword" />
                            </div>

                            <div class="form-group d-flex flex-wrap flex-center mt-10">
                                <button id="kt_login_signup_submit"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
                            </div>
                        </form>
                        <div class="mt-10">
                            <span class="text-muted font-weight-bold">Already have an account ?</span>
                            <a href="/login" id="kt_login_signup"
                                class="text-muted text-hover-primary font-weight-bold">Login</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <script>
        var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('js/pages/custom/login/login.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script type="text/javascript">
        $('.password').on('copy paste cut', function(e) {
            e.preventDefault();
        })
    </script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>
