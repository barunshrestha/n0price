{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header">
		<h3 class="card-title">Update Csi Type</h3>
	</div>
	<!--begin::Form-->
	<form class="form" id="kt_form" action="{{route('csiTypes.update',$data->id)}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
		<div class="card-body">
        <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Name:*</label>
				<div class="col-lg-6 col-md-6 col-sm-9">
					<input name="name" type="text" class="form-control form-control-solid name" placeholder="Enter Name" required value="{{$data->name}}" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Description:*</label>
				<div class="col-lg-9 col-md-9 col-sm-12">
                    <textarea name="description" id="description" class="form-input form-text" rows="10" cols="125" required >{{$data->description}}</textarea>
                </div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Default Language:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                {{Form::select('default_language', ['en'=>'English','np' => 'Nepali'],$data->default_language, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
				</div>
			</div>

            <div class="form-group row">
				<label class="col-form-label text-right col-lg-3 col-sm-12">Active:*</label>
				<div class="col-lg-1 col-md-1 col-sm-2">
                {{Form::select('default_language', ['0'=>'Active','1' => 'Inactive'],$data->active, ['class' =>  'form-control form-control-solid role', 'autocomplete' => 'off','required'=>true])}}
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
					<a href="{{route('csiTypes.index')}}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Questionnaires</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{route('csiQuestionnaire.create',['csi_type_id' =>$csi_type_id])}}" target="_blank" class="btn btn-primary font-weight-bolder"> New Question</a>
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
					<th>Category</th>
					<th>Key</th>
					<th>Question (En)</th>
                    <th>Question (Np)</th>
                    <th>Weightage</th>
                    <th>Order</th>
                    <th>Question Type</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($questionnaires as $key=>$question)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$question->csi_category}}</td>
					<td><p>{{$question->csi_key}}</p></td>
					<td>{{$question->en_question}}</td>
					<td>{{$question->np_question}}</td>
                    <td>{{$question->weightage}}</td>
                    <td>{{$question->order}}</td>
                    <td>{{$question->question_type}}</td>
					<td>
                    <a href="{{route('csiQuestionnaire.edit',$question->id)}}" target="_blank" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
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
            
            {
				field: "Weightage",
				width: 75,
			},
            {
				field: "Order",
				width: 50,
			},
            {
				field: "Question Type",
				width: 70,
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