{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">New Option</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('csiQuestionnaireOption.store')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="POST" enctype="multipart/form-data">
        <input type="hidden" name ="csi_questionnaire_id" value= "{{$csi_question_id}}">
		<div class="card-body">
        <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Option (En):*</label>
				<div class="col-lg-4 col-md-4 col-sm-6">
					<input name="en_option" type="text" class="form-control form-control-solid name" placeholder="Enter Option" required  />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Option (Np):*</label>
				<div class="col-lg-4 col-md-4 col-sm-6">
                    <input name="np_option" type="text" class="form-control form-control-solid name" placeholder="Enter Option" required  />
                </div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Value:</label>
				<div class="col-lg-2 col-md-2 col-sm-4">
                <input name="value" type="number" class="form-control form-control-solid name" placeholder="Enter Value"  />
				</div>
			</div>
            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Order:*</label>
				<div class="col-lg-2 col-md-2 col-sm-4">
                <input name="order" type="number" class="form-control form-control-solid name" placeholder="Enter Order" required  />
				</div>
			</div>

            
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('csiQuestionnaire.edit',$csi_question_id)}}" class="btn btn-secondary">Cancel</a>
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