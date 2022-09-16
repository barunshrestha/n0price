<?php 
use App\Http\Controllers\CustomerController;
$data = CustomerController::getdetails($customer_id);

$Customer = $data['Customer'];

?>

<?php
     $customer_name = $Customer['name'];
     $customer_contact = $Customer['contact_no'];
     $customer_address = 'N/A';
     $customer_gender = 'N/A';
     if($Customer['address'] !== ''){
         $customer_address = $Customer['address'];
     }
     if($Customer['gender'] !== ''){
        $customer_gender = $Customer['gender'];
    }
     $customer_vehicles_allowed = 'Limited';
     if($Customer['allow_unlimited_vehicles'] == 1){
         $customer_vehicles_allowed = 'UnLimited';
     }
?>
 
<div class="container customer_info">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
				</div>
			
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <h6 class="mb-2 text-primary"><?php echo $customer_name; ?></h6>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="fullName"><?php echo $customer_contact; ?></label>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="fullName"><?php echo $customer_address; ?></label>
                </div>
            </div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="row gutters">
        @include('layout.partials.customer_details',['customer_id' => $customer_id])
		</div>    

        <?php if(isset($CustomerDetails)){ 
                $customer_id =  $CustomerDetails['customer_id']  ;
                $name =  $CustomerDetails['name']  ;
                $address = $CustomerDetails['address'];
                $license_no = $CustomerDetails['license_no'];
        ?>
        <div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h4 class="mt-3 mb-2 text-primary">Customer Record:  <?php echo "(".$customer_id.") ". ' ON '. $name; ?></h4>
			</div>
			</div>
			
		</div>
        <?php } ?>
		 
        
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