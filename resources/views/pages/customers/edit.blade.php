{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
	});

	$("#district").children('option').attr('hidden',true);
	$("#municipality").children('option').attr('hidden',true);
	$('#province').on("change",function(){
		$("#district").prop('selectedIndex',0);
		$("#district").children('option').attr('hidden',true);
		$("#district").children('option[data="'+ $(this).val() + '"]').attr('hidden',false);
	});

	$('#district').on("change",function(){
		$("#municipality").prop('selectedIndex',0);
		$("#municipality").children('option').attr('hidden',true);
		$("#municipality").children('option[data="'+ $(this).val() + '"]').attr('hidden',false);
	});
	
</script>
@endsection


<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Edit Customer Detail</h3>
	</div>
	@include('layout.partials.customer_info',['customer_id' => $data->id])

	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('customers.update',$data->id)}}" method="POST" enctype="multipart/form-data">

		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Name</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="name" type="text" class="form-control form-control-solid name" placeholder="Enter Name" required value="{{$data->name}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Type</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('type', $type_options ?? '',$data->type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>

			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Contact No</label>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<input name="contact_no" type="phone" class="form-control form-control-solid" placeholder="Enter Contact No" required value="{{$data->contact_no}}" />
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Alternate Contact No</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="contact_no_1" type="phone" class="form-control form-control-solid" placeholder="Enter Contact No 1" value="{{$data->contact_no_1}}" />
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Carrier</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('carrier', $carrier_options ?? '',$data->carrier ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Age</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('age', $age_group_options ?? '',$data->age ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Gender</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('gender', $gender_options ?? '',$data->gender ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Unlimited Vehicles</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('allow_unlimited_vehicles', $unlimited_vehicles_options ?? '',$data->allow_unlimited_vehicles ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Address</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="address" type="text" class="form-control form-control-solid" placeholder="Enter Address" value="{{$data->address}}" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">State</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<select name="state" id="province" class="form-control form-control-solid">
					<option value="0">Select Province</option>
						@foreach($provinces as $province)
						@if($province->id == $data->state)
							<option value="{{$province->id}}" title="{{$province->name}}" selected="selected">{{$province->name}}</option>
						@else
							<option value="{{$province->id}}" title="{{$province->name}}">{{$province->name}}</option>
						@endif
						@endforeach
					</select>
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">District</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<select name="district" id="district" class="form-control form-control-solid">
					<option value="0">Select District</option>
						@foreach ($districts as $district)
						@if($district->id == $data->district)
							<option value="{{$district->id}}" data="{{$district->province_id}}" selected="selected">{{ $district->name}}</option>
						@else
							<option value="{{$district->id}}" data="{{$district->province_id}}">{{ $district->name}}</option>
						@endif
						@endforeach
					</select>
				</div>
				
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Municipality</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
				<select name="municipality" id="municipality" class="form-control form-control-solid">
				<option value="0">Select Municipality</option>
						@foreach ($municipalities as $municipality)
						@if($municipality->id == $data->municipality)
							<option value="{{$municipality->id}}" data="{{$municipality->district_id}}" selected="selected">{{$municipality->title}}</option>
						@else
							<option value="{{$municipality->id}}" data="{{$municipality->district_id}}">{{$municipality->title}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Document Type</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="document_type" type="text" class="form-control form-control-solid" placeholder="Enter Document Type" value="{{$data->document_type}}" />
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Document No</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="document_no" type="text" class="form-control form-control-solid" placeholder="Enter Document No" value="{{$data->document_no}}" />
				</div>
			</div>


			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">License No</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					@if(@isset($license_data) && $license_data && $license_data->meta_value)
					<input name="meta_value" type="text" class="form-control form-control-solid" placeholder="Enter License No" value="{{$license_data->meta_value}}" />
					@else
					<input name="meta_value" type="text" class="form-control form-control-solid" placeholder="Enter License No" value="" />
					@endif
				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Expiry date</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					@if(@isset($license_data) && $license_data && $license_data->meta_value)
					<input name="meta_value" type="date" class="form-control form-control-solid" placeholder="Enter Expiry date" value="{{$expiry_data->meta_value}}" />
					@else
					<input name="meta_value" type="date" class="form-control form-control-solid" placeholder="Enter Expiry date" value="" />
					@endif

				</div>

				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Bill book expiry date </label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="bill_book_expiry_date" type="date" class="form-control form-control-solid" placeholder="Enter Bill book expiry date" value="{{$data->bill_book_expiry_date}}" />
				</div>
			</div>

		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('customers.index')}}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>
</div>

@endsection
{{-- Scripts Section --}}