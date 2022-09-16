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
                <h3 class="card-label">Users
                    <span class="d-block text-muted pt-2 font-size-sm">List Of approved User</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>New User</a>

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
                                        id="kt_datatable_search_query_user" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Role:</label>
                                    <select class="form-control" id="kt_datatable_search_role">
                                        @foreach ($roles as $key => $role)
                                            <option value="{{ $role }}">{{ ucfirst(trans($role)) }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                    <form action="{{ route('user.approvalFilter') }}" method="POST" class="d-flex">
                                        @csrf
                                        <select class="form-control" id="kt_datatable_search_status" name="approval_status">
                                            <option selected value="">
                                                Select Approval Status
                                            </option>
                                            @foreach ($approval_status as $key => $status)
                                                <?php
                                                if ($status->approval_status == '0') {
                                                    $value = 'Left for approval';
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <table class="datatable datatable-bordered" id="kt_datatable">
                <thead>
                    <tr>
                        <th style="width: 10px !important;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Approval Status</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (isset($user->role))
                                    <a href="{{ route('roles.edit', $user->role->id) }}" data-toggle="tooltip"
                                        title="Edit"> {{ $user->role->name }}</a>
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                {{ $user->approval_status == '0' ? 'Left for approval' : 'Approved' }}
                            </td>

                            <td>
                                @if ($user->approval_status == '0')
                                    <a href="{{ route('user.approve', $user->id) }}"
                                        class="btn btn-icon btn-info btn-xs mr-2" data-toggle="tooltip" title="Approve">
                                        <i class="fa fa-check"></i>
                                    </a>
                                @else
                                    <a href="{{ route('user.unapprove', $user->id) }}"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip" title="Unapprove">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                @endif
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-icon btn-success btn-xs mr-2"
                                    data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" style="display: inline-block;"
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
                    field: "E-mail",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_user'),
                key: 'generalSearch'
            }
        });
        $('#kt_datatable_search_role').on('change', function() {
            datatable.search($(this).val(), 'Role');
        });
        // $('#kt_datatable_search_status').on('change', function() {
        //     datatable.search($(this).val(), 'Approval Status');
        // });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    </script>
@endsection
