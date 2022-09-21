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
            <table class="table table-borderless table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>SYMBOL</th>
                        <th>NAME</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>DAY GAIN</th>
                        <th>VALUE</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($portfolio as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td></td>
                            <td>{{ $data->coin_name }}</td>
                            <td></td>
                            <td>{{ $data->total }}</td>
                            <td></td>
                            <td></td>
                            <td>
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
                            <td colspan="7">
                                <div id=<?php echo "\"coin-" . $key . "\""; ?> class="collapse">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Purchase date</th>
                                                <th>Purchase price</th>
                                                <th>Quantity</th>
                                                <th>Total gain</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tbody>
                                    </table>
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
                                                    <div class="align-items-center d-flex">
                                                        <img src="{{ $coin->image }}" alt="img"
                                                            class="dropdown-image mx-2 ">
                                                        <div class="mx-2">{{ strtoupper($coin->symbol) }}
                                                        </div>
                                                        <div class="mx-2">{{ ucfirst(trans($coin->name)) }}
                                                        </div>
                                                        <div class="mx-2">{{ $usd }}</div>
                                                        <div class="mx-2">{{ round($usd_24h_change, 2) }}
                                                        </div>
                                                        <input type="hidden" value={{ $coin->id }} id={{ $curr }} name="coin_id">
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
                                        <input type="number" class="form-control" placeholder="Quantity"
                                            name="units" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-4 col-lg-4">
                                    <label>Purchase date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="date"
                                            name="purchase_date" />
                                    </div>
                                </div>
                                <div class="form-group mt-2 col-sm-12 col-md-4 col-lg-4">
                                    <label>Purchase price</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Unit Price Amount"
                                            name="purchase_price" />
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
