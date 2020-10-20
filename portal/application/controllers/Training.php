<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {

	private $encryptionKey = 'wNx6fCLiIHd06AUWxTOqyuxcdA9mzgaV';

	public function __construct() {
		parent::__construct();
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		$this->load->library('calc');
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

	public function getGroupList($cluster_id) {
		$data = $this->base->get_group_name($cluster_id);
		echo json_encode($data);
	}

	public function getStandardList($group_id) {
		$data = $this->base->get_standard_name($group_id);
		echo json_encode($data);
	}

	public function create_new_class() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$contentData['yield'] = 'create-new-class';
			$this->show_pages($title = 'مدیریت کلاسها، ایجاد کلاس جدید', 'content', $contentData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function insert_new_class() {
		$this->form_validation->set_rules('class_name', 'نام کلاس', 'required|max_length[80]');
		$this->form_validation->set_rules('class_description', 'توضیحات', 'required');
		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('max_length', '%s نمی تواند بیشتر از 80 حرف باشد');

		if ($this->form_validation->run() === TRUE) {
			$academy_id = $this->session->userdata('academy_id');
			$class_name = $this->input->post('class_name', true);
			$class_desc = $this->input->post('class_description', true);
			$insert_array = array
			(
				'academy_id' => $academy_id,
				'class_name' => $class_name,
				'class_description' => $class_desc
			);
			$this->base->insert('classes', $insert_array);
			$this->session->set_flashdata('success-insert', 'ثبت کلاس جدید با موفقیت انجام شد.');
			echo "
                        <script type=\"text/javascript\">
                            sessionStorage . clear();
                        </script>
                    ";
			redirect('training/manage-classes', 'refresh');
		} else {
			$this->create_new_class();
		}
	}

	public function manage_classes() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['classes_info'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'manage-classes';
			$this->show_pages('مدیریت کلاس ها', 'content', $contentData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function edit_class() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$class_id = $this->input->post('class_id', true);
			$contentData['class_info'] = $this->base->get_data('classes', '*', array('class_id' => $class_id, 'academy_id' => $academy_id));
			$contentData['yield'] = 'edit-class';
			$this->show_pages('ویرایش کلاس', 'content', $contentData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function update_class() {
		$this->form_validation->set_rules('class_name', 'نام کلاس', 'required|max_length[80]');
		$this->form_validation->set_rules('description', 'توضیحات', 'required');
		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('max_length', '%s نمی تواند بیشتر از 80 حرف باشد');

		if ($this->form_validation->run() === TRUE) {
			$academy_id = $this->session->userdata('academy_id');
			$class_name = $this->input->post('class_name', true);
			$class_desc = $this->input->post('description', true);
			$class_id = $this->input->post('class_id', true);
			$insert_array = array
			(
				'class_name' => $class_name,
				'class_description' => $class_desc
			);
			$this->base->update('classes', array('class_id' => $class_id, 'academy_id' => $academy_id), $insert_array);
			$this->session->set_flashdata('success-update', 'ویرایش کلاس با موفقیت انجام شد.');
			redirect('training/manage-classes', 'refresh');
		} else {
			$this->edit_class();
		}
	}

	public function delete_class() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$class_id = $this->input->post('class_id', true);
			$this->base->delete_data('classes', array('class_id' => $class_id, 'academy_id' => $academy_id));
			$this->session->set_flashdata('success-delete', 'کلاس مورد نظر حذف گردید.');
			redirect('training/manage-classes', 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	// ------------- new_lesson ------------- \\
	public function create_new_lesson() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$type_academy = $this->session->userdata('type_academy');
			$contentData['data'] = $this->base->stnd($type_academy);
			$footerData['scripts'] = 'new-lesson-scripts';
			$contentData['yield'] = 'create-new-lesson';
			$this->show_pages($title = 'ایجاد درس جدید', 'content', $contentData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function insert_new_lesson() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('stnd', 'نام استاندارد', 'required');
            $this->form_validation->set_rules('lesson_name', 'نام درس', 'required|max_length[100]');
            $this->form_validation->set_rules('lesson_own_code', 'کد درس', 'required|max_length[100]');
            $this->form_validation->set_rules('lesson_description', 'توضیحات درس', 'required');
            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('max_length', '%s نمی تواند بیشتر از 100 حرف باشد');

            if ($this->form_validation->run() === TRUE) {
			$academy_id = $this->session->userdata('academy_id');
			$lesson_own_code = $this->input->post('lesson_own_code', true);
			$stnd = $this->input->post('stnd', true);
			$lesson_name = $this->input->post('lesson_name', true);
			$lesson_description = $this->input->post('lesson_description', true);

			if ($this->exist->exist_entry('lessons', array('lesson_own_code' => $lesson_own_code, 'academy_id' => $academy_id))) {

					$this->session->set_flashdata('lesson_own_code', 'کد اختصاصی وارد شده تکراری است، لطفا کد دیگری وارد کنید.');
					redirect('new-lesson');

			} else {

					$department = $this->input->post('department', true);
					if($this->session->userdata('type_academy') != 1 && !empty($department)) {
						if ($department != 1) {
							$test_name = $this->input->post('test_name', true);
							$range_score = $this->input->post('range_score', true);
							$quota_score = $this->input->post('quota_score', true);
							$percentage = $this->input->post('percentage', true);

							if (!empty($test_name[0])) {
								$test['item_0'] = [$test_name[0], $range_score[0], $quota_score[0], $percentage[0]];
							}
							if (!empty($test_name[1])) {
								$test['item_1'] = [$test_name[1], $range_score[1], $quota_score[1], $percentage[1]];
							}
							if (!empty($test_name[2])) {
								$test['item_2'] = [$test_name[2], $range_score[2], $quota_score[2], $percentage[2]];
							}
							if (!empty($test_name[3])) {
								$test['item_3'] = [$test_name[3], $range_score[3], $quota_score[3], $percentage[3]];
							}
							if (!empty($test_name[4])) {
								$test['item_4'] = [$test_name[4], $range_score[4], $quota_score[4], $percentage[4]];
							}
							if (!empty($test_name[5])) {
								$test['item_5'] = [$test_name[5], $range_score[5], $quota_score[5], $percentage[5]];
							}
							if (!empty($test_name[6])) {
								$test['item_6'] = [$test_name[6], $range_score[6], $quota_score[6], $percentage[6]];
							}
							if (!empty($test_name[7])) {
								$test['item_7'] = [$test_name[7], $range_score[7], $quota_score[7], $percentage[7]];
							}
							if (!empty($test_name[8])) {
								$test['item_8'] = [$test_name[8], $range_score[8], $quota_score[8], $percentage[8]];
							}
							if (!empty($test_name[9])) {
								$test['item_9'] = [$test_name[9], $range_score[9], $quota_score[9], $percentage[9]];
							}
							if(!empty($test)) {
								$test = json_encode($test);
								$insert_array['test'] = $test;
							}
						}else
							$insert_array['department'] = $department;
					}
					$insert_array['standard_id'] = $stnd;
					$insert_array['lesson_name'] = $lesson_name;
					$insert_array['academy_id'] = $academy_id;
					$insert_array['lesson_own_code'] = $lesson_own_code;
					$insert_array['lesson_description'] = $lesson_description;

					$this->base->insert('lessons', $insert_array);
					echo "<script type=\"text/javascript\">
                            sessionStorage . clear();
                        </script>";
					$this->session->set_flashdata('success-insert', 'ثبت درس جدید با موفقیت انجام شد.');
					redirect('training/manage-lessons', 'refresh');
			}
            } else {
				$this->session->set_flashdata('validation_errors', validation_errors());
                redirect('new-lesson');
            }
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

//    public function test_lesson() {
//
//        $academy_id = $this->session->userdata('academy_id');
//        $lesson = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id, 'lesson_id' => '62'));
//        foreach($lesson as $less){
//            $test= $less->test;
//        }
//        $test = json_decode($test);
//        echo $test->item_0[0];
//    }

	public function manage_lessons() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
//            $contentData['lessons_info'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
			$lessons_info = $contentData['lessons_info'] = $this->get_join->get_data('lessons', 'standards', 'lessons.standard_id=standards.standard_id', null, null, ['lessons.academy_id' => $academy_id]);
			$contentData['default_test'] = $this->base->get_data('default_test', '*');
			$contentData['yield'] = 'manage-lessons';
			$headerData['links'] = 'data-table-links';
			$footerData['scripts'] = 'financial-data-table-scripts';
			$this->show_pages('مدیریت درس ها', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function edit_lesson() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$lesson_id = $this->input->post('lesson_id', true);
			if(empty($lesson_id))
				$lesson_id = $this->input->get('lesson_id', true);
//            $contentData['lesson_info'] = $this->base->get_data('lessons', '*', array('lesson_id' => $lesson_id, 'academy_id' => $academy_id));
			$contentData['lesson_info'] = $this->get_join->get_data('lessons', 'standards', 'lessons.standard_id=standards.standard_id', null, null, ['lessons.lesson_id' => $lesson_id, 'lessons.academy_id' => $academy_id]);
			$contentData['default_test'] = $this->base->get_data('default_test', '*');
			$headerData['links'] = 'custom-select-links';
			$footerData['scripts'] = 'custom-select-scripts';
			$footerData['secondScripts'] = 'new-lesson-scripts';
			$contentData['yield'] = 'edit-lesson';
			$this->show_pages('ویرایش درس', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function update_lesson() {
//        $this->form_validation->set_rules('stnd', 'نام استاندارد', 'required');
		$this->form_validation->set_rules('lesson_name', 'نام درس', 'required|max_length[100]');
		$this->form_validation->set_rules('lesson_own_code', 'کد درس', 'required|max_length[100]');
		$this->form_validation->set_rules('lesson_description', 'توضیحات درس', 'required');
		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('max_length', '%s نمی تواند بیشتر از 100 حرف باشد');

		if ($this->form_validation->run() === TRUE) {
			$academy_id = $this->session->userdata('academy_id');
			$lesson_id = $this->input->post('lesson_id', true);
			$lesson_own_code = $this->input->post('lesson_own_code', true);

			if ($this->exist->exist_entry('lessons', array('lesson_own_code' => $lesson_own_code, 'academy_id' => $academy_id,'lesson_id !='=>$lesson_id)) === true) {
				$this->session->set_flashdata('error-own-code', 'کد اختصاصی وارد شده برای درس قبلا استفاده شده است. لطفا از کد دیگری استفاده کنید.');
				$this->edit_lesson();
			} else {

//            $update_array['standard_id'] = $this->input->post('stnd', true);
				$update_array['lesson_name'] = $this->input->post('lesson_name', true);
				$update_array['lesson_own_code'] = $lesson_own_code;
				$update_array['lesson_description'] = $this->input->post('lesson_description', true);

//                $written = $this->input->post('written', true);
//                $practical = $this->input->post('practical', true);
//                if ($written === 'on' && $practical === 'on') :
//                    $written_range_score = $this->input->post('written_range_score', true);
//                    $written_quota_Score = $this->input->post('written_quota_Score', true);
//                    $written_percentage = $this->input->post('written_percentage', true);
//                    $practical_range_score = $this->input->post('practical_range_score', true);
//                    $practical_quota_Score = $this->input->post('practical_quota_Score', true);
//                    $practical_percentage = $this->input->post('practical_percentage', true);
//                    $exam_type = '3';
//                    $update_array['exam_type'] = $exam_type;
//                    $update_array['written_range_score'] = $written_range_score;
//                    $update_array['written_quota_Score'] = $written_quota_Score;
//                    $update_array['written_percentage'] = $written_percentage;
//                    $update_array['practical_range_score'] = $practical_range_score;
//                    $update_array['practical_quota_Score'] = $practical_quota_Score;
//                    $update_array['practical_percentage'] = $practical_percentage;
//                elseif ($written === 'on' && $practical !== 'on') :
//                    $exam_type = '1';
//                    $written_range_score = $this->input->post('written_range_score', true);
//                    $written_quota_Score = $this->input->post('written_quota_Score', true);
//                    $written_percentage = $this->input->post('written_percentage', true);
//                    $update_array['exam_type'] = $exam_type;
//                    $update_array['written_range_score'] = $written_range_score;
//                    $update_array['written_quota_Score'] = $written_quota_Score;
//                    $update_array['written_percentage'] = $written_percentage;
//                    $update_array['practical_range_score'] = null;
//                    $update_array['practical_quota_Score'] = null;
//                    $update_array['practical_percentage'] = null;
//                elseif ($written !== 'on' && $practical === 'on') :
//                    $exam_type = '2';
//                    $practical_range_score = $this->input->post('practical_range_score', true);
//                    $practical_quota_Score = $this->input->post('practical_quota_Score', true);
//                    $practical_percentage = $this->input->post('practical_percentage', true);
//                    $update_array['exam_type'] = $exam_type;
//                    $update_array['practical_range_score'] = $practical_range_score;
//                    $update_array['practical_quota_Score'] = $practical_quota_Score;
//                    $update_array['practical_percentage'] = $practical_percentage;
//                    $update_array['written_range_score'] = null;
//                    $update_array['written_quota_Score'] = null;
//                    $update_array['written_percentage'] = null;
//                else:
//                    $exam_type = '0';
//                    $update_array['written_range_score'] = null;
//                    $update_array['written_quota_Score'] = null;
//                    $update_array['written_percentage'] = null;
//                    $update_array['practical_range_score'] = null;
//                    $update_array['practical_quota_Score'] = null;
//                    $update_array['practical_percentage'] = null;
//                endif;
				$this->base->update('lessons', array('lesson_id' => $lesson_id, 'academy_id' => $academy_id), $update_array);
				$this->session->set_flashdata('success-update', 'ویرایش درس با موفقیت انجام شد.');
				redirect('training/manage-lessons', 'refresh');
			}
		}else {
			$this->edit_lesson();
		}
	}

	public function delete_lesson() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$lesson_id = $this->input->post('lesson_id', true);
			$this->base->delete_data('lessons', array('lesson_id' => $lesson_id, 'academy_id' => $academy_id));
			$this->session->set_flashdata('success-insert', 'درس مورد نظر حذف گردید.');
			redirect('training/manage-lessons', 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}


	public function default_test() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['default_test'] = $this->base->get_data('default_test', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'default-test';
			$headerData['links'] = 'data-table-links';
			$footerData['scripts'] = 'financial-data-table-scripts';
			$this->show_pages($title = 'درس ها، آزمون پیشفرض', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}


	public function create_new_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
			$contentData['employers'] = $this->base->get_data('employers', '*', array('employee_activated' => 1, 'academy_id' => $academy_id));
			$contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'create-new-course';
			$headerData['links'] = 'custom-select-links';
			$footerData['scripts'] = 'custom-select-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$headerData['thirdLinks'] = 'dropify-links';
			$footerData['thirdScripts'] = 'dropify-scripts';
			$this->show_pages($title = 'مدیریت دوره ها، تعریف دوره جدید', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function insert_new_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {

			$this->form_validation->set_rules('course_name', 'نام دوره', 'required|max_length[80]');
			$this->form_validation->set_rules('employee_id', 'استاد دوره', 'required');
			$this->form_validation->set_rules('course_duration', 'مدت زمان دوره', 'required|max_length[6]|numeric');
			$this->form_validation->set_rules('time_meeting', 'زمان هر جلسه', 'required|max_length[6]|numeric');
			$this->form_validation->set_rules('start_date', 'تاریخ شروع', 'required');

			$this->form_validation->set_message('required', '%s را وارد نمایید');
			$this->form_validation->set_message('max_length', 'طول %s بیش از حد مجاز است');
			$this->form_validation->set_message('numeric', '%s باید به صورت عدد وارد شود');

			if ($this->form_validation->run() === TRUE) {
				$academy_id = $this->session->userdata('academy_id', true);
				$lesson_id = $this->input->post('course_name', true);
				$lesson = $this->base->get_data('lessons', 'standard_id', ['lesson_id' => $lesson_id, 'academy_id' => $academy_id]);
				$course_duration = $this->input->post('course_duration', true);
				$employee_id = $this->input->post('employee_id', true);
				$class_id = $this->input->post('class_id', true);
				$start_date = strtr($this->input->post('start_date', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
				$time_meeting = $this->input->post('time_meeting');
				$capacity = $this->input->post('capacity', true);
				$description = $this->input->post('description', true);
				$type_gender = $this->input->post('type_gender', true);
				$type_holding = $this->input->post('type_holding', true);
				$display_request = $this->input->post('display_request', true);

				$employer = $this->base->get_data('employers', 'national_code', array('employee_id' => $employee_id));
				require_once 'jdf.php';
				$created_on = jdate('H:i:s - Y/n/j');
				$insert_array['created_on'] = $created_on;
				$insert_array['academy_id'] = $academy_id;
				$insert_array['lesson_id'] = $lesson_id;
				$insert_array['standard_id'] = $lesson[0]->standard_id;
				$insert_array['course_duration'] = $course_duration;
				$insert_array['course_master'] = $employer[0]->national_code;
				$insert_array['class_id'] = $class_id;
				$insert_array['time_meeting'] = $time_meeting;
				$insert_array['time_total'] = $time_meeting;
				$insert_array['capacity'] = $capacity;
				$insert_array['start_date'] = $start_date;
				$insert_array['course_description'] = $description;
				$insert_array['type_gender'] = $type_gender;
				$insert_array['type_holding'] = $type_holding;
				if($display_request == 'on')
				$insert_array['display_status_in_system'] = '1';
				if($type_holding == '1'){
					$detail_online['user']= 'null';
					$detail_online['pass']= 'null';
					$detail_online['link_teacher']= 'null';
					$detail_online['link_student']= 'null';
					$detail_online = json_encode($detail_online);
					$insert_array['detail_online'] = $detail_online;
				}


//ذخیره تاریخ شمسی به صورت میلادی
//$insert_array['start_date'] = $this->calc->jalali_to_gregorian($start_date);

				$type_course = $this->input->post('type_course', true);
				$insert_array['type_course'] = $type_course;
				if ($type_course === '0'):
					$course_tuition = $this->input->post('course_tuition', true);
					if ($course_tuition === '') {
						$var['error'] = 'لطفا شهریه دوره را وارد کنید';
						$all_var['var'][] = $var;
					} else
						$insert_array['course_tuition'] = $course_tuition;
				elseif ($type_course === '1'):
					$type_tuition = $this->input->post('type_tuition', true);
					$insert_array['type_tuition'] = $type_tuition;
					if ($type_tuition === '0'):
						$value_tuition_clock = $this->input->post('value_tuition_clock', true);
						if ($value_tuition_clock === '') {
							$var['error'] = 'شهریه کارآموز از نوع ساعتی انتخاب شده است لطفا مقدار آن را وارد کنید';
							$all_var['var'][] = $var;
						} else
							$insert_array['course_tuition'] = $value_tuition_clock;
					elseif ($type_tuition === '1'):
						$value_tuition_course = $this->input->post('value_tuition_course', true);
						if ($value_tuition_course === '') {
							$var['error'] = 'شهریه کارآموز از نوع دوره ای انتخاب شده است لطفا مقدار آن را وارد کنید';
							$all_var['var'][] = $var;
						} else
							$insert_array['course_tuition'] = $value_tuition_course;
					endif;
				endif;

				$type_pay = $this->input->post('type_pay', true);
				$insert_array['type_pay'] = $type_pay;
				if ($type_pay === '0' || $type_pay === '1'):
					$value_pay = $this->input->post('value_pay');
					if ($value_pay === '') {
						$var['error'] = 'درصد یا مبلغ هر ساعت را وارد کنید';
						$all_var['var'][] = $var;
					} else
						$insert_array['value_pay'] = $value_pay;
				elseif ($type_pay === '2'):
					$insert_array['value_pay'] = null;
				endif;

				$sat = $this->input->post('sat_check', true);
				$sun = $this->input->post('sun_check', true);
				$mon = $this->input->post('mon_check', true);
				$tue = $this->input->post('tue_check', true);
				$wed = $this->input->post('wed_check', true);
				$thu = $this->input->post('thu_check', true);
				$fri = $this->input->post('fri_check', true);

				if ($sat || $sun || $mon || $tue || $wed || $thu || $fri === 'on') {

					if ($sat === 'on') {
						$sat_status = '1';
						$sat_clock = $this->input->post('sat_clock', true);
						if ($sat_clock === '') {
							$var['error'] = 'زمان روز شنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['sat_status'] = $sat_status;
							$insert_array['sat_clock'] = $sat_clock;
						}
					}

					if ($sun === 'on') {
						$sun_status = '1';
						$sun_clock = $this->input->post('sun_clock', true);
						if ($sun_clock === '') {
							$var['error'] = 'زمان روز یکشنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['sun_status'] = $sun_status;
							$insert_array['sun_clock'] = $sun_clock;
						}
					}

					if ($mon === 'on') {
						$mon_status = '1';
						$mon_clock = $this->input->post('mon_clock', true);
						if ($mon_clock === '') {
							$var['error'] = 'زمان روز دوشنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['mon_status'] = $mon_status;
							$insert_array['mon_clock'] = $mon_clock;
						}
					}

					if ($tue === 'on') {
						$tue_status = '1';
						$tue_clock = $this->input->post('tue_clock', true);
						if ($tue_clock === '') {
							$var['error'] = 'زمان روز سه شنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['tue_status'] = $tue_status;
							$insert_array['tue_clock'] = $tue_clock;
						}
					}

					if ($wed === 'on') {
						$wed_status = '1';
						$wed_clock = $this->input->post('wed_clock', true);
						if ($wed_clock === '') {
							$var['error'] = 'زمان روز چهارشنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['wed_status'] = $wed_status;
							$insert_array['wed_clock'] = $wed_clock;
						}
					}

					if ($thu === 'on') {
						$thu_status = '1';
						$thu_clock = $this->input->post('thu_clock', true);
						if ($thu_clock === '') {
							$var['error'] = 'زمان روز پنجشنبه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['thu_status'] = $thu_status;
							$insert_array['thu_clock'] = $thu_clock;
						}
					}

					if ($fri === 'on') {
						$fri_status = '1';
						$fri_clock = $this->input->post('fri_clock', true);
						if ($fri_clock === '') {
							$var['error'] = 'زمان روز جمعه وارد نشده است';
							$all_var['var'][] = $var;
						} else {
							$insert_array['fri_status'] = $fri_status;
							$insert_array['fri_clock'] = $fri_clock;
						}
					}

					if (!empty($all_var['var'])) {
						$this->session->set_flashdata($all_var);
						$this->create_new_course();
					} else {

						//=====================================================================================

						require_once 'jdf.php';
						// جداکردن روز و ماه و سال از تاریخ شمسی
						$array = explode('-', $start_date);
						$start_year = $array[0];
						$start_month = $array[1];
						$start_day = $sat_start_day = $sun_start_day = $mon_start_day = $tue_start_day = $wed_start_day = $thu_start_day = $fri_start_day = $array[2];

//        echo '<br>' . jmktime(0, 0, 0, $start_month, $start_day, $start_year);
//        echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
//        echo '<br>' . jmktime($hours, $minute, 0, $start_month, $start_day, $start_year);
						// تعداد جلسات دوره بر اساس مدت زمان دوره و زمان هر جلسه
						(int) $number_of_meeting = ($course_duration * 60) / $time_meeting;
//        echo '<br>تعداد جلسات: ' . (int) $number_of_meeting;
						// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
						$num_day = jdate("N", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
						$num_day = strtr($num_day, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
						$startDAY = '0';
						if ($sat === 'on') {
							$sat_text = '7';
							if ($sat_text === $num_day) {
								$startDAY = $sat_text;
							}
						}
						if ($sun === 'on') {
							$sun_text = '1';
							if ($sun_text === $num_day) {
								$startDAY = $sun_text;
							}
						}
						if ($mon === 'on') {
							$mon_text = '2';
							if ($mon_text === $num_day) {
								$startDAY = $mon_text;
							}
						}
						if ($tue === 'on') {
							$tue_text = '3';
							if ($tue_text === $num_day) {
								$startDAY = $tue_text;
							}
						}
						if ($wed === 'on') {
							$wed_text = '4';
							if ($wed_text === $num_day) {
								$startDAY = $wed_text;
							}
						}
						if ($thu === 'on') {
							$thu_text = '5';
							if ($thu_text === $num_day) {
								$startDAY = $thu_text;
							}
						}
						if ($fri === 'on') {
							$fri_text = '6';
							if ($fri_text === $num_day) {
								$startDAY = $fri_text;
							}
						}
						if ($startDAY === '0')
						{
							$this->session->set_flashdata('start-date', 'تاریخ شروع دوره با هیچکدام از روزهای انتخاب شده هماهنگی ندارد');
							$this->create_new_course();
						}
						else
						{
							$num_meeting = 0;
							$countDay = 0;
							$firstDay = 'false';
							while ($num_meeting !== (int) $number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
								// روزهای برگزاری دوره
								//                                                                                  شنبه
								if ($sat === 'on') {
									// جدا کردن ساعت و دقیقه
									$satTime = explode(':', $sat_clock);
									(int)$sat_hours = $satTime[0];
									(int)$sat_minute = $satTime[1];
									//تبدیل ساعت شروع روز شنبه به ثانیه
									(int)$sat_start_time = ($sat_hours * 60 * 60) + ($sat_minute * 60);
									//تبدیل ساعت پایان روز شنبه به ثانیه
									(int)$sat_end_time = $sat_start_time + ($time_meeting * 60);

									if ($startDAY === $sat_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week1['sat'] = $sat_start_time + $miladiTime;
										$data['week1'][] = $week1;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $sat_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $sat_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week1['sat'] = $sat_start_time + $miladiTime;
										$data['week1'][] = $week1;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$sun_start_day = $sat_start_day + 1;
								} else {
									if ($countDay > 0)
										$sun_start_day = $sat_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  یکشنبه
								if ($sun === 'on') {
									// جدا کردن ساعت و دقیقه
									$sunTime = explode(':', $sun_clock);
									(int)$sun_hours = $sunTime[0];
									(int)$sun_minute = $sunTime[1];
									//تبدیل ساعت شروع روز یکشنبه به ثانیه
									(int)$sun_start_time = ($sun_hours * 60 * 60) + ($sun_minute * 60);
									//تبدیل ساعت پایان روز یکشنبه به ثانیه
									(int)$sun_end_time = $sun_start_time + ($time_meeting * 60);

									if ($startDAY === $sun_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week2['sun'] = $sun_start_time + $miladiTime;
										$data['week2'][] = $week2;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $sun_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $sun_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week2['sun'] = $sun_start_time + $miladiTime;
										$data['week2'][] = $week2;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$mon_start_day = $sun_start_day + 1;
								} else {
									if ($countDay > 0)
										$mon_start_day = $sun_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  دوشنبه
								if ($mon === 'on') {
									// جدا کردن ساعت و دقیقه
									$monTime = explode(':', $mon_clock);
									(int)$mon_hours = $monTime[0];
									(int)$mon_minute = $monTime[1];
									//تبدیل ساعت شروع روز دوشنبه به ثانیه
									(int)$mon_start_time = ($mon_hours * 60 * 60) + ($mon_minute * 60);
									//تبدیل ساعت پایان روز دوشنبه به ثانیه
									(int)$mon_end_time = $mon_start_time + ($time_meeting * 60);

									if ($startDAY === $mon_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week3['mon'] = $mon_start_time + $miladiTime;
										$data['week3'][] = $week3;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $mon_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $mon_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week3['mon'] = $mon_start_time + $miladiTime;
										$data['week3'][] = $week3;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$tue_start_day = $mon_start_day + 1;
								} else {
									if ($countDay > 0)
										$tue_start_day = $mon_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  سه شنبه
								if ($tue === 'on') {
									// جدا کردن ساعت و دقیقه
									$tueTime = explode(':', $tue_clock);
									(int)$tue_hours = $tueTime[0];
									(int)$tue_minute = $tueTime[1];
									//تبدیل ساعت شروع روز سه شنبه به ثانیه
									(int)$tue_start_time = ($tue_hours * 60 * 60) + ($tue_minute * 60);
									//تبدیل ساعت پایان روز سه شنبه به ثانیه
									(int)$tue_end_time = $tue_start_time + ($time_meeting * 60);

									if ($startDAY === $tue_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week4['tue'] = $tue_start_time + $miladiTime;
										$data['week4'][] = $week4;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $tue_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $tue_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week4['tue'] = $tue_start_time + $miladiTime;
										$data['week4'][] = $week4;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$wed_start_day = $tue_start_day + 1;
								} else {
									if ($countDay > 0)
										$wed_start_day = $tue_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  چهارشنبه
								if ($wed === 'on') {
									// جدا کردن ساعت و دقیقه
									$wedTime = explode(':', $wed_clock);
									(int)$wed_hours = $wedTime[0];
									(int)$wed_minute = $wedTime[1];
									//تبدیل ساعت شروع روز چهارشنبه به ثانیه
									(int)$wed_start_time = ($wed_hours * 60 * 60) + ($wed_minute * 60);
									//تبدیل ساعت پایان روز چهارشنبه به ثانیه
									(int)$wed_end_time = $wed_start_time + ($time_meeting * 60);

									if ($startDAY === $wed_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week5['wed'] = $wed_start_time + $miladiTime;
										$data['week5'][] = $week5;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $wed_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $wed_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week5['wed'] = $wed_start_time + $miladiTime;
										$data['week5'][] = $week5;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$thu_start_day = $wed_start_day + 1;
								} else {
									if ($countDay > 0)
										$thu_start_day = $wed_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  پنجشنبه
								if ($thu === 'on') {
									// جدا کردن ساعت و دقیقه
									$thuTime = explode(':', $thu_clock);
									(int)$thu_hours = $thuTime[0];
									(int)$thu_minute = $thuTime[1];
									//تبدیل ساعت شروع روز پنجشنبه به ثانیه
									(int)$thu_start_time = ($thu_hours * 60 * 60) + ($thu_minute * 60);
									//تبدیل ساعت پایان روز پنجشنبه به ثانیه
									(int)$thu_end_time = $thu_start_time + ($time_meeting * 60);

									if ($startDAY === $thu_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week6['thu'] = $thu_start_time + $miladiTime;
										$data['week'][] = $week6;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>' . 'جلسه' . $num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $thu_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $thu_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week6['thu'] = $thu_start_time + $miladiTime;
										$data['week6'][] = $week6;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$fri_start_day = $thu_start_day + 1;
								} else {
									if ($countDay > 0)
										$fri_start_day = $thu_start_day + 1;
								}

								if ($num_meeting === (int) $number_of_meeting)
									break;

								//                                                                                  جمعه
								if ($fri === 'on') {
									// جدا کردن ساعت و دقیقه
									$friTime = explode(':', $fri_clock);
									(int)$fri_hours = $friTime[0];
									(int)$fri_minute = $friTime[1];
									//تبدیل ساعت شروع روز جمعه به ثانیه
									(int)$fri_start_time = ($fri_hours * 60 * 60) + ($fri_minute * 60);
									//تبدیل ساعت پایان روز جمعه به ثانیه
									(int)$fri_end_time = $fri_start_time + ($time_meeting * 60);

									if ($startDAY === $fri_text) {
										$countDay++;
									}

									if ($countDay === 0) {

									} elseif ($countDay === 1 && $firstDay == 'false') {
										$num_meeting++;
										$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week7['fri'] = $fri_start_time + $miladiTime;
										$data['week7'][] = $week7;
										$result['data'] = $data;
									} elseif ($num_meeting != 0) {
										$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $fri_start_day, $start_year));
										$d = $start_year . '-' . $start_month . '-' . $fri_start_day;
										$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
										$week7['fri'] = $fri_start_time + $miladiTime;
										$data['week7'][] = $week7;
										$result['data'] = $data;
									}

									if ($firstDay === 'true')
										$sat_start_day = $fri_start_day + 1;
								} else {
									if ($countDay > 0)
										$sat_start_day = $fri_start_day + 1;
								}


								if ($num_meeting === (int) $number_of_meeting)
									break;
							}


							if (!empty($result['data']['week1']))
								$res1 = $result['data']['week1'];
							if (!empty($result['data']['week2']))
								$res2 = $result['data']['week2'];
							if (!empty($result['data']['week3']))
								$res3 = $result['data']['week3'];
							if (!empty($result['data']['week4']))
								$res4 = $result['data']['week4'];
							if (!empty($result['data']['week5']))
								$res5 = $result['data']['week5'];
							if (!empty($result['data']['week6']))
								$res6 = $result['data']['week6'];
							if (!empty($result['data']['week7']))
								$res7 = $result['data']['week7'];


							//==========================================================================
							// مقایسه دوره جدید با دوره های استاد مربوطه
							//==========================================================================

							$courses = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', null, null, array('course_master' => $employer[0]->national_code));
							if (!empty($courses)) {
								foreach ($courses as $course){
									$course_id = [];
									$course_id = $course->course_id;
//            echo '<br>کد دوره: ' . $course_id;
									$old_start_date = [];
									$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
									$old_start_year = [];
									$old_start_month = [];
									$old_start_day = [];
									$old_array = [];
									require_once 'jdf.php';
									// جداکردن روز و ماه و سال از تاریخ شمسی
									$old_array = explode('-', $old_start_date);
									$old_start_year = $old_array[0];
									$old_start_month = $old_array[1];
									$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

									$old_time_meeting = $course->time_meeting;
									(int)$old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;

									// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
									$old_num_day = jdate("N", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));
									$old_num_day = strtr($old_num_day, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));

									$old_startDAY = '0';
									$old_sat = $course->sat_status;
									if ($old_sat === '1') {
										$old_sat_text = '7';
										if ($old_sat_text === $old_num_day) {
											$old_startDAY = $old_sat_text;
										}
									}
									$old_sun = $course->sun_status;
									if ($old_sun === '1') {
										$old_sun_text = '1';
										if ($old_sun_text === $old_num_day) {
											$old_startDAY = $old_sun_text;
										}
									}
									$old_mon = $course->mon_status;
									if ($old_mon === '1') {
										$old_mon_text = '2';
										if ($old_mon_text === $old_num_day) {
											$old_startDAY = $old_mon_text;
										}
									}
									$old_tue = $course->tue_status;
									if ($old_tue === '1') {
										$old_tue_text = '3';
										if ($old_tue_text === $old_num_day) {
											$old_startDAY = $old_tue_text;
										}
									}
									$old_wed = $course->wed_status;
									if ($old_wed === '1') {
										$old_wed_text = '4';
										if ($old_wed_text === $old_num_day) {
											$old_startDAY = $old_wed_text;
										}
									}
									$old_thu = $course->thu_status;
									if ($old_thu === '1') {
										$old_thu_text = '5';
										if ($old_thu_text === $old_num_day) {
											$old_startDAY = $old_thu_text;
										}
									}
									$old_fri = $course->fri_status;
									if ($old_fri === '1') {
										$old_fri_text = '6';
										if ($old_fri_text === $old_num_day) {
											$old_startDAY = $old_fri_text;
										}
									}

									$old_num_meeting = 0;
									$old_countDay = 0;
									$old_firstDay = 'false';
									while ($old_num_meeting !== (int)$old_number_of_meeting) {
//										$old_num_meeting++;
										//   echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
										//                                                                   روزهای برگزاری دوره
										//                                                                                  شنبه
										if ($old_sat === '1') {
											$old_sat_clock = $course->sat_clock;
											if(!empty($old_sat_clock)){

												// جدا کردن ساعت و دقیقه
												$old_satTime = explode(':', $old_sat_clock);
												(int)$old_sat_hours = $old_satTime[0];
												(int)$old_sat_minute = $old_satTime[1];
												//تبدیل ساعت شروع روز شنبه به ثانیه
												(int)$old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
												//تبدیل ساعت پایان روز شنبه به ثانیه
												(int)$old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_sat_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

													if ($sat === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sat = $old_sat_start_time + $miladiTime; // start time sat day
														$old_week_sat_end = $old_sat_end_time + $miladiTime; // end time sat day
														if (!empty($res1)) {
															foreach ($res1 as $more) {
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) > $old_week_sat && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
													if ($sat === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sat = $old_sat_start_time + $miladiTime;
														$old_week_sat_end = $old_sat_end_time + $miladiTime;
														if (!empty($res1)) {
															foreach ($res1 as $more) {
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) > $old_week_sat && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_sun_start_day = (int)$old_sat_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_sun_start_day = (int)$old_sat_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  یکشنبه
										if ($old_sun === '1') {
											$old_sun_clock = $course->sun_clock;
											if(!empty($old_sun_clock)){

												// جدا کردن ساعت و دقیقه
												$old_sunTime = explode(':', $old_sun_clock);
												(int)$old_sun_hours = $old_sunTime[0];
												(int)$old_sun_minute = $old_sunTime[1];
												//تبدیل ساعت شروع روز یکشنبه به ثانیه
												(int)$old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
												//تبدیل ساعت پایان روز یکشنبه به ثانیه
												(int)$old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_sun_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($sun === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sun = $old_sun_start_time + $miladiTime;
														$old_week_sun_end = $old_sun_end_time + $miladiTime;
														if (!empty($res2)) {
															foreach ($res2 as $more) {
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) > $old_week_sun && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
													if ($sun === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sun = $old_sun_start_time + $miladiTime;
														$old_week_sun_end = $old_sun_end_time + $miladiTime;
														if (!empty($res2)) {
															foreach ($res2 as $more) {
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) > $old_week_sun && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_mon_start_day = (int)$old_sun_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز یکشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_mon_start_day = (int)$old_sun_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  دوشنبه
										if ($old_mon === '1') {
											$old_mon_clock = $course->mon_clock;
											if(!empty($old_mon_clock)){

												// جدا کردن ساعت و دقیقه
												$old_monTime = explode(':', $old_mon_clock);
												(int)$old_mon_hours = $old_monTime[0];
												(int)$old_mon_minute = $old_monTime[1];
												//تبدیل ساعت شروع روز دوشنبه به ثانیه
												(int)$old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
												//تبدیل ساعت پایان روز دوشنبه به ثانیه
												(int)$old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_mon_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($mon === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_mon = $old_mon_start_time + $miladiTime;
														$old_week_mon_end = $old_mon_end_time + $miladiTime;
														if (!empty($res3)) {
															foreach ($res3 as $more) {
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) > $old_week_mon && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
													if ($mon === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_mon = $old_mon_start_time + $miladiTime;
														$old_week_mon_end = $old_mon_end_time + $miladiTime;
														if (!empty($res3)) {
															foreach ($res3 as $more) {
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] <= $old_week_mon && ($more['mon'] + $time_meeting * 60) > $old_week_mon && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_tue_start_day = (int)$old_mon_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز دوشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_tue_start_day = (int)$old_mon_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting) {
//											echo '<br>' . $old_num_meeting;
											break;
										}

										//                                                                                  سه شنبه
										if ($old_tue === '1') {
											$old_tue_clock = $course->tue_clock;
											if(!empty($old_tue_clock)){

												// جدا کردن ساعت و دقیقه
												$old_tueTime = explode(':', $old_tue_clock);
												(int)$old_tue_hours = $old_tueTime[0];
												(int)$old_tue_minute = $old_tueTime[1];
												//تبدیل ساعت شروع روز سه شنبه به ثانیه
												(int)$old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
												//تبدیل ساعت پایان روز سه شنبه به ثانیه
												(int)$old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_tue_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($tue === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_tue = $old_tue_start_time + $miladiTime;
														$old_week_tue_end = $old_tue_end_time + $miladiTime;
														if (!empty($res4)) {
															foreach ($res4 as $more) {
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) > $old_week_tue && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
													if ($tue === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_tue = $old_tue_start_time + $miladiTime;
														$old_week_tue_end = $old_tue_end_time + $miladiTime;
														if (!empty($res4)) {
															foreach ($res4 as $more) {
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) > $old_week_tue && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
															}
														}
													}
												}
												if ($old_firstDay === 'true')
													(int)$old_wed_start_day = (int)$old_tue_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز سه شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_wed_start_day = (int)$old_tue_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  چهارشنبه
										if ($old_wed === '1') {
											$old_wed_clock = $course->wed_clock;
											if(!empty($old_wed_clock)){

												// جدا کردن ساعت و دقیقه
												$old_wedTime = explode(':', $old_wed_clock);
												(int)$old_wed_hours = $old_wedTime[0];
												(int)$old_wed_minute = $old_wedTime[1];
												//تبدیل ساعت شروع روز چهارشنبه به ثانیه
												(int)$old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
												//تبدیل ساعت پایان روز چهارشنبه به ثانیه
												(int)$old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_wed_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($wed === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_wed = $old_wed_start_time + $miladiTime;
														$old_week_wed_end = $old_wed_end_time + $miladiTime;
														if (!empty($res5)) {
															foreach ($res5 as $more) {
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) > $old_week_wed && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
													if ($wed === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_wed = $old_wed_start_time + $miladiTime;
														$old_week_wed_end = $old_wed_end_time + $miladiTime;
														if (!empty($res5)) {
															foreach ($res5 as $more) {
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) > $old_week_wed && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_thu_start_day = (int)$old_wed_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز چهارشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_thu_start_day = (int)$old_wed_start_day + 1;
										}
										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;
										//                                                                                  پنجشنبه
										if ($old_thu === '1') {
											$old_thu_clock = $course->thu_clock;
											if(!empty($old_thu_clock)){

												// جدا کردن ساعت و دقیقه
												$old_thuTime = explode(':', $old_thu_clock);
												(int)$old_thu_hours = $old_thuTime[0];
												(int)$old_thu_minute = $old_thuTime[1];
												//تبدیل ساعت شروع روز پنجشنبه به ثانیه
												(int)$old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
												//تبدیل ساعت پایان روز پنجشنبه به ثانیه
												(int)$old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_thu_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($thu === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_thu = $old_thu_start_time + $miladiTime;
														$old_week_thu_end = $old_thu_end_time + $miladiTime;
														if (!empty($res6)) {
															foreach ($res6 as $more) {
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) > $old_week_thu && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
													if ($thu === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_thu = $old_thu_start_time + $miladiTime;
														$old_week_thu_end = $old_thu_end_time + $miladiTime;
														if (!empty($res6)) {
															foreach ($res6 as $more) {
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) > $old_week_thu && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_fri_start_day = (int)$old_thu_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز پنج شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_fri_start_day = (int)$old_thu_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting) {
//											echo '<br>' . $old_num_meeting;
											break;
										}

										//                                                                                  جمعه
										if ($old_fri === '1') {
											$old_fri_clock = $course->fri_clock;
											if(!empty($old_fri_clock)){

												// جدا کردن ساعت و دقیقه
												$old_friTime = explode(':', $old_fri_clock);
												(int)$old_fri_hours = $old_friTime[0];
												(int)$old_fri_minute = $old_friTime[1];
												//تبدیل ساعت شروع روز جمعه به ثانیه
												(int)$old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
												//تبدیل ساعت پایان روز جمعه به ثانیه
												(int)$old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_fri_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($fri === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_fri = $old_fri_start_time + $miladiTime;
														$old_week_fri_end = $old_fri_end_time + $miladiTime;
														if (!empty($res7)) {
															foreach ($res7 as $more) {
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) > $old_week_fri && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
													if ($fri === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_fri = $old_fri_start_time + $miladiTime;
														$old_week_fri_end = $old_fri_end_time + $miladiTime;
														if (!empty($res7)) {
															foreach ($res7 as $more) {
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) > $old_week_fri && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																	$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													(int)$old_sat_start_day = (int)$old_fri_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز جمعه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_sat_start_day = (int)$old_fri_start_day + 1;
										}


										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										if (!empty($error['teacher'])) {
											$teacherError['thrError'][] = $error;
											$error['teacher'] = null;
										}
									}
									// end while
								}
								//  end endforeach
							}
							//  end if

							//==========================================================================
							// مقایسه دوره جدید با کلاس مربوطه
							//==========================================================================

							$course_class = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('courses.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.class_id' => $class_id, 'classes.class_id' => $class_id));
							$course_class = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('courses.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.class_id' => $class_id, 'classes.class_id' => $class_id));
							if (!empty($course_class)) {
								foreach ($course_class as $course){
									$course_id = [];
									$course_id = $course->course_id;
//            echo '<br>کد دوره: ' . $course_id;
									$old_start_date = [];
									$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
									$old_start_year = [];
									$old_start_month = [];
									$old_start_day = [];
									$old_array = [];
									require_once 'jdf.php';
									// جداکردن روز و ماه و سال از تاریخ شمسی
									$old_array = explode('-', $old_start_date);
									$old_start_year = $old_array[0];
									$old_start_month = $old_array[1];
									$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

									$old_time_meeting = $course->time_meeting;
									(int)$old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;
									// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
									$old_num_day = jdate("N", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));
									$old_num_day = strtr($old_num_day, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));

									$old_startDAY = '0';
									$old_sat = $course->sat_status;
									if ($old_sat === '1') {
										$old_sat_text = '7';
										if ($old_sat_text === $old_num_day) {
											$old_startDAY = $old_sat_text;
										}
									}
									$old_sun = $course->sun_status;
									if ($old_sun === '1') {
										$old_sun_text = '1';
										if ($old_sun_text === $old_num_day) {
											$old_startDAY = $old_sun_text;
										}
									}
									$old_mon = $course->mon_status;
									if ($old_mon === '1') {
										$old_mon_text = '2';
										if ($old_mon_text === $old_num_day) {
											$old_startDAY = $old_mon_text;
										}
									}
									$old_tue = $course->tue_status;
									if ($old_tue === '1') {
										$old_tue_text = '3';
										if ($old_tue_text === $old_num_day) {
											$old_startDAY = $old_tue_text;
										}
									}
									$old_wed = $course->wed_status;
									if ($old_wed === '1') {
										$old_wed_text = '4';
										if ($old_wed_text === $old_num_day) {
											$old_startDAY = $old_wed_text;
										}
									}
									$old_thu = $course->thu_status;
									if ($old_thu === '1') {
										$old_thu_text = '5';
										if ($old_thu_text === $old_num_day) {
											$old_startDAY = $old_thu_text;
										}
									}
									$old_fri = $course->fri_status;
									if ($old_fri === '1') {
										$old_fri_text = '6';
										if ($old_fri_text === $old_num_day) {
											$old_startDAY = $old_fri_text;
										}
									}

									$old_num_meeting = 0;
									$old_countDay = 0;
									$old_firstDay = 'false';
									while ($old_num_meeting !== $old_number_of_meeting) {

//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
										// روزهای برگزاری دوره
										//                                                                                  شنبه
										if ($old_sat === '1') {
											$old_sat_clock = $course->sat_clock;
											if(!empty($old_sat_clock)){

												// جدا کردن ساعت و دقیقه
												$old_satTime = explode(':', $old_sat_clock);
												(int)$old_sat_hours = $old_satTime[0];
												(int)$old_sat_minute = $old_satTime[1];
												//تبدیل ساعت شروع روز شنبه به ثانیه
												(int)$old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
												//تبدیل ساعت پایان روز شنبه به ثانیه
												(int)$old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_sat_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

													if ($sat === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sat = $old_sat_start_time + $miladiTime;
														$old_week_sat_end = $old_sat_end_time + $miladiTime;
														if (!empty($res1)) {
															foreach ($res1 as $more) {
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) > $old_week_sat && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
													if ($sat === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sat = $old_sat_start_time + $miladiTime;
														$old_week_sat_end = $old_sat_end_time + $miladiTime;
														if (!empty($res1)) {
															foreach ($res1 as $more) {
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] <= $old_week_sat && $more['sat'] + ($time_meeting * 60) > $old_week_sat && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) >= $old_week_sat_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
																if ($more['sat'] >= $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) <= $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_sun_start_day = $old_sat_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_sun_start_day = $old_sat_start_day + 1;
										}

										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										//                                                                                  یکشنبه
										if ($old_sun === '1') {
											$old_sun_clock = $course->sun_clock;
											if(!empty($old_sun_clock)){

												// جدا کردن ساعت و دقیقه
												$old_sunTime = explode(':', $old_sun_clock);
												(int)$old_sun_hours = $old_sunTime[0];
												(int)$old_sun_minute = $old_sunTime[1];
												//تبدیل ساعت شروع روز یکشنبه به ثانیه
												(int)$old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
												//تبدیل ساعت پایان روز یکشنبه به ثانیه
												(int)$old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);
//
												if ($old_startDAY === $old_sun_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($sun === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sun = $old_sun_start_time + $miladiTime;
														$old_week_sun_end = $old_sun_end_time + $miladiTime;
														if (!empty($res2)) {
															foreach ($res2 as $more) {
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) > $old_week_sun && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
													if ($sun === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_sun = $old_sun_start_time + $miladiTime;
														$old_week_sun_end = $old_sun_end_time + $miladiTime;
														if (!empty($res2)) {
															foreach ($res2 as $more) {
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] <= $old_week_sun && $more['sun'] + ($time_meeting * 60) > $old_week_sun && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) >= $old_week_sun_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
																if ($more['sun'] >= $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) <= $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_mon_start_day = $old_sun_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز یکشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_mon_start_day = $old_sun_start_day + 1;
										}

										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										//                                                                                  دوشنبه
										if ($old_mon === '1') {
											$old_mon_clock = $course->mon_clock;
											if(!empty($old_mon_clock)){

												// جدا کردن ساعت و دقیقه
												$old_monTime = explode(':', $old_mon_clock);
												(int)$old_mon_hours = $old_monTime[0];
												(int)$old_mon_minute = $old_monTime[1];
												//تبدیل ساعت شروع روز دوشنبه به ثانیه
												(int)$old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
												//تبدیل ساعت پایان روز دوشنبه به ثانیه
												(int)$old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_mon_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($mon === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_mon = $old_mon_start_time + $miladiTime;
														$old_week_mon_end = $old_mon_end_time + $miladiTime;
														if (!empty($res3)) {
															foreach ($res3 as $more) {
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) > $old_week_mon && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
													if ($mon === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_mon = $old_mon_start_time + $miladiTime;
														$old_week_mon_end = $old_mon_end_time + $miladiTime;
														if (!empty($res3)) {
															foreach ($res3 as $more) {
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] <= $old_week_mon && $more['mon'] + ($time_meeting * 60) > $old_week_mon && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) >= $old_week_mon_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
																if ($more['mon'] >= $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) <= $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_tue_start_day = $old_mon_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز دوشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_tue_start_day = $old_mon_start_day + 1;
										}

										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										//                                                                                  سه شنبه
										if ($old_tue === '1') {
											$old_tue_clock = $course->tue_clock;
											if(!empty($old_tue_clock)){

												// جدا کردن ساعت و دقیقه
												$old_tueTime = explode(':', $old_tue_clock);
												(int)$old_tue_hours = $old_tueTime[0];
												(int)$old_tue_minute = $old_tueTime[1];
												//تبدیل ساعت شروع روز سه شنبه به ثانیه
												(int)$old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
												//تبدیل ساعت پایان روز سه شنبه به ثانیه
												(int)$old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_tue_text) {
													$old_countDay++;
												}


												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($tue === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_tue = $old_tue_start_time + $miladiTime;
														$old_week_tue_end = $old_tue_end_time + $miladiTime;
														if (!empty($res4)) {
															foreach ($res4 as $more) {
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) > $old_week_tue && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
													if ($tue === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_tue = $old_tue_start_time + $miladiTime;
														$old_week_tue_end = $old_tue_end_time + $miladiTime;
														if (!empty($res4)) {
															foreach ($res4 as $more) {
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] <= $old_week_tue && $more['tue'] + ($time_meeting * 60) > $old_week_tue && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) >= $old_week_tue_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
																if ($more['tue'] >= $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) <= $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
																}
															}
														}
													}
												}
												if ($old_firstDay === 'true')
													$old_wed_start_day = $old_tue_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز سه شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_wed_start_day = $old_tue_start_day + 1;
										}

										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										//                                                                                  چهارشنبه
										if ($old_wed === '1') {
											$old_wed_clock = $course->wed_clock;
											if(!empty($old_wed_clock)){

												// جدا کردن ساعت و دقیقه
												$old_wedTime = explode(':', $old_wed_clock);
												(int)$old_wed_hours = $old_wedTime[0];
												(int)$old_wed_minute = $old_wedTime[1];
												//تبدیل ساعت شروع روز چهارشنبه به ثانیه
												(int)$old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
												//تبدیل ساعت پایان روز چهارشنبه به ثانیه
												(int)$old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_wed_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($wed === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_wed = $old_wed_start_time + $miladiTime;
														$old_week_wed_end = $old_wed_end_time + $miladiTime;
														if (!empty($res5)) {
															foreach ($res5 as $more) {
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) > $old_week_wed && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
													if ($wed === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_wed = $old_wed_start_time + $miladiTime;
														$old_week_wed_end = $old_wed_end_time + $miladiTime;
														if (!empty($res5)) {
															foreach ($res5 as $more) {
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] <= $old_week_wed && $more['wed'] + ($time_meeting * 60) > $old_week_wed && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) >= $old_week_wed_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
																if ($more['wed'] >= $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) <= $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_thu_start_day = $old_wed_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز چهارشنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_thu_start_day = $old_wed_start_day + 1;
										}
										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;
										//                                                                                  پنجشنبه
										if ($old_thu === '1') {
											$old_thu_clock = $course->thu_clock;
											if(!empty($old_thu_clock)){

												// جدا کردن ساعت و دقیقه
												$old_thuTime = explode(':', $old_thu_clock);
												(int)$old_thu_hours = $old_thuTime[0];
												(int)$old_thu_minute = $old_thuTime[1];
												//تبدیل ساعت شروع روز پنجشنبه به ثانیه
												(int)$old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
												//تبدیل ساعت پایان روز پنجشنبه به ثانیه
												(int)$old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_thu_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($thu === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_thu = $old_thu_start_time + $miladiTime;
														$old_week_thu_end = $old_thu_end_time + $miladiTime;
														if (!empty($res6)) {
															foreach ($res6 as $more) {
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) > $old_week_thu && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
													if ($thu === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_thu = $old_thu_start_time + $miladiTime;
														$old_week_thu_end = $old_thu_end_time + $miladiTime;
														if (!empty($res6)) {
															foreach ($res6 as $more) {
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] <= $old_week_thu && $more['thu'] + ($time_meeting * 60) > $old_week_thu && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) >= $old_week_thu_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
																if ($more['thu'] >= $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) <= $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_fri_start_day = $old_thu_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز پنج شنبه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_fri_start_day = $old_thu_start_day + 1;
										}

										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										//                                                                                  جمعه
										if ($old_fri === '1') {
											$old_fri_clock = $course->fri_clock;
											if(!empty($old_fri_clock)){

												// جدا کردن ساعت و دقیقه
												$old_friTime = explode(':', $old_fri_clock);
												(int)$old_fri_hours = $old_friTime[0];
												(int)$old_fri_minute = $old_friTime[1];
												//تبدیل ساعت شروع روز جمعه به ثانیه
												(int)$old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
												//تبدیل ساعت پایان روز جمعه به ثانیه
												(int)$old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

												if ($old_startDAY === $old_fri_text) {
													$old_countDay++;
												}

												if ($old_countDay === 0) {

												} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
													$old_num_meeting++;
													$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
													if ($fri === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_fri = $old_fri_start_time + $miladiTime;
														$old_week_fri_end = $old_fri_end_time + $miladiTime;
														if (!empty($res7)) {
															foreach ($res7 as $more) {
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) > $old_week_fri && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
															}
														}
													}
												} elseif ($old_num_meeting != 0) {
													$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
													if ($fri === 'on') {
														$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
														$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
														$old_week_fri = $old_fri_start_time + $miladiTime;
														$old_week_fri_end = $old_fri_end_time + $miladiTime;
														if (!empty($res7)) {
															foreach ($res7 as $more) {
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] <= $old_week_fri && $more['fri'] + ($time_meeting * 60) > $old_week_fri && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) >= $old_week_fri_end) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
																if ($more['fri'] >= $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) <= $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																	$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
																}
															}
														}
													}
												}

												if ($old_firstDay === 'true')
													$old_sat_start_day = $old_fri_start_day + 1;
											}else{
												$empty_clock_error = 'ساعت روز جمعه در دوره با کد '.$course_id.' ذخیره نشده است.';
												break;
											}
										} else {
											if ($old_countDay > 0)
												$old_sat_start_day = $old_fri_start_day + 1;
										}


										if ($old_num_meeting === (int) $old_number_of_meeting)
											break;

										if (!empty($error['class'])) {
											$classError['classError'][] = $error;
											$error['class'] = null;
										}
									}
									//  end while
								}
								//  end foreach
							}
							// end if


							if (empty($teacherError) && empty($classError) && empty($empty_clock_error)) {

//                             upload pic
								$result_of_upload = $this->course_upload($_FILES);
								$insert_array['course_pic'] = $result_of_upload['final_image_name'];

								$last_id = $this->base->insert('courses', $insert_array);
								$course_employer = array(
									'course_id' => $last_id,
									'lesson_id' => $lesson_id,
									'academy_id' => $academy_id,
									'employee_nc' => $employer[0]->national_code,
									'employee_id' => $employee_id
								);
								$this->base->insert('courses_employers', $course_employer);

								$academys_option = $this->base->get_data('academys_option', 'number_of_course', array('academy_id' => $academy_id));
								$this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_course' => $academys_option[0]->number_of_course + 1));

								///////////////پیامک استاد\\\\\\\\\\\\\\\
								$employee = $this->base->get_data('employers', 'first_name,last_name,phone_num', array('national_code' => $employer[0]->national_code, 'academy_id' => $academy_id));
								$lesson = $this->base->get_data('lessons', 'lesson_name', array('lesson_id' => $lesson_id, 'academy_id' => $academy_id));
								$full_name = $employee[0]->first_name . " " . $employee[0]->last_name;
								$phone_num = $employee[0]->phone_num;
								$course = $lesson[0]->lesson_name;
								$teacherDName = $this->session->userdata('teacherDName');

								$name = $teacherDName . " گرامی " . $full_name;
								$this->smsForTeacherCreateNewCourse($phone_num, $name, $course);
								$message = $name . " دوره " . $course . " با تدریس جنابعالی ایجاد گردید.";
								$insertArray = array('mss_body' => $message, 'employee_nc' => $employer[0]->national_code, 'manager_nc' => $sessId, 'academy_id' => $academy_id);

								$this->base->insert('manager_employee_sms', $insertArray);
								/////////////////پیامک استاد////////////////

								/////////////////پیامک مدیریت\\\\\\\\\\\\\\\
								$tell = $this->session->userdata('phone_num');
								$this->smsForManagerCreateNewCourse($tell, $course);
								/////////////////پیامک مدیریت////////////////

								///////////////// پیامک ادمین جهت دوره آنلاین \\\\\\\\\\\\\\\
								if($type_holding == '1'){
									$this->smsForAdminCourseOnline($academy_id, $last_id, $created_on);
								}
								///////////////// پیامک ادمین جهت دوره آنلاین ////////////////

								echo "
                        <script type=\"text/javascript\">
                            sessionStorage . clear();
                        </script>
                    ";


								$this->session->set_flashdata('success-insert', 'ثبت دوره جدید با موفقیت انجام شد.');
								redirect('https://amoozkadeh.com/add_room_teacher');

//								echo '<br>successful';
							} else {
								if (!empty($teacherError))
									$this->session->set_flashdata($teacherError);
								if (!empty($classError))
									$this->session->set_flashdata($classError);
								if (!empty($empty_clock_error))
									$this->session->set_flashdata('empty_clock_error', $empty_clock_error);
								$this->create_new_course();
							}
						}
					}
				} else {
					$this->session->set_flashdata('start-date', 'هیچ روزی برای برگزاری دوره انتخاب نشده است.');
					$this->create_new_course();
				}
			} else {
				$this->create_new_course();
			}
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function smsForAdminCourseOnline($academy_id, $last_id, $created_on){
		$admin = $this->base->get_data('admin', 'phone_num', array('status_for_sms_activation' => '1'));
		$phone_num = $admin[0]->phone_num;
		$username = "mehritc";
		$password = '@utabpars1219';
		$from = "+983000505";
		$pattern_code = "sj6ejp5qta";
		$to = array($phone_num);
		$input_data = array("academy" => "$academy_id", "course" => $last_id, "type" => "آنلاین", "time" => $created_on);
//        $url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
		$url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$verify_code = curl_exec($handler);
		return true;
	}

	public function smsForTeacherCreateNewCourse($phone_num, $name, $course) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {

			$academy_name = $this->session->userdata('academy_name');
			$academyDName = $this->session->userdata('academyDName');
			$academy = $academyDName . " " . $academy_name;

			$username = "mehritc";
			$password = '@utabpars1219';
			$from = "+983000505";
			$pattern_code = "f46ortsd0g";
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
			redirect('training/error-403', 'refresh');
		}
	}

	public function smsForManagerCreateNewCourse($phone_num, $course) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {

			$academy_name = $this->session->userdata('academy_name');
			$academyDName = $this->session->userdata('academyDName');
			$academy = $academyDName . " " . $academy_name;

			$username = "mehritc";
			$password = '@utabpars1219';
			$from = "+983000505";
			$pattern_code = "pwzo456wxk";
			$to = array($phone_num);
			$input_data = array(
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
			redirect('training/error-403', 'refresh');
		}
	}

	public function manage_courses() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['courses_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id), 'courses.course_id');
			$contentData['attendance'] = $this->base->get_data('attendance', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'manage-courses';
			$headerData['Links'] = 'persian-calendar-links';
			$footerData['Scripts'] = 'persian-calendar-scripts';
			$this->show_pages('مدیریت دوره ها', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function manage_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['courses_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id), 'courses.course_id');
			$contentData['attendance'] = $this->base->get_data('attendance', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'manage-courses';
			$headerData['Links'] = 'persian-calendar-links';
			$footerData['Scripts'] = 'persian-calendar-scripts';
			$this->session->set_flashdata('course_active','ok');
			$this->show_pages('مدیریت دوره ها', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function edit_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course_id = $this->input->post('course_id', true);
			$contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
			$contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
			$contentData['employers'] = $this->base->get_data('employers', '*', array('employee_activated' => 1, 'academy_id' => $academy_id));
			$contentData['attendance'] = $this->base->get_data('attendance', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
			$course_info = $contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $course_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
			$start_date = $course_info[0]->start_date;
			$contentData['start_date'] = strtr($start_date, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
			$contentData['yield'] = 'edit-course';
			$headerData['links'] = 'custom-select-links';
			$footerData['scripts'] = 'custom-select-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$headerData['thirdLinks'] = 'dropify-links';
			$footerData['thirdScripts'] = 'dropify-scripts';
			$this->show_pages('ویرایش دوره', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function update_course() {
		$this->form_validation->set_rules('course_duration', 'مدت زمان دوره', 'required|max_length[6]|numeric');
		$this->form_validation->set_rules('time_meeting', 'زمان هر جلسه', 'required|max_length[6]|numeric');
		$this->form_validation->set_rules('start_date', 'تاریخ شروع', 'required|max_length[10]');

		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('max_length', 'طول %s بیش از حد مجاز است');
		$this->form_validation->set_message('numeric', '%s باید به صورت عدد وارد شود');

		if ($this->form_validation->run() === TRUE) {
			$academy_id = $this->session->userdata('academy_id', true);
			$course_id = $this->input->post('course_id', true);
			$employee_id = $this->input->post('employee_id', true);
			$time_meeting = $this->input->post('time_meeting', true);
			$class_id = $this->input->post('class_id', true);
			$course_name = $this->input->post('course_name', true);
			$course_duration = $this->input->post('course_duration', true);
			$course_desc = $this->input->post('description', true);
			$capacity = $this->input->post('capacity', true);
			$start_date = $this->input->post('start_date', true);
			$start_date = strtr($start_date, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
			$type_gender = $this->input->post('type_gender', true);
			$type_holding = $this->input->post('type_holding', true);
			$display_request = $this->input->post('display_request', true);

			$employer = $this->base->get_data('employers', 'national_code', array('employee_id' => $employee_id));
			$insert_array['course_master'] = $employer[0]->national_code;
			$insert_array['time_meeting'] = $time_meeting;
			$insert_array['class_id'] = $class_id;
			$insert_array['lesson_id'] = $course_name;
			$insert_array['course_duration'] = $course_duration;
			$insert_array['course_description'] = $course_desc;
			$insert_array['capacity'] = $capacity;
			$insert_array['start_date'] = $start_date;
			$insert_array['type_gender'] = $type_gender;
			$insert_array['type_holding'] = $type_holding;
			$course_info = $this->base->get_data('courses','display_status_in_system', array('course_id' => $course_id, 'academy_id' => $academy_id,));
			if($course_info[0]->display_status_in_system == '1' || $course_info[0]->display_status_in_system == '0'):
				if($display_request == 'on')
					$insert_array['display_status_in_system'] = '1';
				else
					$insert_array['display_status_in_system'] = '0';
			else:
				if($display_request == 'on')
					$insert_array['display_status_in_system'] = '2';
				else
					$insert_array['display_status_in_system'] = '0';
			endif;
			if($type_holding == '1'){
				$detail_online['user']= 'null';
				$detail_online['pass']= 'null';
				$detail_online['link_teacher']= 'null';
				$detail_online['link_student']= 'null';
				$detail_online = json_encode($detail_online);
				$insert_array['detail_online'] = $detail_online;
			}elseif($type_holding == '0'){
				$detail_online= null;
			}

			$type_course = $this->input->post('type_course', true);
			$insert_array['type_course'] = $type_course;
			if ($type_course === '0'):
				$course_tuition = $this->input->post('course_tuition', true);
				if ($course_tuition === '') {
					$var['error'] = 'لطفا شهریه دوره را وارد کنید';
					$all_var['var'][] = $var;
				} else
					$insert_array['course_tuition'] = $course_tuition;
			elseif ($type_course === '1'):
				$type_tuition = $this->input->post('type_tuition', true);
				$insert_array['type_tuition'] = $type_tuition;
				if ($type_tuition === '0'):
					$value_tuition_clock = $this->input->post('value_tuition_clock', true);
					if ($value_tuition_clock === '') {
						$var['error'] = 'شهریه کارآموز از نوع ساعتی انتخاب شده است لطفا مقدار آن را وارد کنید';
						$all_var['var'][] = $var;
					} else
						$insert_array['course_tuition'] = $value_tuition_clock;
				elseif ($type_tuition === '1'):
					$value_tuition_course = $this->input->post('value_tuition_course', true);
					if ($value_tuition_course === '') {
						$var['error'] = 'شهریه کارآموز از نوع دوره ای انتخاب شده است لطفا مقدار آن را وارد کنید';
						$all_var['var'][] = $var;
					} else
						$insert_array['course_tuition'] = $value_tuition_course;
				endif;
			endif;

			$type_pay = $this->input->post('type_pay', true);
			$insert_array['type_pay'] = $type_pay;
			if ($type_pay === '0' || $type_pay === '1'):
				$value_pay = $this->input->post('value_pay');
				if ($value_pay === '') {
					$var['error'] = 'درصد یا مبلغ هر ساعت را وارد کنید';
					$all_var['var'][] = $var;
				} else
					$insert_array['value_pay'] = $value_pay;
			elseif ($type_pay === '2'):
				$insert_array['value_pay'] = null;
			endif;


			/*****************
			چک باکس ها و ساعت ها
			 *****************/
			$sat = $this->input->post('sat_check', true);
			$sun = $this->input->post('sun_check', true);
			$mon = $this->input->post('mon_check', true);
			$tue = $this->input->post('tue_check', true);
			$wed = $this->input->post('wed_check', true);
			$thu = $this->input->post('thu_check', true);
			$fri = $this->input->post('fri_check', true);

			if ($sat || $sun || $mon || $tue || $wed || $thu || $fri === 'on') {

				if ($sat === 'on') {
					$sat_status = '1';
					$sat_clock = $this->input->post('sat_clock', true);
					if ($sat_clock === '') {
						$var['error'] = 'زمان روز شنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['sat_status'] = $sat_status;
						$insert_array['sat_clock'] = $sat_clock;
					}
				}

				if ($sun === 'on') {
					$sun_status = '1';
					$sun_clock = $this->input->post('sun_clock', true);
					if ($sun_clock === '') {
						$var['error'] = 'زمان روز یکشنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['sun_status'] = $sun_status;
						$insert_array['sun_clock'] = $sun_clock;
					}
				}

				if ($mon === 'on') {
					$mon_status = '1';
					$mon_clock = $this->input->post('mon_clock', true);
					if ($mon_clock === '') {
						$var['error'] = 'زمان روز دوشنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['mon_status'] = $mon_status;
						$insert_array['mon_clock'] = $mon_clock;
					}
				}

				if ($tue === 'on') {
					$tue_status = '1';
					$tue_clock = $this->input->post('tue_clock', true);
					if ($tue_clock === '') {
						$var['error'] = 'زمان روز سه شنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['tue_status'] = $tue_status;
						$insert_array['tue_clock'] = $tue_clock;
					}
				}

				if ($wed === 'on') {
					$wed_status = '1';
					$wed_clock = $this->input->post('wed_clock', true);
					if ($wed_clock === '') {
						$var['error'] = 'زمان روز چهارشنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['wed_status'] = $wed_status;
						$insert_array['wed_clock'] = $wed_clock;
					}
				}

				if ($thu === 'on') {
					$thu_status = '1';
					$thu_clock = $this->input->post('thu_clock', true);
					if ($thu_clock === '') {
						$var['error'] = 'زمان روز پنجشنبه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['thu_status'] = $thu_status;
						$insert_array['thu_clock'] = $thu_clock;
					}
				}

				if ($fri === 'on') {
					$fri_status = '1';
					$fri_clock = $this->input->post('fri_clock', true);
					if ($fri_clock === '') {
						$var['error'] = 'زمان روز جمعه وارد نشده است';
						$all_var['var'][] = $var;
					} else {
						$insert_array['fri_status'] = $fri_status;
						$insert_array['fri_clock'] = $fri_clock;
					}
				}
				/*****************
				پایان چک باکس ها و ساعت ها
				 *****************/

				if (!empty($all_var['var'])) {
					$this->session->set_flashdata($all_var);
					$this->edit_course();
					echo $mon;
				} else {

					//=====================================================================================

					require_once 'jdf.php';
					// جداکردن روز و ماه و سال از تاریخ شمسی
					$array = explode('-', $start_date);
					$start_year = $array[0];
					$start_month = $array[1];
					$start_day = $sat_start_day = $sun_start_day = $mon_start_day = $tue_start_day = $wed_start_day = $thu_start_day = $fri_start_day = $array[2];

//        echo '<br>' . jmktime(0, 0, 0, $start_month, $start_day, $start_year);
//        echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
//        echo '<br>' . jmktime($hours, $minute, 0, $start_month, $start_day, $start_year);
					// تعداد جلسات دوره بر اساس مدت زمان دوره و زمان هر جلسه
					(int) $number_of_meeting = ($course_duration * 60) / $time_meeting;
//        echo '<br>تعداد جلسات: ' . (int) $number_of_meeting;
					// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
					$num_day = jdate("N", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
					$num_day = strtr($num_day, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
					$startDAY = 0;
					if ($sat === 'on') {
						$sat_text = '7';
						if ($sat_text === $num_day) {
							$startDAY = $sat_text;
						}
					}
					if ($sun === 'on') {
						$sun_text = '1';
						if ($sun_text === $num_day) {
							$startDAY = $sun_text;
						}
					}
					if ($mon === 'on') {
						$mon_text = '2';
						if ($mon_text === $num_day) {
							$startDAY = $mon_text;
						}
					}
					if ($tue === 'on') {
						$tue_text = '3';
						if ($tue_text === $num_day) {
							$startDAY = $tue_text;
						}
					}
					if ($wed === 'on') {
						$wed_text = '4';
						if ($wed_text === $num_day) {
							$startDAY = $wed_text;
						}
					}
					if ($thu === 'on') {
						$thu_text = '5';
						if ($thu_text === $num_day) {
							$startDAY = $thu_text;
						}
					}
					if ($fri === 'on') {
						$fri_text = '6';
						if ($fri_text === $num_day) {
							$startDAY = $fri_text;
						}
					}
					if ($startDAY === 0) {
						$this->session->set_flashdata('start-date', 'تاریخ شروع دوره با هیچکدام از روزهای انتخاب شده هماهنگی ندارد');
						$this->edit_course();
					} else {
						$num_meeting = 0;
						$countDay = 0;
						$firstDay = 'false';
						while ($num_meeting !== (int) $number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
							// روزهای برگزاری دوره
							//                                                                                  شنبه
							if ($sat === 'on') {
								// جدا کردن ساعت و دقیقه
								$satTime = explode(':', $sat_clock);
								(int) $sat_hours = $satTime[0];
								(int) $sat_minute = $satTime[1];
								//تبدیل ساعت شروع روز شنبه به ثانیه
								(int) $sat_start_time = ($sat_hours * 60 * 60) + ($sat_minute * 60);
								//تبدیل ساعت پایان روز شنبه به ثانیه
								(int) $sat_end_time = $sat_start_time + ($time_meeting * 60);

								if ($startDAY === $sat_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week1['sat'] = $sat_start_time + $miladiTime;
									$data['week1'][] = $week1;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $sat_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $sat_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week1['sat'] = $sat_start_time + $miladiTime;
									$data['week1'][] = $week1;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$sun_start_day = $sat_start_day + 1;
							} else {
								if ($countDay > 0)
									$sun_start_day = $sat_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  یکشنبه
							if ($sun === 'on') {
								// جدا کردن ساعت و دقیقه
								$sunTime = explode(':', $sun_clock);
								(int) $sun_hours = $sunTime[0];
								(int) $sun_minute = $sunTime[1];
								//تبدیل ساعت شروع روز یکشنبه به ثانیه
								(int) $sun_start_time = ($sun_hours * 60 * 60) + ($sun_minute * 60);
								//تبدیل ساعت پایان روز یکشنبه به ثانیه
								(int) $sun_end_time = $sun_start_time + ($time_meeting * 60);

								if ($startDAY === $sun_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week2['sun'] = $sun_start_time + $miladiTime;
									$data['week2'][] = $week2;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $sun_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $sun_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week2['sun'] = $sun_start_time + $miladiTime;
									$data['week2'][] = $week2;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$mon_start_day = $sun_start_day + 1;
							} else {
								if ($countDay > 0)
									$mon_start_day = $sun_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  دوشنبه
							if ($mon === 'on') {
								// جدا کردن ساعت و دقیقه
								$monTime = explode(':', $mon_clock);
								(int) $mon_hours = $monTime[0];
								(int) $mon_minute = $monTime[1];
								//تبدیل ساعت شروع روز دوشنبه به ثانیه
								(int) $mon_start_time = ($mon_hours * 60 * 60) + ($mon_minute * 60);
								//تبدیل ساعت پایان روز دوشنبه به ثانیه
								(int) $mon_end_time = $mon_start_time + ($time_meeting * 60);

								if ($startDAY === $mon_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week3['mon'] = $mon_start_time + $miladiTime;
									$data['week3'][] = $week3;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $mon_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $mon_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week3['mon'] = $mon_start_time + $miladiTime;
									$data['week3'][] = $week3;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$tue_start_day = $mon_start_day + 1;
							} else {
								if ($countDay > 0)
									$tue_start_day = $mon_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  سه شنبه
							if ($tue === 'on') {
								// جدا کردن ساعت و دقیقه
								$tueTime = explode(':', $tue_clock);
								(int) $tue_hours = $tueTime[0];
								(int) $tue_minute = $tueTime[1];
								//تبدیل ساعت شروع روز سه شنبه به ثانیه
								(int) $tue_start_time = ($tue_hours * 60 * 60) + ($tue_minute * 60);
								//تبدیل ساعت پایان روز سه شنبه به ثانیه
								(int) $tue_end_time = $tue_start_time + ($time_meeting * 60);

								if ($startDAY === $tue_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week4['tue'] = $tue_start_time + $miladiTime;
									$data['week4'][] = $week4;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $tue_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $tue_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week4['tue'] = $tue_start_time + $miladiTime;
									$data['week4'][] = $week4;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$wed_start_day = $tue_start_day + 1;
							} else {
								if ($countDay > 0)
									$wed_start_day = $tue_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  چهارشنبه
							if ($wed === 'on') {
								// جدا کردن ساعت و دقیقه
								$wedTime = explode(':', $wed_clock);
								(int) $wed_hours = $wedTime[0];
								(int) $wed_minute = $wedTime[1];
								//تبدیل ساعت شروع روز چهارشنبه به ثانیه
								(int) $wed_start_time = ($wed_hours * 60 * 60) + ($wed_minute * 60);
								//تبدیل ساعت پایان روز چهارشنبه به ثانیه
								(int) $wed_end_time = $wed_start_time + ($time_meeting * 60);

								if ($startDAY === $wed_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week5['wed'] = $wed_start_time + $miladiTime;
									$data['week5'][] = $week5;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $wed_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $wed_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week5['wed'] = $wed_start_time + $miladiTime;
									$data['week5'][] = $week5;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$thu_start_day = $wed_start_day + 1;
							} else {
								if ($countDay > 0)
									$thu_start_day = $wed_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  پنجشنبه
							if ($thu === 'on') {
								// جدا کردن ساعت و دقیقه
								$thuTime = explode(':', $thu_clock);
								(int) $thu_hours = $thuTime[0];
								(int) $thu_minute = $thuTime[1];
								//تبدیل ساعت شروع روز پنجشنبه به ثانیه
								(int) $thu_start_time = ($thu_hours * 60 * 60) + ($thu_minute * 60);
								//تبدیل ساعت پایان روز پنجشنبه به ثانیه
								(int) $thu_end_time = $thu_start_time + ($time_meeting * 60);

								if ($startDAY === $thu_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week6['thu'] = $thu_start_time + $miladiTime;
									$data['week'][] = $week6;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>' . 'جلسه' . $num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $thu_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $thu_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week6['thu'] = $thu_start_time + $miladiTime;
									$data['week6'][] = $week6;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$fri_start_day = $thu_start_day + 1;
							} else {
								if ($countDay > 0)
									$fri_start_day = $thu_start_day + 1;
							}

							if ($num_meeting === (int) $number_of_meeting)
								break;

							//                                                                                  جمعه
							if ($fri === 'on') {
								// جدا کردن ساعت و دقیقه
								$friTime = explode(':', $fri_clock);
								(int) $fri_hours = $friTime[0];
								(int) $fri_minute = $friTime[1];
								//تبدیل ساعت شروع روز جمعه به ثانیه
								(int) $fri_start_time = ($fri_hours * 60 * 60) + ($fri_minute * 60);
								//تبدیل ساعت پایان روز جمعه به ثانیه
								(int) $fri_end_time = $fri_start_time + ($time_meeting * 60);

								if ($startDAY === $fri_text) {
									$countDay++;
								}

								if ($countDay === 0) {

								} elseif ($countDay === 1 && $firstDay == 'false') {
									$num_meeting++;
									$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week7['fri'] = $fri_start_time + $miladiTime;
									$data['week7'][] = $week7;
									$result['data'] = $data;
								} elseif ($num_meeting != 0) {
									$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $fri_start_day, $start_year));
									$d = $start_year . '-' . $start_month . '-' . $fri_start_day;
									$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
									$week7['fri'] = $fri_start_time + $miladiTime;
									$data['week7'][] = $week7;
									$result['data'] = $data;
								}

								if ($firstDay === 'true')
									$sat_start_day = $fri_start_day + 1;
							} else {
								if ($countDay > 0)
									$sat_start_day = $fri_start_day + 1;
							}


							if ($num_meeting === (int) $number_of_meeting)
								break;
						}


						if (!empty($result['data']['week1']))
							$res1 = $result['data']['week1'];
						if (!empty($result['data']['week2']))
							$res2 = $result['data']['week2'];
						if (!empty($result['data']['week3']))
							$res3 = $result['data']['week3'];
						if (!empty($result['data']['week4']))
							$res4 = $result['data']['week4'];
						if (!empty($result['data']['week5']))
							$res5 = $result['data']['week5'];
						if (!empty($result['data']['week6']))
							$res6 = $result['data']['week6'];
						if (!empty($result['data']['week7']))
							$res7 = $result['data']['week7'];

						//==========================================================================
						// مقایسه دوره جدید با دوره های استاد مربوطه
						//==========================================================================
						$employe = $this->base->get_data('employers', 'national_code', array('employee_id' => $employee_id));
						$courses = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', null, null, array('course_master' => $employe[0]->national_code, 'course_id !=' => $course_id));
						if (!empty($courses)) {
							foreach ($courses as $course):
								$old_course_id = [];
								$old_course_id = $course->course_id;
//            echo '<br>کد دوره: ' . $old_course_id;
								$old_start_date = [];
								$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
								$old_start_year = [];
								$old_start_month = [];
								$old_start_day = [];
								$old_array = [];
								require_once 'jdf.php';
								// جداکردن روز و ماه و سال از تاریخ شمسی
								$old_array = explode('-', $old_start_date);
								$old_start_year = $old_array[0];
								$old_start_month = $old_array[1];
								$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

								$old_time_meeting = $course->time_meeting;
								(int) $old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;
								// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
								$old_startDAY = 0;
								$old_sat = $course->sat_status;
								if ($old_sat === '1') {
									$old_sat_text = 'شنبه';
									if ($old_sat_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_sat_text;
									}
								}
								$old_sun = $course->sun_status;
								if ($old_sun === '1') {
									$old_sun_text = 'یکشنبه';
									if ($old_sun_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_sun_text;
									}
								}
								$old_mon = $course->mon_status;
								if ($old_mon === '1') {
									$old_mon_text = 'دوشنبه';
									if ($old_mon_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_mon_text;
									}
								}
								$old_tue = $course->tue_status;
								if ($old_tue === '1') {
									$old_tue_text = 'سه شنبه';
									if ($old_tue_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_tue_text;
									}
								}
								$old_wed = $course->wed_status;
								if ($old_wed === '1') {
									$old_wed_text = 'چهارشنبه';
									if ($old_wed_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_wed_text;
									}
								}
								$old_thu = $course->thu_status;
								if ($old_thu === '1') {
									$old_thu_text = 'پنجشنبه';
									if ($old_thu_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_thu_text;
									}
								}
								$old_fri = $course->fri_status;
								if ($old_fri === '1') {
									$old_fri_text = 'جمعه';
									if ($old_fri_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
										$old_startDAY = $old_fri_text;
									}
								}

								$old_num_meeting = 0;
								$old_countDay = 0;
								$old_firstDay = 'false';
								while ($old_num_meeting !== (int) $old_number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
									// روزهای برگزاری دوره
									//                                                                                  شنبه
									if ($old_sat === '1') {
										$old_sat_clock = $course->sat_clock;

										// جدا کردن ساعت و دقیقه
										$old_satTime = explode(':', $old_sat_clock);
										(int) $old_sat_hours = $old_satTime[0];
										(int) $old_sat_minute = $old_satTime[1];
										//تبدیل ساعت شروع روز شنبه به ثانیه
										(int) $old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
										//تبدیل ساعت پایان روز شنبه به ثانیه
										(int) $old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_sat_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

											if ($sat === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_sat = $old_sat_start_time + $miladiTime;
												$old_week_sat_end = $old_sat_end_time + $miladiTime;
												if (!empty($res1)) {
													foreach ($res1 as $more) {
														if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
											if ($sat === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_sat = $old_sat_start_time + $miladiTime;
												$old_week_sat_end = $old_sat_end_time + $miladiTime;
												if (!empty($res1)) {
													foreach ($res1 as $more) {
														if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
														if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_sun_start_day = $old_sat_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_sun_start_day = $old_sat_start_day + 1;
									}

									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									//                                                                                  یکشنبه
									if ($old_sun === '1') {
										$old_sun_clock = $course->sun_clock;

										// جدا کردن ساعت و دقیقه
										$old_sunTime = explode(':', $old_sun_clock);
										(int) $old_sun_hours = $old_sunTime[0];
										(int) $old_sun_minute = $old_sunTime[1];
										//تبدیل ساعت شروع روز یکشنبه به ثانیه
										(int) $old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
										//تبدیل ساعت پایان روز یکشنبه به ثانیه
										(int) $old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_sun_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($sun === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_sun = $old_sun_start_time + $miladiTime;
												$old_week_sun_end = $old_sun_end_time + $miladiTime;
												if (!empty($res2)) {
													foreach ($res2 as $more) {
														if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
											if ($sun === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_sun = $old_sun_start_time + $miladiTime;
												$old_week_sun_end = $old_sun_end_time + $miladiTime;
												if (!empty($res2)) {
													foreach ($res2 as $more) {
														if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
														if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_mon_start_day = $old_sun_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_mon_start_day = $old_sun_start_day + 1;
									}

									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									//                                                                                  دوشنبه
									if ($old_mon === '1') {
										$old_mon_clock = $course->mon_clock;

										// جدا کردن ساعت و دقیقه
										$old_monTime = explode(':', $old_mon_clock);
										(int) $old_mon_hours = $old_monTime[0];
										(int) $old_mon_minute = $old_monTime[1];
										//تبدیل ساعت شروع روز دوشنبه به ثانیه
										(int) $old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
										//تبدیل ساعت پایان روز دوشنبه به ثانیه
										(int) $old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_mon_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($mon === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_mon = $old_mon_start_time + $miladiTime;
												$old_week_mon_end = $old_mon_end_time + $miladiTime;
												if (!empty($res3)) {
													foreach ($res3 as $more) {
														if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
											if ($mon === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_mon = $old_mon_start_time + $miladiTime;
												$old_week_mon_end = $old_mon_end_time + $miladiTime;
												if (!empty($res3)) {
													foreach ($res3 as $more) {
														if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
														if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_tue_start_day = $old_mon_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_tue_start_day = $old_mon_start_day + 1;
									}

									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									//                                                                                  سه شنبه
									if ($old_tue === '1') {
										$old_tue_clock = $course->tue_clock;

										// جدا کردن ساعت و دقیقه
										$old_tueTime = explode(':', $old_tue_clock);
										(int) $old_tue_hours = $old_tueTime[0];
										(int) $old_tue_minute = $old_tueTime[1];
										//تبدیل ساعت شروع روز سه شنبه به ثانیه
										(int) $old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
										//تبدیل ساعت پایان روز سه شنبه به ثانیه
										(int) $old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_tue_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($tue === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_tue = $old_tue_start_time + $miladiTime;
												$old_week_tue_end = $old_tue_end_time + $miladiTime;
												if (!empty($res4)) {
													foreach ($res4 as $more) {
														if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
											if ($tue === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_tue = $old_tue_start_time + $miladiTime;
												$old_week_tue_end = $old_tue_end_time + $miladiTime;
												if (!empty($res4)) {
													foreach ($res4 as $more) {
														if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
														if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
														}
													}
												}
											}
										}
										if ($old_firstDay === 'true')
											$old_wed_start_day = $old_tue_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_wed_start_day = $old_tue_start_day + 1;
									}

									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									//                                                                                  چهارشنبه
									if ($old_wed === '1') {
										$old_wed_clock = $course->wed_clock;

										// جدا کردن ساعت و دقیقه
										$old_wedTime = explode(':', $old_wed_clock);
										(int) $old_wed_hours = $old_wedTime[0];
										(int) $old_wed_minute = $old_wedTime[1];
										//تبدیل ساعت شروع روز چهارشنبه به ثانیه
										(int) $old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
										//تبدیل ساعت پایان روز چهارشنبه به ثانیه
										(int) $old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_wed_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($wed === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_wed = $old_wed_start_time + $miladiTime;
												$old_week_wed_end = $old_wed_end_time + $miladiTime;
												if (!empty($res5)) {
													foreach ($res5 as $more) {
														if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
											if ($wed === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_wed = $old_wed_start_time + $miladiTime;
												$old_week_wed_end = $old_wed_end_time + $miladiTime;
												if (!empty($res5)) {
													foreach ($res5 as $more) {
														if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
														if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_thu_start_day = $old_wed_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_thu_start_day = $old_wed_start_day + 1;
									}
									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;
									//                                                                                  پنجشنبه
									if ($old_thu === '1') {
										$old_thu_clock = $course->thu_clock;
										// جدا کردن ساعت و دقیقه
										$old_thuTime = explode(':', $old_thu_clock);
										(int) $old_thu_hours = $old_thuTime[0];
										(int) $old_thu_minute = $old_thuTime[1];
										//تبدیل ساعت شروع روز پنجشنبه به ثانیه
										(int) $old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
										//تبدیل ساعت پایان روز پنجشنبه به ثانیه
										(int) $old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_thu_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($thu === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_thu = $old_thu_start_time + $miladiTime;
												$old_week_thu_end = $old_thu_end_time + $miladiTime;
												if (!empty($res6)) {
													foreach ($res6 as $more) {
														if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
											if ($thu === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_thu = $old_thu_start_time + $miladiTime;
												$old_week_thu_end = $old_thu_end_time + $miladiTime;
												if (!empty($res6)) {
													foreach ($res6 as $more) {
														if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
														if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_fri_start_day = $old_thu_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_fri_start_day = $old_thu_start_day + 1;
									}

									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									//                                                                                  جمعه
									if ($old_fri === '1') {
										$old_fri_clock = $course->fri_clock;
										// جدا کردن ساعت و دقیقه
										$old_friTime = explode(':', $old_fri_clock);
										(int) $old_fri_hours = $old_friTime[0];
										(int) $old_fri_minute = $old_friTime[1];
										//تبدیل ساعت شروع روز جمعه به ثانیه
										(int) $old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
										//تبدیل ساعت پایان روز جمعه به ثانیه
										(int) $old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

										if ($old_startDAY === $old_fri_text) {
											$old_countDay++;
										}

										if ($old_countDay === 0) {

										} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
											$old_num_meeting++;
											$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
											if ($fri === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_fri = $old_fri_start_time + $miladiTime;
												$old_week_fri_end = $old_fri_end_time + $miladiTime;
												if (!empty($res7)) {
													foreach ($res7 as $more) {
														if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
													}
												}
											}
										} elseif ($old_num_meeting != 0) {
											$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
											if ($fri === 'on') {
												$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
												$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
												$old_week_fri = $old_fri_start_time + $miladiTime;
												$old_week_fri_end = $old_fri_end_time + $miladiTime;
												if (!empty($res7)) {
													foreach ($res7 as $more) {
														if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
														if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
															$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
														}
													}
												}
											}
										}

										if ($old_firstDay === 'true')
											$old_sat_start_day = $old_fri_start_day + 1;
									} else {
										if ($old_countDay > 0)
											$old_sat_start_day = $old_fri_start_day + 1;
									}


									if ($old_num_meeting === (int) $old_number_of_meeting)
										break;

									if (!empty($error['teacher'])) {
										$teacherError['thrError'][] = $error;
										$error['teacher'] = null;
									}
								}
							endforeach;
						}

						//==========================================================================
						// مقایسه دوره جدید با کلاس مربوطه
						//==========================================================================

						$course_class = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('courses.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.class_id' => $class_id, 'classes.class_id' => $class_id));
						if (!empty($course_class)) {
							foreach ($course_class as $course):
								if($course->course_id !== $course_id) {

									$old_start_date = [];
									$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
									$old_start_year = [];
									$old_start_month = [];
									$old_start_day = [];
									$old_array = [];
									require_once 'jdf.php';
									// جداکردن روز و ماه و سال از تاریخ شمسی
									$old_array = explode('-', $old_start_date);
									$old_start_year = $old_array[0];
									$old_start_month = $old_array[1];
									$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

									$old_time_meeting = $course->time_meeting;
									(int)$old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;
									// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
									$old_startDAY = 0;
									$old_sat = $course->sat_status;
									if ($old_sat === '1') {
										$old_sat_text = 'شنبه';
										if ($old_sat_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_sat_text;
										}
									}
									$old_sun = $course->sun_status;
									if ($old_sun === '1') {
										$old_sun_text = 'یکشنبه';
										if ($old_sun_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_sun_text;
										}
									}
									$old_mon = $course->mon_status;
									if ($old_mon === '1') {
										$old_mon_text = 'دوشنبه';
										if ($old_mon_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_mon_text;
										}
									}
									$old_tue = $course->tue_status;
									if ($old_tue === '1') {
										$old_tue_text = 'سه شنبه';
										if ($old_tue_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_tue_text;
										}
									}
									$old_wed = $course->wed_status;
									if ($old_wed === '1') {
										$old_wed_text = 'چهارشنبه';
										if ($old_wed_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_wed_text;
										}
									}
									$old_thu = $course->thu_status;
									if ($old_thu === '1') {
										$old_thu_text = 'پنجشنبه';
										if ($old_thu_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_thu_text;
										}
									}
									$old_fri = $course->fri_status;
									if ($old_fri === '1') {
										$old_fri_text = 'جمعه';
										if ($old_fri_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
											$old_startDAY = $old_fri_text;
										}
									}

									$old_num_meeting = 0;
									$old_countDay = 0;
									$old_firstDay = 'false';
									while ($old_num_meeting !== (int)$old_number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
										// روزهای برگزاری دوره
										//                                                                                  شنبه
										if ($old_sat === '1') {
											$old_sat_clock = $course->sat_clock;

											// جدا کردن ساعت و دقیقه
											$old_satTime = explode(':', $old_sat_clock);
											(int)$old_sat_hours = $old_satTime[0];
											(int)$old_sat_minute = $old_satTime[1];
											//تبدیل ساعت شروع روز شنبه به ثانیه
											(int)$old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
											//تبدیل ساعت پایان روز شنبه به ثانیه
											(int)$old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_sat_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

												if ($sat === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_sat = $old_sat_start_time + $miladiTime;
													$old_week_sat_end = $old_sat_end_time + $miladiTime;
													if (!empty($res1)) {
														foreach ($res1 as $more) {
															if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
												if ($sat === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_sat = $old_sat_start_time + $miladiTime;
													$old_week_sat_end = $old_sat_end_time + $miladiTime;
													if (!empty($res1)) {
														foreach ($res1 as $more) {
															if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
															if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_sun_start_day = $old_sat_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_sun_start_day = $old_sat_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  یکشنبه
										if ($old_sun === '1') {
											$old_sun_clock = $course->sun_clock;

											// جدا کردن ساعت و دقیقه
											$old_sunTime = explode(':', $old_sun_clock);
											(int)$old_sun_hours = $old_sunTime[0];
											(int)$old_sun_minute = $old_sunTime[1];
											//تبدیل ساعت شروع روز یکشنبه به ثانیه
											(int)$old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
											//تبدیل ساعت پایان روز یکشنبه به ثانیه
											(int)$old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_sun_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($sun === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_sun = $old_sun_start_time + $miladiTime;
													$old_week_sun_end = $old_sun_end_time + $miladiTime;
													if (!empty($res2)) {
														foreach ($res2 as $more) {
															if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
												if ($sun === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_sun = $old_sun_start_time + $miladiTime;
													$old_week_sun_end = $old_sun_end_time + $miladiTime;
													if (!empty($res2)) {
														foreach ($res2 as $more) {
															if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
															if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_mon_start_day = $old_sun_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_mon_start_day = $old_sun_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  دوشنبه
										if ($old_mon === '1') {
											$old_mon_clock = $course->mon_clock;

											// جدا کردن ساعت و دقیقه
											$old_monTime = explode(':', $old_mon_clock);
											(int)$old_mon_hours = $old_monTime[0];
											(int)$old_mon_minute = $old_monTime[1];
											//تبدیل ساعت شروع روز دوشنبه به ثانیه
											(int)$old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
											//تبدیل ساعت پایان روز دوشنبه به ثانیه
											(int)$old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_mon_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($mon === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_mon = $old_mon_start_time + $miladiTime;
													$old_week_mon_end = $old_mon_end_time + $miladiTime;
													if (!empty($res3)) {
														foreach ($res3 as $more) {
															if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
												if ($mon === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_mon = $old_mon_start_time + $miladiTime;
													$old_week_mon_end = $old_mon_end_time + $miladiTime;
													if (!empty($res3)) {
														foreach ($res3 as $more) {
															if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
															if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_tue_start_day = $old_mon_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_tue_start_day = $old_mon_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  سه شنبه
										if ($old_tue === '1') {
											$old_tue_clock = $course->tue_clock;

											// جدا کردن ساعت و دقیقه
											$old_tueTime = explode(':', $old_tue_clock);
											(int)$old_tue_hours = $old_tueTime[0];
											(int)$old_tue_minute = $old_tueTime[1];
											//تبدیل ساعت شروع روز سه شنبه به ثانیه
											(int)$old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
											//تبدیل ساعت پایان روز سه شنبه به ثانیه
											(int)$old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_tue_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($tue === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_tue = $old_tue_start_time + $miladiTime;
													$old_week_tue_end = $old_tue_end_time + $miladiTime;
													if (!empty($res4)) {
														foreach ($res4 as $more) {
															if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
												if ($tue === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_tue = $old_tue_start_time + $miladiTime;
													$old_week_tue_end = $old_tue_end_time + $miladiTime;
													if (!empty($res4)) {
														foreach ($res4 as $more) {
															if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
															if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
															}
														}
													}
												}
											}
											if ($old_firstDay === 'true')
												$old_wed_start_day = $old_tue_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_wed_start_day = $old_tue_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  چهارشنبه
										if ($old_wed === '1') {
											$old_wed_clock = $course->wed_clock;

											// جدا کردن ساعت و دقیقه
											$old_wedTime = explode(':', $old_wed_clock);
											(int)$old_wed_hours = $old_wedTime[0];
											(int)$old_wed_minute = $old_wedTime[1];
											//تبدیل ساعت شروع روز چهارشنبه به ثانیه
											(int)$old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
											//تبدیل ساعت پایان روز چهارشنبه به ثانیه
											(int)$old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_wed_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($wed === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_wed = $old_wed_start_time + $miladiTime;
													$old_week_wed_end = $old_wed_end_time + $miladiTime;
													if (!empty($res5)) {
														foreach ($res5 as $more) {
															if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
												if ($wed === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_wed = $old_wed_start_time + $miladiTime;
													$old_week_wed_end = $old_wed_end_time + $miladiTime;
													if (!empty($res5)) {
														foreach ($res5 as $more) {
															if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
															if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_thu_start_day = $old_wed_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_thu_start_day = $old_wed_start_day + 1;
										}
										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;
										//                                                                                  پنجشنبه
										if ($old_thu === '1') {
											$old_thu_clock = $course->thu_clock;
											// جدا کردن ساعت و دقیقه
											$old_thuTime = explode(':', $old_thu_clock);
											(int)$old_thu_hours = $old_thuTime[0];
											(int)$old_thu_minute = $old_thuTime[1];
											//تبدیل ساعت شروع روز پنجشنبه به ثانیه
											(int)$old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
											//تبدیل ساعت پایان روز پنجشنبه به ثانیه
											(int)$old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_thu_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($thu === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_thu = $old_thu_start_time + $miladiTime;
													$old_week_thu_end = $old_thu_end_time + $miladiTime;
													if (!empty($res6)) {
														foreach ($res6 as $more) {
															if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
												if ($thu === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_thu = $old_thu_start_time + $miladiTime;
													$old_week_thu_end = $old_thu_end_time + $miladiTime;
													if (!empty($res6)) {
														foreach ($res6 as $more) {
															if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
															if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_fri_start_day = $old_thu_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_fri_start_day = $old_thu_start_day + 1;
										}

										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										//                                                                                  جمعه
										if ($old_fri === '1') {
											$old_fri_clock = $course->fri_clock;
											// جدا کردن ساعت و دقیقه
											$old_friTime = explode(':', $old_fri_clock);
											(int)$old_fri_hours = $old_friTime[0];
											(int)$old_fri_minute = $old_friTime[1];
											//تبدیل ساعت شروع روز جمعه به ثانیه
											(int)$old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
											//تبدیل ساعت پایان روز جمعه به ثانیه
											(int)$old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

											if ($old_startDAY === $old_fri_text) {
												$old_countDay++;
											}

											if ($old_countDay === 0) {

											} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
												$old_num_meeting++;
												$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
												if ($fri === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_fri = $old_fri_start_time + $miladiTime;
													$old_week_fri_end = $old_fri_end_time + $miladiTime;
													if (!empty($res7)) {
														foreach ($res7 as $more) {
															if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
														}
													}
												}
											} elseif ($old_num_meeting != 0) {
												$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
												if ($fri === 'on') {
													$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
													$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
													$old_week_fri = $old_fri_start_time + $miladiTime;
													$old_week_fri_end = $old_fri_end_time + $miladiTime;
													if (!empty($res7)) {
														foreach ($res7 as $more) {
															if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
															if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
																$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
															}
														}
													}
												}
											}

											if ($old_firstDay === 'true')
												$old_sat_start_day = $old_fri_start_day + 1;
										} else {
											if ($old_countDay > 0)
												$old_sat_start_day = $old_fri_start_day + 1;
										}


										if ($old_num_meeting === (int)$old_number_of_meeting)
											break;

										if (!empty($error['class'])) {
											$classError['classError'][] = $error;
											$error['class'] = null;
										}
									}
								}
							endforeach;
						}

						if (empty($classError) && empty($teacherError)) {

							// upload pic
//							$result_of_upload = $this->course_upload($_FILES);
//							$insert_array['course_pic'] = $result_of_upload['final_image_name'];

							$update_array = array(
								'lesson_id' => $course_name,
								'employee_id' => $employee_id,
								'employee_nc' => $employer[0]->national_code
							);

							$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $insert_array);
							$this->base->update('courses_employers', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_array);
							$this->session->set_flashdata('success-insert', 'ویرایش دوره با موفقیت انجام شد.');
							redirect('training/manage-courses', 'refresh');
						} else {
							if (!empty($teacherError))
								$this->session->set_flashdata($teacherError);
							if (!empty($classError))
								$this->session->set_flashdata($classError);
							$this->edit_course();
//							print_r($course_class);
						}
					}
				}
			} else {
				$this->session->set_flashdata('start-date', 'هیچ روزی برای برگزاری دوره انتخاب نشده است.');
				$this->edit_course();
			}
		} else {
			$this->edit_course();
		}
	}

//	public function edit_start_date() {
//		$academy_id = $this->session->userdata('academy_id');
//		$course_id = $this->input->post('course_id', true);
//		$date = $this->input->post('start_date', true);
//		$start_date = strtr($date, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
//		$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), array('start_date' => $start_date));
//		$this->show_course_edit_after($course_id);
//	}

	///////     Course update picture
	public function course_update_pic() {
		$academy_id = $this->session->userdata('academy_id');
		$course_id = $this->input->post('course_id');

		$result_of_upload = $this->course_upload($_FILES);
		if ($result_of_upload['result_image_name'] === '110') {
			$course_pic = $this->base->get_data('courses', 'course_pic', array('course_id' => $course_id, 'academy_id' => $academy_id));
			if (!empty($course_pic) && $course_pic[0]->course_pic != 'course.png') {
				unlink('./assets/course-picture/thumb/' . $course_pic[0]->course_pic);
				unlink('./assets/course-picture/' . $course_pic[0]->course_pic);
			}
			$insert_array['course_pic'] = $result_of_upload['final_image_name'];
			$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $insert_array);
//            redirect(base_url('show-course-edit-after/'.$course_id),'refresh');
			$this->show_course_edit_after($course_id);
		} else {
			$this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
			$this->edit_course();
		}
	}

	public function show_course_edit_after($course_id) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
			$contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
			$contentData['employers'] = $this->base->get_data('employers', '*', array('employee_activated' => 1, 'academy_id' => $academy_id));
			$contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $course_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
			$contentData['attendance'] = $this->base->get_data('attendance', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
			$course_info = $contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $course_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
			$start_date = $course_info[0]->start_date;
			$contentData['start_date'] = strtr($start_date, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
			$contentData['yield'] = 'edit-course';
			$headerData['links'] = 'custom-select-links';
			$footerData['scripts'] = 'custom-select-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$headerData['thirdLinks'] = 'dropify-links';
			$footerData['thirdScripts'] = 'dropify-scripts';
			$this->show_pages('ویرایش دوره', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function delete_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course_id = $this->input->post('course_id', true);
			$this->base->delete_data('courses', array('course_id' => $course_id, 'academy_id' => $academy_id));
			$this->base->delete_data('attendance', array('course_id' => $course_id, 'academy_id' => $academy_id));
			$this->session->set_flashdata('success-insert', 'دوره مورد نظر با موفقیت حذف گردید.');
			redirect('training/manage-courses', 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function start_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course_id = $this->input->post('course_id', true);
			$time_meeting = $this->input->post('time_meeting', true);
			$meeting_number = 1;
			$insert_array = array(
				'manager_nc' => $sessId,
				'academy_id' => $academy_id,
				'course_id' => $course_id,
				'meeting_number' => $meeting_number,
				'time_meeting' => (int) $time_meeting
			);
			require_once 'jdf.php';
			$activate_on = jdate('H:i:s - Y/n/j');
			$update_array = array(
				'course_status' => '1',
				'activate_on' => $activate_on
			);
			$courses = $this->base->get_data('courses', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
			if ($courses[0]->type_course === '0') {
				if ($courses[0]->type_pay === '1') {
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				}
			} elseif ($courses[0]->type_course === '1') {
				if ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '1') {
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				} elseif ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '0') {
					// std
					$amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
					$financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
					foreach ($financial_state as $financial_situation) {
						if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
							$amount_update = array(
								'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
								'final_situation' => -1
							);
						} else {
							if ((int) $amount_std > (int) $financial_situation->final_amount) {
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
						$course_cost = $financial_situation->course_cost + $amount_std;
						$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
					}
					// end std
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				} elseif ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '0') {
					// std
					$amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
					$financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
					foreach ($financial_state as $financial_situation) {
						if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
							$amount_update = array(
								'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
								'final_situation' => -1
							);
						} else {
							if ((int) $amount_std > (int) $financial_situation->final_amount) {
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
						$course_cost = $financial_situation->course_cost + $amount_std;
						$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
					}
					// end std
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				}
			}
			$this->base->insert('attendance', $insert_array);
			$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_array);
			redirect('training/manage-courses', 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

//پایان دوره
	public function stop_course() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course_id = $this->input->post('course_id', true);
			require_once 'jdf.php';
			$finished_on = jdate('H:i:s - Y/n/j');
			$update_array = array(
				'course_status' => '2',
				'finished_on' => $finished_on
			);
			$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_array);
			redirect('training/manage-courses', 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

//نمایش جلسات دوره
	public function list_of_meeting($courseid, $course_status) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');

//            if (!empty($this->input->get('course_id', true))) {
//                $courseid = $this->input->get('course_id', true);
//            } else {
//                $courseid = $this->input->post('course_id', true);
//            }
			$contentData['attendancelist'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id));
			$contentData['courseofemployer'] = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('course_id' => $courseid, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
			$contentData['courseid'] = $courseid;
			$contentData['course_status'] = $course_status;
			$contentData['yield'] = 'list_of_meeting';
			$headerData['links'] = 'data-table-links';
			$footerData['scripts'] = 'data-table-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$this->show_pages('مشاهده جلسات دوره', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function change_time_meeting() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$newTimeMeeting = $this->input->post('new_time_meeting', true);
			$meeting_number = $this->input->post('meeting_number', true);
			$course_id = $this->input->post('courseid', true);
			$time_meeting = $this->input->post('old_time_meeting', true);
			$course_status = $this->input->post('course_status', true);
			if ($time_meeting === null) {
				$time_meeting = 0;
			}
			if ($newTimeMeeting === $time_meeting) {
				redirect('training/list_of_meeting/' . $course_id . "/" . $course_status, 'refresh');
			} else {
				$courses = $this->base->get_data('courses', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
				$new_time = array(
					'time_meeting' => $newTimeMeeting
				);

				$result_time = ($courses[0]->time_total - $time_meeting) + $newTimeMeeting;
				$update_time_total = array(
					'time_total' => $result_time
				);
				//////////////////////////////////////

				if ($courses[0]->type_course === '0') {
					if ($courses[0]->type_pay === '1') {
						// emp
						$old_amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
						$amount_emp = ($newTimeMeeting / 60) * $courses[0]->value_pay;
						// update financial_amount (employer) in table financial_situation_employer
						$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
						$financial_situation_update = array(
							'final_amount' => ((int) $financial_situation_emp[0]->final_amount - (int) $old_amount_emp) + (int) $amount_emp,
							'final_situation' => 1
						);
						$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
						// end
						// update course_amount in table courses_employers
						$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
						$courses_employers_update = array(
							'course_amount' => ((int) $courses_employers[0]->course_amount - (int) $old_amount_emp) + (int) $amount_emp
						);
						$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
						// end emp
					}
				} elseif ($courses[0]->type_course === '1') {
					if ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '1') {
						// emp
						$old_amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
						$amount_emp = ($newTimeMeeting / 60) * $courses[0]->value_pay;
						// update financial_amount (employer) in table financial_situation_employer
						$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
						$financial_situation_update = array(
							'final_amount' => ((int) $financial_situation_emp[0]->final_amount - (int) $old_amount_emp) + (int) $amount_emp,
							'final_situation' => 1
						);
						$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
						// end
						// update course_amount in table courses_employers
						$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
						$courses_employers_update = array(
							'course_amount' => ((int) $courses_employers[0]->course_amount - (int) $old_amount_emp) + (int) $amount_emp
						);
						$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
						// end emp
					} elseif ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '0') {
						// std
						$old_amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
						$amount_std = $courses[0]->course_tuition * ($newTimeMeeting / 60);
						// update financial_amount (student) in table financial_situation_employer
						$financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
						foreach ($financial_state as $financial_situation) {
							if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
								$final_amount = (int) $financial_situation->final_amount - (int) $old_amount_std;
								$amount_update = array(
									'final_amount' => $final_amount + (int) $amount_std,
									'final_situation' => -1
								);
							} else {
								$final_amount = (int) $financial_situation->final_amount + (int) $old_amount_std;
								if ((int) $amount_std > (int) $final_amount) {
									$amount_update = array(
										'final_amount' => (int) $amount_std - (int) $final_amount,
										'final_situation' => -1
									);
								} elseif ((int) $amount_std === $final_amount) {
									$amount_update = array(
										'final_amount' => 0,
										'final_situation' => 0
									);
								} else {
									$amount_update = array(
										'final_amount' => (int) $final_amount - (int) $amount_std,
										'final_situation' => 1
									);
								}
							}
							$this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
							$course_cost = ($financial_situation->course_cost - $old_amount_std) + $amount_std;
							$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
						}
						// end std
						// emp
						$old_amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
						$amount_emp = ($newTimeMeeting / 60) * $courses[0]->value_pay;
						// update financial_amount (employer) in table financial_situation_employer
						$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
						$financial_situation_update = array(
							'final_amount' => ((int) $financial_situation_emp[0]->final_amount - (int) $old_amount_emp) + (int) $amount_emp,
							'final_situation' => 1
						);
						$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
						// end
						// update course_amount in table courses_employers
						$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
						$courses_employers_update = array(
							'course_amount' => ((int) $courses_employers[0]->course_amount - (int) $old_amount_emp) + (int) $amount_emp
						);
						$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
						// end emp
					} elseif ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '0') {
						// std
						$old_amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
						$amount_std = $courses[0]->course_tuition * ($newTimeMeeting / 60);
						// update financial_amount (student) in table financial_situation_employer
						$financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
						foreach ($financial_state as $financial_situation) {
							if ((int) $financial_situation->final_situation === 0 || (int) $financial_situation->final_situation === -1) {
								$final_amount = (int) $financial_situation->final_amount - (int) $old_amount_std;
								$amount_update = array(
									'final_amount' => $final_amount + (int) $amount_std,
									'final_situation' => -1
								);
							} else {
								$final_amount = (int) $financial_situation->final_amount + (int) $old_amount_std;
								if ((int) $amount_std > (int) $final_amount) {
									$amount_update = array(
										'final_amount' => (int) $amount_std - (int) $final_amount,
										'final_situation' => -1
									);
								} elseif ((int) $amount_std === $final_amount) {
									$amount_update = array(
										'final_amount' => 0,
										'final_situation' => 0
									);
								} else {
									$amount_update = array(
										'final_amount' => (int) $final_amount - (int) $amount_std,
										'final_situation' => 1
									);
								}
							}
							$this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
							$course_cost = ($financial_situation->course_cost - $old_amount_std) + $amount_std;
							$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
						}
						// end std
						// emp
						$old_amount_emp = (($old_amount_std * $courses[0]->count_std) * $courses[0]->value_pay) / 100;
						$amount_emp = (($amount_std * $courses[0]->count_std) * $courses[0]->value_pay) / 100;
						// update financial_amount (employer) in table financial_situation_employer
						$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
						$financial_situation_update = array(
							'final_amount' => ((int) $financial_situation_emp[0]->final_amount - $old_amount_emp) + (int) $amount_emp,
							'final_situation' => 1
						);
						$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
						// end
						// update course_amount in table courses_employers
						$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
						$courses_employers_update = array(
							'course_amount' => ((int) $courses_employers[0]->course_amount - $old_amount_emp) + (int) $amount_emp
						);
						$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
						// end emp
					}
				}
				//////////////////////////////////////
				$this->base->update('attendance', array('course_id' => $course_id, 'meeting_number' => $meeting_number, 'academy_id' => $academy_id), $new_time);
				$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_time_total);
				redirect('training/list_of_meeting/' . $course_id . "/" . $course_status, 'refresh');
			}
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function insert_new_meeting() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course_id = $this->input->post('course_id', true);
			$meeting_number = $this->input->post('meeting', true);
			$course_status = $this->input->post('course_status', true);

			$courses = $this->base->get_data('courses', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
			$employer_nc = $courses[0]->course_master;
			(int) $time_meeting = (int) $courses[0]->time_meeting;
			require_once 'jdf.php';
			$date = jdate('H:i:s - Y/n/j');
			$insert_array = array(
				'manager_nc' => $sessId,
				'academy_id' => $academy_id,
				'employer_nc' => $employer_nc,
				'course_id' => $course_id,
				'meeting_number' => $meeting_number + 1,
				'time_meeting' => (int) $time_meeting,
				'date' => $date
			);
			$time_total = $courses[0]->time_total;
			$update_time_total = array(
				'time_total' => (int) $time_meeting + $time_total
			);

			if ($courses[0]->type_course === '0') {
				if ($courses[0]->type_pay === '1') {
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				}
			} elseif ($courses[0]->type_course === '1') {
				if ($courses[0]->type_pay === '1' && $courses[0]->type_tuition === '1') {
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
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
							if ((int) $amount_std > (int) $financial_situation->final_amount) {
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
						$course_cost = $financial_situation->course_cost + $amount_std;
						$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
					}
					// end std
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
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
							if ((int) $amount_std > (int) $financial_situation->final_amount) {
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
						$course_cost = $financial_situation->course_cost + $amount_std;
						$this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
					}
					// end std
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
					$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
					$courses_employers_update = array(
						'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
					);
					$this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
					// end emp
				}
			}
			$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_time_total);
			$this->base->insert('attendance', $insert_array);
			redirect('training/list_of_meeting/' . $course_id . "/" . $course_status, 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function students_of_course($courseid, $meeting) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['studentListOfCourse'] = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $courseid, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
			$contentData['count_absence'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id, 'meeting_number_std !=' => null));
			$contentData['absence_status'] = $this->base->get_data('attendance', '*', array('course_id' => $courseid, 'academy_id' => $academy_id, 'meeting_number_std !=' => null, 'meeting_number_std' => $meeting));
			$contentData['course_info'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_id' => $courseid, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
			$contentData['courseid'] = $courseid;
			$contentData['meeting'] = $meeting;
			$contentData['yield'] = 'list-of-students';
			$headerData['links'] = 'persian-calendar-links';
			$footerData['scripts'] = 'persian-calendar-scripts';
			$this->show_pages('لیست دانشجویان دوره', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function insert_attendance($courseid, $meeting, $student_nc) {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$course = $this->base->get_data('courses', '*', array('course_id' => $courseid, 'academy_id' => $academy_id));
			$employer_nc = $course[0]->course_master;
			$check_box = $this->input->post('check_box', true);
			if ($check_box === 'on') {
				$check_box = '1';
				$insert_array['type_attendance'] = $check_box;
			}
			$insert_array = array(
				'academy_id' => $academy_id,
				'course_id' => $courseid,
				'meeting_number_std' => $meeting,
				'student_nc' => $student_nc,
				'manager_nc' => $sessId,
				'employer_nc' => $employer_nc
			);
			$this->base->insert('attendance', $insert_array);
			redirect('training/students_of_course/' . $courseid . '/' . $meeting, 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function change_attendance() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$student_nc = $this->input->post('student_nc', true);
			$meeting = $this->input->post('meeting', true);
			$courseid = $this->input->post('course_id', true);
			$employer_nc = $this->input->post('employer_nc', true);
			$conditions = $this->input->post('conditions', true);

//            چاپ آرایه:
//            echo $dataJson = $this->input->post('my_data');
//            $dataArray = json_decode(htmlspecialchars_decode($dataJson), true);

			if ($conditions === '1'):
				$this->base->delete_data('attendance', array('student_nc' => $student_nc, 'course_id' => $courseid, 'meeting_number_std' => $meeting, 'academy_id' => $academy_id));
			elseif ($conditions === '0'):

				require_once 'jdf.php';
				$date = jdate('H:i:s - Y/n/j');
				$my_array['date'] = $date;
				$my_array['type_attendance'] = '1';
				$my_array['academy_id'] = $academy_id;
				$my_array['student_nc'] = $student_nc;
				$my_array['employer_nc'] = $employer_nc;
				$my_array['manager_nc'] = $sessId;
				$my_array['meeting_number_std'] = $meeting;
				$my_array['course_id'] = $courseid;

				$this->base->insert('attendance', $my_array);
			endif;
//            $this->students_of_course($courseid, $meeting);
			redirect('training/students_of_course/' . $courseid . '/' . $meeting, 'refresh');
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function course_upload() {
		if(isset($_FILES['pic_name']['name']) && !empty($_FILES['pic_name']['name'])){
			$this->load->library('upload');
			$config_array = array(
				'upload_path' => './assets/course-picture',
				'allowed_types' => 'jpg|png|jpeg',
				'max_size' => 10240,
				'file_name' => time() . rand(1000,9999)
			);
			$this->upload->initialize($config_array);

			if ($this->upload->do_upload('pic_name')) {
				$pic_info = $this->upload->data();
				$pic_name = $pic_info['file_name'];
				$this->load->library('image_lib');
				$config_array = array(
					'source_image' => './assets/course-picture/' . $pic_name,
					'new_image' => './assets/course-picture/thumb/' . $pic_name,
					'width' => 240,
					'height' => 240,
					'maintain_ratio' => false,
				);

				$this->image_lib->initialize($config_array);
				$this->image_lib->resize();
				$result_image_name = '110';
				$final_image_name = $pic_name;
			} else {
				$result_image_name = '404';
				$final_image_name = 'course.png';
			}
		} else {
			$result_image_name = '110';
			$final_image_name = 'course.png';
		}
		$result = array(
			'img_name' => $result_image_name,
			'final_image_name' => $final_image_name,
			'result_image_name' => $result_image_name
		);
		return $result;
	}

//    public function insert_wallet() {
//        $sessId = $this->session->userdata('session_id');
//        $userType = $this->session->userdata('user_type');
//        if (!empty($sessId) && $userType === 'managers') {
//            $student_nc = $this->input->post('student_nc', true);
//            $amount_wallet = $this->input->post('amount_wallet', true);
//            $wallet = $this->base->get_data('wallet_students', '*', array('student_nc' => $student_nc));
//            $amount_wallet += $wallet[0]->wallet_stock;
//            $this->base->update('wallet_students', array('student_nc' => $student_nc), array('wallet_stock' => $amount_wallet));
//            redirect('financial/finan-get-student-nc', 'refresh');
//        } else {
//            redirect('users-403', 'refresh');
//        }
//    }
	//=======================================================================\\
	//=======================================================================\\
	//=======================================================================\\
	public function test() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'managers') {
			$academy_id = $this->session->userdata('academy_id');
			$contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
			$contentData['employers'] = $this->base->get_data('employers', '*', array('employee_activated' => 1, 'academy_id' => $academy_id));
			$contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
			$contentData['yield'] = 'test-create-new-course';
			$headerData['links'] = 'custom-select-links';
			$footerData['scripts'] = 'custom-select-scripts';
			$headerData['secondLinks'] = 'persian-calendar-links';
			$footerData['secondScripts'] = 'persian-calendar-scripts';
			$headerData['thirdLinks'] = 'dropify-links';
			$footerData['thirdScripts'] = 'dropify-scripts';
			$this->show_pages($title = 'TEST', 'content', $contentData, $headerData, $footerData);
		} else {
			redirect('training/error-403', 'refresh');
		}
	}

	public function test_insert() {

		$academy_id = $this->session->userdata('academy_id', true);
		$lesson_id = $this->input->post('course_name', true);
		$course_duration = $this->input->post('course_duration', true);
		$employee_id = $this->input->post('employee_id', true);
		$start_date = $this->input->post('start_date', true);
		$class_id = $this->input->post('class_id', true);
		$time_meeting = $this->input->post('time_meeting');

		require_once 'jdf.php';
		// جداکردن روز و ماه و سال از تاریخ شمسی
		$array = explode('-', $start_date);
		$start_year = $array[0];
		$start_month = $array[1];
		$start_day = $sat_start_day = $sun_start_day = $mon_start_day = $tue_start_day = $wed_start_day = $thu_start_day = $fri_start_day = $array[2];


//        echo '<br>' . jmktime(0, 0, 0, $start_month, $start_day, $start_year);
//        echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
//        echo '<br>' . jmktime($hours, $minute, 0, $start_month, $start_day, $start_year);
		// تعداد جلسات دوره بر اساس مدت زمان دوره و زمان هر جلسه
		(int) $number_of_meeting = ($course_duration * 60) / $time_meeting;
//        echo '<br>تعداد جلسات: ' . (int) $number_of_meeting;
		// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
		$startDAY = 0;
		$sat = $this->input->post('sat_check', true);
		if ($sat === 'on') {
			$sat_text = 'شنبه';
			if ($sat_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $sat_text;
			}
		}
		$sun = $this->input->post('sun_check', true);
		if ($sun === 'on') {
			$sun_text = 'یکشنبه';
			if ($sun_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $sun_text;
			}
		}
		$mon = $this->input->post('mon_check', true);
		if ($mon === 'on') {
			$mon_text = 'دوشنبه';
			if ($mon_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $mon_text;
			}
		}
		$tue = $this->input->post('tue_check', true);
		if ($tue === 'on') {
			$tue_text = 'سه شنبه';
			if ($tue_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $tue_text;
			}
		}
		$wed = $this->input->post('wed_check', true);
		if ($wed === 'on') {
			$wed_text = 'چهارشنبه';
			if ($wed_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $wed_text;
			}
		}
		$thu = $this->input->post('thu_check', true);
		if ($thu === 'on') {
			$thu_text = 'پنجشنبه';
			if ($thu_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $thu_text;
			}
		}
		$fri = $this->input->post('fri_check', true);
		if ($fri === 'on') {
			$fri_text = 'جمعه';
			if ($fri_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $fri_text;
			}
		}

		if ($startDAY === 0) {
			echo '<br>تاریخ شروع دوره با هیچکدام از روزهای انتخاب شده هماهنگی ندارد';
		} else {
			$num_meeting = 0;
			$countDay = 0;
			$firstDay = 'false';
			while ($num_meeting !== (int) $number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
				// روزهای برگزاری دوره
				//                                                                                  شنبه
				if ($sat === 'on') {
					$sat_status = '1';
					$sat_clock = $this->input->post('sat_clock', true);

					// جدا کردن ساعت و دقیقه
					$satTime = explode(':', $sat_clock);
					(int) $sat_hours = $satTime[0];
					(int) $sat_minute = $satTime[1];
					//تبدیل ساعت شروع روز شنبه به ثانیه
					(int) $sat_start_time = ($sat_hours * 60 * 60) + ($sat_minute * 60);
					//تبدیل ساعت پایان روز شنبه به ثانیه
					(int) $sat_end_time = $sat_start_time + ($time_meeting * 60);

					if ($startDAY === $sat_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week1['sat'] = $sat_start_time + $miladiTime;
						$data['week1'][] = $week1;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $sat_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $sat_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week1['sat'] = $sat_start_time + $miladiTime;
						$data['week1'][] = $week1;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$sun_start_day = $sat_start_day + 1;
				} else {
					if ($countDay > 0)
						$sun_start_day = $sat_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  یکشنبه
				if ($sun === 'on') {
					$sun_status = '1';
					$sun_clock = $this->input->post('sun_clock', true);

					// جدا کردن ساعت و دقیقه
					$sunTime = explode(':', $sun_clock);
					(int) $sun_hours = $sunTime[0];
					(int) $sun_minute = $sunTime[1];
					//تبدیل ساعت شروع روز یکشنبه به ثانیه
					(int) $sun_start_time = ($sun_hours * 60 * 60) + ($sun_minute * 60);
					//تبدیل ساعت پایان روز یکشنبه به ثانیه
					(int) $sun_end_time = $sun_start_time + ($time_meeting * 60);

					if ($startDAY === $sun_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week2['sun'] = $sun_start_time + $miladiTime;
						$data['week2'][] = $week2;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $sun_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $sun_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week2['sun'] = $sun_start_time + $miladiTime;
						$data['week2'][] = $week2;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$mon_start_day = $sun_start_day + 1;
				} else {
					if ($countDay > 0)
						$mon_start_day = $sun_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  دوشنبه
				if ($mon === 'on') {
					$mon_status = '1';
					$mon_clock = $this->input->post('mon_clock', true);

					// جدا کردن ساعت و دقیقه
					$monTime = explode(':', $mon_clock);
					(int) $mon_hours = $monTime[0];
					(int) $mon_minute = $monTime[1];
					//تبدیل ساعت شروع روز دوشنبه به ثانیه
					(int) $mon_start_time = ($mon_hours * 60 * 60) + ($mon_minute * 60);
					//تبدیل ساعت پایان روز دوشنبه به ثانیه
					(int) $mon_end_time = $mon_start_time + ($time_meeting * 60);

					if ($startDAY === $mon_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week3['mon'] = $mon_start_time + $miladiTime;
						$data['week3'][] = $week3;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $mon_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $mon_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week3['mon'] = $mon_start_time + $miladiTime;
						$data['week3'][] = $week3;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$tue_start_day = $mon_start_day + 1;
				} else {
					if ($countDay > 0)
						$tue_start_day = $mon_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  سه شنبه
				if ($tue === 'on') {
					$tue_status = '1';
					$tue_clock = $this->input->post('tue_clock', true);

					// جدا کردن ساعت و دقیقه
					$tueTime = explode(':', $tue_clock);
					(int) $tue_hours = $tueTime[0];
					(int) $tue_minute = $tueTime[1];
					//تبدیل ساعت شروع روز سه شنبه به ثانیه
					(int) $tue_start_time = ($tue_hours * 60 * 60) + ($tue_minute * 60);
					//تبدیل ساعت پایان روز سه شنبه به ثانیه
					(int) $tue_end_time = $tue_start_time + ($time_meeting * 60);

					if ($startDAY === $tue_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week4['tue'] = $tue_start_time + $miladiTime;
						$data['week4'][] = $week4;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $tue_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $tue_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week4['tue'] = $tue_start_time + $miladiTime;
						$data['week4'][] = $week4;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$wed_start_day = $tue_start_day + 1;
				} else {
					if ($countDay > 0)
						$wed_start_day = $tue_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  چهارشنبه
				if ($wed === 'on') {
					$wed_status = '1';
					$wed_clock = $this->input->post('wed_clock', true);

					// جدا کردن ساعت و دقیقه
					$wedTime = explode(':', $wed_clock);
					(int) $wed_hours = $wedTime[0];
					(int) $wed_minute = $wedTime[1];
					//تبدیل ساعت شروع روز چهارشنبه به ثانیه
					(int) $wed_start_time = ($wed_hours * 60 * 60) + ($wed_minute * 60);
					//تبدیل ساعت پایان روز چهارشنبه به ثانیه
					(int) $wed_end_time = $wed_start_time + ($time_meeting * 60);

					if ($startDAY === $wed_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week5['wed'] = $wed_start_time + $miladiTime;
						$data['week5'][] = $week5;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $wed_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $wed_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week5['wed'] = $wed_start_time + $miladiTime;
						$data['week5'][] = $week5;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$thu_start_day = $wed_start_day + 1;
				} else {
					if ($countDay > 0)
						$thu_start_day = $wed_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  پنجشنبه
				if ($thu === 'on') {
					$thu_status = '1';
					$thu_clock = $this->input->post('thu_clock', true);
					// جدا کردن ساعت و دقیقه
					$thuTime = explode(':', $thu_clock);
					(int) $thu_hours = $thuTime[0];
					(int) $thu_minute = $thuTime[1];
					//تبدیل ساعت شروع روز پنجشنبه به ثانیه
					(int) $thu_start_time = ($thu_hours * 60 * 60) + ($thu_minute * 60);
					//تبدیل ساعت پایان روز پنجشنبه به ثانیه
					(int) $thu_end_time = $thu_start_time + ($time_meeting * 60);

					if ($startDAY === $thu_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week6['thu'] = $thu_start_time + $miladiTime;
						$data['week'][] = $week6;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>' . 'جلسه' . $num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $thu_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $thu_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week6['thu'] = $thu_start_time + $miladiTime;
						$data['week6'][] = $week6;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$fri_start_day = $thu_start_day + 1;
				} else {
					if ($countDay > 0)
						$fri_start_day = $thu_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  جمعه
				if ($fri === 'on') {
					$fri_status = '1';
					$fri_clock = $this->input->post('fri_clock', true);
					// جدا کردن ساعت و دقیقه
					$friTime = explode(':', $fri_clock);
					(int) $fri_hours = $friTime[0];
					(int) $fri_minute = $friTime[1];
					//تبدیل ساعت شروع روز جمعه به ثانیه
					(int) $fri_start_time = ($fri_hours * 60 * 60) + ($fri_minute * 60);
					//تبدیل ساعت پایان روز جمعه به ثانیه
					(int) $fri_end_time = $fri_start_time + ($time_meeting * 60);

					if ($startDAY === $fri_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week7['fri'] = $fri_start_time + $miladiTime;
						$data['week7'][] = $week7;
						$result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
//                        echo '<br>جلسه' . $num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $fri_start_day, $start_year));
						$d = $start_year . '-' . $start_month . '-' . $fri_start_day;
						$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
						$week7['fri'] = $fri_start_time + $miladiTime;
						$data['week7'][] = $week7;
						$result['data'] = $data;
					}

					if ($firstDay === 'true')
						$sat_start_day = $fri_start_day + 1;
				} else {
					if ($countDay > 0)
						$sat_start_day = $fri_start_day + 1;
				}


				if ($num_meeting === (int) $number_of_meeting)
					break;
			}
		}

		if (!empty($result['data']['week1']))
			$res1 = $result['data']['week1'];
		if (!empty($result['data']['week2']))
			$res2 = $result['data']['week2'];
		if (!empty($result['data']['week3']))
			$res3 = $result['data']['week3'];
		if (!empty($result['data']['week4']))
			$res4 = $result['data']['week4'];
		if (!empty($result['data']['week5']))
			$res5 = $result['data']['week5'];
		if (!empty($result['data']['week6']))
			$res6 = $result['data']['week6'];
		if (!empty($result['data']['week7']))
			$res7 = $result['data']['week7'];


		//==========================================================================
		// مقایسه دوره جدید با دوره های استاد مربوطه
		//==========================================================================
		$employe = $this->base->get_data('employers', 'national_code', array('employee_id' => $employee_id));
		$courses = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', null, null, array('course_master' => $employe[0]->national_code));
		if (!empty($courses)) {
			foreach ($courses as $course):
				$course_id = [];
				$course_id = $course->course_id;
//            echo '<br>کد دوره: ' . $course_id;
				$old_start_date = [];
				$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
				$old_start_year = [];
				$old_start_month = [];
				$old_start_day = [];
				$old_array = [];
				require_once 'jdf.php';
				// جداکردن روز و ماه و سال از تاریخ شمسی
				$old_array = explode('-', $old_start_date);
				$old_start_year = $old_array[0];
				$old_start_month = $old_array[1];
				$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

				$old_time_meeting = $course->time_meeting;
				(int) $old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;
				// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
				$old_startDAY = 0;
				$old_sat = $course->sat_status;
				if ($old_sat === '1') {
					$old_sat_text = 'شنبه';
					if ($old_sat_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_sat_text;
					}
				}
				$old_sun = $course->sun_status;
				if ($old_sun === '1') {
					$old_sun_text = 'یکشنبه';
					if ($old_sun_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_sun_text;
					}
				}
				$old_mon = $course->mon_status;
				if ($old_mon === '1') {
					$old_mon_text = 'دوشنبه';
					if ($old_mon_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_mon_text;
					}
				}
				$old_tue = $course->tue_status;
				if ($old_tue === '1') {
					$old_tue_text = 'سه شنبه';
					if ($old_tue_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_tue_text;
					}
				}
				$old_wed = $course->wed_status;
				if ($old_wed === '1') {
					$old_wed_text = 'چهارشنبه';
					if ($old_wed_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_wed_text;
					}
				}
				$old_thu = $course->thu_status;
				if ($old_thu === '1') {
					$old_thu_text = 'پنجشنبه';
					if ($old_thu_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_thu_text;
					}
				}
				$old_fri = $course->fri_status;
				if ($old_fri === '1') {
					$old_fri_text = 'جمعه';
					if ($old_fri_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_fri_text;
					}
				}

				$old_num_meeting = 0;
				$old_countDay = 0;
				$old_firstDay = 'false';
				while ($old_num_meeting !== (int) $old_number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
					// روزهای برگزاری دوره
					//                                                                                  شنبه
					if ($old_sat === '1') {
						$old_sat_clock = $course->sat_clock;

						// جدا کردن ساعت و دقیقه
						$old_satTime = explode(':', $old_sat_clock);
						(int) $old_sat_hours = $old_satTime[0];
						(int) $old_sat_minute = $old_satTime[1];
						//تبدیل ساعت شروع روز شنبه به ثانیه
						(int) $old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
						//تبدیل ساعت پایان روز شنبه به ثانیه
						(int) $old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_sat_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

							if ($sat === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sat = $old_sat_start_time + $miladiTime;
								$old_week_sat_end = $old_sat_end_time + $miladiTime;
								if (!empty($res1)) {
									foreach ($res1 as $more) {
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
							if ($sat === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sat = $old_sat_start_time + $miladiTime;
								$old_week_sat_end = $old_sat_end_time + $miladiTime;
								if (!empty($res1)) {
									foreach ($res1 as $more) {
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_sun_start_day = $old_sat_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_sun_start_day = $old_sat_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  یکشنبه
					if ($old_sun === '1') {
						$old_sun_clock = $course->sun_clock;

						// جدا کردن ساعت و دقیقه
						$old_sunTime = explode(':', $old_sun_clock);
						(int) $old_sun_hours = $old_sunTime[0];
						(int) $old_sun_minute = $old_sunTime[1];
						//تبدیل ساعت شروع روز یکشنبه به ثانیه
						(int) $old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
						//تبدیل ساعت پایان روز یکشنبه به ثانیه
						(int) $old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_sun_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($sun === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sun = $old_sun_start_time + $miladiTime;
								$old_week_sun_end = $old_sun_end_time + $miladiTime;
								if (!empty($res2)) {
									foreach ($res2 as $more) {
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
							if ($sun === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sun = $old_sun_start_time + $miladiTime;
								$old_week_sun_end = $old_sun_end_time + $miladiTime;
								if (!empty($res2)) {
									foreach ($res2 as $more) {
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_mon_start_day = $old_sun_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_mon_start_day = $old_sun_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  دوشنبه
					if ($old_mon === '1') {
						$old_mon_clock = $course->mon_clock;

						// جدا کردن ساعت و دقیقه
						$old_monTime = explode(':', $old_mon_clock);
						(int) $old_mon_hours = $old_monTime[0];
						(int) $old_mon_minute = $old_monTime[1];
						//تبدیل ساعت شروع روز دوشنبه به ثانیه
						(int) $old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
						//تبدیل ساعت پایان روز دوشنبه به ثانیه
						(int) $old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_mon_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($mon === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_mon = $old_mon_start_time + $miladiTime;
								$old_week_mon_end = $old_mon_end_time + $miladiTime;
								if (!empty($res3)) {
									foreach ($res3 as $more) {
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
							if ($mon === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_mon = $old_mon_start_time + $miladiTime;
								$old_week_mon_end = $old_mon_end_time + $miladiTime;
								if (!empty($res3)) {
									foreach ($res3 as $more) {
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_tue_start_day = $old_mon_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_tue_start_day = $old_mon_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  سه شنبه
					if ($old_tue === '1') {
						$old_tue_clock = $course->tue_clock;

						// جدا کردن ساعت و دقیقه
						$old_tueTime = explode(':', $old_tue_clock);
						(int) $old_tue_hours = $old_tueTime[0];
						(int) $old_tue_minute = $old_tueTime[1];
						//تبدیل ساعت شروع روز سه شنبه به ثانیه
						(int) $old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
						//تبدیل ساعت پایان روز سه شنبه به ثانیه
						(int) $old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_tue_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($tue === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_tue = $old_tue_start_time + $miladiTime;
								$old_week_tue_end = $old_tue_end_time + $miladiTime;
								if (!empty($res4)) {
									foreach ($res4 as $more) {
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
							if ($tue === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_tue = $old_tue_start_time + $miladiTime;
								$old_week_tue_end = $old_tue_end_time + $miladiTime;
								if (!empty($res4)) {
									foreach ($res4 as $more) {
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
									}
								}
							}
						}
						if ($old_firstDay === 'true')
							$old_wed_start_day = $old_tue_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_wed_start_day = $old_tue_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  چهارشنبه
					if ($old_wed === '1') {
						$old_wed_clock = $course->wed_clock;

						// جدا کردن ساعت و دقیقه
						$old_wedTime = explode(':', $old_wed_clock);
						(int) $old_wed_hours = $old_wedTime[0];
						(int) $old_wed_minute = $old_wedTime[1];
						//تبدیل ساعت شروع روز چهارشنبه به ثانیه
						(int) $old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
						//تبدیل ساعت پایان روز چهارشنبه به ثانیه
						(int) $old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_wed_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($wed === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_wed = $old_wed_start_time + $miladiTime;
								$old_week_wed_end = $old_wed_end_time + $miladiTime;
								if (!empty($res5)) {
									foreach ($res5 as $more) {
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
							if ($wed === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_wed = $old_wed_start_time + $miladiTime;
								$old_week_wed_end = $old_wed_end_time + $miladiTime;
								if (!empty($res5)) {
									foreach ($res5 as $more) {
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_thu_start_day = $old_wed_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_thu_start_day = $old_wed_start_day + 1;
					}
					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;
					//                                                                                  پنجشنبه
					if ($old_thu === '1') {
						$old_thu_clock = $course->thu_clock;
						// جدا کردن ساعت و دقیقه
						$old_thuTime = explode(':', $old_thu_clock);
						(int) $old_thu_hours = $old_thuTime[0];
						(int) $old_thu_minute = $old_thuTime[1];
						//تبدیل ساعت شروع روز پنجشنبه به ثانیه
						(int) $old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
						//تبدیل ساعت پایان روز پنجشنبه به ثانیه
						(int) $old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_thu_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($thu === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_thu = $old_thu_start_time + $miladiTime;
								$old_week_thu_end = $old_thu_end_time + $miladiTime;
								if (!empty($res6)) {
									foreach ($res6 as $more) {
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
							if ($thu === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_thu = $old_thu_start_time + $miladiTime;
								$old_week_thu_end = $old_thu_end_time + $miladiTime;
								if (!empty($res6)) {
									foreach ($res6 as $more) {
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_fri_start_day = $old_thu_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_fri_start_day = $old_thu_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  جمعه
					if ($old_fri === '1') {
						$old_fri_clock = $course->fri_clock;
						// جدا کردن ساعت و دقیقه
						$old_friTime = explode(':', $old_fri_clock);
						(int) $old_fri_hours = $old_friTime[0];
						(int) $old_fri_minute = $old_friTime[1];
						//تبدیل ساعت شروع روز جمعه به ثانیه
						(int) $old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
						//تبدیل ساعت پایان روز جمعه به ثانیه
						(int) $old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_fri_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($fri === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_fri = $old_fri_start_time + $miladiTime;
								$old_week_fri_end = $old_fri_end_time + $miladiTime;
								if (!empty($res7)) {
									foreach ($res7 as $more) {
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
							if ($fri === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_fri = $old_fri_start_time + $miladiTime;
								$old_week_fri_end = $old_fri_end_time + $miladiTime;
								if (!empty($res7)) {
									foreach ($res7 as $more) {
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
											$error['teacher'] = 'تداخل زمانی با استاد انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_sat_start_day = $old_fri_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_sat_start_day = $old_fri_start_day + 1;
					}


					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					if (!empty($error['teacher'])) {
						$teacherError['thrError'][] = $error;
						$error['teacher'] = null;
					}
				}
			endforeach;
		}

		//==========================================================================
		// مقایسه دوره جدید با کلاس مربوطه
		//==========================================================================

		$course_class = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('courses.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.class_id' => $class_id, 'classes.class_id' => $class_id));
//        $course_class = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('courses.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.class_id' => $class_id, 'classes.class_id' => $class_id));
		if (!empty($course_class)) {
			foreach ($course_class as $course):
				$course_id = [];
				$course_id = $course->course_id;
//            echo '<br>کد دوره: ' . $course_id;
				$old_start_date = [];
				$old_start_date = $course->start_date;
//            echo '<br> زمان شروع دوره: '.json_encode($old_start_date);
				$old_start_year = [];
				$old_start_month = [];
				$old_start_day = [];
				$old_array = [];
				require_once 'jdf.php';
				// جداکردن روز و ماه و سال از تاریخ شمسی
				$old_array = explode('-', $old_start_date);
				$old_start_year = $old_array[0];
				$old_start_month = $old_array[1];
				$old_start_day = $old_sat_start_day = $old_sun_start_day = $old_mon_start_day = $old_tue_start_day = $old_wed_start_day = $old_thu_start_day = $old_fri_start_day = $old_array[2];

//            echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year));

				$old_time_meeting = $course->time_meeting;
				(int) $old_number_of_meeting = ($course->course_duration * 60) / $old_time_meeting;
//            echo '<br>تعداد جلسات: ' . (int) $old_number_of_meeting;
				// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
				$old_startDAY = 0;
				$old_sat = $course->sat_status;
				if ($old_sat === '1') {
					$old_sat_text = 'شنبه';
					if ($old_sat_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_sat_text;
					}
				}
				$old_sun = $course->sun_status;
				if ($old_sun === '1') {
					$old_sun_text = 'یکشنبه';
					if ($old_sun_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_sun_text;
					}
				}
				$old_mon = $course->mon_status;
				if ($old_mon === '1') {
					$old_mon_text = 'دوشنبه';
					if ($old_mon_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_mon_text;
					}
				}
				$old_tue = $course->tue_status;
				if ($old_tue === '1') {
					$old_tue_text = 'سه شنبه';
					if ($old_tue_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_tue_text;
					}
				}
				$old_wed = $course->wed_status;
				if ($old_wed === '1') {
					$old_wed_text = 'چهارشنبه';
					if ($old_wed_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_wed_text;
					}
				}
				$old_thu = $course->thu_status;
				if ($old_thu === '1') {
					$old_thu_text = 'پنجشنبه';
					if ($old_thu_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_thu_text;
					}
				}
				$old_fri = $course->fri_status;
				if ($old_fri === '1') {
					$old_fri_text = 'جمعه';
					if ($old_fri_text === jdate("l", jmktime(0, 0, 0, $old_start_month, $old_start_day, $old_start_year))) {
						$old_startDAY = $old_fri_text;
					}
				}

				$old_num_meeting = 0;
				$old_countDay = 0;
				$old_firstDay = 'false';
				while ($old_num_meeting !== (int) $old_number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
					// روزهای برگزاری دوره
					//                                                                                  شنبه
					if ($old_sat === '1') {
						$old_sat_clock = $course->sat_clock;

						// جدا کردن ساعت و دقیقه
						$old_satTime = explode(':', $old_sat_clock);
						(int) $old_sat_hours = $old_satTime[0];
						(int) $old_sat_minute = $old_satTime[1];
						//تبدیل ساعت شروع روز شنبه به ثانیه
						(int) $old_sat_start_time = ($old_sat_hours * 60 * 60) + ($old_sat_minute * 60);
						//تبدیل ساعت پایان روز شنبه به ثانیه
						(int) $old_sat_end_time = $old_sat_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_sat_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));
//                        $all['end_meeting'] = jdate("l j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_start_day, $old_start_year));

							if ($sat === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sat = $old_sat_start_time + $miladiTime;
								$old_week_sat_end = $old_sat_end_time + $miladiTime;
								if (!empty($res1)) {
									foreach ($res1 as $more) {
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
							if ($sat === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_sat_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sat = $old_sat_start_time + $miladiTime;
								$old_week_sat_end = $old_sat_end_time + $miladiTime;
								if (!empty($res1)) {
									foreach ($res1 as $more) {
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] < $old_week_sat && ($more['sat'] + ($time_meeting * 60) > $old_week_sat) && ($more['sat'] + ($time_meeting * 60) < $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && ($more['sat'] + ($time_meeting * 60) > $old_week_sat_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
										if ($more['sat'] > $old_week_sat && $more['sat'] < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) < $old_week_sat_end && $more['sat'] + ($time_meeting * 60) > $old_week_sat) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز شنبه: ' . jdate(" j F Y - H:i", jmktime($old_sat_hours, $old_sat_minute, 0, $old_start_month, $old_sat_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_sun_start_day = $old_sat_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_sun_start_day = $old_sat_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  یکشنبه
					if ($old_sun === '1') {
						$old_sun_clock = $course->sun_clock;

						// جدا کردن ساعت و دقیقه
						$old_sunTime = explode(':', $old_sun_clock);
						(int) $old_sun_hours = $old_sunTime[0];
						(int) $old_sun_minute = $old_sunTime[1];
						//تبدیل ساعت شروع روز یکشنبه به ثانیه
						(int) $old_sun_start_time = ($old_sun_hours * 60 * 60) + ($old_sun_minute * 60);
						//تبدیل ساعت پایان روز یکشنبه به ثانیه
						(int) $old_sun_end_time = $old_sun_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_sun_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($sun === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sun = $old_sun_start_time + $miladiTime;
								$old_week_sun_end = $old_sun_end_time + $miladiTime;
								if (!empty($res2)) {
									foreach ($res2 as $more) {
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
							if ($sun === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_sun_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_sun = $old_sun_start_time + $miladiTime;
								$old_week_sun_end = $old_sun_end_time + $miladiTime;
								if (!empty($res2)) {
									foreach ($res2 as $more) {
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] < $old_week_sun && ($more['sun'] + ($time_meeting * 60) > $old_week_sun) && ($more['sun'] + ($time_meeting * 60) < $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && ($more['sun'] + ($time_meeting * 60) > $old_week_sun_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
										if ($more['sun'] > $old_week_sun && $more['sun'] < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) < $old_week_sun_end && $more['sun'] + ($time_meeting * 60) > $old_week_sun) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز یکشنبه: ' . jdate(" j F Y - H:i", jmktime($old_sun_hours, $old_sun_minute, 0, $old_start_month, $old_sun_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_mon_start_day = $old_sun_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_mon_start_day = $old_sun_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  دوشنبه
					if ($old_mon === '1') {
						$old_mon_clock = $course->mon_clock;

						// جدا کردن ساعت و دقیقه
						$old_monTime = explode(':', $old_mon_clock);
						(int) $old_mon_hours = $old_monTime[0];
						(int) $old_mon_minute = $old_monTime[1];
						//تبدیل ساعت شروع روز دوشنبه به ثانیه
						(int) $old_mon_start_time = ($old_mon_hours * 60 * 60) + ($old_mon_minute * 60);
						//تبدیل ساعت پایان روز دوشنبه به ثانیه
						(int) $old_mon_end_time = $old_mon_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_mon_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($mon === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_mon = $old_mon_start_time + $miladiTime;
								$old_week_mon_end = $old_mon_end_time + $miladiTime;
								if (!empty($res3)) {
									foreach ($res3 as $more) {
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
							if ($mon === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_mon_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_mon = $old_mon_start_time + $miladiTime;
								$old_week_mon_end = $old_mon_end_time + $miladiTime;
								if (!empty($res3)) {
									foreach ($res3 as $more) {
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] < $old_week_mon && ($more['mon'] + ($time_meeting * 60) > $old_week_mon) && ($more['mon'] + ($time_meeting * 60) < $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && ($more['mon'] + ($time_meeting * 60) > $old_week_mon_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
										if ($more['mon'] > $old_week_mon && $more['mon'] < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) < $old_week_mon_end && $more['mon'] + ($time_meeting * 60) > $old_week_mon) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز دوشنبه: ' . jdate(" j F Y - H:i", jmktime($old_mon_hours, $old_mon_minute, 0, $old_start_month, $old_mon_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_tue_start_day = $old_mon_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_tue_start_day = $old_mon_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  سه شنبه
					if ($old_tue === '1') {
						$old_tue_clock = $course->tue_clock;

						// جدا کردن ساعت و دقیقه
						$old_tueTime = explode(':', $old_tue_clock);
						(int) $old_tue_hours = $old_tueTime[0];
						(int) $old_tue_minute = $old_tueTime[1];
						//تبدیل ساعت شروع روز سه شنبه به ثانیه
						(int) $old_tue_start_time = ($old_tue_hours * 60 * 60) + ($old_tue_minute * 60);
						//تبدیل ساعت پایان روز سه شنبه به ثانیه
						(int) $old_tue_end_time = $old_tue_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_tue_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($tue === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_tue = $old_tue_start_time + $miladiTime;
								$old_week_tue_end = $old_tue_end_time + $miladiTime;
								if (!empty($res4)) {
									foreach ($res4 as $more) {
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
							if ($tue === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_tue_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_tue = $old_tue_start_time + $miladiTime;
								$old_week_tue_end = $old_tue_end_time + $miladiTime;
								if (!empty($res4)) {
									foreach ($res4 as $more) {
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] < $old_week_tue && ($more['tue'] + ($time_meeting * 60) > $old_week_tue) && ($more['tue'] + ($time_meeting * 60) < $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && ($more['tue'] + ($time_meeting * 60) > $old_week_tue_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
										if ($more['tue'] > $old_week_tue && $more['tue'] < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) < $old_week_tue_end && $more['tue'] + ($time_meeting * 60) > $old_week_tue) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز سه شنبه: ' . jdate(" j F Y - H:i", jmktime($old_tue_hours, $old_tue_minute, 0, $old_start_month, $old_tue_start_day, $old_start_year));
										}
									}
								}
							}
						}
						if ($old_firstDay === 'true')
							$old_wed_start_day = $old_tue_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_wed_start_day = $old_tue_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  چهارشنبه
					if ($old_wed === '1') {
						$old_wed_clock = $course->wed_clock;

						// جدا کردن ساعت و دقیقه
						$old_wedTime = explode(':', $old_wed_clock);
						(int) $old_wed_hours = $old_wedTime[0];
						(int) $old_wed_minute = $old_wedTime[1];
						//تبدیل ساعت شروع روز چهارشنبه به ثانیه
						(int) $old_wed_start_time = ($old_wed_hours * 60 * 60) + ($old_wed_minute * 60);
						//تبدیل ساعت پایان روز چهارشنبه به ثانیه
						(int) $old_wed_end_time = $old_wed_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_wed_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($wed === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_wed = $old_wed_start_time + $miladiTime;
								$old_week_wed_end = $old_wed_end_time + $miladiTime;
								if (!empty($res5)) {
									foreach ($res5 as $more) {
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
							if ($wed === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_wed_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_wed = $old_wed_start_time + $miladiTime;
								$old_week_wed_end = $old_wed_end_time + $miladiTime;
								if (!empty($res5)) {
									foreach ($res5 as $more) {
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] < $old_week_wed && ($more['wed'] + ($time_meeting * 60) > $old_week_wed) && ($more['wed'] + ($time_meeting * 60) < $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && ($more['wed'] + ($time_meeting * 60) > $old_week_wed_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
										if ($more['wed'] > $old_week_wed && $more['wed'] < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) < $old_week_wed_end && $more['wed'] + ($time_meeting * 60) > $old_week_wed) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز چهارشنبه: ' . jdate(" j F Y - H:i", jmktime($old_wed_hours, $old_wed_minute, 0, $old_start_month, $old_wed_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_thu_start_day = $old_wed_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_thu_start_day = $old_wed_start_day + 1;
					}
					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;
					//                                                                                  پنجشنبه
					if ($old_thu === '1') {
						$old_thu_clock = $course->thu_clock;
						// جدا کردن ساعت و دقیقه
						$old_thuTime = explode(':', $old_thu_clock);
						(int) $old_thu_hours = $old_thuTime[0];
						(int) $old_thu_minute = $old_thuTime[1];
						//تبدیل ساعت شروع روز پنجشنبه به ثانیه
						(int) $old_thu_start_time = ($old_thu_hours * 60 * 60) + ($old_thu_minute * 60);
						//تبدیل ساعت پایان روز پنجشنبه به ثانیه
						(int) $old_thu_end_time = $old_thu_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_thu_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($thu === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_thu = $old_thu_start_time + $miladiTime;
								$old_week_thu_end = $old_thu_end_time + $miladiTime;
								if (!empty($res6)) {
									foreach ($res6 as $more) {
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
							if ($thu === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_thu_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_thu = $old_thu_start_time + $miladiTime;
								$old_week_thu_end = $old_thu_end_time + $miladiTime;
								if (!empty($res6)) {
									foreach ($res6 as $more) {
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] < $old_week_thu && ($more['thu'] + ($time_meeting * 60) > $old_week_thu) && ($more['thu'] + ($time_meeting * 60) < $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && ($more['thu'] + ($time_meeting * 60) > $old_week_thu_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
										if ($more['thu'] > $old_week_thu && $more['thu'] < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) < $old_week_thu_end && $more['thu'] + ($time_meeting * 60) > $old_week_thu) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' (کد ' . $course->course_id .') روز پنج شنبه: ' . jdate(" j F Y - H:i", jmktime($old_thu_hours, $old_thu_minute, 0, $old_start_month, $old_thu_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_fri_start_day = $old_thu_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_fri_start_day = $old_thu_start_day + 1;
					}

					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					//                                                                                  جمعه
					if ($old_fri === '1') {
						$old_fri_clock = $course->fri_clock;
						// جدا کردن ساعت و دقیقه
						$old_friTime = explode(':', $old_fri_clock);
						(int) $old_fri_hours = $old_friTime[0];
						(int) $old_fri_minute = $old_friTime[1];
						//تبدیل ساعت شروع روز جمعه به ثانیه
						(int) $old_fri_start_time = ($old_fri_hours * 60 * 60) + ($old_fri_minute * 60);
						//تبدیل ساعت پایان روز جمعه به ثانیه
						(int) $old_fri_end_time = $old_fri_start_time + ($old_time_meeting * 60);

						if ($old_startDAY === $old_fri_text) {
							$old_countDay++;
						}

						if ($old_countDay === 0) {

						} elseif ($old_countDay === 1 && $old_firstDay == 'false') {
							$old_num_meeting++;
							$old_firstDay = 'true';
//                        echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_start_day, $old_start_year));
							if ($fri === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_fri = $old_fri_start_time + $miladiTime;
								$old_week_fri_end = $old_fri_end_time + $miladiTime;
								if (!empty($res7)) {
									foreach ($res7 as $more) {
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
									}
								}
							}
						} elseif ($old_num_meeting != 0) {
							$old_num_meeting++;
//                        echo '<br>جلسه ' . $old_num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
							if ($fri === 'on') {
								$d = $old_start_year . '-' . $old_start_month . '-' . $old_fri_start_day;
								$miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
								$old_week_fri = $old_fri_start_time + $miladiTime;
								$old_week_fri_end = $old_fri_end_time + $miladiTime;
								if (!empty($res7)) {
									foreach ($res7 as $more) {
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] < $old_week_fri && ($more['fri'] + ($time_meeting * 60) > $old_week_fri) && ($more['fri'] + ($time_meeting * 60) < $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && ($more['fri'] + ($time_meeting * 60) > $old_week_fri_end)) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
										if ($more['fri'] > $old_week_fri && $more['fri'] < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) < $old_week_fri_end && $more['fri'] + ($time_meeting * 60) > $old_week_fri) {
											$error['class'] = 'تداخل زمانی با کلاس انتخاب شده در دوره ' . $course->lesson_name . ' روز جمعه: ' . jdate(" j F Y - H:i", jmktime($old_fri_hours, $old_fri_minute, 0, $old_start_month, $old_fri_start_day, $old_start_year));
										}
									}
								}
							}
						}

						if ($old_firstDay === 'true')
							$old_sat_start_day = $old_fri_start_day + 1;
					} else {
						if ($old_countDay > 0)
							$old_sat_start_day = $old_fri_start_day + 1;
					}


					if ($old_num_meeting === (int) $old_number_of_meeting)
						break;

					if (!empty($error['class'])) {
						$classError['classError'][] = $error;
						$error['class'] = null;
					}
				}
			endforeach;
		}

		if (!empty($teacherError))
			$this->session->set_flashdata($teacherError);
		if (!empty($classError))
			$this->session->set_flashdata($classError);
		redirect('test');
	}

	public function schedule_meetings($course_id) {
		$course = $this->base->get_data('courses', '*', array('course_id' => $course_id));
		require_once 'jdf.php';
		// جداکردن روز و ماه و سال از تاریخ شمسی
		$array = explode('-', $course[0]->start_date);
		$start_year = $array[0];
		$start_month = $array[1];
		$start_day = $sat_start_day = $sun_start_day = $mon_start_day = $tue_start_day = $wed_start_day = $thu_start_day = $fri_start_day = $array[2];


//        echo '<br>' . jmktime(0, 0, 0, $start_month, $start_day, $start_year);
//        echo "<br>تاریخ شروع دوره: " . jdate("l j F Y", jmktime(0, 0, 0, $start_month, $start_day, $start_year));
//        echo '<br>' . jmktime($hours, $minute, 0, $start_month, $start_day, $start_year);
		// تعداد جلسات دوره بر اساس مدت زمان دوره و زمان هر جلسه
		(int) $number_of_meeting = ($course[0]->course_duration * 60) / $course[0]->time_meeting;
//        echo '<br>تعداد جلسات: ' . (int) $number_of_meeting;
		// شرط برابری روز شروع دوره با یکی از روزهای انتخاب شده در هفته
		$startDAY = 0;
		$sat = $course[0]->sat_status;
		if ($sat === '1') {
			$sat_text = 'شنبه';
			if ($sat_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $sat_text;
			}
		}
		$sun = $course[0]->sun_status;
		if ($sun === '1') {
			$sun_text = 'یکشنبه';
			if ($sun_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $sun_text;
			}
		}
		$mon = $course[0]->mon_status;
		if ($mon === '1') {
			$mon_text = 'دوشنبه';
			if ($mon_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $mon_text;
			}
		}
		$tue = $course[0]->tue_status;
		if ($tue === '1') {
			$tue_text = 'سه شنبه';
			if ($tue_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $tue_text;
			}
		}
		$wed = $course[0]->wed_status;
		if ($wed === '1') {
			$wed_text = 'چهارشنبه';
			if ($wed_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $wed_text;
			}
		}
		$thu = $course[0]->thu_status;
		if ($thu === '1') {
			$thu_text = 'پنجشنبه';
			if ($thu_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $thu_text;
			}
		}
		$fri = $course[0]->fri_status;
		if ($fri === '1') {
			$fri_text = 'جمعه';
			if ($fri_text === jdate("l", jmktime(0, 0, 0, $start_month, $start_day, $start_year))) {
				$startDAY = $fri_text;
			}
		}

		if ($startDAY === 0) {
			echo '<br>تاریخ شروع دوره با هیچکدام از روزهای انتخاب شده هماهنگی ندارد';
		} else {
			$num_meeting = 0;
			$countDay = 0;
			$firstDay = 'false';
			$time_meeting = $course[0]->time_meeting;
			while ($num_meeting !== (int) $number_of_meeting) {
//                echo '<br>'.$num_meeting.' = '.(int)$number_of_meeting;
				// روزهای برگزاری دوره
				//                                                                                  شنبه
				if ($sat === '1') {
					// جدا کردن ساعت و دقیقه
					$satTime = explode(':', $course[0]->sat_clock);
					(int) $sat_hours = $satTime[0];
					(int) $sat_minute = $satTime[1];
					//تبدیل ساعت شروع روز شنبه به ثانیه
					(int) $sat_start_time = ($sat_hours * 60 * 60) + ($sat_minute * 60);
					//تبدیل ساعت پایان روز شنبه به ثانیه
					(int) $sat_end_time = $sat_start_time + ($time_meeting * 60);

					if ($startDAY === $sat_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week1['sat'] = $sat_start_time + $miladiTime;
//                        $data['week1'][] = $week1;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': شنبه ' . jdate(" j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $start_month, $sat_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $sat_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week1['sat'] = $sat_start_time + $miladiTime;
//                        $data['week1'][] = $week1;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$sun_start_day = $sat_start_day + 1;
				} else {
					if ($countDay > 0)
						$sun_start_day = $sat_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  یکشنبه
				if ($sun === '1') {
					// جدا کردن ساعت و دقیقه
					$sunTime = explode(':', $course[0]->sun_clock);
					(int) $sun_hours = $sunTime[0];
					(int) $sun_minute = $sunTime[1];
					//تبدیل ساعت شروع روز یکشنبه به ثانیه
					(int) $sun_start_time = ($sun_hours * 60 * 60) + ($sun_minute * 60);
					//تبدیل ساعت پایان روز یکشنبه به ثانیه
					(int) $sun_end_time = $sun_start_time + ($time_meeting * 60);

					if ($startDAY === $sun_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week2['sun'] = $sun_start_time + $miladiTime;
//                        $data['week2'][] = $week2;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': یکشنبه ' . jdate(" j F Y - H:i", jmktime($sun_hours, $sun_minute, 0, $start_month, $sun_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $sun_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week2['sun'] = $sun_start_time + $miladiTime;
//                        $data['week2'][] = $week2;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$mon_start_day = $sun_start_day + 1;
				} else {
					if ($countDay > 0)
						$mon_start_day = $sun_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  دوشنبه
				if ($mon === '1') {
					// جدا کردن ساعت و دقیقه
					$monTime = explode(':', $course[0]->mon_clock);
					(int) $mon_hours = $monTime[0];
					(int) $mon_minute = $monTime[1];
					//تبدیل ساعت شروع روز دوشنبه به ثانیه
					(int) $mon_start_time = ($mon_hours * 60 * 60) + ($mon_minute * 60);
					//تبدیل ساعت پایان روز دوشنبه به ثانیه
					(int) $mon_end_time = $mon_start_time + ($time_meeting * 60);

					if ($startDAY === $mon_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week3['mon'] = $mon_start_time + $miladiTime;
//                        $data['week3'][] = $week3;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': دوشنبه ' . jdate(" j F Y - H:i", jmktime($mon_hours, $mon_minute, 0, $start_month, $mon_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $mon_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week3['mon'] = $mon_start_time + $miladiTime;
//                        $data['week3'][] = $week3;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$tue_start_day = $mon_start_day + 1;
				} else {
					if ($countDay > 0)
						$tue_start_day = $mon_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  سه شنبه
				if ($tue === '1') {
					// جدا کردن ساعت و دقیقه
					$tueTime = explode(':', $course[0]->tue_clock);
					(int) $tue_hours = $tueTime[0];
					(int) $tue_minute = $tueTime[1];
					//تبدیل ساعت شروع روز سه شنبه به ثانیه
					(int) $tue_start_time = ($tue_hours * 60 * 60) + ($tue_minute * 60);
					//تبدیل ساعت پایان روز سه شنبه به ثانیه
					(int) $tue_end_time = $tue_start_time + ($time_meeting * 60);

					if ($startDAY === $tue_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week4['tue'] = $tue_start_time + $miladiTime;
//                        $data['week4'][] = $week4;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': سه شنبه ' . jdate(" j F Y - H:i", jmktime($tue_hours, $tue_minute, 0, $start_month, $tue_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $tue_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week4['tue'] = $tue_start_time + $miladiTime;
//                        $data['week4'][] = $week4;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$wed_start_day = $tue_start_day + 1;
				} else {
					if ($countDay > 0)
						$wed_start_day = $tue_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  چهارشنبه
				if ($wed === '1') {
					// جدا کردن ساعت و دقیقه
					$wedTime = explode(':', $course[0]->wed_clock);
					(int) $wed_hours = $wedTime[0];
					(int) $wed_minute = $wedTime[1];
					//تبدیل ساعت شروع روز چهارشنبه به ثانیه
					(int) $wed_start_time = ($wed_hours * 60 * 60) + ($wed_minute * 60);
					//تبدیل ساعت پایان روز چهارشنبه به ثانیه
					(int) $wed_end_time = $wed_start_time + ($time_meeting * 60);

					if ($startDAY === $wed_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week5['wed'] = $wed_start_time + $miladiTime;
//                        $data['week5'][] = $week5;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': چهارشنبه ' . jdate(" j F Y - H:i", jmktime($wed_hours, $wed_minute, 0, $start_month, $wed_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $wed_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week5['wed'] = $wed_start_time + $miladiTime;
//                        $data['week5'][] = $week5;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$thu_start_day = $wed_start_day + 1;
				} else {
					if ($countDay > 0)
						$thu_start_day = $wed_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  پنجشنبه
				if ($thu === '1') {
					// جدا کردن ساعت و دقیقه
					$thuTime = explode(':', $course[0]->thu_clock);
					(int) $thu_hours = $thuTime[0];
					(int) $thu_minute = $thuTime[1];
					//تبدیل ساعت شروع روز پنجشنبه به ثانیه
					(int) $thu_start_time = ($thu_hours * 60 * 60) + ($thu_minute * 60);
					//تبدیل ساعت پایان روز پنجشنبه به ثانیه
					(int) $thu_end_time = $thu_start_time + ($time_meeting * 60);

					if ($startDAY === $thu_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week6['thu'] = $thu_start_time + $miladiTime;
//                        $data['week'][] = $week6;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>' . 'جلسه' . $num_meeting . ': پنجشنبه ' . jdate(" j F Y - H:i", jmktime($thu_hours, $thu_minute, 0, $start_month, $thu_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $thu_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week6['thu'] = $thu_start_time + $miladiTime;
//                        $data['week6'][] = $week6;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$fri_start_day = $thu_start_day + 1;
				} else {
					if ($countDay > 0)
						$fri_start_day = $thu_start_day + 1;
				}

				if ($num_meeting === (int) $number_of_meeting)
					break;

				//                                                                                  جمعه
				if ($fri === '1') {
					// جدا کردن ساعت و دقیقه
					$friTime = explode(':', $course[0]->fri_clock);
					(int) $fri_hours = $friTime[0];
					(int) $fri_minute = $friTime[1];
					//تبدیل ساعت شروع روز جمعه به ثانیه
					(int) $fri_start_time = ($fri_hours * 60 * 60) + ($fri_minute * 60);
					//تبدیل ساعت پایان روز جمعه به ثانیه
					(int) $fri_end_time = $fri_start_time + ($time_meeting * 60);

					if ($startDAY === $fri_text) {
						$countDay++;
					}

					if ($countDay === 0) {

					} elseif ($countDay === 1 && $firstDay == 'false') {
						$num_meeting++;
						$firstDay = 'true';
						echo '<br>جلسه اول: ' . jdate("l j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week7['fri'] = $fri_start_time + $miladiTime;
//                        $data['week7'][] = $week7;
//                        $result['data'] = $data;
					} elseif ($num_meeting != 0) {
						$num_meeting++;
						echo '<br>جلسه' . $num_meeting . ': جمعه ' . jdate(" j F Y - H:i", jmktime($fri_hours, $fri_minute, 0, $start_month, $fri_start_day, $start_year));
//                        $d = $start_year . '-' . $start_month . '-' . $fri_start_day;
//                        $miladiTime = strtotime($this->calc->jalali_to_gregorian($d));
//                        $week7['fri'] = $fri_start_time + $miladiTime;
//                        $data['week7'][] = $week7;
//                        $result['data'] = $data;
					}

					if ($firstDay === 'true')
						$sat_start_day = $fri_start_day + 1;
				} else {
					if ($countDay > 0)
						$sat_start_day = $fri_start_day + 1;
				}


				if ($num_meeting === (int) $number_of_meeting)
					break;
			}
		}

		if (!empty($result['data']['week1']))
			$res1 = $result['data']['week1'];
		if (!empty($result['data']['week2']))
			$res2 = $result['data']['week2'];
		if (!empty($result['data']['week3']))
			$res3 = $result['data']['week3'];
		if (!empty($result['data']['week4']))
			$res4 = $result['data']['week4'];
		if (!empty($result['data']['week5']))
			$res5 = $result['data']['week5'];
		if (!empty($result['data']['week6']))
			$res6 = $result['data']['week6'];
		if (!empty($result['data']['week7']))
			$res7 = $result['data']['week7'];
	}

}
