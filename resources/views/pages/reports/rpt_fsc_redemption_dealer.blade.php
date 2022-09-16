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
			<h3 class="card-label">FSC Redemption by Dealer
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filterFscRedemptionDealer','method' => 'get']) }}
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="start_date" type="date" class="form-control form-control-solid" value="{{$start_date}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="end_date" type="date" class="form-control form-control-solid" value="{{$end_date}}" />
				</div>
				
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
			</div>

			{{ Form::close() }}
		</div>
	</div>
	</div></div></div>
	<div class="card-body">
		

		<table class="" id="kt_datatable_fsc_redemption">
			<thead>
				<tr>
					<th>No</th>
					<th>Dealer</th>
					<th>Sales</th>
					<th>FSC 1</th>
					<th>FSC 2</th>
					<th>FSC 3</th>
					<th>FSC 4</th>
                    <th>FSC 5</th>
					<th>FSC 6</th>
                    <th>FSC 7</th>
                    <th>FSC 8</th>
                    <th>FSC 9</th>
                    <th>FSC 10</th>
                    <th>FSC 11</th>
                    <th>FSC 12</th>
				</tr>
			</thead>
			<tbody>
                <?php $cnt = 1;?>
				@foreach($data as $datum)
				<tr>
					<td>{{$cnt++}}</td>
					<td><a href="{{route('dealers.show', $datum->dealer_id)}}">{{isset($datum->name) ?$datum->name:"" }}</a></td>
                    <td>{{$datum->total_sales}}</td>
					<td>{{$datum->First}}</td>
					<td>{{$datum->Second}}</td>
					<td>{{$datum->Third}}</td>
                    <td>{{$datum->Fourth}}</td>
					<td>{{$datum->Fifth}}</td>
                    <td>{{$datum->Sixth}}</td>
                    <td>{{$datum->Seventh}}</td>
                    <td>{{$datum->Eighth}}</td>
                    <td>{{$datum->Ninth}}</td>
                    <td>{{$datum->Tenth}}</td>
                    <td>{{$datum->Eleventh}}</td>
                    <td>{{$datum->Twelfth}}</td>
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
		$('#kt_datatable_fsc_redemption').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				 'excel', 'pdf'
			],
			"pageLength":20
  		});
		  $('.form-control-role').select2();
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