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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="kt_form" action="{{ route('transactions.store') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card p-3 container">
                            <div class="form-group mt-4 ">
                                <div class="row">
                                    <label class="px-4">Investment Type</label>
                                </div>
                               

                                <select name="coin_id" class="form-control" id="kt_datatable_search_coins">
                                    @foreach ($available_coins as $coin)
                                        <option value="{{ $coin->id }}" id="{{ $coin->id }}">
                                            <div class="container">
                                                <span
                                                    class="kt-badge kt-badge--unified-brand kt-badge--xl kt-badge--rounded kt-badge--bold ">{{ strtoupper($coin->symbol) }}</span>
                                            </div>
                                            {{ ucfirst(trans($coin->name)) }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
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
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
