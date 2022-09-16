<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\SmsSettings;
use App\Models\Message;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSMS($mobile_no, $message_text){
        if(strlen($message_text) < 10){
            return false;
        }
        $exclude = $this->exclude_SMS($mobile_no);
        if($exclude){
            return false;
        }
        
        $gateway_info = $this->get_default_SMS_device($mobile_no);
        $message = [];
        $message['phone_number'] = '977'.$mobile_no;
        $message['device_id'] = $gateway_info['device'];
        $message['message'] = $message_text;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$gateway_info['gateway_url']); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array($message)));
        curl_setopt($curl, CURLOPT_VERBOSE, 0); 
        curl_setopt($curl, CURLOPT_HEADER, 0); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Authorization: ' .$gateway_info['auth']));

        $content = curl_exec($curl);
        $response = curl_getinfo($curl);
        
        curl_close($curl);
        $return['success'] = true;
        return $return;
    }

    public function get_default_SMS_device($mobile_no){
        $carrier = in_array(substr($mobile_no,0,3), array('984','985','986','974','975'))? 'ntc' : 'ncell';
        $sms_settings = SmsSettings::first();
        $return['carrier'] = $carrier;
        $carrier_gateway = $carrier.'_gateway';
        $gateway_active = $sms_settings->$carrier_gateway;
        $return['gateway'] = $gateway_active;
        $auth_key = $gateway_active.'_authorization_key';
        $return['auth'] = $sms_settings->$auth_key;
        $device_id = $gateway_active.'_'.$carrier.'_device_id';
        $return['device'] = $sms_settings->$device_id;
        if($return['gateway'] == 'sms'){ //HT Sajilo SMS Gateway
            $return['gateway_url'] = 'http://smsgateway.himalayantechies.com/api/messages/send';
        } else {
            $return['gateway_url'] = 'https://smsgateway.me/api/v4/message/send';
        }
        return $return;

    }

    public function exclude_SMS($mobile_no){
        //SMS wont be sent to these numbers
        $exclude_array = array(
                                '9801552000', '9843739137', //NGM numbers
                                '9849009280'  //Developer numbers
                            );
        if(in_array($mobile_no,$exclude_array)){
            return true;
        }
        //Check for characters
        if(! preg_match('/^\d+$/',$mobile_no)) { 
            return true;
        }
        //Validity by starting 3 digits of Nepal's current operators
        $valid_mobile_nos = array(
            '980','981','982',  //Ncell
            '984','985','986',  //NTC GSM
            '974','975',        //NTC CDMA
            '961','962','988'   //SMART 
        );
        if(in_array($mobile_no,$valid_mobile_nos)){
            return true;
        }
        //Mobile nos must be of 10 digits
        if(strlen($mobile_no) !== 10){
            return true;
        }
        return false;
    }

    public function get_active_devices(){
        $sms_settings = SmsSettings::first();
        $active_gateway_ntc = $sms_settings->ntc_gateway;
        $active_gateway_ncell = $sms_settings->ncell_gateway;
        if($active_gateway_ntc == 'sms'){
            $active_devices['ntc'] = $sms_settings->sms_ntc_device_id;
            $active_devices['ntc_auth'] = $sms_settings->sms_authorization_key;
            $active_devices['ntc_gateway_url_for_sync'] = 'https://smsgateway.himalayantechies.com/api/messages/filterBy';
            $active_devices['ntc_max_message_id'] = Message::where('device_id','=',$sms_settings->sms_ntc_device_id)->max('message_id');

        } else if($active_gateway_ntc == 'sgm'){
            $active_devices['ntc'] = $sms_settings->sgm_ntc_device_id;
            $active_devices['auth'] = $sms_settings->sgm_authorization_key;
            $active_devices['gateway_url_for_sync'] = 'https://smsgateway.me/api/v4/message/send';
            $active_devices['ntc_max_message_id'] = Message::where('device_id','=',$sms_settings->sgm_ntc_device_id)->max('id');
        }

        if($active_gateway_ncell == 'sms'){
            $active_devices['ncell'] = $sms_settings->sms_ncell_device_id;
            $active_devices['ncell_auth'] = $sms_settings->sms_authorization_key;
            $active_devices['ncell_gateway_url_for_sync'] = 'https://smsgateway.himalayantechies.com/api/messages/filterBy';
            $active_devices['ncell_max_message_id'] = Message::where('device_id','=',$sms_settings->sms_ncell_device_id)->max('message_id');
        } else if($active_gateway_ncell == 'sgm'){
            $active_devices['ncell'] = $sms_settings->sgm_ncell_device_id;
            $active_devices['ncell_auth'] = $sms_settings->sgm_authorization_key;
            $active_devices['ncell_gateway_url_for_sync'] = 'https://smsgateway.me/api/v4/message/send';
            $active_devices['ncell_max_message_id'] = Message::where('device_id','=',$sms_settings->sgm_ncell_device_id)->max('id');
        }
       
        $return['ntc']['gateway'] = $active_gateway_ntc ;
        $return['ntc']['device_id'] = $active_devices['ntc'] ;
        $return['ntc']['auth'] = $active_devices['ntc_auth'] ;
        $return['ntc']['gateway_url_for_sync'] = $active_devices['ntc_gateway_url_for_sync'];
        $return['ntc']['max_message_id'] = $active_devices['ntc_max_message_id'] == null ? 0 : $active_devices['ntc_max_message_id'];
        $return['ncell']['gateway'] = $active_gateway_ncell ;
        $return['ncell']['device_id'] = $active_devices['ncell'] ;
        $return['ncell']['auth'] = $active_devices['ncell_auth'] ;
        $return['ncell']['gateway_url_for_sync'] = $active_devices['ncell_gateway_url_for_sync'];
        $return['ncell']['max_message_id'] = $active_devices['ncell_max_message_id'] == null ? 0 : $active_devices['ncell_max_message_id'];
        
        return $return;
    }
   
}
