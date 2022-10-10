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
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/get/all/transactions',
                        contentType: 'application/json',
                        params: {
                            generalSearch: '',
                        },
                        map: function(data){
                            console.log(data);
                            var my_data=data.data;
                           return data.data;
                        }
                    }
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                saveState: {
                    cookie: false
                }
            },
            columns: [
                {
                    field: "username",
                    title:"User",
                    width: 130,
                },
                {
                    field: "coin_name",
                    title: "Coin",
                    width: 130,
                },
                {
                    field: "units",
                    title: "Units",
                    width: 130,
                },
                {
                    field: "purchase_price",
                    title: "Price",
                    width: 130,
                },
                {
                    field: "status",
                    title: "Status",
                    width: 130,
                },
                {
                    field: "date",
                    title: "Date",
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
