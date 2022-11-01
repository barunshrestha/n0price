{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 mt-5 pb-0">
            <div class="card-title">
                <h3 class="card-label">My Portfolios
                    {{-- <span class="d-block text-muted pt-2 font-size-sm">List of available Portfolio</span> --}}
                </h3>
            </div>
            <div class="card-toolbar">

                <a href="#" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>New Portfolio</a>

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
                                        id="kt_datatable_my_portfolio_search" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable_my_portfolio">
                <thead>
                    <th>PORTFOLIO</th>
                    <th>ACTIVE</th>
                    <th>ACTIONS</th>
                </thead>
                <tbody>
                    @foreach ($portfolios as $portfolio)
                        <tr>
                            <td>{{ $portfolio->portfolio_name ? $portfolio->portfolio_name : 'Name unavailable' }}</td>
                            <td><?php
                            if ($portfolio->id == $selected_portfolio->portfolio_id) {
                                echo "<i class='flaticon2-correct text-success'></i>";
                            }
                            ?></td>
                            <td>
                                @if ($portfolio->id == $selected_portfolio->portfolio_id)
                                @else
                                    <a href="{{ route('portfolio.active', $portfolio->id) }}"
                                        class="btn btn-icon btn-info btn-xs mr-2" data-toggle="tooltip" title="Approve">
                                        <i class="fa fa-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('portfolio.edit', $portfolio->id) }}"
                                    class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('portfolio.destroy', $portfolio->id) }}"
                                    style="display: inline-block;" method="post">
                                    {{ method_field('POST') }}
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
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var my_portfolio_datatable = $('#kt_datatable_my_portfolio')
            .KTDatatable({
                data: {
                    saveState: {
                        cookie: false
                    }
                },
                columns: [{
                        field: "PORTFOLIO",
                        width: 150,
                        sortable: false,
                        textAlign: 'center'
                    },
                    {
                        field: "ACTIVE",
                        width: 60,
                        sortable: false,
                        textAlign: 'center'
                    },
                    {
                        field: "ACTIONS",
                        width: 180,
                        sortable: false,
                        textAlign: 'right'
                    },
                ],
                search: {
                    input: $('#_portfolio_search_transaction'),
                    key: 'generalSearch'
                },

            });
        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    </script>
@endsection
