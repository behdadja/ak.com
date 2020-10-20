<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BBB extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('CI_Bigblue');
		$this->load->library('CI_Bigblue2');
		$this->load->library('encryption');
	}

	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}

	public function running_classes(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$data =  $this->get_join->get_data4('courses' , 'academys_option' , 'courses.academy_id=academys_option.academy_id' , 'employers' , 'courses.course_master=employers.national_code' , 'lessons' , 'courses.lesson_id=lessons.lesson_id');
            $running_classes = array();
            $class_info = array();
            $count = 0;
			for ($i = 0 ; $i < count($data) ; $i++){
                if (intval($data[$i]->using_server) != 0){
                    if ($this->is_running($data[$i]->using_server, $data[$i]->course_id) == 'true'){
                        $running_classes[$count] = $data[$i];
                        $class_info[$count] = $this->online_class_info($data[$i]->using_server,$data[$i]->course_id);
                        $count++;
                    }
                }
            }
            $contentData['online_course'] = $running_classes ;
            $contentData['classes_info'] = $class_info ;
			$headerData['links'] = 'bootstrap-jquery-links';
			$contentData['admin'] = 'running_classes';
			$this->show_pages($title = 'کلاس های در حال اجرا', 'admin-content', $contentData, $headerData);
		}else
			redirect('error-403', 'refresh');
	}

    public function more_info(){
        $meetingID = $this->input->post('MID');
        $server = $this->input->post('server');
        $data = $this->online_class_info($server,$meetingID);
        $contentData['class_info'] = $data['attendees'];
        $headerData['links'] = 'bootstrap-jquery-links';
        $contentData['admin'] = 'online_classes_info';
        $this->show_pages($title = 'اطلاعات بیشتر کلاس ها', 'admin-content', $contentData, $headerData);
    }

    public function join_meeting($server_id, $meeting_id, $password ){

        $params = array(
            'meetingID'=> $meeting_id . '22',
            'password' => $password, #required
            'fullName' => 'POSHTIBANI',#required  - must be without space
        );

        if ($server_id == '1'){
            redirect($this->ci_bigblue->join_meeting($params));
        } elseif ($server_id == '2') {
            redirect($this->ci_bigblue2->join_meeting($params));
        }
    }

	public function class_duration(){


		sleep(3);

		$academyID = $this->session->userdata('academy_id');
		$lessonID = $this->session->userdata('courseID');
		$MID = array('meetingID' => $lessonID . '22');
		$isRunning = $this->ci_bigblue->meeting_status($MID);
		$partisipants = $this->ci_bigblue->meeting_info($MID);

		if (($this->session->userdata('ST'))){

			$startedTime = $this->session->userdata('ST');

			if (!($isRunning['running'] == true) || (intval($partisipants['participantCount']) == 0)){

				$total_AC_hour = $this->base->get_data('academys_option' , 'online_class_hours' ,array('academy_id'=>$academyID));
				$total_lesson_hour = $this->base->get_data('courses','onlineClassHour',array('course_id'=>$lessonID));
				$x = $total_AC_hour[0]->online_class_hours;
				$y = $total_lesson_hour[0]->onlineClassHour;
				$DU = time() - intval($startedTime);

				if (intval($DU) > 7200) {
				    $DU = 7200;
				}

				$DU /= 3600;

				$x = $DU + $x;
				$y = $DU + $y;
				$this->base->update('academys_option', array('academy_id'=>$academyID) , array('online_class_hours'=>$x));
				$this->base->update('courses', array('course_id'=>$lessonID) , array('onlineClassHour'=>$y));
				$params = array('meetingID' => $lessonID . '22' ,"password"=>"123456" ); #moderator password
				$this->ci_bigblue->meeting_end($params);
			}

		} else {

			$startedTime = $partisipants['createTime'];

			if (!($isRunning['running'] == true) || ($partisipants['participantCount'] == 0)) {

				$total_AC_hour = $this->base->get_data('academys_option', 'online_class_hours', array('academy_id' => $academyID));
				$total_lesson_hour = $this->base->get_data('courses', 'onlineClassHour', array('course_id' => $lessonID));
				$x = $total_AC_hour[0]->online_class_hours;
				$y = $total_lesson_hour[0]->onlineClassHour;
				$DU = time() - $startedTime;
				$x = $DU + $x;
				$y = $DU + $y;
				$this->base->update('academys_option', array('academy_id' => $academyID), array('online_class_hours' => $x));
				$this->base->update('courses', array('course_id' => $lessonID), array('onlineClassHour' => $y));
				$params = array('meetingID' => $lessonID . '22', "password" => "123456"); #moderator password
				$this->ci_bigblue->meeting_end($params);
			}
		}
		redirect('http://amoozkadeh.com/portal');
	}

	public function is_running($server_id, $meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == '1'){
			$isRunning = $this->ci_bigblue->meeting_status($MID);
		} elseif ($server_id == '2') {
			$isRunning = $this->ci_bigblue2->meeting_status($MID);
		}
		//var_dump($isRunning);
		return $isRunning['running'];
	}

	public function online_class_info($server_id, $meeting_id){
		$MID = array('meetingID' => $meeting_id . '22');
		if ($server_id == '1'){
			$partisipants = $this->ci_bigblue->meeting_info($MID);
		} elseif ($server_id == '2') {
			$partisipants = $this->ci_bigblue2->meeting_info($MID);
		}
		return $partisipants;
	}

	public function end_meeting($server_id, $meeting_id, $password){
		$params = array('meetingID' => $meeting_id . '22' ,"password"=>$password ); #moderator password
		$this->base->update('courses', array('course_id' => $meeting_id), array('using_server' => 0));
		$server = $this->base->get_data('servers', 'server_usage' , array('server_id' => $server_id));
		$this->base->update('servers', array('server_id' => $server_id), array('server_usage'=>intval($server[0]->server_usage) - 1));
		if ($server_id == '1'){
			$this->ci_bigblue->meeting_end($params);
		}elseif ($server_id == '2'){
			$this->ci_bigblue2->meeting_end($params);
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

    public function joinAdmin(){
        $classID = $this->input->post('MID');
        $server_id = $this->input->post('server');
        $academy_id = $this->input->post('academy_id');
        $password = '123456';
        $course_id = array(
            'meeting_id'=> $classID,
            'academy_id'=> $academy_id
        );
        $this->session->set_userdata($course_id);
        $this->join_meeting($server_id, $classID, $password);

    }

	public function ended_class(){
		$academyID = $this->session->userdata('academy_id');
		$meeting_id = $this->session->userdata('meeting_id');
		$server_id = $this->base->get_data('courses', 'using_server', array('course_id'=>$meeting_id));
		$password = '123456';

		sleep(3);

		if ($this->is_running($server_id[0]->using_server,$meeting_id) == 'true'){
			$count = $this->online_class_info($server_id[0]->using_server, $meeting_id);
			if (intval($count['participantCount']) == 0){
				$this->calculate_duration($academyID,$meeting_id);
				$this->end_meeting($server_id[0]->using_server,$meeting_id,$password);
			}
			redirect('http://amoozkadeh.com/portal');
		} else {
			$this->calculate_duration($academyID,$meeting_id);
			$this->end_meeting($server_id[0]->using_server,$meeting_id,$password);
			redirect('http://amoozkadeh.com/portal');
		}
	}

    public function turn_off_on(){

        $server_id = $this->input->post('server_id');
        $server = $this->base->get_data('servers', 'server_usage,isON', array('server_id' => $server_id));
        if ($server[0]->isON == '1'){
            if ($server[0]->server_usage == '0'){
                $this->base->update('servers', array('server_id' => $server_id), array('isON' => false));
            } else {
                $this->session->set_flashdata('fail', 'there is online class(es) running on this server');
            }
        } else {
            $this->base->update('servers', array('server_id' => $server_id), array('isON' => true));
        }

        redirect('/servers_info');

    }

    public function servers_info(){
        $servers = $this->base->get_data('servers', '*');
        $contentData['servers'] = $servers;
        $headerData['links'] = 'bootstrap-jquery-links';
        $contentData['admin'] = 'servers';
        $this->show_pages($title = 'اطلاعات بیشتر کلاس ها', 'admin-content', $contentData ,$headerData);
    }

    public function clear(){
	    $count_s1 = 0;
	    $count_s2 = 0;

        $classes = $this->base->get_data('courses', 'course_id,using_server,academy_id');
        for ($i = 0 ; $i < count($classes) ; $i++){
            if (intval($classes[$i]->using_server) != 0){
                $is_on = $this->base->get_data('servers','isON',array('server_id' => $classes[$i]->using_server));
                if ($classes[$i]->using_server == '1') {
                    $count_s1++;
                } elseif ($classes[$i]->using_server == '2') {
                    $count_s2++;
                }
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

        $this->base->update('servers', array('server_id' => '1'), array('server_usage' => $count_s1));
        $this->base->update('servers', array('server_id' => '2'), array('server_usage' => $count_s2));

        redirect('/servers_info');
    }

    public function pass(){

	    $manager = $this->base->get_data('academys_option' , 'national_code');
	    $teacher = $this->base->get_data('employers' , 'national_code');
	    $student = $this->base->get_data('students' , 'national_code');

        echo '<br>======================================================================================<br>';
	    for ($i = 0 ; $i < count($manager) ; $i++) {
	        $this->base->update('academys_option' , array('national_code' => $manager[$i]->national_code) , array('password' => sha1($manager[$i]->national_code)));
            echo $manager[$i]->national_code.'==>'.sha1($manager[$i]->national_code);
	    }
	    echo '<br>======================================================================================<br>';
	    for ($i = 0 ; $i < count($teacher) ; $i++) {
	        $this->base->update('employers' , array('national_code' => $teacher[$i]->national_code) , array('password' => sha1($teacher[$i]->national_code)));
            echo $teacher[$i]->national_code.'==>'.sha1($teacher[$i]->national_code);
        }
        echo '<br>======================================================================================<br>';
	    for ($i = 0 ; $i < count($student) ; $i++) {
	        $this->base->update('students' , array('national_code' => $student[$i]->national_code) , array('password' => sha1($student[$i]->national_code)));
            echo $student[$i]->national_code.'==>'.sha1($student[$i]->national_code);
	    }
        echo '<br>======================================================================================<br>';

    }

}
