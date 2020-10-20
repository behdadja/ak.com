<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller {

	private $encryptionKey = 'wNx6fCLiIHd06AUWxTOqyuxcdA9mzgaV';

	public function __construct()
	{
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

	public function error_403(){
		$this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
		$this->load->view('errors/403');
	}

	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null)
	{
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}

	public function finan_get_student_nc(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'finan-get-student-nc-page';
			$this->show_pages('مالی و حسابداری - استعلام وضعیت مالی دانشجو', 'content', $contentData);
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function student_inquiry(){
		$this->form_validation->set_rules('student_nc','کد ملی دانشجو','required|exact_length[10]|numeric');
		$this->form_validation->set_message('required','%s را وارد نمایید');
		$this->form_validation->set_message('exact_length','%s باید 10 رقم باشد');
		$this->form_validation->set_message('numeric','%s معتبر نیست');

		if ($this->form_validation->run() === TRUE){
			$student_nc = $this->input->post('student_nc', true);
			if ($this->exist->exist_entry('students', array('national_code' => $student_nc))){
				$headerData['links'] = 'data-table-links';
				$footerData['scripts'] = 'financial-data-table-scripts';
				$contentData['yield'] = 'financial-inquiry';
				$contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $student_nc));
				$contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc));
				$contentData['transactions'] = $this->base->get_data('transactions_students', '*', array('student_nc' => $student_nc));
				$contentData['courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $student_nc));
				$contentData['exams'] = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $student_nc));
				// print_r($contentData);
				$this->show_pages('مالی و حسابداری - استعلام وضعیت مالی دانشجو', 'content', $contentData, $headerData, $footerData);
			}else{
				$this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
				redirect('financial/finan-get-student-nc', 'refresh');
			}
		}else{
			$this->finan_get_student_nc();
		}
	}

	public function student_exam_tuition_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'get-student-nc-exam-tuition';
			$this->show_pages('مالی و حسابداری - پرداخت شهریه آزمون ها', 'content', $contentData);
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function get_all_exam_tuition(){
		$this->form_validation->set_rules('student_nc','کد ملی دانشجو','required|exact_length[10]|numeric');
		$this->form_validation->set_message('required','%s را وارد نمایید');
		$this->form_validation->set_message('exact_length','%s باید 10 رقم باشد');
		$this->form_validation->set_message('numeric','%s معتبر نیست');

		if ($this->form_validation->run() === TRUE){
			$student_nc = $this->input->post('student_nc', true);
			if ($this->exist->exist_entry('students', array('national_code' => $student_nc))){
				$headerData['links'] = 'data-table-links';
				$footerData['scripts'] = 'data-table-scripts';
				$contentData['yield'] = 'all-exams-for-pay';
				$headerData['secondLinks'] = 'persian-calendar-links';
				$footerData['secondScripts'] = 'persian-calendar-scripts';
				$contentData['exams'] = $this->base->get_data('exams_students', '*', array('student_nc' => $student_nc));
				$this->show_pages('مالی و حسابداری - پرداخت شهریه آزمون های ثبت نامی دانشجو', 'content', $contentData, $headerData, $footerData);
			}else{
				$this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
				redirect('financial/get-all-exam-tuition', 'refresh');
			}
		}else{
			$this->get_all_exam_tuition();
		}
	}

	public function cash_exam_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			$exam_student_id = $this->input->post('exam_student_id', true);
			$course_id = $this->input->post('course_id', true);

			$examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id));
			$examSelected[0]->exam_cost_pay += $amount;
			$this->base->update('exams_students', array('exam_student_id' => $exam_student_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
			$cash_pay = array(
				'student_nc' => $student_nc,
				'exam_student_id' => $exam_student_id,
				'amount_of_pay' => $amount,
				'exam_id' => $examSelected[0]->exam_id,
				'course_id' => $examSelected[0]->course_id
			);
			$this->insert_pay($student_nc, $amount);
			$this->base->insert('exam_cash_pay', $cash_pay);
			$this->get_all_exam_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function pouse_exam_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			$exam_student_id = $this->input->post('exam_student_id', true);
			$course_id = $this->input->post('course_id', true);
			$trans_num = $this->input->post('transaction_num', true);

			$examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id));
			$examSelected[0]->exam_cost_pay += $amount;
			$this->base->update('exams_students', array('exam_student_id' => $exam_student_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
			$cash_pay = array(
				'student_nc' => $student_nc,
				'exam_student_id' => $exam_student_id,
				'pouse_amount' => $amount,
				'exam_id' => $examSelected[0]->exam_id,
				'course_id' => $examSelected[0]->course_id,
				'transaction_number' => $trans_num
			);
			$this->insert_pay($student_nc, $amount);
			$this->base->insert('exam_pouse_pay', $cash_pay);
			$this->get_all_exam_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	private function insert_pay($student_nc, $amount_pay){

		$financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $student_nc));
		if((int)$financial_situation[0]->final_situation === 0 || (int)$financial_situation[0]->final_situation === 1){
			$amount_update = array(
				'final_amount' => (int)$financial_situation[0]->final_amount + (int)$amount_pay,
				'final_situation' => 1
				);
		}else{
			if((int)$amount_pay > (int)$financial_situation[0]->final_amount){
				$amount_update = array(
									'final_amount' => (int)$amount_pay - (int)$financial_situation[0]->final_amount,
									'final_situation' => 1
									);
			}elseif((int)$amount_pay === (int)$financial_situation[0]->final_amount){
				$amount_update = array(
									'final_amount' => 0,
									'final_situation' => 0
									);
			}else{
				$amount_update = array(
									'final_amount' => (int)$financial_situation[0]->final_amount - (int)$amount_pay,
									'final_situation' => -1
									);
			}
		}
		$this->base->update('financial_situation', array('student_nc' => $student_nc), $amount_update);
	}

	public function	checkـexamـpay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			$exam_student_id = $this->input->post('exam_student_id', true);
			$course_id = $this->input->post('course_id', true);
			$serial_num = $this->input->post('serial_num', true);
			$check_date = $this->input->post('check_date', true);

			$examSelected = $this->base->get_data('exams_students', '*', array('exam_student_id' => $exam_student_id));
			// $examSelected[0]->exam_cost_pay += $amount;
			// $this->base->update('exams_students', array('exam_student_id' => $exam_student_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'ثبت چک با موفقیت انجام شد.');
			$this->load->library('calc');
			$check_pay = array(
				'student_nc' => $student_nc,
				'exam_student_id' => $exam_student_id,
				'check_amount' => $amount,
				'exam_id' => $examSelected[0]->exam_id,
				'course_id' => $examSelected[0]->course_id,
				'serial_number' => $serial_num,
				'check_date' => $this->calc->jalali_to_gregorian($check_date)
			);
			// $this->insert_pay($student_nc, $amount);
			$this->base->insert('exam_check_pay', $check_pay);
			$this->get_all_exam_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function student_course_tuition_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'get-student-nc-course-tuition';
			$this->show_pages('مالی و حسابداری - پرداخت شهریه دوره ها', 'content', $contentData);
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function get_all_course_tuition(){
		$this->form_validation->set_rules('student_nc','کد ملی دانشجو','required|exact_length[10]|numeric');
		$this->form_validation->set_message('required','%s را وارد نمایید');
		$this->form_validation->set_message('exact_length','%s باید 10 رقم باشد');
		$this->form_validation->set_message('numeric','%s معتبر نیست');

		if ($this->form_validation->run() === TRUE){
			$student_nc = $this->input->post('student_nc', true);
			if ($this->exist->exist_entry('students', array('national_code' => $student_nc))){
				$headerData['links'] = 'data-table-links';
				$footerData['scripts'] = 'data-table-scripts';
				$contentData['yield'] = 'all-courses-for-pay';
				$headerData['secondLinks'] = 'persian-calendar-links';
				$footerData['secondScripts'] = 'persian-calendar-scripts';
				$contentData['courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', null, null, array('student_nc' => $student_nc));
				$this->show_pages('مالی و حسابداری - پرداخت شهریه دوره های ثبت نامی دانشجو', 'content', $contentData, $headerData, $footerData);
			}else{
				$this->session->set_flashdata('do-not-exist-student', 'دانشجو با کد ملی وارد شده موجود نمی باشد');
				redirect('financial/get-all-course-tuition', 'refresh');
			}
		}else{
			$this->get_all_course_tuition();
		}
	}

/////////////////////////////////////////

	public function cash_course_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			/////////////////پیامک///////
			   $student = $this->base->get_data('students','*', array('national_code' => $student_nc));
			   $rcpt_nm = array(substr($student[0]->phone_num, 1, 10));
			  /////////////////پیامک///////
			
			$course_student_id = $this->input->post('course_student_id', true);

			$examSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id));
			$examSelected[0]->course_cost_pay += $amount;
			$this->base->update('courses_students', array('course_student_id' => $course_student_id), array('course_cost_pay' => $examSelected[0]->course_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
			$cash_pay = array(
				'student_nc' => $student_nc,
				'course_student_id' => $course_student_id,
				'course_amount_of_pay' => $amount,
				'course_id' => $examSelected[0]->course_id,
				'lesson_id' => $examSelected[0]->lesson_id
			);
			
			/////////////////پیامک///////
			$message = "زبان آموز گرامی - مبلغ $amount تومان بصورت نقدی ثبت 
		گردید. ";
			 $this->send_sms($rcpt_nm, $message);
			 $insertArray = array('mss_body' => $message, 'student_nc' => $student_nc, 'manager_nc' => $sessId);
            /////////////////پیامک///////
			$this->insert_pay($student_nc, $amount);
			$this->base->insert('course_cash_pay', $cash_pay);
			$this->base->insert('manager_student_sms', $insertArray);
			$this->get_all_course_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

/////////////////پیامک///////
private function send_sms($rcpt_nm, $message){
		$url = "https://ippanel.com/services.jspd";

		$param = array
					(
						'uname'=>'parsac',
						'pass'=>'parsac1002',
						'from'=>'+9810009589',
						'message'=>$message,
						'to'=>json_encode($rcpt_nm),
						'op'=>'send'
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

	public function pouse_course_pay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			$course_student_id = $this->input->post('course_student_id', true);

			$trans_num = $this->input->post('transaction_num', true);

			$courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id));
			$courseSelected[0]->course_cost_pay += $amount;
			$this->base->update('courses_students', array('course_student_id' => $course_student_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'پرداخت در دوره مورد نظر با موفقیت انجام شد.');
			$pouse_pay = array(
				'student_nc' => $student_nc,
				'course_student_id' => $course_student_id,
				'course_pouse_amount' => $amount,
				'lesson_id' => $courseSelected[0]->lesson_id,
				'course_id' => $courseSelected[0]->course_id,
				'transaction_number' => $trans_num
			);
			$this->insert_pay($student_nc, $amount);
			$this->base->insert('course_pouse_pay', $pouse_pay);
			$this->get_all_course_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function	checkـcourseـpay(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$amount = $this->input->post('amount', true);
			$student_nc = $this->input->post('student_nc', true);
			$course_student_id = $this->input->post('course_student_id', true);

			$serial_num = $this->input->post('serial_num', true);
			$check_date = $this->input->post('check_date', true);

			$courseSelected = $this->base->get_data('courses_students', '*', array('course_student_id' => $course_student_id));
			// $examSelected[0]->exam_cost_pay += $amount;
			// $this->base->update('exams_students', array('exam_student_id' => $exam_student_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay ));
			$this->session->set_flashdata('update-successfully-msg', 'ثبت چک با موفقیت انجام شد.');
			$this->load->library('calc');
			$check_pay = array(
				'student_nc' => $student_nc,
				'course_student_id' => $course_student_id,
				'check_amount' => $amount,
				'lesson_id' => $courseSelected[0]->lesson_id,
				'course_id' => $courseSelected[0]->course_id,
				'serial_number' => $serial_num,
				'check_date' => $this->calc->jalali_to_gregorian($check_date)
			);
			// $this->insert_pay($student_nc, $amount);
			$this->base->insert('course_check_pay', $check_pay);
			$this->get_all_course_tuition();
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function manage_exams_check(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'manage-exams-checks';
			$headerData['links'] = 'data-table-links';
			$footerData['scripts'] = 'data-table-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$contentData['exams_checks'] = $this->get_join->get_data('exam_check_pay', 'exams', 'exam_check_pay.exam_id=exams.exam_id', 'courses', 'exam_check_pay.course_id=courses.course_id', null);
			// print_r($contentData);
			$this->show_pages('مالی و حسابداری - مدیرت چک های دریافتی برای آزمون ها', 'content', $contentData, $headerData, $footerData);
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function pass_ckeck(){
		if ($this->agent->is_browser()){
			$sessId = $this->session->userdata('session_id');
			$userType = $this->session->userdata('user_type');
			if (!empty($sessId) && $userType === 'managers') {
				$zip = $this->input->post('check_pay_id', true);
				$where = $this->input->post('where', true);
				if($where === 'course'){
					$this->base->update('course_check_pay', array('check_pay_id' => $zip), array('check_status' => 1));
					$check_info = $this->base->get_data('course_check_pay', '*', array('check_pay_id' => $zip));
					$course_info = $this->base->get_data('courses_students', '*', array('course_student_id' => $check_info[0]->course_student_id));
					$this->base->update('courses_students', array('course_student_id' => $check_info[0]->course_student_id), array('course_cost_pay' => ($check_info[0]->check_amount + $course_info[0]->course_cost_pay)));
					$this->insert_pay($check_info[0]->student_nc, $check_info[0]->check_amount);
					$this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت پاس گردید.');
					redirect('financial/manage-courses-check', 'refresh');
				}else{
					$this->base->update('exam_check_pay', array('check_pay_id' => $zip), array('check_status' => 1));
					$check_info = $this->base->get_data('exam_check_pay', '*', array('check_pay_id' => $zip));
					$exam_info = $this->base->get_data('exams_students', '*', array('exam_student_id' => $check_info[0]->exam_student_id));
					$this->base->update('exams_students', array('exam_student_id' => $check_info[0]->exam_student_id), array('exam_cost_pay' => ($check_info[0]->check_amount + $exam_info[0]->exam_cost_pay)));
					$this->insert_pay($check_info[0]->student_nc, $check_info[0]->check_amount);
					$this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت پاس گردید.');
					redirect('financial/manage-exams-check', 'refresh');
				}
			}else{
				redirect('financial/error-403', 'refresh');
			}
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function return_ckeck(){
		if ($this->agent->is_browser()){
			$sessId = $this->session->userdata('session_id');
			$userType = $this->session->userdata('user_type');
			if (!empty($sessId) && $userType === 'managers') {
				$zip = $this->input->post('check_pay_id', true);
				$download = $this->input->post('download', true);
				$this->base->update($download, array('check_pay_id' => $zip), array('check_status' => 2));
				$this->session->set_flashdata('insert-success', 'چک مورد نظر با موفقیت برگشت زده شد.');
				redirect('financial/manage-exams-check', 'refresh');
			}else{
				redirect('financial/error-403', 'refresh');
			}
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

	public function manage_courses_check(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'manage-courses-checks';
			$headerData['links'] = 'data-table-links';
			$footerData['scripts'] = 'data-table-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$contentData['courses_checks'] = $this->get_join->get_data('course_check_pay', 'lessons', 'course_check_pay.lesson_id=lessons.lesson_id', 'courses', 'course_check_pay.course_id=courses.course_id', null);
			// print_r($contentData);
			$this->show_pages('مالی و حسابداری - مدیرت چک های دریافتی برای آزمون ها', 'content', $contentData, $headerData, $footerData);
		}else {
			redirect('financial/error-403', 'refresh');
		}
	}

}

/* End of file Financial.php */
