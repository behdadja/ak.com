<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'این صفحه وجود ندارد');
        $this->load->view('errors/403');
    }

//    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
//        $headerData['title'] = $title;
//        $this->load->view('templates/header', $headerData);
//        $this->load->view('pages/' . $path, $contentData);
//        $this->load->view('templates/footer', $footerData);
//    }
//
//    public function show_index() {
//        $contentData['academys'] = $this->base->get_data('academys_option', '*', null, '4');
//        $contentData['course_academy'] = $this->base->get_data('academys_option', '*');
//        $contentData['courses'] = $this->base->get_triple4('*', 'courses', 'lessons', 'courses_employers', 'employers', 'courses.lesson_id=lessons.lesson_id', 'courses.course_id=courses_employers.course_id', 'courses_employers.employee_id=employers.employee_id',null, 'courses.course_id', '8');
//        $contentData['yield'] = 'dashboard';
//        $this->show_pages($title='amoozkadeh |آموزکده | سامانه مديريت آموزشگاه ها', 'content', $contentData);
//    }

}
