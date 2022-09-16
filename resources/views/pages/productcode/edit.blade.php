{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Edit Product Code Info</h3>
	</div>
	@include('layout.partials.productcode_info',['id' => $data->id])

	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('productcode.update',$data->id)}}" method="POST" enctype="multipart/form-data">

		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Plant</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="plant" type="text" class="form-control form-control-solid name" placeholder="Enter Plant" value="{{$data->plant}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Model</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="model" type="text" class="form-control form-control-solid name" placeholder="Enter Model" required value="{{$data->model}}" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Variant</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="variant" type="text" class="form-control form-control-solid name" placeholder="Enter Variant" value="{{$data->variant}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">Color</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="colour" type="text" class="form-control form-control-solid name" placeholder="Enter Color" required value="{{$data->colour}}" />
				</div>

			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">SKU Code</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="sku_code" type="text" class="form-control form-control-solid name" placeholder="Enter SKU Code" required value="{{$data->sku_code}}" />
				</div>
				<label class="col-form-label text-right col-lg-2 col-sm-12">SKU Description</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="sku_description" type="text" class="form-control form-control-solid name" placeholder="Enter SKU Description" value="{{$data->sku_description}}" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Brake Type</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="brake_type" type="text" class="form-control form-control-solid" placeholder="Enter Brake Type" value="{{$data->brake_type}}" />
				</div>

				<label class="col-form-label text-right col-lg-2 col-sm-12">Start Type</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="start_type" type="text" class="form-control form-control-solid" placeholder="Enter Start Type" value="{{$data->start_type}}" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Wheel Type</label>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<input name="wheel_type" type="text" class="form-control form-control-solid" placeholder="Enter Wheel Type" value="{{$data->wheel_type}}" />
				</div>
			</div>


			<div class="form-group row">
				<label class="col-form-label text-right col-lg-2 col-sm-12">Notes</label>
				<div class="col-lg-10 col-md-10 col-sm-12">
					<input name="notes" type="text" class="form-control form-control-solid name" placeholder="Enter Notes" value="{{$data->notes}}" />
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

@endsection
{{-- Scripts Section --}}
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

	});
</script>
@endsection