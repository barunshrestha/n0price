<div class="modal fade" id="new_transaction_modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="window.location.reload();">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="card px-3 container card-custom" style="width: 100%">

                    <div class="card-body">
                        <!--begin::Search Form-->
                        <div class="mb-5 mt-lg-5 mb-lg-10" id="coin-search-bar">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 mt-2 mt-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control"
                                                    placeholder="Enter the Coin Name ..."
                                                    id="kt_coin_datatable_search_query" />
                                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="hiddentable" class="hidden">
                            <table class="table table-hover" id="kt_datatable_coin_select" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form class="form" id="kt_form" action="{{ route('transactions.store') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$portfolio_details->id}}" name="portfolio_id">
                        
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div id="selected_coin" class="card ">

                                </div>
                            </div>
                        </div>

                        <div class="row hidden mt-5" id="investment-description">
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Type</label>
                                <div class="input-group">
                                    <select name="coin_investment_type" id="coin_investment_type"
                                        class="form-control">
                                        <option value="buy">Buy</option>
                                        <option value="sell">Sell</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Quantity</label>
                                <div class="input-group">
                                    <input type=number step=any class="form-control" placeholder="Quantity" required
                                        id="purchase_quantity" name="units" value="1" oninput="validity.valid||(value='');"/>
                                </div>
                            </div>
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="date" required
                                        value="<?php echo date('Y-m-d'); ?>" name="purchase_date" id="purchase_date"/>
                                </div>
                            </div>
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Price</label>
                                <div class="input-group">
                                    <input type=number step=any class="form-control" required
                                        placeholder="Purchase Price Amount" name="purchase_price"
                                        id="purchase_price" oninput="validity.valid||(value='');" />
                                </div>
                                <!-- <label>Total Price: </label><span id="total_price_label"></span> -->
                            </div>
                        </div>
                        <div id="selected-coin-error-box" class="my-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"
                        onclick="window.location.reload();">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" id="coin-save-transaction-btn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
