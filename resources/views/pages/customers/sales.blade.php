{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Sales</h3>
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filterSales','method' => 'get']) }}
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id, ['class' =>  'form-control role', 'autocomplete' => 'off','required'=>true])}}
				</div>
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Model</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="model" type="text" class="form-control form-control-solid" value="{{$model}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Payment Type</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
				{{ Form::select('payment_type[]', $payment_type_options, Request::get('payment_type') ?: Request::old('payment_type'), ['class' => 'form-control select2-control ', 'multiple'=>'multiple','name'=>'payment_type[]','id'=>'payment_type']) }}

				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-4 col-sm-6">
					<input name="date_from" type="date" class="form-control form-control-solid" value="{{$date_from}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-4 col-sm-6">
					<input name="date_to" type="date" class="form-control form-control-solid" value="{{$date_to}}" />
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
				</div>
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_sales" />
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
					<th>Dealer</th>
					<th>Vehicle</th>
					<th>Engine / Chasis</th>
					<th>Customer</th>
					<th>Date of sale</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sales as $key=>$sale)

				<tr>
					<td>{{$key+1}}</td>
					<td><a href="{{route('dealers.show',$sale->dealer_id)}}">{{$sale->dealer_name}}</a></td>
					<td><a href="{{route('vehicles.edit',$sale->vehicle_id)}}">{{$sale->registration_no}}</a><br />{{$sale->model}}</td>
					<td>{{$sale->engine_no}}<br />{{$sale->chasis_no}}</td>
					<td><a href="{{route('customers.edit',$sale->customer_id)}}">{{$sale->customer_name}}</a><br />{{$sale->customer_contact}}</td>
					<td>
						{{$sale->date_of_sale}}
						
						<?php 
							echo "<span class = 'spanPaymentType' style='float:right'>";
							if($sale->payment_type == 'cash'){
								echo '<i style="color:green;" class="fas fa-dollar-sign" title = "Cash Sales"></i>';
							}
							if($sale->payment_type == 'exchange'){
								echo '<i style="color:orange;" class="fas fa-exchange-alt"  title = "Exchange"></i>';
							}
							if($sale->payment_type == 'finance'){
								echo '<i style="color:blue;" class="fa fa-landmark" aria-hidden="true" title = "Finance"></i>';
							}
							if($sale->payment_type == 'exchange finance'){
								echo '<i style="color:orange;" class="fa fa-exchange" aria-hidden="true" title = "Exchange"></i>';
								echo '<i style="color:blue;" class="fa fa-landmark" aria-hidden="true" title = "Finance"></i>';
							}
							echo "</span>";
							
						?>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
			input: $('#kt_datatable_search_query_sales'),
			key: 'generalSearch'
		}
	});
	$(".select2-control").select2({ width: '100%' });
</script>

<style>
	.flagged {}
</style>
@endsection