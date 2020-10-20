<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    }

//    private function getpass() {
//        $code = mt_rand(10000, 99999);
//        echo $code;
//        echo '</br>';
//        echo sha1($code . $this->salt);
//    }

    public function index() {

    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function show_login_page() {
        $this->show_pages('احراز هویت', 'login-form');
    }

    public function login_process() {
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
        $this->form_validation->set_message('numeric', '%s فقط باید به صورت عدد وارد شود');

        if ($this->form_validation->run() === TRUE) {
            $national_code = $this->input->post('national_code', true);
            $category = $this->input->post('category', true);
            $ip_address = $this->input->ip_address();

            if ($national_code === '1111111111' || $national_code === '2222222222') {
                if ($category === '1') {
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
                    redirect('profile', 'refresh');
                } elseif ($category === '2') {
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
                    redirect('teacher/profile', 'refresh');
                } elseif ($category === '3') {
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
                    redirect('student/profile', 'refresh');
                }
            } elseif ($this->exist->is_correct_user_info($national_code, $category)) {
                if ($category === '1')
                    $result = $this->base->get_data('academys_option', 'phone_num', array('national_code' => $national_code));
                elseif ($category === '2')
                    $result = $this->base->get_data('employers', 'phone_num', array('national_code' => $national_code));
                elseif ($category === '3')
                    $result = $this->base->get_data('students', 'phone_num', array('national_code' => $national_code));

				if($result[0]->phone_num == '' || $result[0]->phone_num == '0'){
					$this->session->set_flashdata('notExistPhoneNumber','شماره ای برای شما ثبت نشده است لطفا شماره همراه و کد ملی خود را جهت ثبت به بخش پشتیبانی اعلام کنید.');
					redirect('login', 'refresh');
				}else{
					$phone_num = $result[0]->phone_num;
					$rand = (string) rand(1111, 9999);

					$this->sendVerifyCode($phone_num, $rand);

//				$phone_num_display = substr($phone_num, 0, 4) . ' *** *' . substr($phone_num, 8, 3);
					$phone_num = substr($phone_num, 8, 3) . '* *** ' . substr($phone_num, 0, 4);
					$data = array(
						'phone_num' => $phone_num,
						'national_code' => $national_code,
						'category' => $category,
						'rand' => $rand
					);
					$this->session->set_userdata($data);
					$this->show_pages('ورود به پروفایل شخصی', 'verify-form');
				}
            } else {
                $this->session->set_flashdata('invalid-national-code', 'کد ملی وارد شده موجود نمی باشد.');
                redirect('login', 'refresh');
            }
        } else {
            $this->show_pages('احراز هویت', 'login-form');
        }
    }

    public function verify() {
        $this->form_validation->set_rules('user_otp', 'کد ورود به پروفایل', 'required|exact_length[4]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 4 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $user_otp = $this->input->post('user_otp', true);
            $ip_address = $this->input->ip_address();
            $user_agent = $this->input->user_agent();

            $otp = $this->session->userdata('rand');
            $national_code = $this->session->userdata('national_code');
            $category = $this->session->userdata('category');
            if ($user_otp === $otp) {
                if ($category === '1') {
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
                    redirect('../portal', 'refresh');
                } elseif ($category === '2') {
                    $userInfo = $this->get_join->get_data('employers', 'academys_option', 'employers.academy_id=academys_option.academy_id', null, null, array('employers.national_code' => $national_code));
                    foreach ($userInfo as $std):
                        $data['academy_id'] = $std->academy_id;
                        $data['category'] = '2';
                        $data['academy'] = $std->academy_display_name . ' ' . $std->academy_name;
                        $data['logo'] = $std->logo;
                        $data['national_code'] = $national_code;
                        $academy['data'][] = $data;
                    endforeach;
                    if (sizeof($userInfo) <= '1') {
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
                        redirect('teacher/profile', 'refresh');
                    } else {
                        $this->session->set_flashdata($academy);
                        $this->show_pages('ورود به پروفایل شخصی', 'verify-form');
                    }
                } elseif ($category === '3') {
                    $userInfo = $this->get_join->get_data('students', 'academys_option', 'students.academy_id=academys_option.academy_id', null, null, array('students.national_code' => $national_code));
                    foreach ($userInfo as $std):
                        $data['academy_id'] = $std->academy_id;
                        $data['category'] = '3';
                        $data['academy'] = $std->academy_display_name . ' ' . $std->academy_name;
                        $data['logo'] = $std->logo;
                        $data['national_code'] = $national_code;
                        $academy['data'][] = $data;
                    endforeach;
                    if (sizeof($userInfo) <= '1') {
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
                        redirect('student/profile', 'refresh');
                    } else {
                        $this->session->set_flashdata($academy);
                        $this->show_pages('ورود به پروفایل شخصی', 'verify-form');
                    }
                }
            } else {
                $this->session->set_flashdata('invalid-verify-code', 'کد وارد شده صحیح نمی باشد');
                $this->show_pages('ورود به پروفایل شخصی', 'verify-form');
            }
        } else {
            $this->show_pages('ورود به پروفایل شخصی', 'verify-form');
        }
    }

    public function verify_complete() {
        $national_code = $this->input->post('national_code');
        $academy_id = $this->input->post('academy_id');
        $category = $this->input->post('category');
        $ip_address = $this->input->ip_address();

        if ($category === '2')
            $userAcademy = $this->get_join->get_data('employers', 'academys_option', 'employers.academy_id=academys_option.academy_id', null, null, array('employers.academy_id' => $academy_id, 'employers.national_code' => $national_code));
        elseif ($category === '3')
            $userAcademy = $this->get_join->get_data('students', 'academys_option', 'students.academy_id=academys_option.academy_id', null, null, array('students.academy_id' => $academy_id, 'students.national_code' => $national_code));

        $session_data = array(
            'academy_id' => $academy_id,
            'manager_nc' => $userAcademy[0]->national_code,
            'academy_name' => $userAcademy[0]->academy_name,
            'academyDName' => $userAcademy[0]->academy_display_name,
            'studentDName' => $userAcademy[0]->student_display_name,
            'studentDName2' => $userAcademy[0]->student_display_name_2,
            'teacherDName' => $userAcademy[0]->teacher_display_name,
            'manage_pic' => $userAcademy[0]->manage_pic,
            'logo' => $userAcademy[0]->logo,
            'full_name' => $userAcademy[0]->first_name . ' ' . $userAcademy[0]->last_name,
            'name' => $userAcademy[0]->first_name,
            'session_id' => $national_code,
            'phone_num' => $userAcademy[0]->phone_num,
            'ip_address' => $ip_address,
            'pic_name' => $userAcademy[0]->pic_name,
            'logged_in' => true
        );

        if ($category === '2') {
            $session_data['user_type'] = 'teachers';
            $this->session->set_userdata($session_data);
            redirect('teacher/profile', 'refresh');
        } elseif ($category === '3') {
            $session_data['user_type'] = 'students';
            $this->session->set_userdata($session_data);
            redirect('student/profile', 'refresh');
        }
    }

    public function logout() {
        $session_id = $this->input->post('national_code', true);
        $sess_array = array(
            'academy_id',
            'academy_name',
            'academyDName',
            'studentDName',
            'studentDName2',
            'teacherDName',
            'manage_pic',
            'logo',
            'full_name',
            'name',
            'session_id',
            'phone_num',
            'ip_address',
            'pic_name',
            'user_type',
            'logged_in'
        );

        $this->session->unset_userdata($sess_array);
        $this->session->sess_destroy($session_id);
        redirect('../', 'refresh');
    }

//    public function change_password() {
//        if ($this->input->is_ajax_request()) {
//            $academy_id = $this->session->userdata('academy_id', true);
//            $phone_num = $this->input->post('phoneNum', true);
//            $uniqueCode = mt_rand(10000, 99999);
//            $this->sendPassword($phone_num, $uniqueCode);
//            $this->base_model->update('academys_option', array('phone_num' => $phone_num, 'academy_id' => $academy_id), array('password' => sha1($uniqueCode . $this->salt)));
//            echo true;
//        }
//    }
//
//    public function register() {
//        $this->form_validation->set_rules('phone_num_reg', 'شماره همراه', 'required|exact_length[10]|numeric');
//        $this->form_validation->set_rules('fullname_reg', 'نام و نام خانوادگی', 'required');
//        $this->form_validation->set_message('required', '%s را وارد نمایید');
//        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
//        $this->form_validation->set_message('numeric', '%s معتبر نیست');
//
//        if ($this->form_validation->run() === TRUE) {
//            $academy_id = $this->session->userdata('academy_id', true);
//            $fullName = $this->input->post('fullname_reg', true);
//            $phoneNum = $this->input->post('phone_num_reg', true);
//            if ($this->exist->is_exist_mobile('0' . $phoneNum, $academy_id)) {
//                $this->session->set_flashdata('phone-num-exist', 'کاربر گرامی، شما با این شماره موبایل قبلا ثبت نام کرده اید. لطفا از طریق فرم زیر به پروفایل شخصی خود وارد شوید.');
//                $this->show_pages('ورود به پروفایل شخصی', 'login-form');
//            } else {
//                $this->exist->del_all_temp_user_if_exist($phoneNum, $academy_id);
//                $uniqueId = mt_rand(100000, 999999);
//                $data = array(
//                    'academy_id' => $academy_id,
//                    'phone_num' => '0' . $phoneNum,
//                    'full_name' => $fullName,
//                    'activation_code' => sha1($uniqueId)
//                );
//                $this->base_model->insert('temp_users', $data);
//                $this->sendVerifyCode($phoneNum, $uniqueId);
//                $contentData['phone_num'] = $phoneNum;
//                $this->show_pages('فعال سازی پروفایل شخصی', 'verify-phone', $contentData);
//            }
//        } else {
//            $this->show_pages($title = 'ثبت نام', $path = 'register-form');
//        }
//    }
//
//    private function sendPassword($tel, $token, $temp = 'password') {
//        $to = $tel;
//        $url = 'https://api.kavenegar.com/v1/' . $this->apiKey . '/verify/lookup.json';
//        $fields = array(
//            'receptor' => urlencode($to),
//            'token' => urlencode($token),
//            'template' => urlencode($temp)
//        );
//        $fields_string = "";
//        foreach ($fields as $key => $value) {
//            $fields_string .= $key . '=' . $value . '&';
//        }
//        rtrim($fields_string, '&');
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, count($fields));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $result = curl_exec($ch);
//
//        curl_close($ch);
//        return 2;
//    }

    private function sendVerifyCode($phone_num, $rand) {
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
        return true;
    }

    public function send_sms($phone_num, $detail) {
        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
        $pattern_code = "xrxxd37nki";
        $to = array($phone_num);
        $input_data = array(
            "code" => "$detail");
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $verify_code = curl_exec($handler);
    }


    #login with password
    public function NEW_login () {

        $cat = $this->input->post('category');
        $password = sha1($this->input->post('password'));
        $na_code = $this->input->post('national_code');
        $ip_address = $this->input->ip_address();

        if ($cat == '1') {

            $manager = $this->base->get_data('academys_option' , '*' , array('national_code' => $na_code));

            if (!empty($manager)) {

                if ($manager[0]->password === $password) {

                    $academy = $this->base->get_data('academys_option', '*', array('national_code' => $na_code));

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
                        'session_id' => $na_code,
                        'phone_num' => $academy[0]->phone_num,
                        'manage_pic' => $academy[0]->manage_pic,
                        'logo' => $academy[0]->logo,
                        'status' => $academy[0]->status,
                        'ip_address' => $ip_address,
                        'user_type' => 'managers',
                        'logged_in' => true

                    );

                    $this->session->set_userdata($session_data);
                    redirect('profile', 'refresh');

                } else { # wrong password

                    $this->session->set_flashdata('fail', 'رمز عبور شما نادرست است');

                }

            } else { # wrong national code

                $this->session->set_flashdata('fail', 'کد ملی شما ثبت نشده با مدیریت تماس بگیرید');

            }

        } elseif ($cat == '2') {

            $teacher = $this->base->get_data('employers' , '*' , array('national_code' => $na_code));

            if (!empty($teacher)) {

                if ($teacher[0]->password === $password) {

                    $userInfo = $this->base->get_data('employers', '*', array('national_code' => $na_code));
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
                        'session_id' => $na_code,
                        'phone_num' => $userInfo[0]->phone_num,
                        'ip_address' => $ip_address,
                        'pic_name' => $userInfo[0]->pic_name,
                        'user_type' => 'teachers',
                        'logged_in' => true

                    );

                    $this->session->set_userdata($session_data);
                    redirect('teacher/profile', 'refresh');

                } else { # wrong password

                    $this->session->set_flashdata('fail', 'رمز عبور شما نادرست است');

                }

            } else { # wrong national code

                $this->session->set_flashdata('fail', 'کد ملی شما ثبت نشده با مدیریت تماس بگیرید');

            }

        } elseif ($cat == '3') {

            $student = $this->base->get_data('students' , '*' , array('national_code' => $na_code));

            if (!empty($student)) {

                if ($student[0]->password === $password) {

                    $userInfo = $this->get_join->get_data('students', 'academys_option', 'students.academy_id=academys_option.academy_id', null, null, array('students.national_code' => $national_code));

                    foreach ($userInfo as $std):

                        $data['academy_id'] = $std->academy_id;
                        $data['category'] = '3';
                        $data['academy'] = $std->academy_display_name . ' ' . $std->academy_name;
                        $data['logo'] = $std->logo;
                        $data['national_code'] = $national_code;
                        $academy['data'][] = $data;

                    endforeach;

                    if (sizeof($userInfo) <= '1') {

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
                        redirect('student/profile', 'refresh');

                    } else {

                        $this->session->set_flashdata($academy);
                        $this->show_pages('ورود به پروفایل شخصی', 'verify-form');

                    }

                } else { # wrong password

                    $this->session->set_flashdata('fail', 'رمز عبور شما نادرست است');

                }

            } else { # wrong national code

                $this->session->set_flashdata('fail', 'کد ملی شما ثبت نشده با مدیریت تماس بگیرید');

            }

        }
        
    }

}

/* End of file Auth.php */
