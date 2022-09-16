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
    <div class="card card-custom mb-5">
        <div class="card-body">
            {{ Form::open(['url' => '/filter_offer', 'method' => 'get']) }}
            <div class=" d-flex pt-2 mb-5 pb-5">
                <h3 class="card-label" style="align-self: end;margin-right: 3em;">Offers Summary</h3>
                <select name="selected_offer_name" id="bt" class="form-control" style="width: auto">
                    <option value=null selected>--Select offer--</option>
                    @foreach ($offer_names as $offer_name)
                        <option value="{{ $offer_name->offer_name }}"
                            {{ old($offer_name->offer_name, $offer_name->offer_name) == $selected_offer_name ? 'selected' : '' }}>
                            {{ $offer_name->offer_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary ml-5 submitBtn"><i class="fa fa-submit"></i>
                    Search</button>
                    <h4 style="align-self: center;margin-left: auto;">
                        {{$selected_offer_name}}({{$offer_validity[0]->valid_from}}-{{$offer_validity[0]->valid_till}})
                    </h4>
            </div>
            {{ Form::close() }}


            <table class="mt-5" id="kt_datatable_offers_summary">
                <thead>
                    <tr>
                        <th>Result</th>
                        <th>Total</th>
                        <th>Inactive</th>
                        <th>Total Active</th>
                        <th>Remaining</th>
                        <th>Won</th>
                        <th>Withheld</th>

                    </tr>
                </thead>
                {{-- ({{round($summary->Total/$total_offer_summary->Total,3)}} %) --}}
                <tbody>

                    @foreach ($offer_summary as $key => $summary)
                        <?php
                        $total_percentage = ($summary->Total / $total_offer_summary->Total) * 100;
                        $won_percentage = ($summary->Won / $total_offer_summary->Won) * 100;
                        $deviation = (($won_percentage - $total_percentage) / $total_percentage) * 100;
                        ?>
                        <tr>
                            <td>{{ $summary->result }}</td>
                            <td>{{ $summary->Total }} <span
                                    style="float:right;padding-right:2rem;">({{ round($total_percentage, 2) }}
                                    %)</span>
                            </td>
                            <td>{{ $summary->Inactive }}</td>
                            <td>{{ $summary->Total_active }}</td>
                            <td>{{ $summary->Remaining }}</td>
                            <td>{{ $summary->Won }}<span
                                    style="float:right;padding-right:2rem;">{{ round($won_percentage, 2) }}
                                    % ({{ round($deviation, 2) }} %)
                                </span></td>
                            <td>{{ $summary->Withheld }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>


    <div class="card card-custom">
        <div class="wrap-collabsible"> <input id="collapsible" class="toggle" type="checkbox">
            <label for="collapsible" class="lbl-toggle">Filters</label>
            <div class="collapsible-content">
                <div class="content-inner">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Offers</h3>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            {{ Form::open(['url' => '/filter_offer', 'method' => 'get']) }}
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-12">Select dealer</label>
                                <div class="col-lg-3 col-md-6 col-sm-6">

                                    {{ Form::select('dealer_id', [' ' => '-Select Dealer-'] + $dealers, $dealer_id, ['class' => 'form-control-role', 'autocomplete' => 'off']) }}
                                </div>
                                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Name</label>
                                <div class="col-lg-3 col-md-2 col-sm-6">
                                    <input name="customer_name" type="text" class="form-control form-control-solid"
                                        value="{{ $customer_name }}" />
                                </div>
                                <label class="col-form-label text-right col-lg-1 col-md-2 col-sm-2">Contact No.</label>
                                <div class="col-lg-3 col-md-2 col-sm-6">
                                    <input name="customer_contact" type="text" class="form-control form-control-solid"
                                        value="{{ $customer_contact }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
                                <div class="col-lg-3 col-md-2 col-sm-6">
                                    <input name="date_from" type="date" class="form-control form-control-solid"
                                        value="{{ $date_from }}" />
                                </div>
                                <label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
                                <div class="col-lg-3 col-md-2 col-sm-6">
                                    <input name="date_to" type="date" class="form-control form-control-solid"
                                        value="{{ $date_to }}" />
                                </div>

                                <button type="submit" class="btn btn-primary mr-2 submitBtn"><i class="fa fa-submit"></i>
                                    Search</button>
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <h3 class="card-label pb-4">Offers</h3>
            <table class="" id="kt_datatable_offers">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Offer Name</th>
                        <th>Vehicle</th>
                        <th>Customer</th>
                        <th>Dealer</th>
                        <th>Code</th>
                        <th>Result</th>
                        <th>Date of Sale</th>
                        <th>Offer Registered On</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $key => $offer)
                        <?php
                        if ($offer->date_of_sale == null || $offer->date_of_sale == '') {
                            $status = 'Unlinked';
                            $bgcolor = 'rgba(245, 183, 177 , 0.5)';
                        } elseif ($offer->date_of_sale == date('Y-m-d', strtotime($offer->updated))) {
                            $status = 'OK';
                            $bgcolor = 'rgba(255, 255, 255, 0.5)';
                        } else {
                            $status = 'Date Mismatch';
                            $bgcolor = 'rgba(248, 196, 113, 0.5)';
                        }
                        ?>
                        <tr style="background:<?php echo $bgcolor; ?>;">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $offer->offer_name }}</td>
                            <td>{{ $offer->registration_no }}</td>
                            <td>{{ $offer->customer_name }} <br /> {{ $offer->customer_contact }}</td>
                            <td>{{ $offer->dealer_name }}</td>
                            <td>{{ $offer->code }}</td>
                            <td>{{ $offer->result }}</td>
                            <td>{{ $offer->date_of_sale }}</td>
                            <td>{{ $offer->updated }}</td>
                            <td>{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-6">

                <a href="/enquiries_excel_import" class="btn btn-icon btn-success btn-xs mr-2" data-toggle="tooltip"
                    title="Excel Import">
                    <i class="fas fa-file-excel"></i>
                </a>

            </div>
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

    <script type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#kt_datatable_offers_summary').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf'
                ],
                "pageLength": 20,
                searching: false, paging: false, info: false
            });
            //$('.form-control-role').select2();
            $('#kt_datatable_offers').DataTable({
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
