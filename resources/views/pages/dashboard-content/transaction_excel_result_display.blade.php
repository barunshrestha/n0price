{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .fixed-height-table {
            max-height: 30em;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: white;
        }
        .fixed-width{
            width: 12em;
        }
    </style>
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
            <form action="{{ route('transaction.final.excel.submit') }}" method="POST" id="excel-import-form">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <input type="hidden" name="portfolio_id" value="{{ $portfolio_id }}">
                <div class="d-block text-success mt-5 font-size-md"><b>List of Valid Data</b></div>
                <div class="d-block text-muted font-size-sm">Please <b>verify</b> the transactions. These data will be
                    uploaded to transaction table.
                </div>

                <table class="table table-responsive fixed-height-table">
                    <thead class="sticky-header">
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
                        @for ($key = 0; $key < count($valid_transaction); $key++)
                            <tr>
                                <td>
                                    <input type="text" value="{{ $valid_transaction[$key][0] }}" class="form-control fixed-width"
                                       disabled>
                                    <input type="hidden" value="{{ $valid_transaction[$key][0] }}"
                                        name="symbol[]">
                                    <input type="hidden" value="{{ $valid_transaction[$key][1] }}" name="coin_id[]">
                                </td>
                                <td>
                                    <select name="investment_type[]" class="form-control fixed-width">
                                        <option value="buy" <?php if ($valid_transaction[$key][2] == 'buy') {
                                            echo 'selected';
                                        }
                                        ?>>buy</option>
                                        <option value="sell" <?php if ($valid_transaction[$key][2] == 'sell') {
                                            echo 'selected';
                                        } ?>>sell</option>
                                    </select>
                                </td>
                                <td><input type="number" name="units[]" value="{{ $valid_transaction[$key][3] }}"
                                        class="form-control fixed-width">
                                </td>
                                <td><input type="number" name="price_per_unit[]" value="{{ $valid_transaction[$key][4] }}"
                                        class="form-control fixed-width"></td>

                                <td><input type="date" name="purchase_date[]" value="{{ $valid_transaction[$key][5] }}"
                                        class="form-control fixed-width">
                                </td>
                                <td><button type="button" class="btn btn-danger flaticon2-delete"
                                        onclick="removeField(event)"></button></td>
                            </tr>
                        @endfor

                    </tbody>

                </table>
                <div id="selected-coin-error-box" class="mt-3">
                </div>
                <button type="submit" class="btn btn-primary mt-5" id="submit-btn-valid-data">Submit</button>
            </form>
            <hr>
            <div class="d-block text-danger mt-4 font-size-md"><b>List of Invalid Data</b></div>
            <div class="d-block text-muted font-size-sm">You need to import these data manually.
            </div>
            <table class="table table-responsive fixed-height-table">
                <thead class="sticky-header">
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
                    @for ($key = 0; $key < count($invalid_transaction); $key++)
                        <tr>
                            <td>
                                <input type="text" value="{{ $invalid_transaction[$key][0] }}" class="form-control fixed-width"
                                    disabled name="coin_name">
                            </td>
                            <td>
                                <input type="text" name="investment_type" value="{{ $invalid_transaction[$key][1] }}"
                                    class="form-control fixed-width" disabled>
                            </td>
                            <td><input type="text" name="units" value="{{ $invalid_transaction[$key][2] }}"
                                    class="form-control fixed-width" disabled>
                            </td>
                            <td><input type="text" name="price_per_unit" value="{{ $invalid_transaction[$key][3] }}"
                                    class="form-control fixed-width" disabled></td>
                            </td>
                            <td><input type="text" name="purchase_date" value="{{ $invalid_transaction[$key][4] }}"
                                    class="form-control fixed-width" disabled>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#excel-import-form').submit(function(event) {

                $.each($('input[type=number]'), function() {
                    if (this.value <= 0) {
                        event.preventDefault();
                        $('#selected-coin-error-box').html(
                            '<p class="bg-danger p-2 text-white text-sm">Please enter valid purchase price /quantity.</p>'
                        );
                    } else {
                        $('#excel-import-form').submit();
                    }
                });
            });
        });

        function removeField(event) {
            var parent = $(event.target.parentElement.parentElement);
            if (parent.is("tr")) {
                parent.remove();
            }
        }
    </script>
@endsection
