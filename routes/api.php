<?php

use App\Http\Controllers\API\ComplainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\ServiceBookingController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\ServiceCouponController;
use App\Http\Controllers\API\CsiQuestionnaireController;
use App\Http\Controllers\API\EnquiriesController;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\ShowRoomVisitsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('connect_login', [CustomerController::class, 'login']);
Route::post('sathi_login', [UserController::class, 'login']);
Route::post('service_schedule_info', [CustomerController::class, 'service_schedule_info']);
Route::post('get_service_booking', [ServiceBookingController::class, 'get_service_booking']);
Route::get('check_expired_coupons', [ServiceCouponController::class, 'check_expired_coupons']);
Route::get('change_complain_status', [ComplainController::class, 'change_complain_status']);

Route::middleware('verifyToken')->group(function () {
    Route::post('list_exceeded_servicing', [UserController::class, 'list_exceeded_servicing']);
    
    Route::post('verification_code_api', [UserController::class, 'verification_code_api']);
    Route::post('check_verification_code', [UserController::class, 'check_verification_code']);
    
    Route::post('change_password_api', [UserController::class, 'change_password_api']);
    Route::post('change_customer_contact', [UserController::class, 'change_customer_contact']);
    Route::post('change_reg_no_api', [UserController::class, 'change_reg_no_api']);
    
    Route::post('generate_warranty_token_api', [UserController::class, 'generate_warranty_token_api']);
    Route::post('claim_warranty_api', [UserController::class, 'claim_warranty_api']);
    
    Route::post('each_fsc_servicing_details', [ServiceCouponController::class, 'each_fsc_servicing_details']);
    
    Route::post('api_get_complain_by_dealer', [ComplainController::class, 'api_get_complain_by_dealer']);
    Route::post('edit_complain_status', [ComplainController::class, 'edit_complain_status']);
    
    //Not being used now, all servicings can be fetched using vehicle_servicings api
    //Route::post('in_progress_servicings', [ServiceCouponController::class, 'in_progress_servicings']);
    Route::post('vehicle_servicings', [ServiceCouponController::class, 'vehicle_servicings']);
    
    
    Route::post('duration_days', [ServiceCouponController::class, 'duration_days']);
    
    Route::post('get_profile', [UserController::class, 'get_profile']);
    

    //Search Vehicles
    Route::post('search_vehicles', [VehicleController::class, 'search_vehicles']);
    //Link Vehicle to Customer
    Route::post('register_customer ', [VehicleController::class, 'register_customer_api']);
    //Unlink Vehicle from Customer
    Route::post('unlink_customer ', [VehicleController::class, 'unlink_customer']);

    //List Enquiries
    Route::post('enquiries_list', [EnquiriesController::class, 'get_enquiries']);
    //Edit Enquiries
    Route::post('enquiries_edit', [EnquiriesController::class, 'edit']);
    //Enquiries - Add FollowUp
    Route::post('enquiries_add_follow_up ', [EnquiriesController::class, 'add_follow_up']);
    //Enquiries - Add Enquiry
    Route::post('enquiries_add', [EnquiriesController::class, 'add_enquiry']);
    //Enquiries - Search Enquiry, Used while registering Customer, status must be sold (2)
    Route::post('enquiries_search', [EnquiriesController::class, 'search_enquiry']);
    //Enquiries - Search Enquiry, Used on Enquiries View
    Route::post('enquiries_search_all_status', [EnquiriesController::class, 'search_enquiry_all_status']);
    //Enquiry search by enquiry->id
    Route::post('enquiries_search_by_id', [EnquiriesController::class, 'search_enquiry_by_id']);

    
    //Servicing history for a vehicle,param:chasis_no
    Route::post('servicing_history', [ServiceCouponController::class, 'servicing_history']);
    //Service start
    Route::post('service_start', [ServiceCouponController::class, 'service_start']);
    //Service Complete
    Route::post('service_complete', [ServiceCouponController::class, 'service_complete']);
    //Service Cancel
    Route::post('service_cancel', [ServiceCouponController::class, 'service_cancel']);


    //Get all districts by Provinces
    Route::post('get_all_districts_by_provinces ', [DistrictController::class, 'get_all_districts_by_provinces']);
    //Get all districts by Provinces
    Route::post('get_municipalities_by_district ', [DistrictController::class, 'get_municipalities_by_district']);

    //Get CSI questionnaire
    Route::post('get_questionnaire', [CsiQuestionnaireController::class, 'get_questionnaire']);
    //Save CSI response
    Route::post('save_pdi_response', [CsiQuestionnaireController::class, 'save_pdi_response']);
    //Get CSI response with questionnaire
    Route::post('get_questionnaire_with_response', [CsiQuestionnaireController::class, 'get_questionnaire_with_response']);
    


    //Service Bookings Fetch
    Route::post('api_get_service_booking', [ServiceBookingController::class, 'api_get_service_booking']);
    //Service Bookings Update
    Route::post('service_booking_update', [ServiceBookingController::class, 'service_booking_update']);
    //Create Service Booking from NGM Sathi app
    Route::post('service_booking_create', [ServiceBookingController::class, 'service_booking_create']);
    
    //Fetch ShowRoom Visits
    Route::post('showroom_visits', [ShowRoomVisitsController::class, 'showroom_visits']);
    Route::post('showroom_visits_update', [ShowRoomVisitsController::class, 'showroom_visits_update']);
    
    //NGM Sathi Reports
    Route::post('overall_report_api', [ReportController::class, 'overall_report_api']);
    Route::post('survey_ratings_api', [ReportController::class, 'survey_ratings_api']);
    Route::post('sales_summary', [ReportController::class, 'sales_summary']);
    Route::post('enquiries_summary', [ReportController::class, 'enquiries_summary']);
    Route::post('servicings_summary', [ReportController::class, 'servicings_summary']);
    Route::post('service_reminders_summary', [ReportController::class, 'service_reminders_summary']);


    //Offer
    //Check Offer available
    Route::post('check_offer_available ', [OfferController::class, 'check_offer_available']);
    //List all offers associated to that dealer
    Route::post('registered_offers', [OfferController::class, 'registered_offers']);
    //Filtered 
    Route::post('registered_offers_search', [OfferController::class, 'registered_offers_search']);
    //Get Offer Code NGM -Sathi
    Route::post('get_offer_code', [OfferController::class, 'get_offer_code']);


    //Fsc Follow Up NGM Sathi
    Route::post('fsc_follow_up', [ReportController::class, 'fsc_follow_up']);
    Route::post('fsc_follow_up_update', [ServiceCouponController::class, 'fsc_follow_up_update']);

    //For PDI ChecklIst
    Route::post('pdi_list_vehicles', [VehicleController::class, 'pdi_list_vehicles']);
    Route::post('pdi_list_vehicles_completed', [VehicleController::class, 'pdi_list_vehicles_completed']);
    
    //Search Vehicles
    Route::post('rm_search_vehicles', [VehicleController::class, 'rm_search_vehicles']);
    
});
