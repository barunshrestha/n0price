{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> Product Code Details
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox">
                <label for="collapsible" class="lbl-toggle">Filters</label>
                <div class="collapsible-content">
                    <div class="content-inner">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Customers
                            </div>
                            <div class="col-md-12 col-lg-12">
                                {{ Form::open(['url' => '/filterProductcode', 'method' => 'get']) }}
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Model</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="model" type="text" class="form-control"
                                            value="{{ isset($filter_model) ? $filter_model : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Sku Code</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="sku_code" type="text" class="form-control"
                                            value="{{ isset($filter_sku_code) ? $filter_sku_code : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Brake Type</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <select class="form-control form-control-role" name="brake_type">
                                            <option value="" selected>--Select Break Type</option>
                                            @foreach ($brake_type_options as $b)
                                                <option value="{{ $b->brake_type }}"
                                                    {{ $filter_brake_type == $b->brake_type ? 'selected' : '' }}>
                                                    {{ $b->brake_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Start Type</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <select class="form-control form-control-role" name="start_type">
                                            <option value="" selected>--Select Start Type</option>
                                            @foreach ($start_type_options as $sop)
                                                <option
                                                    value="{{ $sop->start_type }}"{{ $filter_start_type == $sop->start_type ? 'selected' : '' }}>
                                                    {{ $sop->start_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Wheel Type</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <select class="form-control form-control-role" name="wheel_type">
                                            <option value="" selected>--Select Wheel Type</option>
                                            @foreach ($wheel_type_options as $wo)
                                                <option
                                                    value="{{ $wo->wheel_type }}"{{ $filter_wheel_type == $wo->wheel_type ? 'selected' : '' }}>
                                                    {{ $wo->wheel_type }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Color</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <select class="form-control form-control-role" name="color">
                                            <option value="" selected>--Select Color--</option>
                                            @foreach ($color_options as $co)
                                                <option
                                                    value="{{ $co->colour }}"{{ $filter_color == $co->colour ? 'selected' : '' }}>
                                                    {{ $co->colour }}</option>
                                            @endforeach
                                        </select>

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


            <table class="datatable datatable-bordered" id="kt_datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>Plant</th> -->
                        <th>Model</th>
                        <!-- <th>Variant</th> -->
                        <th>SKU Code</th>
                        <th>Brake Type</th>
                        <th>Start Type</th>
                        <th>Wheel Type</th>
                        <th>Color</th>
                        <th>Vehicle Count</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productcode as $key => $productcode)
                        <tr class="">
                            <td>{{ $key + 1 }}</td>
                            <!-- <td>{{ $productcode->plant }}</td> -->
                            <td>{{ $productcode->model }}</td>
                            <!-- <td>{{ $productcode->variant }}</td> -->
                            <td>{{ $productcode->sku_code }}</td>
                            <td>{{ $productcode->brake_type }}</td>
                            <td>{{ $productcode->start_type }}</td>
                            <td>{{ $productcode->wheel_type }}</td>
                            <td>{{ $productcode->colour }}</td>
                            <td>{{ $productcode->v_count }}
                            </td>
                            <td>
                                <a href="{{ route('productcode.edit', $productcode->id) }}"
                                    class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('productcode.destroy', $productcode->id) }}"
                                    style="display: inline-block;" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="button" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                        title="Flag">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
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
    <script type="text/javascript">
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "No",
                    width: 35,
                },
                {
                    field: "E-mail",
                    width: 200,
                },



            ],
            search: {
                input: $('#kt_datatable_search_query_product_code'),
                key: 'generalSearch'
            }
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
