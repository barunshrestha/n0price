<div class="d-flex justify-content-end">
    <div class="d-flex flex-column flex-root">

        {{-- <form action="{{ route('loadDashboardWithoutLogin') }}" method="POST"> --}}
        {{-- @csrf --}}
        <div class="d-flex flex-column">

            <div class="d-flex justify-content-center" style="margin-top:20em;">
                <div class="input-icon mx-4">
                    <input type="text" name="wallet_address" class="form-control-lg form-control"
                        id="wallet_address_at_search" style="width: 40em;" placeholder="Enter Wallet Address">
                    <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary font-weight-bold" onclick="searchWallet()">Search</button>
            </div>
        </div>
        {{-- </form> --}}
        <div class="form-group align-items-center" style="margin-left: 33.5%">
            <p class="text-muted">Separate addresses (maximum 5) with commas</p>
        </div>
    </div>
</div>
