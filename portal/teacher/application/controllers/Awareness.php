<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Awareness extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('teacher/awareness/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function courses_to_send_ufile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');

            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['attendance'] = $this->base->get_data('attendance', '*');
            $contentData['yield'] = 'existing-courses';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $headerData['secondLinks'] = 'dropify-links';
            $footerData['secondScripts'] = 'dropify-scripts';
            $this->show_pages('دوره های موجود', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/awareness/error-403', 'refresh');
        }
    }

//    public function ufile_awareness() {
//        $sessId = $this->session->userdata('session_id');
//        $userType = $this->session->userdata('user_type');
//        if (!empty($sessId) && $userType === 'teachers') {
//
//            $academy_id = $this->session->userdata('academy_id');
//            $title = $this->input->post('awareness_title', true);
//            $course_id = $this->input->post('course_id', true);
//            $meeting_number = $this->input->post('meeting_number', true);
//            $resultOfUploadFile = $this->my_upload($_FILES);
//
//            if ($resultOfUploadFile['result_awr_name'] === '110') {
//                $insArrayFile = array(
//                    'academy_id' => $academy_id,
//                    'awareness_subject_title' => $title,
//                    'file_name' => $resultOfUploadFile['final_awr_name'],
//                    'meeting_number' => $meeting_number,
//                    'course_id' => $course_id,
//                    'employee_nc' => $sessId
//                );
//                $this->base->insert('awareness_subject', $insArrayFile);
//                $this->session->set_flashdata('insert-success', 'مطلب آموزشی با موفقیت ارسال گردید.');
//                redirect('teacher/awareness/existing-courses', 'refresh');
//            } else {
//                $this->session->set_flashdata('error-upload', 'بارگزاری فایل پیوست با مشکل مواجه شد لطفا مجددا تلاش نمایید');
//                redirect('teacher/awareness/existing-courses', 'refresh');
//            }
//        } else {
//            redirect('teacher/awareness/error-403', 'refresh');
//        }
//    }
//
//    private function my_upload() {
//        $this->load->library('upload');
//        $config_array = array(
//            'upload_path' => './../assets/awareness',
//            'allowed_types' => 'zip|rar',
//            'max_size' => 153600,
//            'file_name' => time()
//        );
//        $this->upload->initialize($config_array);
//
//        if ($this->upload->do_upload('awareness_file')) {
//            $awr_info = $this->upload->data();
//            $awr_name = $awr_info['file_name'];
//            $result_awr_name = '110';
//            $final_awr_name = $awr_name;
//        } else {
//            $result_awr_name = '404';
//            $final_awr_name = 'user-default.jpg';
//        }
//        $result = array(
//            'img_name' => $result_awr_name,
//            'final_awr_name' => $final_awr_name,
//            'result_awr_name' => $result_awr_name
//        );
//        return $result;
//    }


}
