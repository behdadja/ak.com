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
        $national_code = $this->input->post('national_code', true);
        $password = $this->input->post('password', true);
        if ($this->exist->exist_entry('personnels', array(
                    'national_code' => $national_code,
                    'password' => sha1($password . $this->salt),
                    'manager_activated' => 1
                        )
                )
        ) {
            $userInfo = $this->base->get_data('personnels', '*', array('national_code' => $national_code));
            $userInfo[0]->pic_url = base_url() . 'assets/profile-picture/' . $userInfo[0]->pic_name;
            $userInfo[0]->token = bin2hex(openssl_random_pseudo_bytes(128));
            $userInfo[0]->status = 1;
            echo (json_encode($userInfo[0]));
        } else {
            $result = array(
                'status' => '0'
            );
            echo (json_encode($result));
        }
    }

    public function all_classes() {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $query['classes'] = $this->base->get_data('classes', '*');
            $query['status'] = (string) 1;
            echo (json_encode($query));
        } else {

            $error = array('status' => '0', 'message' => 'This method is not allowed!');
            echo json_encode($error);
        }
    }

    public function all_lessons() {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $query['lessons'] = $this->base->get_data('lessons', '*');
            $query['status'] = (string) 1;
            echo (json_encode($query));
        } else {

            $error = array('status' => '0', 'message' => 'This method is not allowed!');
            echo json_encode($error);
        }
    }

    public function all_courses() {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $query['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'courses.course_master=employers.employee_id', null);
            $query['status'] = (string) 1;
            echo (json_encode($query));
        } else {

            $error = array('status' => '0', 'message' => 'This method is not allowed!');
            echo json_encode($error);
        }
    }

    public function all_employers() {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $query['employers'] = $this->base->get_data('employers', '*');
            foreach ($query['employers'] as $value) {
                $value->pic_url = base_url() . 'assets/profile-picture/' . $value->pic_name;
            }
            $query['status'] = (string) 1;
            echo (json_encode($query));
        } else {

            $error = array('status' => '0', 'message' => 'This method is not allowed!');
            echo json_encode($error);
        }
    }

    public function manager_ticket_to_student() {
        $student_nc = $this->input->post('student_nc', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $ticket_body = $this->input->post('ticket_body', true);
        $insertArray = array('student_nc' => $student_nc, 'manager_nc' => $manager_nc, 'mst_body' => $ticket_body);
        $this->base->insert('manager_student_tickets', $insertArray);
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_sms_to_student() {

        $message = $this->input->post('sms_body', true);
        $student_nc = $this->input->post('student_nc', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $student = $this->base->get_data('students', '*', array('national_code' => $student_nc));
        $rcpt_nm = array(substr($student[0]->phone_num, 1, 10));
        $this->send_sms($rcpt_nm, $message);
        $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $manager_nc);
        $this->base->insert('manager_student_sms', $insertArray);
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_sms_to_course() {

        $message = $this->input->post('sms_body', true);
        $course_id = $this->input->post('course_id', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id));
        // print_r($course_students);
        $rcpt_nm = array();
        foreach ($course_students as $student) {
            $rcpt_nm = array(substr($employee->phone_num, 1, 10));
            $insertArray = array(
                'mss_body' => $message,
                'student_nc' => $student->national_code,
                'manager_nc' => $manager_nc,
                'mss_from' => 'course-sms'
            );
            $this->base->insert('manager_student_sms', $insertArray);
        }
        $this->send_sms($rcpt_nm, $message);
        $this->base->insert('manager_course_sms', array('mcs_body' => $message, 'course_id' => $course_id, 'manager_nc' => $manager_nc));
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_to_course() {

        $message = $this->input->post('ticket_body', true);
        $course_id = $this->input->post('course_id', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id));
        // print_r($course_students);
        foreach ($course_students as $student) {
            $insertArray = array(
                'mst_body' => $message,
                'student_nc' => $student->national_code,
                'manager_nc' => $manager_nc
            );
            $this->base->insert('manager_student_tickets', $insertArray);
        }
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function manager_ticket_to_employee() {
        $message = $this->input->post('ticket_body', true);
        $employee_nc = $this->input->post('employee_nc', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $insertArray = array(
            'met_body' => $message,
            'employee_nc' => $employee_nc,
            'manager_nc' => $manager_nc
        );
        $this->base->insert('manager_employee_tickets', $insertArray);
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_to_employers() {

        $message = $this->input->post('ticket_body', true);
        $employers = $this->base->get_data('employers', '*');
        $manager_nc = $this->input->post('manager_nc', true);
        foreach ($employers as $employee) {
            $insertArray = array(
                'met_body' => $message,
                'employee_nc' => $employee->national_code,
                'manager_nc' => $manager_nc
            );
            $this->base->insert('manager_employee_tickets', $insertArray);
        }
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_sms_to_employee() {

        $message = $this->input->post('ticket_body', true);
        $employee_nc = $this->input->post('employee_nc', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $employee = $this->base->get_data('employers', '*', array('national_code' => $employee_nc));
        $rcpt_nm = array(substr($employee[0]->phone_num, 1, 10));
        $this->send_sms($rcpt_nm, $message);
        $insertArray = array('mes_body' => $message, 'employee_nc' => $employee_nc, 'manager_nc' => $manager_nc);
        $this->base->insert('manager_employee_sms', $insertArray);
        $success = array('status' => '1');
        echo json_encode($success);
    }

    public function send_sms_to_employers() {

        $message = $this->input->post('ticket_body', true);
        $manager_nc = $this->input->post('manager_nc', true);
        $employers = $this->base->get_data('employers', '*');
        $rcpt_nm = array();
        foreach ($employers as $employee) {
            $rcpt_nm = array(substr($employee->phone_num, 1, 10));
        }
        $this->send_sms($rcpt_nm, $message);
        $insertArray = array('maes_body' => $message, 'manager_nc' => $manager_nc, 'mes_type' => 1);
        $this->base->insert('manager_all_emp_sms', $insertArray);
        $success = array('status' => '1');
        echo json_encode($success);
    }

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
