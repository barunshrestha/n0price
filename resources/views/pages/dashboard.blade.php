{{-- Extends layout --}}
@extends('layout.default')
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('css/badge.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('css/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/> --}}

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


        @media screen and (min-width: 1287px) {
            .portfolio-table {
                display: inline-table;
            }
        }
    </style>
@endsection
{{-- Content --}}
@section('content')
    {{-- <div class="card card-custom" style="width: 100%">
        <div class="card-body">
            <!--begin::Search Form-->
            <div class="mt-2 mb-5 mt-lg-5 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-xl-12">
                        <div class="row align-items-center">
                            <div class="col-md-12 mt-2 mt-md-0">
                                <div class="input-icon" id="coin-search-bar">
                                    <input type="text" class="form-control" placeholder="Enter the investment type ..."
                                        id="kt_coin_datatable_search_query" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div id="selected_coin" class="card ">

                    </div>
                </div>
            </div>

            <div id="hiddentable" class="hidden">
                <table class="table table-hover" id="kt_datatable_coin_select" style="width: 100%">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($available_coins as $coin)
                            <tr>
                                <td class="coin-table-data">
                                    <?php
                                    $curr = "$coin->coin_id";
                                    $usd = $current_price->$curr->usd;
                                    $usd_24h_vol = $current_price->$curr->usd_24h_vol;
                                    $usd_24h_change = $current_price->$curr->usd_24h_change;
                                    ?>
                                    <div class="align-items-center d-flex">
                                        <img src="{{ $coin->image }}" alt="img" class="dropdown-image mx-2 ">
                                        <div class="mx-2">{{ strtoupper($coin->symbol) }}</div>
                                        <div class="mx-2">{{ ucfirst(trans($coin->name)) }}</div>
                                        <div class="mx-2">{{ $usd }}</div>
                                        <div class="mx-2">{{ round($usd_24h_change, 2) }}</div>
                                        <button type="button" onclick="selectCoinFromCoinsList(event)" class="btn btn-icon text-info btn-circle mr-2 coin-in-coin-list-button">
                                            <i class="flaticon-plus text-info"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

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
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script type="text/javascript">
        var portfolio_datatable = $('#kt_datatable_portfolio').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
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


        document.getElementById('portfolio-btn').onclick = function() {
            var portfolio_datatable = $('#kt_datatable_portfolio').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },

                search: {
                    input: $('#kt_datatable_search_query_portfolio'),
                    key: 'generalSearch'
                }
            });
        }
        document.getElementById('transaction-btn').onclick = function() {
            var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                search: {
                    input: $('#_portfolio_search_transaction'),
                    key: 'generalSearch'
                }
            });
        }
        document.getElementById('assetmatrix-btn').onclick = function() {
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
        }
        $(document).ready(function() {
            $('#kt_coin_datatable_search_query').click(
                function() {
                    $('#hiddentable').removeClass("hidden");
                }
            );
            // $('td').click(
            //     function() {
            //         // alert("clicked");
            //         // var parent = returnparent(event);
            //         // // $contents = event.target.parentElement;
            //         // // console.log(event.target.parentElement);
            //         // console.log(parent);

            //         // $('#selected_coin').html(parent)
            //         // $('#selected_coin').removeClass("hidden");
            //         // $('#investment-description').removeClass("hidden");
            //         // $('#hiddentable').addClass("hidden");
            //         // $('#coin-search-bar').addClass('hidden');
            //     }

            // );

            // function returnparent(event) {
            //     var target = event.currentTarget;
            //     var parent = target.parentElement;
            //     return parent;
            // }


            $('#purchase_quantity').change(
                function() {

                    var selected_coin = $('#selected_coin .coin_org_symbol').val();
                    // var org_date = $('#purchase_date').val();
                    // let currentDate = new Date().toJSON().slice(0, 10);

                    // if (org_date == currentDate) {

                    //     var quantity = $('#purchase_quantity').val();
                    //     console.log("q",quantity);
                    //     console.log("p",price_today);
                    //     var total_price_today = Number(quantity) * Number(price_today);
                    //     console.log(total_price_today);
                    //     $('#purchase_price').val(total_price_today);
                    //     // var ab = $('#selected_coin *.usd-price').val();
                    //     // $('#purchase_price').val(req_data);
                    // } else {


                    // var date = org_date.split('-').reverse().join('-');
                    // var date = reverseString($('#purchase_date').val());
                    // var url = "https://api.coingecko.com/api/v3/coins/" + selected_coin + "/history?date=" +
                    //     date + "&localization=false&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX";
                    // let fetchRes = fetch(url);
                    // fetchRes.then(res =>
                    //     res.json()).then(data => {
                    //     // console.log(data);
                    //     var req_data = data['market_data']['current_price']['usd'];
                    //     var quantity = $('#purchase_quantity').val();
                    //     var total_price = Number(quantity) * Number(req_data);
                    //     $('#purchase_price').val(total_price);

                    // })
                    // }
                    var price_today = $('#selected_coin .coin_org_price').val();
                    // var req_data = data['market_data']['current_price']['usd'];
                    var quantity = $('#purchase_quantity').val();
                    var total_price = parseFloat(quantity) * parseFloat(price_today);
                    $('#purchase_price').val(total_price);


                }
            );


        });

        function selectCoinFromCoinsList(event) {
            var parent = event.currentTarget.parentElement;

            // console.log(parent);


            $('#selected_coin').html(parent)
            $('#selected_coin').removeClass("hidden");
            $('#investment-description').removeClass("hidden");
            $('#hiddentable').addClass("hidden");
            $('#coin-search-bar').addClass('hidden');
            $('.coin-in-coin-list-button').addClass('hidden');

            // var price_today = 
            var price_today = $('#selected_coin .coin_org_price').val();
            $('#purchase_price').val(price_today);
        }
    </script>
@endsection
