{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Create New Service Coupon Setting</h3>
	</div>
	<!--begin::Form-->
    <?php
        $service_type_list = array('free' => 'free','paid' => 'paid');
    ?>
	<form class="form" id="kt_form" action="{{route('servicecouponsettings.store')}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">FSC No.</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="fsc_no" type="text" class="form-control form-control-solid name" placeholder="Enter FSC No." required autocomplete="off" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Service Type</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					{{Form::select('service_type', $service_type_list ?? '',$data->service_type ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Effective Date</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="effective_date" type="date" class="form-control form-control-solid" placeholder="Enter Effective Date" required autocomplete="off"/>
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Duration (No. of days)</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="duration" type="text" class="form-control form-control-solid name" placeholder="Enter Duration" required autocomplete="off" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Distance (Km Range)</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="distance" type="text" class="form-control form-control-solid name" placeholder="Enter Distance" required autocomplete="off" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Discount</label>
				<div class="col-lg-2 col-md-2 col-sm-12">
					<input name="discount" type="text" class="form-control form-control-solid name" placeholder="Enter Discount" required autocomplete="off" />
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Instruction</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                    <textarea name="instruction" rows="4" cols="50" class="form-control form-control-solid Instruction" 
                    placeholder="Enter Instruction" required autocomplete="off"></textarea>
				</div>
			</div>
			
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('servicecouponsettings.index')}}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script type="text/javascript">
    	$(document).ready(function(){
    		
    	});
    </script>
@endsection