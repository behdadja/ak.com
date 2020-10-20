<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financialst extends CI_Controller {

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
		$this->load->view('student/financialst/errors/403');
	}

	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null)
	{
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}

    public function finst_inquiry(){
        $sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'students') {
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $contentData['yield'] = 'financialst-inquiry';
            $contentData['wallet_stock'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $sessId));
            $contentData['financial_state'] = $this->base->get_data('financial_situation', '*', array('student_nc' => $sessId));
            $contentData['transactions'] = $this->base->get_data('transactions_students', '*', array('student_nc' => $sessId));
            $contentData['courses'] = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $sessId));
            $contentData['exams'] = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $sessId));
			$contentData['exam_pouse'] = $this->base->get_data('exam_pouse_pay', '*', array('student_nc' => $sessId));
			$contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('student_nc' => $sessId));
			// print_r($contentData['course_pouse']);
			$this->show_pages('دانشجو - وضعیت مالی', 'content', $contentData, $headerData, $footerData);
		}else {
			redirect('student/financialst/error-403', 'refresh');
		}
    }
}
