{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Vehicle Booking Details
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filter_rpt_vehicle_bookings','method' => 'get']) }}

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Dealers</label>
				<div class="col-lg-2 col-md-3 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id,  ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>

				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-2 col-md-3 col-sm-6">
					<input name="date_from" id="date_from" type="date" class="form-control form-control-solid" value="{{$date_from}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-2 col-md-3 col-sm-6">
					<input name="date_to" id="date_to" type="date" class="form-control form-control-solid" value="{{$date_to}}" />
				</div>
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_booking_detail" />
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
					<th>Customer</th>
					<th>Mobile No</th>
					<th>Dealer</th>
					<th>Model</th>
					<th>Description</th>
					<th>Amount paid</th>
					<th>Booked date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($vehicle_bookings as $key=>$bookings)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$bookings->customer_name}}</td>
					<td>{{$bookings->customer_contact_no}}</td>
					<td>{{$bookings->dealer_name}}</td>
					<td>{{$bookings->model}}</td>
					<td>{{$bookings->description}}</td>
					<td>{{$bookings->esewa_transactions_total_amount}}</td>
					<td>{{$bookings->follow_up_date1}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
@section('scripts')
<!-- <script src="{{asset('js/pages/crud/ktdatatable/base/html-table.js')}}" type="text/javascript"></script> -->
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
			input: $('#kt_datatable_search_query_booking_detail'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-booking').select2();
	});
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