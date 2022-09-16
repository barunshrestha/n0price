{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Post</h3>
	</div>

	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('posts.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Category</label>
					<select name="post_category_id" id="post_category_id" class="form-control form-control-solid">
						<option value="0">Select Category</option>

						@foreach($postcategories as $postcategory)
						@if($postcategory->id == $data->post_category_id)
						<option value="{{$postcategory->id}}" title="{{$postcategory->name}}" selected="selected">{{$postcategory->name}}</option>
						@else
						<option value="{{$postcategory->id}}" title="{{$postcategory->name}}">{{$postcategory->name}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<div class="col-lg-6">
					<label>Title:</label><br>
					<input name="title" type="text" class="form-control form-control-solid" placeholder="Enter Title" required autocomplete="off" value="{{$data->title}}" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Description:</label><br>
						<textarea name="description" id="editor">
						{!!$data->description!!}
						</textarea>
				</div>

				<div class="col-lg-6">
					<label>Status:</label><br>
					{{Form::select('status', $status ?? '',$data->status ?? '', ['class' =>  'form-control form-control-solid', 'autocomplete' => 'off'])}}
				</div>
			</div>
			<div class="form-group row">
				<!-- <div class="col-lg-6">
					<label>Price:</label><br>
					<input name="price" type="number" class="form-control form-control-solid" placeholder="Enter Price" required autocomplete="off" value="{{$data->price}}" />
				</div> -->
				<div class="col-lg-6">
					<label>Image:</label><br>
					<input name="img_name" type="file" accept="image/*" class="form-control form-control-solid" placeholder="Insert image" autocomplete="off" value="{{$data->img_name}}" />
				</div>
			</div>

			<div class="card-footer">
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary mr-2">Save</button>
						<a href="{{route('posts.index')}}" class="btn btn-secondary">Cancel</a>
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
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
	ClassicEditor
		.create(document.querySelector('#editor'))
		.catch(error => {
			console.error(error);
		});
</script>
@endsection