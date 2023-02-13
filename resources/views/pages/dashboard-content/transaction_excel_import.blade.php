<div class="modal fade" id="excelImport" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card px-3 py-3 container card-custom" style="width: 100%">
                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-bold nav-tabs-line row">
                                <li class="nav-item col-sm-12 col-md-7">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_csv"
                                        id="portfolio-btn">
                                        <span class="nav-icon mx-2"><i class="flaticon2-infographic"></i></span>
                                        <span class="nav-text">Import CSV</span>
                                    </a>
                                </li>
                                @if (Auth::user()->role_id == '1')
                                    <li class="nav-item col-sm-12 col-md-5">
                                        <a class="nav-link mx-sm-5" data-toggle="tab" href="#kt_tab_pane_wallet"
                                            id="transaction-btn">
                                            <span class="nav-icon mx-2"><i class="flaticon-piggy-bank"></i></span>
                                            <span class="nav-text">Wallet</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_tab_pane_csv" role="tabpanel"
                                aria-labelledby="kt_tab_pane_csv">
                                <a href="{{ route('download.excel.sample') }}" data-toggle="tooltip"
                                    title="Download Excel Sample">
                                    Download CSV Sample <i class="flaticon-download-1 text-primary"></i>
                                </a>
                                <form class="form" id="kt_form"
                                    action="{{ route('transaction.excel.import.submit') }}" method="post"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="dashboard-portfolio-id"
                                        value="{{ $portfolio_details->id }}" name="portfolio_id">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <input name="file_name" type="file" accept="excel/*"
                                                class="form-control form-control-solid" placeholder="Choose File"
                                                required autocomplete="off" />
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold"
                                            id="coin-save-transaction-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                            @if (Auth::user()->role_id == '1')
                                <div class="tab-pane fade" id="kt_tab_pane_wallet" role="tabpanel"
                                    aria-labelledby="kt_tab_pane_wallet">
                                    <form class="form" id="wallet_form" action="{{ route('load.wallet') }}"
                                        method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="card-body">
                                            <div id="wallet_address_collection">
                                                <div class="input-group mb-3">
                                                    <input name="wallet_address[]" type="text"
                                                        class="form-control form-control-solid"
                                                        placeholder="Enter your wallet address" required
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <button class="btn btn-icon btn-info btn-sm mx-2" type="button"
                                                onclick="addWalletAddressField()">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary font-weight-bold"
                                                id="coin-save-transaction-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
