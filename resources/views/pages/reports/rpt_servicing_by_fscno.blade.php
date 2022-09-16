{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
<style>
	tr:nth-child(even){background-color: #f2f2f2}

	table{
		margin: 0 0 40px 0
		width: 100%
		box-shadow: 0 1px 3px rgba(0,0,0,0.2)
		display: table
		
	}
	tr{
		display: table-row;
		background: #f6f6f6;
	}
	th{
		font-weight: 900;
		color: #ffffff;
		background: #ea6153;
	}
	td{
		margin:0px 5px 0px 5px;
		text-align: center;
	}
	th{
		padding:5px !important;
		text-align: center;
	}
	.bordered { 
		border-left: 1px solid #000000;
		border-right: 1px solid #000000; 
	}
	.bordered-left{
		border-left: 1px solid #000000;
	}
 
</style>
@endsection



{{-- Content --}}
@section('content')	
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Servicing Details by FSC No.
		</div>
        <div class="col-md-12 col-lg-12">
				{{ Form::open(['url' => '/filter_rpt_servicing_by_fscno','method' => 'get']) }}
					<div class="form-group row">
						<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
						<div class="col-lg-3 col-md-6 col-sm-6">
							{{Form::select('dealer_id', $dealers,$dealer_id, ['class' =>  'form-control role', 'autocomplete' => 'off','required'=>true])}}
						</div>
						<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
						<div class="col-lg-3 col-md-2 col-sm-6">
							<input name="date_from" type="date" class="form-control form-control-solid"  required value="{{$date_from}}"/>
						</div>
						<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
						<div class="col-lg-3 col-md-2 col-sm-6">
							<input name="date_to" type="date" class="form-control form-control-solid"  required value="{{$date_to}}"/>
						</div>
						<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
					</div>
				{{ Form::close() }}
		</div>
		
	</div>
	<div class="card-body">
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
		<div style="overflow-x:auto;">
		@if(count($servicings) > 1)
		<table class="" id="datatable" role="grid">
			<thead>
				<tr>
					<th rowspan="2">No</th>
				 	<th rowspan="2">Model</th>
					<th colspan="3" >FSC 1</th>
					<th colspan="3" >FSC 2</th>
					<th colspan="3" >FSC 3</th>
                    <th colspan="3" >FSC 4</th>
                    <th colspan="3" >FSC 5</th>
                    <th colspan="3">FSC 6</th>
                    <th colspan="3">FSC 7</th>
                    <th colspan="3">FSC 8</th>
                    <th colspan="3">FSC 9</th>
                    <th colspan="3">FSC 10</th>
                    <th colspan="3">FSC 11</th>
                    <th colspan="3">FSC 12</th>
					<th rowspan="2">Total</th>
				</tr>
                <tr>
					<th >Qty</th>
                    <th>Rate</th>
					<th >Amount</th>
					<th >Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
                    <th >Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
					<th >Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
                    <th >Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
					<th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
                    <th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
					<th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
                    <th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
					<th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
                    <th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>
					<th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>

				</tr>
			</thead>

			<tbody>
                
				@foreach($servicings as $key=>$servicing)
				<tr>
					<td>{{$key+1}}</td>
                    <td style="padding:5px!important;"><strong>{{$servicing->model_name}}<br/>({{$servicing->model_code}})</strong></td>
					<td class="bordered-left">{{$servicing->S1_Qty}}</td>
                    <td>{{$servicing->S1_Rate}}</td>
                    <td>{{$servicing->S1_Amount}}</td>
					<td class="bordered-left">{{$servicing->S2_Qty}}</td>
                    <td>{{$servicing->S2_Rate}}</td>
                    <td>{{$servicing->S2_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S3_Qty}}</td>
                    <td>{{$servicing->S3_Rate}}</td>
                    <td>{{$servicing->S3_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S4_Qty}}</td>
                    <td>{{$servicing->S4_Rate}}</td>
                    <td>{{$servicing->S4_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S5_Qty}}</td>
                    <td>{{$servicing->S5_Rate}}</td>
                    <td>{{$servicing->S5_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S6_Qty}}</td>
                    <td>{{$servicing->S6_Rate}}</td>
                    <td>{{$servicing->S6_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S7_Qty}}</td>
                    <td>{{$servicing->S7_Rate}}</td>
                    <td>{{$servicing->S7_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S8_Qty}}</td>
                    <td>{{$servicing->S8_Rate}}</td>
                    <td>{{$servicing->S8_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S9_Qty}}</td>
                    <td>{{$servicing->S9_Rate}}</td>
                    <td>{{$servicing->S9_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S10_Qty}}</td>
                    <td>{{$servicing->S10_Rate}}</td>
                    <td>{{$servicing->S10_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S11_Qty}}</td>
                    <td>{{$servicing->S11_Rate}}</td>
                    <td>{{$servicing->S11_Amount}}</td>
                    <td class="bordered-left">{{$servicing->S12_Qty}}</td>
                    <td>{{$servicing->S12_Rate}}</td>
                    <td>{{$servicing->S12_Amount}}</td>
                    <td class="bordered-left">{{$servicing->Total_Amount}}</td>

				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<h3> No Data available for selected period </h3>
		@endif
	</div>
	</div>
</div>
		
@endsection
@section('scripts')
    <!-- <script src="{{asset('js/pages/crud/ktdatatable/base/html-table.js')}}" type="text/javascript"></script> -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
	
    <script type="text/javascript">
		$(document).ready(function(){
			// $('#datatable').Datatable({
	    	// });
		});
    	// var datatable = $('#kt_datatable').Datatable({
	    // });
	   
    	
    </script>
@endsection