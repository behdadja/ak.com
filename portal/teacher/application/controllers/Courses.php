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
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $this->load->library('calc');
            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
            $contentData['count_student_course'] = $this->get_join->get_data('courses', 'courses_students', 'courses_students.course_id=courses.course_id', null, null, array('courses.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
            $contentData['yield'] = 'my-courses';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('کل دوره های محوله', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function detail($courseid, $meeting) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $contentData['studentListOfCourse'] = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $courseid, 'students.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
            $contentData['courseid'] = $courseid;
            $contentData['meetingnumber'] = $meeting;
            $contentData['yield'] = 'list-of-students';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('لیست دانشجویان دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function list_of_courses() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['courses_list'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['yield'] = 'list-of-courses';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('دانشجو - ثبت نام در دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/courses/error-403', 'refresh');
        }
    }

    //**********
    public function list_of_meeting($courseid) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
//            if (!empty($this->input->get('courseid', true))) {
//                $courseid = $this->input->get('courseid', true);
//            } else {
//                $courseid = $this->input->post('course_id', true);
//            }
            $contentData['awareness_subject'] = $this->base->get_data('awareness_subject', '*', array('academy_id' => $academy_id));
            $contentData['courseofemployer'] = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('course_id' => $courseid, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
            $contentData['courseid'] = $courseid;
            $contentData['attendancelist'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id));
            $contentData['yield'] = 'list_of_meeting';
//            $headerData['links'] = 'data-table-links';
//            $footerData['scripts'] = 'data-table-scripts';
            $headerData['links'] = 'persian-calendar-links';
            $footerData['scripts'] = 'persian-calendar-scripts';
            $headerData['secondLinks'] = 'dropify-links';
            $footerData['secondScripts'] = 'dropify-scripts';
            $this->show_pages('مشاهده جلسات دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function ufile_awareness() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $title = $this->input->post('awareness_title', true);
            $course_id = $this->input->post('course_id', true);
            $meeting_number = $this->input->post('meeting_number', true);
            $lesson_name = $this->input->post('lesson_name', true);
            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_awr_name'] === '110') {
                $insArrayFile = array(
                    'academy_id' => $academy_id,
                    'awareness_subject_title' => $title,
                    'file_name' => $resultOfUploadFile['final_awr_name'],
                    'course_id' => $course_id,
                    'employee_nc' => $sessId,
                    'meeting_number' => $meeting_number
                );
                $this->base->insert('awareness_subject', $insArrayFile);
                $this->session->set_userdata($insArrayFile);
                $this->session->set_flashdata('insert-success', 'مطلب آموزشی با موفقیت ارسال گردید.');
                redirect('teacher/courses/list_of_meeting/' . $course_id, 'refresh');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل پیوست با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('teacher/courses/list_of_meeting/' . $course_id, 'refresh');
            }
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    private function my_upload() {
        $this->load->library('upload');
        $academy_id = $this->session->userdata('academy_id');
        $course_id = $this->session->userdata('course_id');
        $config_array = array(
            'upload_path' => './../assets/awareness',
            'allowed_types' => 'pdf|mp4|doc|docx|xlsx|xls|txt|jpg|jpeg|png',
            'max_size' => 153600,
            'file_name' => time().rand(1000, 9999)
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('awareness_file')) {
            $awr_info = $this->upload->data();
            $awr_name = $awr_info['file_name'];
            $result_awr_name = '110';
            $final_awr_name = $awr_name;
        } else {
            $result_awr_name = '404';
            $final_awr_name = 'user-default.jpg';
        }
        $result = array(
            'img_name' => $result_awr_name,
            'final_awr_name' => $final_awr_name,
            'result_awr_name' => $result_awr_name
        );
        return $result;
    }

    public function delete_file($courseid, $id) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $file = $this->base->get_data('awareness_subject', 'file_name', array('awareness_subject_id' => $id, 'academy_id' => $academy_id));
            foreach ($file as $more):
                unlink('./../assets/awareness/' . $more->file_name);
            endforeach;
            $this->base->delete_data('awareness_subject', array('awareness_subject_id' => $id, 'academy_id' => $academy_id));
            $this->session->set_flashdata('delete_file', 'فایل مورد نظر با موفقیت حذف شد.');
            redirect('teacher/courses/list_of_meeting/' . $courseid, 'refresh');
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function insert_new_meeting($courseid, $meeting) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            //         $courseid1 = $this->input->post('courseid', true);
//            $meeting = $this->input->post('meeting', true);
            $courses = $this->base->get_data('courses', '*', array('course_id' => $courseid, 'academy_id' => $academy_id));
            $meeting_number = $meeting + 1;
            (int) $time_meeting = (int) $courses[0]->time_meeting;
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $insert_array = array(
                'academy_id' => $academy_id,
                'employer_nc' => $sessId,
                'course_id' => $courseid,
                'meeting_number' => $meeting_number,
                'time_meeting' => (int) $time_meeting,
                'date' => $date
            );
            $time_total = $courses[0]->time_total;
            $sum_time = array(
                'time_total' => (int) $time_meeting + $time_total
            );
            $cours_amount = $courses[0]->course_tuition;
            if ($courses[0]->type_course === '0') {
                // emp
                if ($courses[0]->type_pay === '1') {
                    $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                    // update financial_amount (employer) in table financial_situation_employer
                    $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                    $financial_situation_update = array(
                        'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                        'final_situation' => 1
                    );
                    $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                    // end
                    // update course_amount in table courses_employers
                    $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                    $courses_employers_update = array(
                        'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                    );
                    $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                    // end
                }
            } elseif ($courses[0]->type_course === '1') {
                // emp
                if ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === null) {
                    // emp
                    $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                    // update financial_amount (employer) in table financial_situation_employer
                    $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                    $financial_situation_update = array(
                        'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                        'final_situation' => 1
                    );
                    $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                    // end
                    // update course_amount in table courses_employers
                    $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                    $courses_employers_update = array(
                        'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                    );
                    $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                    // end
                } elseif ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '1') {
                    // emp
                    $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                    // update financial_amount (employer) in table financial_situation_employer
                    $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                    $financial_situation_update = array(
                        'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                        'final_situation' => 1
                    );
                    $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                    // end
                    // update course_amount in table courses_employers
                    $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                    $courses_employers_update = array(
                        'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                    );
                    $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                    // end
                } elseif ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '0') {
                    // std
                    $amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
                    // update financial_amount (student) in table financial_situation_employer
                    $financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
                    foreach ($financial_state as $financial_situation) {
                        if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
                            $amount_update = array(
                                'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
                                'final_situation' => -1
                            );
                        } else {
                            if ((int) $cours_amount > (int) $financial_situation->final_amount) {
                                $amount_update = array(
                                    'final_amount' => (int) $amount_std - (int) $financial_situation->final_amount,
                                    'final_situation' => -1
                                );
                            } elseif ((int) $amount_std === (int) $financial_situation->final_amount) {
                                $amount_update = array(
                                    'final_amount' => 0,
                                    'final_situation' => 0
                                );
                            } else {
                                $amount_update = array(
                                    'final_amount' => (int) $financial_situation->final_amount - (int) $amount_std,
                                    'final_situation' => 1
                                );
                            }
                        }
                        $this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
                        $course_cost = $financial_situation->course_cost + $courses[0]->course_tuition;
                        $this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
                    }
                    // end update financial_amount (student)
                    // emp
                    $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                    // update financial_amount (employer) in table financial_situation_employer
                    $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                    $financial_situation_update = array(
                        'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                        'final_situation' => 1
                    );
                    $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                    // end
                    // update course_amount in table courses_employers
                    $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                    $courses_employers_update = array(
                        'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                    );
                    $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                    // end
                } elseif ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '0') {
                    // std
                    $amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
                    // update financial_amount (student) in table financial_situation_employer
                    $financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
                    foreach ($financial_state as $financial_situation) {
                        if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
                            $amount_update = array(
                                'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
                                'final_situation' => -1
                            );
                        } else {
                            if ((int) $cours_amount > (int) $financial_situation->final_amount) {
                                $amount_update = array(
                                    'final_amount' => (int) $amount_std - (int) $financial_situation->final_amount,
                                    'final_situation' => -1
                                );
                            } elseif ((int) $amount_std === (int) $financial_situation->final_amount) {
                                $amount_update = array(
                                    'final_amount' => 0,
                                    'final_situation' => 0
                                );
                            } else {
                                $amount_update = array(
                                    'final_amount' => (int) $financial_situation->final_amount - (int) $amount_std,
                                    'final_situation' => 1
                                );
                            }
                        }
                        $this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
                        $course_cost = $financial_situation->course_cost + $courses[0]->course_tuition;
                        $this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
                    }
                    // end update financial_amount (student)
                    // emp
                    $amount_emp = (($amount_std * $courses[0]->count_std) * $courses[0]->value_pay) / 100;
                    // update financial_amount (employer) in table financial_situation_employer
                    $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                    $financial_situation_update = array(
                        'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                        'final_situation' => 1
                    );
                    $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                    // end
                    // update course_amount in table courses_employers
                    $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                    $courses_employers_update = array(
                        'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                    );
                    $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                    // end
                }
            }
            $this->base->update('courses', array('course_id' => $courseid, 'academy_id' => $academy_id), $sum_time);
            $this->base->insert('attendance', $insert_array);
            redirect('teacher/courses/list_of_meeting/' . $courseid, 'refresh');
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function students_of_course($courseid, $meeting) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['studentListOfCourse'] = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $courseid, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            $contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $courseid, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['count_absence'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id, 'meeting_number_std !=' => null));
            $contentData['absence_status'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id, 'meeting_number_std !=' => null, 'meeting_number_std' => $meeting));
            $contentData['courseid'] = $courseid;
            $contentData['meeting'] = $meeting;
            $contentData['yield'] = 'list-of-students';
            $headerData['Links'] = 'persian-calendar-links';
            $footerData['Scripts'] = 'persian-calendar-scripts';
            $this->show_pages('لیست دانشجویان دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function insert_attendance($courseid, $meeting, $student_nc) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $insert_array = array(
                'academy_id' => $academy_id,
                'employer_nc' => $sessId,
                'course_id' => $courseid,
                'meeting_number_std' => $meeting,
                'student_nc' => $student_nc
            );
            $this->base->insert('attendance', $insert_array);
            $this->students_of_course($courseid, $meeting);
        } else {
            redirect('teacher/courses/error-403', 'refresh');
        }
    }

    public function save() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $student_nc = $this->input->post('student_nc', true);
            $meeting = $this->input->post('meeting', true);
            $courseid = $this->input->post('course_id', true);
            $conditions = $this->input->post('conditions', true);

//            چاپ آرایه:
//            echo $dataJson = $this->input->post('my_data');
//            $dataArray = json_decode(htmlspecialchars_decode($dataJson), true);

            if ($conditions === '1'):
                $this->base->delete_data('attendance', array('student_nc' => $student_nc, 'course_id' => $courseid, 'academy_id' => $academy_id));
            elseif ($conditions === '0'):

                require_once 'jdf.php';
                $date = jdate('H:i:s - Y/n/j');
                $my_array['date'] = $date;
                $my_array['academy_id'] = $academy_id;
                $my_array['type_attendance'] = '1';
                $my_array['student_nc'] = $student_nc;
                $my_array['employer_nc'] = $sessId;
                $my_array['meeting_number_std'] = $meeting;
                $my_array['course_id'] = $courseid;

                $this->base->insert('attendance', $my_array);
            endif;
//            $this->students_of_course($courseid, $meeting);
            redirect('teacher/courses/students_of_course/' . $courseid . '/' . $meeting, 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

}
