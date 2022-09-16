{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
@section('scripts')
<script type="text/javascript">

</script>
@endsection
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Enquiries</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('enquiries.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Dealer</label>
					{{Form::select('dealers', [' ' => '-Select Dealer-'] + $dealers ?? '',$data->dealers->id ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}

				</div>
				<div class="col-lg-6">
					<label>Name</label>
					<input name="name" type="text" class="form-control form-control-solid" placeholder="Enter Dealer name" required autocomplete="off" value="{{$data->name}}" />
				</div>

				<div class="col-lg-6">
					<label>Contact number</label>
					<input name="contact_no" type="text" class="form-control form-control-solid" placeholder="Enter Dealer name" required autocomplete="off" value="{{$data->contact_no}}" />
				</div>

				<div class="col-lg-6">
					<label>Date</label><br>
					<input name="date" type="date" class="form-control form-control-solid" placeholder="Date" autocomplete="off" value="{{$data->date}}" />
				</div>

				<div class="col-lg-6">
					<label>Gender</label><br>

					{{Form::select('gender', [' ' => '-Select Gender-'] + $gender ?? '',$data->gender ?? '',['class' => 'form-control form-control-solid','autocomplete' => 'off' ])}}
				</div>
				<div class="col-lg-6">
					<label>Age</label><br>
					{{Form::select('age', [' ' => '-Select Age-'] + $age ?? '',$data->age ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>


				<div class="col-lg-6">
					<label>Products</label><br>
					<select name="meta_name" id="meta_value" class="form-control form-control-solid">
						<option value="0">Select Model</option>
						@foreach($enquiries as $key=>$enquiry)
						@foreach($enquiry['models'] as $key=>$model)
						<option value="{{$model}}" title="{{$model}}" selected="selected">{{$model}}</option>
						<br />
						@endforeach
						@endforeach

					</select>
				</div>
				<div class="col-lg-6">
					<label>Sales Type (Exchange)</label><br>
					{{Form::select('sales_type', [' ' => '-Select Sales Type-'] + $sales_type ?? '',$data->sales_type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<div class="col-lg-6">
					<label>Payment Type</label><br>
					{{Form::select('payment_type', [' ' => '-Select Payment Type-'] + $payment_type ?? '',$data->payment_type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<div class="col-lg-6">
					<label>Test Ride</label><br>
					{{Form::select('test_ride', [' ' => '-Select Test Ride-'] + $test_ride ?? '',$data->test_ride ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<div class="col-lg-6">
					<label>Test Ride Date</label><br>
					<input name="test_ride_date" type="date" class="form-control form-control-solid" placeholder="Date" autocomplete="off" value="{{$data->test_ride_date}}" />
				</div>
				<div class="col-lg-6">
					<label>Sold To Customer Date</label><br>
					<input name="sold_date" type="date" class="form-control form-control-solid" placeholder="Date" autocomplete="off" value="{{$data->sold_date}}" />
				</div>

			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary mr-2">Save</button>
						<a href="{{route('enquiries.index')}}" class="btn btn-secondary">Cancel</a>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-solid-survey').select2();
	});
</script>
@endsection