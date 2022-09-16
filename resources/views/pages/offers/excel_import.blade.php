{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
@section('scripts')
<script type="text/javascript">

</script>
@endsection
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Import Enquiries</h3>
        <a href="/enquiries_excel_download_sample" class="" data-toggle="tooltip" title="Excel Sample">
           Download Sample Excel
        </a>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="/enquiries_excel_import_submit" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		
		<div class="card-body">
			<div class="form-group row">
                <input name="file_name" type="file" accept="excel/*" class="form-control form-control-solid" placeholder="Choose File" required autocomplete="off" />
            </div>
			<div class="card-footer">
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary mr-2">Save</button>
						<a href="{{route('enquiries.index')}}" class="btn btn-secondary">Cancel</a>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-solid-survey').select2();
	});
</script>
@endsection