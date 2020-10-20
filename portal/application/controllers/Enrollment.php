<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->library('calc');
        $this->load->model('update');
    }

    public function index() {
        
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

    public function registration_course() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['courses_list'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', array('course_status !=' => 2, 'courses.academy_id' => $academy_id, 'employers.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
//            echo json_encode($courses_list);
            $contentData['yield'] = 'list-of-courses';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('ثبت نام در دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function course($courseCode) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['students_info'] = $this->base->get_data('students', '*', array('student_activated' => '1', 'academy_id' => $academy_id));
            $contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $courseCode, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['course_code'] = $courseCode;
            $contentData['yield'] = 'student-list-for-enroll-course';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('ثبت نام دانشجو', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function enroll_course() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            $course_id = $this->input->post('course_id', true);

            if ($this->exist->isExistCoursesEnroll($national_code, $course_id, $academy_id)) {
                $this->session->set_flashdata('enroll-exist', 'دانشجوی مورد نظر قبلا در این دوره ثبت نام شده است.');
                redirect('training/manage-courses', 'refresh');
            } else {
                $courses = $this->base->get_data('courses', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));

                $insert_array['academy_id'] = $academy_id;
                $insert_array['course_id'] = $course_id;
                $insert_array['lesson_id'] = $courses[0]->lesson_id;
                $insert_array['student_nc'] = $national_code;
                if ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '0') {
                    $insert_array['course_cost'] = (int) 0;
                } else {
                    $insert_array['course_cost'] = $courses[0]->course_tuition;
                }

                if ($courses[0]->type_course === '0') {
                    if ($courses[0]->type_pay === '0') {
                        $amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
                        // update financial_amount (employer) in table financial_situation_employer
                        $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                        $financial_situation_update = array(
                            'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
                            'final_situation' => 1
                        );
                        $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                        // end
                        // update course_amount in table courses_employers
                        $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                        $courses_employers_update = array(
                            'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
                        );
                        $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                        // end
                    }
                } elseif ($courses[0]->type_course === '1') {
                    if ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '1') {
                        $amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
                        // update financial_amount (employer) in table financial_situation_employer
                        $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                        $financial_situation_update = array(
                            'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
                            'final_situation' => 1
                        );
                        $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                        // end
                        // update course_amount in table courses_employers
                        $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
                        $courses_employers_update = array(
                            'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
                        );
                        $this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
                        // end
                    }
                }
                // update count_std in table courses
                $cours_amount = $courses[0]->course_tuition;
                $count_std = array(
                    'count_std' => $courses[0]->count_std + 1
                );
                // end update count_std

                if ($courses[0]->type_course === '0' || ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '1')) {
                    // std
                    $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
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
                    $this->base->update('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id), $amount_update);
                    // end std
                } 
//               
                /////////////////پیامک\\\\\\\\\\\\\\\
                $lesson_name = $this->input->post('lesson_name', true);
                $phone_num = $this->input->post('phone_num', true);
                $full_name = $this->input->post('full_name', true);
                $studentDName2 = $this->session->userdata('studentDName2');

                $name = $studentDName2 . " گرامی " . $full_name;
                $this->smsForCourseRegistration($phone_num, $name, $lesson_name);

                $message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
                $insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

                $this->base->insert('manager_student_sms', $insertArray);
                /////////////////پیامک////////////////

                $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
                $this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

                $this->base->insert('courses_students', $insert_array);
                $this->session->set_flashdata('enroll-new', 'ثبت نام با موفقیت انجام شد.');
                $this->session->set_userdata(array('national_code' => $national_code));
                $this->session->set_userdata(array('course_id' => $course_id));

                redirect('https://amoozkadeh.com/add_std_manager');
            }
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function smsForCourseRegistration($phone_num, $name, $course) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_name = $this->session->userdata('academy_name');
            $academyDName = $this->session->userdata('academyDName');
            $academy = $academyDName . " " . $academy_name;

            $username = "mehritc";
            $password = '@utabpars1219';
            $from = "+983000505";
            $pattern_code = "o6m2t2ijji";
            $to = array($phone_num);
            $input_data = array(
                "name" => "$name",
                "cource" => "$course",
                "academy" => "$academy"
            );
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $verify_code = curl_exec($handler);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function registration_course_list() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['courses_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('courses.academy_id' => $academy_id, 'employers.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['count_student_course'] = $this->get_join->get_data('courses', 'courses_students', 'courses_students.course_id=courses.course_id', null, null, array('courses.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
            $contentData['yield'] = 'list-of-enrolled-courses';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages(' دوره ها', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function registration_of_course($course_id) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
//            $course_id = $this->input->post('course_id', true);
            $contentData['studentListOfCourse'] = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
			$contentData['course'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('courses.course_id' => $course_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['yield'] = 'students_of_course';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('ثبت نامی های دوره', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function registration_of_access(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id', true);
			$course_id = $this->input->post('course_id', true);
			$course_student_id = $this->input->post('course_student_id', true);
			$courses_students = $this->base->get_data('courses_students', 'reg_site', array('course_student_id'=>$course_student_id));
			if($courses_students[0]->reg_site == '1'){
				$update_data = array('reg_site'=> '2');
			}if($courses_students[0]->reg_site == '2'){
				$update_data = array('reg_site'=> '1');
			}
			$this->base->update('courses_students', array('course_student_id'=>$course_student_id, 'academy_id'=>$academy_id), $update_data);
			redirect('enrollment/registration-of-course/'.$course_id);
		} else {
			redirect('enrollment/error-403', 'refresh');
		}
	}

    public function delete_course_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $course_student_code = $this->input->post('course_student_code', true);
            $national_code = $this->input->post('national_code', true);
            $this->base->delete_data('courses_students', array('course_student_id' => $course_student_code, 'student_nc' => $national_code, 'academy_id' => $academy_id));
            $this->session->set_flashdata('del-exist-course', 'ثبت نام در دوره مورد نظر حذف گردید.');
            redirect('enrollment/registration-course-list', 'refresh');
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function before_reg_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['yield'] = 'get-student-nc';
            $this->show_pages('ثبت نام در آزمون', 'content', $contentData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function registration_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['exams_list'] = $this->get_join->get_data('exams', 'courses', 'exams.course_id=courses.course_id', null, null, array('exams.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
            foreach ($contentData['exams_list'] as $exam) {
                $exam->start_date = $this->calc->gregorian_to_jalali($exam->start_date);
            }
            $contentData['yield'] = 'list-of-exams';
            $headerData['secondLinks'] = 'small-modal-links';
            $footerData['secondScripts'] = 'small-modal-scripts';
            $this->show_pages('ثبت نام در آزمون', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function exam($courseCode, $examCode) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['students_info'] = $this->base->get_data('students', '*', array('student_activated' => '1', 'academy_id' => $academy_id));
            $contentData['exam_info'] = $this->get_join->get_data('exams', 'courses', 'exams.course_id=courses.course_id', null, null, array('exam_id' => $examCode, 'exams.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
            $contentData['course_code'] = $courseCode;
            $contentData['exam_code'] = $examCode;
            $contentData['yield'] = 'student-list-for-enroll-exam';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $footerData['secondScripts'] = 'small-modal-scripts';
            $this->show_pages('ثبت نام دانشجو در آزمون', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function enroll_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            $exam_id = $this->input->post('exam_code', true);
            $course_id = $this->input->post('course_code', true);

            if ($this->exist->isExistCoursesEnroll($national_code, $exam_id, $academy_id)) {
                if ($this->exist->isExistExamsEnroll($national_code, $exam_id, $academy_id)) {
                    $existed_exam = $this->exist->getExistExamEnroll($national_code, $course_id, $academy_id);
                    $existed_exam[0]->number_of_exam += 1;
                    $this->base->update('exams_students', array('exam_id' => $existed_exam[0]->exam_id, 'academy_id' => $academy_id), $existed_exam[0]);
                    $this->session->set_flashdata('enroll-exist', 'ثبت نام مجدد با موفقیت انجام شده.');
                    redirect('enrollment/registration-exam', 'refresh');
                } else {
                    $insert_array = array(
                        'academy_id' => $academy_id,
                        'exam_id' => $exam_id,
                        'course_id' => $course_id,
                        'student_nc' => $national_code,
                        'number_of_exam' => 1
                    );
                    $this->base->insert('exams_students', $insert_array);
                    $this->session->set_flashdata('enroll-exist', 'ثبت نام با موفقیت انجام شد.');
                    redirect('enrollment/registration-exam', 'refresh');
                }
            } else {
                $this->session->set_flashdata('enroll-exist-exam', 'لطفا ابتدا دانجشو را در دوره مورد نظر ثبت نام نمایید.');
                redirect('enrollment/registration-exam', 'refresh');
            }
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function registration_exam_list() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['enrolled_exams'] = $this->get_join->get_data4('exams_students', 'courses', 'exams_students.exam_id=courses.course_id', 'students', 'exams_students.student_nc=students.national_code', 'exams', 'exams_students.exam_id=exams.exam_id', array('exams_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id, 'exams.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
//            foreach ($contentData['enrolled_exams'] as $enrolled) {
//                $enrolled->exam_date = $this->calc->gregorian_to_jalali($enrolled->exam_date);
//            }
            $contentData['yield'] = 'list-of-enrolled-exams';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('ثبت نامی های آزمون ها', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function delete_exam_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $exam_student_code = $this->input->post('exam_student_code', true);
            $national_code = $this->input->post('national_code', true);
            $this->base->delete_data('exams_students', array('exam_student_id' => $exam_student_code, 'student_nc' => $national_code, 'academy_id' => $academy_id));
            $this->session->set_flashdata('del-exist-exam', 'ثبت نام جهت آزمون مورد نظر حذف گردید.');
            redirect('enrollment/registration-exam-list', 'refresh');
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function create_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['yield'] = 'creat-exam-page';
            $this->show_pages('ثبت آزمون جدید', 'content', $contentData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function all_of_exams() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $exams_type_info = $this->base->get_data('exams', '*', array('academy_id' => $academy_id));
            $contentData['exams_type_info'] = $exams_type_info;
            $contentData['yield'] = 'all-exams-type';
            $this->show_pages('آزمون های موجود', 'content', $contentData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function edit_exam_type() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $exam_id = $this->input->post('exam_id', true);
            $exam_type_info = $this->base->get_data('exams', '*', array('exam_id' => $exam_id, 'academy_id' => $academy_id));
            $contentData['exam_type_info'] = $exam_type_info;
            $contentData['yield'] = 'edit-exams-type';
            $this->show_pages('ویرایش آزمون', 'content', $contentData);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function update_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $exam_id = $this->input->post('exam_id', true);
            $exam_tuition = $this->input->post('exam_tuition', true);
            $uData = array(
                'exam_cost' => $exam_tuition
            );
            $exam_type_info = $this->base->update('exams', array('exam_id' => $exam_id, 'academy_id' => $academy_id), $uData);
            $this->session->set_flashdata('success-insert', 'هزینه با موفقیت تغییر کرد.');
            redirect('enrollment/all-of-exams', 'refresh');
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function insert_new_exam() {
        $this->form_validation->set_rules('exam_type', 'نوع آزمون', 'required');
        $this->form_validation->set_rules('exam_tuition', 'هزینه آزمون', 'required|numeric|max_length[20]');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s معتبر نیست');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id', true);
            $exam_type = $this->input->post('exam_type', true);
            $exam_tuition = $this->input->post('exam_tuition', true);
            $insert_array = array(
                'academy_id' => $academy_id,
                'exam_type' => $exam_type,
                'exam_cost' => $exam_tuition
            );
            $this->base->insert('exams', $insert_array);
            $this->session->set_flashdata('success-insert', 'ثبت آزمون جدید با موفقیت انجام شد.');
            redirect('enrollment/create-exam', 'refresh');
        } else {
            $this->create_exam();
        }
    }

    public function search_student_info() {
        $this->form_validation->set_rules('student_nc', 'کد ملی دانشجو', 'required|exact_length[10]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id', true);
            $student_nc = $this->input->post('student_nc', true);
            if ($this->exist->exist_entry('students', array('national_code' => $student_nc, 'academy_id' => $academy_id))) {
                $this->show_student_courses($student_nc);
            } else {
                $this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
                $this->before_reg_exam();
            }
        } else {
            $this->before_reg_exam();
        }
    }

    private function show_student_courses($student_nc) {
        $academy_id = $this->session->userdata('academy_id', true);
        $contentData['student_courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', null, null, array('student_nc' => $student_nc, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
        $contentData['student_info'] = $this->get_join->getMiniInfoOfStudent($student_nc, $academy_id);
        $contentData['exams'] = $this->base->get_data('exams', '*', array('academy_id' => $academy_id));
        $contentData['yield'] = 'student-course-list-for-exam';
        $headerData['links'] = 'data-table-links';
        $headerData['secondLinks'] = 'persian-calendar-links';
        $footerData['scripts'] = 'data-table-scripts';
        $footerData['secondScripts'] = 'persian-calendar-scripts';
        $this->show_pages('اطلاعات کلاس ها و دوره های دانشجو', 'content', $contentData, $headerData, $footerData);
    }

    private function insert_exam_cost($student_nc, $exam_id) {
        $academy_id = $this->session->userdata('academy_id', true);
        $exam_query = $this->get_join->getAmountOfExam($exam_id, $academy_id);
        $exam_cost = $exam_query[0]->exam_cost;
        $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
        if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === -1) {
            $amount_update = array(
                'final_amount' => (int) $financial_situation[0]->final_amount + (int) $exam_cost,
                'final_situation' => -1
            );
        } else {
            if ((int) $exam_cost > (int) $financial_situation[0]->final_amount) {
                $amount_update = array(
                    'final_amount' => (int) $exam_cost - (int) $financial_situation[0]->final_amount,
                    'final_situation' => -1
                );
            } elseif ((int) $exam_cost === (int) $financial_situation[0]->final_amount) {
                $amount_update = array(
                    'final_amount' => 0,
                    'final_situation' => 0
                );
            } else {
                $amount_update = array(
                    'final_amount' => (int) $financial_situation[0]->final_amount - (int) $exam_cost,
                    'final_situation' => 1
                );
            }
        }
        $this->base->update('financial_situation', array('student_nc' => $student_nc, 'academy_id' => $academy_id), $amount_update);
    }

    public function student_enroll_in_exam() {

        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $course_id = $this->input->post('course_id', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $exam_stage = $this->input->post('exam_stage', true);
            $exam_stage_p = $this->input->post('exam_stage_p', true);
            $exam_date = $this->input->post('exam_date', true);
            $exam_id = $this->input->post('exam_id', true);
            $exam_cost = $this->input->post('exam_cost', true);
            $this->update->updateExamStatus($student_nc, $course_student_id, $course_id, $exam_stage, $exam_stage_p, $academy_id);
            $this->insert_exam_cost($student_nc, $exam_id);
            $arrForExamsStudents = array(
                'academy_id' => $academy_id,
                'course_student_id' => $course_student_id,
                'course_id' => $course_id,
                'exam_id' => $exam_id,
                'student_nc' => $student_nc,
                'exam_date' => $exam_date,
                'exam_cost' => $exam_cost
            );
            $this->base->insert('exams_students', $arrForExamsStudents);
            $this->session->set_flashdata('enroll-exam-mark', 'ثبت نام دانشجو در دوره مورد نظر انجام شد');
            $this->show_student_courses($student_nc);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function student_enroll_written_exam_mark() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $course_id = $this->input->post('course_id', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $mark = $this->input->post('mark', true);
            $mark_stage = $this->input->post('mark_stage', true);
            $exam_stage = $this->input->post('exam_stage', true);
            if ($mark >= 50) {
                $this->update->updateWrittenExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, '1');
            } else {
                $this->update->updateWrittenExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, '0');
            }
            $this->session->set_flashdata('enroll-exam-mark', 'ثبت نمره دانشجو با موفقیت انجام شد');
            $this->show_student_courses($student_nc);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function student_enroll_practical_exam_mark() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $course_id = $this->input->post('course_id', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $mark = $this->input->post('mark', true);
            $mark_stage = $this->input->post('mark_stage', true);
            $exam_stage = $this->input->post('exam_stage', true);
            if ($mark >= 70) {
                $this->update->updatePracticalExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, '1');
            } else {
                $this->update->updatePracticalExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, '1');
            }
            $this->session->set_flashdata('enroll-exam-mark', 'ثبت نمره دانشجو با موفقیت انجام شد');
            $this->show_student_courses($student_nc);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function student_enroll_in_practical_alone() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $course_id = $this->input->post('course_id', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $exam_stage = $this->input->post('exam_stage', true);
            $exam_id = $this->input->post('exam_id', true);
            $exam_date = $this->input->post('exam_date', true);
            $exam_cost = $this->input->post('exam_cost', true);
            $this->insert_exam_cost($student_nc, $exam_id);
            $arrForExamsStudents = array(
                'academy_id' => $academy_id,
                'course_student_id' => $course_student_id,
                'course_id' => $course_id,
                'exam_id' => $exam_id,
                'student_nc' => $student_nc,
                'exam_date' => $exam_date,
                'exam_cost' => $exam_cost
            );
            $this->base->insert('exams_students', $arrForExamsStudents);
            $this->update->updateAloneExamStatus($student_nc, $course_student_id, $course_id, $exam_stage, $academy_id);
            $this->session->set_flashdata('enroll-exam-mark', 'ثبت نام دانشجو در دوره مورد نظر انجام شد');
            $this->show_student_courses($student_nc);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

}

/* End of file Enrollment.php */
