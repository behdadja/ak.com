<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financialem extends CI_Controller {

    private $encryptionKey = 'wNx6fCLiIHd06AUWxTOqyuxcdA9mzgaV';

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->library('user_agent');
        $this->encryption->initialize(
                array(
                    'cipher' => 'AES-256',
                    'mode' => 'CTR',
                    'key' => $this->encryptionKey,
                    'driver' => 'openssl'
                )
        );
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان استاد وارد شوید.');
        $this->load->view('teacher/financialem/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }
    
    public function financial_situation() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            
            $academy_id = $this->session->userdata('academy_id');
            if ($this->exist->exist_entry('employers', array('national_code' => $sessId, 'academy_id' => $academy_id))) {
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'financial-data-table-scripts';
                $contentData['yield'] = 'employer-inquiry';
                $contentData['employers'] = $this->base->get_data('employers', '*', array('national_code' => $sessId, 'academy_id' => $academy_id));
                $contentData['courses'] = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'courses_employers', 'courses.course_id=courses_employers.course_id', array('employee_nc' => $sessId, 'course_status != ' => 0, 'courses_employers.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
                $contentData['financial_state'] = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
                $contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
                $contentData['course_cash'] = $this->base->get_data('course_cash_pay', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
                $contentData['course_check'] = $this->base->get_data('course_check_pay', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
                $this->show_pages('استاد - وضعیت مالی', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('teacher/financialem/error-403', 'refresh');
        }
    }

//    public function finst_inquiry() {
//        $sessId = $this->session->userdata('session_id');
//        $userType = $this->session->userdata('user_type');
//        if (!empty($sessId) && $userType === 'teachers') {
//            
//            $academy_id = $this->session->userdata('academy_id');
//            $headerData['links'] = 'data-table-links';
//            $footerData['scripts'] = 'financial-data-table-scripts';
//            $contentData['yield'] = 'financialst-inquiry';
////            $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $sessId));
//            $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array('student_nc' => $sessId));
//            $contentData['transactions'] = $this->base->get_data('transactions_students', '*', array('student_nc' => $sessId));
//            $contentData['courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $sessId));
//            $contentData['exams'] = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $sessId));
//            $contentData['exam_pouse'] = $this->base->get_data('exam_pouse_pay', '*', array('student_nc' => $sessId));
//            $contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('student_nc' => $sessId));
//            // print_r($contentData['course_pouse']);
//            $this->show_pages('دانشجو - وضعیت مالی', 'content', $contentData, $headerData, $footerData);
//        } else {
//            redirect('student/financialst/error-403', 'refresh');
//        }
//    }

}
