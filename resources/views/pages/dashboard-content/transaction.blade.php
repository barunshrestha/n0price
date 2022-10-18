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
@else
    <div id="dashboard-transaction-partials">
        <h5 style="text-align: center;">
            Loading....
        </h5>
    </div>
@endif
