{{-- Extends layout --}}
@extends('layout.default')
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4" id="portfolio-btn">
                                    <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                    <span class="nav-text">Portfolio</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4" id="transaction-btn">
                                    <span class="nav-icon"><i class="flaticon2-drop"></i></span>
                                    <span class="nav-text">Transaction</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_4" id="assetmatrix-btn">
                                    <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                                    <span class="nav-text">Asset Matrix</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel"
                            aria-labelledby="kt_tab_pane_1_4">

                            @include('pages.dashboard-content.portfolio')
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">

                            @include('pages.dashboard-content.transaction')
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_3_4" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">

                            @include('pages.dashboard-content.asset-matrix')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var datatable = $('#kt_datatable_portfolio').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "No",
                    width: 20,
                },
                {
                    field: "Coin",
                    width: 60,
                },
                {
                    field: "Total Units",
                    width: 80,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_portfolio'),
                key: 'generalSearch'
            }
        });

        document.getElementById('portfolio-btn').onclick = function() {
            var datatable = $('#kt_datatable_portfolio').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                columns: [{
                        field: "No",
                        width: 20,
                    },

                ],
                search: {
                    input: $('#kt_datatable_search_query_portfolio'),
                    key: 'generalSearch'
                }
            });
        }
        document.getElementById('transaction-btn').onclick = function() {
            var datatable_transactions = $('#kt_datatable_transactions').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                columns: [{
                        field: "No",
                        width: 20,
                    },

                ],
                search: {
                    input: $('#_portfolio_search_transaction'),
                    key: 'generalSearch'
                }
            });
        }
        document.getElementById('assetmatrix-btn').onclick = function() {
            var datatable_assetmatrix = $('#kt_datatable_assetmatrix').KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                columns: [{
                        field: "No",
                        width: 20,
                    },

                ],
                search: {
                    input: $('#portfolio_search_assetmatrix'),
                    key: 'generalSearch'
                }
            });
        }
    </script>
@endsection
