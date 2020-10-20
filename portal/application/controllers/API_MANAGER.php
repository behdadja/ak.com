<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;

class API_MANAGER extends CI_Controller
{

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
//        $this->load->helper('Api_Helper');
        $this->load->library('user_agent');
//        $this->load->library('zarinpal', [
//            'merchant_id' => '50a9ce9c-9cbd-11e9-b0b8-000c29344814'
//        ]);
    }

    public function test_api()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $national_code = $user_var['national_code'];
        $result['response'] = (string) 1;
        $result['mesg'] = $national_code;
        echo json_encode($result);
    }
}
