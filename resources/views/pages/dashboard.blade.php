{{-- Extends layout --}}
@extends('layout.default')
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />

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

        @media screen and (min-width: 1287px) {
            .portfolio-table {
                display: inline-table;
            }
        }
    </style>
@endsection
{{-- Content --}}

@section('content')
    <input type="hidden" id="dashboard-portfolio-id" value="{{ $portfolio_details->id }}" name="portfolio_id">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="errorbox">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line row">
                            <li class="nav-item col-sm-12 col-md-5">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4" id="portfolio-btn">
                                    <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                    <span class="nav-text">Portfolio</span>
                                </a>
                            </li>
                            <li class="nav-item col-sm-12 col-md-7">
                                <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_2_4" id="transaction-btn">
                                    <span class="nav-icon"><i class="flaticon2-drop"></i></span>
                                    <span class="nav-text">Transaction</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item col-sm-12 col-md-5">
                                <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_3_4" id="assetmatrix-btn">
                                    <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                                    <span class="nav-text">Asset Matrix</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel"
                            aria-labelledby="kt_tab_pane_1_4">

                            @include('pages.dashboard-content.portfolio')
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">

                            @include('pages.dashboard-content.transaction')
                        </div>
                        {{-- <div class="tab-pane fade" id="kt_tab_pane_3_4" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">

                            @include('pages.dashboard-content.asset-matrix')
                        </div> --}}

                    </div>
                    @include('pages.transaction_add')
                    @include('pages.dashboard-content.transaction_excel_import')
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
                $('.allocationEditBtn').addClass('hidden');
                $('.hideBeforeedit').removeClass('hidden');
                $('.hideAfteredit').addClass('hidden');
                $('.allocationSaveBtn').removeClass('hidden');
            });

            dashboard_portfolio_id = $('#dashboard-portfolio-id').val();

            $('#transaction-btn').click(function() {
                load_portfolio_transactions();
            });

            var coin_datatable = $('#kt_datatable_coin_select').KTDatatable({
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '/get/all/coins',
                            contentType: 'application/json',
                            params: {
                                generalSearch: '',
                            },
                            map: function(data) {
                                return data.data;
                            }
                        }
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                    saveState: {
                        cookie: false
                    }
                },
                columns: [{
                    field: "title",
                    template: function(row) {
                        return '<div onclick="selectCoinFromCoinsList(event)">' +
                            '<div class="coin-table-data">' +
                            '<div class="align-items-center d-flex">' +
                            '<img src="' +
                            row.image +
                            '" alt="img" class="dropdown-image mx-2 "><div class="mx-2 font-weight-bold">' +
                            row.name + '</div><input type="hidden" value="' + row.coin_id +
                            '"class="coin_org_symbol" name="symbol" /><input type="hidden" value="' + row.id +
                            '"class="coin_table_id" name="coin_id" /><div class="align-items-center d-flex ml-auto price_and_gain"></div></div></div></div>';
                    },
                    width: 130,
                }],

                search: {
                    input: $('#kt_coin_datatable_search_query'),
                    key: 'generalSearch'
                },

            });

            $('#kt_coin_datatable_search_query').click(
                function() {
                    $('#hiddentable').removeClass("hidden");
                }
            );

            $('#purchase_quantity').change(
                function() {
                    var org_date = $('#purchase_date').val();
                    let currentDate = new Date().toJSON().slice(0, 10);
                    if (org_date == currentDate) {
                        var selected_coin = $('#selected_coin .coin_org_symbol').val();
                        var quantity = $('#purchase_quantity').val();
                        if (quantity < 0) {
                            $('#coin-save-transaction-btn').prop('disabled', true);
                            $('#selected-coin-error-box').html(
                                '<p class="bg-danger p-2 text-white text-sm">Please enter valid purchase quantity</p>'
                            );
                        } else {
                            $('#coin-save-transaction-btn').prop('disabled', false);
                            $('#selected-coin-error-box').html('');
                            var total_price = parseFloat(quantity) * parseFloat(price_today);
                            //$('#purchase_price').val(total_price.toFixed(2));
                            //$("#total_price_label").html(' $'+total_price.toFixed(2));
                            // $("#total_price_label").html(total_price.toLocaleString('en-US', {
                            // style: 'currency',
                            // currency: 'USD',
                            // })); 
                        }
                    } else {
                        $('#purchase_price').val(0);
                    }

                });
            $('#purchase_price').change(function() {
                var total_price = $('#purchase_price').val();
                if (total_price < 0) {
                    $('#coin-save-transaction-btn').prop('disabled', true);
                    $('#selected-coin-error-box').html(
                        '<p class="bg-danger p-2 text-white text-sm">Please enter valid purchase amount</p>'
                    );

                } else {
                    var quantity = $('#purchase_quantity').val();
                    if (quantity < 0) {
                        $('#coin-save-transaction-btn').prop('disabled', true);
                        $('#selected-coin-error-box').html(
                            '<p class="bg-danger p-2 text-white text-sm">Please enter valid purchase quantity</p>'
                        );
                    } else {
                        $('#selected-coin-error-box').html('');
                        $('#coin-save-transaction-btn').prop('disabled', false);
                    }
                }
            });

            $('#purchase_date').change(function() {
                var org_date = $('#purchase_date').val();
                let currentDate = new Date().toJSON().slice(0, 10);
                if (org_date != currentDate) {
                    $('#purchase_price').val(0);
                } else {
                    var quantity = $('#purchase_quantity').val();
                    var total_price = parseFloat(quantity) * parseFloat(price_today);
                    $('#purchase_price').val(total_price.toFixed(2));
                }

            });
            populateReturn();
        });
        // $.ajax({
        //     url: "{{ route('portfolio_summary') }}",
        //     success: function(result) {
        //         $("#portfolio_summary").html(result);
        //     }
        // });

        load_portfolio_transactions();

        function load_portfolio_transactions() {
            if (typeof dashboard_portfolio_id !== 'undefined') {} else {
                dashboard_portfolio_id = 0;
            }
            $.ajax({
                'url': '/dashboardTransactionPartials/' + dashboard_portfolio_id,
                'type': 'GET',
                success: function(result) {
                    $("#dashboard-transaction-partials").html(result);
                    var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
                        data: {
                            saveState: {
                                cookie: false
                            }
                        },

                        columns: [{
                                field: "SYMBOL",
                                width: 60,
                                sortable: false,
                            },
                            {
                                field: "TICKER",
                                width: 65,
                                overflow: 'visible'
                            },
                            {
                                field: "TYPE",
                                width: 80,
                            },
                            {
                                field: "DATE",
                                width: 160,
                            },
                            {
                                field: "UNITS",
                                width: 60,
                            },
                            {
                                field: "PRICE(PER UNIT)",
                                width: 147,
                            },
                            {
                                field: "ACTIONS",
                                width: 147,
                            },
                        ],
                        search: {
                            input: $('#_portfolio_search_transaction'),
                            key: 'generalSearch'
                        },


                    });
                    datatable_transactions.sort('SYMBOL', 'asc');
                }
            });
        }

        function populateReturn() {
            $.ajax({
                'url': '/return_calculation/' + dashboard_portfolio_id,
                'type': 'GET',
                success: function(result) {
                    $("#coin_worth_all_summary").html(result);
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
                    $('#total_holding_valuation').html(sign_total_allocated >= 0 ? 'Total : $' +
                        sign_total_allocated.replace(/\d(?=(\d{3})+\.)/g, '$&,') : 'Total : -$' + String(
                            Math
                            .abs(sign_total_allocated)).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

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


                    var not_allocated_verylow = sum_verylow - allocated_verylow;
                    var not_allocated_low = sum_low - allocated_low;
                    var not_allocated_medium = sum_medium - allocated_medium;
                    var not_allocated_high = sum_high - allocated_high;
                    var not_allocated_veryhigh = sum_veryhigh - allocated_veryhigh;

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
                }
            });
        }


        function selectCoinFromCoinsList(event) {
            var parent = event.target.parentElement;

            $('#selected_coin').html(parent)
            $('#selected_coin').removeClass("hidden");
            $('#investment-description').removeClass("hidden");
            $('#hiddentable').addClass("hidden");
            $('#coin-search-bar').addClass('hidden');
            $('.coin-in-coin-list-button').addClass('hidden');
            $('.modal.fade.show').css('display', 'flex');


            var coin_id = $('#selected_coin .coin_org_symbol').val();
            const url = 'https://pro-api.coingecko.com/api/v3/simple/price?ids=' + coin_id +
                '&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX';

            // console.log(curr);
            let fetchRes = fetch(url);
            fetchRes.then(res =>
                res.json()).then(data => {
                console.log(data);
                price_today = data[Object.keys(data)[0]].usd;
                var usd_24h_change = data[Object.keys(data)[0]].usd_24h_change ? data[Object.keys(data)[0]]
                    .usd_24h_change : 0;
                var round_usd = Number((usd_24h_change).toFixed(1));
                if (usd_24h_change > 0) {
                    $('#selected_coin .price_and_gain').html(
                        '<div class="mx-2 font-weight-bold usd-price"><div class="mx-2 ml-5"><span class="text-success font-weight-bold gain-button"> ' +
                        round_usd + '% <i class="text-success flaticon2-arrow-up"></i></span></div></div>');
                } else if (usd_24h_change < 0) {
                    $('#selected_coin .price_and_gain').html(
                        '<div class="mx-2 font-weight-bold usd-price"><div class="mx-2 ml-5"><span class="text-danger font-weight-bold gain-button"> ' +
                        round_usd + '% <i class="text-danger flaticon2-arrow-down"></i></span></div></div>');
                } else {
                    $('#selected_coin .price_and_gain').html(
                        '<div class="mx-2 font-weight-bold usd-price"><div class="mx-2 ml-5"><span class="text-dark font-weight-bold gain-button"> ' +
                        round_usd + '% <i class="text-dark flaticon2-hexagonal"></i></span></div></div>');
                }
                $('#purchase_price').val(price_today);
                //$('#purchase_quantity').trigger('change');

            })
        }


        function transactionEditBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var investment_type = '#investment_type-' + id;
            var purchase_date = '#purchase_date-' + id;
            var units = '#units-' + id;
            var purchase_price = '#purchase_price-' + id;
            var transaction_action_buttons = '#transaction_action_buttons-' + id;

            $(investment_type + ' .hide_before_edit').removeClass('hidden');
            $(purchase_date + ' .hide_before_edit').removeClass('hidden');
            $(units + ' .hide_before_edit').removeClass('hidden');
            $(purchase_price + ' .hide_before_edit').removeClass('hidden');
            $(transaction_action_buttons + ' .hide_before_edit').removeClass('hidden');

            $(investment_type + ' .hide_after_edit').addClass('hidden');
            $(purchase_date + ' .hide_after_edit').addClass('hidden');
            $(units + ' .hide_after_edit').addClass('hidden');
            $(purchase_price + ' .hide_after_edit').addClass('hidden');
            $(transaction_action_buttons + ' .hide_after_edit').addClass('hidden');
        }

        function transactionDiscardBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var investment_type = '#investment_type-' + id;
            var purchase_date = '#purchase_date-' + id;
            var units = '#units-' + id;
            var purchase_price = '#purchase_price-' + id;
            var transaction_action_buttons = '#transaction_action_buttons-' + id;

            $(investment_type + ' .hide_before_edit').addClass('hidden');
            $(purchase_date + ' .hide_before_edit').addClass('hidden');
            $(units + ' .hide_before_edit').addClass('hidden');
            $(purchase_price + ' .hide_before_edit').addClass('hidden');
            $(transaction_action_buttons + ' .hide_before_edit').addClass('hidden');

            $(investment_type + ' .hide_after_edit').removeClass('hidden');
            $(purchase_date + ' .hide_after_edit').removeClass('hidden');
            $(units + ' .hide_after_edit').removeClass('hidden');
            $(purchase_price + ' .hide_after_edit').removeClass('hidden');
            $(transaction_action_buttons + ' .hide_after_edit').removeClass('hidden');
        }

        function transactionsaveBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var investment_type = '#investment_type-' + id;
            var purchase_date = '#purchase_date-' + id;
            var units = '#units-' + id;
            var purchase_price = '#purchase_price-' + id;
            let details = {
                investment_type: $(investment_type + ' .hide_before_edit').val(),
                purchase_date: $(purchase_date + ' .hide_before_edit').val(),
                units: $(units + ' .hide_before_edit').val(),
                purchase_price: $(purchase_price + ' .hide_before_edit').val(),
                portfolio_id: dashboard_portfolio_id
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': '/transactions/' + id,
                'type': 'PUT',
                'dataType': 'json',
                'data': details,
            }).done(function(response) {
                if (response.success == true) {
                    $('.errorbox').html(
                        "<div class='p-4 bg-success text-white'>Transaction has been updated.</div>"
                    );
                    $('#transaction-btn').click();

                    setTimeout(removeerrbox, 3000);

                    function removeerrbox() {
                        $('.errorbox').html("")
                    }

                } else {
                    $('.errorbox').html(
                        "<div class='p-4 bg-danger text-white'>Transaction couldnt be updated.</div>"
                    );
                    $('#transaction-btn').click();
                    setTimeout(removeerrbox, 3000);

                    function removeerrbox() {
                        $('.errorbox').html("")
                    }
                }
                populateReturn();
            }).fail(function(xhr, ajaxOps, error) {
                console.log('Failed: ' + error);
            });
        }
        // function get_profit_data() {
        //     $.ajax({
        //         'url': '/profit_calc',
        //         'type': 'GET',
        //         'dataType': 'json',
        //     }).done(function(response) {
        //         if (response.success == true) {
        //             // console.log(response.data);
        //             var profit_data = response.data;
        //             profit_data.forEach(element => {
        //                 var class_name = element[0] + "-profit"
        //                 if (element[1] > 0) {
        //                     var html =
        //                         '<span class=" text-success font-weight-bold gain-button\">' +
        //                         element[1] + ' USD </span>';
        //                 } else {
        //                     var html =
        //                         '<span class=" text-danger font-weight-bold gain-button\">' +
        //                         element[1] + ' USD </span>';
        //                 }
        //                 $('.' + class_name).html(html);
        //                 // console.log("classname",$('.'class_name).val());
        //             });
        //         } else {
        //             console.error(response.data);

        //         }
        //     }).fail(function(xhr, ajaxOps, error) {
        //         console.log('Failed: ' + error);
        //     });
        // }

        function deleteTransaction(tid) {
            swal.fire({
                title: "Delete!",
                text: "Are you sure you want to delete this transaction?",
                icon: "question",
                buttonsStyling: false,
                confirmButtonText: "Yes I'm sure",
                showCancelButton: true,
                cancelButtonText: "No",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-default"
                }
            }).then(function(result) {
                if (result.hasOwnProperty('value')) {
                    $.ajax({
                        url: "{{ route('destroymyTransaction') }}",
                        type: "POST",
                        data: {
                            id: tid
                        },
                        success: function(result) {
                            $('.errorbox').html(
                                "<div class='p-4 bg-success text-white'>Transaction has been deleted.</div>"
                            );
                            $('#transaction-btn').click();
                            populateReturn();
                            setTimeout(removeerrbox, 3000);

                            function removeerrbox() {
                                $('.errorbox').html("")
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    // var form_id = "deleteMyTransaction-" + tid;
                    // $("#" + form_id).submit();
                }
            });
        }
    </script>
@endsection
