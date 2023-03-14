<div class="container">

    <div class="d-flex justify-content-end">
        <div class="d-flex flex-column flex-root">

            {{-- <form action="{{ route('loadDashboardWithoutLogin') }}" method="POST"> --}}
            {{-- @csrf --}}
            <h1 class="text-center mb-4"
                style="    margin-top: 4em;
            color: #e4e4e7;
            font-weight: 600;
            font-size: 4em;
            letter-spacing: 0.3rem;">
                manage portfolios, not just coins
            </h1>
            <div class="align-items-end" style="margin-left: 44.4%;margin-top:7em;">
                {{-- <p class="text-muted">Show assets allocation and returns based on the risk factors</p> --}}
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <div class="mx-4 d-flex input-box-holder">
                        <input type="text" name="wallet_address" class="form-control-md form-control"
                            id="wallet_address_at_search" style="width: 45em;"
                            placeholder="search by ethereum addresses (max 5, separated by comma)"
                            value="{{ $address ?? '' }}">
                        <button class="btn btn-primary btn-icon" onclick="searchWallet()">
                            <i class="flaticon2-search-1"></i>
                        </button>
                        {{-- <span class="btn btn-md btn-primary">
                            <i class="flaticon2-search-1 text-white"></i>
                        </span> --}}
                    </div>
                </div>
            </div>

            {{-- </form> --}}

        </div>
    </div>
</div>
