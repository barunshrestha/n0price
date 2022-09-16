{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Banner</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('roles.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-8">
					<label>Title</label>
					<input name="name" type="text" class="form-control form-control-solid" placeholder="Enter Title name" required autocomplete="off" value="{{$data->title}}" />
				</div>
				<div class="col-lg-8">
					<label>Description</label>
					<input name="name" type="textarea" class="form-control form-control-solid" placeholder="Enter Description" required autocomplete="off" value="{{$data->description}}" />
				</div>
				<div class="col-lg-8">
					<label>Added Date</label>
					<input name="added_date" type="date" class="form-control form-control-solid" required value="{{$data->date}}" />
				</div>

				<div class="col-lg-8">
					<label>Status</label>
					<select class="form-control form-control-solid">
						<option>Select Status</option>
						<option value="{{$data->status}}">Active</option>
						<option value="{{$data->status}}">Inactive</option>
					</select>
				</div>
				<div class="col-lg-8">
					<label>Upload Image</label>
					<input name="upload_image" type="file" class="form-control form-control-solid" required value="{{$data->img_name}}" />
				</div>
				<div class="col-lg-12">
					<br />
					<button type="submit" class="btn btn-primary mr-2">Save</button>
					<a href="{{route('banners.index')}}" class="btn btn-secondary">Cancel</a>
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