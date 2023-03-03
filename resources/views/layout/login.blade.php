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
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_3"
                                        id="home-page-link">
                                        <span class="nav-icon"><i class="flaticon-home-2"></i></span>
                                        <span class="nav-text">Home</span>
                                    </a>
                                </li>
                                <li class="nav-item col-sm-12 col-md-4">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_4" id="login-page-link"
                                        style="width: inherit;">
                                        <span class="nav-icon"><i class="flaticon-user"></i></span>
                                        <span class="nav-text">Sign in</span>
                                    </a>
                                </li>
                                <li class="nav-item col-sm-12 col-md-4">
                                    <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_2_4"
                                        id="signup-page-link" style="width: inherit;">
                                        <span class="nav-icon"><i class="flaticon-user-add"></i></span>
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
    <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
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

    <script>
        @if (session('action'))
            $(document).ready(function() {
                @if (session('action') == 'login')
                    $('#login-page-link')[0].click();
                @elseif (session('action') == 'signup')
                    $('#signup-page-link')[0].click();
                @endif
            });
        @endif
    </script>
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
                    populateReturn();
                    $('.allocationEditBtn').click(function() {
                        pleaseLoginSweetAlert();
                    });
                }
            });
        }

        function editWalletListModal() {
            // Get all input fields with name "wallet_address[]"
            $('.modal-backdrop').remove();
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
                    populateReturn();
                    $('.allocationEditBtn').click(function() {
                        pleaseLoginSweetAlert();
                    });
                }
            });
        }
    </script>
    <script type="text/javascript">
        function pleaseLoginSweetAlert() {
            swal.fire({
                title: "Login Alert",
                text: "Please login to access additional feature",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Proceed to login",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                }
            }).then(function(result) {
                if (result.hasOwnProperty('value')) {
                    window.location.replace("/login");
                }
            });
        }

        function populateReturn() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var wallet_list = $('#all_wallet_address').val();
            $.ajax({
                'url': '/calculate/wallet/0',
                'type': 'POST',
                'data': {
                    'wallet_address': wallet_list
                },
                success: function(result) {

                    $("#coin_worth_all_summary").html(result);
                    var api_rate_limit_flag = $('#api_rate_limit_flag').val();
                    if (api_rate_limit_flag == 1) {
                        $('#error-box-api-rate-limit').removeClass('d-none');
                    }
                    var invalid_wallet_addresses = $('#invalid_wallet_address_list').val();
                    if (invalid_wallet_addresses !== "") {
                        $("#invalid_wallet_address_message").html(
                            '<div class="alert alert-danger" role="alert">' +
                            'Invalid wallet address: ' +
                            invalid_wallet_addresses +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true"><i class="ki ki-close"></i></span></button></div>'
                        )
                    }
                    var verylow = $('.tabledata-verylow').map((_, el) => el.innerHTML).get();
                    var sum_verylow = 0;
                    verylow.forEach(element => {
                        var value = Number(element.replace(/,/g, '').replace(/\$/g, ''));
                        sum_verylow = sum_verylow + value;
                    });
                    var low = $('.tabledata-low').map((_, el) => el.innerHTML).get();
                    var sum_low = 0;
                    low.forEach(element => {
                        var value = Number(element.replace(/,/g, '').replace(/\$/g, ''));
                        sum_low = sum_low + value;
                    });
                    var medium = $('.tabledata-medium').map((_, el) => el.innerHTML).get();
                    var sum_medium = 0;
                    medium.forEach(element => {
                        var value = Number(element.replace(/,/g, '').replace(/\$/g, ''));
                        sum_medium = sum_medium + value;
                    });
                    var high = $('.tabledata-high').map((_, el) => el.innerHTML).get();
                    var sum_high = 0;
                    high.forEach(element => {
                        var value = Number(element.replace(/,/g, '').replace(/\$/g, ''));
                        sum_high = sum_high + value;
                    });
                    var veryhigh = $('.tabledata-veryhigh').map((_, el) => el.innerHTML).get();
                    var sum_veryhigh = 0;
                    veryhigh.forEach(element => {
                        var value = Number(element.replace(/,/g, '').replace(/\$/g, ''));
                        sum_veryhigh = sum_veryhigh + value;
                    });
                    var sign_sum_verylow = sum_verylow.toFixed(1);
                    var sign_sum_low = sum_low.toFixed(1);
                    var sign_sum_medium = sum_medium.toFixed(1);
                    var sign_sum_high = sum_high.toFixed(1);
                    var sign_sum_veryhigh = sum_veryhigh.toFixed(1);

                    $('#allocated-verylow').html(sign_sum_verylow >= 0 ? '$' + sign_sum_verylow.replace(
                        /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_sum_verylow)).replace(
                        /\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#allocated-low').html(sign_sum_low >= 0 ? '$' + sign_sum_low.replace(/\d(?=(\d{3})+\.)/g,
                        '$&,') : '-$' + String(Math.abs(sign_sum_low)).replace(/\d(?=(\d{3})+\.)/g,
                        '$&,'));
                    $('#allocated-medium').html(sign_sum_medium >= 0 ? '$' + sign_sum_medium.replace(
                        /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_sum_medium)).replace(
                        /\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#allocated-high').html(sign_sum_high >= 0 ? '$' + sign_sum_high.replace(
                        /\d(?=(\d{3})+\.)/g,
                        '$&,') : '-$' + String(Math.abs(sign_sum_high)).replace(/\d(?=(\d{3})+\.)/g,
                        '$&,'));
                    $('#allocated-veryhigh').html(sign_sum_veryhigh >= 0 ? '$' + sign_sum_veryhigh.replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_sum_veryhigh))
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,'));
                    var total_allocated = sum_verylow + sum_low + sum_medium + sum_high + sum_veryhigh;

                    var sign_total_allocated = total_allocated.toFixed(1);
                    // $('#total_holding_valuation').html(sign_total_allocated >= 0 ? 'Total : $' +
                    //     sign_total_allocated.replace(/\d(?=(\d{3})+\.)/g, '$&,') : 'Total : -$' + String(
                    //         Math
                    //         .abs(sign_total_allocated)).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

                    $('#total_holding_valuation').html('Total : $' + $('#total_worth_backend').val());

                    var allocation_percentage = $('.allocation-percentage').map((_, el) => el.innerHTML)
                        .get();
                    var total_allocation_percentage = 0;
                    $.each(allocation_percentage, function() {
                        total_allocation_percentage += parseInt(this, 10);
                    });
                    $('#total_allocation').html(total_allocation_percentage.toFixed(1));
                    if (total_allocation_percentage !== 100) {
                        $('#total_allocation').css('color', 'red');
                        $('#total_allocation').css('font-weight', 'bold');
                    }
                    //console.log("allocation_percentage " + allocation_percentage[0].replace(/[^0-9]/g,''));

                    var allocated_verylow = Number(allocation_percentage[4].replace(/[^0-9]/g, '')) *
                        total_allocated / 100;
                    var allocated_low = Number(allocation_percentage[3].replace(/[^0-9]/g, '')) *
                        total_allocated / 100;
                    var allocated_medium = Number(allocation_percentage[2].replace(/[^0-9]/g, '')) *
                        total_allocated / 100;
                    var allocated_high = Number(allocation_percentage[1].replace(/[^0-9]/g, '')) *
                        total_allocated / 100;
                    var allocated_veryhigh = Number(allocation_percentage[0].replace(/[^0-9]/g, '')) *
                        total_allocated /
                        100;

                    var sign_allocated_verylow = allocated_verylow.toFixed(1);
                    var sign_allocated_low = allocated_low.toFixed(1);
                    var sign_allocated_medium = allocated_medium.toFixed(1);
                    var sign_allocated_high = allocated_high.toFixed(1);
                    var sign_allocated_veryhigh = allocated_veryhigh.toFixed(1);
                    var sign_total_allocated = total_allocated.toFixed(1);

                    $('#toallocate-verylow').html(sign_allocated_verylow >= 0 ? '$' + sign_allocated_verylow
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(
                            sign_allocated_verylow))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#toallocate-low').html(sign_allocated_low >= 0 ? '$' + sign_allocated_low.replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_allocated_low))
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#toallocate-medium').html(sign_allocated_medium >= 0 ? '$' + sign_allocated_medium
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_allocated_medium))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#toallocate-high').html(sign_allocated_high >= 0 ? '$' + sign_allocated_high.replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_allocated_high))
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#toallocate-veryhigh').html(sign_allocated_veryhigh >= 0 ? '$' + sign_allocated_veryhigh
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(
                            sign_allocated_veryhigh))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#allocated-total').html(sign_total_allocated >= 0 ? '$' + sign_total_allocated.replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_total_allocated))
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,'));


                    var not_allocated_verylow = allocated_verylow - sum_verylow;
                    var not_allocated_low = allocated_low - sum_low;
                    var not_allocated_medium = allocated_medium - sum_medium;
                    var not_allocated_high = allocated_high - sum_high;
                    var not_allocated_veryhigh = allocated_veryhigh - sum_veryhigh;

                    var total_not_allocated = not_allocated_verylow + not_allocated_low +
                        not_allocated_medium +
                        not_allocated_high + not_allocated_veryhigh;

                    var sign_not_allocated_verylow = not_allocated_verylow.toFixed(1);
                    var sign_not_allocated_low = not_allocated_low.toFixed(1);
                    var sign_not_allocated_medium = not_allocated_medium.toFixed(1);
                    var sign_not_allocated_high = not_allocated_high.toFixed(1);
                    var sign_not_allocated_veryhigh = not_allocated_veryhigh.toFixed(1);
                    var sign_total_not_allocated = total_not_allocated.toFixed(1);

                    $('#not_allocated-verylow').html(sign_not_allocated_verylow >= 0 ? '$' +
                        sign_not_allocated_verylow.replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math
                            .abs(
                                sign_not_allocated_verylow)).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#not_allocated-low').html(sign_not_allocated_low >= 0 ? '$' + sign_not_allocated_low
                        .replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(sign_not_allocated_low))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#not_allocated-medium').html(sign_not_allocated_medium >= 0 ? '$' +
                        sign_not_allocated_medium
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(
                            sign_not_allocated_medium)).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#not_allocated-high').html(sign_not_allocated_high >= 0 ? '$' + sign_not_allocated_high
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(
                            sign_not_allocated_high))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#not_allocated-veryhigh').html(sign_not_allocated_veryhigh >= 0 ? '$' +
                        sign_not_allocated_veryhigh.replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math
                            .abs(sign_not_allocated_veryhigh)).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#not_allocated-total').html(sign_total_not_allocated >= 0 ? '$' +
                        sign_total_not_allocated
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') : '-$' + String(Math.abs(
                            sign_total_not_allocated))
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    sortTableasc(0);
                }
            });
        }


        function sortTableasc(column_id) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("coin_worth_all_summary");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("td")[column_id];
                    y = rows[i + 1].getElementsByTagName("td")[column_id];

                    //check if the two rows should switch place:

                    if (parseFloat((x.innerHTML).replace(/\$|M|\,|\%/g, '')) > parseFloat((y.innerHTML).replace(
                            /\$|M|\,|\%/g,
                            ''))) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;

                }
            }
            if (column_id == 0) {
                $('#market-cap-asc-desc').html('Market Cap  <i class="fa fa-sort" onclick="sortTabledesc(0)"></i>');
            }
            if (column_id == 7) {
                $('#return-asc-desc').html('Return <i class="fa fa-sort" onclick="sortTabledesc(7)"></i>');
            }
            if (column_id == 8) {
                $('#24hr-asc-desc').html('24hr <i class="fa fa-sort"onclick="sortTabledesc(8)"></i>');
            }
            if (column_id == 9) {
                $('#7d-asc-desc').html('7d <i class="fa fa-sort"onclick="sortTabledesc(9)"></i>');
            }
            if (column_id == 10) {
                $('#ath-asc-desc').html('ATH <i class="fa fa-sort"onclick="sortTabledesc(10)"></i>');
            }
        }

        function sortTabledesc(column_id) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("coin_worth_all_summary");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("td")[column_id];
                    y = rows[i + 1].getElementsByTagName("td")[column_id];

                    //check if the two rows should switch place:

                    if (parseFloat((x.innerHTML).replace(/\$|M|\,|\%/g, '')) < parseFloat((y.innerHTML).replace(
                            /\$|M|\,|\%/g, ''))) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;

                }
            }
            if (column_id == 0) {
                $('#market-cap-asc-desc').html('Market Cap <i class="fa fa-sort" onclick="sortTableasc(0)"></i>');
            }
            if (column_id == 7) {
                $('#return-asc-desc').html('Return <i class="fa fa-sort" onclick="sortTableasc(7)"></i>');
            }
            if (column_id == 8) {
                $('#24hr-asc-desc').html('24hr <i class="fa fa-sort"onclick="sortTableasc(8)"></i>');
            }
            if (column_id == 9) {
                $('#7d-asc-desc').html('7d <i class="fa fa-sort"onclick="sortTableasc(9)"></i>');
            }
            if (column_id == 10) {
                $('#ath-asc-desc').html('ATH <i class="fa fa-sort"onclick="sortTableasc(10)"></i>');
            }

        }

        function sortTabletextasc(column_id) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("coin_worth_all_summary");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("td")[column_id];
                    y = rows[i + 1].getElementsByTagName("td")[column_id];

                    //check if the two rows should switch place:

                    if ((x.innerHTML).toLowerCase() > (y.innerHTML).toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;

                }
            }
            if (column_id == 1) {
                $('#coin-asc-desc').html('Coin  <i class="fa fa-sort" onclick="sortTabletextdesc(1)"></i>');
            }

        }

        function sortTabletextdesc(column_id) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("coin_worth_all_summary");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("td")[column_id];
                    y = rows[i + 1].getElementsByTagName("td")[column_id];

                    //check if the two rows should switch place:

                    if ((x.innerHTML).toLowerCase() < (y.innerHTML).toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;

                }
            }
            if (column_id == 1) {
                $('#coin-asc-desc').html('Coin <i class="fa fa-sort" onclick="sortTabletextasc(1)"></i>');
            }
        }

        function addWalletAddressField() {
            var total_wallet_address = $('#wallet_address_collection').find($("input"));
            if (total_wallet_address.length < 5) {
                $('#wallet_address_collection').append('<div class="input-group mb-3">' +
                    '<input name="wallet_address[]" type="text"' +
                    'class="form-control form-control-solid"' +
                    'placeholder="Enter another wallet address" required ' +
                    'autocomplete="off" />' +
                    '<button class="btn btn-icon btn-danger btn-sm mx-2" type="button" ' +
                    'onclick="removeWalletAddressField(this)">' +
                    '<i class="fa fa-minus"></i>' +
                    '</button>' +
                    '</div>');
            } else {
                var error_msg = '<h6 class="bg-danger text-white p-4">You can only add 5 wallet address at max.</h6>';
                $('#maximum_wallet_capacity_error_box').html(error_msg);
            }
        }

        function removeWalletAddressField(elem) {
            var error_msg = '';
            $('#maximum_wallet_capacity_error_box').html(error_msg);
            $(elem).closest('.input-group').remove();
        }
    </script>
</body>
<!--end::Body-->

</html>
