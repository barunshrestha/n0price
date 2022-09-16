{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection.select2-selection--single {
            height: 40px;
            width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Update Service Coupon</h3>
        </div>
        @include('layout.partials.vehicle_info', ['vehicle_id' => $data->vehicle_id])
        <!--begin::Form-->
        <form class="form" id="kt_form" action="{{ route('servicecoupons.update', $data->id) }}" method="POST"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Coupon No</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="coupon_no" type="text" class="form-control form-control-solid" required readOnly
                            value="{{ $data->coupon_no }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Fsc No</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="fsc_no" type="text" class="form-control form-control-solid" required readOnly
                            value="{{ $data->fsc_no }}" />
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-6">
                        <label class="col-form-label text-right col-lg-1 col-sm-2 lblinfo" style="bottom: 6px;">
                            @if ($data->service_type == 'free')
                                <h4><span
                                        class="badge badge-pill badge-success">{{ strtoupper($data->service_type) }}</span>
                                </h4>
                            @else
                                <h4>
                                    <span
                                        class="badge badge-pill badge-danger">{{ strtoupper($data->service_type) }}</span>
                                </h4>
                            @endif
                        </label>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-6">
                        <label class="col-form-label text-right col-lg-2 col-sm-2 lblinfo" style="bottom: 6px;">
                            @if ($data->service_type == 0)
                                <h4> <span class="badge badge-pill badge-success">Scheduled</span></h4>
                            @else
                                <h4> <span class="badge badge-pill badge-danger">UnScheduled</span></h4>
                            @endif
                            @if ($data->minor == 1)
                                <h4> <span class="badge badge-pill badge-success">Minor</span></h4>
                            @endif

                            @if ($data->accidental == 1)
                                <h4><span class="badge badge-pill badge-danger">Accidental</span></h4>
                            @endif
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Service Date</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="service_date" type="date" class="form-control" required
                            value="{{ $data->service_date }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Service Start</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="service_start" type="datetime-local" class="form-control" required
                            value="{{ $data->service_start }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Service Stop</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="service_stop" type="datetime-local" class="form-control" required
                            value="{{ $data->service_stop }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Cancelled Reason</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="cancelled_reason" type="text" class="form-control" required
                            value="{{ $data->cancelled_reason }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Cancelled By</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        {{ Form::select('cancelled_dealer_id', $dealers, $data->cancelled_dealer_id, ['class' => 'form-control form-control-solid form-control-role', 'autocomplete' => 'off']) }}
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Cancelled Date</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="cncelled_date" type="date" class="form-control" required
                            value="{{ $data->cncelled_date }}" />
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-form-label text-right col-lg-2 col-sm-12">Dealer:</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        {{ Form::select('dealer_id', $dealers, $data->dealer_id, ['class' => 'form-control form-control-role', 'autocomplete' => 'off']) }}

                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-12">Status</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        {{ Form::select('status', $status_list ?? '', $data->status, ['class' => 'form-control', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Estimated Time</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="estimated_time" type="text" class="form-control" required
                            value="{{ $data->estimated_time }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Estimated Cost</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="estimated_cost" type="text" class="form-control" required
                            value="{{ $data->estimated_cost }}" />
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Next Service Date</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="next_service_date" type="date" class="form-control" required
                            value="{{ $data->next_service_date }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Service Km</label>
                    <div class="col-lg-2 col-md-1 col-sm-6">
                        <input name="service_km" type="text" class="form-control" required
                            value="{{ $data->service_km }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">First Call </label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="call_1" type="date" class="form-control" value="{{ $data->call_1 }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">First Call Notes</label>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input name="call_1_notes" type="text" class="form-control"
                            value="{{ $data->call_1_notes }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Second Call</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="call_2" type="date" class="form-control" value="{{ $data->call_2 }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Second Call Notes</label>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input name="call_2_notes" type="text" class="form-control"
                            value="{{ $data->call_2_notes }}" />
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Third Call</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="call_3" type="date" class="form-control" value="{{ $data->call_3 }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">Third Call Notes</label>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input name="call_3_notes" type="text" class="form-control"
                            value="{{ $data->call_3_notes }}" />
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">21 days remider</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="sms_21d" type="date" class="form-control" value="{{ $data->sms_21d }}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-4">7 days remider</label>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <input name="sms_7d" type="date" class="form-control" value="{{ $data->sms_7d }}" />
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-2 col-sm-4">Feedback</label>
                    <div class="col-lg-9 col-md-9 col-sm-6">
                        <input name="feedback" type="text" class="form-control" required
                            value="{{ $data->feedback }}" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
                        <a href="{{ route('servicecoupons.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script>
        $('.form-control-role').select2({
            width: '100%',
            allowClear: false
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

    <script type="text/javascript">
        $(document).ready(function() {


        });
    </script>
@endsection
