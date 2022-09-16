<?php

use App\Http\Controllers\VehicleController;

$data = VehicleController::getdetails($vehicle_id);

$Vehicle = $data['Vehicle'];
$Dealer = $data['Dealer'];
$Customer = $data['Customer'];
$ProductCode = $data['ProductCode'];


?>

<?php

$Product = 'N/A';
$Product = isset($ProductCode['product']) ? $ProductCode['product'] : $Vehicle['product'];
$Registration_no = $Vehicle['registration_no'];
$Engine_no = $Vehicle['engine_no'];
$Chasis_no = $Vehicle['chasis_no'];
$date_of_sale = $Vehicle['date_of_sale'];
$date_of_registration = $Vehicle['date_of_registration'];

$customer_name = isset($Customer['name']) ? $Customer['name'] : '';
$customer_contact = isset($Customer['contact_no']) ? $Customer['contact_no'] : '';

$customer_address = isset($Customer['address']) ? $Customer['address'] : 'N/A';

$customer_vehicles_allowed = 'Limited';
if (isset($Customer['allow_unlimited_vehicles'])) {
    if ($Customer['allow_unlimited_vehicles'] == 1) {
        $customer_vehicles_allowed = 'UnLimited';
    }
}


$dealer_name = $Dealer['name'];
$dealer_contact = $Dealer['contact'];
$dealer_code = $Dealer['dealer_code'];
$dealer_address = $Dealer['address'];
?>

<div class="container vehicle_info">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                            </div>
                            <h5 class="user-email"><?php echo $Registration_no; ?></h5>
                            <h5 class="user-name"><?php echo $Product; ?></h5>

                            <h5 class="user-email">Engine no: <?php echo $Engine_no; ?></h5>
                            <h5 class="user-email">Chasis no: <?php echo $Chasis_no; ?></h5>
                            <?php if (isset($date_of_sale)) { ?>
                                <h4 class="user-email">Sold on: <?php echo $date_of_sale; ?></h4>
                            <?php } ?>
                            <?php if (isset($date_of_registration)) { ?>
                                <h5 class="user-email">Registered on: <?php echo $date_of_registration; ?></h5>
                            <?php } ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mb-2 text-primary">Customer</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName"><?php echo $customer_name; ?></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName"><?php echo $customer_contact; ?></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName">Address</label><br />
                                <label for="fullName"><?php echo $customer_address; ?></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName">No. of Vehicles allowed</label><br />
                                <label for="fullName"><?php echo $customer_vehicles_allowed; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mt-3 mb-2 text-primary">Dealer</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName"><?php echo $dealer_name; ?></label><br />
                                <label for="fullName">Code: <?php echo $dealer_code; ?></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="ciTy">Contact No.</label><br />
                                <label for="ciTy"><?php echo $dealer_contact; ?></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="sTate">Address</label><br />
                                <label for="ciTy"><?php echo $dealer_address; ?></label>
                            </div>
                        </div>

                    </div>
                    <?php if (isset($ServiceCoupon)) {
                        $coupon_no =  $ServiceCoupon['coupon_no'];
                        $fsc_no =  $ServiceCoupon['fsc_no'];
                        $servicing_dealer = $ServiceCoupon['dealer_name'];
                        $servicing_dealer_contact = $ServiceCoupon['dealer_contact'];
                        $servicing_dealer_address = $ServiceCoupon['dealer_address'];
                        $schedule_type = 'Scheduled';
                        if ($ServiceCoupon['schedule_type'] !== 0) {
                            $schedule_type = 'UnScheduled';
                        }
                        $service_type = $ServiceCoupon['service_type'];
                        $duration = $ServiceCoupon['duration'] . " days";
                        $distance = $ServiceCoupon['distance'];
                        $status_array = array(
                            '0' => 'New',
                            '1' => 'Requested',
                            '2' => 'In Progress',
                            '3' => 'Completed',
                            '4' => 'Cancelled',
                            '5' => 'Rejected'
                        );
                        $status = $ServiceCoupon['status'];
                        $service_date = $ServiceCoupon['service_date'];
                        $service_km = $ServiceCoupon['service_km'];
                        $service_start = $ServiceCoupon['service_start'];
                        $service_end = $ServiceCoupon['service_stop'];
                        $next_service_date = $ServiceCoupon['next_service_date'];
                    ?>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h4 class="mt-3 mb-2 text-primary">Servicing Record: <?php echo "(" . $coupon_no . ") " . $status_array[$status] . ' ON ' . $service_date; ?></h4>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">FSC No: <?php echo $fsc_no . "  (" . $schedule_type . " / " . $service_type . ") "; ?></label><br />
                                    <label for="fullName"><?php echo $duration . ", " . $distance; ?></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">Workshop: <?php echo $dealer_name; ?></label><br />
                                    <label for="ciTy"><?php echo $servicing_dealer_contact . ", " . $servicing_dealer_address; ?></label>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">Service KM: <?php echo $service_km; ?></label><br />
                                    <label for="ciTy">Service Start: <?php echo $service_start; ?></label>
                                    <label for="ciTy">Service End: <?php echo $service_end; ?></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">Next Service Date</label><br />
                                    <label for="ciTy"><?php echo $next_service_date; ?></label>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    body {
        margin: 0;
        padding-top: 40px;
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
    }

    .account-settings .user-profile {
        margin: 0 0 1rem 0;
        padding-bottom: 1rem;
        text-align: center;
    }

    .account-settings .user-profile .user-avatar {
        margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
        width: 90px;
        height: 90px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
        margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 400;
        color: #9fa8b9;
    }

    h5.user-email,
    h5.user-name {
        font-size: 1.10rem;
    }

    .account-settings .about {
        margin: 2rem 0 0 0;
        text-align: center;
    }

    .account-settings .about h5 {
        margin: 0 0 15px 0;
        color: #007ae1;
    }

    .account-settings .about p {
        font-size: 0.825rem;
    }

    /* .form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .825rem;
    background: #ffffff;
    color: #2e323c;
} */

    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }
</style>