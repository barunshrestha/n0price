{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox">
                <label for="collapsible" class="lbl-toggle">Filters</label>
                <div class="collapsible-content">
                    <div class="content-inner">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Vehicles
                            </div>
                            <div class="col-md-12 col-lg-12">
                                {{ Form::open(['url' => '/filterVehicles', 'method' => 'get']) }}
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Regs
                                        No</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="reg_no" type="text" class="form-control" value="{{ isset($f_reg_no) ? $f_reg_no : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select
                                        dealer</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        {{-- {{ Form::select('dealer_id', [' ' => '-Select Dealer-'] + $dealers, $dealer_id, ['class' => 'form-control form-control-role', 'autocomplete' => 'off']) }} --}}
                                        <select class="form-control form-control-role" name="dealer_id">
                                            <option value=" ">- Select Dealer-</option>
                                            @foreach ($dealers as $key=>$dealer)
                                                <option value="{{$key}}" {{ $f_dealer_id == $key ? 'selected' : '' }}>{{$dealer}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Product</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <select class="form-control form-control-role" name="product_id">
                                            <option value=" ">- Select Product-</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->sku_code }}" {{ $f_product_id == $product->sku_code ? 'selected' : '' }}>
                                                    {{ $product->sku_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Chasis
                                        No</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="chasis_no" type="text" class="form-control" value="{{ isset($f_chasis_no) ? $f_chasis_no : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Challan Date</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <input name="challan_date" type="date" class="form-control" value="{{ isset($f_challan_date) ? $f_challan_date : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date of sale</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <input name="date_of_sale" type="date" class="form-control" value="{{ isset($f_date_of_sale) ? $f_date_of_sale : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row pb-4">
                                    <div class="col-lg-1 col-sm-2 offset-1"> <button type="submit"
                                            class="btn btn-primary submitBtn">
                                            Search</button></div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <table class="" id="kt_datatable">
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
                    @foreach ($vehicles as $key => $vehicle)
                        <tr>
                            <?php
                            $customer = isset($vehicle->customer_name) ? $vehicle->customer_name . ' , ' . $vehicle->customer_contact : '';
                            $dealer = isset($vehicle->dealer_name) ? $vehicle->dealer_name . ' , ' . $vehicle->dealer_address : '';
                            ?>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $vehicle->registration_no }}</td>
                            <td>{{ isset($vehicle->model_name) ? $vehicle->model_name : '' }}
                                <br />{{ $vehicle->product }}
                            </td>
                            <td>{{ $vehicle->chasis_no }}</td>
                            <td>
                                @if (isset($vehicle->dealer_id))
                                    <a href="{{ route('dealers.edit', $vehicle->dealer_id) }}">
                                        {{ isset($vehicle->Dealers->name) ? $vehicle->Dealers->name : $dealer }}</a>
                                @else
                                    -- No Dealer --
                                @endif
                            </td>
                            <td>
                                @if (isset($vehicle->customer_id))
                                    <a href="{{ route('customers.edit', $vehicle->customer_id) }}">
                                        {{ isset($vehicle->Customer->name) ? $vehicle->Customer->name : $vehicle->customer_name }}</a>
                                    {{-- {{ isset($vehicle->Customer->contact_no) ? $vehicle->Customer->contact_no : $customer_contact_no }} --}}
                                @else
                                    -- No Customer --
                                @endif
                            </td>
                            <td>{{ $vehicle->challan_date }}</td>
                            <td>{{ $vehicle->date_of_sale }}</td>
                            <td>
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                    class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                {{ csrf_field() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    {{-- <script type="text/javascript">
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "No",
                    width: 30,
                },
                {
                    field: "E-mail",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_vehicles'),
                key: 'generalSearch'
            }
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            //$('.form-control-role').select2();
            $('#kt_datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf'
                ],
                "pageLength": 20
            });
            $('.form-control-role').select2();
            $('.collapse').collapse();
        });
    </script>
    <style>
        .flagged {}

        input[type='checkbox'] {
            display: none;
        }

        .wrap-collabsible {
            margin: 1.2rem 0;
        }

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

        .lbl-toggle:hover {
            color: #FFF;
        }

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

        .toggle:checked+.lbl-toggle::before {
            transform: rotate(90deg) translateX(-3px);
        }

        .collapsible-content {
            max-height: 0px;
            overflow: hidden;
            transition: max-height .25s ease-in-out;
        }

        .toggle:checked+.lbl-toggle+.collapsible-content {
            max-height: 350px;
        }

        .toggle:checked+.lbl-toggle {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .collapsible-content .content-inner {
            background: rgba(0, 105, 255, .2);
            border-bottom: 1px solid rgba(0, 105, 255, .45);
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
            padding: .5rem 1rem;
        }

        .collapsible-content p {
            margin-bottom: 0;
        }
    </style>
@endsection
