{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Question</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('csiQuestionnaire.update',$data->id)}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<input type="hidden" name="csi_type_id" value ="{{$data->csi_type_id}}">
		<div class="card-body">
        <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Category:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
					<input name="csi_category" type="text" class="form-control form-control-solid name" placeholder="Enter Category" required value="{{$data->csi_category}}" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Key:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
                    <input name="csi_key" type="text" class="form-control form-control-solid name" placeholder="Enter Key" required value="{{$data->csi_key}}" />
                </div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question (En):*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                <input name="en_question" type="text" class="form-control form-control-solid name" placeholder="Enter Question" required value="{{$data->en_question}}" />
				</div>
			</div>
            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question (Np):*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                <input name="np_question" type="text" class="form-control form-control-solid name" placeholder="Enter Question" required value="{{$data->np_question}}" />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Weightage:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                <input name="weightage" type="text" class="form-control form-control-solid name" placeholder="Enter weightage" required value="{{$data->weightage}}" />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Order:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                <input name="order" type="number" class="form-control form-control-solid name" placeholder="Enter order" required value="{{$data->order}}" />
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Question Type:*</label>
				<div class="col-lg-2 col-md-4 col-sm-6">
                {{Form::select('question_type', $question_types,$data->question_type, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('csiTypes.edit',$data->csi_type_id)}}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Options</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{route('csiQuestionnaireOption.create',['csi_question_id'=>$data->id])}}" target="_blank" class="btn btn-primary font-weight-bolder"> New Option</a>
        </div>
		
	</div>
	<div class="card-body">
		<!--begin: Search Form-->
		<!--begin::Search Form-->
		<div class="mb-7">
			<div class="row align-items-center">
				<div class="col-lg-9 col-xl-8">
					<div class="row align-items-center">
						<div class="col-md-4 my-2 my-md-0">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_csiTypes" />
								<span>
									<i class="flaticon2-search-1 text-muted"></i>
								</span>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<table class="datatable datatable-bordered" id="kt_datatable">
			<thead>
				<tr>
					<th>No</th>
					<th>Option (En)</th>
					<th>Option (Np)</th>
					<th>value</th>
                    <th>Order</th>
                   
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($options as $key=>$option)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$option->en_option}}</td>
					<td>{{$option->np_option}}</td>
					<td>{{$option->value}}</td>
                    <td>{{$option->order}}</td>
                  
					<td>
                    <a href="{{route('csiQuestionnaireOption.edit',$option->id)}}" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
					<form action="{{ route('csiQuestionnaireOption.destroy', $option->id) }}" style="display: inline-block;" method="post">
						{{ method_field('DELETE') }}
						{{ csrf_field() }}
						<button type="button" value="Delete" class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
					</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
        var datatable = $('#kt_datatable').KTDatatable({
		data: {
			saveState: {
				cookie: false
			}
		},
		columns: [
            {
				field: "No",
				width: 30,
			},
        ],
		search: {
			input: $('#kt_datatable_search_query_csiTypes'),
			key: 'generalSearch'
		}
	});
		
	});
</script>
@endsection