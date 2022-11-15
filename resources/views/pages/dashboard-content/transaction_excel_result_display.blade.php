{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Transaction Import
                    <span class="d-block text-muted pt-2 font-size-sm">Check and verify the imports from Excel File</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('transaction.final.excel.submit') }}" method="POST">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <input type="hidden" name="portfolio_id" value="{{ $portfolio_id }}">
                <div class="d-block text-success mt-5 font-size-md"><b>List of Valid Data</b></div>
                <div class="d-block text-muted font-size-sm">These data will be uploaded to transaction table.
                </div>
                <table class="datatable datatable-bordered table-responsive" id="kt_datatable_transaction_import_valid">
                    <thead>
                        <tr>
                            <th>Coin</th>
                            <th>Investment Type</th>
                            <th>Units Purchased</th>
                            <th>Price per unit</th>
                            <th>Purchase date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $zero_input_flag = 1;
                        ?>
                        @for ($key = 1; $key < count($datas); $key++)
                            <?php
                            $coin_id = (new App\Http\Controllers\TransactionController())->checkCoinInDatabase($datas[$key][0], $datas[$key][1]);
                            ?>
                            @if (!empty($coin_id))
                                <tr>
                                    <td>
                                        <input type="text" value="{{ $coin_id->coin_id }}" class="form-control"
                                            name="symbol[]">
                                        <input type="hidden" value="{{ $coin_id->id }}" name="coin_id[]">
                                    </td>
                                    <td>
                                        <select name="investment_type[]" class="form-control">
                                            <option value="buy" <?php if ($datas[$key][2] == 'buy') {
                                                echo 'selected';
                                            }
                                            ?>>buy</option>
                                            <option value="sell" <?php if ($datas[$key][2] == 'sell') {
                                                echo 'selected';
                                            } ?>>sell</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="units[]" value="{{ $datas[$key][3] }}" 
                                            class="form-control">
                                    </td>
                                    <td><input type="number" name="price_per_unit[]" value="{{ $datas[$key][4] }}" 
                                            class="form-control"></td>

                                    <td><input type="date" name="purchase_date[]" value="<?php
                                    echo (new App\Http\Controllers\TransactionController())->convertExcelTimetoCarbon($datas[$key][5]);
                                    ?>"
                                            class="form-control">
                                    </td>
                                    <td><button type="button" class="btn btn-danger flaticon2-delete"
                                            onclick="removeField(event)"></button></td>
                                </tr>
                            @endif
                        @endfor

                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary mt-5" id="submit-btn-valid-data">Submit</button>
            </form>
            <hr>
            <div class="d-block text-danger mt-4 font-size-md"><b>List of Invalid Data</b></div>
            <div class="d-block text-muted font-size-sm">You need to import these data manually.
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable_transaction_import_invalid">
                <thead>
                    <tr>
                        <th>Coin</th>
                        <th>Investment Type</th>
                        <th>Units Purchased</th>
                        <th>Price per unit</th>
                        <th>Purchase date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($key = 1; $key < count($datas); $key++)
                        <?php
                        $coin_id = (new App\Http\Controllers\TransactionController())->checkCoinInDatabase($datas[$key][0], $datas[$key][1]);
                        ?>
                        @if (empty($coin_id))
                            <tr>
                                <td>
                                    <input type="text" value="{{ $datas[$key][0] }}" class="form-control" disabled
                                        name="coin_name">
                                </td>
                                <td>
                                    <select name="investment_type" class="form-control" disabled>
                                        <option value="buy" <?php if ($datas[$key][2] == 'buy') {
                                            echo 'selected';
                                        }
                                        ?>>buy</option>
                                        <option value="sell" <?php if ($datas[$key][2] == 'sell') {
                                            echo 'selected';
                                        } ?>>sell</option>
                                    </select>
                                </td>
                                <td><input type="text" name="units" value="{{ $datas[$key][3] }}" class="form-control"
                                        disabled>
                                </td>
                                <td><input type="text" name="price_per_unit" value="{{ $datas[$key][4] }}"
                                        class="form-control" disabled></td>
                                </td>
                                <td><input type="date" name="purchase_date" value="<?php
                                echo (new App\Http\Controllers\TransactionController())->convertExcelTimetoCarbon($datas[$key][5]);
                                ?>"
                                        class="form-control" disabled>
                                </td>

                            </tr>
                        @endif
                    @endfor

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        var datatable = $('#kt_datatable_transaction_import_valid').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "Coin",
                    width: 120,
                },
                {
                    field: "Investment Type",
                    width: 120,
                },
                {
                    field: "Units Purchased",
                    width: 120,
                },
                {
                    field: "Price per unit",
                    width: 120,
                },
                {
                    field: "Purchase date",
                    width: 150,
                },
                {
                    field: "Actions",
                    width: 120,
                    textAlign: "center"
                }

            ],
            search: {
                input: $('#kt_datatable_transaction_import_valid_search_query_user'),
                key: 'generalSearch'
            }
        });
        var datatable2 = $('#kt_datatable_transaction_import_invalid').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "Coin",
                    width: 120,
                },
                {
                    field: "Investment Type",
                    width: 120,
                },
                {
                    field: "Units Purchased",
                    width: 120,
                },
                {
                    field: "Price per unit",
                    width: 120,
                },
                {
                    field: "Purchase date",
                    width: 150,
                },

            ],
            search: {
                input: $('#kt_datatable_transaction_import_valid_search_query_user'),
                key: 'generalSearch'
            }
        });

        function removeField(event) {
            var parent = $(event.target.parentElement.parentElement.parentElement);
            if (parent.is("tr")) {
                parent.remove();
            }
        }
    </script>
@endsection
