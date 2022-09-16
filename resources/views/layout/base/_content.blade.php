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
