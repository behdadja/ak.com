<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller {

    private $encryptionKey = 'wNx6fCLiIHd06AUWxTOqyuxcdA9mzgaV';

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->library('user_agent');
        $this->load->library('zarinpal', [
            'merchant_id' => '50a9ce9c-9cbd-11e9-b0b8-000c29344814'
        ]);
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
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function finan_get_student_nc() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['students_info'] = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'finan-get-student-nc-page';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('مالی و حسابداری - استعلام وضعیت مالی دانشجو', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    public function student_inquiry() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $student_nc = $this->input->post('national_code', true);
            if ($this->exist->exist_entry('students', array('national_code' => $student_nc, 'academy_id' => $academy_id))) {
                $contentData['yield'] = 'financial-inquiry';
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'financial-data-table-scripts';
                $footerData['secondScripts'] = 'custom-select-scripts';
                $contentData['students'] = $this->base->get_data('students', '*', array('national_code' => $student_nc, 'academy_id' => $academy_id));
                $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('student_nc' => $student_nc, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
                $contentData['exams'] = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $student_nc, 'exams_students.academy_id' => $academy_id, 'exams.academy_id' => $academy_id));
                $contentData['exam_pouse'] = $this->base->get_data('exam_pouse_pay', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['exam_cash'] = $this->base->get_data('exam_cash_pay', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['course_cash'] = $this->base->get_data('course_cash_pay', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['course_check'] = $this->base->get_data('course_check_pay', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $contentData['online_payments'] = $this->base->get_data('online_payments', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $this->show_pages('مالی و حسابداری - استعلام وضعیت مالی دانشجو', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }
    public function student_payments(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
             if ($this->exist->exist_entry('students', array('academy_id' => $academy_id))) {
                $contentData['yield'] = 'students-payments';
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'financial-data-table-scripts';
                $footerData['secondScripts'] = 'custom-select-scripts';
//                $contentData['students_info'] = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
                $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('academy_id' => $academy_id));
                $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array( 'academy_id' => $academy_id));
                $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array( 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
                $contentData['online_payments'] = $this->get_join->get_data('students', 'online_payments', 'students.national_code=online_payments.student_nc', null, null, array( 'students.academy_id' => $academy_id, 'online_payments.academy_id' => $academy_id));
//                $contentData['online_payments'] = $this->base->get_data('online_payments', '*', array('academy_id' => $academy_id));
                $this->show_pages('مالی و حسابداری - پرداخت ها', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    public function student_exam_tuition_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['yield'] = 'get-student-nc-exam-tuition';
            $this->show_pages('مالی و حسابداری - پرداخت شهریه آزمون ها', 'content', $contentData);
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    public function get_all_exam_tuition() {
        $this->form_validation->set_rules('student_nc', 'کد ملی دانشجو', 'required|exact_length[10]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id');
            $student_nc = $this->input->post('student_nc', true);
            if ($this->exist->exist_entry('students', array('national_code' => $student_nc, 'academy_id' => $academy_id))) {
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'data-table-scripts';
                $contentData['yield'] = 'all-exams-for-pay';
                $headerData['secondLinks'] = 'persian-calendar-links';
                $footerData['secondScripts'] = 'persian-calendar-scripts';
                $contentData['exams'] = $this->base->get_data('exams_students', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
                $this->show_pages('مالی و حسابداری - پرداخت شهریه آزمون های ثبت نامی دانشجو', 'content', $contentData, $headerData, $footerData);
            } else {
                $this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
                redirect('financial/get-all-exam-tuition', 'refresh');
            }
        } else {
            $this->get_all_exam_tuition();
        }
    }

    private function insert_pay($student_nc, $amount_pay) {
        $academy_id = $this->session->userdata('academy_id');
        $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
        if(!empty($financial_situation)) {
            if ((int)$financial_situation[0]->final_situation === 0 || (int)$financial_situation[0]->final_situation === 1) {
                $amount_update = array(
                    'final_amount' => (int)$financial_situation[0]->final_amount + (int)$amount_pay,
                    'final_situation' => 1
                );
            } else {
                if ((int)$amount_pay > (int)$financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => (int)$amount_pay - (int)$financial_situation[0]->final_amount,
                        'final_situation' => 1
                    );
                } elseif ((int)$amount_pay === (int)$financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => 0,
                        'final_situation' => 0
                    );
                } else {
                    $amount_update = array(
                        'final_amount' => (int)$financial_situation[0]->final_amount - (int)$amount_pay,
                        'final_situation' => -1
                    );
                }
            }
            $this->base->update('financial_situation', array('student_nc' => $student_nc, 'academy_id' => $academy_id), $amount_update);
        }else{
            echo 'فرد با این کد ملی در سامانه ثبت نشده است';
        }
    }

    private function insert_pay_employee ($employee_nc, $amount_pay) {
        $academy_id = $this->session->userdata('academy_id');
        $financial_situation = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $employee_nc, 'academy_id' => $academy_id));
        if(!empty($financial_situation)) {
            if ((int)$financial_situation[0]->final_situation === 0 || (int)$financial_situation[0]->final_situation === -1) {
                $amount_update = array(
                    'final_amount' => (int)$financial_situation[0]->final_amount + (int)$amount_pay,
                    'final_situation' => -1
                );
            } else {
                if ((int)$amount_pay > (int)$financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => (int)$amount_pay - (int)$financial_situation[0]->final_amount,
                        'final_situation' => -1
                    );
                } elseif ((int)$amount_pay === (int)$financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => 0,
                        'final_situation' => 0
                    );
                } else {
                    $amount_update = array(
                        'final_amount' => (int)$financial_situation[0]->final_amount - (int)$amount_pay,
                        'final_situation' => 1
                    );
                }
            }
            $this->base->update('financial_situation_employer', array('employee_nc' => $employee_nc, 'academy_id' => $academy_id), $amount_update);
        }else{
            echo 'فرد با این کد ملی در سامانه ثبت نشده است';
        }
    }

    public function student_course_tuition_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['yield'] = 'get-student-nc-course-tuition';
            $this->show_pages('مالی و حسابداری - پرداخت شهریه دوره ها', 'content', $contentData);
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    public function get_all_course_tuition() {
        $this->form_validation->set_rules('student_nc', 'کد ملی دانشجو', 'required|exact_length[10]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id');
            $student_nc = $this->input->post('student_nc', true);
            if ($this->exist->exist_entry('students', array('national_code' => $student_nc, 'academy_id' => $academy_id))) {
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'data-table-scripts';
                $contentData['yield'] = 'all-courses-for-pay';
                $headerData['secondLinks'] = 'persian-calendar-links';
                $footerData['secondScripts'] = 'persian-calendar-scripts';
                $contentData['courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', null, null, array('student_nc' => $student_nc, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
                $contentData['students'] = $this->base->get_data('students', '*', array('national_code' => $student_nc, 'academy_id' => $academy_id));
                $this->show_pages('مالی و حسابداری - پرداخت شهریه دوره های ثبت نامی دانشجو', 'content', $contentData, $headerData, $footerData);
            } else {
                $this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
                redirect('financial/get-all-course-tuition', 'refresh');
            }
        } else {
            $this->get_all_course_tuition();
        }
    }

    //////////-آزمون-//////////
    //پرداخت نقدی آزمون
    public function cash_exam_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $student_nc = $this->input->post('student_nc', true);
            $exam_student_id = $this->input->post('exam_student_id', true);
            $course_id = $this->input->post('course_id', true);
            $examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id));
            $examSelected[0]->exam_cost_pay += $amount;
            $this->base->update('exams_students', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
            $cash_pay = array(
                'academy_id' => $academy_id,
                'student_nc' => $student_nc,
                'exam_student_id' => $exam_student_id,
                'amount_of_pay' => $amount,
                'exam_id' => $examSelected[0]->exam_id,
                'course_id' => $examSelected[0]->course_id
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->insert('exam_cash_pay', $cash_pay);
            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت پوز یا کارت برای آزمون
    public function pouse_exam_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $student_nc = $this->input->post('student_nc', true);
            $exam_student_id = $this->input->post('exam_student_id', true);
            $course_id = $this->input->post('course_id', true);
            $trans_num = $this->input->post('transaction_num', true);

            $examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id));
            $examSelected[0]->exam_cost_pay += $amount;
            $this->base->update('exams_students', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
            $cash_pay = array(
                'academy_id' => $academy_id,
                'student_nc' => $student_nc,
                'exam_student_id' => $exam_student_id,
                'pouse_amount' => $amount,
                'exam_id' => $examSelected[0]->exam_id,
                'course_id' => $examSelected[0]->course_id,
                'transaction_number' => $trans_num
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->insert('exam_pouse_pay', $cash_pay);
            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //افزودن تخفیف آزمون
    public function insert_off_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $price = $this->input->post('amount', true);
            $type_off = $this->input->post('switch', true);
            $exam_cost = $this->input->post('exam_cost', true);
            $exam_student_id = $this->input->post('exam_student_id', true);
            $student_nc = $this->input->post('student_nc', true);
            if ($type_off == 1) {
                $amount = ($exam_cost * $price) / 100;
            } elseif ($type_off == 2) {
                $amount = $price;
            }
            $uppdate_array = array(
                'amount_off' => $amount
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->update('exams_students', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id), $uppdate_array);
            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //////////-دوره-//////////
    //پرداخت نقدی دوره
    public function cash_course_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);

            $courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id));
            $courseSelected[0]->course_cost_pay += $amount;
            $this->base->update('courses_students', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $cash_pay = array(
                'academy_id' => $academy_id,
                'student_nc' => $student_nc,
                'course_student_id' => $course_student_id,
                'course_amount_of_pay' => $amount,
                'course_id' => $courseSelected[0]->course_id,
                'lesson_id' => $courseSelected[0]->lesson_id,
                'date_payment' => $date
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->insert('course_cash_pay', $cash_pay);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $studentDName2 = $this->session->userdata('studentDName2');

            $name = $studentDName2 . " گرامی " . $full_name;
            $price = $amount . " تومان به صورت نقدی";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_student_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت پوز یا کارت  دوره
    public function pouse_course_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $trans_num = $this->input->post('transaction_num', true);
            $courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id));
            $courseSelected[0]->course_cost_pay += $amount;
            $this->base->update('courses_students', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $pouse_pay = array(
                'academy_id' => $academy_id,
                'student_nc' => $student_nc,
                'course_student_id' => $course_student_id,
                'course_pouse_amount' => $amount,
                'lesson_id' => $courseSelected[0]->lesson_id,
                'course_id' => $courseSelected[0]->course_id,
                'date_payment' => $date,
                'transaction_number' => $trans_num
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->insert('course_pouse_pay', $pouse_pay);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $studentDName2 = $this->session->userdata('studentDName2');

            $name = $studentDName2 . " گرامی " . $full_name;
            $price = $amount . " تومان به وسیله کارتخوان";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_student_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت چک دوره
    public function check_course_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $serial_num = $this->input->post('serial_num', true);
            $check_date = $this->input->post('check_date', true);

            $courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id));
            $courseSelected[0]->course_cost_pay += $amount;
            $this->base->update('courses_students', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay));
            $this->session->set_flashdata('update-successfully-msg', 'ثبت چک با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $check_pay = array(
                'academy_id' => $academy_id,
                'student_nc' => $student_nc,
                'course_student_id' => $course_student_id,
                'check_amount' => $amount,
                'lesson_id' => $courseSelected[0]->lesson_id,
                'course_id' => $courseSelected[0]->course_id,
                'serial_number' => $serial_num,
                'check_date' => $check_date,
                'created_at' => $date
//                'check_date' => $this->calc->jalali_to_gregorian($check_date)
            );
            $this->insert_pay($student_nc, $amount);
            $this->base->insert('course_check_pay', $check_pay);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $studentDName2 = $this->session->userdata('studentDName2');

            $name = $studentDName2 . " گرامی " . $full_name;
            $price = $amount . " تومان به صورت چک";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_student_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //افزودن تخفیف دوره
    public function insert_off_course() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $price = $this->input->post('amount', true);
            $type_off = $this->input->post('switch', true);
            $course_cost = $this->input->post('course_cost', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_off = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id));
            if ($price > 0) {
                if ($type_off == 1) {
                    if ($price > 100) {
                        $price = 100;
                        $amount = ($course_cost * $price) / 100;
                    } else {
                        $amount = ($course_cost * $price) / 100;
                    }
                } elseif ($type_off == 2) {
                    $amount = $price;
                }
                $this->insert_pay($student_nc, $amount);
                $amount = $amount + $course_off[0]->amount_off;
                $update_array = array(
                    'amount_off' => $amount
                );
            } else {
                $amount = - $course_off[0]->amount_off;
                $this->insert_pay($student_nc, $amount);
                $update_array = array(
                    'amount_off' => 0
                );
            }
            $this->base->update('courses_students', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id), $update_array);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $studentDName2 = $this->session->userdata('studentDName2');

            $name = $studentDName2 . " گرامی " . $full_name;
            $price = $amount . " تومان ";
            $course = $lesson_name . " به عنوان تخفیف";
            $this->sms_for_payment($phone_num, $name, $price, $course);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $course . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_student_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('financial/finan-get-student-nc', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت حقوق استاد-چک
    public function check_course_pay_em() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $course_master = $this->input->post('course_master', true);
            $course_id = $this->input->post('course_id', true);
            $serial_num = $this->input->post('serial_num', true);
            $check_date = $this->input->post('check_date', true);
            $lesson_id = $this->input->post('lesson_id', true);
            $amount_received = $this->input->post('amount_received', true);
            $course_employee_id = $this->input->post('course_employee_id', true);

            $amount_received += $amount;
            $this->base->update('courses_employers', array('course_employee_id' => $course_employee_id, 'academy_id' => $academy_id), array('amount_received' => $amount_received));
            $this->session->set_flashdata('update-successfully-msg', 'پراخت چک  به استاد با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $check_pay = array(
                'academy_id' => $academy_id,
                'employee_nc' => $course_master,
                'check_amount' => $amount,
                'lesson_id' => $lesson_id,
                'course_id' => $course_id,
                'serial_number' => $serial_num,
                'check_date' => $check_date,
                'created_at' => $date,
                'course_employee_id' => $course_employee_id
                    // 'check_date' => $this->calc->jalali_to_gregorian($check_date)
            );
            $this->insert_pay_employee($course_master, $amount);
            $this->base->insert('course_check_pay', $check_pay);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $teacherDName = $this->session->userdata('teacherDName');

            $name = $teacherDName . " گرامی " . $full_name;
            $price = $amount . " تومان به صورت چک";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'employee_nc' => $course_master, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_employee_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('users/manage_employers_pay', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت حقوق استاد-کارت
    public function pouse_course_pay_em() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $course_master = $this->input->post('course_master', true);
            $course_id = $this->input->post('course_id', true);
            $trans_num = $this->input->post('transaction_num', true);
            $lesson_id = $this->input->post('lesson_id', true);
            $amount_received = $this->input->post('amount_received', true);
            $course_employee_id = $this->input->post('course_employee_id', true);

            $amount_received += $amount;
            $this->base->update('courses_employers', array('course_employee_id' => $course_employee_id, 'academy_id' => $academy_id), array('amount_received' => $amount_received));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت نقدی به استاد مورد نظر با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $pouse_pay = array(
                'academy_id' => $academy_id,
                'employee_nc' => $course_master,
                'course_pouse_amount' => $amount,
                'lesson_id' => $lesson_id,
                'course_id' => $course_id,
                'date_payment' => $date,
                'transaction_number' => $trans_num,
                'course_employee_id' => $course_employee_id
            );
            $this->insert_pay_employee($course_master, $amount);
            $this->base->insert('course_pouse_pay', $pouse_pay);

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $teacherDName = $this->session->userdata('teacherDName');

            $name = $teacherDName . " گرامی " . $full_name;
            $price = $amount . " تومان به صورت کارت به کارت";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'employee_nc' => $course_master, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_employee_sms', $insertArray);
            /////////////////پیامک////////////////

            redirect('users/manage_employers_pay', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    //پرداخت حقوق استاد-نقدی
    public function cash_course_pay_em() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $amount = $this->input->post('amount', true);
            $course_master = $this->input->post('course_master', true);
            $course_id = $this->input->post('course_id', true);
            $lesson_id = $this->input->post('lesson_id', true);
            $amount_received = $this->input->post('amount_received', true);
            $course_employee_id = $this->input->post('course_employee_id', true);

            $amount_received += $amount;
            $this->base->update('courses_employers', array('course_employee_id' => $course_employee_id, 'academy_id' => $academy_id), array('amount_received' => $amount_received));
            $this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $cash_pay = array(
                'academy_id' => $academy_id,
                'employee_nc' => $course_master,
                'course_amount_of_pay' => $amount,
                'course_id' => $lesson_id,
                'lesson_id' => $course_id,
                'date_payment' => $date,
                'course_employee_id' => $course_employee_id
            );

            /////////////////پیامک\\\\\\\\\\\\\\\
            $lesson_name = $this->input->post('lesson_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $full_name = $this->input->post('full_name', true);
            $teacherDName = $this->session->userdata('teacherDName');

            $name = $teacherDName . " گرامی " . $full_name;
            $price = $amount . " تومان به صورت نقدی";
            $this->sms_for_payment($phone_num, $name, $price, $lesson_name);

            $message = $name . " مبلغ " . $price . " بابت دوره " . $lesson_name . " با موفقیت ثبت گردید.";
            $insertArray = array('mss_body' => $message, 'employee_nc' => $course_master, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

            $this->base->insert('manager_employee_sms', $insertArray);
            /////////////////پیامک////////////////

            $this->insert_pay_employee($course_master, $amount);
            $this->base->insert('course_cash_pay', $cash_pay);
            $this->base->insert('manager_employee_sms', $insertArray);
            redirect('users/manage_employers_pay', 'refresh');
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    // پاس کردن چک
    public function pass_ckeck() {
        if ($this->agent->is_browser()) {
            $sessId = $this->session->userdata('session_id');
            $userType = $this->session->userdata('user_type');
            if (!empty($sessId) && $userType === 'managers') {

                $academy_id = $this->session->userdata('academy_id');
                $zip = $this->input->post('check_pay_id', true);
                $where = $this->input->post('where', true);

                if ($where === 'course') {
                    $this->base->update('course_check_pay', array('check_pay_id' => $zip, 'academy_id' => $academy_id), array('check_status' => 1));
                    $check_info = $this->base->get_data('course_check_pay', '*', array('check_pay_id' => $zip, 'academy_id' => $academy_id));
                    $course_info = $this->base->get_data('courses_students', '*', array('course_student_id' => $check_info[0]->course_student_id, 'academy_id' => $academy_id));
                    $this->base->update('courses_students', array('course_student_id' => $check_info[0]->course_student_id, 'academy_id' => $academy_id), array('course_cost_pay' => ($check_info[0]->check_amount + $course_info[0]->course_cost_pay)));
                    $this->insert_pay($check_info[0]->student_nc, $check_info[0]->check_amount);
                    $this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت پاس گردید.');
                    redirect('financial/manage-courses-check', 'refresh');
                } else {
                    $this->base->update('exam_check_pay', array('check_pay_id' => $zip, 'academy_id' => $academy_id), array('check_status' => 1));
                    $check_info = $this->base->get_data('exam_check_pay', '*', array('check_pay_id' => $zip, 'academy_id' => $academy_id));
                    $exam_info = $this->base->get_data('exams_students', '*', array('exam_student_id' => $check_info[0]->exam_student_id, 'academy_id' => $academy_id));
                    $this->base->update('exams_students', array('exam_student_id' => $check_info[0]->exam_student_id, 'academy_id' => $academy_id), array('exam_cost_pay' => ($check_info[0]->check_amount + $exam_info[0]->exam_cost_pay)));
                    $this->insert_pay($check_info[0]->student_nc, $check_info[0]->check_amount);
                    $this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت پاس گردید.');
                    redirect('financial/manage-exams-check', 'refresh');
                }
            } else {
                redirect('financial/error-403', 'refresh');
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    // برگشت زدن چک
    public function return_ckeck() {
        if ($this->agent->is_browser()) {
            $sessId = $this->session->userdata('session_id');
            $userType = $this->session->userdata('user_type');
            if (!empty($sessId) && $userType === 'managers') {
                $academy_id = $this->session->userdata('academy_id');
                $zip = $this->input->post('check_pay_id', true);
                $download = $this->input->post('download', true);
                $this->base->update($download, array('check_pay_id' => $zip, 'academy_id' => $academy_id), array('check_status' => 2));
                $this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت برگشت زده شد.');
                redirect('financial/manage-exams-check', 'refresh');
            } else {
                redirect('financial/error-403', 'refresh');
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    // مدیریت چک ها
    public function manage_courses_check() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['yield'] = 'manage-courses-checks';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $contentData['courses_checks'] = $this->get_join->get_data('course_check_pay', 'lessons', 'course_check_pay.lesson_id=lessons.lesson_id', 'courses', 'course_check_pay.course_id=courses.course_id', array('course_check_pay.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
            $this->show_pages('مالی و حسابداری - مدیرت چک های دریافتی برای آزمون ها', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    // پیامک جهت پرداخت ها
    public function sms_for_payment($phone_num, $name, $price, $course) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_name = $this->session->userdata('academy_name');
            $academyDName = $this->session->userdata('academyDName');
            $academy = $academyDName . " " . $academy_name;

            $username = "mehritc";
            $password = '@utabpars1219';
            $from = "+983000505";
            $pattern_code = "ydx4lpds0l";
            $to = array($phone_num);
            $input_data = array(
                "name" => "$name",
                "price" => "$price",
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
            redirect('financial/error-403', 'refresh');
        }
    }
    public function online_payment() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $amount = $this->input->post('online_amount', true);

//            $payment_info['course_id'] = $course_id;
//            $payment_info['lesson_name'] = $lesson_name;
//            $payment_info['date_payment'] = $date_payment;
//            if (!empty($course_student_id))
//                $payment_info['course_student_id'] = $course_student_id;
//            if (!empty($exam_student_id))
//                $payment_info['exam_student_id'] = $exam_student_id;
//            if (!empty($exam_id))
//                $payment_info['exam_id'] = $exam_id;
//            $this->session->set_userdata($payment_info);

            $callback = 'https://amoozkadeh.com/portal/financial/pay_verify/' . $amount;
            $description = "پرداخت هزینه دوره";
            if ($this->zarinpal->request($amount, $description, $callback)) {
                $authority = $this->zarinpal->get_authority();
                // do database stuff
                $this->zarinpal->redirect();
            } else {
//                echo "failed";
                $this->session->set_flashdata('failed_payment', 'لطفا مبلغ را صحیح وارد کنید');
                redirect('wallet', 'refresh');
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }

    public function pay_verify($amount) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $status = $this->input->get('Status', TRUE);
            $authority = $this->input->get('Authority', TRUE);

            if ($status != 'OK' OR $authority == NULL) {
                $this->session->set_flashdata('failed_payment', 'پرداخت شما لغو شد');
                redirect('wallet');
            }
            if ($this->zarinpal->verify($amount, $authority)) {
                $ref_id = $this->zarinpal->get_ref_id();
                require_once 'jdf.php';
                $date_payment = jdate('H:i:s - Y/n/j');
                $success_payment = array(
                    'paid_amount' => $amount,
                    'verify_code' => $ref_id,
                    'date_payment' => $date_payment,
                    'academy_id' => $academy_id
                );

                $last_id = $this->base->insert('manager_payments', $success_payment);

//                /////////////////پیامک\\\\\\\\\\\\\\\
//                $lesson_name = $this->session->userdata('lesson_name');
//                $phone_num = $this->session->userdata('phone_num');
//                $full_name = $this->session->userdata('full_name');
//                $studentDName2 = $this->session->userdata('studentDName2');
//
//                $name = $studentDName2 . " گرامی " . $full_name;
//                $price = $amount . " تومان به صورت آنلاین";
//                $course = $lesson_name;
//                $this->smsForPaymentsStudent($phone_num, $name, $price, $course);
//
//                $message = $name . " مبلغ " . $price . " بابت دوره " . $course . " با موفقیت ثبت گردید.";
//                $insertArray = array('mss_body' => $message, 'student_nc' => $sessId, 'manager_nc' => $sessId, 'academy_id' => $academy_id);
//
//                $this->base->insert('manager_student_sms', $insertArray);
//                /////////////////پیامک////////////////

                $this->session->set_flashdata('success_payment', 'ok');
                redirect('wallet');
            } else {
                $error = $this->zarinpal->get_error();
                $this->session->set_flashdata('failed_payment', 'متاسفانه پرداخت انجام نشد');
                redirect('wallet');
            }
        } else {
            redirect('financial/error-403', 'refresh');
        }
    }
    public function reckon_request(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $reckon = $this->base->get_data('academys_option','reckon_request',array('academy_id' => $academy_id));
            if ($reckon != 1){
                $data = array(
                    'reckon_request'=> 1
                );
                $this->base->update('academys_option', array('academy_id' => $academy_id), $data);
                $contentData['yield'] = 'students-payments';
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'financial-data-table-scripts';
                $footerData['secondScripts'] = 'custom-select-scripts';
//                $contentData['students_info'] = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
                $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('academy_id' => $academy_id));
                $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array( 'academy_id' => $academy_id));
                $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array( 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
                $contentData['online_payments'] = $this->get_join->get_data('students', 'online_payments', 'students.national_code=online_payments.student_nc', null, null, array( 'students.academy_id' => $academy_id, 'online_payments.academy_id' => $academy_id));
//                $contentData['online_payments'] = $this->base->get_data('online_payments', '*', array('academy_id' => $academy_id));
                $this->session->set_flashdata('success_request', 'درخواست شما با موفقیت ثبت شد. واریز پرداخت ها به حساب شما به زودی انجام خواهد شد.');

                $this->show_pages('مالی و حسابداری - پرداخت ها', 'content', $contentData, $headerData, $footerData);
            }elseif ($reckon == 1){
                $this->session->set_flashdata('failed_request','درخواست واریز پرداخت ها برای شما قبلا ثبت شده است');
            }
        }else {
            redirect('financial/error-403', 'refresh');
        }
    }


    public function onlineClassHours ($academy_id)
    {
        $hours = $this->base->get_data('academys_option', 'online_class_hours', array('academy_id' => $academy_id));
        return $hours[0]->online_class_hours;
    }

    public function countOfStd ($academy_id)
    {
        $number_of_std = $this->get_data('academys_option','number_of_student', array('academy_id' => $academy_id));
        $num_of_stds = array('number_of_std' => $number_of_std[0]->number_of_student);
        $this->session->set_userdata($num_of_stds);
        return  $number_of_std;
    }

    public function calculate_student_price ($count, $each)
    {
        return ($count * $each);
    }

    public function calculate_OCH ($count,$hour)
    { if ($count<=5){
        $pricePerHour=3500;
        return  $price_online=$pricePerHour*$hour;
    }
        if ($count>5 && $count<=10){
            $pricePerHour=4500;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>10 && $count<=20){
            $pricePerHour=5500;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>20 && $count<=30){
            $pricePerHour=7500;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>30 && $count<=40){
            $pricePerHour=8000;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>40 && $count<=50){
            $pricePerHour=10000;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>50 && $count<=70){
            $pricePerHour=17000;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>70 && $count<=100){
            $pricePerHour=22000;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>100 && $count<=120){
            $pricePerHour=27000;
            return  $price_online=$pricePerHour*$hour;
        }
        if ($count>120 && $count<=150){
            $pricePerHour=40000;
            return  $price_online=$pricePerHour*$hour;
        }

    }

    public function base_price ($price)
    {
        return $price;
    }

    public function total_price ($academy_id, $price_perSTD, $price_online, $base_price, $is_off = NULL, $off = NULL)
    {
        $total_price = $this->calculate_student_price($this->countOfStd($academy_id), $price_perSTD) + $this->calculate_OCH($this->onlineClassHours($academy_id),$price_online) + $this->base_price($base_price);

        if ($is_off != NUll)
        {
            $total_price *= $off;
        }

        return $total_price;
    }


    public function calculate_total_price($base,$countOfStd,$hour){
        if ($countOfStd<=5){
           $pricePerHour=3500;
           return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>5 && $countOfStd<=10){
            $pricePerHour=4500;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>10 && $countOfStd<=20){
            $pricePerHour=5500;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>20 && $countOfStd<=30){
            $pricePerHour=7500;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>30 && $countOfStd<=40){
            $pricePerHour=8000;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>40 && $countOfStd<=50){
            $pricePerHour=10000;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>50 && $countOfStd<=70){
            $pricePerHour=17000;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>70 && $countOfStd<=100){
            $pricePerHour=22000;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>100 && $countOfStd<=120){
            $pricePerHour=27000;
            return  $base+$pricePerHour*$hour;
        }
        if ($countOfStd>120 && $countOfStd<=150){
            $pricePerHour=40000;
            return  $base+$pricePerHour*$hour;
        }
    }

}


/* End of file Financial.php */
