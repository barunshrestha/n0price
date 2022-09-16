{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {});

	$("#district").children('option').attr('hidden', true);
	$("#municipality").children('option').attr('hidden', true);
	$('#province').on("change", function() {
		$("#district").prop('selectedIndex', 0);
		$("#district").children('option').attr('hidden', true);
		$("#district").children('option[data="' + 0 + '"]').attr('hidden', false);
		$("#district").children('option[data="' + $(this).val() + '"]').attr('hidden', false);
	});

	$('#district').on("change", function() {
		$("#address").prop('selectedIndex', 0);
		$("#address").children('option').attr('hidden', true);
		$("#address").children('option[data="' + $(this).val() + '"]').attr('hidden', false);
	});
</script>
@endsection
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Dealer</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('dealers.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Dealer Name</label>
					<input name="name" type="text" class="form-control form-control-solid" placeholder="Enter Dealer name" required autocomplete="off" value="{{$data->name}}" />
				</div>
				<div class="col-lg-6">
					<label>Dealer Code</label><br>
					<input name="dealer_code" type="text" class="form-control form-control-solid" placeholder="Enter Dealer code" required autocomplete="off" value="{{$data->dealer_code}}" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Area</label>
					<input name="area" type="text" class="form-control form-control-solid" placeholder="Enter area" autocomplete="off" value="{{$data->area}}" />
				</div>
				<div class="col-lg-6">
					<label>Province</label><br>
					<select name="state" id="province" class="form-control form-control-solid">
						<option value=" ">Select Province</option>

						@foreach($provinces as $province)
						@if($province->id == $data->state)
						<option value="{{$province->id}}" title="{{$province->name}}" selected="selected">{{$province->name}}</option>
						@else
						<option value="{{$province->id}}" title="{{$province->name}}">{{$province->name}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>District</label>
					<select name="district" id="district" class="form-control form-control-solid">
						<option value=" ">Select District</option>
						@foreach ($districts as $district)
						@if($district->id == $data->district)
						<option value="{{$district->id}}" data="{{$district->province_id}}" selected="selected">{{ $district->name}}</option>
						@else
						<option value="{{$district->id}}" data="{{$district->province_id}}">{{ $district->name}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<div class="col-lg-6">
					<label>Address</label><br>
					<select name="address" id="address" class="form-control form-control-solid">
						<option value=" ">Select Address</option>
						@foreach ($address as $address)
						@if($address->id == $data->address)
						<option value="{{$address->id}}" data="{{$address->district_id}}" selected="selected">{{$address->title}}</option>
						@else
						<option value="{{$address->id}}" data="{{$address->district_id}}">{{$address->title}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Contact</label><br>
					<input name="contact" type="phone" class="form-control form-control-solid" placeholder="Enter contact" required autocomplete="off" value="{{$data->contact}}" />
				</div>
				<div class="col-lg-6">
					<label>Mobile 1</label>
					<input name="contact_1" type="phone" class="form-control form-control-solid" placeholder="Enter mobile 1" autocomplete="off" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Mobile 2</label><br>
					<input name="contact_2" type="phone" class="form-control form-control-solid" placeholder="Enter Mobile 2" autocomplete="off" />
				</div>
				<div class="col-lg-6">
					<label>Mobile 3</label><br>
					<input name="contact_3" type="phone" class="form-control form-control-solid" placeholder="Enter Mobile 3" autocomplete="off" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Mobile 4</label><br>
					<input name="contact_4" type="phone" class="form-control form-control-solid" placeholder="Enter Mobile 4" autocomplete="off" />
				</div>
				<div class="col-lg-6">
					<label>Mobile 5</label><br>
					<input name="contact_5" type="phone" class="form-control form-control-solid" placeholder="Enter Mobile 5" autocomplete="off" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Owner</label><br>
					<input name="owner" type="text" class="form-control form-control-solid" placeholder="Enter owner" autocomplete="off" />
				</div>
				<div class="col-lg-6">
					<label>Type</label><br>
					{{Form::select('type', [' ' => 'Select Type'] + $type_options ?? '',$data->type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Detail</label><br>
					<select name="address" id="address" class="form-control form-control-solid">
						@foreach ($dealer_details as $dealer_detail)
						@if($dealer_detail->dealer_id == $data->id)
						<option value="{{$dealer_detail->dealer_id}}" data="{{$dealer_detail->dealer_id}}" selected="selected">{{$dealer_detail->meta_name}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<div class="col-lg-6">
					<label>Detail</label><br>
					<select name="address" id="address" class="form-control form-control-solid">
						@foreach ($dealer_details as $dealer_detail)
						@if($dealer_detail->dealer_id == $data->id)
						<option value="{{$dealer_detail->dealer_id}}" data="{{$dealer_detail->dealer_id}}" selected="selected">{{$dealer_detail->meta_value}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary mr-2">Save</button>
						<a href="{{route('dealers.index')}}" class="btn btn-secondary">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script src="{{asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
@endsection