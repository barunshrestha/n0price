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
                <h3 class="card-label">Showroom Visits
            </div>
            <div class="col-md-12 col-lg-12">
                {{ Form::open(['url' => '/filter_rpt_showroom_visit', 'method' => 'get']) }}

                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        {{ Form::select('dealer_id', [' ' => 'All Nepal'] + $dealers, $dealer_id, ['class' => 'form-control role', 'autocomplete' => 'off', 'required' => true]) }}
                    </div>

                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Status</label>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        {{ Form::select('status', [' ' => 'All'] + $status_option ?? '', $data->status ?? '', ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="date_from" type="date" class="form-control form-control-solid"
                        value="{{ $date_from }}"   />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
                    <div class="col-lg-3 col-md-2 col-sm-6">
                        <input name="date_to" type="date" class="form-control form-control-solid"
                        value="{{ $date_to }}"   />
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
                                        id="kt_datatable_search_query_showroom_visit" />
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
                        <th>Visitor Name</th>
                        <th>Mobile No</th>
                        <th>Visited Dealer</th>
                        <th>Interested Model</th>
                        <th>Test Ride</th>
                        <th>Visit Date</th>
                        <th>Status</th>
                        <th>Cancellation Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($showroom_visit as $key => $visit)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $visit->customer_name }}</td>
                            <td>{{ $visit->mobile_number }}</td>
                            <td>
                                @if (isset($visit->dealer_id))
                                    <a href="{{ route('dealers.show', $visit->dealer_id) }}" data-toggle="tooltip"
                                        title="View">{{ isset($visit->dealer_name) ? $visit->dealer_name : '' }}</a>
                                @else
                                    ---
                                @endif


                            </td>
                            <td>{{ $visit->interested_model }}</td>
                            <td>{{ $visit->test_ride }}</td>
                            <td>{{ $visit->visit_date }}</td>
                            <td>{{ $visit->status }}</td>
                            <td>{{ $visit->cancellation_reason }}</td>
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
                input: $('#kt_datatable_search_query_showroom_visit'),
                key: 'generalSearch'
            }
        });
    </script>
@endsection
