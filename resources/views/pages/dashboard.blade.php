{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    {{-- Dashboard 1 --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-1">
                    <div class="card-title">
                        <h3 class="card-label">
                            MONTHLY REPORT
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                            href="#monthly_report" role="button" aria-expanded="true" aria-controls="monthly_report"
                            title="Toggle Card">
                            <i class="ki ki-arrow-down icon-nm"></i>
                        </a>
                    </div>
                </div>

                <div id="monthly_report" class="collapse show">
                    <div class="card card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <strong>The following report displays a summary of sales, enquiries, servicings and service
                                reminders sent for a period of a month. You can choose a particular month. By default, the
                                report is displayed for the current month.</strong>
                        </div>
                        <!-- BEGIN FORM-->
                        <form>
                            <div class="form-body">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        
                                    </div>
                                    <div class="col-lg-3" style="margin-top: 24px;">
                                        <button type="submit" class="btn btn-primary">Apply</button>
                                    </div>
                                   
                                </div>
                        </form>

                        <div class="table-responsive">
                           
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
    </div>

    
@endsection
@section('scripts')
    <script>
        var card = new KTCard('kt_card_1');
        jQuery(document).ready(function() {
           
        });
    </script>
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
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            }
        });
    </script>
@endsection
