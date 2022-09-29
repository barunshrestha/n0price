{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Transactions
                    <span class="d-block text-muted pt-2 font-size-sm">List of transactions of all User</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="kt_all_transaction_search_query_user" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_all_transaction">
                <thead>
                    <tr>
                        <th> id </th>
                        <th> user_id </th>
                        <th> coin_id </th>
                        <th> units </th>
                        <th> purchase_price </th>
                        <th> investment_type </th>
                        <th> purchase_date </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var datatable = $('#kt_all_transaction').KTDatatable({
            data: {
                source: {
                    read: {
                        url: '/get/all/transactions',
                        method: 'GET',
                        map: function(raw) {
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        }
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    data: "id",
                    width: 20,
                },
                {
                    data: "user_id",
                    width: 130,
                },
                {
                    data: "coin_id",
                    width: 130,
                },
                {
                    data: "units",
                    width: 130,
                },
                {
                    data: "purchase_price",
                    width: 130,
                },
                {
                    data: "investment_type",
                    width: 130,
                },
                {
                    data: "purchase_date",
                    width: 130,
                },

            ],
            search: {
                input: $('#kt_all_transaction_search_query_user'),
                key: 'generalSearch'
            }
        });
        $('#kt_all_transaction_search_role').on('change', function() {
            datatable.search($(this).val(), 'Role');
        });
        // $('#kt_all_transaction_search_status').on('change', function() {
        //     datatable.search($(this).val(), 'Approval Status');
        // });

        $('#kt_all_transaction_search_status, #kt_all_transaction_search_type').selectpicker();
    </script>
@endsection
