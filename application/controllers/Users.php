<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->library('calc');
        $this->load->library('upload');
		$this->load->library('encryption');
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('errors/403');
    }

    public function test() {

//        $params = [
//            'allowStartStopRecording' => 'false',
//            'attendeePW' => '111222',
//            'autoStartRecording' => 'false',
//            'meetingID' => 'abc123',
//            'moderatorPW' => '333444',
//            'name' => 'abc123',
//            'record' => 'false',
//            'voiceBridge' => '77896',
//            'welcome' => '<br>Welcome to <b>%%CONFNAME%%</b>!'
//        ];
        $parameters = array(
            'allowStartStopRecording' => 'false',
            'createname' => 'random-3731702',
            'attendeePW' => 'ap',
            'autoStartRecording' => 'false',
            'meetingID' => 'random-3731702',
            'moderatorPW' => 'mp',

            'record' => 'false'
	);
        $queryBuild = http_build_query($parameters);
        $Shared_secret= 'FSyruzdFbVc99MNGSOOA6KG2OKryhqETpOo98HoiVM';
        $checkSum = sha1($queryBuild . $Shared_secret);

        $parameters['checksum']= $checkSum;
        $queryBuild = http_build_query($parameters);
//        $result = $queryBuild.$checkSum;
        echo $queryBuild;

        $endpoint = 'https://online.amoozkadeh.com/bigbluebutton/';


//        $checkSum = sha1($endpoint . $queryBuild . 'FSyruzdFbVc99MNGSOOA6KG2OKryhqETpOo98HoiVM');
        $lastUrl = $endpoint . 'api/create?' . $queryBuild;

//        echo $lastUrl;


//        $params = [
//            'allowStartStopRecording' => true,
//            'attendeePW' => 'ap',
//            'autoStartRecording' => false,
//            'meetingID' => 'random-8336598',
//            'moderatorPW' => 'mp',
//            'name' => 'random-8336598',
//            'record' => false,
//            'voiceBridge' => '77896',
//            'welcome' => '<br>Welcome to <b>%%CONFNAME%%</b>!'
//            ];
//        $queryBuild = http_build_query($params);
//        $Shared_secret = 'FSyruzdFbVc99MNGSOOA6KG2OKryhqETpOo98HoiVM';
//        $checkSum = sha1('create' . $queryBuild . $Shared_secret);
//        echo $checkSum;
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
//        $this->load->view('templates/navbar');
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    // ------------- modal courses in page content ------------- \\
    public function getClusterList($academy_id) {
        $data = $this->base->get_cluster_name($academy_id);
        echo json_encode($data);
    }

    public function getGroupList($cluster_id) {
        $data = $this->base->get_group_name($cluster_id);
        echo json_encode($data);
    }

    public function getStandardList($group_id) {
        $data = $this->base->get_standard_name($group_id);
        echo json_encode($data);
    }

    // ------------- End ------------- //

    public function reg_academy() {
//        $headerData['links'] = 'form-step-links';
//        $footerData['scripts'] = 'form-step-scripts';
//        $headerData['secondLinks'] = 'dropify-links';
//        $footerData['secondScripts'] = 'dropify-scripts';
        $contentData['province'] = $this->base->get_data('province', '*', NULL);
        $contentData['yield'] = 'reg-academy';
        $this->show_pages('ثبت آموزشگاه', 'content', $contentData);
    }

    public function getCityList($id) {
        $states = $this->base->city($id);
        echo json_encode($states);
    }

    public function insert_new_academy() {
        $this->form_validation->set_rules('fname', 'نام', 'required|max_length[60]');
        $this->form_validation->set_rules('lname', 'نام خانوادگی', 'required|max_length[60]');
        $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
        $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
        $this->form_validation->set_rules('type_academy', 'نوع آموزشگاه', 'required|max_length[60]');
        $this->form_validation->set_rules('academy_name', 'نام آموزشگاه', 'required|max_length[60]');
        $this->form_validation->set_rules('reference_code', 'کد معرف', 'exact_length[10]|numeric');

        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
        $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {

            $national_code = $this->input->post('national_code', true);
            if ($this->exist->exist_entry('academys_option', array('national_code' => $national_code))) {
                $this->session->set_flashdata('national-code-msg', 'این کد ملی قبلا ثبت شده است.');
                $this->reg_academy();
            } else {
				require_once 'jdf.php';
				$created_on = jdate('H:i:s - Y/n/j');
                $first_name = $this->input->post('fname', true);
                $last_name = $this->input->post('lname', true);
                $full_name = $first_name.' '.$last_name;
                $type_academy = $this->input->post('type_academy', true);
                $academy_name = $this->input->post('academy_name', true);

                $insert_array = array(
                    'm_first_name' => $first_name,
                    'm_last_name' => $last_name,
                    'national_code' => $national_code,
                    'phone_num' => $this->input->post('phone_num', true),
                    'type_academy' => $type_academy,
                    'academy_name' => $academy_name,
                    'reference_code' => $this->input->post('reference_code', true),
                    'province' => $this->input->post('province', true),
                    'city' => $this->input->post('city', true),
                    'logo' => 'education.png',
                    'manage_pic' => 'manager-icon.png',
					'created_on' => $created_on
                );
                $academy_id = $this->base->insert('academys_option', $insert_array);
                $this->sendSMSforAdmin($academy_id);
                $this->session->set_flashdata('successful-reg','ok');
                $this->session->set_flashdata(array(
                    'type_academy' => $type_academy,
                    'academy_name' => $academy_name,
                    'full_name' => $full_name
                    ));
                $this->reg_academy();
            }
        } else {
            $this->reg_academy();
        }
    }

    private function sendSMSforAdmin($academy_id) {
		$admin = $this->base->get_data('admin', 'phone_num', array('status_for_sms_activation' => '1'));
        foreach ($admin as $item) {
            $phone_num = $item->phone_num;
            $username = "mehritc";
            $password = '@utabpars1219';
            $from = "+983000505";
            $pattern_code = "wcnhj8qbmr";
            $to = array($phone_num);
            $input_data = array(
                "academy" => "$academy_id");
//        $url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $verify_code = curl_exec($handler);
        }
        return true;
    }

    public function guide() {
    	$contentData['yield'] = 'guide';
		$this->show_pages('amoozkadeh |آموزکده | راهنما', 'content', $contentData);
    }

    public function guide_register() {
        $contentData['yield'] = 'guide-register';
        $this->show_pages('amoozkadeh |آموزکده | راهنمای ثبت نام', 'content', $contentData);
    }

    public function academy_details($academy_en_name) {
        $academy = $this->base->get_data('academys_option', '*', array('academy_name_en' => $academy_en_name));
		$academy_id = $academy[0]->academy_id;
        $contentData['academy'] = $academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
        $contentData['courses'] = $courses = $this->base->get_triple4('*', 'courses', 'lessons', 'courses_employers', 'employers', 'courses.lesson_id=lessons.lesson_id', 'courses.course_id=courses_employers.course_id', 'courses_employers.employee_id=employers.employee_id', array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_employers.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
        $contentData['yield'] = 'academy-details';
        $this->show_pages('amoozkadeh |آموزکده | آموزشگاه ها', 'content', $contentData);
    }

    //    public function insert_new_academy() {
//        $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
//        $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
//        $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
//        $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
//        $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
//        $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
//        $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
//        $this->form_validation->set_rules('street', 'خیابان', 'required|max_length[180]');
//
//        $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
//        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
//        $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');
//        $this->form_validation->set_rules('postal_code', 'کد پستی', 'required|exact_length[10]');
//        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'required|max_length[12]');
//        $this->form_validation->set_message('required', '%s را وارد نمایید');
//        $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
//        $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
//        $this->form_validation->set_message('numeric', '%s معتبر نیست');
//
//        if ($this->form_validation->run() === TRUE) {
//
//        $national_code = $this->input->post('national_code', true);
//        if ($this->exist->exist_entry('academys_option', array('national_code' => $national_code))) {
//            $this->session->set_flashdata('national-code-msg', 'این کد ملی قبلا ثبت شده است.');
//            $this->reg_academy();
//        } else {
//            $result_of_upload = $this->upload_logo($_FILES);
//            if ($result_of_upload['result_image_name'] === '110') {
//                $insert_array = array(
//                    'first_name' => $this->input->post('fname', true),
//                    'last_name' => $this->input->post('lname', true),
//                    'national_code' => $national_code,
//                    'birthday' => $this->input->post('birthday', true),
//                    'marital_status' => $this->input->post('marital_status', true),
//                    'gender' => $this->input->post('gender', true),
//                    'academy_name' => $this->input->post('academy_name', true),
//                    'academy_name_en' => $this->input->post('academy_name_en', true),
//                    'academy_display_name' => $this->input->post('academy_display_name', true),
//                    'teacher_display_name' => $this->input->post('teacher_display_name', true),
//                    'student_display_name' => $this->input->post('student_display_name', true),
//                    'student_display_name_2' => $this->input->post('student_display_name2', true),
//                    'phone_num' => $this->input->post('mobile', true),
//                    'tell' => $this->input->post('phone_num', true),
//                    'email' => $this->input->post('email', true),
//                    'site' => $this->input->post('site', true),
//                    'province' => $this->input->post('province', true),
//                    'city' => $this->input->post('city', true),
//                    'address' => $this->input->post('address', true),
//                    'postal_code' => $this->input->post('postal_code', true),
//                    'Introduction' => $this->input->post('Introduction', true),
//                    'reference_code' => $this->input->post('reference_code', true),
//                );
//                $insert_array['logo'] = $result_of_upload['final_image_name'];
//                $this->base->insert('academys_option', $insert_array);
//                redirect('portal', 'refresh');
//            } else {
//                $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                $this->reg_academy();
//            }
//        }
//    }

    public function contact_us() {
        $contentData['yield'] = 'contact-us';
        $this->show_pages('amoozkadeh |آموزکده | تماس با ما', 'content', $contentData);
    }

    public function about_us() {
        $contentData['yield'] = 'about-us';
        $this->show_pages('amoozkadeh |آموزکده | درباره ما', 'content', $contentData);
    }

	public function demo_request() {
		$this->form_validation->set_rules('first_name', 'نام', 'required|max_length[40]');
		$this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[40]');
		$this->form_validation->set_rules('academy_name', 'نام آموزشگاه', 'required|max_length[100]');
		$this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');

		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
		$this->form_validation->set_message('numeric', '%s معتبر نیست');

		if ($this->form_validation->run() === TRUE) {
			$first_name = $this->input->post('first_name', true);
			$last_name = $this->input->post('last_name', true);
			$academy_name = $this->input->post('academy_name', true);
			$phone_num = $this->input->post('phone_num', true);

			if ($this->exist->exist_entry('demo_request', array('demo_phone_num' => $phone_num))) {
//				$txt = "testing";
//				$encrypttext = urlencode($this->encrypt->encode($txt));
				redirect(base_url('guide-register/?q=demo'), 'refresh');
			}else {
				$rand = (string)rand(1111, 9999);
				$demo_request = array(
					'demo_fname' => $first_name,
					'demo_lname' => $last_name,
					'demo_aname' => $academy_name,
					'demo_mobile' => $phone_num,
					'otp' => $rand,
					'case' => '3'
				);
				$this->session->set_userdata($demo_request);

				$this->send_otp($phone_num, $rand);

				$this->session->set_flashdata('authentication', 'ok.');
				redirect(base_url('../'), 'refresh');
			}
		} else {
			$form_validation = array (
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name'),
				'academy_name' => form_error('academy_name'),
				'phone_num' => form_error('phone_num')
			);
			$this->session->set_flashdata('error-validation', $form_validation);
//			$this->session->set_flashdata('authentication', 'ok.');
			redirect(base_url('../'), 'refresh');
		}
	}

	public function demo_resend_otp() {
		$phone_num = $this->session->userdata('demo_mobile');
		$rand =(string)rand(1111, 9999);
		$this->send_otp($phone_num, $rand);

		$demo_request['otp'] = $rand;
		$this->session->set_userdata($demo_request);
		$this->session->set_flashdata('authentication', 'ok.');
		redirect(base_url('../'), 'refresh');
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

	public function demo_auth(){
		$this->form_validation->set_rules('user_otp', 'کداحراز هویت', 'required|exact_length[4]|numeric');
		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
		$this->form_validation->set_message('numeric', '%s معتبر نیست');

		if ($this->form_validation->run() === TRUE) {
			$otp = $this->session->userdata('otp');
			$user_otp = $this->input->post('user_otp');
			if ($otp === $user_otp) {
					require_once 'jdf.php';
					$created_on = jdate('H:i:s - Y/n/j');
					$demo_request = array(
						'demo_fname' => $this->session->userdata('demo_fname'),
						'demo_lname' => $this->session->userdata('demo_lname'),
						'demo_academy_name' => $this->session->userdata('demo_aname'),
						'demo_phone_num' => $this->session->userdata('demo_mobile'),
						'created_on' => $created_on
					);
					$this->base->insert('demo_request', $demo_request);
					$this->session->unset_userdata($demo_request);
					redirect(base_url('guide-register'),'refresh');
			}else{
				$this->session->set_flashdata('error-otp', 'کد وارد شده صحیح نیست.');
				redirect(base_url('../'),'refresh');
			}
		}else{
			$form_validation_otp=array(
				'user_otp' => form_error('user_otp'),
			);
			$this->session->set_flashdata('error-user-otp', $form_validation_otp);
			redirect(base_url('../'),'refresh');
		}
	}
	function search_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data =  $this->base->search($keyword);
		foreach ($data as $item) {
			$results[] = $this->base->get_triple4('*', 'courses', 'lessons', 'courses_employers', 'employers', 'courses.lesson_id=lessons.lesson_id', 'courses.course_id=courses_employers.course_id', 'courses_employers.employee_id=employers.employee_id', array('courses.lesson_id'=> $item->lesson_id));
		}
		if(!empty($results)) {
			// Convert two-dimensional array to one-dimensional
			$results = call_user_func_array('array_merge', $results);
			// end
			$contentData['results'] = $results;
		}
		$contentData['course_academy'] = $this->base->get_data('academys_option', '*');
		$contentData['provinces'] = $this->base->get_data('province', '*');
		$contentData['citys'] = $this->base->get_data('city', '*');
		$contentData['yield'] = 'result_view';
		$contentData['keyword'] = $keyword;
		$this->show_pages($title = 'نتایج جستجو', 'content', $contentData);


	}


}
