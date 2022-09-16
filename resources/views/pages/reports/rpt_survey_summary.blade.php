{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
<link href="{{asset('css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">
    body {
    padding : 10px ;
    }

    #exTab1 .tab-content {
    
    padding : 5px 15px;
    }

    #exTab2 h3 {
    color : white;
    background-color: #428bca;
    padding : 5px 15px;
    }

    /* remove border radius for the tab */
    #exTab1 .nav-pills > li > a {
    border-radius: 0;
    }

    /* change border radius for the tab , apply corners on top*/
    #exTab3 .nav-pills > li > a {
    border-radius: 4px 4px 0 0 ;
    }

    #exTab3 .tab-content {
    color : white;
    background-color: #428bca;
    padding : 5px 15px;
    }
    
    .dot {
        height: 80px;
        width: 80px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
    .media-body, .media-left, .media-right {
        display: table-cell;
        vertical-align: top;
    }
    .text-muted {
        color: #777;
    }
    .small, small {
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

<h1>Surveys  </h1>
<div id="exTab1" >	
    <ul  class="nav nav-pills">
        <li class="active"><a  href="#1a" data-toggle="tab">ShowRoom Survey</a></li>
        <li><a href="#2a" data-toggle="tab">WorkShop Survey</a></li>
        <li><a href="#3a" data-toggle="tab">Suggestions</a></li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="1a">
            <h3>ShowRoom Survey</h3>
            <?php if (isset($survey_summary_showroom)) { ?>
            
            <div class = "row">
                <div class="col-md-4 col-lg-4"><h3>Questions</h3></div>
                <div class="col-md-8 col-lg-8"><h3>Response</h3></div>
            </div>
           
                <?php 
                   
                    foreach($survey_summary_showroom as $key=>$data){
                        echo '<div class="row">';
                        echo '<div class="col-md-4 col-lg-4"><strong>'.$showroom_survey_questions[$key].'</strong> <br/>  ('.$key.')</div>';
                        foreach($data as $k=>$v){
                            echo '<div class="col-md-1 col-lg-1"><strong>'.$k .'</strong> <br/><span class="resp_result"> </strong>'.$v.'</strong></span></div>';
                        }
                        echo '</div>';
                    }
                ?>
                    
           
            <?php } ?>
        </div>
        <div class="tab-pane" id="2a">
        <h3>Workshop Survey</h3>
            <?php if (isset($survey_summary_workshop)) { ?>
            
            <div class = "row">
                <div class="col-md-4 col-lg-4"><h3>Questions</h3></div>
                <div class="col-md-8 col-lg-8"><h3>Response</h3></div>
            </div>
           
                <?php 
                   
                    foreach($survey_summary_workshop as $key=>$data){
                        echo '<div class="row">';
                        echo '<div class="col-md-4 col-lg-4"><strong>'.$workshop_survey_questions[$key].'</strong> <br/>  ('.$key.')</div>';
                        foreach($data as $k=>$v){
                            echo '<div class="col-md-1 col-lg-1"><strong>'.$k .'</strong> <br/><span class="resp_result"> </strong>'.$v.'</strong></span></div>';
                        }
                        echo '</div>';
                    }
                ?>
                    
           
            <?php } ?>
        </div>
        <div class="tab-pane container" id="3a">
        <h3>Survey Suggestions</h3>
        <div class="row">
            
            @foreach($survey_suggestions as $key=>$suggestion)
            <div class="col-md-6 col-sm-6">
            <div class="panel-body pull-right">
                <ul class="media-list">
                    <li class="media">
                        <span href="#" class="pull-left">
                            <strong class="dot"><br> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;@if($suggestion->survey_type == 'WorkshopSurvey')SR @else WS @endif </strong>
                        </span>
                        <div class="media-body">
                            
                            <strong class="text-success">{{$suggestion->customer_name}}</strong>
                            <span class="text-muted pull-right">
                                <small class="text-muted">{{$suggestion->created}}</small>
                            </span>
                            <p>{{$suggestion->customer_contact}}</p>
                            <p class="answer">{{$suggestion->answers}} </p>
                        </div>
                    </li>
                </ul>
            </div>
            </div>
            @endforeach
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
    	var datatable = $('#kt_datatable').KTDatatable({
	      
	    });
	   
    	
    </script>
@endsection