{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Role</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('roles.update',$data->id)}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6">
					<label>Role Name</label>
					<input name="name" type="text" class="form-control form-control-solid" placeholder="Enter Role name" required autocomplete="off" value="{{$data->name}}" />
				</div>
				<div class="col-lg-6">
					<label>Alias</label><br>
					<input name="alias" type="text" class="form-control form-control-solid" placeholder="Enter Alias" required autocomplete="off" value="{{$data->alias}}" />
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary mr-2">Submit</button>
						<a href="{{route('roles.index')}}" class="btn btn-secondary">Cancel</a>
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