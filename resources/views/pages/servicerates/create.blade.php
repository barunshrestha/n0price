{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Create New Service Rate</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('servicerates.store')}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Model:</label><br>
					<select name="model" id="model" class="form-control form-control-solid">
						<option value="0">Select Model</option>
						@foreach($model as $model)
						<option value="{{$model->model}}" title="{{$model->model}}">{{$model->model}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-lg-6">
					<label>Rate:</label><br>
					<input name="rate" type="number" class="form-control form-control-solid" placeholder="Enter Product" required autocomplete="off"" />
				</div>
			</div>
			<div class=" form-group row">
					<div class="col-lg-6">
						<label>Effective date:</label><br>
						<input name="effective_date" type="date" class="form-control form-control-solid" placeholder="Enter Effective date" required autocomplete="off" />
					</div>
					<div class="col-lg-6">
						<label>Product:</label><br>
						<input name="sku_code" type="text" class="form-control form-control-solid" placeholder="Enter Product" required autocomplete="off" />
					</div>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6">
							<button type="submit" class="btn btn-primary mr-2">Save</button>
							<a href="{{route('servicerates.index')}}" class="btn btn-secondary">Cancel</a>
						</div>
					</div>
				</div>
			</div>
	</form>
</div>
@endsection
{{-- Scripts Section --}}