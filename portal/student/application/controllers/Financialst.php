<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financialst extends CI_Controller {

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
        $this->load->view('student/financialst/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function finst_inquiry() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $headerData['links'] = 'data-table-links';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $headerData['secondScripts'] = 'persian-calendar-scripts';
            $contentData['yield'] = 'financialst-inquiry';
            $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('student_nc' => $sessId, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['exams'] = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $sessId, 'exams_students.academy_id' => $academy_id, 'exams.academy_id' => $academy_id));
            $contentData['exam_pouse'] = $this->base->get_data('exam_pouse_pay', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['exam_cash'] = $this->base->get_data('exam_cash_pay', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['course_cash'] = $this->base->get_data('course_cash_pay', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['course_check'] = $this->base->get_data('course_check_pay', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['online_payments'] = $this->base->get_data('online_payments', '*', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            // print_r($contentData['course_pouse']);
            $this->show_pages('دانشجو - وضعیت مالی', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/financialst/error-403', 'refresh');
        }
    }

    public function online_payment() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            
            $course_id = $this->input->post('course_id', true);
            $lesson_name = $this->input->post('lesson_name', true);
            $exam_id = $this->input->post('exam_id', true);
            $amount = $this->input->post('online_amount', true);
            $date_payment = $this->input->post('date_payment', true);
            $course_student_id = $this->input->post('course_student_id', true);
            $exam_student_id = $this->input->post('exam_student_id', true);

            $payment_info['course_id'] = $course_id;
            $payment_info['lesson_name'] = $lesson_name;
            $payment_info['date_payment'] = $date_payment;
            if (!empty($course_student_id))
                $payment_info['course_student_id'] = $course_student_id;
            if (!empty($exam_student_id))
                $payment_info['exam_student_id'] = $exam_student_id;
            if (!empty($exam_id))
                $payment_info['exam_id'] = $exam_id;
            $this->session->set_userdata($payment_info);

//            $callback = 'https://amoozkadeh.com/portal/student/financialst/finst_inquiry/' . $amount;
			$callback = 'https://amoozkadeh.com/portal/student/financialst/pay_verify/' . $amount;
            $description = "پرداخت هزینه دوره";
            if ($this->zarinpal->request($amount, $description, $callback)) {
                $authority = $this->zarinpal->get_authority();
                // do database stuff
                $this->zarinpal->redirect();
            } else {
				$this->session->set_flashdata('failed_payment', 'لطفا مبلغ را صحیح وارد کنید');
				redirect('student/financialst/finst_inquiry');
            }
        } else {
            redirect('student/financialst/error-403', 'refresh');
        }
    }

    public function pay_verify($amount) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {

            $academy_id = $this->session->userdata('academy_id');
            $status = $this->input->get('Status', TRUE);
            $authority = $this->input->get('Authority', TRUE);

            if ($status != 'OK' OR $authority == NULL) {
                $this->session->set_flashdata('failed_payment', 'پرداخت شما لغو شد');
                redirect('student/financialst/finst_inquiry');
            }
			if ($this->zarinpal->verify($amount, $authority)) {
				$ref_id = $this->zarinpal->get_ref_id();
				$course_id = $this->session->userdata('course_id');
				$exam_id = $this->session->userdata('exam_id');
				$date_payment = $this->session->userdata('date_payment');
				$course_student_id = $this->session->userdata('course_student_id');
				$exam_student_id = $this->session->userdata('exam_student_id');
				$success_payment = array(
					'paid_amount' => $amount,
					'verify_code' => $ref_id,
					'date_payment' => $date_payment,
					'course_id' => $course_id,
					'exam_id' => $exam_id,
					'academy_id' => $academy_id,
					'student_nc' => $sessId
				);

				$last_id = $this->base->insert('online_payments', $success_payment);
				$success_payment['payment_id']=$last_id;
				$this->session->set_userdata($success_payment);

				$this->insert_pay($sessId, $amount);

				if (!empty($course_student_id)) {
					$courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id));
					$courseSelected[0]->course_cost_pay += $amount;
					$this->base->update('courses_students', array('course_student_id' => $course_student_id, 'academy_id' => $academy_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay));
				}
				if (!empty($exam_student_id)) {
					$examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id));
					$examSelected[0]->exam_cost_pay += $amount;
					$this->base->update('exams_students', array('exam_student_id' => $exam_student_id, 'academy_id' => $academy_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay));
				}

				/////////////////پیامک\\\\\\\\\\\\\\\
				$lesson_name = $this->session->userdata('lesson_name');
				$phone_num = $this->session->userdata('phone_num');
				$full_name = $this->session->userdata('full_name');
				$studentDName2 = $this->session->userdata('studentDName2');

				$name = $studentDName2 . " گرامی " . $full_name;
				$price = $amount . " تومان به صورت آنلاین";
				$course = $lesson_name;
				$this->smsForPaymentsStudent($phone_num, $name, $price, $course);

				$message = $name . " مبلغ " . $price . " بابت دوره " . $course . " با موفقیت ثبت گردید.";
				$insertArray = array('mss_body' => $message, 'student_nc' => $sessId, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

				$this->base->insert('manager_student_sms', $insertArray);
				/////////////////پیامک////////////////

				$this->session->set_flashdata('success_payment', 'ok');
				redirect('student/financialst/finst_inquiry');
			} else {
				$error = $this->zarinpal->get_error();
				$this->session->set_flashdata('failed_payment', 'متاسفانه پرداخت انجام نشد');
				redirect('student/financialst/finst_inquiry');
			}
        } else {
            redirect('student/financialst/error-403', 'refresh');
        }
    }

    public function smsForPaymentsStudent($phone_num, $name, $price, $course) {
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
    }

    private function insert_pay($student_nc, $amount_pay) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {

            $academy_id = $this->session->userdata('academy_id');
            $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc, 'academy_id' => $academy_id));
            if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === 1) {
                $amount_update = array(
                    'final_amount' => (int) $financial_situation[0]->final_amount + (int) $amount_pay,
                    'final_situation' => 1
                );
            } else {
                if ((int) $amount_pay > (int) $financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => (int) $amount_pay - (int) $financial_situation[0]->final_amount,
                        'final_situation' => 1
                    );
                } elseif ((int) $amount_pay === (int) $financial_situation[0]->final_amount) {
                    $amount_update = array(
                        'final_amount' => 0,
                        'final_situation' => 0
                    );
                } else {
                    $amount_update = array(
                        'final_amount' => (int) $financial_situation[0]->final_amount - (int) $amount_pay,
                        'final_situation' => -1
                    );
                }
            }
            $this->base->update('financial_situation', array('student_nc' => $student_nc, 'academy_id' => $academy_id), $amount_update);
        } else {
            redirect('student/financialst/error-403', 'refresh');
        }
    }

}
