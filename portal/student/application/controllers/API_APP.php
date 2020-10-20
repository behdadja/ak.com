<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class API_APP extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function index() {
        echo 'API APP';
    }

    public function login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        if ($this->exist->exist_entry('students', array(
                    'national_code' => $username,
                    'password' => sha1($password . $this->salt),
                    'student_activated' => 1
                        )
                )
        ) {
            $student_info = $this->base->get_data('students', 'first_name,last_name,pic_name', array('national_code' => $username));
            $wallet_students = $this->base->get_data('wallet_students', 'wallet_stock', array('national_code' => $username));
            $financial_status = $this->base->get_data('financial_situation', 'final_amount', array('national_code' => $username));
            $data->status = 1;
            $data->full_name = $student_info[0]->first_name . " " . $student_info[0]->last_name;
            $data->image = base_url('assets/profile-picture/' . $student_info[0]->pic_name);
            $data->wallet = $wallet_students[0]->wallet_stock;
            $data->financial = $financial_status[0]->final_amount;
//            $data[0]->token = bin2hex(openssl_random_pseudo_bytes(128));
            echo (json_encode($data[0]));
        } else {

            $error = array('status' => '0', 'message' => 'فردی با این اطلاعات موجود نمی باشد');
            echo json_encode($error);
        }
    }

    public function course_Of_student() {
        $username = $this->input->post('username', true);
        if ($this->exist->exist_entry('courses_students', array(
                    'national_code' => $username,
                        )
                )
        ) {

            $data['active_courses'] = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $username, 'course_status' => 1));
            $data['Waiting_courses'] = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $username, 'course_status' => 0));
            $data['Finished_courses'] = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $username, 'course_status' => 2));
            $data['status'] = (string) 1;
            echo (json_encode($data));
        } else {

            $error = array('status' => '0', 'message' => 'هنوز دوره ای برای شما ثبت نشده است.');
            echo json_encode($error);
        }
    }

    public function course_info() {
        $student_nc = $this->input->post('student_nc', true);
        $course_id = $this->input->post('course_id', true);
        $query['courses'] = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $student_nc));
        $query['attendancelist'] = $this->get_join->get_data('attendance', 'courses', 'courses.course_id=attendance.course_id', null, null, null);
        $query['count_absence'] = $this->base->get_data('attendance', '*', array('student_nc' => $student_nc));
        $query['status'] = (string) 1;
        echo (json_encode($query));
    }

//    public function manager_ticket_to_student() {
//        $student_nc = $this->input->post('student_nc', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $ticket_body = $this->input->post('ticket_body', true);
//        $insertArray = array('student_nc' => $student_nc, 'manager_nc' => $manager_nc, 'mst_body' => $ticket_body);
//        $this->base->insert('manager_student_tickets', $insertArray);
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_sms_to_student() {
//
//        $message = $this->input->post('sms_body', true);
//        $student_nc = $this->input->post('student_nc', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $student = $this->base->get_data('students', '*', array('national_code' => $student_nc));
//        $rcpt_nm = array(substr($student[0]->phone_num, 1, 10));
//        $this->send_sms($rcpt_nm, $message);
//        $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $manager_nc);
//        $this->base->insert('manager_student_sms', $insertArray);
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_sms_to_course() {
//
//        $message = $this->input->post('sms_body', true);
//        $course_id = $this->input->post('course_id', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id));
//        // print_r($course_students);
//        $rcpt_nm = array();
//        foreach ($course_students as $student) {
//            $rcpt_nm = array(substr($employee->phone_num, 1, 10));
//            $insertArray = array(
//                'mss_body' => $message,
//                'student_nc' => $student->national_code,
//                'manager_nc' => $manager_nc,
//                'mss_from' => 'course-sms'
//            );
//            $this->base->insert('manager_student_sms', $insertArray);
//        }
//        $this->send_sms($rcpt_nm, $message);
//        $this->base->insert('manager_course_sms', array('mcs_body' => $message, 'course_id' => $course_id, 'manager_nc' => $manager_nc));
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_to_course() {
//
//        $message = $this->input->post('ticket_body', true);
//        $course_id = $this->input->post('course_id', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id));
//        // print_r($course_students);
//        foreach ($course_students as $student) {
//            $insertArray = array(
//                'mst_body' => $message,
//                'student_nc' => $student->national_code,
//                'manager_nc' => $manager_nc
//            );
//            $this->base->insert('manager_student_tickets', $insertArray);
//        }
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function manager_ticket_to_employee() {
//        $message = $this->input->post('ticket_body', true);
//        $employee_nc = $this->input->post('employee_nc', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $insertArray = array(
//            'met_body' => $message,
//            'employee_nc' => $employee_nc,
//            'manager_nc' => $manager_nc
//        );
//        $this->base->insert('manager_employee_tickets', $insertArray);
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_to_employers() {
//
//        $message = $this->input->post('ticket_body', true);
//        $employers = $this->base->get_data('employers', '*');
//        $manager_nc = $this->input->post('manager_nc', true);
//        foreach ($employers as $employee) {
//            $insertArray = array(
//                'met_body' => $message,
//                'employee_nc' => $employee->national_code,
//                'manager_nc' => $manager_nc
//            );
//            $this->base->insert('manager_employee_tickets', $insertArray);
//        }
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_sms_to_employee() {
//
//        $message = $this->input->post('ticket_body', true);
//        $employee_nc = $this->input->post('employee_nc', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $employee = $this->base->get_data('employers', '*', array('national_code' => $employee_nc));
//        $rcpt_nm = array(substr($employee[0]->phone_num, 1, 10));
//        $this->send_sms($rcpt_nm, $message);
//        $insertArray = array('mes_body' => $message, 'employee_nc' => $employee_nc, 'manager_nc' => $manager_nc);
//        $this->base->insert('manager_employee_sms', $insertArray);
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }
//    public function send_sms_to_employers() {
//
//        $message = $this->input->post('ticket_body', true);
//        $manager_nc = $this->input->post('manager_nc', true);
//        $employers = $this->base->get_data('employers', '*');
//        $rcpt_nm = array();
//        foreach ($employers as $employee) {
//            $rcpt_nm = array(substr($employee->phone_num, 1, 10));
//        }
//        $this->send_sms($rcpt_nm, $message);
//        $insertArray = array('maes_body' => $message, 'manager_nc' => $manager_nc, 'mes_type' => 1);
//        $this->base->insert('manager_all_emp_sms', $insertArray);
//        $success = array('status' => '1');
//        echo json_encode($success);
//    }

    private function send_sms($rcpt_nm, $message) {
        $url = "37.130.202.188/services.jspd";

        $param = array
            (
            'uname' => 'parsac',
            'pass' => 'parsac1002',
            'from' => '+985000189',
            'message' => $message,
            'to' => json_encode($rcpt_nm),
            'op' => 'send'
        );
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($handler);
        $response2 = json_decode($response2);
        $res_code = $response2[0];
        $res_data = $response2[1];
        // echo $res_data;
    }

}
