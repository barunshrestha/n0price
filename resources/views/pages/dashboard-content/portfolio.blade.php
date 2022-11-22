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

        <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#excelImport">
            <i class="flaticon-upload"></i>
            Import</button>
    </div>
@else
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div style="border: 1px solid #d6d6d6; padding:2em;">
                <h5 class="card-title">Your Portfolio : {{ $portfolio_details->portfolio_name }}</h5>
                <h6 class="card-text" id="total_holding_valuation"></h6>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#excelImport">
                    <i class="flaticon-upload"></i>
                    Import</button>
                <button type="button" class="btn btn-primary mx-2 my-3" data-toggle="modal"
                    data-target="#new_transaction_modal">
                    <i class="flaticon2-plus"></i>
                    Transaction</button>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-responsive w-100 d-block d-md-table table-bordered" style="width: 100%">

                <thead>
                    <tr>
                        <th scope="col" colspan="2">Market Cap</th>
                        @foreach ($asset_matrix_constraints as $constraints)
                            <th scope="col"
                                style="background: {{ $constraints->color }};color:black;text-align:center;">
                                {{ $constraints->market_cap }}
                            </th>
                        @endforeach
                        <th style="text-align:center; border:none;" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            Risk
                        </td>
                        @foreach ($asset_matrix_constraints as $constraints)
                            <td style="text-align:center;">
                                {{ $constraints->risk }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid #ffffff;">Allocation%
                        </td>
                        <td style="text-align: right">
                            <span id="total_allocation" class="ml-auto"></span>
                        </td>
                        <form action="{{ route('percentage.allocation') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $portfolio_details->id }}" name="portfolio_id">
                            <input type="hidden" value="{{ $portfolio_details->portfolio_name }}"
                                name="portfolio_name">
                            @foreach ($asset_matrix_constraints as $constraints)
                                <td>
                                    <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                        {{ $constraints->percentage_allocation }}%
                                    </div>
                                    <input type="text" class="form-control hideBeforeedit hidden"
                                        name="allocation_percentage[]"
                                        value="{{ $constraints->percentage_allocation }}">
                                </td>
                            @endforeach
                            <td colspan="4" style="border: none;">
                                <div class="d-flex justify-content-left">
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

                        <td colspan="2">
                            To Allocate $
                        </td>
                        <td style="text-align: right;"><span id="toallocate-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="toallocate-high"></span></td>
                        <td style="text-align: right;"><span id="toallocate-medium"></span></td>
                        <td style="text-align: right;"><span id="toallocate-low"></span></td>
                        <td style="text-align: right;"><span id="toallocate-verylow"></span></td>

                    </tr>
                    <tr>

                        <td colspan="2">
                            Allocated
                        </td>
                        <td style="text-align: right;"><span id="allocated-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="allocated-high"></span></td>
                        <td style="text-align: right;"><span id="allocated-medium"></span></td>
                        <td style="text-align: right;"><span id="allocated-low"></span></td>
                        <td style="text-align: right;"><span id="allocated-verylow"></span></td>
                        <td style="text-align: center; font-weight:bold;" colspan="4">Market</td>
                    </tr>
                    <tr>

                        <td colspan="2">
                            Not Allocated
                        </td>
                        <td style="text-align: right;"><span id="not_allocated-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-high"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-medium"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-low"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-verylow"></span></td>
                        <td style="text-align: center;">Return</td>
                        <td style="text-align: center;">24hr</td>
                        <td style="text-align: center;">7d</td>
                        <td style="text-align: center;">ATH</td>
                    </tr>
                </tbody>
                <tbody id="coin_worth_all_summary">
                    <tr>
                        <td colspan="11" style="text-align: center;" class="my-5">
                            <h4>
                                Loading....
                            </h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
{{-- <div class="modal fade" id="new_transaction_modal" data-backdrop="static" tabindex="-1" role="dialog"
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
                                <tbody> --}}
{{-- @foreach ($available_coins as $coin)
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
                                                            } else {
                                                                $round_usd = round($usd_24h_change / 100, 2);
                                                                echo "<span class=\"text-dark font-weight-bold gain-button \">" . (string) $round_usd . '% <i class="text-dark flaticon2-hexagonal"></i>  </button>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach --}}
{{-- </tbody>
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
</div> --}}
