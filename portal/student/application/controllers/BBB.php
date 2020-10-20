<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BBB extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('CI_Bigblue');
		$this->load->library('CI_Bigblue2');
	}

	public function joinSTD(){

		$courseID = $this->input->post('course_id');
		$sessId = $this->session->userdata('session_id');
		$academy_id = $this->session->userdata('academy_id');
//		$Data = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', null, null, array('courses_students.student_nc' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'course_id' => $courseID));
		$student = $this->base->get_data('students' , 'first_name_en,last_name_en' , array('national_code'=>$sessId, 'academy_id'=>$academy_id));
		$fullName = $student[0]->first_name_en . ' ' . $student[0]->last_name_en;
		$MID = array('meetingID' => $courseID . '22');
		$isRunning = $this->ci_bigblue->meeting_status($MID);

		if ($isRunning['running'] == 'true'){
			$params2 = array(
				'meetingID'=> $courseID . '22',
				'password' => '123', #required
				'fullName' => str_replace(" " ,"_", $fullName),#required  - must be without space
				//'userID' =>  "1554" ,#Optional  - *** if you dont have user id so please delete this line ***
				//'guestPolicy'=>  "ASK_MODERATOR" , #Optional - ALWAYS_ACCEPT, ALWAYS_DENY, and ASK_MODERATOR
			);
			$course_id = array(
				'courseID'=>$courseID
			);
			$this->session->set_userdata($course_id);
			redirect($this->ci_bigblue->join_meeting($params2));
		} else {
			$this->session->set_flashdata('fail','کلاس هنوز تشکیل نشده است');
			redirect('student/profile');
		}
	}

	public function join_meeting($server_id, $meeting_id, $password, $fullName){
		$params = array(
			'meetingID'=> $meeting_id . '22',
			'password' => $password, #required
			'fullName' => str_replace(" " ,"_", $fullName),#required  - must be without space
		);

        $meetingID = array(
            'meeting_id'=>$meeting_id,
        );
        $this->session->set_userdata($meetingID);

		if ($server_id == '1'){
			redirect($this->ci_bigblue->join_meeting($params));
		} elseif ($server_id == '2'){
			redirect($this->ci_bigblue2->join_meeting($params));
		}
	}


	public function online_class_info($server_id, $meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == 1){
			$partisipants = $this->ci_bigblue->meeting_info($MID);
		} elseif ($server_id == 2) {
			$partisipants = $this->ci_bigblue2->meeting_info($MID);
		}
		return $partisipants;
	}

	public function existence($server_id, $meeting_id, $fullName){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == 1){
			$partisipants = $this->ci_bigblue->meeting_info($MID);
		} elseif ($server_id == 2) {
			$partisipants = $this->ci_bigblue2->meeting_info($MID);
		}
		if ($partisipants['participantCount'] > 1){
			for ($i = 0 ;$i < count($partisipants['attendees']['attendee']); $i++){
				if ($partisipants['attendees']['attendee'][$i]->fullName == $fullName ){
					$this->session->set_flashdata('fail','شما قبلا وارد کلاس شده اید');
					redirect('student/profile' ,'refresh');
				}
			}
		}
	}

	public function is_running($server_id, $meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == '1'){
			$isRunning = $this->ci_bigblue->meeting_status($MID);
            return $isRunning['running'];
		} elseif ($server_id == '2') {
			$isRunning = $this->ci_bigblue2->meeting_status($MID);
            return $isRunning['running'];
		}
        return false;

	}

	public function join_student(){
		$student_id = $this->session->userdata('student_id');
		$meeting_id = $this->input->post('course_id');
		$sessId = $this->session->userdata('session_id');
		$student = $this->base->get_data('students' , 'first_name_en,last_name_en' , array('national_code'=>$sessId));
		$server_id = $this->base->get_data('courses', 'using_server', array('course_id'=>$meeting_id));
		$fullName = $student[0]->first_name_en . ' ' . $student[0]->last_name_en;
		$fullName = str_replace(" " ,"_", $fullName).'_'.$student_id;
		$MID = array('meetingID' => $meeting_id . '22');
		$password = '123';

		$meetingID = array(
			'meeting_id'=>$meeting_id
		);
		$this->session->set_userdata($meetingID);

		if ($this->is_running($server_id[0]->using_server, $meeting_id) == 'true'){
			$this->existence($server_id[0]->using_server, $meeting_id, $fullName);
			$this->join_meeting($server_id[0]->using_server,$meeting_id,$password,$fullName);
		} else {
			$this->session->set_flashdata('fail','کلاس آنلاین توسط معلم شروع نشده است');
			redirect('student/profile' ,'refresh');
		}
	}

}
