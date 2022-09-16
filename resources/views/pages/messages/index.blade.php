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
                <h3 class="card-label">Messages
            </div>
            <div class="card-toolbar">
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
                                        id="kt_datatable_search_query_message" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="datatable datatable-bordered" id="kt_datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Device</th>
                        <th>Phone Number</th>
                        <th style="width: 45%;">Message</th>
                        <th>Status</th>
                        <th>Sent On</th>
                        <th title="Field #6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $key => $message)
                        <tr class="<?php echo $message->flag == 1 ? 'flagged' : ''; ?>">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ isset($devices[$message->device_id]) ? $devices[$message->device_id] : $message->device_id }}
                            </td>
                            <td style="width: 100px;">{{ $message->phone_number }}</td>
                            <td>{{ $message->message }}</td>
                            <td style="width: 100px;">{{ strtoupper($message->status) }}</td>
                            <td>{{ $message->created }}</td>
                            <td>

                                {{ Form::open(['url' => '/message_resend', 'method' => 'get', 'style' => 'display: inline-block;']) }}

                                {{ Form::hidden('id', $message->id) }}
                                <button type="submit" class="btn btn-icon btn-success btn-xs mr-2" title="resend"><i
                                        class="fa fa-sync"></i></button>
                                {{ Form::close() }}

                                <form action="{{ route('messages.flag', $message->id) }}" style="display: inline-block;"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if ($message->flag == 0)
                                        <button class="btn btn-link btn-icon btn-xs btn-danger" type="submit"
                                            name="action" value="delete" title="flag">
                                            <i class="fa fa-flag"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-link btn-icon btn-xs btn-secondary" type="submit"
                                            name="action" value="delete" title="unflag">
                                            <i class="fa fa-flag"></i>
                                        </button>
                                    @endif

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
                    width: 50,
                },
                {
                    field: "Phone Number",
                    width: 120,
                },
                {
                    field: "Status",
                    width: 80,
                },
                {
                    field: "Message",
                    width: 350,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query_message'),
                key: 'generalSearch'
            }
        });
    </script>

    <style>
        .flagged {}
    </style>
@endsection
