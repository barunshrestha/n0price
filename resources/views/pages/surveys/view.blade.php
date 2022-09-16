{{-- Extends layout --}}
@extends('layout.default')


{{-- Content --}}

@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-label"><br />View Survey Info</h3>
    </div>

    @include('layout.partials.customer_info',['customer_id' => $survey[0]->customers->id])

   {{-- <!-- {{  dd($survey);}} -->--}}
    <div class="container customer_info" style="padding: 0 0px;">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <h5><u>Survey Details</u></h5>
                                <p>Dealer: {{$survey[0]->dealers->name}}</p>
                                <p>Survey type: {{$survey[0]->survey_type}}</p>
                                <p>Survey date: {{ Carbon\Carbon::parse($survey[0]->survey_date)->format('Y-m-d')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>
                                    <h5><b> Question </b></h5>
                                </th>
                                <th class="pl_ans">
                                    <h5><b> Answer </b></h5>
                                </th>
                            </tr>

                            @foreach($survey[0]->surveyDetail as $details)
                            <tr>
                                <td class="pl3">
                                    <h5 class="user-question">{{ $details['question']}}</h5>
                                </td>
                                <td class="pl3">
                                    <h5 class="user-answers">{{ $details['answers'] }}</h5>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    body {
        margin: 0;
        padding-top: 40px;
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
    }

    .account-settings .user-profile {
        margin: 0 0 1rem 0;
        padding-bottom: 1rem;
        text-align: center;
    }

    .account-settings .user-profile .user-avatar {
        margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
        width: 90px;
        height: 90px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
        margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 400;
        color: #9fa8b9;
    }

    .account-settings .about {
        margin: 2rem 0 0 0;
        text-align: center;
    }

    .account-settings .about h5 {
        margin: 0 0 15px 0;
        color: #007ae1;
    }

    .account-settings .about p {
        font-size: 0.825rem;
    }

    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }

    .pl3 {
        padding-left: 0rem;
    }

    .user-profile {
        font-size: 14px;
        list-style-type: none;
    }
    .user-question,
    .user-answers {
        font-size: 14px;
    }

    .user-answers {
        padding-left: 2rem;
    }

    .pl_ans {
        padding-left: 2rem;
    }
</style>