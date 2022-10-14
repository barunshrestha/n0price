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
    @include('pages.transaction_add')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header card-header-tabs-line d-flex justify-content-end">
                    @if (Auth::user()->role_id == '2')
                        <ul class="nav nav-tabs nav-bold nav-tabs-line pe-5 row">
                            <li class="nav-item dropdown col-sm-12">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false" style="margin-right:5em;">
                                    {{ $user->name }}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item">Profiles</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="d-flex flex-column flex-root">
                    <!--begin::Login-->
                    <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">
                        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">
                            <div class="login-form text-center p-7 position-relative overflow-hidden">

                                <div class="login-signin">
                                    @if ($transaction_count == 0)
                                        <div class="mb-10">
                                            <h3 class="font-weight-bold">No Transactions added.</h3>
                                            <div class="font-weight-bold">Please add the transaction to continue to
                                                portfolio !
                                            </div>
                                        </div>
                                        <div class="mt-10">
                                            <button type="button" class="btn btn-primary mx-auto my-3" data-toggle="modal"
                                                data-target="#new_transaction_modal">
                                                <i class="flaticon2-plus"></i>
                                                Transaction</button>
                                        </div>
                                    @endif
                                    <div class="mt-10">
                                        Please define your portfolio risk level to continue to your portfolio.
                                        <form action="{{ route('percentage.allocation') }}" method="POST">
                                            @csrf
                                            <table class="table mt-5">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Market Capital</th>
                                                        <th scope="col">Risk</th>
                                                        <th scope="col">Allocation %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($asset_matrix_constraints as $constraints)
                                                        <tr style="background:<?php echo $constraints->color ?>;">
                                                            <td style="vertical-align: middle;">
                                                                {{ $constraints->market_cap }}</td>
                                                            <td style="vertical-align: middle;">{{ $constraints->risk }}
                                                            </td>
                                                            <td style="vertical-align: middle;"><input type="text"
                                                                    class="form-control" name="allocation_percentage[]"
                                                                    value="{{ $constraints->percentage_allocation }}"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-success btn-xs ml-auto allocationSaveBtn"
                                                    type="submit" data-toggle="tooltip" title="Submit">Save
                                                    <h6 class="fa fa-save"></h6>
                                                </button>
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
                                // console.log(data);
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
                            '"class="coin_org_symbol" /><input type="hidden" value="' + row.id +
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
                        // var price_today = $('#selected_coin .coin_org_price').val();
                        var quantity = $('#purchase_quantity').val();
                        var total_price = parseFloat(quantity) * parseFloat(price_today);
                        $('#purchase_price').val(total_price);
                    } else {
                        $('#purchase_price').val(0);
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
                    $('#purchase_price').val(total_price);
                }

            });

        });

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
                var round_usd = Number((usd_24h_change).toFixed(2));
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

            })
        }
    </script>
@endsection
