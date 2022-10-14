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

                           <form method="POST" action="{{ route('password.update') }}">
                               @csrf

                               <!-- Password Reset Token -->
                               <input type="hidden" name="token" value="{{ $request->route('token') }}">

                               <!-- Email Address -->
                               <div>
                                   <label>Email</label>

                                   <input id="email" class="block mt-1 w-full" type="email" name="email"
                                       value={{ $request->email }} required autofocus />
                               </div>

                               <!-- Password -->
                               <div class="mt-4">
                                   <label>Password</label>

                                   <input  id="password" class="block mt-1 w-full" type="password"
                                       name="password" required />
                               </div>

                               <!-- Confirm Password -->
                               <div class="mt-4">
                                   <label>Confirm Password</label>

                                   <input id="password_confirmation" class="block mt-1 w-full" type="password"
                                       name="password_confirmation" required />
                               </div>

                               <div class="flex items-center justify-end mt-4">
                                   <button class="btn btn-primary">
                                       Reset Password
                                   </button>

                               </div>
                           </form>

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
