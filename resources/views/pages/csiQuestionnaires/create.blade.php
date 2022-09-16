{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">New Question</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('csiQuestionnaire.store')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="POST" enctype="multipart/form-data">
        <input type="hidden" name ="csi_type_id" value= "{{$csi_type_id}}">
		<div class="card-body">
        <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Category:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
					<input name="csi_category" type="text" class="form-control form-control-solid name" placeholder="Enter Category" required  />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Key:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
                    <input name="csi_key" type="text" class="form-control form-control-solid name" placeholder="Enter Key" required  />
                </div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question (En):*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                <input name="en_question" type="text" class="form-control form-control-solid name" placeholder="Enter Question" required />
				</div>
			</div>
            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question (Np):*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                <input name="np_question" type="text" class="form-control form-control-solid name" placeholder="Enter Question" required  />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Weightage:</label>
				<div class="col-lg-2 col-md-2 col-sm-4">
                <input name="weightage" type="number" class="form-control form-control-solid name" placeholder="Enter weightage" />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Order:*</label>
				<div class="col-lg-2 col-md-2 col-sm-4">
                <input name="order" type="number" class="form-control form-control-solid name" placeholder="Enter order" required  />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question Type:*</label>
				<div class="col-lg-2 col-md-4 col-sm-6">
                {{Form::select('question_type', $question_types,null, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
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
	$(document).ready(function() {
       
		
	});
</script>
@endsection