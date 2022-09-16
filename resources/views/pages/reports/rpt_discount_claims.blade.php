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
                <h3 class="card-label">Discount Claims
            </div>
            <div class="col-md-12 col-lg-12">
                {{ Form::open(['url' => '/filter_rpt_discount_claims', 'method' => 'get']) }}

                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Discount</label>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        {{ Form::select('get_discount', [' ' => 'Select a claim'] + $get_discount ?? '', $data->get_discount ?? '', ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>

                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="date_from" type="date" class="form-control form-control-solid"
                            value="{{ $date_from }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="date_to" type="date" class="form-control form-control-solid"
                            value="{{ $date_to }}" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Apply</button>
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
                                        id="kt_datatable_search_query_discount_page" />
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
                        <th>Vehicle</th>
                        <th>Fsc No</th>
                        <th>Discount</th>
                        <th>get Discount</th>
                        <th>Associated Dealer</th>
                        <th>Service Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($service_coupons as $key => $service)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $service->registration_no }}</td>
                            <td>{{ $service->fsc_no }}</td>
                            <td>{{ isset($service->discount) ? $service->discount : '------' }}</td>
                            <td>{{ isset($service->get_discount) ? $service->get_discount : '------' }}</td>
                            <td>{{ $service->dealer_name }}</td>
                            <td>{{ $service->service_date }}</td>
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
                input: $('#kt_datatable_search_query_discount_page'),
                key: 'generalSearch'
            }
        });
    </script>
@endsection
