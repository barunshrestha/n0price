{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Create New CSI Type</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('csiTypes.store')}}" method="post">
		{{csrf_field()}}
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Name:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
					<input name="name" type="text" class="form-control form-control-solid name" placeholder="Enter Name" required autocomplete="off" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Description:*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                    <textarea name="description" id="description" class="form-input form-text" rows="10" cols="125"></textarea>
                </div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Default Language:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                {{Form::select('default_language', ['en'=>'English','np' => 'Nepali'],null, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Active:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                {{Form::select('default_language', ['0'=>'Active','1' => 'Inactive'],null, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
				</div>
			</div>
			
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('users.index')}}" class="btn btn-secondary">Cancel</a>
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