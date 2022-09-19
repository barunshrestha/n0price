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
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>Add Coin </button>
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
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable_portfolio">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Coin</th>
                        <th>Total Units</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($portfolio as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->coin_name }}</td>
                            <td>{{ $data->total }}</td>
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
                                    <label class="px-4">Coin type</label>
                                </div>
                                <div class="row">

                                    <div class="coin_container">
                                        @foreach ($available_coins as $coin)
                                            <div class="col">

                                                <div class="selection">
                                                    <input name="coin_id" type="radio" value="{{ $coin->id }}"
                                                        id="{{ $coin->id }}">
                                                    <label
                                                        for="{{ $coin->id }}">{{ ucfirst(trans($coin->name)) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- <select class="form-control form-control-solid coins" id="coin_id" name="coin_id"
                                    required>
                                    @foreach ($available_coins as $coin)
                                        <option value="{{ $coin->id }}">
                                            {{ ucfirst(trans($coin->name)) }}</option>
                                    @endforeach
                                </select> --}}

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
