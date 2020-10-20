<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('student/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function my_courses() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['courses'] = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $sessId, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
            $contentData['attendancelist'] = $this->get_join->get_data('attendance', 'courses', 'courses.course_id=attendance.course_id', null, null, array('attendance.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
            $contentData['count_absence'] = $this->base->get_data('attendance', '*', array('academy_id' => $academy_id));
            $contentData['awareness_subject'] = $this->base->get_data('awareness_subject', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'my-courses';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('دانشجو - دوره های من', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/courses/error-403', 'refresh');
        }
    }

    public function list_of_courses() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['courses_list'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
            $contentData['yield'] = 'list-of-courses';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('دانشجو - ثبت نام در دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/courses/error-403', 'refresh');
        }
    }

    public function enroll_course() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $national_code = $this->session->userdata('session_id');
            $course_id = $this->input->post('course_code', true);
            $lesson_id = $this->input->post('lesson_id', true);
            $course_cost = $this->input->post('course_cost', true);
            $insert_array = array(
                 'academy_id' => $academy_id,
                'course_id' => $course_id,
                'student_nc' => $national_code,
                'lesson_id' => $lesson_id,
                'course_cost' => $course_cost
            );
            if ($this->exist->isExistCoursesEnroll($national_code, $course_id, $academy_id)) {
                $this->session->set_flashdata('enroll-e', 'شما قبلا در این دوره ثبت نام شده اید.');
                redirect('student/courses/list-of-courses', 'refresh');
            } else {
                $cours_query = $this->get_join->getAmountOfCourse($course_id);
                $cours_amount = $cours_query[0]->course_tuition;
                $count_std = array(
                    'count_std' => $cours_query[0]->count_std + 1
                );
                $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id'=> $academy_id));
                if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === -1) {
                    $amount_update = array(
                        'final_amount' => (int) $financial_situation[0]->final_amount + (int) $cours_amount,
                        'final_situation' => -1
                    );
                } else {
                    if ((int) $cours_amount > (int) $financial_situation[0]->final_amount) {
                        $amount_update = array(
                            'final_amount' => (int) $cours_amount - (int) $financial_situation[0]->final_amount,
                            'final_situation' => -1
                        );
                    } elseif ((int) $cours_amount === (int) $financial_situation[0]->final_amount) {
                        $amount_update = array(
                            'final_amount' => 0,
                            'final_situation' => 0
                        );
                    } else {
                        $amount_update = array(
                            'final_amount' => (int) $financial_situation[0]->final_amount - (int) $cours_amount,
                            'final_situation' => 1
                        );
                    }
                }
                $this->base->update('students', array('national_code' => $national_code, 'academy_id'=> $academy_id), array('student_status' => 1));
                $this->base->update('courses', array('course_id' => $course_id, 'academy_id'=> $academy_id), $count_std);
                $this->base->update('financial_situation', array('student_nc' => $national_code, 'academy_id'=> $academy_id), $amount_update);
                $this->base->insert('courses_students', $insert_array);
                $this->session->set_flashdata('enroll', 'ثبت نام با موفقیت انجام شد.');
                redirect('student/courses/my-courses', 'refresh');
            }
        } else {
            redirect('student/courses/error-403', 'refresh');
        }
    }

}
