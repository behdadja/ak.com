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
//        echo sha1('2380248259' . $this->salt);
//    }

    public function index() {
        
    }

    private function show_pages($title = null, $path) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path);
        $this->load->view('templates/footer');
    }

    public function show_login_page() {
        $this->show_pages('ورود به پروفایل شخصی', 'login-form');
    }

//    public function register() {
//        $this->form_validation->set_rules('phone_num_reg', 'شماره همراه', 'required|exact_length[10]|numeric');
//        $this->form_validation->set_rules('fullname_reg', 'نام و نام خانوادگی', 'required');
//        $this->form_validation->set_message('required', '%s را وارد نمایید');
//        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
//        $this->form_validation->set_message('numeric', '%s معتبر نیست');
//
//        if ($this->form_validation->run() === TRUE) {
//            $fullName = $this->input->post('fullname_reg', true);
//            $phoneNum = $this->input->post('phone_num_reg', true);
//            if ($this->exist->is_exist_mobile('0' . $phoneNum)) {
//                $this->session->set_flashdata('phone-num-exist', 'کاربر گرامی، شما با این شماره موبایل قبلا ثبت نام کرده اید. لطفا از طریق فرم زیر به پروفایل شخصی خود وارد شوید.');
//                $this->show_pages('ورود به پروفایل شخصی', 'login-form');
//            } else {
//                $this->exist->del_all_temp_user_if_exist($phoneNum);
//                $uniqueId = mt_rand(100000, 999999);
//                $data = array(
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

    public function verify() {
        $this->form_validation->set_rules('verify_code', 'کد فعال سازی', 'required|exact_length[6]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 6 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');
        $phoneNum = $this->input->post('phone_num_verify', true);
        $contentData['phone_num'] = $phoneNum;
        if ($this->form_validation->run() === TRUE) {
            $verifyCode = $this->input->post('verify_code', true);
            $ip_address = $this->input->ip_address();
            $user_agent = $this->input->user_agent();
            if ($this->exist->is_correct_verify_code('0' . $phoneNum, sha1($verifyCode))) {
                $userInfo = $this->base_model->get_data('temp_users', '*', array('phone_num' => '0' . $phoneNum, 'activation_code' => sha1($verifyCode)));
                $full_name = $userInfo[0]->full_name;
                $phone_num = $userInfo[0]->phone_num;
                $this->exist->del_all_temp_user_if_exist($phoneNum);
                $password = sha1(substr($userInfo[0]->phone_num, -5) . $this->salt);
                $this->sendPassword($phoneNum, substr($userInfo[0]->phone_num, -5), 'password');
                $finalData = array(
                    'full_name' => $full_name,
                    'phone_num' => $phone_num,
                    'password' => $password,
                    'created_at' => date('Y-m-d'),
                    'last_ip_address' => $ip_address,
                    'user_agent' => $user_agent
                );
                $this->base_model->insert('users', $finalData);
                $session_data = array(
                    'full_name' => $full_name,
                    'phone_num' => $phone_num,
                    'ip_address' => $ip_address,
                    'logged_in' => true
                );
                $this->session->set_userdata($session_data);
                $this->show_profile();
            } else {
                $this->session->set_flashdata('invalid-verify-code', 'کد وارد شده صحیح نمی باشد');
                $this->show_pages('فعال سازی پروفایل شخصی', 'verify-phone', $contentData);
            }
        } else {
            $this->show_pages('فعال سازی پروفایل شخصی', 'verify-phone', $contentData);
        }
    }

    public function login_process() {
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('password', 'رمز عبور', 'required');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', '%s باید 10 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $national_code = $this->input->post('national_code', true);
            $password = $this->input->post('password', true);
            $academy_id = $this->input->post('academy_id', true);
            $category = '3';
            $ip_address = $this->input->ip_address();
            $user_agent = $this->input->user_agent();
            if ($this->exist->is_correct_user_info($national_code, sha1($password . $this->salt), $academy_id, $category)) {

                $userInfo = $this->base->get_data('students', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
                $academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
                $userType = 'students';

                $full_name = $userInfo[0]->first_name . ' ' . $userInfo[0]->last_name;
                /// $arrName = explode(' ',trim($full_name));
                $phone_num = $userInfo[0]->phone_num;
                $session_data = array(
                    'academy_id' => $academy_id,
                    'manager_nc' => $academy[0]->national_code,
                    'academy_name' => $academy[0]->academy_name,
                    'academyDName' => $academy[0]->academy_display_name,
                    'studentDName' => $academy[0]->student_display_name,
                    'studentDName2' => $academy[0]->student_display_name_2,
                    'teacherDName' => $academy[0]->teacher_display_name,
                    'manage_name' => $academy[0]->m_first_name . " " . $academy[0]->m_last_name,
                    'manage_pic' => $academy[0]->manage_pic,
                    'logo' => $academy[0]->logo,
                    'full_name' => $full_name,
                    'name' => $userInfo[0]->first_name,
                    'session_id' => $national_code,
                    'phone_num' => $phone_num,
                    'ip_address' => $ip_address,
                    'pic_name' => $userInfo[0]->pic_name,
                    'user_type' => $userType,
                    'logged_in' => true
                );
                $this->session->set_userdata($session_data);
                redirect('student/profile', 'refresh');
            } else {
                $this->session->set_flashdata('invalid-info', 'کد ملی وارد شده با رمز عبور مطابقت ندارد.');
                $this->show_pages('ورود به پروفایل شخصی', 'login-form');
            }
        } else {
            $this->show_pages('ورود به پروفایل شخصی', 'login-form');
        }
    }

    public function logout() {
        $session_id = $this->input->post('national_code', true);
        $sess_array = array(
            'academy_id',
            'manager_nc',
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
        redirect('student/login', 'refresh');
    }

//    public function change_password() {
//        if ($this->input->is_ajax_request()) {
//            $academy_id = $this->session->userdata('academy_id');
//            $phone_num = $this->input->post('phoneNum', true);
//            $uniqueCode = mt_rand(10000, 99999);
//            $this->sendPassword($phone_num, $uniqueCode);
//            $this->base_model->update('users', array('phone_num' => $phone_num, 'academy_id' => $academy_id), array('password' => sha1($uniqueCode . $this->salt)));
//            echo true;
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
//
//    private function sendVerifyCode($tel, $token, $temp = 'verifyCode') {
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
}

/* End of file Auth.php */
