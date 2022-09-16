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
			<div class="col-md-12 col-lg-12">
				{{ Form::open(['url' => '/rpt_filterReminders','method' => 'get']) }}
					<div class="form-group row">
						<label class="col-form-label text-right col-md-2 col-lg-1 col-sm-12">Select dealer</label>
						<div class="col-lg-3 col-md-3 col-sm-12">
							{{Form::select('dealer_id', $dealers,$dealer_id, ['class' =>  'form-control role', 'autocomplete' => 'off','required'=>true])}}
						</div>
						<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
					</div>
					
				{{ Form::close() }}
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
            <div class="row">
				
				<div class="col-md-6">
					
				</div>
			</div>
		</div>
		<?php if(isset($reminders)) {?>
		<table class="datatable datatable-bordered" id="kt_datatable">
			<thead>
				<tr>
					<th>S No</th>
					<th>Vehicle</th>
				 	<th>Customer</th>
					<th>Exceeded days</th>
					
					<th>First Call</th>
					<th>Second Call</th>
					<th>Lost</th>
					<th title="Field #6">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($reminders as $key=>$reminder)
				<tr>
					<td>{{$key + 1}}</td>
					<td>{{$reminder->registration_no}}</td>
					<td>{{$reminder->customer_name .", ".$reminder->customer_number}}</td>
					<td>{{abs($reminder->exceed_days)}}</td>
					<td>{{$reminder->call_1}}</td>
					<td>{{$reminder->call_2}}</td>
					<td>
						<?php 
							if((abs($reminder->exceed_days)) > 15){ 
								echo '<i class="fas fa-check" style="color:red;"></i>';
							}
						?>
					</td>
					<td>
						<a href="{{route('servicecoupons.edit',$reminder->service_coupon_id)}}" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
						
					</td>
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