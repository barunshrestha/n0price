{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
<div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox"> 
<label for="collapsible" class="lbl-toggle">Filters</label>
<div class="collapsible-content"><div class="content-inner">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Sales
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/rpt_filterSales','method' => 'get']) }}
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
                    {{Form::select('dealer_id',[' ' => '-Select Dealer-'] + $dealers,$dealer_id, ['class' =>  'form-control-role', 'autocomplete' => 'off'])}}
				</div>	
                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Group By</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
                    {{Form::select('group_by',['' => '-Select Group-','Model' =>'Model','Dealer' =>'Dealer'] ,$group_by, ['class' =>  'form-control-role', 'autocomplete' => 'off'])}}
				</div>
                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Payment Type</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
				{{ Form::select('payment_type[]', $payment_type_options, Request::get('payment_type') ?: Request::old('payment_type'), ['class' => 'form-control select2-control ', 'multiple'=>'multiple','name'=>'payment_type[]','id'=>'payment_type']) }}

				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="start_date" type="date" class="form-control form-control-solid" value="{{$start_date}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<input name="end_date" type="date" class="form-control form-control-solid" value="{{$end_date}}" />
				</div>
				
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
			</div>

			{{ Form::close() }}
		</div>
	</div>
	</div></div></div>
	<div class="card-body">
		

		<table class="" id="kt_datatable_enquiries">
			<thead>
				<tr>
					<th>No</th>
					<th>Date of sale</th>
					<th>Dealer</th>
					<th>Payment type</th>
					
					<th>Model</th>
					<th>Total</th>
					<th title="Field #6">Action</th>

				</tr>
			</thead>
			<tbody>
                
				@foreach($data as $key=>$sales)
               
				<tr>
					<td>{{$key+1}}</td>
					
					<td>{{$sales['date_of_sale']}}</td>
					<td>{{$sales['dealer']}}</td>
					<td>{{$sales['payment_type']}}</td>
                    <td>{{$sales['model']}}</td>
                    <td>{{$sales['total']}}</td>

					<td>
						
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
<script src = "https://code.jquery.com/jquery-3.5.1.js"></script>
<script src = "https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src = "https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src = "https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script type="text/javascript">
</script>
<script>
	$(document).ready(function() {
		//$('.form-control-role').select2();
		$('#kt_datatable_enquiries').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				 'excel', 'pdf'
			],
			"pageLength":20
  		});
		  $('.form-control-role').select2();
          $(".select2-control").select2({ width: '100%' });
		  $('.collapse').collapse();
	});
</script>

<style>
	.flagged {}

	input[type='checkbox'] { display: none; } 
	.wrap-collabsible { margin: 1.2rem 0; } 
	.lbl-toggle { 
		display: block; 
		font-weight: bold; 
		font-family: monospace; 
		font-size: 1.2rem; 
		text-transform: uppercase; 
		text-align: center; 
		padding: 1rem; 
		color: #DDD; 
		background: #0069ff; 
		cursor: pointer; 
		border-radius: 7px; 
		transition: all 0.25s ease-out; 
	} 
	.lbl-toggle:hover { color: #FFF; } 
	.lbl-toggle::before { 
		content: ' '; 
		display: inline-block; 
		border-top: 5px solid transparent; 
		border-bottom: 5px solid transparent; 
		border-left: 5px solid currentColor; 
		vertical-align: middle; 
		margin-right: .7rem; 
		transform: translateY(-2px); 
		transition: transform .2s ease-out; 
	} 
	.toggle:checked+.lbl-toggle::before { transform: rotate(90deg) translateX(-3px); } 
	.collapsible-content { max-height: 0px; overflow: hidden; transition: max-height .25s ease-in-out; } 
	.toggle:checked + .lbl-toggle + .collapsible-content { max-height: 350px; } 
	.toggle:checked+.lbl-toggle { border-bottom-right-radius: 0; border-bottom-left-radius: 0; } 
	.collapsible-content .content-inner { 
		background: rgba(0, 105, 255, .2); 
		border-bottom: 1px solid rgba(0, 105, 255, .45); 
		border-bottom-left-radius: 7px; 
		border-bottom-right-radius: 7px; 
		padding: .5rem 1rem; 
	} 
	.collapsible-content p { margin-bottom: 0; }
</style>
@endsection