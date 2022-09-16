<?php
use App\Http\Controllers\VehicleController;
$data = VehicleController::getAllVehiclesByCustomer($customer_id);

?>

<div class="container text-center my-3">
    <div class="row mx-auto my-auto">
        {{-- <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach ($data['Vehicles'] as $key => $vehicle)
                    <div class="carousel-item <?php echo $key == 0 ? 'active' : ''; ?>">
                        <div class="col-md-4 offset-4">
                            <div class="card card-body">
                                <label>Vechicle no: {{ $key + 1 }}</label>
                                <h6 class="mt-2">{{ $vehicle->registration_no }}</h6>
                                <label>{{ $vehicle->product }}</label>
                                <label>{{ $vehicle->chasis_no }}</label>
                                <label>{{ $vehicle->engine_no }}</label>
                                <label><strong>Date of Sale</strong></label>
                                <label>{{ $vehicle->date_of_sale }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle"
                    aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle"
                    aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div> --}}
        <div id="carouselExampleIndicators" class="carousel slide w-50" data-interval="false" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($data['Vehicles'] as $key => $vehicle)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                        class="active bg-dark"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($data['Vehicles'] as $key => $vehicle)
                    <div class="carousel-item <?php echo $key == 0 ? 'active' : ''; ?>">
                        <div class="col-md-8 offset-2">
                            <div class="card card-body">
                                <h6 class="mt-2">{{ $vehicle->registration_no }}</h6>
                                <label>{{ $vehicle->product }}</label>
                                <label>{{ $vehicle->chasis_no }}</label>
                                <label>{{ $vehicle->engine_no }}</label>
                                <label><strong>Date of Sale</strong></label>
                                <label>{{ $vehicle->date_of_sale }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle"
                    aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next w-auto" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle"
                    aria-hidden="true"></span>
                <span class="sr-only ">Next</span>
            </a>
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $('.carousel .carousel-item').each(function() {
            var minPerSlide = 3;
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i = 0; i < minPerSlide; i++) {
                next = next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }

                next.children(':first-child').clone().appendTo($(this));
            }

        });
    </script>
@endsection

<style>
    @media (max-width: 768px) {
        .carousel-inner .carousel-item>div {
            display: none;
        }

        .carousel-inner .carousel-item>div:first-child {
            display: block;
        }
    }

    .carousel-inner .carousel-item.active,
    .carousel-inner .carousel-item-next,
    .carousel-inner .carousel-item-prev {
        display: flex;
    }

    /* display 3 */
    @media (min-width: 768px) {

        .carousel-inner .carousel-item-right.active,
        .carousel-inner .carousel-item-next {
            transform: translateX(33.333%);
        }

        .carousel-inner .carousel-item-left.active,
        .carousel-inner .carousel-item-prev {
            transform: translateX(-33.333%);
        }
    }

    .carousel-inner .carousel-item-right,
    .carousel-inner .carousel-item-left {
        transform: translateX(0);
    }
</style>
