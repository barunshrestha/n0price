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
			<h3 class="card-label">Vehicles
		</div>
		<div class="card-toolbar">
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
			</span>New User</a>
			
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
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
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
					<th>Registration No</th>
				 	<th>Product</th>
					<th>Chasis No</th>
					<th>Dealer</th>
					<th>Customer</th>
					<th>Challan date</th>
					<th>Date of Sale</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				
				@foreach($connectlogin_histories as $key=>$connecthist)
				
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$connecthist->registration_no}}</td>
					<td>{{$connecthist->battery_no}}</td>
					<td>{{$connecthist->chasis_no}}</td>
					<td>{{$connecthist->challan_date}}</td>
					<td>{{$connecthist->date_of_sale}}</td>
                   

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
	    		field : "No",
	   			width: 20,
	  		},
	  		{
	    		field : "E-mail",
	   			width: 200,
	  		},
	  		
	  		],
	      search: {
	        input: $('#kt_datatable_search_query'),
	        key: 'generalSearch'
	      }
	    });
	   
    	
    </script>

	<style>
		.flagged{
			
		}
	</style>
@endsection