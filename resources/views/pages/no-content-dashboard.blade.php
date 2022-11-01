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
                   
                </div>
                <form action="{{ route('percentage.allocation') }}" method="POST">

                    <div class="d-flex flex-column flex-root">
                        <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">

                            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">

                                <div class="login-form text-center p-7 position-relative overflow-hidden">

                                    <div class="login-signin">
                                        <div class="form-group mb-5 text-left">
                                            <input type="hidden" value={{$portfolio_details->id}} name="portfolio_id">
                                           <span>
                                                Please define your portfolio name.
                                            </span>
                                            <input
                                                class="form-control h-auto form-control-solid py-4 px-8 @error('portfolio_name')is-invalid @enderror"
                                                type="text" value="{{ $portfolio_details->portfolio_name}}" placeholder="Portfolio Name" required
                                                name="portfolio_name" />
                                            @error('portfolio_name')
                                                <div class="d-flex mt-2 invalid-feedback">
                                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                                    <div class="text-danger mx-3"> {{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mt-10">
                                            @csrf
                                            Please define your portfolio risk level to continue to your portfolio.<b> You
                                                can change
                                                this later.</b>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection
