<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class API_BBB extends CI_Controller {
	private $salt = 'EYJNm3FzGEvg#zVLp7vG';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('user_agent');
		$this->load->library('CI_Bigblue');
	}

	public function join_student(){
		$user_var = file_get_contents('php://input');
		$user_var = json_decode($user_var, 1);

		if(isset($user_var['national_code']) && !empty($user_var['national_code']) && isset($user_var['academy_id']) && !empty($user_var['academy_id']) && isset($user_var['course_id']) && !empty($user_var['course_id'])){

			$sessId = $user_var['national_code'];
			$courseID = $user_var['course_id'];
			$academy_id = $user_var['academy_id'];
//		$Data = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', null, null, array('courses_students.student_nc' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'course_id' => $courseID));
			$student = $this->base->get_data('students' , 'first_name_en,last_name_en' , array('national_code'=>$sessId, 'academy_id'=>$academy_id));
			$fullName = $student[0]->first_name_en . ' ' . $student[0]->last_name_en;
			$MID = array('meetingID' => $courseID . '11');
			$isRunning = $this->ci_bigblue->meeting_status($MID);

			if ($isRunning['running'] == 'true'){
				$params2 = array(
					'meetingID'=> $courseID . '11',
					'password' => '123', #required
					'fullName' => str_replace(" " ,"_", $fullName),#required  - must be without space
					//'userID' =>  "1554" ,#Optional  - *** if you dont have user id so please delete this line ***
					//'guestPolicy'=>  "ASK_MODERATOR" , #Optional - ALWAYS_ACCEPT, ALWAYS_DENY, and ASK_MODERATOR
				);
				$result['response'] = (string) 1;
				$result['mesg'] = 'لینک جلسه آنلاین';
				$result['online_meeting_link'] = $this->ci_bigblue->join_meeting($params2);
			} else {
				$result['response'] = (string) 0;
				$result['mesg'] = 'کلاس شروع نشده';
			}
		} else {
			$result['response'] = (string) 0;
			$result['mesg'] = 'خطای نقص ورودی';
		}
		echo json_encode($result);
	}

	public function create_meeting_by_teacher(){
		$user_var = file_get_contents('php://input');
		$user_var = json_decode($user_var, 1);

		if(isset($user_var['national_code']) && !empty($user_var['national_code']) && isset($user_var['academy_id']) && !empty($user_var['academy_id']) && isset($user_var['course_id']) && !empty($user_var['course_id'])){

			$sessId = $user_var['national_code'];
			$courseID = $user_var['course_id'];
			$academy_id = $user_var['academy_id'];

			$teacher = $this->base->get_data('employers' , 'last_name_en' , array('national_code'=>$sessId, 'academy_id'=>$academy_id));

			$MID = array('meetingID' => $courseID . '11');
			$isRunning = $this->ci_bigblue->meeting_status($MID);

			if (!($isRunning['running'] == 'true')){
				$params1 = array(
					'name'=> $courseID, #optional
					'meetingID'=> $courseID . '11', # get unique id for meetingID , you can set your custom meeting id - required
					'attendeePW'=>'123', #optional
					'moderatorPW'=>'123456', #optional
//					'logoutURL' => 'location: myapputabedu://edu.com',
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
					'ST' => time()
				);
				$this->session->set_userdata($started_time);
			}
			$params2 = array(
				'meetingID'=> $courseID . '11',
				'password' => '123456', #required
				'fullName' => $teacher[0]->last_name_en,//str_replace(" " ,"_", $fullName),#required  - must be without space
				//'userID' =>  "1554" ,#Optional  - *** if you dont have user id so please delete this line ***
				//'guestPolicy'=>  "ASK_MODERATOR" , #Optional - ALWAYS_ACCEPT, ALWAYS_DENY, and ASK_MODERATOR
			);
			$result['response'] = (string) 1;
			$result['mesg'] = 'لینک جلسه آنلاین';
			$result['online_meeting_link'] = $this->ci_bigblue->join_meeting($params2);
		} else {
			$result['response'] = (string) 0;
			$result['mesg'] = 'خطای نقص ورودی';
		}
		echo json_encode($result);
	}

	public function return_app(){
		header("location: myapputabedu://edu.com");
	}
}
