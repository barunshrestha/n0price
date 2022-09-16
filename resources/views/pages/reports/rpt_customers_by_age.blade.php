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
                <h3 class="card-label">Sales (Model-AgeGroup)
            </div>
            <div class="col-md-12 col-lg-12">
                {{ Form::open(['url' => '/filter_rpt_customers_by_age', 'method' => 'get']) }}
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
                    <div class="col-lg-3 col-md-2 col-sm-6">
                        <input name="date_from" type="date" class="form-control form-control-solid" required
                            value="{{ $date_from }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
                    <div class="col-lg-3 col-md-2 col-sm-6">
                        <input name="date_to" type="date" class="form-control form-control-solid" required
                            value="{{ $date_to }}" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i>
                        Search</button>
                </div>
                {{ Form::close() }}
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
                                        id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <table class="datatable datatable-bordered" id="kt_datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Model</th>
                        <th>Under 25</th>
                        <th>25 - 35</th>
                        <th>35 - 45</th>
                        <th>Over 45</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <?php //print_r($customer);
                            ?>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->model . ' (' . $customer->product . ')' }}</td>

                            <td>{{ $customer->first_age_group }} @if ($customer->first_age_group > 0)
                                    {{ ' ( ' . number_format(($customer->first_age_group * 100) / $customer->Total, 2) . '% )' }}
                                @endif
                            </td>
                            <td>{{ $customer->second_age_group }} @if ($customer->second_age_group > 0)
                                    {{ ' ( ' . number_format(($customer->second_age_group * 100) / $customer->Total, 2) . '% )' }}
                                @endif
                            </td>
                            <td>{{ $customer->third_age_group }} @if ($customer->third_age_group > 0)
                                    {{ ' ( ' . number_format(($customer->third_age_group * 100) / $customer->Total, 2) . '% )' }}
                                @endif
                            </td>
                            <td>{{ $customer->fourth_age_group }} @if ($customer->fourth_age_group > 0)
                                    {{ ' ( ' . number_format(($customer->fourth_age_group * 100) / $customer->Total, 2) . '% )' }}
                                @endif
                            </td>
                            <td>{{ $customer->Total }}</td>
                        </tr>
                    @endforeach
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
        var datatable = $('#kt_datatable').KTDatatable({
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
                    field: "E-mail",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            }
        });
    </script>
@endsection
