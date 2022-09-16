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
            <h3>Model Details</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <strong>The following report displays available no. of products on different dealers / locations.</strong>
            </div>
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
                                {{ Form::open(['url' => '/filterModelDetails', 'method' => 'get']) }}
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Model</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="model" type="text" class="form-control"
                                            value="{{ isset($f_model) ? $f_model : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Address</label>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <input name="address" type="text" class="form-control"
                                            value="{{ isset($f_address) ? $f_address : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-1 col-sm-2">Dealer</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">

                                        <select class="form-control form-control-role" name="dealer">
                                            <option value="" selected>--Select Dealer--</option>
                                            @foreach ($dealer_options as $do)
                                                <option
                                                    value="{{ $do->name }}"{{ $f_dealer == $do->name ? 'selected' : '' }}>
                                                    {{ ucfirst(trans($do->name)) }}</option>
                                            @endforeach
                                            <option></option>
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

            <?php if(isset($models)) {?>
            <table class="datatable datatable-bordered" id="kt_datatable">
                <thead>
                    <tr>
                        <th>S No</th>
                        <th>Model</th>
                        <th>Dealer</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Count</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $key => $model)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $model->model . ' (' . $model->product . ')' }}</td>
                            <td>{{ $model->dealer_name }}</td>
                            <td>{{ $model->dealer_address }}</td>
                            <td>{{ $model->dealer_contact }}</td>
                            <td>{{ $model->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?php } // end if ?>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script>
        $('.form-control-role').select2({
            width: '100%',
            allowClear: false
        });
    </script>
    <script type="text/javascript">
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "S No",
                    width: 50,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            }
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
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
