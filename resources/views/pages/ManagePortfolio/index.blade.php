{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .hidden {
            display: none !important;
        }
    </style>
@endsection

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="errorbox">

                </div>
            </div>
        </div>
    </div>
    @include('pages.ManagePortfolio.addPortfolio')

    <div id="myportfolioIndexContents">
        <div class="card">
            <div class="text-center">
                <h3>
                    Loading...
                </h3>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function initial_load() {
            $.ajax({
                url: "{{ route('portfolio.content') }}",
                success: function(result) {
                    $("#myportfolioIndexContents").html(result);
                    var my_portfolio_datatable = $('#kt_datatable_my_portfolio')
                        .KTDatatable({
                            data: {
                                saveState: {
                                    cookie: false
                                }
                            },
                            columns: [{
                                    field: "PORTFOLIO",
                                    width: 150,
                                    sortable: false,
                                    textAlign: 'center'
                                },
                                {
                                    field: "ACTIVE",
                                    width: 60,
                                    sortable: false,
                                    textAlign: 'center'
                                },
                                {
                                    field: "ACTIONS",
                                    width: 180,
                                    sortable: false,
                                    textAlign: 'right'
                                },
                            ],
                            search: {
                                input: $('#kt_datatable_my_portfolio_search'),
                                key: 'generalSearch'
                            },

                        });
                    my_portfolio_datatable.sort('ACTIVE', 'desc');

                    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

                }
            });
        }

        initial_load();

        function myportfolioEditBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var myportfolio_name = '#myportfolio_name-' + id;
            var myportfolio_action_buttons = '#myportfolio_action_buttons-' + id;

            $(myportfolio_name + ' .hide_before_edit').removeClass('hidden');

            $(myportfolio_action_buttons + ' .hide_before_edit').removeClass('hidden');

            $(myportfolio_name + ' .hide_after_edit').addClass('hidden');

            $(myportfolio_action_buttons + ' .hide_after_edit').addClass('hidden');
        }

        function myportfolioDiscardBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var myportfolio_name = '#myportfolio_name-' + id;
            var myportfolio_action_buttons = '#myportfolio_action_buttons-' + id;
            $(myportfolio_name + ' .hide_before_edit').addClass('hidden');
            $(myportfolio_action_buttons + ' .hide_before_edit').addClass('hidden');
            $(myportfolio_name + ' .hide_after_edit').removeClass('hidden');
            $(myportfolio_action_buttons + ' .hide_after_edit').removeClass('hidden');
        }

        function myportfoliosaveBtn(event) {
            var all_id = event.target.parentElement.id;
            id = all_id.split('-')[1];
            var myportfolio_name = '#myportfolio_name-' + id;
            let details = {
                myportfolio_name: $(myportfolio_name + ' .hide_before_edit').val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': '/portfolio/update/' + id,
                'type': 'POST',
                'dataType': 'json',
                'data': details,
            }).done(function(response) {
                if (response.success == true) {
                    $('.errorbox').html(
                        "<div class='p-4 bg-success text-white'>Portfolio has been updated.</div>"
                    );
                    setTimeout(removeerrbox, 3000);

                    function removeerrbox() {
                        $('.errorbox').html("")
                    }

                } else {
                    $('.errorbox').html(
                        "<div class='p-4 bg-danger text-white'>Portfolio couldn't be updated</div>"
                    );
                    setTimeout(removeerrbox, 3000);

                    function removeerrbox() {
                        $('.errorbox').html("")
                    }
                }
                initial_load();
            }).fail(function(xhr, ajaxOps, error) {
                console.log('Failed: ' + error);
            });
        }
    </script>
@endsection
