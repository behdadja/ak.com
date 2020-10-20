<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adminator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		$this->load->library('calc');
		$this->load->library('upload');
		$this->load->library('encryption');
	}

	public function error_403() {
		$this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیر سایت وارد شوید.');
		$this->load->view('errors/403');
	}

	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}

	public function index() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$contentData['admin'] = 'true';
			$this->show_pages($title = 'مدیریت آموزکده', 'admin-content', $contentData);
		} else{
			$this->load->view('admin/admin_login');
		}
	}

	public function manage_academy() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$contentData['academys'] = $this->base->get_data('academys_option', '*', null, null, null, null, null, null, null, null, 'academy_id');
			$contentData['admin'] = 'manage-academys';
			$headerData['links'] = 'bootstrap-jquery-links';
			$this->show_pages($title = 'مديريت آموزشگاه ها', 'admin-content', $contentData, $headerData);
		}else
			redirect('error-403','refresh');
	}

	public function manage_teachers() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$contentData['teachers'] = $this->base->get_data('employers', '*', null, null, null, null, null, null, null, null, 'employee_id');
			$contentData['admin'] = 'manage-teachers';
			$headerData['links'] = 'bootstrap-jquery-links';
			$this->show_pages($title = 'مديريت اساتید', 'admin-content', $contentData, $headerData);
		}else
			redirect('error-403','refresh');
	}

	public function manage_students() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$contentData['students'] = $this->base->get_data('students', '*', null, null, null, null, null, null, null, null, 'student_id');
			$contentData['admin'] = 'manage-students';
			$headerData['links'] = 'bootstrap-jquery-links';
			$this->show_pages($title = 'مديريت دانشجوها', 'admin-content', $contentData, $headerData);

		}else
			redirect('error-403','refresh');
	}

	public function edit_academy() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$academy_id = $this->input->post('academy_id', true);
			$contentData['province'] = $this->base->get_data('province', '*', NULL);
			$contentData['city'] = $this->base->get_data('city', '*', NULL);
			$contentData['academy'] = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
			$contentData['admin'] = 'edit-academy';
			$this->show_pages('amoozkadeh |آموزکده | ویرایش آموزشگاه', 'admin-content', $contentData);
		}else
			redirect('error-403','refresh');
	}

	public function update_academy() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$this->form_validation->set_rules('fname', 'نام', 'required|max_length[60]');
			$this->form_validation->set_rules('lname', 'نام خانوادگی', 'required|max_length[60]');
			$this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
			$this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');

			$this->form_validation->set_rules('academy_display_name', 'پیشوند نام آموزشگاه', 'max_length[60]');
			$this->form_validation->set_rules('academy_name', 'نام آموزشگاه', 'required|max_length[60]');
			$this->form_validation->set_rules('type_academy', 'نوع آموزشگاه', 'required|max_length[60]');
			$this->form_validation->set_rules('teacher_display_name', 'لقب آموزش دهنده', 'required|max_length[60]');
			$this->form_validation->set_rules('student_display_name', 'لقب آموزش پذیر', 'required|max_length[60]');
			$this->form_validation->set_rules('student_display_name_2', 'لقب دوم آموزش پذیر', 'required|max_length[60]');

			$this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
			$this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
			$this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
			$this->form_validation->set_rules('address', 'خیابان', 'required|max_length[180]');

			$this->form_validation->set_message('required', '%s را وارد نمایید');
			$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
			$this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
			$this->form_validation->set_message('numeric', '%s معتبر نیست');

			if ($this->form_validation->run() === TRUE) {

				$national_code = $this->input->post('national_code', true);
				$academy_id = $this->input->post('academy_id', true);

				$insert_array = array(
					'm_first_name' => $this->input->post('fname', true),
					'm_last_name' => $this->input->post('lname', true),
					'father_name' => $this->input->post('father_name', true),
					'national_code' => $national_code,
					'birthday' => $this->input->post('birthday', true),
					'marital_status' => $this->input->post('marital_status', true),
					'gender' => $this->input->post('gender', true),
					'academy_name' => $this->input->post('academy_name', true),
					'academy_name_en' => $this->input->post('academy_name_en', true),
					'academy_display_name' => $this->input->post('academy_display_name', true),
					'teacher_display_name' => $this->input->post('teacher_display_name', true),
					'student_display_name' => $this->input->post('student_display_name', true),
					'student_display_name_2' => $this->input->post('student_display_name_2', true),
					'phone_num' => $this->input->post('phone_num', true),
					'tell' => $this->input->post('tell', true),
					'email' => $this->input->post('email', true),
					'site' => $this->input->post('site', true),
					'province' => $this->input->post('province', true),
					'city' => $this->input->post('city', true),
					'address' => $this->input->post('address', true),
					'postal_code' => $this->input->post('postal_code', true),
					'Introduction' => $this->input->post('Introduction', true),
					'reference_code' => $this->input->post('reference_code', true),
				);

				$this->base->update('academys_option', array('academy_id' => $academy_id), $insert_array);
				$this->session->set_flashdata('update-msg', 'ویرایش با موفقیت انجام شد');
				redirect('manage-academys', 'refresh');
			} else {
				$this->edit_academy();
			}
		}else
			redirect('error-403','refresh');
	}

	///////     manager update picture
	public function manager_update_pic() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$academy_id = $this->input->post('academy_id');

			$result_of_upload = $this->upload_manage_pic($_FILES);
			if ($result_of_upload['result_image_name'] === '110') {
				$manager_info = $this->base->get_data('academys_option', 'manage_pic', array('academy_id' => $academy_id));
				if (!empty($manager_info) && $manager_info[0]->manage_pic !== 'manager-icon.png') {
					unlink('./portal/assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
					unlink('./portal/assets/profile-picture/' . $manager_info[0]->manage_pic);
				}
				$insert_array['manage_pic'] = $result_of_upload['final_image_name'];
				$this->base->update('academys_option', array('academy_id' => $academy_id), $insert_array);
				$this->edit_academy();
			} else {
				$this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
				$this->edit_academy();
			}
		}else
			redirect('error-403','refresh');
	}

	///////     manager update logo
	public function manager_update_logo() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {

			$academy_id = $this->input->post('academy_id');

			$result_of_upload = $this->upload_academy_logo($_FILES);
			if ($result_of_upload['result_image_name'] === '110') {
				$manager_info = $this->base->get_data('academys_option', 'logo', array('academy_id' => $academy_id));
				if (!empty($manager_info) && $manager_info[0]->logo !== 'education.png') {
					unlink('./portal/assets/profile-picture/thumb/' . $manager_info[0]->logo);
					unlink('./portal/assets/profile-picture/' . $manager_info[0]->logo);
				}
				$insert_array['logo'] = $result_of_upload['final_image_name'];
				$this->base->update('academys_option', array('academy_id' => $academy_id), $insert_array);
				$this->edit_academy();
			} else {
				$this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
				$this->edit_academy();
			}
		}else
			redirect('error-403','refresh');
	}

	public function upload_academy_logo() {
		$this->load->library('upload');
		$config_array = array(
			'upload_path' => 'portal/assets/profile-picture',
			'allowed_types' => 'jpg|png|jpeg',
			'max_size' => 10240,
			'file_name' => time()
		);
		$this->upload->initialize($config_array);

		if ($this->upload->do_upload('logo')) {
			$pic_info = $this->upload->data();
			$pic_name = $pic_info['file_name'];
			$this->load->library('image_lib');
			$config_array = array(
				'source_image' => 'portal/assets/profile-picture/' . $pic_name,
				'new_image' => 'portal/assets/profile-picture/thumb/' . $pic_name,
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
			$final_image_name = 'education.png';
		}
		$result = array(
			'img_name' => $result_image_name,
			'final_image_name' => $final_image_name,
			'result_image_name' => $result_image_name
		);
		return $result;
	}

	public function upload_manage_pic() {
		$this->load->library('upload');
		$config_array = array(
			'upload_path' => 'portal/assets/profile-picture',
			'allowed_types' => 'jpg|png|jpeg',
			'max_size' => 10240,
			'file_name' => time()
		);
		$this->upload->initialize($config_array);

		if ($this->upload->do_upload('manage_pic')) {
			$pic_info = $this->upload->data();
			$pic_name = $pic_info['file_name'];
			$this->load->library('image_lib');
			$config_array = array(
				'source_image' => 'portal/assets/profile-picture/' . $pic_name,
				'new_image' => 'portal/assets/profile-picture/thumb/' . $pic_name,
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
			$final_image_name = 'manager-icon.png';
		}

		$result = array(
			'img_name' => $result_image_name,
			'final_image_name' => $final_image_name,
			'result_image_name' => $result_image_name
		);
		return $result;
	}

	public function activation_academy() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$academy_id = $this->input->post('academy_id', true);
			$status = $this->input->post('status', true);
			if ($status === '0'):
				$update_array['status'] = '1';
			else:
				$update_array['status'] = '0';
			endif;
			$this->base->update('academys_option', array('academy_id' => $academy_id), $update_array);
			$academy_info = $this->base->get_data('academys_option','academy_display_name, academy_name, phone_num, status', array('academy_id'=>$academy_id));
			$academy = $academy_info[0]->academy_display_name.' '.$academy_info[0]->academy_name;
			if($academy_info[0]->status == '0'){
				$status = 'غیرفعال';
				$description = 'لطفا جهت رفع مشکل در قسمت تماس با در سامانه، موضوع را پیگیری کنید.';
			}else{
				$status = 'فعال';
				$description = 'از انتخاب شما سپاسگذاریم.';
			}
			$this->smsForManagerAcademy($academy, $status, $description, $academy_info[0]->phone_num);
			$this->edit_academy();
		}else
			redirect('error-403','refresh');
	}

	public function smsForManagerAcademy($academy, $status, $description, $phone_num) {
		$username = "mehritc";
		$password = '@utabpars1219';
		$from = "+983000505";
		$pattern_code = "rf0bnccguu";
		$to = array($phone_num);
		$input_data = array(
			"academy" => "$academy",
			"status" => "$status",
			"description" => "$description"
		);
		$url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
//        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$verify_code = curl_exec($handler);
	}

	public function online_course(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$contentData['online_course'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', array('courses.type_holding' => '1'));
			$contentData['admin'] = 'online-course';
			$headerData['links'] = 'bootstrap-jquery-links';
			$this->show_pages($title = 'دوره های آنلاین', 'admin-content', $contentData);
		}else
			redirect('error-403','refresh');
	}

	public function insert_link_online(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$course_id = $this->input->post('course_id');
			$detail_online['user']= $this->input->post('user');
			$detail_online['pass']= $this->input->post('pass');
			$detail_online['link_teacher']= $this->input->post('link_teacher');
			$detail_online['link_student']= $this->input->post('link_student');
			$detail_online = json_encode($detail_online);
			$update_array['detail_online'] = $detail_online;

			$this->base->update('courses', array('course_id'=>$course_id), $update_array);
			$this->session->set_flashdata('successfully','لینک با موفقیت ثبت شد');
			$this->online_course();
		}else
			redirect('error-403','refresh');
	}

	public function edit_link_online(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$course_id = $this->input->post('course_id');
			$detail_online['user']= $this->input->post('user');
			$detail_online['pass']= $this->input->post('pass');
			$detail_online['link_teacher']= $this->input->post('link_teacher');
			$detail_online['link_student']= $this->input->post('link_student');
			$detail_online = json_encode($detail_online);
			$update_array['detail_online'] = $detail_online;

			$this->base->update('courses', array('course_id'=>$course_id), $update_array);
			$this->session->set_flashdata('update','تغییرات با موفقیت ثبت شد');
			$this->online_course();
		}else
			redirect('error-403','refresh');
	}

	public function login_to_academy_profile(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$national_code = $this->input->post('national_code', true);
			$ip_address = $this->input->ip_address();
			$academy = $this->base->get_data('academys_option', '*', array('national_code' => $national_code));
			$session_data = array(
				'academy_id' => $academy[0]->academy_id,
				'manager_nc' => $academy[0]->national_code,
				'type_academy' => $academy[0]->type_academy,
				'academy_name' => $academy[0]->academy_name,
				'academyDName' => $academy[0]->academy_display_name,
				'studentDName' => $academy[0]->student_display_name,
				'studentDName2' => $academy[0]->student_display_name_2,
				'teacherDName' => $academy[0]->teacher_display_name,
				'full_name' => $academy[0]->m_first_name . " " . $academy[0]->m_last_name,
				'name' => $academy[0]->m_first_name,
				'session_id' => $national_code,
				'phone_num' => $academy[0]->phone_num,
				'manage_pic' => $academy[0]->manage_pic,
				'logo' => $academy[0]->logo,
				'status' => $academy[0]->status,
				'ip_address' => $ip_address,
				'user_type' => 'managers',
				'logged_in' => true
			);
			$this->session->set_userdata($session_data);
			redirect('portal/profile', 'refresh');
		}else
			redirect('error-403','refresh');
	}

	public function login_to_teacher_profile(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$national_code = $this->input->post('national_code', true);
			$ip_address = $this->input->ip_address();
			$result = $this->base->get_data('employers', '*', array('national_code' => $national_code));
			$userInfo = $this->base->get_data('employers', '*', array('national_code' => $national_code));
			$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $userInfo[0]->academy_id));
			$session_data = array(
				'academy_id' => $academy[0]->academy_id,
				'manager_nc' => $academy[0]->national_code,
				'academy_name' => $academy[0]->academy_name,
				'academyDName' => $academy[0]->academy_display_name,
				'studentDName' => $academy[0]->student_display_name,
				'studentDName2' => $academy[0]->student_display_name_2,
				'teacherDName' => $academy[0]->teacher_display_name,
				'manage_name' => $academy[0]->m_first_name . " " . $academy[0]->m_last_name,
				'manage_pic' => $academy[0]->manage_pic,
				'logo' => $academy[0]->logo,
				'full_name' => $userInfo[0]->first_name . " " . $userInfo[0]->last_name,
				'name' => $userInfo[0]->first_name,
				'session_id' => $national_code,
				'phone_num' => $userInfo[0]->phone_num,
				'ip_address' => $ip_address,
				'pic_name' => $userInfo[0]->pic_name,
				'user_type' => 'teachers',
				'logged_in' => true
			);
			$this->session->set_userdata($session_data);
			redirect('portal/teacher/profile', 'refresh');
		}else
			redirect('error-403','refresh');
	}

	public function login_to_student_profile(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$national_code = $this->input->post('national_code', true);
			$ip_address = $this->input->ip_address();
			$result = $this->base->get_data('students', '*', array('national_code' => $national_code));
			$userInfo = $this->base->get_data('students', '*', array('national_code' => $national_code));
			$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $userInfo[0]->academy_id));
			$session_data = array(
				'academy_id' => $academy[0]->academy_id,
				'manager_nc' => $academy[0]->national_code,
				'academy_name' => $academy[0]->academy_name,
				'academyDName' => $academy[0]->academy_display_name,
				'studentDName' => $academy[0]->student_display_name,
				'studentDName2' => $academy[0]->student_display_name_2,
				'teacherDName' => $academy[0]->teacher_display_name,
				'manage_name' => $academy[0]->m_first_name . " " . $academy[0]->m_last_name,
				'manage_pic' => $academy[0]->manage_pic,
				'logo' => $academy[0]->logo,
				'full_name' => $userInfo[0]->first_name . " " . $userInfo[0]->last_name,
				'name' => $userInfo[0]->first_name,
				'session_id' => $national_code,
				'phone_num' => $userInfo[0]->phone_num,
				'ip_address' => $ip_address,
				'pic_name' => $userInfo[0]->pic_name,
				'user_type' => 'students',
				'logged_in' => true
			);
			$this->session->set_userdata($session_data);
			redirect('portal/student/profile', 'refresh');
		}else
			redirect('error-403','refresh');
	}

	public function requests(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$contentData['courses'] = $this->get_join->get_data4('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', 'academys_option','academys_option.academy_id=courses.academy_id' , array('courses.display_status_in_system !=' => '0'));
			$contentData['admin'] = 'requests';
			$headerData['links'] = 'bootstrap-jquery-links';
			$this->show_pages($title = 'درخواست ها', 'admin-content', $contentData);
		}else
			redirect('error-403','refresh');
	}

	public function details_course(){
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$course_id = $this->input->post('course_id', true);
			$contentData['courses'] = $this->get_join->get_data4('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', 'academys_option','academys_option.academy_id=courses.academy_id' , array('courses.course_id' => $course_id));
			$contentData['admin'] = 'details-course';
			$this->show_pages($title = 'جزئیات دوره', 'admin-content', $contentData);
		}else
			redirect('error-403','refresh');
	}

	public function display_status_course_in_system() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$course_id = $this->input->post('course_id', true);
			$status = $this->input->post('status', true);
			if($status == '1'){
				$update_array = array('display_status_in_system' => '2');
			}if($status == '2'){
				$update_array = array('display_status_in_system' => '1');
			}
			$this->base->update('courses', array('course_id' => $course_id), $update_array);
			redirect('requests');
		}else
			redirect('error-403','refresh');
	}

	public function send_otp($phone_num, $rand) {
		$username = "mehritc";
		$password = '@utabpars1219';
		$from = "+983000505";
		$pattern_code = "lx19h6cjh9";
		$to = array($phone_num);
		$input_data = array(
			"code" => "$rand");
		$url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
//        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$verify_code = curl_exec($handler);
	}

	public function demo_phone_num_request(){
		$this->form_validation->set_rules('na_code', 'کدملی اشتباه است', 'required|exact_length[10]|numeric');

		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
		$this->form_validation->set_message('numeric', '%s معتبر نیست');

		if ($this->form_validation->run() === TRUE) {
			$na_code = $this->input->post('na_code', true);

			if ($this->exist->exist_entry('admin', array('national_code' => $na_code))) {
//				$txt = "testing";
//				$encrypttext = urlencode($this->encrypt->encode($txt));
//				redirect(base_url('guide-register/?q=demo'), 'refresh');
				$phone_num = $this->base->get_data('admin', 'phone_num', array('national_code'=> $na_code));
				//var_dump($na_code);
				//var_dump($phone_num);
				$num = get_object_vars($phone_num[0]);
				//echo $num['phone_num'];


				$rand = (string)rand(1111, 9999);
				$demo_request = array(
					'demo_mobile' => $num['phone_num'],
					'otp' => $rand,
					'case' => '3'
				);
				$this->session->set_userdata('code',$demo_request);
				$this->session->set_flashdata('authentication', 'ok.');
				//$this->send_otp($num['phone_num'], $rand);
			}else {
				$this->session->set_flashdata('error-validation', 'not ok');
			}
		} else {
			$form_validation=array(
				'na_code' => form_error('na_code')
			);
			$this->session->set_flashdata('fail', 'فرمت کدملی معتبر نیست');
		}
		$this->index();
	}

	public function validCode(){
		$code['validate_code'] = $this->input->post('validate_code');
		$check = $this->session->userdata('code');
		if ($code['validate_code'] == $check['otp']){
			$contentData['admin'] = 'true';

			$data = $this->base->get_data('admin', 'full_name,national_code', array('phone_num'=>$check['demo_mobile']));
			$admin_info = array(
				'full_name' => $data[0]->full_name,
				'session_id' => $data[0]->national_code,
				'user_type' => 'admin'
			);
			$this->session->set_userdata($admin_info);
			redirect('/admin');
		} else{
			$this->session->set_flashdata('authentication', 'ok.');
			redirect('/admin');
		}
	}
	public function logout() {
		$sessId = $this->session->userdata('session_id');
		$userType = $this->session->userdata('user_type');
		if (!empty($sessId) && $userType === 'admin') {
			$session_id = $this->session->userdata('session_id');
			$sess_array = array(
				'full_name',
				'session_id',
				'user_type'
			);

			$this->session->unset_userdata($sess_array);
			$this->session->sess_destroy($session_id);
			redirect('/admin', 'refresh');
		}else
			redirect('error-403', 'refresh');
	}

}
