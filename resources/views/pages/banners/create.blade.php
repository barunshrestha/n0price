{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Create New Banner</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('banners.store')}}" method="post" enctype="multipart/form-data">
	{{csrf_field()}}
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-8">
					<label>Title</label>
					<input name="title" type="text" class="form-control form-control-solid" placeholder="Title" required autocomplete="off" />
				</div>
				<div class="col-lg-8">
					<label>Description</label><br>
					<textarea name="description" type="text" class="form-control form-control-solid" placeholder="Description" required autocomplete="off" ></textarea>
				</div>
				<div class="col-lg-8">
					<label>Added Date</label><br>
					<input name="date" type="date" class="form-control form-control-solid" placeholder="Added date" required autocomplete="off" />
				</div>
				<div class="col-lg-8">
					<label>Status</label>
					<select class="form-control form-control-solid" name="status">
						<option>Select Status</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
                <div class="col-lg-8">
					<label>Upload Image</label>
					<input name="upload_image" type="file" class="form-control form-control-solid" required />
				</div>

			</div>
			<div class="card-footer">
				<div class="row">
				<div class="col-lg-6">
		            <button type="submit" class="btn btn-primary mr-2">Save</button>
		            <a href="{{route('banners.index')}}" class="btn btn-secondary">Cancel</a>
		        </div>
		    </div>
	        </div>
	    </div>
 	</form>
</div>
@endsection
{{-- Scripts Section --}}
