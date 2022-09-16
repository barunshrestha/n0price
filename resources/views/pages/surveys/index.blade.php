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
			<h3 class="card-label">Surveys
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filterSurveys','method' => 'get']) }}
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-3 col-sm-2">Select dealer</label>
				<div class="col-lg-3 col-md-3 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id,  ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off','required'=>true])}}
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-3 col-sm-2">Customer</label>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<input name="customer_name" type="text" class="form-control form-control-solid" value="{{$customer_name}}" />
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-3 col-sm-2">Vehicle</label>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<input name="vehicle_registration_no" type="text" class="form-control form-control-solid" value="{{$vehicle_registration_no}}" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<input name="date_from" type="date" class="form-control form-control-solid" value="{{$date_from}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<input name="date_to" type="date" class="form-control form-control-solid" value="{{$date_to}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-md-3 col-sm-12">Status</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('status', ['' => 'Select Status'] + $status_list,$status, ['class' =>  'form-control', 'autocomplete' => 'off'])}}
				</div>
			</div>

			<button type="submit" class="btn btn-primary mr-2 submitBtn" style="position: absolute; right: 0;"><i class="fa fa-submit"></i> Search</button>


			{{ Form::close() }}
		</div>
	</div>
	<div class="card-body">
		<!--begin: Search Form-->
		<div class="mb-7">
			<div class="row align-items-center">
				<div class="col-lg-9 col-xl-8">
					<div class="row align-items-center">
						<div class="col-md-3 my-2 my-md-0">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_surveys" />
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
					<th>Vehicle</th>
					<th>Dealer</th>
					<th>Type</th>
					<th>Status</th>
					<th>Date</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($surveys as $key=>$survey)

				<tr>
					<td>{{$key+1}}</td>
					<td><a href="{{route('customers.edit',$survey->customer_id)}}">{{$survey->customers->name ?? ''}}</a></td>
					<td><a href="{{route('vehicles.edit',$survey->vehicle_id)}}">{{$survey->vehicles->registration_no}}</a></td>
					<td><a href="{{route('dealers.edit',$survey->dealer_id)}}">{{$survey->dealers->name}}</a></td>
					<td>{{$survey->survey_type}}</td>
					<td>{{$status_list[$survey->status]}}</td>
					<td>{{date('Y-m-d',strtotime($survey->created))}}</td>

					<td>
						<a href="{{route('surveys.show',$survey->id)}}" class="btn btn-icon btn-info btn-xs mr-2 viewBtn" data-toggle="tooltip" title="View">
							<i class="fa fa-eye"></i>
						</a>

						<form action="{{ route('surveys.destroy', $survey->id) }}" style="display: inline-block;" method="post">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							<button type="button" value="Delete" class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip" title="Delete">
								<i class="fa fa-trash"></i>
							</button>
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
			input: $('#kt_datatable_search_query_surveys'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.solid').select2();
	});
</script>

<style>
	.form-control-solid,
	.form-control-solid-survey {
		min-width: 1rem;
		max-width: 100%;
	}
</style>
@endsection
