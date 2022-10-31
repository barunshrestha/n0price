{{-- Extends layout --}}
@extends('layout.default')
@section('styles')
    <link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .coin_container .selection {
            margin-bottom: 1em;
        }

        .coin_container {
            display: flex;
        }

        .selection label {
            text-align: center;
            display: block;
            width: 7em;
            background-color: #42b4d6;
            border-radius: 12em;
            color: #ffffff;
            padding: 0.5em;
            cursor: pointer;
        }

        .coin_container .selection label:hover {
            background-color: #5fc0dc;
        }

        .coin_container .selection input[type=radio] {
            display: none;
        }

        .coin_container .selection input[type=radio]:checked~label {
            background-color: #f1592a;
        }

        .dropdown-image {
            height: 40px;
            width: 40px;
        }

        .icon-image {
            height: 25px;
            width: 25px;
        }


        .hidden {
            display: none !important;
        }

        .flexproperty {
            display: inline-flex;
        }

        #kt_datatable_coin_select tbody tr span {
            /* width:max-content !important; */
            width: 100% !important;
        }

        .gain-button {
            min-width: 8em;
        }

        #selected_coin span {
            width: 100% !important;
        }

        @media screen and (min-width: 1287px) {
            .portfolio-table {
                display: inline-table;
            }
        }
    </style>
@endsection
{{-- Content --}}
@section('content')
    @include('pages.transaction_add')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header card-header-tabs-line d-flex justify-content-end">
                    @if (Auth::user()->role_id == '2')
                        <ul class="nav nav-tabs nav-bold nav-tabs-line pe-5 row">
                            <li class="nav-item dropdown col-sm-12">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false" style="margin-right:5em;">
                                    {{ $user->name }}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item">Profiles</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="d-flex flex-column flex-root">
                    <!--begin::Login-->
                    <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">
                        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">
                            <div class="login-form text-center p-7 position-relative overflow-hidden">

                                <div class="login-signin">

                                    <div class="mt-10">
                                        Please define your portfolio risk level to continue to your portfolio.<b> You can change
                                        this later.</b>
                                        <form action="{{ route('percentage.allocation') }}" method="POST">
                                            @csrf
                                            <table class="table mt-5">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Market Capital</th>
                                                        <th scope="col">Risk</th>
                                                        <th scope="col">Allocation %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($asset_matrix_constraints as $constraints)
                                                        <tr style="background:<?php echo $constraints->color; ?>;">
                                                            <td style="vertical-align: middle;">
                                                                {{ $constraints->market_cap }}</td>
                                                            <td style="vertical-align: middle;">{{ $constraints->risk }}
                                                            </td>
                                                            <td style="vertical-align: middle;"><input type="text"
                                                                    class="form-control" name="allocation_percentage[]"
                                                                    value="{{ $constraints->percentage_allocation }}"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-success btn-xs ml-auto allocationSaveBtn"
                                                    type="submit" data-toggle="tooltip" title="Submit">Save
                                                    <h6 class="fa fa-save"></h6>
                                                </button>
                                            </div>
                                        </form>
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
@section('scripts')
    <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection
