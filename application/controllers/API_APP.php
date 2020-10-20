<?php
defined('BASEPATH') or exit('No direct script access allowed');

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;

/*
* Validate api interface at: https://github.com/bigbluebutton/bigbluebutton-api-php
*/
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('Api_Helper');
    }

    public function create()
    {
        try {
            $data = getRequest();

            $bbb = new BigBlueButton();
            $createMeetingParams = new CreateMeetingParameters($data->meeting_id, $data->meeting_name);
            $createMeetingParams->setAttendeePassword($data->attendee_password);
            $createMeetingParams->setModeratorPassword($data->moderator_password);

            if (isset($data->is_recording)) {
                $createMeetingParams->setRecord(true);
                $createMeetingParams->setAllowStartStopRecording(true);
                $createMeetingParams->setAutoStartRecording(true);
            }

            $response = $bbb->createMeeting($createMeetingParams);

            if ($response->getReturnCode() == 'FAILED') {
                return 'Can\'t create room! please contact our administrator.';
            } else {
                echo('<pre>');
                print_r($response);
                echo('</pre>');
            }
        } catch (\Exception $e) {
            return show_error('Internal error '.$e, 500);
        }
    }
}
