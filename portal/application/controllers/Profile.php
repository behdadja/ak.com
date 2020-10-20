<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->library('calc');
        $this->load->library('upload');
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

    private function viewsCountProcess($arr) {
        $viewArr = [];
        foreach ($arr as $key => $value) {
            $viewArr[] = $value->ip_address;
        }
        return count(array_unique($viewArr));
    }

    private function viewsCountProcessAll($arr) {
        $viewArr = [];
        foreach ($arr as $key => $value) {
            $viewArr[] = $value;
        }
        return count($viewArr);
    }

    private function getCountOfOnlineExams() {
        $viewArr = $this->base->get_data('online_exams', 'exam_code');
        $resultArr = [];
        foreach ($viewArr as $key => $value) {
            $resultArr[] = $value->exam_code;
        }
        return count(array_unique($resultArr));
    }

    private function weekViw() {
        $todayViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('+1 day') . " AND " . 'timestamp>' . strtotime('-1 day'));
        $todayViewsCount = $this->viewsCountProcess($todayViews);
        $yesterdayViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('now') . " AND " . 'timestamp>' . strtotime('-2 day'));
        $yesterdayViewsCount = $this->viewsCountProcess($yesterdayViews);
        $twoDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-1 day') . " AND " . 'timestamp>' . strtotime('-3 day'));
        $twoDaysViewsCount = $this->viewsCountProcess($twoDaysGoViews);
        $threeDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-2 day') . " AND " . 'timestamp>' . strtotime('-4 day'));
        $threeDaysViewsCount = $this->viewsCountProcess($threeDaysGoViews);
        $fourDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-3 day') . " AND " . 'timestamp>' . strtotime('-5 day'));
        $fourDaysViewsCount = $this->viewsCountProcess($fourDaysGoViews);
        $fiveDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-4 day') . " AND " . 'timestamp>' . strtotime('-6 day'));
        $fiveDaysViewsCount = $this->viewsCountProcess($fiveDaysGoViews);
        $sixDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-5 day') . " AND " . 'timestamp>' . strtotime('-7 day'));
        $sixDaysViewsCount = $this->viewsCountProcess($sixDaysGoViews);
        $sevenDaysGoViews = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp<' . strtotime('-6 day') . " AND " . 'timestamp>' . strtotime('-8 day'));
        $sevenDaysViewsCount = $this->viewsCountProcess($sevenDaysGoViews);
        $resultArray = [$twoDaysViewsCount, $yesterdayViewsCount, $twoDaysViewsCount, $threeDaysViewsCount, $fourDaysViewsCount, $fiveDaysViewsCount, $sixDaysViewsCount, $sevenDaysViewsCount];
        // print_r($resultArray);
        return($resultArray);
    }

    private function monthView() {
        $where = 'timestamp < ' . strtotime("last day of -1 month") . " AND " . 'timestamp > ' . strtotime("first day of -1 month");
        $lastMontView = $this->base->get_data('ci_sessions', 'ip_address', $where);
        $lastMontViewCount = $this->viewsCountProcess($lastMontView);

        $firstDayOfLastTwoMonth = strtotime("first day of -2 month");
        $lastDayOfLastTwoMonth = strtotime("last day of -2 month");
        $lastTwoMontView = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp < ' . $lastDayOfLastTwoMonth . " AND " . 'timestamp > ' . $firstDayOfLastTwoMonth);
        $lastTwoMontViewCount = $this->viewsCountProcess($lastTwoMontView);

        $firstDayOfLastthreeMonth = strtotime("first day of -3 month");
        $lastDayOfLastthreeMonth = strtotime("last day of -3 month");
        $lastthreeMontView = $this->base->get_data('ci_sessions', 'ip_address', 'timestamp < ' . $lastDayOfLastthreeMonth . " AND " . 'timestamp > ' . $firstDayOfLastthreeMonth);
        $lastthreeMontViewCount = $this->viewsCountProcess($lastthreeMontView);
        $resultArray = [$lastMontViewCount, $lastTwoMontViewCount, $lastthreeMontViewCount];
        return $resultArray;
    }

    public function show_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['user_info'] = $this->base->get_data('academys_option', '*', array('national_code' => $sessId, 'academy_id' => $academy_id));
            $contentData['debtors'] = $this->get_join->get_data('financial_situation', 'students', 'financial_situation.student_nc=students.national_code', null, null, array('final_situation' => -1, 'financial_situation.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            $contentData['pre_registration'] = $this->base->get_data('students', '*', array('student_status' => 0, 'academy_id' => $academy_id));
            $contentData['viewsWeb'] = $this->weekViw();
            $contentData['viewsMonthWeb'] = $this->monthView();
            $contentData['debtorsCount'] = $this->viewsCountProcessAll($this->base->get_data('financial_situation', '*', array('final_situation' => -1, 'academy_id' => $academy_id)));
            $contentData['studentsCount'] = $this->viewsCountProcessAll($this->base->get_data('students', 'national_code', array('academy_id' => $academy_id)));
            $contentData['coursesCount'] = $this->viewsCountProcessAll($this->base->get_data('courses', 'course_id', array('academy_id' => $academy_id)));
            $onlineExams = $this->getCountOfOnlineExams();
            $contentData['examsCount'] = $this->viewsCountProcessAll($this->base->get_data('exams_students', 'exam_student_id', array('academy_id' => $academy_id))) + $onlineExams;
            $tomorrow_checks_ex = $this->get_join->get_data('exam_check_pay', 'students', 'exam_check_pay.student_nc=students.national_code', null, null, array('check_date' => date('Y-m-d', strtotime('+1 day')), 'students.academy_id' => $academy_id));
            $tomorrow_checks_cu = $this->get_join->get_data('course_check_pay', 'students', 'course_check_pay.student_nc=students.national_code', null, null, array('check_date' => date('Y-m-d', strtotime('+1 day')), 'course_check_pay.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            $contentData['tomorrow_checks'] = array_merge($tomorrow_checks_ex, $tomorrow_checks_cu);
            // print_r($contentData['tomorrow_checks']);
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $footerData['secondScripts'] = 'dashboard-scripts';
            $footerData['thirdScripts'] = 'sparklines-scripts';
            $contentData['yield'] = 'dashboard';
            $this->show_pages($title = 'پروفایل کاربری', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('login-page', 'refresh');
        }
    }
    public function wallet(){
        $academy_id = $this->session->userdata('academy_id');
        $manager_payments = $this->base->get_data('manager_payments','*',array('academy_id' => $academy_id));
        $contentData['manager_payments']=$manager_payments;
        $number_of_std = $this->base->get_data('courses_students','academy_id', array('academy_id' => $academy_id));
        $num_of_stds = array('number_of_std' => count($number_of_std));
        $this->session->set_userdata($num_of_stds);
        $const_tuition = $this->base->get_data('academys_option','constant_tuition', array('academy_id' => $academy_id));
        $tuition=array('const_tuition'=>$const_tuition[0]->constant_tuition);
        $this->session->set_userdata($tuition);
        $seconds = $this->base->get_data('academys_option', 'online_class_hours', array('academy_id' => $academy_id));
        $online_hours = array('seconds'=>$seconds[0]->online_class_hours);
        $this->session->set_userdata($online_hours);
        $headerData['links'] = 'data-table-links';
        $footerData['scripts'] = 'data-table-scripts';
        $footerData['secondScripts'] = 'dashboard-scripts';
        $footerData['thirdScripts'] = 'sparklines-scripts';
        $contentData['yield'] = 'wallet';
        $this->show_pages($title = 'وضعیت مالی آموزشگاه', 'content', $contentData, $headerData, $footerData);
    }

    public function inquiry() {
        if ($this->input->is_ajax_request()) {
            $academy_id = $this->session->userdata('academy_id', true);
            $nc = $this->input->post('student_nc', true);
            if ($this->exist->exist_entry('students', array('national_code' => $nc, 'academy_id' => $academy_id))) {
                echo json_encode(array('exist' => $nc));
            } else {
                echo json_encode(array('notexist' => true));
            }
        }
    }

    public function pre_register_st() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            $first_name = $this->input->post('first_name', true);
            $last_name = $this->input->post('last_name', true);
            $phone_num = $this->input->post('phone_num', true);
            $inArray = array(
                'academy_id' => $academy_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'national_code' => $national_code,
                'phone_num' => $phone_num,
            );

            /////////////////پیامک\\\\\\\\\\\\\\\
            $full_name = $first_name . " " . $last_name;
            $studentDName2 = $this->session->userdata('studentDName2');
            $last_app_version = $this->session->userdata('last_app_version');
            $urlApp = "https://amoozkadeh.com/app/" . $last_app_version;
            $name = $studentDName2 . " گرامی " . $full_name;
            $this->smsForStudentRegistration($phone_num, $name, $urlApp);
            /////////////////پیامک////////////////

            $this->base->insert('students', $inArray);
            $this->base->insert('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id));
//                $this->base->insert('wallet_students', array('student_nc' => $national_code, 'academy_id' => $academy_id));
            $this->session->set_flashdata('success-insert', 'کاربر مورد نظر ثبت گردید.لطفا جهت تکمیل ثبت نام خود اقدام نمایید');
            redirect('profile', 'refresh');
        } else {
            redirect('profile/error-403', 'refresh');
        }
    }

    public function smsForStudentRegistration($phone_num, $name, $urlApp) {

        $academy_name = $this->session->userdata('academy_name');
        $academyDName = $this->session->userdata('academyDName');
        $academy = $academyDName . " " . $academy_name;

        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
        $pattern_code = "e7s6fafpbp";
        $to = array($phone_num);
        $input_data = array(
            "name" => "$name",
            "app" => "$urlApp",
            "academy" => "$academy"
        );
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_exec($handler);
    }

    public function user_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['userInfo'] = $this->base->get_data('academys_option', '*', array('national_code' => $sessId));
			$contentData['city'] = $this->base->get_data('city', '*', array('id' => $contentData['userInfo'][0]->city));
			$contentData['province'] = $this->base->get_data('province', '*', array('id' => $contentData['userInfo'][0]->province));
            $footerData['scripts'] = 'lable-scripts';
            $contentData['yield'] = 'user-profile';
            $this->show_pages($title = 'پروفایل مدیریت', 'content', $contentData, $footerData);
        } else {
            redirect('profile/error-403', 'refresh');
        }
    }

    public function edit_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $manager_info = $contentData['manager_info'] = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
            $birthday = $manager_info[0]->birthday;
            $contentData['birthday'] = strtr($birthday, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));

            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'edit-profile';
            $headerData['links'] = 'custom-select-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش پروفایل', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('profile/error-403', 'refresh');
        }
    }

    public function update_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('m_first_name', 'نام', 'required|max_length[60]');
            $this->form_validation->set_rules('m_last_name', 'نام خانوادگی', 'required|max_length[60]');
            $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
            $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');

            $this->form_validation->set_rules('academy_name', 'نام آموزشگاه', 'required|max_length[60]');
            $this->form_validation->set_rules('type_academy', 'نوع آموزشگاه', 'required|max_length[60]');
            $this->form_validation->set_rules('academy_name_en', 'نام لاتین', 'max_length[60]');
            $this->form_validation->set_rules('academy_display_name', 'پیشوند آموزشگاه', 'required|max_length[60]');
            $this->form_validation->set_rules('teacher_display_name', 'لقب آموزش دهنده', 'required|max_length[60]');
            $this->form_validation->set_rules('student_display_name', 'لقب آموزش پذیر', 'required|max_length[60]');
            $this->form_validation->set_rules('student_display_name_2', 'لقب دوم آموزش پذیر', 'required|max_length[60]');

            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('tell', 'تلفن ثابت', 'exact_length[11]|numeric');
            $this->form_validation->set_rules('email', 'ایمیل', 'max_length[100]|valid_email');
            $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
            $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
            $this->form_validation->set_rules('address', 'آدرس', 'required|max_length[180]');
            $this->form_validation->set_rules('postal_code', 'کد پستی', 'required|exact_length[10]');
            $this->form_validation->set_rules('Introduction', 'معرفی آموزشگاه', 'required');

            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
            $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
            $this->form_validation->set_message('numeric', '%s معتبر نیست');
            $this->form_validation->set_message('valid_email', 'فرمت %s اشتباه است');

            if ($this->form_validation->run() === TRUE) {

                $academy_id = $this->session->userdata('academy_id');
                $birthday = $this->input->post('birthday', true);
                $birthday = strtr($birthday, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));

                $update_array = array(
                    'm_first_name' => $this->input->post('m_first_name', true),
                    'm_last_name' => $this->input->post('m_last_name', true),
                    'father_name' => $this->input->post('father_name', true),
                    'birthday' => $birthday,
                    'marital_status' => $this->input->post('marital_status', true),
                    'gender' => $this->input->post('gender', true),
                    'academy_name' => $this->input->post('academy_name', true),
                    'type_academy' => $this->input->post('type_academy', true),
                    'academy_name_en' => $this->input->post('academy_name_en', true),
                    'academy_display_name' => $this->input->post('academy_display_name', true),
                    'teacher_display_name' => $this->input->post('teacher_display_name', true),
                    'student_display_name' => $this->input->post('student_display_name', true),
                    'student_display_name_2' => $this->input->post('student_display_name_2', true),
                    'tell' => $this->input->post('tell', true),
                    'phone_num' => $this->input->post('phone_num', true),
                    'email' => $this->input->post('email', true),
                    'site' => $this->input->post('site', true),
//                    'province' => $this->input->post('province', true),
					'province' => '17',
                    'city' => $this->input->post('city', true),
                    'address' => $this->input->post('address', true),
                    'postal_code' => $this->input->post('postal_code', true),
                    'Introduction' => $this->input->post('Introduction', true)
                );

                // upload National card and License
					if(!empty($_FILES['national_card_image']['name'])) {
						$result_of_upload = $this->my_upload($_FILES);
						if ($result_of_upload['result_image_name'] === '110') {
							$update_array['national_card_image'] = $result_of_upload['final_image_name'];
						} else {
							$this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
							$this->edit_profile();
						}
					}
					if(!empty($_FILES['license_image']['name'])) {
						$result_of_upload2 = $this->my_upload2($_FILES);
						if ($result_of_upload2['result_image_name'] === '110') {
							$update_array['license_image'] = $result_of_upload2['final_image_name'];
						} else {
							$this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
							$this->edit_profile();
						}
					}
				// End upload National card and License

                $academy = $this->base->get_data('academys_option', '*', array('national_code' => $sessId, 'academy_id' => $academy_id));

                if ($academy[0]->mesg_activation === '0' && $academy[0]->status === '0') {
                	// sms
                    $academy_name = $academy[0]->academy_display_name . " " . $academy[0]->academy_name;
                    $admin = $this->base->get_data('admin', 'phone_num', array('status_for_sms_activation' => '1'));
                    $phone_num = $admin[0]->phone_num;
                    $this->smsActivationAcademy($phone_num, $academy_name);
					// End sms
                    $this->session->set_flashdata('sms-msg', 'ok');
                    $this->base->update('academys_option', array('academy_id' => $academy_id), array('mesg_activation' => '1'));
                }
                $this->base->update('academys_option', array('national_code' => $sessId, 'academy_id' => $academy_id), $update_array);
                $this->session->set_flashdata('success-update', 'تغییرات مورد نظر اعمال گردید');
                $this->user_profile();
            } else {
                $this->edit_profile();
            }
        } else {
            redirect('profile/error-403', 'refresh');
        }
    }

//    ///////     edit birthday manager
//    public function manager_edit_birthday() {
//        $academy_id = $this->session->userdata('academy_id');
//        $national_code = $this->input->post('national_code', true);
//        $date = $this->input->post('birthday', true);
//        $birthday = strtr($date, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
//        $this->base->update('academys_option', array('national_code' => $national_code, 'academy_id' => $academy_id), array('birthday' => $birthday));
//        $this->edit_profile();
//    }

	public function my_upload() {
		$this->load->library('upload');
		$config_array = array(
			'upload_path' => './assets/documents',
			'allowed_types' => 'jpg|png|jpeg',
			'max_size' => 10240,
			'file_name' => time().rand(1000,9999)
		);
		$this->upload->initialize($config_array);

		if ($this->upload->do_upload('national_card_image')) {
			$pic_info = $this->upload->data();
			$pic_name = $pic_info['file_name'];
			$this->load->library('image_lib');
			$config_array = array(
				'source_image' => './assets/documents/' . $pic_name,
				'new_image' => './assets/documents/thumb/' . $pic_name,
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
			$final_image_name = '';
		}
		$result = array(
			'img_name' => $result_image_name,
			'final_image_name' => $final_image_name,
			'result_image_name' => $result_image_name
		);
		return $result;
	}

	public function my_upload2() {
		$this->load->library('upload');
		$config_array = array(
			'upload_path' => './assets/documents',
			'allowed_types' => 'jpg|png|jpeg',
			'max_size' => 10240,
			'file_name' => time().rand(1000,9999)
		);
		$this->upload->initialize($config_array);

		if ($this->upload->do_upload('license_image')) {
			$pic_info = $this->upload->data();
			$pic_name = $pic_info['file_name'];
			$this->load->library('image_lib');
			$config_array = array(
				'source_image' => './assets/documents/' . $pic_name,
				'new_image' => './assets/documents/thumb/' . $pic_name,
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
			$final_image_name = '';
		}
		$result = array(
			'img_name' => $result_image_name,
			'final_image_name' => $final_image_name,
			'result_image_name' => $result_image_name
		);
		return $result;
	}

    ///////// upload file \\\\\\\\
    public function upload_manage_pic() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => 'assets/profile-picture',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10240,
            'file_name' => time().rand(1000,9999)
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('manage_pic')) {
            $pic_info = $this->upload->data();
            $pic_name = $pic_info['file_name'];
            $this->load->library('image_lib');
            $config_array = array(
                'source_image' => 'assets/profile-picture/' . $pic_name,
                'new_image' => 'assets/profile-picture/thumb/' . $pic_name,
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

    ///////// upload file \\\\\\\\
    public function upload_academy_logo() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => 'assets/profile-picture',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10240,
            'file_name' => time().rand(1000,9999)
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('logo')) {
            $pic_info = $this->upload->data();
            $pic_name = $pic_info['file_name'];
            $this->load->library('image_lib');
            $config_array = array(
                'source_image' => 'assets/profile-picture/' . $pic_name,
                'new_image' => 'assets/profile-picture/thumb/' . $pic_name,
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
            $final_image_name = 'aducation.png';
        }
        $result = array(
            'img_name' => $result_image_name,
            'final_image_name' => $final_image_name,
            'result_image_name' => $result_image_name
        );
        return $result;
    }

    ///////     manager update picture
    public function manager_update_pic() {
        $academy_id = $this->session->userdata('academy_id');

        $result_of_upload = $this->upload_manage_pic($_FILES);
        if ($result_of_upload['result_image_name'] === '110') {
            $manager_info = $this->base->get_data('academys_option', 'manage_pic', array('academy_id' => $academy_id));
            if (!empty($manager_info) && $manager_info[0]->manage_pic !== 'manager-icon.png') {
                unlink('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
                unlink('assets/profile-picture/' . $manager_info[0]->manage_pic);
            }
            $insert_array['manage_pic'] = $result_of_upload['final_image_name'];
            $this->base->update('academys_option', array('academy_id' => $academy_id), $insert_array);
            $this->edit_profile();
        } else {
            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
            $this->edit_profile();
        }
    }

    ///////     manager update logo
    public function manager_update_logo() {
        $academy_id = $this->session->userdata('academy_id');

        $result_of_upload = $this->upload_academy_logo($_FILES);
        if ($result_of_upload['result_image_name'] === '110') {
            $manager_info = $this->base->get_data('academys_option', 'logo', array('academy_id' => $academy_id));
            if (!empty($manager_info) && $manager_info[0]->logo !== 'education.png') {
                unlink('assets/profile-picture/thumb/' . $manager_info[0]->logo);
                unlink('assets/profile-picture/' . $manager_info[0]->logo);
            }
            $insert_array['logo'] = $result_of_upload['final_image_name'];
            $this->base->update('academys_option', array('academy_id' => $academy_id), $insert_array);
            $this->edit_profile();
        } else {
            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
            $this->edit_profile();
        }
    }

    public function smsActivationAcademy($phone_num, $academy_name) {
        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
        $pattern_code = "e7s6fafpbp";
        $to = array($phone_num);
        $input_data = array(
            "academy" => "$academy_name"
        );
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_exec($handler);
        return true;
    }

}
