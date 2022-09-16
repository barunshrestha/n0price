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

<?php
        $months = array(
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );
        $years = array_combine(range(date("Y"), 2019), range(date("Y"), 2019));
    ?>
 
<div class="card card-custom">
<div class="row align-items-center"><h3 style="left:15px;top:5px;position: relative;">FSC Redemption by Month</h3></div>   

<div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox"> 
<label for="collapsible" class="lbl-toggle">Filters</label>
<div class="collapsible-content"><div class="content-inner">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filterFscRedemptionMonth','method' => 'get']) }}
			
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-sm-2">Year</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
                    {{Form::select('year',[' ' => '-Select Year-'] + $years,$current_year, ['class' =>  'form-control-role', 'autocomplete' => 'off'])}}
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
					<th>Month</th>
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
                    <th class="summary_row"><strong>Total</strong></th>
				</tr>
			</thead>
			<tbody>
                <?php $cnt = 1;?>
				@foreach($data as $datum)
				<tr class = "<?php echo ($datum->service_month == 'Total' || $datum->service_month == 'Total AVG')?'summary_row': '';?>">
					<td><?php echo isset($months[$datum->service_month])? $months[$datum->service_month]:$datum->service_month; ?></td>
					<td>{{(int)$datum->FSC1}}</td>
					<td>{{(int)$datum->FSC2}}</td>
					<td>{{(int)$datum->FSC3}}</td>
                    <td>{{(int)$datum->FSC4}}</td>
					<td>{{(int)$datum->FSC5}}</td>
                    <td>{{(int)$datum->FSC6}}</td>
                    <td>{{(int)$datum->FSC7}}</td>
                    <td>{{(int)$datum->FSC8}}</td>
                    <td>{{(int)$datum->FSC9}}</td>
                    <td>{{(int)$datum->FSC10}}</td>
                    <td>{{(int)$datum->FSC11}}</td>
                    <td>{{(int)$datum->FSC12}}</td>
                    <td class="summary_row">{{(int)$datum->Total}}</td>
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
        $("#date_year").datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });
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
    .summary_row{
        font-weight: bold !important;
        background-color: rgb(115, 147, 179, 0.15) !important;
        
    }
    #wrap-title {
    float: left;
    position: relative;
    left: 50%;
    }

    #content-title {
        float: left;
        position: relative;
        left: -50%;
    }
    
</style>
@endsection