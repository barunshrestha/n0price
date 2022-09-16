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
			<h3>Model Details</h3>
	</div>
	<div class="card-body">
    <div class="alert alert-info">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        <strong>The following report displays available no. of products on different dealers / locations.</strong> 
    </div>
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
            <div class="row">
				
				<div class="col-md-6">
					
				</div>
			</div>
		</div>
		<?php if(isset($vehicles)) {?>
		<table class="datatable datatable-bordered" id="kt_datatable">
			<thead>
				<tr>
					<th>S No</th>
					
				 	<th>Dealer</th>
                    <th>Vehicle</th>
                    <th>Engine / Chasis</th>
					<th>Challan Date</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($vehicles as $key=>$vehicle)
				<tr>
					<td>{{$key + 1}}</td>
					<td>{{$vehicle->dealer_name}}</td>
                    <td>{{$vehicle->registration_no}}</td>
					<td>{{$vehicle->engine_no.' / '.$vehicle->chasis_no}}</td>
					<td>{{$vehicle->challan_date}}</td>
                    <td><a href="{{route('vehicles.edit',$vehicle->id)}}" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                        <i class="fa fa-pen"></i>
                    </a></td>
					
				</tr>
				@endforeach
			</tbody>
		</table>
        <?php } // end if ?>
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
	   
	    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    	
    </script>
@endsection