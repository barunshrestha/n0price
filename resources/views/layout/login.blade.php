<html lang="en">

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>NoPrice | Login Page</title>
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
    <style>
        .card-custom-login {
            background: transparent !important;
        }

        .card-custom-login .card-header {
            border-bottom: none !important;
        }

        .coin_container .selection {
            margin-bottom: 1em;
        }

        .coin_container {
            display: flex;
        }

        .selection label {
            text-align: center;
            display: block;
            width: 7em;
            background-color: #42b4d6;
            border-radius: 12em;
            color: #ffffff;
            padding: 0.5em;
            cursor: pointer;
        }

        .coin_container .selection label:hover {
            background-color: #5fc0dc;
        }

        .coin_container .selection input[type=radio] {
            display: none;
        }

        .coin_container .selection input[type=radio]:checked~label {
            background-color: #f1592a;
        }

        .dropdown-image {
            height: 40px;
            width: 40px;
        }

        .icon-image {
            height: 25px;
            width: 25px;
        }


        .hidden {
            display: none !important;
        }

        .flexproperty {
            display: inline-flex;
        }

        #kt_datatable_coin_select tbody tr span {
            /* width:max-content !important; */
            width: 100% !important;
        }

        .gain-button {
            min-width: 8em;
        }

        #selected_coin span {
            width: 100% !important;
        }

        #coin_worth_all_summary tr td i {
            float: right;
        }

        #coin_worth_all_summary tr td i:hover {
            color: black;
        }

        @media screen and (min-width: 1287px) {
            .portfolio-table {
                display: inline-table;
            }
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #EBEDF3;
            font-size: 0.8em;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading bgi-size-cover bgi-position-top"
    style="background-image: url('{{ asset('media/bg/bg-11.jpg') }}');">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--begin::Main-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom-login card-custom">
                    <div class="card-header card-header-tabs-line justify-content-end">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-bold nav-tabs-line row">
                                <li class="nav-item col-sm-12 col-md-4">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_3">
                                        <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                        <span class="nav-text">Home</span>
                                    </a>
                                </li>
                                <li class="nav-item col-sm-12 col-md-4">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_4"
                                        style="width: inherit;">
                                        <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                        <span class="nav-text">Sign in</span>
                                    </a>
                                </li>
                                <li class="nav-item col-sm-12 col-md-4">
                                    <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_2_4"
                                        style="width: inherit;">
                                        <span class="nav-icon"><i class="flaticon2-drop"></i></span>
                                        <span class="nav-text">Sign up</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_tab_pane_1_3" role="tabpanel"
                                aria-labelledby="kt_tab_pane_1_3">
                                @include('layout.searchWallet-partials')
                            </div>
                            <div class="tab-pane fade show" id="kt_tab_pane_1_4" role="tabpanel"
                                aria-labelledby="kt_tab_pane_1_4">
                                @include('layout.login-partials')
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2_4">
                                @include('layout.signup-partials');
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script>
        function searchWallet() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var wallet_list = $('#wallet_address_at_search').val();
            $.ajax({
                'url': '{{ route('loadDashboardWithoutLogin') }}',
                'type': 'POST',
                'data': {
                    'wallet_address': wallet_list
                },
                success: function(result) {
                    $('#kt_tab_pane_1_3').html(result)
                }
            });
        }

        function editWalletListModal() {
            // Get all input fields with name "wallet_address[]"
            $('#modal-close-button').click();
            $('#modal-close-button').click();
            var walletAddresses = $("input[name='wallet_address[]']");

            // Create an array to store the values
            var walletAddressValues = [];

            // Loop through each input field and add its value to the array
            walletAddresses.each(function() {
                if ($(this).val().trim() !== '') {
                    // Remove the input field from the DOM
                    walletAddressValues.push($(this).val());
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Perform AJAX call to the backend
            $.ajax({
                type: "POST",
                'url': '{{ route('loadDashboardWithoutLogin') }}',
                data: {
                    'wallet_address': walletAddressValues
                },
                success: function(result) {
                    // Handle success response from backend
                    $('#kt_tab_pane_1_3').html(result)
                }
            });
        }
    </script>
</body>
<!--end::Body-->

</html>
