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
			<h3 class="card-label"> Sales by Model
		</div>
		<div class="col-md-12 col-lg-12">
			{{ Form::open(['url' => '/filter_sales_by_model','method' => 'get']) }}

			<div class="form-group row">
				<label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Dealer</label>
				<div class="col-lg-4 col-md-6 col-sm-6">
					{{Form::select('dealer_id', ['0' => 'Select Dealer'] + $dealers,$dealer_id,  ['class' =>  'form-control-role', 'autocomplete' => 'off','required'=>true])}}
				</div>
                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-6">Model</label>
				<div class="col-lg-4 col-md-6 col-sm-6">
                <input name="model" type="text" class="form-control form-control-solid"  value="{{$model}}" />
				</div>
            </div>
            <div class="form-group row">  
                <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="start_date" type="date" class="form-control form-control-solid" required value="{{$start_date}}" />
				</div>
				<label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
				<div class="col-lg-3 col-md-2 col-sm-6">
					<input name="end_date" type="date" class="form-control form-control-solid" required value="{{$end_date}}" />
				</div>
                <div class = "col-lg-2 col-md-2 col-sm-2">
				<button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i> Search</button>
                </div>
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
					<th>Dealer</th>
					<th>Date of Sale</th>
					<th>Model</th>
					<th>Product</th>
					<th>Count</th>
					
				</tr>
			</thead>
			<tbody>
				@foreach($sales as $key=>$sale)
				<tr>
                    
					<td>{{$key+1}}</td>
					<td>{{$sale->dealer}}</td>
					<td>{{$sale->date_of_sale}}</td>
					<td>{{$sale->model}}</td>
					<td>{{$sale->product}}</td>
					<td>{{$sale->Count}}</td>
				
				</tr>
				@endforeach
                <tr>
                    <td></td>
                    <td>Total Sales</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$sum['Count']}}</td>
                </tr>
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
@endsection