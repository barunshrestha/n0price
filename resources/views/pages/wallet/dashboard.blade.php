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
    <input type="hidden" id="wallet_address" value="{{ $wallet_address }}" name="wallet_address">

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
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div style="border: 1px solid #d6d6d6; padding:2em; width:50em;">
                        <h5 class="card-title">Wallet Address : {{ $wallet_address }}</h5>
                        <h6 class="card-text" id="calculate_total"></h6>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel"
                            aria-labelledby="kt_tab_pane_1_4">
                            @include('pages.wallet.portfolio')
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
            wallet_address = $('#wallet_address').val();
            populateReturn();
            calculateTotal();
        });

        function calculateTotal() {
            $.ajax({
                'url': '/calculate/total/' + wallet_address,
                'type': 'GET',
                success: function(result) {
                    $("#calculate_total").html(result);
                }
            });
        }

        function populateReturn() {
            $.ajax({
                'url': '/calculate/wallet/' + wallet_address,
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
