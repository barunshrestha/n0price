    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Portfolio
                    <span class="d-block text-muted pt-2 font-size-sm">Your current portfolio</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="input-icon mx-2 my-3 ">
                    <input type="text" class="form-control " placeholder="Search..."
                        id="kt_datatable_search_query_portfolio" />
                    <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                    </span>
                </div>
                <button type="button" class="btn btn-primary mx-2 my-3" data-toggle="modal" data-target="#new_transaction_modal">
                    <i class="flaticon2-plus"></i>
                    Transaction</button>
            </div>
        </div>
        <div class="card-body">
            <table class="datatable datatable-bordered table-responsive text-center table-hover mt-5"
                id="kt_datatable_portfolio">
                <thead class="card card-custom" style="background: #f6f6f6;">
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">SYMBOL</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">PRICE(CURRENT)</th>
                        <th class="text-center">GAIN</th>
                        <th class="text-center">QUANTITY</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($portfolio as $key => $data)
                        <?php
                        $curr = "$data->coin_id";
                        $usd = $current_price->$curr->usd;
                        $usd_24h_change = $current_price->$curr->usd_24h_change;
                        ?>
                        <tr style="border-bottom: #f6f6f6 solid 0.75px;">
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">
                                <img src="{{ $data->image }}" alt="img" class="dropdown-image mx-2 ">
                            </td>
                            <td class="text-center align-middle">{{ $data->coin_name }}</td>
                            <td class="text-center align-middle">
                                {{ round($usd, 2) }} USD
                            </td>
                           <td>
                            <?php
                            if ($data->total_profit>0) {
                                echo "<span class=\" text-success font-weight-bold gain-button\">" . (string)$data->total_profit . ' USD </span>';
                            } else {
                                echo "<span class=\" text-danger font-weight-bold gain-button\">" . (string)$data->total_profit . ' USD</span>';
                            }
                            ?>
                           </td>
                            <td class="text-center align-middle">
                                <?php
                                $total_buy_unit=$data->buy_unit?$data->buy_unit:0;
                                $total_sell_unit=$data->sell_unit?$data->sell_unit:0;
                                $req_unit=$total_buy_unit- $total_sell_unit;
                                echo $req_unit;                                
                                ?>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="new_transaction_modal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add to My Portfolio</h5>
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
                                                        placeholder="Enter the investment type ..."
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
                                        @foreach ($available_coins as $coin)
                                            <tr onclick="selectCoinFromCoinsList(event)">
                                                <td class="coin-table-data">
                                                    <?php
                                                    $curr = "$coin->coin_id";
                                                    $usd = $current_price->$curr->usd;
                                                    $usd_24h_vol = $current_price->$curr->usd_24h_vol;
                                                    $usd_24h_change = $current_price->$curr->usd_24h_change;
                                                    ?>

                                                    <div class="align-items-center d-flex"
                                                        onclick="selectCoinFromCoinsList(event)">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $coin->image }}" alt="img"
                                                                class="dropdown-image mx-2 ">

                                                            <input type="hidden" value={{ $coin->id }}
                                                                id={{ $curr }} name="coin_id">
                                                            <input type="hidden" value={{ $coin->coin_id }}
                                                                class="coin_org_symbol">
                                                            <input type="hidden" value={{ $usd }}
                                                                class="coin_org_price">

                                                            <div class="mx-2 font-weight-bold">
                                                                {{ ucfirst(trans($coin->name)) }}</div>
                                                        </div>
                                                        <div class="align-items-center d-flex ml-auto ">
                                                            <div class="mx-2 font-weight-bold usd-price">
                                                                {{ round($usd, 2) }}
                                                                USD
                                                            </div>
                                                            <div class="mx-2 ml-5">
                                                                <?php
                                                                if ($usd_24h_change > 0) {
                                                                    $round_usd = round($usd_24h_change / 100, 2);
                                                                    echo "<span class=\"text-success font-weight-bold gain-button\">" . (string) $round_usd . '% <i class="text-success flaticon2-arrow-up"></i></span>';
                                                                } elseif ($usd_24h_change < 0) {
                                                                    $round_usd = round($usd_24h_change / 100, 2);
                                                                    echo "<span class=\"text-danger font-weight-bold gain-button \">" . (string) $round_usd . '% <i class="text-danger flaticon2-arrow-down"></i>  </button>';
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form class="form" id="kt_form" action="{{ route('transactions.store') }}" method="POST"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div id="selected_coin" class="card ">

                                    </div>
                                </div>
                            </div>

                            <div class="row hidden mt-5" id="investment-description">
                                <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                    <label>Status</label>
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
                                        <input type="text" class="form-control" placeholder="Quantity"
                                            id="purchase_quantity" name="units" value="1" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                    <label>Purchase date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="date"
                                            value="<?php echo date('Y-m-d'); ?>" name="purchase_date" id="purchase_date" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                    <label>Purchase price</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Purchase Price Amount" name="purchase_price"
                                            id="purchase_price" />
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"
                            onclick="window.location.reload();">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
