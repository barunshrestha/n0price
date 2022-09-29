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


            var verylow = $('.tabledata-verylow').map((_, el) => el.innerHTML).get();
            var sum_verylow = 0;
            verylow.forEach(element => {
                var value = Number(element);
                sum_verylow = sum_verylow + value;
            });
            var low = $('.tabledata-low').map((_, el) => el.innerHTML).get();
            var sum_low = 0;
            low.forEach(element => {
                var value = Number(element);
                sum_low = sum_low + value;
            });
            var medium = $('.tabledata-medium').map((_, el) => el.innerHTML).get();
            var sum_medium = 0;
            medium.forEach(element => {
                var value = Number(element);
                sum_medium = sum_medium + value;
            });
            var high = $('.tabledata-high').map((_, el) => el.innerHTML).get();
            var sum_high = 0;
            high.forEach(element => {
                var value = Number(element);
                sum_high = sum_high + value;
            });
            var veryhigh = $('.tabledata-veryhigh').map((_, el) => el.innerHTML).get();
            var sum_veryhigh = 0;
            veryhigh.forEach(element => {
                var value = Number(element);
                sum_veryhigh = sum_veryhigh + value;
            });

            $('#allocated-verylow').html(sum_verylow.toFixed(2));
            $('#allocated-low').html(sum_low.toFixed(2));
            $('#allocated-medium').html(sum_medium.toFixed(2));
            $('#allocated-high').html(sum_high.toFixed(2));
            $('#allocated-veryhigh').html(sum_veryhigh.toFixed(2));
            var total_allocated = sum_verylow + sum_low + sum_medium + sum_high + sum_veryhigh;

            var allocation_percentage = $('.allocation-percentage').map((_, el) => el.innerHTML).get();

            var allocated_verylow = Number(allocation_percentage[0]) * total_allocated / 100;
            var allocated_low = Number(allocation_percentage[1]) * total_allocated / 100;
            var allocated_medium = Number(allocation_percentage[2]) * total_allocated / 100;
            var allocated_high = Number(allocation_percentage[3]) * total_allocated / 100;
            var allocated_veryhigh = Number(allocation_percentage[4]) * total_allocated / 100;
            
            $('#toallocate-verylow').html(allocated_verylow.toFixed(2));
            $('#toallocate-low').html(allocated_low.toFixed(2));
            $('#toallocate-medium').html(allocated_medium.toFixed(2));
            $('#toallocate-high').html(allocated_high.toFixed(2));
            $('#toallocate-veryhigh').html(allocated_veryhigh.toFixed(2));

            $('#allocated-total').html(total_allocated.toFixed(2));


            var not_allocated_verylow=sum_verylow-allocated_verylow;
            var not_allocated_low=sum_low-allocated_low;
            var not_allocated_medium=sum_medium-allocated_medium;
            var not_allocated_high=sum_high-allocated_high;
            var not_allocated_veryhigh=sum_veryhigh-allocated_veryhigh;

            var total_not_allocated = not_allocated_verylow + not_allocated_low + not_allocated_medium + not_allocated_high + not_allocated_veryhigh;


            $('#not_allocated-verylow').html(not_allocated_verylow.toFixed(2));
            $('#not_allocated-low').html(not_allocated_low.toFixed(2));
            $('#not_allocated-medium').html(not_allocated_medium.toFixed(2));
            $('#not_allocated-high').html(not_allocated_high.toFixed(2));
            $('#not_allocated-veryhigh').html(not_allocated_veryhigh.toFixed(2));

            $('#not_allocated-total').html(total_not_allocated.toFixed(2));
            

            // var portfolio_datatable = $('#kt_datatable_portfolio').KTDatatable({
            //     data: {
            //         saveState: {
            //             cookie: false
            //         }
            //     },
            //     columns: [{
            //             field: "SN",
            //             width: 50,
            //             textAlign: 'center'
            //         },
            //         {
            //             field: "SYMBOL",
            //             width: 52,
            //             sortable: false,
            //         },
            //         {
            //             field: "NAME",
            //             width: 65,
            //             overflow: 'visible'
            //         },
            //         {
            //             field: "PRICE(CURRENT)",
            //             width: 115,
            //         },
            //         {
            //             field: "GAIN",
            //             width: 91,
            //         },
            //         {
            //             field: "QUANTITY",
            //             width: 91,
            //         },
            //     ],
            //     search: {
            //         input: $('#kt_datatable_search_query_portfolio'),
            //         key: 'generalSearch'
            //     }
            // });
            // get_profit_data();
            var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    },
                },
                search: {
                    input: $('#_portfolio_search_transaction'),
                    key: 'generalSearch'
                },
                columns: [{
                        field: "SN",
                        width: 46,
                    },
                    {
                        field: "SYMBOL",
                        width: 52,
                        sortable: false,
                    },
                    {
                        field: "TICKER",
                        width: 65,
                    },
                    {
                        field: "TYPE",
                        width: 90,
                    },
                    {
                        field: "DATE",
                        width: 180,
                    },
                    {
                        field: "UNITS",
                        width: 180,
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

            // $('#portfolio-btn').click(function() {
            //     portfolio_datatable.reload();
            //     setTimeout(() => {
            //         get_profit_data();
            //     }, 500);

            // });

            $('#transaction-btn').click(function() {
                datatable_transactions.reload();

            });
            // $('#assetmatrix-btn').click(function() {
            //     datatable_assetmatrix.reload();
            // });

            var coin_datatable = $('#kt_datatable_coin_select').KTDatatable({
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
                    var org_date = $('#purchase_date').val();
                    let currentDate = new Date().toJSON().slice(0, 10);
                    if (org_date == currentDate) {
                        var selected_coin = $('#selected_coin .coin_org_symbol').val();
                        var price_today = $('#selected_coin .coin_org_price').val();
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

            var price_today = $('#selected_coin .coin_org_price').val();
            $('#purchase_price').val(price_today);
            $('.modal.fade.show').css('display', 'flex');
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
                    setTimeout(window.location.reload('/'), 100);
                } else {
                    $('.errorbox').html(
                        "<div class='p-4 bg-danger text-white'>Transaction couldnt be updated.</div>"
                    );
                    setTimeout(window.location.reload('/'), 100);
                }

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
    </script>
@endsection
