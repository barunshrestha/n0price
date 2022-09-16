{{-- Content --}}

@if (config('layout.content.extended'))
    <div class="alert alert-primary" role="alert">
        {{ session('success') }}
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
    @yield('content')
@else
    <div class="d-flex flex-column-fluid">

        <div class="{{ Metronic::printClasses('content-container', false) }}">
            <div class="row align-items-center">
                <div class="card-body px-0">
                    <div class="col-md-12 my-2 my-md-0">
                        <div class="row align-items-center">
                            <div class="col-md-3 my-md-0">
                                {{ Form::open(['url' => '/search_vehicles', 'method' => 'get']) }}

                                <div class="input-icon">
                                    <input type="text" class="form-control" name="registration_no"
                                        placeholder="Search by vehicle details" id="kt_datatable_search_query"
                                        value="{{ isset($registration_no) ? $registration_no : '' }}" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-3 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="customer_name"
                                        placeholder="Search by customer details" id="kt_datatable_search_query"
                                        value="{{ isset($customer_name) ? $customer_name : '' }}" />
                                    <span>
                                        <i class=" flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 my-md-0">
                                {{-- <!-- @if (isset($date_from) && isset($date_to)) --> --}}
                                <div class="row align-items-center">

                                    <label class="col-form-label text-right col-lg-2 col-sm-2">Sale date
                                        (start)</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <input name="date_from" type="date" id="startdate"
                                            class="date-input form-control form-control-solid"
                                            value="{{ isset($date_from) ? $date_from : '' }}" />
                                    </div>
                                    <label class="col-form-label text-right col-lg-2 col-sm-2">Sale
                                        date(end)</label>
                                    <div class="col-lg-3 col-md-2 col-sm-6">
                                        <input name="date_to" type="date" id="enddate"
                                            class="date-input form-control form-control-solid"
                                            value="{{ isset($date_to) ? $date_to : '' }}" />
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2 submitBtn"><i
                                            class="fa fa-submit"></i> Search</button>
                                </div>
                                {{-- <!-- @endif --> --}}
                                {{ Form::close() }}

                            </div>

                        </div>

                    </div>
                </div>
                <!-- </form> -->
            </div>
            @if (\Session::has('success'))
                <div class="alert alert-primary" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            @elseif (\Session::has('fail'))
                <div class="alert alert-primary" role="alert">
                    {{ session('fail') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
@endif
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".date-input").change(function() {
                const startDate = $("#startdate").val();
                const enddate = $("#enddate").val();
                const new_startDate = new Date(startDate).getTime();
                const new_enddate = new Date(enddate).getTime();
                if (new_startDate >= new_enddate) {
                    alert("Start date cannot be greater than End date");
                    $("#enddate").val("");
                }
            });
        });
    </script>
@endpush
