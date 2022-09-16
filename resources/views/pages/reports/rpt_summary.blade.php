{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">
    body {
        padding: 10px;
    }

    #exTab1 .tab-content {

        padding: 5px 15px;
    }

    #exTab2 h3 {
        color: white;
        background-color: #428bca;
        padding: 5px 15px;
    }

    /* remove border radius for the tab */
    #exTab1 .nav-pills>li>a {
        border-radius: 0;
    }

    /* change border radius for the tab , apply corners on top*/
    #exTab3 .nav-pills>li>a {
        border-radius: 4px 4px 0 0;
    }

    #exTab3 .tab-content {
        color: white;
        background-color: #428bca;
        padding: 5px 15px;
    }

    .dot {
        height: 80px;
        width: 80px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }

    .media-body,
    .media-left,
    .media-right {
        display: table-cell;
        vertical-align: top;
    }

    .text-muted {
        color: #777;
    }

    .small,
    small {
        font-size: 85%;
        text-align: left;
    }

    .answer {
        font-size: large;
        color: #333333 !important;
    }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
        <h3 class="card-label">Summary
    </div>
    </div>
    <div class="card-body">
        <div id="exTab1">
            <ul class="nav nav-pills">
                <li class="active"><a href="#1a" data-toggle="tab">Sales</a></li> &nbsp;&nbsp;&nbsp;
                <li><a href="#2a" data-toggle="tab">Enquiry</a></li>&nbsp;&nbsp;&nbsp;
                <li><a href="#3a" data-toggle="tab">Servicing</a></li>&nbsp;&nbsp;&nbsp;
                <li><a href="#4a" data-toggle="tab">Servicing Reminder</a></li>
            </ul>
            <br />
            <div class="col-md-12 col-lg-12">
                {{ Form::open(['url' => '/filter_rpt_summary','method' => 'get']) }}
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date From</label>
                    <div class="col-lg-3 col-md-2 col-sm-6">
                        <input name="date_from" type="date" id="rpt_summary_startdate" class="date-input form-control form-control-solid" value="{{isset($date_from)?$date_from:''}}" />
                    </div>
                    <label class="col-form-label text-right col-lg-1 col-sm-2">Date To</label>
                    <div class="col-lg-3 col-md-2 col-sm-6">
                        <input name="date_to" type="date" id="rpt_summary_enddate" class="date-input form-control form-control-solid" value="{{isset($date_to)?$date_to:''}}" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 submitBtn" id="rpt_summary_submitBtn"><i class="fa fa-submit"></i> Search</button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1a">
                    <h3>Sales Summary</h3> <br />
                    <?php if (isset($summary)) { ?>
                        <table class="table table-bordered table-hover" style="display:block;" cellpadding="20px">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cash</th>
                                    <th>Finance</th>
                                    <th>Exchange Cash</th>
                                    <th>Exchange Finance</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $key=>$summary_data)
                                <tr>
                                    <td>{{$summary_data->date}}</td>
                                    <td>{{$summary_data->sales_cash}}</td>
                                    <td>{{$summary_data->sales_finance}}</td>
                                    <td>{{$summary_data->exchange_cash}}</td>
                                    <td>{{$summary_data->exchange_finance}}</td>
                                    <td>{{$summary_data->sales_cash + $summary_data->sales_finance + $summary_data->exchange_cash + $summary_data->exchange_finance}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfooter>

                                <tr>
                                    <td>Total</td>
                                    <td>{{$cashSum}}</td>
                                    <td>{{$financeSum}}</td>
                                    <td>{{$cashexcSum}}</td>
                                    <td>{{$financeexcSum}}</td>
                                    <td>{{$totalSum}}</td>
                                </tr>
                            </tfooter>
                        </table>

                    <?php } ?>
                </div>
                <div class="tab-pane" id="2a">
                    <h3>Enquiry Summary</h3> <br />
                    <?php if (isset($summary)) { ?>

                        <table class="table table-bordered table-hover" style="display:block;" cellpadding="20px">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Won</th>
                                    <th>Lost</th>
                                    <th>Interested</th>
                                    <th>Interested on Schemes</th>
                                    <th>Interested on Sajilai Hero</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $key=>$summary_data)
                                <tr>
                                    <td>{{$summary_data->date}}</td>
                                    <td>{{$summary_data->enquiry_won}}</td>
                                    <td>{{$summary_data->enquiry_lost}}</td>
                                    <td>{{$summary_data->enquiry_interested}}</td>
                                    <td>{{$summary_data->enquiry_interested_on_schemes}}</td>
                                    <td>{{$summary_data->enquiry_interested_on_SajilaiHero}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfooter>

                                <tr>
                                    <td>Total</td>
                                    <td>{{$wonsum}}</td>
                                    <td>{{$lostsum}}</td>
                                    <td>{{$interestedsum}}</td>
                                    <td>{{$interestedschemessum}}</td>
                                    <td>{{$sajiloherosum}}</td>
                                </tr>
                            </tfooter>
                        </table>

                    <?php } ?>
                </div>

                <div class="tab-pane" id="3a">
                    <h3>Service Summary</h3> <br />
                    <?php if (isset($summary)) { ?>

                        <table class="table table-bordered table-hover" style="display:block;" cellpadding="20px">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Free</th>
                                    <th>Paid</th>
                                    <th>Unscheduled</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $key=>$summary_data)
                                <tr>
                                    <td>{{$summary_data->date}}</td>
                                    <td>{{$summary_data->scheduled_free}}</td>
                                    <td>{{$summary_data->scheduled_paid}}</td>
                                    <td>{{$summary_data->unscheduled}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfooter>

                                <tr>
                                    <td>Total</td>
                                    <td>{{$freesum}}</td>
                                    <td>{{$paidsum}}</td>
                                    <td>{{$unscheduledsum}}</td>
                                </tr>
                            </tfooter>
                        </table>
                    <?php } ?>
                </div>

                <div class="tab-pane" id="4a">
                    <h3>Service Reminder Summary</h3> <br />
                    <?php if (isset($summary)) { ?>

                        <table class="table table-bordered table-hover" style="display:block;" cellpadding="20px">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sms Sent</th>
                                    <th>Reported</th>
                                    <th>First Call</th>
                                    <th>First Call Reported</th>
                                    <th>First Call Due</th>
                                    <th>Second Call</th>
                                    <th>Second Call Reported</th>
                                    <th>Second Call Due</th>
                                    <th>Lost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $key=>$summary_data)
                                <tr>
                                    <td>{{$summary_data->date}}</td>
                                    <td>{{$summary_data->sms}}</td>
                                    <td>{{$summary_data->sms_reported}}</td>
                                    <td>{{$summary_data->first_call}}</td>
                                    <td>{{$summary_data->first_call_reported}}</td>
                                    <td>{{$summary_data->first_call_due}}</td>
                                    <td>{{$summary_data->second_call}}</td>
                                    <td>{{$summary_data->second_call_reported}}</td>
                                    <td>{{$summary_data->second_call_due}}</td>
                                    <td>{{$summary_data->lost}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfooter>

                                <tr>
                                    <td>Total</td>
                                    <td>{{$smssentsum}}</td>
                                    <td>{{$reportedsum}}</td>
                                    <td>{{$firstcallsum}}</td>
                                    <td>{{$firstreportedsum}}</td>
                                    <td>{{$firstduesum}}</td>
                                    <td>{{$secondcallsum}}</td>
                                    <td>{{$secondreportedsum}}</td>
                                    <td>{{$secondduesum}}</td>
                                    <td>{{$srlostsum}}</td>
                                </tr>
                            </tfooter>
                        </table>

                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('js/pages/crud/ktdatatable/base/html-table.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".date-input").change(function() {
            const startDate = $("#rpt_summary_startdate").val();
            const enddate = $("#rpt_summary_enddate").val();
            const new_startDate = new Date(startDate).getTime();
            const new_enddate = new Date(enddate).getTime();
            if (new_startDate >= new_enddate) {
                alert("Start date cannot be greater than End date");
                $("#rpt_summary_enddate").val("");
            }
        });
    });
</script>
@endsection
