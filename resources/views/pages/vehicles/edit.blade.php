{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Edit Vehicle Info</h3>
	</div>
	@include('layout.partials.vehicle_info',['vehicle_id' => $data->id])

	<!--begin::Form-->
	<?php
	?>
	<form class="form" id="kt_form" action="{{route('vehicles.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Registration No</label>
				<div class="col-lg-2 col-md-4 col-sm-12">
					<input name="registration_no" type="text" class="form-control form-control-solid name" placeholder="Enter Registration No" required autocomplete="off" value="{{$data->registration_no}}" />
				</div>

			</div>
			<div class="form-group row">

				<label class="col-form-label text-right col-lg-2 col-sm-12">Dealer</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('dealer_id', $Dealers ?? '',$data->dealer_id ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Product</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="product" type="text" class="form-control form-control-solid name" placeholder="Enter product" required autocomplete="off" value="{{$data->product}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Engine No</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="engine_no" type="text" class="form-control form-control-solid" placeholder="Enter Effective Date" required autocomplete="off" value="{{$data->engine_no}}" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Chasis No</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="chasis_no" type="text" class="form-control form-control-solid name" placeholder="Enter Chasis No." required autocomplete="off" value="{{$data->chasis_no}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Battery No</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="battery_no" type="text" class="form-control form-control-solid name" placeholder="Enter Battery No" autocomplete="off" value="{{$data->battery_no}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Color</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="color" type="text" class="form-control form-control-solid name" placeholder="Enter color" autocomplete="off" value="{{$data->color}}" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Challan Date</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="challan_date" type="date" class="form-control form-control-solid name" placeholder="Enter Challan Date" autocomplete="off" value="{{$data->challan_date}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Challan No</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="challan_no" type="text" class="form-control form-control-solid name" placeholder="Enter Challan No" autocomplete="off" value="{{$data->challan_no}}" />
				</div>


			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Date of Sale</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="date_of_sale" type="date" class="form-control form-control-solid name" placeholder="Enter Date of Sale" autocomplete="off" value="{{$data->date_of_sale}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Date of Registration</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="date_of_registration" type="date" class="form-control form-control-solid name" placeholder="Enter Date of Registration" autocomplete="off" value="{{$data->date_of_registration}}" />
				</div>

			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">No of Coupons</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="no_of_coupons" type="text" class="form-control form-control-solid name" placeholder="Enter No of Coupons" autocomplete="off" value="{{$data->no_of_coupons}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Approved</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('approval', $approval_options ?? '',$data->approval ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>


			</div>

			<div class="form-group row">

				<label class="col-form-label text-right col-lg-2 col-sm-12">Payment Type</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('payment_type', $payment_type_options ?? '',$data->payment_type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>




			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Previous Registration No</label>
				<div class="col-lg-2 col-md-4 col-sm-12">
					<input name="last_registration_no" type="text" class="form-control form-control-solid name" placeholder="Enter Registration No" autocomplete="off" value="{{$data->last_registration_no}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Reg. No. Modified By</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('reg_no_modified_by', $Dealers ?? '',$data->reg_no_modified_by ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>



			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Warranty Status</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('warranty_status', $warranty_status_options ?? '',$data->warranty_status ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Exclude From Offers</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('exclude_offers', $exclude_offer_options ?? '',$data->exclude_offers ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>

		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('vehicles.index')}}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>


<!-- @include('layout.partials.service_coupons',['vehicle_id' => $data->id]) -->
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

	});
</script>
@endsection