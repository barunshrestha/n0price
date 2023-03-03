{{-- Extends layout --}}
@extends('layout.default')
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
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
    </style>
@endsection
{{-- Content --}}
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <a href="{{ route('login') }}" class="btn btn-primary mb-3"><i class="fa fa-solid fa-arrow-left"></i>Back</a>
    <div class="card card-custom">
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                    <span class="font-weight-bolder text-dark">Portfolio</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">{{ count($wallet_list) }} wallets</span>
                    <input type="hidden" id="all_wallet_address" value="{{ $wallet_address }}">
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal"
                        data-target="#my_wallet_addresses">
                        <i class="flaticon-upload"></i>
                        My Wallet</button>
                </div>
            </div>
            <div class="card-body pt-1">
                <div class="timeline timeline-6">
                    @foreach ($wallet_list as $item)
                        <div class="timeline-item align-items-start">
                            <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"></div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-success icon-xl"></i>
                            </div>
                            <div class="timeline-content d-flex">
                                <span class="font-weight-bolder text-dark-75 pl-3 font-size-lg"> {{ $item }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <h4 class="px-10 font-weight-bolder text-dark" id="total_holding_valuation"></h4>


            <div class="card-body">
                <div class="card d-none" id="error-box-api-rate-limit">
                    <p class="p-2 text-danger text-sm">There has been error in fetching data from API. Click here
                        to refresh.
                        <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                            Refresh
                        </button>
                    </p>
                </div>
                <div class="card" id="invalid_wallet_address_message">
                </div>

                <table class="table table-responsive w-100 d-block d-md-table table-bordered" style="width: 100%">

                    <thead>
                        <tr>
                            <th scope="col" colspan="2"></th>
                            <th scope="col" style="background: #e9fac8;color:black;text-align:center;">
                                &lt;25M
                            </th>
                            <th scope="col" style="background: #fff3bf;color:black;text-align:center;">
                                25M - 250M
                            </th>
                            <th scope="col" style="background: #d3f9d8;color:black;text-align:center;">
                                250M - 1B
                            </th>
                            <th scope="col" style="background: #ffd8a8;color:black;text-align:center;">
                                1B - 25B
                            </th>
                            <th scope="col" style="background: #ffa8a8;color:black;text-align:center;">
                                &gt;25B
                            </th>
                            <th style="text-align:center; border:none;" colspan="4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                Risk
                            </td>
                            <td style="text-align:center;">
                                Very High
                            </td>
                            <td style="text-align:center;">
                                High
                            </td>
                            <td style="text-align:center;">
                                Medium
                            </td>
                            <td style="text-align:center;">
                                Low
                            </td>
                            <td style="text-align:center;">
                                Very Low
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #ffffff;">Allocation%
                            </td>
                            <td style="text-align: right">
                                <span id="total_allocation" class="ml-auto">100.0</span>
                            </td>
                            <form action="http://localhost:8000/change_allocation" method="POST"></form>
                            <input type="hidden" name="_token" value="irdfKsob986txSDHekgj3bBTYfsACLEHMPgjIzPS"> <input
                                type="hidden" value="20" name="portfolio_id">
                            <input type="hidden" value="Original Portfolio" name="portfolio_name">
                            <td>
                                <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                    20%
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="20">
                            </td>
                            <td>
                                <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                    20%
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="20">
                            </td>
                            <td>
                                <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                    20%
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="20">
                            </td>
                            <td>
                                <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                    20%
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="20">
                            </td>
                            <td>
                                <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                    20%
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="20">
                            </td>
                            <td colspan="4" style="border: none;">
                                <div class="d-flex justify-content-left">
                                    <button class="btn btn-icon btn-success btn-xs allocationEditBtn" type="button"
                                        data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <button class="btn btn-icon btn-success btn-xs ml-2 allocationSaveBtn hidden"
                                        type="submit" data-toggle="tooltip" title="Submit">
                                        <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                To Allocate $
                            </td>
                            <td style="text-align: right;"><span id="toallocate-veryhigh"></span></td>
                            <td style="text-align: right;"><span id="toallocate-high"></span></td>
                            <td style="text-align: right;"><span id="toallocate-medium"></span></td>
                            <td style="text-align: right;"><span id="toallocate-low"></span></td>
                            <td style="text-align: right;"><span id="toallocate-verylow"></span></td>

                        </tr>
                        <tr>

                            <td colspan="2">
                                Allocated
                            </td>
                            <td style="text-align: right;"><span id="allocated-veryhigh"></span></td>
                            <td style="text-align: right;"><span id="allocated-high"></span></td>
                            <td style="text-align: right;"><span id="allocated-medium"></span></td>
                            <td style="text-align: right;"><span id="allocated-low"></span></td>
                            <td style="text-align: right;"><span id="allocated-verylow"></span></td>
                        </tr>
                        <tr>

                            <td colspan="2">
                                Reallocate
                            </td>
                            <td style="text-align: right;"><span id="not_allocated-veryhigh"></span></td>
                            <td style="text-align: right;"><span id="not_allocated-high"></span></td>
                            <td style="text-align: right;"><span id="not_allocated-medium"></span></td>
                            <td style="text-align: right;"><span id="not_allocated-low"></span></td>
                            <td style="text-align: right;"><span id="not_allocated-verylow"></span></td>
                            <td style="text-align: center;font-weight:bold;" colspan="4">Market</td>

                        </tr>
                    </tbody>

                    <tbody id="coin_worth_all_summary">
                        <tr>
                            <td colspan="11" style="text-align: center;" class="my-5">
                                <h4>
                                    Loading....
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="my_wallet_addresses" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card px-3 py-3 container card-custom" style="width: 100%">
                            <div class="card-header card-header-tabs-line">
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-bold nav-tabs-line row">

                                        <li class="nav-item col-sm-12 col-md-7">
                                            <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_wallet"
                                                id="transaction-btn">
                                                <span class="nav-icon mx-2"><i class="flaticon-piggy-bank"></i></span>
                                                <span class="nav-text">Wallet</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_csv" role="tabpanel"
                                        aria-labelledby="kt_tab_pane_csv">
                                        <form class="form" id="wallet_form"
                                            action="{{ route('loadDashboardWithoutLogin') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="card-body">
                                                <div id="wallet_address_collection">
                                                    @foreach ($wallet_list as $wallet_address)
                                                        <div class="input-group mb-3">
                                                            <input name="wallet_address[]" type="text"
                                                                class="form-control form-control-solid"
                                                                placeholder="Enter your wallet address" required
                                                                value="{{ $wallet_address }}" autocomplete="off" />
                                                            <button class="btn btn-icon btn-danger btn-sm mx-2"
                                                                type="button" onclick="removeWalletAddressField(this)">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="btn btn-icon btn-info btn-sm mx-2" type="button"
                                                    onclick="addWalletAddressField()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="card-body" id="maximum_wallet_capacity_error_box">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-primary font-weight-bold"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary font-weight-bold"
                                                    id="coin-save-transaction-btn">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.allocationEditBtn').click(function() {
                    pleaseLoginSweetAlert();
                });
                populateReturn();
            });

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
        </script>
    @endsection
