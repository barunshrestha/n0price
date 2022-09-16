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
			<h3 class="card-label">Connect Login History
				<span class="d-block text-muted pt-2 font-size-sm">Connect Login History</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<!--begin: Search Form-->
		<!--begin::Search Form-->
		<div class="mb-7">
			<div class="row align-items-center">
				<div class="col-lg-4 col-xl-4">
					<div class="row align-items-center">
						<div class="col-md-8 my-2 my-md-0">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_connect" />
								<span>
									<i class="flaticon2-search-1 text-muted"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
					<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
				</div> -->
			</div>
		</div>
		<table class="datatable datatable-bordered" id="kt_datatable">
			<thead>
				<tr>
					<th style="width: 10px !important;">No</th>
					<th>Name</th>
					<th>Vehicles</th>
					<th>Logged In</th>
					<th>Ip Address</th>


				</tr>
			</thead>
			<tbody>
				<?php $_count = 1 ?>
				@foreach($connecthistories as $key=>$connecthistory)

				<tr>
					<td>{{$_count++}}</td>

					<td><a href="{{route('customers.edit',$connecthistory->customer_id)}}">{{$connecthistory->customer_name}}</a></td>
					<td><a href="{{route('vehicles.edit',$connecthistory->vehicle_id)}}">{{$connecthistory->registration_no}}</a></td>
					<td>{{$connecthistory->logged_in}}</td>
					<td>{{$connecthistory->ip}}</td>
					<td>

						<a href="{{route('connecthistories.show',$connecthistory->id)}}" class="btn btn-icon btn-info btn-xs mr-2 viewBtn" data-toggle="tooltip" title="Edit">
							<i class="fa fa-eye"></i>


					</td>

				</tr>
				@endforeach

			</tbody>
		</table>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	var datatable = $('#kt_datatable').KTDatatable({
		data: {
			saveState: {
				cookie: false
			}
		},
		columns: [{
				field: "No",
				width: 30,
			},
			{
				field: "Name",
				width: 200,
			},
			{
				field: "Vehicles",
				width: 200,
			},
			{
				field: "Logged In",
				width: 200,
			},
			{
				field: "Ip Address",
				width: 200,
			}

		],
		search: {
			input: $('#kt_datatable_search_query_connect'),
			key: 'generalSearch'
		}
	});
	$('#kt_datatable_search_status').on('change', function() {
		datatable.search($(this).val().toLowerCase(), 'Status');
	});
	$('#kt_datatable_search_type').on('change', function() {
		datatable.search($(this).val().toLowerCase(), 'Type');
	});
	$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
</script>
@endsection