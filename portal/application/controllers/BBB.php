<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BBB extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('CI_Bigblue');
		$this->load->library('CI_Bigblue2');
		$this->load->library('encryption');
	}

	public function error_403() {
		$this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
		$this->load->view('errors/403');
	}
	
	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}

    public function more_info(){
        $meetingID = $this->input->post('MID');
        $server = $this->input->post('server');
        $data = $this->online_class_info($server,$meetingID);
        $contentData['class_info'] = $data['attendees'];
        //var_dump($data['attendees']);
        //$headerData['links'] = 'bootstrap-jquery-links';
        $contentData['yield'] = 'online_classes_info';
        $this->show_pages($title = 'اطلاعات بیشتر کلاس ها', 'content', $contentData );
    }

    public function running_classes(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        $academy_id = $this->session->userdata('academy_id');
        if (!empty($sessId) && $userType === 'managers') {
            $data =  $this->get_join->get_data4('courses' , 'academys_option' , 'courses.academy_id=academys_option.academy_id' , 'employers' , 'courses.course_master=employers.national_code' , 'lessons' , 'courses.lesson_id=lessons.lesson_id', array('courses.academy_id'=>$academy_id), array('academys_option.academy_id'=>$academy_id));
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
            $contentData['yield'] = 'running_online_classes';
            $this->show_pages($title = 'کلاس های در حال اجرا', 'content', $contentData);
        }else
            redirect('BBB/error-403', 'refresh');
    }

    public function join_meeting($server_id, $meeting_id, $password ,$fullName){

        $params = array(
            'meetingID'=> $meeting_id . '22',
            'password' => $password, #required
            'fullName' => str_replace(' ', '_',$fullName),#required  - must be without space
        );

        if ($server_id == '1'){
            redirect($this->ci_bigblue->join_meeting($params));
        } elseif ($server_id == '2') {
            redirect($this->ci_bigblue2->join_meeting($params));
        }
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

    public function joinManager(){

        $sessId = $this->session->userdata('session_id');
        $academy_id = $this->input->post('academy_id');
        $classID = $this->input->post('MID');
        $manager = $this->base->get_data('academys_option', 'full_name_en', array('national_code' => $sessId, 'academy_id' => $academy_id));
        $server_id = $this->input->post('server');
        $fullName = $manager[0]->full_name_en;
        $password = '123456';

        if ($this->is_running($server_id, $classID) == 'true') {
            $course_id = array(
                'meeting_id'=> $classID ,
            );
            $this->session->set_userdata($course_id);
            $this->join_meeting($server_id, $classID, $password, $fullName);
        } else {
            $this->session->set_flashdata('fail');
            redirect('profile');
        }

    }


}
