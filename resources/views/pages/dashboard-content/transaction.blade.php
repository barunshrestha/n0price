<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Transactions
                <span class="d-block text-muted pt-2 font-size-sm">Your Transaction History</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="input-icon">
                <input type="text" class="form-control" placeholder="Search..." id="_portfolio_search_transaction" />
                <span>
                    <i class="flaticon2-search-1 text-muted"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="datatable datatable-bordered table-responsive text-center table-hover mt-5"
            id="kt_datatable_transactions">
            <thead class="card card-custom" style="background: #f6f6f6;">
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center"></th>
                    <th class="text-center">TICKER</th>
                    <th class="text-center">TYPE</th>
                    <th class="text-center">PURCHASE DATE</th>
                    <th class="text-center">UNITS</th>
                    <th class="text-center">PRICE(PER UNIT)</th>
                    <th class="text-center" title="Field #6">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $key => $transaction)
                    <tr style="border-bottom: #f6f6f6 solid 0.75px;">

                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                        <td class="text-center align-middle">
                            <img src="{{ $transaction->image }}" alt="img" class="icon-image mx-2 ">
                        </td>
                        <td class="text-center align-middle">
                            {{ $transaction->coin_name }}

                        </td>
                        <td class="text-center align-middle">
                            <div id="investment_type-{{ $transaction->id }}">

                                <div class="hide_after_edit">
                                    <?php
                                    $type = $transaction->investment_type;
                                    if ($type == 'buy') {
                                        echo "<span class=\" text-success font-weight-bold gain-button\">" . 'BUY' . ' </span>';
                                    } else {
                                        echo "<span class=\" text-danger font-weight-bold gain-button\">" . 'SELL' . ' </span>';
                                    }
                                    ?>
                                </div>

                                <select name="investment_type" class="form-control hide_before_edit hidden">
                                    <option value="buy" <?php if ($type == 'buy') {
                                        echo 'selected';
                                    } ?>>Buy</option>
                                    <option value="sell" <?php if ($type == 'sell') {
                                        echo 'selected';
                                    } ?>>Sell</option>
                                </select>
                            </div>

                        </td>
                        <td class="text-center align-middle">
                            <div id="purchase_date-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    {{ $transaction->purchase_date }}
                                </div>
                                <input type="date" name="purchase_date" class="form-control hidden hide_before_edit"
                                    value="{{ $transaction->purchase_date }}">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div id="units-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    {{ $transaction->units }}
                                </div>
                                <input type="text" name="units" class="form-control hidden hide_before_edit"
                                    value="{{ $transaction->units }}">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div id="purchase_price-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    {{ round($transaction->purchase_price / $transaction->units, 2) }}
                                </div>
                                <input type="text" name="price_per_unit"
                                    class="form-control hidden  hide_before_edit"
                                    value="{{ round($transaction->purchase_price / $transaction->units, 2) }}">
                            </div>
                        </td>
                        <td>
                            <div id="transaction_action_buttons-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    <button class="btn btn-icon btn-success btn-xs mr-2 transactionEditBtn"
                                        data-toggle="tooltip" title="Edit"
                                        id="transactionEdit-{{ $transaction->id }}"
                                        onclick="transactionEditBtn(event)">
                                        <i class="fa fa-pen"></i>
                                    </button>

                                    <a href="{{ route('destroyTransaction', $transaction->id) }}" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip"
                                        title="Delete"><i class="fa fa-trash"></i></a>
                                </div>
                                <div class="hide_before_edit hidden d-flex">
                                    <form action={{ route('transactions.update', $transaction->id) }} method="POST"
                                        id="transaction_edit_form-{{ $transaction->id }}">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" value="" name="investment_type" id="form_investment_type-{{$transaction->id}}">
                                        <input type="hidden" value="" name="purchase_date" id="form_purchase_date-{{$transaction->id}}">
                                        <input type="hidden" value="" name="units" id="form_units-{{$transaction->id}}">
                                        <input type="hidden" value="" name="price_per_unit" id="form_price_per_unit-{{$transaction->id}}">
                                        <button type="submit" value="Save"
                                            class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip"
                                            title="Save"><i class="flaticon2-check-mark"></i></button>
                                    </form>
                                    <button type="button" value="Discard" onclick="window.location.reload();"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip"
                                        title="Discard"><i class="flaticon2-cross"></i></button>
                                </div>
                            </div>






                            {{-- <button type="button" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="modal"
                                title="Edit" data-target="#editModal-{{ $transaction->id }}">
                                <i class="fa fa-pen"></i>
                            </button>

                            <div class="modal fade" id="editModal-{{ $transaction->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModal-{{ $transaction->id }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModal-{{ $transaction->id }}Label">Edit
                                                transaction</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row mt-5" id="investment-description">
                                                    <form action="{{ route('transactions.update') }}">
                                                        <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                                            <label>Status</label>
                                                            <div class="input-group">
                                                                <select name="coin_investment_type"
                                                                    id="coin_investment_type" class="form-control">
                                                                    <option value="buy">Buy</option>
                                                                    <option value="sell">Sell</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                                            <label>Quantity</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Quantity" id="purchase_quantity"
                                                                    name="units" value="1" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                                            <label>Purchase date</label>
                                                            <div class="input-group">
                                                                <input type="date" class="form-control"
                                                                    placeholder="date" value="<?php echo date('Y-m-d'); ?>"
                                                                    name="purchase_date" id="purchase_date" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                                            <label>Purchase price</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Purchase Price Amount"
                                                                    name="purchase_price" id="purchase_price" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary font-weight-bold">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}



                            {{-- <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a> --}}
                            {{-- <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                style="display: inline-block;" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" value="Delete"
                                    class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                    title="Delete"><i class="fa fa-trash"></i></button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
