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

        .show {
            display: block;
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
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4" id="portfolio-btn">
                                    <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                    <span class="nav-text">Portfolio</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4" id="transaction-btn">
                                    <span class="nav-icon"><i class="flaticon2-drop"></i></span>
                                    <span class="nav-text">Transaction</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_4" id="assetmatrix-btn">
                                    <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                                    <span class="nav-text">Asset Matrix</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (Auth::user()->role_id == '2')
                        <ul class="nav nav-tabs nav-bold nav-tabs-line pe-5">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false" style="margin-right:5em;">
                                    {{ $user->name }}
                                </a>
                                <div class="dropdown-menu">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    @endif
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
                        <div class="tab-pane fade" id="kt_tab_pane_3_4" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">

                            @include('pages.dashboard-content.asset-matrix')
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
            setTimeout(() => {
                let portfolio_datatable = $('#kt_datatable_portfolio').KTDatatable({
                    data: {
                        saveState: {
                            cookie: false
                        }
                    },
                    columns: [{
                            field: "SN",
                            width: 50,
                        },
                        {
                            field: "SYMBOL",
                            width: 79,
                        },
                        {
                            field: "NAME",
                            width: 65,
                        },
                        {
                            field: "PRICE(CURRENT)",
                            width: 136,
                        },
                        {
                            field: "QUANTITY",
                            width: 91,
                        },
                    ],
                    search: {
                        input: $('#kt_datatable_search_query_portfolio'),
                        key: 'generalSearch'
                    }
                });

            }, 200);
            setTimeout(() => {
                var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
                    data: {
                        saveState: {
                            cookie: false
                        },
                        autoColumns: true
                    },
                    mobile: {
                        layout: 'compact'
                    },
                    search: {
                        input: $('#_portfolio_search_transaction'),
                        key: 'generalSearch'
                    },
                    columns: [{
                            field: "NO",
                            width: 46,
                        },
                        {
                            field: "SYMBOL",
                            width: 150,
                            sortable: false,
                        },
                        {
                            field: "TICKER",
                            width: 130,
                        },
                        {
                            field: "TYPE",
                            width: 90,
                        },
                        {
                            field: "PURCHASE DATE",
                            width: 180,
                        },
                        {
                            field: "UNITS",
                            width: 106,
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
                });
            }, 200);
            setTimeout(() => {
                var datatable_assetmatrix = $('#kt_datatable_assetmatrix').KTDatatable({
                    data: {
                        saveState: {
                            cookie: false
                        }
                    },

                    search: {
                        input: $('#portfolio_search_assetmatrix'),
                        key: 'generalSearch'
                    }
                });
            }, 200);




            // $('#portfolio-btn').click(function() {
            // });

            // $('#transaction-btn').click(function() {
            // });
            // $('#assetmatrix-btn').click(function() {
            // });

            var datatable = $('#kt_datatable_coin_select').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                pagination: false,
                search: {
                    input: $('#kt_coin_datatable_search_query'),
                    key: 'generalSearch'
                }
            });





            $('#kt_coin_datatable_search_query').click(
                function() {
                    $('#hiddentable').removeClass("hidden");
                }
            );
            $('#purchase_quantity').change(
                function() {
                    var selected_coin = $('#selected_coin .coin_org_symbol').val();
                    var price_today = $('#selected_coin .coin_org_price').val();
                    var quantity = $('#purchase_quantity').val();
                    var total_price = parseFloat(quantity) * parseFloat(price_today);
                    $('#purchase_price').val(total_price);
                });



            $('form').on('submit', function(event) {
                event.preventDefault();
                var all_id = this.id;
                id = all_id.split('-')[1];
                var investment_type = '#investment_type-' + id;
                var purchase_date = '#purchase_date-' + id;
                var units = '#units-' + id;
                var purchase_price = '#purchase_price-' + id;
                let details = {
                    investment_type: $(investment_type + ' .hide_before_edit').val(),
                    purchase_date: $(purchase_date + ' .hide_before_edit').val(),
                    units: $(units + ' .hide_before_edit').val(),
                    purchase_price: $(purchase_price + ' .hide_before_edit').val()
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
                        setTimeout(window.location.replace('/'), 6000);
                    } else {
                        $('.errorbox').html(
                            "<div class='p-4 bg-danger text-white'>Transaction couldnt be updated.</div>"
                        );
                        setTimeout(window.location.replace('/'), 6000);
                    }

                }).fail(function(xhr, ajaxOps, error) {
                    console.log('Failed: ' + error);
                });
            });
        });

        function selectCoinFromCoinsList(event) {
            var parent = event.target.parentElement;
            console.log(parent);
            $('#selected_coin').html(parent)
            $('#selected_coin').removeClass("hidden");
            $('#investment-description').removeClass("hidden");
            $('#hiddentable').addClass("hidden");
            $('#coin-search-bar').addClass('hidden');
            $('.coin-in-coin-list-button').addClass('hidden');

            var price_today = $('#selected_coin .coin_org_price').val();
            $('#purchase_price').val(price_today);
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
    </script>
@endsection
