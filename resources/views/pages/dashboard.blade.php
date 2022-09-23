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
            width: 8em;
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
        let portfolio_datatable = $('#kt_datatable_portfolio').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "NO",
                    width: 46,
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
                {
                    field: "PROFIT/LOSS(TOTAL)",
                    width: 161,
                },
                {
                    field: "INVESTMENT",
                    width: 106,
                },
                {
                    field: "WORTH(CURRENT)",
                    width: 147,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_portfolio'),
                key: 'generalSearch'
            }
        });
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

        var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
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
                    field: "TICKER",
                    width: 200,
                },
                {
                    field: "TYPE",
                    width: 65,
                },
                {
                    field: "PURCHASE DATE",
                    width: 161,
                },
                {
                    field: "UNITS",
                    width: 106,
                },
                {
                    field: "PRICE(PER UNIT)",
                    width: 147,
                },

            ],

        });

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

        $(document).ready(function() {
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
                }
            );

        });

        function selectCoinFromCoinsList(event) {
            // var parent = event.currentTarget.parentElement;
            var parent = event.target.parentElement;

            // console.log(parent);


            $('#selected_coin').html(parent)
            $('#selected_coin').removeClass("hidden");
            $('#investment-description').removeClass("hidden");
            $('#hiddentable').addClass("hidden");
            $('#coin-search-bar').addClass('hidden');
            $('.coin-in-coin-list-button').addClass('hidden');

            var price_today = $('#selected_coin .coin_org_price').val();
            $('#purchase_price').val(price_today);
        }
    </script>
@endsection
