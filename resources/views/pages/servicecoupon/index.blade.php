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
                <h3 class="card-label">Service Coupons
            </div>
            <div class="col-md-12 col-lg-12">

                {{ Form::open(['url' => '/filterServiceCoupons', 'method' => 'get']) }}

                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        {{ Form::select('dealer_id', ['' => 'Select Dealer'] + $dealers, $dealer_id, ['class' => 'form-control form-control-service', 'autocomplete' => 'off']) }}
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Status</label>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        {{ Form::select('status', $status_list, $status, ['class' => 'form-control form-control-service', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date from</label>
                    <div class="col-lg-3 col-md-2 col-sm-12">
                        <input name="date_from" id="date_from" type="date" class="form-control form-control-service"
                            value="{{ $date_from }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Date to</label>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <input name="date_to" id="date_to" type="date" class="form-control form-control-solid"
                            value="{{ $date_to }}" />
                    </div>

                    <button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i>
                        Search</button>
                </div>

                {{ Form::close() }}
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
                                        id="kt_datatable_search_query_service_coupon" />
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
                        <th>FCSno</th>
                        <th>Coupon No</th>
                        <th>Vehicle</th>
                        <th>Dealer</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Service date</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicecoupons as $key => $servicecoupon)
                        <tr>

                            <td>{{ $key + 1 }}</td>
                            <td>{{ isset($servicecoupon->fsc_no) ? $servicecoupon->fsc_no : '' }}
                                ({{ $servicecoupon->service_type }})
                            </td>
                            <td><a
                                    href="{{ route('servicecoupons.edit', $servicecoupon->id) }}">{{ $servicecoupon->coupon_no }}</a>
                            </td>
                            <td><a
                                    href="{{ route('vehicles.edit', $servicecoupon->vehicle_id) }}">{{ $servicecoupon->registration_no }}</a>
                            </td>
                            <td>
                                @if (isset($servicecoupon->dealer_id) ? $servicecoupon->dealer_id : '')
                                    <a href="{{ route('dealers.edit', $servicecoupon->dealer_id) }}">
                                        {{ $servicecoupon->dealer }}</a>
                                @endif
                            </td>
                            <td>{{ $servicecoupon->customer . ' , ' . $servicecoupon->contact_no }}</td>

                            <td>{{ $status_list[$servicecoupon->status] }}</td>
                            <td>{{ $servicecoupon->service_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- <script src=" {{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script> -->
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
                    field: "FCSno",
                    width: 55,
                },
                {
                    field: "Coupon No",
                    width: 85,
                },
                {
                    field: "Status",
                    width: 80,
                },
                {
                    field: "Dealer",
                    width: 200,
                },
                {
                    field: "Service Date",
                    width: 80,
                },
                // {
                //     field: "Customer",
                //     width: 160,
                // },
                {
                    field: "Vehicle",
                    width: 100,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_service_coupon'),
                key: 'generalSearch'
            }
        });
        $('#kt_datatable_search_role').on('change', function() {
            datatable.search($(this).val(), 'Role');
        });
        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var startDate = new Date($('#date_from').val());
            var endDate = new Date($('#date_to').val());
            if ((startDate > endDate)) {
                alert("End date must be greater than start date.")
                $('#date_to').val('');
            } else if ((startDate > new Date())) {
                alert("Start date must not be  greater than current date.")
                $('#date_from').val('');
            } else {
                return startDate;
            }

        });
    </script>
@endsection
