    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Portfolio
                    <span class="d-block text-muted pt-2 font-size-sm">Your current portfolio</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_transaction_modal">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect fill="#000000" x="4" y="11" width="16" height="2"
                                    rx="1" />
                                <rect fill="#000000" opacity="0.9"
                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                    x="4" y="11" width="16" height="2" rx="1" />
                            </g>
                        </svg>
                    </span> Investment</button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="kt_datatable_search_query_portfolio" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-borderless table-bordered px-5">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">SYMBOL</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">PRICE(CURRENT)</th>
                        <th class="text-center">QUANTITY</th>
                        <th class="text-center">PROFIT/LOSS(TOTAL)</th>
                        <th class="text-center">INVESTMENT</th>
                        <th class="text-center">WORTH(CURRENT)</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($portfolio as $key => $data)
                        <?php
                        $curr = "$data->coin_id";
                        $usd = $current_price->$curr->usd;
                        $usd_24h_change = $current_price->$curr->usd_24h_change;
                        ?>
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">
                                <img src="{{ $data->image }}" alt="img" class="dropdown-image mx-2 ">
                            </td>
                            <td class="text-center align-middle">{{ $data->coin_name }}</td>
                            <td class="text-center align-middle">
                                {{ $usd }} USD
                            </td>
                            <td class="text-center align-middle">{{ $data->total }}</td>
                            <td class="text-center align-middle">
                                <?php
                                
                                $t_investment = $data->total_investment;
                                $t_worth = $usd * $data->total;
                                $t_profit_loss=$t_investment- $t_worth;
                                
                                if ($t_profit_loss > 0) {
                                    
                                    echo "<span class=\" text-success font-weight-bold gain-button\">" . (string) $t_profit_loss . '  USD</span>';
                                } 
                                elseif ($t_profit_loss < 0) {
                                    
                                    echo "<span class=\" text-danger font-weight-bold gain-button \">" . (string) $t_profit_loss . '  USD</span>';
                                } else {
                                    
                                    echo "<span class=\" text-dark font-weight-bold gain-button\">" . (string) $t_profit_loss . '  USD</span>';
                                }
                                ?>



                                {{-- <?php
                                if ($usd_24h_change > 0) {
                                    $round_usd = round($usd_24h_change / 100, 2);
                                    echo "<button class=\"btn btn-success font-weight-bold gain-button\">" . (string) $round_usd . '%</button>';
                                } elseif (round($usd_24h_change / 100, 2) < 0) {
                                    $round_usd = round($usd_24h_change / 100, 2);
                                    echo "<button class=\"btn btn-danger font-weight-bold gain-button \">" . (string) $round_usd . '%</button>';
                                } else {
                                    $round_usd = round($usd_24h_change / 100, 2);
                                    echo "<button class=\"btn btn-dark font-weight-bold gain-button\">" . (string) $round_usd . '%</button>';
                                }
                                ?> --}}

                            </td>
                            <td class="text-center align-middle">{{ round($data->total_investment, 2) }} </td>
                            <td class="text-center align-middle">{{ round($usd * $data->total, 2) }} </td>
                            <td class="text-center align-middle">
                                <div class="card-toolbar">
                                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                                        href=<?php echo "\"#coin-" . $key . "\""; ?> role="button" aria-expanded="false"
                                        aria-controls=<?php echo "\"coin-" . $key . "\""; ?> title="Toggle Card">
                                        <i class="ki ki-arrow-down icon-nm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div id=<?php echo "\"coin-" . $key . "\""; ?> class="collapse">
                                    <div class="card-container">
                                        <div class="card shadow mb-5 bg-white rounded">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center align-middle">Purchase date</th>
                                                        <th class="text-center align-middle">Purchase price</th>
                                                        <th class="text-center align-middle">Quantity</th>
                                                        <th class="text-center align-middle">Profit/Loss</th>
                                                        <th class="text-center align-middle">Value</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($portfolio_details as $details)
                                                        @if ($details->coin_id == $data->id_of_coin)
                                                            <tr>
                                                                <td class="text-center align-middle">
                                                                    {{ $details->purchase_date }}</td>
                                                                <td class="text-center align-middle">
                                                                    <?php
                                                                    $p_price = $details->purchase_price / $details->units;
                                                                    echo round($p_price, 2);
                                                                    ?>

                                                                    {{-- {{ round($details->purchase_price / $details->units, 2) }} --}}
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    {{ $details->units }}</td>
                                                                <td class="text-center align-middle">
                                                                    <?php
                                                                    
                                                                    $profitLossAmount = round(($p_price - $usd) * $details->units, 2);
                                                                    // echo $usd;
                                                                    if ($profitLossAmount > 0) {
                                                                        echo "<span class=\"text-success font-weight-bold gain-button\">" . (string) $profitLossAmount . '  USD</span>';
                                                                    } elseif (round($profitLossAmount / 100, 2) < 0) {
                                                                        echo "<span class=\"text-danger font-weight-bold gain-button \">" . (string) $profitLossAmount . '  USD</span>';
                                                                    } else {
                                                                        echo "<span class=\"text-dark font-weight-bold gain-button\">" . (string) $profitLossAmount . '  USD</span>';
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    {{ round($details->purchase_price, 2) }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                            <tr>
                                                <td class="coin-table-data">
                                                    <?php
                                                    $curr = "$coin->coin_id";
                                                    $usd = $current_price->$curr->usd;
                                                    $usd_24h_vol = $current_price->$curr->usd_24h_vol;
                                                    $usd_24h_change = $current_price->$curr->usd_24h_change;
                                                    ?>

                                                    <div class="align-items-center d-flex ">
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
                                                            <div class="mx-2">
                                                                <?php
                                                                if ($usd_24h_change > 0) {
                                                                    $round_usd = round($usd_24h_change / 100, 2);
                                                                    echo "<button class=\"btn btn-success font-weight-bold gain-button\">" . (string) $round_usd . '% <i class="flaticon2-arrow-up"></i></button>';
                                                                } elseif ($usd_24h_change < 0) {
                                                                    $round_usd = round($usd_24h_change / 100, 2);
                                                                    echo "<button class=\"btn btn-danger font-weight-bold gain-button \">" . (string) $round_usd . '% <i class="flaticon2-arrow-down"></i>  </button>';
                                                                }
                                                                ?>

                                                            </div>


                                                            {{-- <button type="button"
                                                                onclick="selectCoinFromCoinsList(event)"
                                                                class="btn btn-light-success btn-circle mr-2 coin-in-coin-list-button">
                                                                <i class="flaticon-plus text-info"></i>
                                                            </button> --}}
                                                        </div>
                                                        <button class="btn mr-2 coin-in-coin-list-button"
                                                            onclick="selectCoinFromCoinsList(event)" type="button">
                                                            <i class="flaticon2-plus text-success"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form class="form" id="kt_form" action="{{ route('transactions.store') }}"
                            method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div id="selected_coin" class="card ">

                                    </div>
                                </div>
                            </div>

                            <div class="row hidden mt-5" id="investment-description">
                                <div class="form-group mt-2 col-sm-12 col-md-4 col-lg-4">
                                    <label>Quantity</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Quantity"
                                            id="purchase_quantity" name="units" value="1" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-4 col-lg-4">
                                    <label>Purchase date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="date"
                                            value="<?php echo date('Y-m-d'); ?>" name="purchase_date" id="purchase_date" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-4 col-lg-4">
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
