<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Transactions
                <span class="d-block text-muted pt-2 font-size-sm">Your Transaction History</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="input-icon">
                <input type="text" class="form-control" placeholder="Search..."
                    id="_portfolio_search_transaction" />
                <span>
                    <i class="flaticon2-search-1 text-muted"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="datatable datatable-bordered table-responsive text-center table-hover mt-5" id="kt_datatable_transactions">
            <thead class="card card-custom" style="background: #f6f6f6;">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Coin</th>
                    <th class="text-center">Units</th>
                    <th class="text-center">Purchase Price</th>
                    <th class="text-center">Purchase Date</th>
                    <th class="text-center" title="Field #6">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $key => $transaction)
                    <tr style="border-bottom: #f6f6f6 solid 0.75px;">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $transaction->coin_name }}</td>
                        <td>{{ $transaction->units }}</td>
                        <td>{{ $transaction->purchase_price }}</td>
                        <td>{{ $transaction->purchase_date }}</td>

                        <td>
                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                style="display: inline-block;" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" value="Delete"
                                    class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                    title="Delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


