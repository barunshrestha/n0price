<div class="container">

    <div class="d-flex justify-content-end">
        <div class="d-flex flex-column flex-root">

            {{-- <form action="{{ route('loadDashboardWithoutLogin') }}" method="POST"> --}}
            {{-- @csrf --}}
            <h1 class="text-center mb-4"
                style="    margin-top: 4em;
            color: #d1d3e0;
            font-weight: 600;
            font-size: 4em;
            letter-spacing: 0.3rem;">
                Manage portfolios, not just coins...
            </h1>
            <div class="align-items-end" style="margin-left: 44.4%;margin-top:7em;">
                <p class="text-muted">Show assets allocation and returns based on the risk factors</p>
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <div class="input-icon mx-4">
                        <input type="text" name="wallet_address" class="form-control-lg form-control"
                            id="wallet_address_at_search" style="width: 45em;"
                            placeholder="Search by ethereum addresses, separated by comma if multiple…"
                            value="{{ $address ?? '' }}">
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{-- </form> --}}

        </div>
    </div>
</div>
