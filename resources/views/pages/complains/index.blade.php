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
			<h3 class="card-label">Complains
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filterComplains','method' => 'get']) }}
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('dealer_id', ['' => 'Select Dealer'] +$dealers,$dealer_id, ['class' =>  'form-control form-control-solid-complain','autocomplete' => 'off','required'=>true])}}
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Name</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="customer_name" type="text" class="form-control form-control-solid" value="{{$customer_name}}" />
				</div>

			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="date_from" type="date" class="form-control form-control-solid" value="{{$date_from}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="date_to" type="date" class="form-control form-control-solid" value="{{$date_to}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Status</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('status', $status_list,$status, ['class' =>  'form-control role', 'autocomplete' => 'off'])}}
				</div>
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_complains" />
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
					<th>Dealer</th>
					<th>Complaint</th>
					<th>Date</th>
					<th>Status</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($complains as $key=>$complain)
				<tr>
					<td>{{$key+1}}</td>
					<td><a href="{{route('customers.edit',$complain->customer_id)}}">{{$complain->customers->name .', '.$complain->customers->contact_no}}</a></td>
					<td><a href="{{route('dealers.show',$complain->dealer_id)}}">{{$complain->dealers->name}}</a></td>
					<td>{{$complain->complain}}</td>
					<td>{{date('Y-m-d',strtotime($complain->created))}}</td>
					<td>{{$status_list[$complain->status]}}</td>
					<td>
						<form action="{{ route('complains.destroy', $complain->id) }}" style="display: inline-block;" method="post">
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
				width: 30,
			},
			{
				field: "E-mail",
				width: 200,
			},

		],
		search: {
			input: $('#kt_datatable_search_query_complains'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-solid-complain').select2();
	});
</script>

<style>
	.flagged {}
</style>
@endsection
