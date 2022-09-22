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
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="kt_datatable_search_query_coin" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                    {{-- <form action="{{ route('user.approvalFilter') }}" method="POST" class="d-flex">
                                        @csrf
                                        <select class="form-control" id="kt_datatable_search_status" name="approval_status">
                                            <option selected value="">
                                               All Available Status
                                            </option>
                                            @foreach ($approval_status as $key => $status)
                                                <?php
                                                if ($status->approval_status == '0') {
                                                    $value = 'Unapproved';
                                                } elseif ($status->approval_status == '1') {
                                                    $value = 'Approved';
                                                }
                                                ?>
                                                <option value="{{ $status->approval_status }}">
                                                    {{ $value }}
                                                </option>
                                            @endforeach

                                        </select>
                                        <button type="submit" class="mx-5 btn btn-primary" >
                                            Search
                                        </button>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered table-responsive" id="kt_datatable">
                <thead>
                    <tr>
                        <th style="width: 10px !important;">No</th>
                        <th>Name</th>
                        <th>Approval Status</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coins as $key => $coin)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $coin->name }}</td>

                            <td>
                                @if ($coin->status == '0')
                                    <span class="text-danger fs-6">
                                        Inactive
                                    </span>
                                @else
                                    <span class="text-success fs-6">
                                        Active
                                    </span>
                                @endif
                                {{-- {{ $user->approval_status == '0' ? 'Unapproved' : 'Approved' }} --}}
                            </td>

                            <td>
                                @if ($coin->status == '0')
                                    <a href="{{ route('coins.active', $coin->id) }}"
                                        class="btn btn-icon btn-info btn-xs mr-2" data-toggle="tooltip" title="Approve">
                                        <i class="fa fa-check"></i>
                                    </a>
                                @else
                                    <a href="{{ route('coins.inactive', $coin->id) }}"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip" title="Disable">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                @endif
                                <a href="{{ route('coins.edit', $coin->id) }}" class="btn btn-icon btn-success btn-xs mr-2"
                                    data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('coins.destroy', $coin->id) }}" style="display: inline-block;"
                                    method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" value="Delete"
                                        class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                        title="Delete"><i class="fa fa-trash"></i></button>
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
                    field: "Approval Status",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_coin'),
                key: 'generalSearch'
            }
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    </script>
@endsection
