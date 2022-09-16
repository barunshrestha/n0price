{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
	
		<div class="card-title"><h3 class="card-label">Service Reminders </h3></div>
		<div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox"> 
		<label for="collapsible" class="lbl-toggle">Filters</label>
		<div class="collapsible-content"><div class="content-inner">
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filter_service_reminders','method' => 'get']) }}
		
			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id,  ['class' =>  'form-control-role', 'autocomplete' => 'off','required'=>true])}}
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Service Date</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="date" type="date" class="form-control form-control-solid" value="{{$date}}" />
				</div>
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
			</div>
			{{ Form::close() }}
		</div>
		</div>
		</div>

	<div class="card-body">
		<div class="mb-7">
			<div class="row align-items-center">
				<div class="col-lg-9 col-xl-8">
					<div class="row align-items-center">
						<div class="col-md-4 my-2 my-md-0">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_new" />
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
					<th>Vehicle</th>
					<th>Customer</th>
					
					<th>Fsc No</th>
					<th>Service Date</th>
					<th>Dealer</th>
					<th>1st Reminder SMS (21 days)</th>
					<th>2nd Reminder SMS (7 days)</th>
					<th>2nd Reminder Call (7 days)</th>
					<th>3rd Reminder Call (0 days)</th>
					<th>4th Reminder Call (+5 days)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($followup as $key=>$followups)
				<tr>
					<td>{{$key+1}}</td>
					<td><a target= "_blank" href="{{route('servicecoupons.edit',$followups->id)}}">{{$followups->registration_no}}</a></td>
					<td>{{$followups->name}}, {{$followups->contact_no}}</td>
					<td>{{$followups->fsc_no}}</td>
					<td>{{$followups->next_service_date}}</td>
					<td>{{$followups->dealer_name}}</td>
					<td>{{$followups->sms_21d}}</td>
					<td>{{$followups->sms_7d}}</td>
					<td>{{$followups->call_1}} <br/>{{$followups->call_1_notes}}</td>
					<td>{{$followups->call_2}} <br/>{{$followups->call_2_notes}}</td>
					<td>{{$followups->call_3}} <br/>{{$followups->call_3_notes}}</td>
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
		columns: [{
				field: "No",
				width: 20,
			},
			{
				field: "E-mail",
				width: 200,
			},

		],
		search: {
			input: $('#kt_datatable_search_query_new'),
			key: 'generalSearch'
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.form-control-role').select2();
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