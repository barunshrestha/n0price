{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">CSI Types</h3>
            
            
		</div>
        <div class="card-toolbar">
       
            <a href="/addCsiTypes" target="_blank" class="btn btn-primary font-weight-bolder"> New CSI Type</a>
       
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
					<th>Name</th>
					<th>Description</th>
					<th>Default Language</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($CsiTypes as $key=>$csiType)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$csiType->name}}</td>
					<td><p>{{$csiType->description}}</p></td>
					<td>{{$csiType->default_language}}</td>
					
					<td>
                    <a href="{{route('csiTypes.edit',$csiType->id)}}" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
@section('scripts')
<!-- <script src="{{asset('js/pages/crud/ktdatatable/base/html-table.js')}}" type="text/javascript"></script> -->
<script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
<script type="text/javascript">
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
				field: "Default Language",
				width: 70,
			},
            {
				field: "Name",
				width: 150,
			},
            {
				field: "Description",
				width: 750,
			},
			
		],
		search: {
			input: $('#kt_datatable_search_query_csiTypes'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-solid-complain').select2();
	});
</script>

<style>
	.flagged {}
</style>
@endsection