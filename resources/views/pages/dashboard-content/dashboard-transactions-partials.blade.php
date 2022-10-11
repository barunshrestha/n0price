<div class="card card-custom">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Transactions
                <span class="d-block text-muted pt-2 font-size-sm">Your Transaction History</span>
            </h3>
        </div>
        <div class="card-toolbar">
        <button type="button" class="btn btn-primary mx-2 my-3" data-toggle="modal"
                data-target="#new_transaction_modal">
                <i class="flaticon2-plus"></i>
                Transaction</button>
        
        
            <div class="input-icon">
                <input type="text" class="form-control" placeholder="Search by ticker..." id="_portfolio_search_transaction" />
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
                    <th class="text-center">SN</th>
                    <th class="text-center">SYMBOL</th>
                    <th class="text-center">TICKER</th>
                    <th class="text-center">TYPE</th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">UNITS</th>
                    <th class="text-center">PRICE(PER UNIT)</th>
                    <th class="text-center">ACTIONS</th>
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

                                <select name="investment_type" class="form-control hide_before_edit hidden"
                                    style="width: 85%;">
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
                                    style="width: 85%;" value="{{ $transaction->purchase_date }}">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div id="units-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    {{ $transaction->units }}
                                </div>
                                <input type="text" name="units" class="form-control hidden hide_before_edit"
                                    style="width: 85%;" value="{{ $transaction->units }}">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div id="purchase_price-{{ $transaction->id }}">
                                <div class="hide_after_edit ">
                                    {{ number_format($transaction->purchase_price / $transaction->units, 2) }}
                                </div>
                                <input type="text" name="price_per_unit"
                                    class="form-control hidden  hide_before_edit" style="width: 85%;"
                                    value="{{ round($transaction->purchase_price / $transaction->units, 2) }}">
                            </div>
                        </td>
                        <td>
                            <div id="transaction_action_buttons-{{ $transaction->id }}">
                                <div class="hide_after_edit d-flex">
                                    <button class="btn btn-icon btn-success btn-xs mr-2 transactionEditBtn"
                                        data-toggle="tooltip" title="Edit"
                                        id="transactionEdit-{{ $transaction->id }}"
                                        onclick="transactionEditBtn(event)">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <button type="button" value="Delete"
                                    class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip" onclick="deleteTransaction({{$transaction->id}})"
                                    title="Delete"><i class="fa fa-trash"></i></button>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" id="deleteMyTransaction-{{$transaction->id}}"
                                        style="display: inline-block;" method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        {{-- <button type="submit" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn transactiondeleteBtn" data-toggle="tooltip"
                                        title="Delete"><i class="fa fa-trash"></i></button> --}}
                                    </form>
                                </div>
                                <div class="hide_before_edit hidden d-flex">
                                    <button type="button" value="Save" class="btn btn-icon btn-success btn-xs mr-2"
                                        data-toggle="tooltip" title="Save"
                                        id="transaction_save_btn-{{ $transaction->id }}" onclick="transactionsaveBtn(event)"><i
                                            class="flaticon2-check-mark"></i></button>

                                    <button type="button" value="Discard" onclick="transactionDiscardBtn(event)"
                                    id="transactionDiscard-{{ $transaction->id }}"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip"
                                        title="Discard"><i class="flaticon2-cross"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>