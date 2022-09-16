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
			<h3 class="card-label">Warranty Claims
		</div>
		<div class="col-md-12 col-lg-12">
				{{ Form::open(['url' => '/filter_rpt_warranty_claims','method' => 'get']) }}
					<div class="form-group row">
						<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
						<div class="col-lg-3 col-md-2 col-sm-6">
							<input name="date_from" type="date" class="form-control form-control-solid"  required value="{{$date_from}}"/>
						</div>
						<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
						<div class="col-lg-3 col-md-2 col-sm-6">
							<input name="date_to" type="date" class="form-control form-control-solid"  required value="{{$date_to}}"/>
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
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
					<th>Associated Dealer</th>
					<th>Model</th>
					<th>Warranty claimed on</th>
					<th>Warranty status</th>
					<th>Warranty claimed</th>
				</tr>
			</thead>
			<tbody>
				@foreach($vehicles as $key=>$vehicle)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$vehicle->registration_no }}</td>
					<td>{{$vehicle->name}}</td>
					<td>{{$vehicle->product}}</td>
					<td>{{$vehicle->warranty_date}}</td>
					<td>{{$vehicle->warranty_status}}</td>
					<td>{{$vehicle->warranty_delaer_name}}</td>
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
			input: $('#kt_datatable_search_query'),
			key: 'generalSearch'
		}
	});
</script>
@endsection