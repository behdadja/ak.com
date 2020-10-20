<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
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
    
    //////////////////////////////////////////    test    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function show_database() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $contentData['courses'] = $this->base->get_data('courses', '*');
            $contentData['courses_students'] = $this->base->get_data('courses_students', '*');
            $contentData['students'] = $this->base->get_data('students', '*');
            $contentData['employers'] = $this->base->get_data('employers', '*');
            $contentData['yield'] = 'test';
            $headerData['Links'] = 'persian-calendar-links';
            $footerData['Scripts'] = 'persian-calendar-scripts';
            $this->show_pages('database', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_course($course_id){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('courses',array('course_id' => $course_id));
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_all_courses(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('courses', '*');
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_student($student_id){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('students',array('student_id' => $student_id));
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_all_students(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('students', '*');
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_employer($employee_id){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('employers',array('employee_id' => $employee_id));
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_all_employers(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('employers', '*');
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_course_student($course_student_id){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $this->base->delete_data('courses_students',array('course_student_id' => $course_student_id));
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
    public function delete_all_courses_students(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'admin') {
            $academy_id = $this->session->userdata('academy_id');
            $this->base->delete_data('courses_students', '*');
            redirect('database/show_database', 'refresh');
        }else {
            redirect('database/error-403', 'refresh');
        }
    }
}

