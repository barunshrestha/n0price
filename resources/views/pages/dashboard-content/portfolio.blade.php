<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Asset Matrix
                <span class="d-block text-muted pt-2 font-size-sm">Available Asset matrix</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary mx-2 my-3" data-toggle="modal"
                data-target="#new_transaction_modal">
                <i class="flaticon2-plus"></i>
                Transaction</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-responsive-sm table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <th scope="col">Market Cap</th>
                    @foreach ($asset_matrix_constraints as $constraints)
                        <th scope="col" style="background: {{ $constraints->color }};color:black;">
                            {{ $constraints->market_cap }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Risk
                    </td>
                    @foreach ($asset_matrix_constraints as $constraints)
                        <td>
                            {{ $constraints->risk }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>
                        Allocation % <span id ="total_allocation"></span>
                    </td>
                    <form action="{{ route('percentage.allocation') }}" method="POST">
                        @csrf
                        @foreach ($asset_matrix_constraints as $constraints)
                            <td>
                                <div class="hideAfteredit allocation-percentage">
                                    {{ $constraints->percentage_allocation }} %
                                </div>
                                <input type="text" class="form-control hideBeforeedit hidden"
                                    name="allocation_percentage[]" value="{{ $constraints->percentage_allocation }}">
                            </td>
                        @endforeach
                        <td>
                            <div class="d-flex">
                                <button class="btn btn-icon btn-success btn-xs allocationEditBtn" type="button"
                                    data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <button class="btn btn-icon btn-success btn-xs ml-2 allocationSaveBtn hidden"
                                    type="submit" data-toggle="tooltip" title="Submit">
                                    <i class="fa fa-save"></i>
                                </button>
                            </div>
                        </td>
                    </form>
                </tr>
                <tr>

                    <td>
                        To Allocate $
                    </td>
                    <td id="toallocate-veryhigh"></td>
                    <td id="toallocate-high"></td>
                    <td id="toallocate-medium"></td>
                    <td id="toallocate-low"></td>
                    <td id="toallocate-verylow"></td>
                </tr>
                <tr>

                    <td>
                        Allocated
                    </td>
                    <td id="allocated-veryhigh"></td>
                    <td id="allocated-high"></td>
                    <td id="allocated-medium"></td>
                    <td id="allocated-low"></td>
                    <td id="allocated-verylow"></td>
                    <td id="allocated-total"></td>
                </tr>
                <tr>

                    <td>
                        Not Allocated
                    </td>
                    <td id="not_allocated-veryhigh"></td>
                    <td id="not_allocated-high"></td>
                    <td id="not_allocated-medium"></td>
                    <td id="not_allocated-low"></td>
                    <td id="not_allocated-verylow"></td>
                    <td id="not_allocated-total"></td>
                </tr>
                @foreach ($portfolio as $key => $data)
                    <tr>
                        <?php
                        $coin_id = $data->coin_id;
                        $url = 'https://pro-api.coingecko.com/api/v3/simple/price?ids=' . $coin_id . '&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $current_price = json_decode($response);
                        curl_close($ch);
                        
                        $curr = "$data->coin_id";
                        $usd = $current_price->$curr->usd;
                        $usd_24h_vol = $current_price->$curr->usd_24h_vol;
                        $usd_24h_change = $current_price->$curr->usd_24h_change;
                        $usd_market_cap = $current_price->$curr->usd_market_cap;
                        
                        // $curr = "$data->coin_id";
                        // $usd = $current_price->$curr->usd;
                        // $usd_24h_change = $current_price->$curr->usd_24h_change;
                        
                        $total_buy_unit = $data->buy_unit ? $data->buy_unit : 0;
                        $total_sell_unit = $data->sell_unit ? $data->sell_unit : 0;
                        $req_unit = $total_buy_unit - $total_sell_unit;
                        ?>
                        @if ($usd_market_cap < 25000000)
                            <td style="background:#ffe599;color:black;">
                                {{ $data->coin_name }}
                            </td>
                            <td class="tabledata-veryhigh">
                                {{ $req_unit * $usd }}
                            </td>
                            <td class="tabledata-high">

                            </td>
                            <td class="tabledata-medium">

                            </td>
                            <td class="tabledata-low">

                            </td>
                            <td class="tabledata-verylow">
                            </td>
                        @endif
                        @if ($usd_market_cap > 25000000 && $usd_market_cap < 250000000)
                            <td style="background:#ffff00;color:black;">
                                {{ $data->coin_name }}
                            </td>
                            <td class="tabledata-veryhigh">

                            </td>
                            <td class="tabledata-high">
                                {{ $req_unit * $usd }}

                            </td>
                            <td class="tabledata-medium">

                            </td>
                            <td class="tabledata-low">

                            </td>
                            <td class="tabledata-verylow">

                            </td>
                        @endif
                        @if ($usd_market_cap > 250000000 && $usd_market_cap < 1000000000)
                            <td style="background:#00ff00;color:black;">
                                {{ $data->coin_name }}
                            </td>
                            <td class="tabledata-veryhigh">

                            </td>
                            <td class="tabledata-high">

                            </td>
                            <td class="tabledata-medium">
                                {{ $req_unit * $usd }}

                            </td>
                            <td class="tabledata-low">

                            </td>
                            <td class="tabledata-verylow">

                            </td>
                        @endif
                        @if ($usd_market_cap > 1000000000 && $usd_market_cap < 25000000000)
                            <td style="background:#ff9900;color:black;">
                                {{ $data->coin_name }}
                            </td>
                            <td class="tabledata-veryhigh">

                            </td>
                            <td class="tabledata-high">

                            </td>
                            <td class="tabledata-medium">

                            </td>
                            <td class="tabledata-low">
                                {{ $req_unit * $usd }}

                            </td>
                            <td class="tabledata-verylow">

                            </td>
                        @endif
                        @if ($usd_market_cap > 25000000000)
                            <td style="background:#ff0000;color:black;">
                                {{ $data->coin_name }}
                            </td>
                            <td class="tabledata-veryhigh">

                            </td>
                            <td class="tabledata-high">

                            </td>
                            <td class="tabledata-medium">

                            </td>
                            <td class="tabledata-low">

                            </td>
                            <td class="tabledata-verylow">
                                {{ $req_unit * $usd }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
                                    @foreach ($available_coins as $coin)
                                        <tr onclick="selectCoinFromCoinsList(event)">
                                            <td class="coin-table-data">
                                                <?php
                                                $coin_id = $coin->coin_id;
                                                $url = 'https://pro-api.coingecko.com/api/v3/simple/price?ids=' . $coin_id . '&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&x_cg_pro_api_key=CG-Lv6txGbXYYpmXNp7kfs2GhiX';
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                $response = curl_exec($ch);
                                                $current_price = json_decode($response);
                                                curl_close($ch);
                                                
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
                                                            else{
                                                                $round_usd = round($usd_24h_change / 100, 2);
                                                                echo "<span class=\"text-dark font-weight-bold gain-button \">" . (string) $round_usd . '% <i class="text-dark flaticon2-hexagonal"></i>  </button>';
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
                                    <input type="text" class="form-control" placeholder="Quantity" required
                                        id="purchase_quantity" name="units" value="1" />
                                </div>
                            </div>
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="date" required
                                        value="<?php echo date('Y-m-d'); ?>" name="purchase_date" id="purchase_date" />
                                </div>
                            </div>
                            <div class="form-group mt-2 col-sm-12 col-md-3 col-lg-3">
                                <label>Price</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" required
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
