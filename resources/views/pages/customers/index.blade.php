{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
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
                                <h3 class="card-label">Customers
                            </div>
                            <div class="col-md-12 col-lg-12">
                                {{ Form::open(['url' => '/filterCustomers', 'method' => 'get']) }}
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Name</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="name" type="text" class="form-control"
                                            value="{{ isset($f_customer_name) ? $f_customer_name : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Contact No</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="contact_no" type="text" class="form-control"
                                            value="{{ isset($f_customer_contact_no) ? $f_customer_contact_no : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Address</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="address" type="text" class="form-control"
                                            value="{{ isset($f_customer_address) ? $f_customer_address : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Type</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <select class="form-control form-contrl-role" name="type">
                                            <option value="" selected>--Select Type--</option>
                                            @foreach ($customer_type_options as $customer_type)
                                                <option
                                                    value="{{ $customer_type }}"{{ $f_customer_type == $customer_type ? 'selected' : '' }}>
                                                    {{ ucfirst(trans($customer_type)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Age</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <select class="form-control form-control-role" name="age">
                                            <option value="" selected>--Select Age Group--</option>
                                            @foreach ($age_group_options as $age)
                                                <option
                                                    value="{{ $age }}"{{ $f_customer_age == $age ? 'selected' : '' }}>
                                                    {{ ucfirst(trans($age)) }}</option>
                                            @endforeach
                                            <option></option>
                                        </select>
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Gender</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <select class="form-control form-control-role" name="gender">
                                            <option value="" selected>--Select Gender--</option>
                                            @foreach ($gender as $g)
                                                <option
                                                    value="{{ $g }}"{{ $f_customer_gender == $g ? 'selected' : '' }}>
                                                    {{ ucfirst(trans($g)) }}</option>
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


            <table class="datatable datatable-bordered" id="kt_datatable" style="display: block;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Type</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $customer)
                        <tr class="<?php echo (isset($customer->flag) ? $customer->flag : $customer->customer_flag) == 1 ? 'flagged' : ''; ?>">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ isset($customer->name) ? $customer->name : $customer->customer_name }}</td>
                            <td>{{ isset($customer->contact_no) ? $customer->contact_no : $customer->customer_contact }}
                            </td>
                            <td>{{ isset($customer->type) ? $customer->type : $customer->customer_type }}</td>
                            <td>{{ isset($customer->age) ? $customer->age : $customer->customer_age }}</td>
                            <td>{{ isset($customer->gender) ? $customer->gender : $customer->customer_gender }}</td>
                            <td>{{ isset($customer->address) ? $customer->address : $customer->customer_address }}</td>

                            <td>
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $customer->id) }}"
                                    style="display: inline-block;" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="button" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2 deleteBtnforcustomer"
                                        data-toggle="tooltip" title="Delete">
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
                    width: 20,
                },
                {
                    field: "E-mail",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_customer'),
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
