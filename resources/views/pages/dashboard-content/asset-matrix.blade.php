    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Asset Matrix
                    <span class="d-block text-muted pt-2 font-size-sm">Available Asset
                        matrix</span>
                </h3>
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
                                        id="portfolio_search_assetmatrix" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable_assetmatrix">
                <thead>
                    <tr>
                        <th style="width: 10px !important;">No</th>
                        <th>Coin</th>
                        <th>Units</th>
                        <th>Purchase Price</th>
                        <th>Purchase Date</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->coin_id }}</td>
                            <td>{{ $data->units }}</td>
                            <td>{{ $data->purchase_price }}</td>
                            <td>{{ $data->purchase_date }}</td>

                            <td>

                                <a href="{{ route('transactions.edit', $data->id) }}"
                                    class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('transactions.destroy', $data->id) }}"
                                    style="display: inline-block;" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                        title="Delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
