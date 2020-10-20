<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->library('calc');
    }

    // ------------- test ------------- \\
    public function getClusterList($academy) {
        $data = $this->base->stnd($academy);
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

    public function test() {
        $data = $this->base->get_data('province', '*');
        $this->load->view('welcome_message', array('data' => $data));
    }

    public function getCityList($prv_id) {
        $states = $this->base->get_data('city', 'name', array('province' => $prv_id));
        echo json_encode($states);
    }

    public function create_new_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            if ($this->exist->exist_entry('students', array('national_code' => $national_code))) {
                if ($this->exist->exist_entry('students', array('national_code' => $national_code, 'academy_id' => $academy_id))) {
                    $this->session->set_flashdata('national-code-msg', 'فرد با کد ملی وارد شده قبلا ثبت نام شده است.');
                    redirect('profile', 'refresh');
                } else {
                    $student_info = $contentData['student_info'] = $this->base->get_data('students', '*', array('national_code' => $national_code));
                    $academy = $this->base->get_data('academys_option', 'academy_display_name,academy_name', array('academy_id' => $student_info[0]->academy_id));
                    $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
                    $contentData['yield'] = 'create-new-student-page-academy';
                    $headerData['links'] = 'persian-calendar-links';
                    $footerData['scripts'] = 'persian-calendar-scripts';
                    $msg = "کارآموز با کد ملی وارد شده قبلا در " . $academy[0]->academy_display_name . " " . $academy[0]->academy_name . " ثبت شده است.";
                    $this->session->set_flashdata('available-nc-msg', $msg);
                    $this->session->set_userdata(array('register_nc' => $national_code));
                    $this->show_pages($title = 'مدیریت کاربران، ثبت نام زبان آموز جدید', 'content', $contentData, $headerData, $footerData);
                }
            } else {
                $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
                $contentData['yield'] = 'create-new-student-page';
                $headerData['links'] = 'persian-calendar-links';
                $footerData['scripts'] = 'persian-calendar-scripts';
                $data = array('register_nc' => $national_code);
                $this->session->set_userdata($data);
                $this->show_pages($title = 'مدیریت کاربران، ثبت نام زبان آموز جدید', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function insert_new_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
            $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
            $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
            $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
            $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
            $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
            $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');

            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[11]');
            $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
            $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
            $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
            $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]|numeric');
            $this->form_validation->set_rules('reference_code', 'کد معرف', 'exact_length[10]|numeric');

            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
            $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
            $this->form_validation->set_message('numeric', '%s معتبر نیست');

            if ($this->form_validation->run() === TRUE) {
                $academy_id = $this->session->userdata('academy_id', true);
                $first_name = $this->input->post('first_name', true);
                $last_name = $this->input->post('last_name', true);
                $first_name_en = $this->input->post('first_name_en', true);
                $last_name_en = $this->input->post('last_name_en', true);
                $father_name = $this->input->post('father_name', true);
                $province = $this->input->post('province', true);
                $city = $this->input->post('city', true);
                $street = $this->input->post('street', true);
                $phone_num = $this->input->post('phone_num', true);
                $national_code = $this->input->post('national_code', true);
                $postal_code = $this->input->post('postal_code', true);
                $tell = $this->input->post('tell', true);
                $marital_status = $this->input->post('marital_status', true);
                $gender = $this->input->post('gender', true);
                $birthday = $this->input->post('birthday', true);
                $reference_code = $this->input->post('reference_code', true);

                $insert_array = array(
                    'academy_id' => $academy_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'first_name_en' => $first_name_en,
                    'last_name_en' => $last_name_en,
//                    'password' => sha1($national_code . $this->salt),
                    'father_name' => $father_name,
                    'province' => $province,
                    'city' => $city,
                    'street' => $street,
                    'phone_num' => $phone_num,
                    'national_code' => $national_code,
                    'postal_code' => $postal_code,
                    'tell' => $tell,
                    'marital_status' => $marital_status,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'student_activated' => 1,
                    'reference_code' => $reference_code
// تبدیل تاریخ شمسی به میلادی
// 'birthday' => $this->calc->jalali_to_gregorian($birthday)
                );

                $result_of_upload = $this->student_upload($_FILES);
                $insert_array['pic_name'] = $result_of_upload['final_image_name'];

//                if ($pic_name != '') {
//                    $result_of_upload = $this->my_upload($_FILES);
//                    if ($result_of_upload['result_image_name'] === '110') {
//                        $insert_array['pic_name'] = $result_of_upload['final_image_name'];
//                    } else {
//                        $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                        $this->create_new_student();
//                    }
//                }

                $this->base->insert('students', $insert_array);
                $this->base->insert('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id));
                $this->base->insert('wallet_students', array('student_nc' => $national_code, 'academy_id' => $academy_id));

                $academys_option = $this->base->get_data('academys_option', 'number_of_student', array('academy_id' => $academy_id));
                $this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academys_option[0]->number_of_student + 1));

                echo "
                            <script type=\"text/javascript\">
                            sessionStorage . clear();
                            </script>
                        ";

                $data = array('register_nc' => $national_code);
                $this->session->unset_userdata($data);

                /////////////////پیامک\\\\\\\\\\\\\\\
                $full_name = $first_name . " " . $last_name;
                $studentDName2 = $this->session->userdata('studentDName2');
                $last_app_version = $this->session->userdata('last_app_version');
                $urlApp = "yun.ir/qpt";
                $name = $studentDName2 . " گرامی " . $full_name;
                $this->smsForStudentRegistration($phone_num, $name, $urlApp);
                /////////////////پیامک////////////////

                $this->session->set_flashdata('success-insert', 'کاربر مورد نظر ثبت گردید.');
                redirect('users/manage-students', 'refresh');
            } else {
                $this->create_new_student();
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function insert_new_student2() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
            $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
            $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
            $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
            $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
            $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
            $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');

            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[12]');
            $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
            $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
            $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
            $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]|numeric');
            $this->form_validation->set_rules('reference_code', 'کد معرف', 'exact_length[10]|numeric');

            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
            $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
            $this->form_validation->set_message('numeric', '%s معتبر نیست');

            if ($this->form_validation->run() === TRUE) {
                $academy_id = $this->session->userdata('academy_id', true);
                $first_name = $this->input->post('first_name', true);
                $last_name = $this->input->post('last_name', true);
                $first_name_en = $this->input->post('first_name_en', true);
                $last_name_en = $this->input->post('last_name_en', true);
                $father_name = $this->input->post('father_name', true);
                $province = $this->input->post('province', true);
                $city = $this->input->post('city', true);
                $street = $this->input->post('street', true);
                $phone_num = $this->input->post('phone_num', true);
                $postal_code = $this->input->post('postal_code', true);
                $tell = $this->input->post('tell', true);
                $marital_status = $this->input->post('marital_status', true);
                $gender = $this->input->post('gender', true);
                $birthday = $this->input->post('birthday', true);
                $national_code = $this->input->post('national_code', true);
                $reference_code = $this->input->post('reference_code', true);

                $insert_array = array(
                    'academy_id' => $academy_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'first_name_en' => $first_name_en,
                    'last_name_en' => $last_name_en,
                    'password' => sha1($national_code . $this->salt),
                    'father_name' => $father_name,
                    'province' => $province,
                    'city' => $city,
                    'street' => $street,
                    'phone_num' => $phone_num,
                    'national_code' => $national_code,
                    'postal_code' => $postal_code,
                    'tell' => $tell,
                    'marital_status' => $marital_status,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'student_activated' => 1,
                    'reference_code' => $reference_code
                );

                $pic_name = $this->input->post('pic_name', true);
                if ($pic_name !== null) {
                    $result_of_upload = $this->student_upload($_FILES);
                    $insert_array['pic_name'] = $result_of_upload['final_image_name'];
                    $update_array['pic_name'] = $result_of_upload['final_image_name'];
                }

//                if ($pic_name != '') {
//                    $result_of_upload = $this->my_upload($_FILES);
//                    if ($result_of_upload['result_image_name'] === '110') {
//                        $insert_array['pic_name'] = $result_of_upload['final_image_name'];
//                        $update_array['pic_name'] = $result_of_upload['final_image_name'];
//                    } else {
//                        $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                        $this->create_new_student();
//                    }
//                }

                $update_array = array(
                    'province' => $province,
                    'city' => $city,
                    'street' => $street,
                    'phone_num' => $phone_num,
                    'postal_code' => $postal_code,
                    'tell' => $tell,
                );


                $this->base->insert('students', $insert_array);
                $students = $this->base->get_data('students', '*', array('national_code' => $national_code));
                foreach ($students as $student) {
                    $this->base->update('students', array('national_code' => $national_code), $update_array);
                }
                $this->base->insert('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id));
                $this->base->insert('wallet_students', array('student_nc' => $national_code, 'academy_id' => $academy_id));
                $this->session->set_flashdata('success-insert', 'کاربر مورد نظر ثبت گردید.');
                echo "
                            <script type=\"text/javascript\">
                            sessionStorage . clear();
                            </script>
                        ";

                /////////////////پیامک\\\\\\\\\\\\\\\
                $full_name = $first_name . " " . $last_name;
                $studentDName2 = $this->session->userdata('studentDName2');
                $last_app_version = $this->session->userdata('last_app_version');
                $urlApp = "yun.ir/qpt";
                $name = $studentDName2 . " گرامی " . $full_name;
                $this->smsForStudentRegistration($phone_num, $name, $urlApp);
                /////////////////پیامک////////////////

                redirect('users/manage-students', 'refresh');
            } else {
                $this->create_new_student();
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function smsForStudentRegistration($phone_num, $name, $urlApp) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_name = $this->session->userdata('academy_name');
            $academyDName = $this->session->userdata('academyDName');
            $academy = $academyDName . " " . $academy_name;

            $username = "mehritc";
            $password = '@utabpars1219';
            $from = "+983000505";
            $pattern_code = "4agenwbtrc";
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
            $verify_code = curl_exec($handler);
        } else {
            redirect('enrollment/error-403', 'refresh');
        }
    }

    public function manage_students() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['students_info'] = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'manage-students';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('مدیریت زبان آموزان', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function edit_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            $student_info = $contentData['student_info'] = $this->base->get_data('students', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            $birthday = $student_info[0]->birthday;
            $contentData['birthday'] = strtr($birthday, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'edit-student';
            $headerData['links'] = 'custom-select-links';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش زبان آموز', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function update_student() {
        $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
        $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
        $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
        $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
        $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');

        $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[12]');
        $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
        $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
        $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
        $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]|numeric');

        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
        $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        $national_code = $this->input->post('national_code', true);

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id', true);

            $first_name = $this->input->post('first_name', true);
            $last_name = $this->input->post('last_name', true);
            $first_name_en = $this->input->post('first_name_en', true);
            $last_name_en = $this->input->post('last_name_en', true);
            $father_name = $this->input->post('father_name', true);
            $province = $this->input->post('province', true);
            $city = $this->input->post('city', true);
            $street = $this->input->post('street', true);
            $phone_num = $this->input->post('phone_num', true);
            $postal_code = $this->input->post('postal_code', true);
            $tell = $this->input->post('tell', true);
            $marital_status = $this->input->post('marital_status', true);
            $gender = $this->input->post('gender', true);
            $birthday = $this->input->post('birthday', true);
            $birthday = strtr($birthday, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));

            $insert_array = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'first_name_en' => $first_name_en,
                'last_name_en' => $last_name_en,
                'father_name' => $father_name,
                'province' => $province,
                'city' => $city,
                'street' => $street,
                'phone_num' => $phone_num,
                'national_code' => $national_code,
                'postal_code' => $postal_code,
                'tell' => $tell,
                'marital_status' => $marital_status,
                'gender' => $gender,
                'birthday' => $birthday,
            );

            $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), $insert_array);
            $this->session->set_flashdata('success-update', 'تغیرات مورد نظر اعمال گردید');
            redirect('users/manage-students', 'refresh');
        } else {
            $this->edit_student();
        }
    }

    private function show_student_edit_after($na_code) {
        $academy_id = $this->session->userdata('academy_id', true);
        $contentData['student_info'] = $this->base->get_data('students', '*', array('national_code' => $na_code, 'academy_id' => $academy_id));
        $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
        $contentData['yield'] = 'edit-student';
        $headerData['links'] = 'custom-select-links';
        $headerData['secondLinks'] = 'persian-calendar-links';
        $footerData['scripts'] = 'custom-select-scripts';
        $footerData['secondScripts'] = 'persian-calendar-scripts';
        $headerData['thirdLinks'] = 'dropify-links';
        $footerData['thirdScripts'] = 'dropify-scripts';
        $this->show_pages('ویرایش زبان آموز', 'content', $contentData, $headerData, $footerData);
    }

    public function create_new_employee() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'create-new-employee-page';
            $headerData['links'] = 'persian-calendar-links';
            $footerData['scripts'] = 'persian-calendar-scripts';
            $this->show_pages($title = 'مدیریت مربیان، ثبت مربی جدید', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function insert_new_employee() {
        $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
        $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
        $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
        $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
        $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
        $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');

        $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[11]');
        $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
        $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
        $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
        $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]');
        $this->form_validation->set_rules('monthly_salary', 'حقوق ماهیانه', 'max_length[8]');

        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
        $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id', true);
            $first_name = $this->input->post('first_name', true);
            $last_name = $this->input->post('last_name', true);
            $first_name_en = $this->input->post('first_name_en', true);
            $last_name_en = $this->input->post('last_name_en', true);
            $father_name = $this->input->post('father_name', true);
            $province = $this->input->post('province', true);
            $city = $this->input->post('city', true);
            $street = $this->input->post('street', true);
            $phone_num = $this->input->post('phone_num', true);
            $national_code = $this->input->post('national_code', true);
            $postal_code = $this->input->post('postal_code', true);
            $tell = $this->input->post('tell', true);
            $marital_status = $this->input->post('marital_status', true);
            $gender = $this->input->post('gender', true);
            $birthday = $this->input->post('birthday', true);
            $monthly_salary = $this->input->post('monthly_salary', true);

            if ($this->exist->exist_entry('employers', array('national_code' => $national_code, 'academy_id' => $academy_id))) {
                $this->session->set_flashdata('national-code-msg', 'استاد با کد ملی وارد شده قبلا ثبت نام شده است.');
                $this->create_new_employee();
            } else {
                $insert_array = array(
                    'academy_id' => $academy_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'first_name_en' => $first_name_en,
                    'last_name_en' => $last_name_en,
                    'password' => sha1($national_code . $this->salt),
                    'father_name' => $father_name,
                    'province' => $province,
                    'city' => $city,
                    'street' => $street,
                    'phone_num' => $phone_num,
                    'national_code' => $national_code,
                    'postal_code' => $postal_code,
                    'tell' => $tell,
                    'marital_status' => $marital_status,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'employee_activated' => 1,
                    'monthly_salary' => $monthly_salary
                );

                $result_of_upload = $this->teacher_upload($_FILES);
                $insert_array['pic_name'] = $result_of_upload['final_image_name'];


//                $result_of_upload = $this->my_upload($_FILES);
//                if ($result_of_upload['result_image_name'] === '110') {
//                    $insert_array['pic_name'] = $result_of_upload['final_image_name'];
//                } else {
//                    $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                    $this->create_new_employee();
//                }


                $last_id = $this->base->insert('employers', $insert_array);
                $this->base->insert('financial_situation_employer', array('employee_nc' => $national_code, 'academy_id' => $academy_id, 'employee_id' => $last_id));
                $this->session->set_flashdata('success-insert', 'کاربر مورد نظر ثبت گردید.');
                echo "
                        <script type=\"text/javascript\">
                            sessionStorage . clear();
                        </script>
                    ";
                redirect('users/manage-employers', 'refresh');
            }
        } else {
            $this->create_new_employee();
        }
    }

    public function manage_employers() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['employers_info'] = $this->base->get_data('employers', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'manage-employers';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('مدیریت مربیان', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function edit_employee() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $national_code = $this->input->post('national_code', true);
            $employee_info = $contentData['employee_info'] = $this->base->get_data('employers', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            $birthday = $employee_info[0]->birthday;
            $contentData['birthday'] = strtr($birthday, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'edit-employee';
            $headerData['links'] = 'custom-select-links';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش اطلاعات استاد', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function edit_activated_employer() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $national_code = $this->input->post('national_code', true);
            $employer_info = $this->base->get_data('employers', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if ($employer_info[0]->employee_activated == 0):
                $activated = array(
                    'employee_activated' => 1
                );
            else:
                $activated = array(
                    'employee_activated' => 0
                );
            endif;
            $this->base->update('employers', array('national_code' => $national_code, 'academy_id' => $academy_id), $activated);
            redirect('users/manage-employers', 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function update_employee() {
        $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
        $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
        $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
        $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
        $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
        $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');
        $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');

        $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[11]');
        $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
        $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
        $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
        $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]');
        $this->form_validation->set_rules('monthly_salary', 'حقوق ماهیانه', 'max_length[8]');

        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
        $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');

        $national_code = $this->input->post('national_code', true);

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id');
            $first_name = $this->input->post('first_name', true);
            $last_name = $this->input->post('last_name', true);
            $first_name_en = $this->input->post('first_name_en', true);
            $last_name_en = $this->input->post('last_name_en', true);
            $father_name = $this->input->post('father_name', true);
            $province = $this->input->post('province', true);
            $city = $this->input->post('city', true);
            $street = $this->input->post('street', true);
            $phone_num = $this->input->post('phone_num', true);
            $postal_code = $this->input->post('postal_code', true);
            $tell = $this->input->post('tell', true);
            $marital_status = $this->input->post('marital_status', true);
            $gender = $this->input->post('gender', true);
            $birthday = $this->input->post('birthday', true);
            $birthday = strtr($birthday, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));

            $update_array = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'first_name_en' => $first_name_en,
                'last_name_en' => $last_name_en,
                'father_name' => $father_name,
                'province' => $province,
                'city' => $city,
                'street' => $street,
                'phone_num' => $phone_num,
                'national_code' => $national_code,
                'postal_code' => $postal_code,
                'tell' => $tell,
                'marital_status' => $marital_status,
                'gender' => $gender,
                'birthday' => $birthday
//      تبدیل تاریخ شمسی به میلادی برای ثبت در دیتابیس
//    'birthday' => $this->calc->jalali_to_gregorian($birthday)
            );

            $pic_name = $this->input->post('pic_name', true);
            if ($pic_name !== null) {
                $result_of_upload = $this->teacher_upload($_FILES);
                $update_array['pic_name'] = $result_of_upload['final_image_name'];
            }

            $this->base->update('employers', array('national_code' => $national_code, 'academy_id' => $academy_id), $update_array);
            $this->session->set_flashdata('success-update', 'تغییرات مورد نظر اعمال گردید');
            redirect('users/manage-employers', 'refresh');
        } else {
            $this->show_employee_edit_after($national_code);
        }
    }

    private function show_employee_edit_after($na_code) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['employee_info'] = $this->base->get_data('employers', '*', array('national_code' => $na_code, 'academy_id' => $academy_id));
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'edit-employee';
            $headerData['links'] = 'custom-select-links';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش اطلاعات استاد', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function create_new_personnel() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $contentData['yield'] = 'create-new-personnel';
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $headerData['links'] = 'custom-select-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages($title = 'مدیریت ، ثبت مدیر جدید', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function insert_new_personnel() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
            $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
            $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
            $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
            $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
            $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');
            $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');

            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[11]');
            $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
            $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
            $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
            $this->form_validation->set_rules('activity_unit', 'واحد فعالیت', 'required');
            $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]');
            $this->form_validation->set_rules('monthly_salary', 'حقوق ماهیانه', 'required|max_length[8]');

            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
            $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
            $this->form_validation->set_message('numeric', '%s معتبر نیست');

            if ($this->form_validation->run() === TRUE) {
                $academy_id = $this->session->userdata('academy_id');

                $first_name = $this->input->post('first_name', true);
                $last_name = $this->input->post('last_name', true);
                $first_name_en = $this->input->post('first_name_en', true);
                $last_name_en = $this->input->post('last_name_en', true);
                $father_name = $this->input->post('father_name', true);
                $birthday = $this->input->post('birthday', true);
                $marital_status = $this->input->post('marital_status', true);
                $gender = $this->input->post('gender', true);
                $national_code = $this->input->post('national_code', true);
//            $password = $this->input->post('password', true);
                $phone_num = $this->input->post('phone_num', true);
                $tell = $this->input->post('tell', true);
                $province = $this->input->post('province', true);
                $city = $this->input->post('city', true);
                $street = $this->input->post('street', true);
                $postal_code = $this->input->post('postal_code', true);
                $pic_name = $this->input->post('pic_name', true);

                $activity_unit = $this->input->post('activity_unit', true);
                $monthly_salary = $this->input->post('monthly_salary', true);

                $all_level = $this->input->post('all_level', true);
                $classs = $this->input->post('classs', true);
                $lesson = $this->input->post('lesson', true);
                $course = $this->input->post('course', true);
                $exam = $this->input->post('exam', true);
                $student = $this->input->post('student', true);
                $teacher = $this->input->post('teacher', true);
                $personnel = $this->input->post('personnel', true);
                $financial_std = $this->input->post('financial_std', true);
                $financial_thr = $this->input->post('$financial_thr', true);
                $financial_prl = $this->input->post('$financial_prl', true);
                $ticket_std = $this->input->post('ticket_std', true);
                $ticket_thr = $this->input->post('ticket_thr', true);
                $ticket_prl = $this->input->post('ticket_prl', true);


                if ($this->exist->exist_entry('personnels', array('national_code' => $national_code, 'academy_id' => $academy_id))) {
                    $this->session->set_flashdata('national-code-msg', 'کارمند با کد ملی وارد شده قبلا ثبت شده است.');
                    $this->create_new_personnel();
                } else {

                    $insert_array['academy_id'] = $academy_id;
                    $insert_array['full_name'] = $first_name . ' ' . $last_name;
                    $insert_array['first_name'] = $first_name;
                    $insert_array['last_name'] = $last_name;
                    $insert_array['first_name_en'] = $first_name_en;
                    $insert_array['last_name_en'] = $last_name_en;
                    $insert_array['father_name'] = $father_name;
                    $insert_array['birthday'] = $birthday;
                    $insert_array['marital_status'] = $marital_status;
                    $insert_array['gender'] = $gender;
                    $insert_array['national_code'] = $national_code;
//                    $insert_array['password']=sha1($password . $this->salt);
                    $insert_array['phone_num'] = $phone_num;
                    $insert_array['tell'] = $tell;
                    $insert_array['province'] = $province;
                    $insert_array['city'] = $city;
                    $insert_array['street'] = $street;
                    $insert_array['postal_code'] = $postal_code;
                    $insert_array['activity_unit'] = $activity_unit;
                    $insert_array['monthly_salary'] = $monthly_salary;

                    if ($all_level === 'on') {
                        $insert_array['class'] = '1';
                        $insert_array['lesson'] = '1';
                        $insert_array['course'] = '1';
                        $insert_array['exam'] = '1';
                        $insert_array['student'] = '1';
                        $insert_array['teacher'] = '1';
                        $insert_array['personnel'] = '1';
                        $insert_array['financial_std'] = '1';
                        $insert_array['financial_thr'] = '1';
                        $insert_array['financial_prl'] = '1';
                        $insert_array['ticket_std'] = '1';
                        $insert_array['ticket_thr'] = '1';
                        $insert_array['ticket_prl'] = '1';
                    } else {
                        if ($classs === 'on')
                            $insert_array['class'] = '1';
                        if ($lesson === 'on')
                            $insert_array['lesson'] = '1';
                        if ($course === 'on')
                            $insert_array['course'] = '1';
                        if ($exam === 'on')
                            $insert_array['exam'] = '1';
                        if ($student === 'on')
                            $insert_array['student'] = '1';
                        if ($teacher === 'on')
                            $insert_array['teacher'] = '1';
                        if ($personnel === 'on')
                            $insert_array['personnel'] = '1';
                        if ($financial_std === 'on')
                            $insert_array['financial_std'] = '1';
                        if ($financial_thr === 'on')
                            $insert_array['financial_thr'] = '1';
                        if ($financial_prl === 'on')
                            $insert_array['financial_prl'] = '1';
                        if ($ticket_std === 'on')
                            $insert_array['ticket_std'] = '1';
                        if ($ticket_thr === 'on')
                            $insert_array['ticket_thr'] = '1';
                        if ($ticket_prl === 'on')
                            $insert_array['ticket_prl'] = '1';
                    }

                    $result_of_upload = $this->personnel_upload($_FILES);
                    $insert_array['pic_name'] = $result_of_upload['final_image_name'];

//                    if ($pic_name != '') {
//                        $result_of_upload = $this->my_upload($_FILES);
//                        if ($result_of_upload['result_image_name'] === '110') {
//                            $insert_array['pic_name'] = $result_of_upload['final_image_name'];
//                        } else {
//                            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                            $this->create_new_personnel();
//                        }
//                    }

                    $this->base->insert('personnels', $insert_array);
                    $this->session->set_flashdata('success-insert', 'کارمند مورد نظر ثبت گردید.');
                    echo "
                            <script type=\"text/javascript\">
                            sessionStorage . clear();
                            </script>
                        ";
                    redirect('users/manage-personnels', 'refresh');
                }
            } else {
                $this->create_new_personnel();
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function manage_personnels() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['managers_info'] = $this->base->get_data('personnels', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'manage-personnels';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('مدیریت کارمندها', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function edit_personnel() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $national_code = $this->input->post('national_code', true);
            $manager_info = $contentData['manager_info'] = $this->base->get_data('personnels', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            $birthday = $manager_info[0]->birthday;
            $contentData['birthday'] = strtr($birthday, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
            $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
            $contentData['yield'] = 'edit-personnel';
            $headerData['links'] = 'custom-select-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش اطلاعات کارمند', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function edit_activated_personnel() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $national_code = $this->input->post('national_code', true);
            $managers_info = $this->base->get_data('personnels', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if ($managers_info[0]->manager_activated == 0):
                $activated = array(
                    'manager_activated' => 1
                );
            else:
                $activated = array(
                    'manager_activated' => 0
                );
            endif;
            $this->base->update('personnels', array('national_code' => $national_code, 'academy_id' => $academy_id), $activated);
            redirect('users/manage-personnels', 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function update_personnel() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $this->form_validation->set_rules('first_name', 'نام', 'required|max_length[60]');
            $this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[60]');
            $this->form_validation->set_rules('first_name_en', 'نام لاتین', 'max_length[60]');
            $this->form_validation->set_rules('last_name_en', 'نام خانوادگی لاتین', 'max_length[60]');
            $this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[60]');
            $this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required');
            $this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');

            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('tell', 'تلفن ثابت', 'max_length[11]');
            $this->form_validation->set_rules('province', 'استان', 'required|max_length[60]');
            $this->form_validation->set_rules('city', 'شهر', 'required|max_length[60]');
            $this->form_validation->set_rules('street', 'آدرس', 'required|max_length[180]');
            $this->form_validation->set_rules('activity_unit', 'واحد فعالیت', 'required');
            $this->form_validation->set_rules('postal_code', 'کد پستی', 'exact_length[10]');
            $this->form_validation->set_rules('monthly_salary', 'حقوق ماهیانه', 'required|max_length[8]');

            $this->form_validation->set_message('required', '%s را وارد نمایید');
            $this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
            $this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
            $this->form_validation->set_message('numeric', '%s معتبر نیست');

            if ($this->form_validation->run() === TRUE) {
                $academy_id = $this->session->userdata('academy_id');

                $first_name = $this->input->post('first_name', true);
                $last_name = $this->input->post('last_name', true);
                $first_name_en = $this->input->post('first_name_en', true);
                $last_name_en = $this->input->post('last_name_en', true);
                $father_name = $this->input->post('father_name', true);
                $birthday = $this->input->post('birthday', true);
                $birthday = strtr($birthday, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
                $marital_status = $this->input->post('marital_status', true);
                $gender = $this->input->post('gender', true);
                $national_code = $this->input->post('national_code', true);
//            $password = $this->input->post('password', true);
                $phone_num = $this->input->post('phone_num', true);
                $tell = $this->input->post('tell', true);
                $province = $this->input->post('province', true);
                $city = $this->input->post('city', true);
                $street = $this->input->post('street', true);
                $postal_code = $this->input->post('postal_code', true);

                $activity_unit = $this->input->post('activity_unit', true);
                $monthly_salary = $this->input->post('monthly_salary', true);

                $all_level = $this->input->post('all_level', true);
                $classs = $this->input->post('classs', true);
                $lesson = $this->input->post('lesson', true);
                $course = $this->input->post('course', true);
                $exam = $this->input->post('exam', true);
                $student = $this->input->post('student', true);
                $teacher = $this->input->post('teacher', true);
                $personnel = $this->input->post('personnel', true);
                $financial_std = $this->input->post('financial_std', true);
                $financial_thr = $this->input->post('$financial_thr', true);
                $financial_prl = $this->input->post('$financial_prl', true);
                $ticket_std = $this->input->post('ticket_std', true);
                $ticket_thr = $this->input->post('ticket_thr', true);
                $ticket_prl = $this->input->post('ticket_prl', true);

                $insert_array['academy_id'] = $academy_id;
                $insert_array['full_name'] = $first_name . ' ' . $last_name;
                $insert_array['first_name'] = $first_name;
                $insert_array['last_name'] = $last_name;
                $insert_array['first_name_en'] = $first_name_en;
                $insert_array['last_name_en'] = $last_name_en;
                $insert_array['father_name'] = $father_name;
                $insert_array['birthday'] = $birthday;
                $insert_array['marital_status'] = $marital_status;
                $insert_array['gender'] = $gender;
                $insert_array['national_code'] = $national_code;
//                    $insert_array['password']=sha1($password . $this->salt);
                $insert_array['phone_num'] = $phone_num;
                $insert_array['tell'] = $tell;
                $insert_array['province'] = $province;
                $insert_array['city'] = $city;
                $insert_array['street'] = $street;
                $insert_array['postal_code'] = $postal_code;
                $insert_array['activity_unit'] = $activity_unit;
                $insert_array['monthly_salary'] = $monthly_salary;

                if ($all_level === 'on') {
                    $insert_array['class'] = '1';
                    $insert_array['lesson'] = '1';
                    $insert_array['course'] = '1';
                    $insert_array['exam'] = '1';
                    $insert_array['student'] = '1';
                    $insert_array['teacher'] = '1';
                    $insert_array['personnel'] = '1';
                    $insert_array['financial_std'] = '1';
                    $insert_array['financial_thr'] = '1';
                    $insert_array['financial_prl'] = '1';
                    $insert_array['ticket_std'] = '1';
                    $insert_array['ticket_thr'] = '1';
                    $insert_array['ticket_prl'] = '1';
                } else {
                    if ($classs === 'on')
                        $insert_array['class'] = '1';
                    if ($lesson === 'on')
                        $insert_array['lesson'] = '1';
                    if ($course === 'on')
                        $insert_array['course'] = '1';
                    if ($exam === 'on')
                        $insert_array['exam'] = '1';
                    if ($student === 'on')
                        $insert_array['student'] = '1';
                    if ($teacher === 'on')
                        $insert_array['teacher'] = '1';
                    if ($personnel === 'on')
                        $insert_array['personnel'] = '1';
                    if ($financial_std === 'on')
                        $insert_array['financial_std'] = '1';
                    if ($financial_thr === 'on')
                        $insert_array['financial_thr'] = '1';
                    if ($financial_prl === 'on')
                        $insert_array['financial_prl'] = '1';
                    if ($ticket_std === 'on')
                        $insert_array['ticket_std'] = '1';
                    if ($ticket_thr === 'on')
                        $insert_array['ticket_thr'] = '1';
                    if ($ticket_prl === 'on')
                        $insert_array['ticket_prl'] = '1';
                }

                $pic_name = $this->input->post('pic_name', true);
                if ($pic_name !== null) {
                    $result_of_upload = $this->personnel_upload($_FILES);
                    $insert_array['pic_name'] = $result_of_upload['final_image_name'];
                }

//                if ($pic_name != '') {
//                    $result_of_upload = $this->my_upload($_FILES);
//                    if ($result_of_upload['result_image_name'] === '110') {
//                        $insert_array['pic_name'] = $result_of_upload['final_image_name'];
//                    } else {
//                        $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
//                        $this->create_new_personnel();
//                    }
//                }

                $this->base->update('personnels', array('national_code' => $national_code, 'academy_id' => $academy_id), $insert_array);
                $this->session->set_flashdata('success-update', 'تغییرات مورد نظر اعمال گردید');
                $this->manage_personnels();
            } else {
                $this->edit_personnel();
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

    private function show_personnel_edit_after($na_code) {
        $academy_id = $this->session->userdata('academy_id');
        $contentData['manager_info'] = $this->base->get_data('personnels', '*', array('national_code' => $na_code, 'academy_id' => $academy_id));
        $contentData['city'] = $this->base->get_data('city', 'id,name', array('province' => '17'));
        $contentData['yield'] = 'edit-personnel';
        $headerData['links'] = 'custom-select-links';
        $footerData['scripts'] = 'custom-select-scripts';
        $headerData['secondLinks'] = 'persian-calendar-links';
        $footerData['secondScripts'] = 'persian-calendar-scripts';
        $headerData['thirdLinks'] = 'dropify-links';
        $footerData['thirdScripts'] = 'dropify-scripts';
        $this->show_pages('ویرایش اطلاعات کارمند', 'content', $contentData, $headerData, $footerData);
    }

    public function edit_activated_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $national_code = $this->input->post('national_code', true);
            $student_info = $this->base->get_data('students', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if ($student_info[0]->student_activated == 0):
                $activated = array(
                    'student_activated' => 1
                );
            else:
                $activated = array(
                    'student_activated' => 0
                );
            endif;
            $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), $activated);
            redirect('users/manage-students', 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

//*******
    public function manage_employers_pay() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $contentData['employers_info'] = $this->base->get_data('employers', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'manage-employers_pay';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('مدیریت مربیان', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('users-403', 'refresh');
        }
    }

    public function employer_inquiry() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $employer_nc = $this->input->post('national_code', true);
            if ($this->exist->exist_entry('employers', array('national_code' => $employer_nc, 'academy_id' => $academy_id))) {
                $headerData['links'] = 'data-table-links';
                $footerData['scripts'] = 'financial-data-table-scripts';
                $contentData['yield'] = 'employer-inquiry';
                $contentData['employers'] = $this->base->get_data('employers', '*', array('national_code' => $employer_nc, 'academy_id' => $academy_id));
                $contentData['courses'] = $this->get_join->get_data('lessons', 'courses', 'lessons.lesson_id=courses.lesson_id', 'courses_employers', 'courses.course_id=courses_employers.course_id', array('employee_nc' => $employer_nc, 'count_std != ' => 0, 'course_status != ' => 0, 'courses_employers.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
                $contentData['financial_state'] = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $employer_nc, 'academy_id' => $academy_id));
                $contentData['course_pouse'] = $this->base->get_data('course_pouse_pay', '*', array('employee_nc' => $employer_nc, 'academy_id' => $academy_id));
                $contentData['course_cash'] = $this->base->get_data('course_cash_pay', '*', array('employee_nc' => $employer_nc, 'academy_id' => $academy_id));
                $contentData['course_check'] = $this->base->get_data('course_check_pay', '*', array('employee_nc' => $employer_nc, 'academy_id' => $academy_id));
                $this->show_pages('وضعیت مالی استاد', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('users-403', 'refresh');
        }
    }

///////  Edit course_amount
    public function edit_course_amount() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $course_amount = $this->input->post('course_amount', true);
            $course_master = $this->input->post('course_master', true);
            $course_id = $this->input->post('course_id', true);
            $this->base->update('courses_employers', array('course_id' => $course_id, 'academy_id' => $academy_id), array('course_amount' => $course_amount));
            $this->manage_employers_pay();
//            redirect('users/employer-inquiry?employer_nc='.$course_master, 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

/////// Edit course_cost
    public function edit_course_cost() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $course_cost = $this->input->post('course_cost', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_id = $this->input->post('course_id', true);
            $this->base->update('courses_students', array('course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
            redirect('financial/finan-get-student-nc', 'refresh');
//            redirect('users/employer-inquiry?employer_nc='.$course_master, 'refresh');
        } else {
            redirect('users-403', 'refresh');
        }
    }

    ///////     edit birthday users
//    public function edit_birthday() {
//        $academy_id = $this->session->userdata('academy_id');
//        $national_code = $this->input->post('national_code', true);
//        $date = $this->input->post('birthday', true);
//        $birthday = strtr($date, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
//        $category = $this->input->post('category', true);
//        if ($category === '1') {
//            $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('birthday' => $birthday));
//            $this->show_student_edit_after($national_code);
//        } elseif ($category === '2') {
//            $this->base->update('employers', array('national_code' => $national_code, 'academy_id' => $academy_id), array('birthday' => $birthday));
//            $this->show_employee_edit_after($national_code);
//        } elseif ($category === '3') {
//            $this->base->update('personnels', array('national_code' => $national_code, 'academy_id' => $academy_id), array('birthday' => $birthday));
//            $this->show_personnel_edit_after($national_code);
//        }
//    }

    ///////     student update picture
    public function student_update_pic() {
        $academy_id = $this->session->userdata('academy_id');
        $national_code = $this->input->post('national_code');

        $result_of_upload = $this->student_upload($_FILES);
        if ($result_of_upload['result_image_name'] === '110') {
            $student_pic = $this->base->get_data('students', 'pic_name', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if (!empty($student_pic) && $student_pic[0]->pic_name !== 'student-icon.png') {
                unlink('./assets/profile-picture/thumb/' . $student_pic[0]->pic_name);
                unlink('./assets/profile-picture/' . $student_pic[0]->pic_name);
            }
            $insert_array['pic_name'] = $result_of_upload['final_image_name'];
            $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), $insert_array);
//            $this->show_student_edit_after($national_code);
			$this->edit_student();
        } else {
            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
            $this->edit_student();
        }
    }

    ///////     teacher update picture
    public function teacher_update_pic() {
        $academy_id = $this->session->userdata('academy_id');
        $national_code = $this->input->post('national_code');

        $result_of_upload = $this->teacher_upload($_FILES);
        if ($result_of_upload['result_image_name'] === '110') {
            $teacher_pic = $this->base->get_data('employers', 'pic_name', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if (!empty($teacher_pic) && $teacher_pic[0]->pic_name !== 'teacher-icon.png') {
                unlink('./assets/profile-picture/thumb/' . $teacher_pic[0]->pic_name);
                unlink('./assets/profile-picture/' . $teacher_pic[0]->pic_name);
            }
            $insert_array['pic_name'] = $result_of_upload['final_image_name'];
            $this->base->update('employers', array('national_code' => $national_code, 'academy_id' => $academy_id), $insert_array);
//            $this->show_employee_edit_after($national_code);
			$this->edit_employee();
        } else {
            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
            $this->edit_employee();
        }
    }

    ///////     personnel update picture
    public function personnel_update_pic() {
        $academy_id = $this->session->userdata('academy_id');
        $national_code = $this->input->post('national_code');

        $result_of_upload = $this->personnel_upload($_FILES);
        if ($result_of_upload['result_image_name'] === '110') {
            $personnel_pic = $this->base->get_data('personnels', 'pic_name', array('national_code' => $national_code, 'academy_id' => $academy_id));
            if (!empty($personnel_pic) && $personnel_pic[0]->pic_name !== 'pesonnel-icon.png') {
                unlink('./assets/profile-picture/thumb/' . $personnel_pic[0]->pic_name);
                unlink('./assets/profile-picture/' . $personnel_pic[0]->pic_name);
            }
            $insert_array['pic_name'] = $result_of_upload['final_image_name'];
            $this->base->update('personnels', array('national_code' => $national_code, 'academy_id' => $academy_id), $insert_array);
            $this->show_personnel_edit_after($national_code);
			$this->edit_personnel();
        } else {
            $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
            $this->edit_personnel();
        }
    }

    ///////     upload file
    public function student_upload() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => './assets/profile-picture',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10240,
            'file_name' => time()
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('pic_name')) {
            $pic_info = $this->upload->data();
            $pic_name = $pic_info['file_name'];
            $this->load->library('image_lib');
            $config_array = array(
                'source_image' => './assets/profile-picture/' . $pic_name,
                'new_image' => './assets/profile-picture/thumb/' . $pic_name,
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
            $final_image_name = 'student-icon.png';
        }
        $result = array(
            'img_name' => $result_image_name,
            'final_image_name' => $final_image_name,
            'result_image_name' => $result_image_name
        );
        return $result;
    }

    ///////     upload file
    public function teacher_upload() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => './assets/profile-picture',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10240,
            'file_name' => time()
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('pic_name')) {
            $pic_info = $this->upload->data();
            $pic_name = $pic_info['file_name'];
            $this->load->library('image_lib');
            $config_array = array(
                'source_image' => './assets/profile-picture/' . $pic_name,
                'new_image' => './assets/profile-picture/thumb/' . $pic_name,
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
            $final_image_name = 'teacher-icon.png';
        }
        $result = array(
            'img_name' => $result_image_name,
            'final_image_name' => $final_image_name,
            'result_image_name' => $result_image_name
        );
        return $result;
    }

    ///////     upload file
    public function personnel_upload() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => './assets/profile-picture',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10240,
            'file_name' => time()
        );
        $this->upload->initialize($config_array);

        if ($this->upload->do_upload('pic_name')) {
            $pic_info = $this->upload->data();
            $pic_name = $pic_info['file_name'];
            $this->load->library('image_lib');
            $config_array = array(
                'source_image' => './assets/profile-picture/' . $pic_name,
                'new_image' => './assets/profile-picture/thumb/' . $pic_name,
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
            $final_image_name = 'personnel-icon.png';
        }
        $result = array(
            'img_name' => $result_image_name,
            'final_image_name' => $final_image_name,
            'result_image_name' => $result_image_name
        );
        return $result;
    }

}
