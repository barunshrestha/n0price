{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}

@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-label"><br />View Dealer Info</h3>
    </div>

    <div class="container customer_info">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                </div>

                                <h6>{{$dealer->name}}</h6>
                                <h6>{{$dealer->dealer_code}}</h6>


                                <h6> {{$dealer->contact}}</h6>
                                <h6> {{$dealer->owner}}</h6>

                                <h6> {{$types[$dealer->type]}}</h6>

                                <h6>{{$dealer->area}}</h6>


                                @foreach($provinces as $key=>$province)
                                @if($dealer->state == $province->id)
                                <h6>{{$province->name}}</h6>
                                @endif
                                @endforeach

                                @foreach($districts as $key=>$district)
                                @if($dealer->district == $district->id)
                                <h6>{{$district->name}}</h6>
                                @endif
                                @endforeach

                                @foreach($address as $key=>$address)
                                @if($dealer->address == $address->id)
                                <h6> {{$address->title}}</h6>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="account-settings">
                                <div class="user-profile">

                                    <div class="cust_container">
                                        <div class="row">

                                            @foreach($dealer->dealerdetails as $dealer_detail)

                                            @if($dealer_detail->meta_value >= 1)
                                            @if($dealer_detail->meta_name === "sales" || $dealer_detail->meta_name === "service" || $dealer_detail->meta_name ==="spare" || $dealer_detail->meta_name ==="exchange" || $dealer_detail->meta_name ==="finance" || $dealer_detail->meta_name ==="sajilai_hero" )
                                            <div class="col-sm-12 col-md-4 flex">
                                                <div class="dealer-meta-tags">
                                                    <span>
                                                        @if($dealer_detail->meta_name === "sales")
                                                        Sales
                                                        @elseif($dealer_detail->meta_name === "service")
                                                        Service
                                                        @elseif($dealer_detail->meta_name === "spare")
                                                        Spare
                                                        @elseif($dealer_detail->meta_name === "exchange")
                                                        Exchange
                                                        @elseif($dealer_detail->meta_name === "finance")
                                                        Finance
                                                        @elseif($dealer_detail->meta_name === "sajilai_hero")
                                                        Sajilai hero
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            @else

                                            <div class="col-sm-12 flex dealer-meta-values">

                                                @if( ($dealer_detail->meta_name === "district_id") )
                                                @foreach($districts as $key=>$district)
                                                @if($dealer_detail->meta_value == $district->id)
                                                <div>
                                                    <br />
                                                    <span>District : {{$district->name}}</span>
                                                </div>

                                                @endif
                                                @endforeach
                                                @endif


                                                @if($dealer_detail->meta_name !== "district_id")
                                                @if($dealer_detail->meta_name === "municipality")
                                                Municipality : {{$dealer_detail->meta_value}}
                                                @elseif($dealer_detail->meta_name === "spare_contact")
                                                Spare contact : {{$dealer_detail->meta_value}}
                                                @elseif($dealer_detail->meta_name === "service_contact")
                                                Service contact : {{$dealer_detail->meta_value}}
                                                @elseif($dealer_detail->meta_name === "email")
                                                Email : {{$dealer_detail->meta_value}}
                                                @elseif($dealer_detail->meta_name === "tole")
                                                Tole : {{$dealer_detail->meta_value}}
                                                @elseif($dealer_detail->meta_name === "latitude")
                                                {{' '}}
                                                @elseif($dealer_detail->meta_name === "longitude")
                                                {{' '}}
                                                @elseif($dealer_detail->meta_name === "operating_hours")
                                                Operating hours : {{$dealer_detail->meta_value}}
                                                @endif
                                                @endif
                                            </div>


                                            @endif
                                            @endif

                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
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

    /* .form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .825rem;
    background: #ffffff;
    color: #2e323c;
} */
    .flex {
        display: flex;
    }

    .dealer-meta-values {
        font-size: 16px;

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
        padding-left: 3rem;
    }

    .dealer-meta-tags {
        background: crimson;
        text-align: center;
        justify-content: center;
        border-radius: 5px;
        color: white;
        padding: 0.5rem;
        margin: 0.5rem;
        display: flex;
        width: 10rem;
    }
</style>