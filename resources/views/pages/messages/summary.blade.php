{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles --}}
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-body">
            <div class="d-flex">

                <table class="table table-bordered" id="kt_datatable_message_summary">
                    <thead>
                        <tr>
                            <th>Device ID</th>
                            <th>Device</th>
                            <th style="width: 20%;">Date</th>
                            <th style="width: 20%;">SMS Sent</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($summary as $data)
                            <tr>
                                <td>{{ $data->device_id }}</td>
                                <td>{{ $devices[$data->device_id] }}</td>
                                <td>{{ $data->date }}</td>
                                <td>{{ $data->count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total SMS Sent</th>
                            <th>Last SMS Sent at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($total_count); $i++)
                            <tr>
                                <td>
                                    {{ $devices[$total_count[$i]->device_id] }}: {{ $total_count[$i]->count }}
                                </td>
                                <td>
                                    {{ $last_sms[$i][0]->updated }}
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
