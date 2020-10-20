<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BBB extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('CI_Bigblue');
		$this->load->library('CI_Bigblue2');
	}

	public function createMeeting_join(){

		$courseID = $this->input->post('course_id');
		$sessId = $this->session->userdata('session_id');
		$academy_id = $this->session->userdata('academy_id');
//		$Data = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'course_id' => $courseID));
		$teacher = $this->base->get_data('employers' , 'last_name_en' , array('national_code'=>$sessId, 'academy_id'=>$academy_id));
//		$fullName = 'سیبلات';

		$MID = array('meetingID' => $courseID . '22');
		$isRunning = $this->ci_bigblue->meeting_status($MID);

		if (!($isRunning['running'] == 'true')){
			$params1 = array(
				'name'=> $courseID, #optional
				'meetingID'=> $courseID . '22', # get unique id for meetingID , you can set your custom meeting id - required
				'attendeePW'=>'123', #optional
				'moderatorPW'=>'123456', #optional
				'logoutURL' => 'http://amoozkadeh.com/CD',
				'duration'=>'120' #optional
			);
			$started_time = array(
				'ST'=>time(),
				'courseID'=>$courseID,
			);
			$this->session->set_userdata($started_time);
			$this->ci_bigblue->create_meeting($params1);

		}
		if (!($this->session->userdata('ST'))) {
			$started_time = array(
				'ST' => time(),
				'courseID'=>$courseID
			);
			$this->session->set_userdata($started_time);
		}
		$params2 = array(
			'meetingID'=> $courseID . '22',
			'password' => '123456', #required
			'fullName' => $teacher[0]->last_name_en,//str_replace(" " ,"_", $fullName),#required  - must be without space
			//'userID' =>  "1554" ,#Optional  - *** if you dont have user id so please delete this line ***
			//'guestPolicy'=>  "ASK_MODERATOR" , #Optional - ALWAYS_ACCEPT, ALWAYS_DENY, and ASK_MODERATOR
		);
		redirect($this->ci_bigblue->join_meeting($params2));
	}

	public function is_running($server_id, $meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == '1'){
			$isRunning = $this->ci_bigblue->meeting_status($MID);
		} elseif ($server_id == '2'){
			$isRunning = $this->ci_bigblue2->meeting_status($MID);
		}
		return $isRunning['running'];
	}

	public function online_class_info($server_id ,$meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == '1'){
			$participants = $this->ci_bigblue->meeting_info($MID);
		} elseif ($server_id == '2'){
			$participants = $this->ci_bigblue2->meeting_info($MID);
		}
		return $participants;
	}

	public function join_meeting($server_id, $meeting_id, $password, $fullName){
		$params = array(
			'meetingID'=> $meeting_id . '22',
			'password' => $password, #required
			'fullName' => str_replace(" " ,"_", $fullName),#required  - must be without space
		);

        if (!$this->session->userdata('meeting_id')){
            $meetingID = array(
                'meeting_id'=>$meeting_id,
            );
            $this->session->set_userdata($meetingID);
        }

		if ($server_id == '1'){
			redirect($this->ci_bigblue->join_meeting($params));
		} elseif ($server_id == '2'){
			redirect($this->ci_bigblue2->join_meeting($params));
		}
	}

	public function create_meeting($server_id, $meeting_id, $ap, $mp){
		$params = array(
			'name'=> $meeting_id, #optional
			'meetingID'=> $meeting_id. '22', # get unique id for meetingID , you can set your custom meeting id - required
			'attendeePW'=>$ap, #optional
			'moderatorPW'=>$mp, #optional
			'logoutURL' => 'http://amoozkadeh.com/CD',
			'duration'=>'120' #optional
		);

		$count = $this->base->get_data('servers', 'server_usage', array('server_id' => $server_id));
		$this->base->update('servers' , array('server_id' => $server_id), array('server_usage' => intval($count[0]->server_usage) + 1));
		$this->base->update('courses' ,array('course_id' => $meeting_id), array('using_server' => $server_id , 'start_time' => time()));

		$meetingID = array(
			'meeting_id'=>$meeting_id,
		);
		$this->session->set_userdata($meetingID);


		if ($server_id == '1'){
			$this->ci_bigblue->create_meeting($params);
		} elseif ($server_id == '2'){
			$this->ci_bigblue2->create_meeting($params);
		}
	}

	public function best_server($servers){

		for ($i = 0 ; $i <count($servers) ; $i++){
			for ($j = $i+1 ; $j < count($servers) ; $j++){
				if ($servers[$i]->server_usage > $servers[$j]->server_usage){
					$temp = $servers[$i];
					$servers[$i] = $servers[$j];
					$servers[$j] = $temp;
				}
			}
		}
		for ($i = 0 ; $i < count($servers) ; $i++){
		    if ($servers[$i]->isON == '1'){
                return $servers[$i];
            }
        }
	}

	public function calculate_duration($academyID, $meeting_id){
		$total_AC_hour = $this->base->get_data('academys_option' , 'online_class_hours' ,array('academy_id'=>$academyID));
		$total_lesson_hour = $this->base->get_data('courses' , 'onlineClassHour' ,array('course_id'=>$meeting_id));
		$startedTime = $this->base->get_data('courses' , 'start_time' ,array('course_id'=>$meeting_id));
		$x = intval($total_AC_hour[0]->online_class_hours);
		$y = intval($total_lesson_hour[0]->onlineClassHour);
		$DU = time() - intval($startedTime[0]->start_time);

		if (intval($DU) > 7200) {
		    $DU = 7200;
        }

		$DU /= 3600;

		$x = $DU + $x;
		$y = $DU + $y;
		$this->base->update('academys_option', array('academy_id'=>$academyID) , array('online_class_hours'=>$x));
		$this->base->update('courses', array('course_id'=>$meeting_id) , array('onlineClassHour'=>$y));
	}

    public function clear(){

        $classes = $this->base->get_data('courses', 'course_id,using_server,academy_id');
        for ($i = 0 ; $i < count($classes) ; $i++){
            if (intval($classes[$i]->using_server) != 0){
                $is_on = $this->base->get_data('servers','isON',array('server_id' => $classes[$i]->using_server));
                if ($is_on[0]->isON == '1'){
                    if ($this->is_running($classes[$i]->using_server, $classes[$i]->course_id) == 'false'){
                        $this->calculate_duration($classes[$i]->academy_id,$classes[$i]->course_id);
                        $count = $this->base->get_data('servers', 'server_usage' ,array('server_id' => $classes[$i]->using_server));
                        $this->base->update('courses', array('course_id' => $classes[$i]->course_id), array('using_server'=>0));
                        $this->base->update('servers', array('server_id' => $classes[$i]->using_server), array('server_usage' => intval($count[0]->server_usage) - 1));
                    }
                } else {
                    $this->calculate_duration($classes[$i]->academy_id,$classes[$i]->course_id);
                    $count = $this->base->get_data('servers', 'server_usage' ,array('server_id' => $classes[$i]->using_server));
                    $this->base->update('courses', array('course_id' => $classes[$i]->course_id), array('using_server'=>0));
                    $this->base->update('servers', array('server_id' => $classes[$i]->using_server), array('server_usage' => intval($count[0]->server_usage) - 1));
                }
            }
        }
    }
	public function create_join_meeting(){
		## needed params
		$meeting_id = $this->input->post('course_id');
		$mp = '123456';
		$ap = '123';
		$sessId = $this->session->userdata('session_id');
		$teacher = $this->base->get_data('employers' , 'last_name_en' , array('national_code'=>$sessId));
		$fullName = $teacher[0]->last_name_en;
		$servers = $this->base->get_data('servers' , 'server_id,server_usage,isON');

		$this->clear();

        for ($i = 0 ; $i < count($servers) ; $i++){
            if ($servers[$i]->isON == '1'){
                if ($this->is_running($servers[$i]->server_id, $meeting_id) == 'true'){
                    $this->join_meeting($servers[$i]->server_id, $meeting_id,$mp, $fullName);
                    return 0;
                }
            }
        }

		$best_server = $this->best_server($servers);
		$this->create_meeting($best_server->server_id,$meeting_id,$ap,$mp);
		$this->join_meeting($best_server->server_id, $meeting_id, $mp,$fullName);

	}
}
