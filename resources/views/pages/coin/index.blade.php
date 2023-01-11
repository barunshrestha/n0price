{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="errorbox">

            </div>
        </div>
    </div>
</div>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Coins
                    <span class="d-block text-muted pt-2 font-size-sm">List of available Coins</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <a href="{{ route('coins.sync') }}" class="btn btn-success font-weight-bolder mx-3">
                    <i class="flaticon-coins"></i>
                    Sync Coin</a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="kt_datatable_all_coins_search_query_coin" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable_all_coins">
                <thead>
                    <tr>
                        {{-- <th style="width: 10px !important;">No</th>
                        <th>Name</th>
                        <th>Approval Status</th>
                        <th title="Field #6">Action</th> --}}
                    </tr>
                </thead>
                <tbody>

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
        var coin_datatable = $('#kt_datatable_all_coins').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/admin/get/all/coins',
                        contentType: 'application/json',
                        params: {
                            generalSearch: '',
                        },
                        map: function(data) {
                            // console.log(data);
                            return data.data;
                        }
                    }
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "id",
                    title: "Id",
                    width: 20,
                },
                {
                    field: "image",
                    title: "Image",
                    width: 60,
                    template: function(row) {
                        return '<img src="' + row.image + '" alt="img" class="mx-2" style="height:2em;">';
                    },
                },
                {
                    field: "symbol",
                    title: "Symbol",
                    width: 60,
                },
                {
                    field: "name",
                    title: "Name",
                    width: 200,
                },
                {
                    field: "status",
                    title: "Status",
                    template: function(row) {
                        if (row.status == 0) {
                            return '<span class="text-danger fs-6">Inactive</span>';
                        } else {
                            return '<span class="text-success fs-6">Active</span>';
                        }
                    },
                    width: 150,
                },
                {
                    field: "coin_id",
                    title: "Actions",
                    template: function(row) {
                        if (row.status == 0) {
                            return '<button class="btn btn-icon btn-info btn-xs mr-2" data-toggle="tooltip" title="Approve" onclick="activeCoin('+row.id+')">' +
                                '<i class="fa fa-check"></i>' +
                                '</button>';
                        } else {
                            return '<button class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip" title="Disable"onclick="inactiveCoin('+row.id+')">' +
                                    '<i class="fa fa-minus"></i>' +
                                    '</button>';
                        }
                    }
                }
            ],
            search: {
                input: $('#kt_datatable_all_coins_search_query_coin'),
                key: 'generalSearch'
            }
        });
        function activeCoin(coin_id){
            swal.fire({
                title: "Delete!",
                text: "Are you sure you want to make this coin active ?",
                icon: "question",
                buttonsStyling: false,
                confirmButtonText: "Yes I'm sure",
                showCancelButton: true,
                cancelButtonText: "No",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-default"
                }
            }).then(function(result) {
                if (result.hasOwnProperty('value')) {
                    $.ajax({
                        url: "{{ route('coins.active') }}",
                        type: "POST",
                        data: {
                            id: coin_id
                        },
                        success: function(result) {
                            $('.errorbox').html(
                                "<div class='p-4 bg-success text-white'>Coin has been activated.</div>"
                            );
                            coin_datatable.load();

                            setTimeout(removeerrbox, 3000);

                            function removeerrbox() {
                                $('.errorbox').html("")
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    // var form_id = "deleteMyTransaction-" + tid;
                    // $("#" + form_id).submit();
                }
            });
            
        }
        function inactiveCoin(coin_id){
            swal.fire({
                title: "Delete!",
                text: "Are you sure you want to deactivate this coin ?",
                icon: "question",
                buttonsStyling: false,
                confirmButtonText: "Yes I'm sure",
                showCancelButton: true,
                cancelButtonText: "No",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-default"
                }
            }).then(function(result) {
                if (result.hasOwnProperty('value')) {
                    $.ajax({
                        url: "{{ route('coins.inactive') }}",
                        type: "POST",
                        data: {
                            id: coin_id
                        },
                        success: function(result) {
                            $('.errorbox').html(
                                "<div class='p-4 bg-success text-white'>Coin has been deactivated.</div>"
                            );
                            coin_datatable.load();

                            setTimeout(removeerrbox, 3000);

                            function removeerrbox() {
                                $('.errorbox').html("")
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    // var form_id = "deleteMyTransaction-" + tid;
                    // $("#" + form_id).submit();
                }
            });
        }
    </script>
@endsection
