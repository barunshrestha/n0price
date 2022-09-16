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
			<h3 class="card-label"> FSC Follow-Up
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filter_rpt_fscfollowup','method' => 'get']) }}

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-md-2 col-sm-12">Select dealer</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id,  ['class' =>  'form-control-role', 'autocomplete' => 'off','required'=>true])}}
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_new" />
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
					<th>Previous Dealer</th>
					<th>Customer</th>
					<th>Customer Contact No</th>
					<th>Exceeded Days</th>
					<th>First Call</th>
					<th>Second Call</th>
					<th>Lost</th>

				</tr>
			</thead>
			<tbody>
				@foreach($followup as $key=>$followups)
				<tr>

					<td>{{$key+1}}</td>
					<td>{{$followups->registration_no}}</td>
					<td>{{$followups->prev_dealer_name}}</td>
					<td>{{$followups->customer_name}}</td>
					<td>{{$followups->customer_number}}</td>
					<td>{{$followups->exceed_days}}</td>
					<td>{{$followups->call_1}}</td>
					<td>{{$followups->call_2}}</td>
					<td>@if($followups->exceed_days <= -16) <i class="fa fa-check" aria-hidden="true"></i>
							@endif
					</td>
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
			input: $('#kt_datatable_search_query_new'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-role').select2();
	});
</script>
@endsection