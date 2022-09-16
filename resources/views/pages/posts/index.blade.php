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
			<h3 class="card-label">Posts
				<span class="d-block text-muted pt-2 font-size-sm">List Of posts</span>
			</h3>
		</div>
		<div class="card-toolbar">
			<a href="{{route('posts.create')}}" class="btn btn-primary font-weight-bolder">
				<span class="svg-icon svg-icon-md">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<circle fill="#000000" cx="9" cy="15" r="6" />
							<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>New Post</a>

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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_post" />
								<span>
									<i class="flaticon2-search-1 text-muted"></i>
								</span>

							</div>
						</div>

						<div class="col-md-5  my-4 my-md-0">
							<div class="d-flex align-items-center">
								<label class="mr-3 mb-0 d-none d-md-block">Category</label>
								<select name="post_category_id" class="form-control form-control-solid" id="kt_datatable_search_category">
									<option value="">Select Category</option>

									@foreach($postcategories as $postcategory)
									<option value="{{$postcategory->name}}" title="{{$postcategory->name}}">
										@if($postcategory->name === "HeaderCategory")
										Header Category
										@else
										{{$postcategory->name}}
										@endif
									</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

				</div>
				<!-- <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
					<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
				</div> -->
			</div>
		</div>
		<table class="datatable datatable-bordered" id="kt_datatable">
			<thead>
				<tr>
					<th style="width: 10px !important;">No</th>
					<th>Title</th>
					<th>Category</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				@foreach($posts as $key=>$post)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$post->title}}</td>
					<td>
						@foreach($postcategories as $key=>$postcategory)
						@if($post->post_category_id == $postcategory->id)
						{{$postcategory->name}}
						@endif
						@endforeach
					</td>
					<td>{{$status_list[$post->status]}}</td>
					<td>
						<a href="{{route('posts.show',$post->id)}}" class="btn btn-icon btn-info btn-xs mr-2 viewBtn" data-toggle="tooltip" title="View">
							<i class="fa fa-eye"></i>
						</a>
						<a href="{{route('posts.edit',$post->id)}}" class="btn btn-icon btn-success btn-xs mr-2 edit" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
						<form action="{{ route('posts.destroy', $post->id) }}" style="display: inline-block;" method="post">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							<button type="button" value="Delete" class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip" title="Delete">
								<i class="fa fa-trash"></i>
							</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	var datatable = $('#kt_datatable').KTDatatable({
		data: {
			saveState: {
				cookie: false
			}
		},
		columns: [{
				field: "No",
				width: 20,
			},
			{
				field: "Title",
				width: 200,
			},
			{
				field: "Category",
				width: 200,
			},

			{
				field: "Action",
				width: 400,
			},

		],
		search: {
			input: $('#kt_datatable_search_query_post'),
			key: 'generalSearch'
		}
	});
	$('#kt_datatable_search_status').on('change', function() {
		datatable.search($(this).val().toLowerCase(), 'Status');
	});
	$('#kt_datatable_search_category').on('change', function() {
		datatable.search($(this).val().toLowerCase(), 'Category');

	});

	$('#kt_datatable_search_type').on('change', function() {
		datatable.search($(this).val().toLowerCase(), 'Type');
	});
	$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
</script>
@endsection
