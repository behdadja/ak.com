<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('calc');
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('teacher/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function show_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            require_once 'jdf.php';
            $academy_id = $this->session->userdata('academy_id');
            $contentData['user_info'] = $this->base->get_data('employers', '*', array('national_code' => $sessId, 'academy_id' => $academy_id));
            $contentData['manager_employee_sms'] = $this->get_join->get_data('manager_employee_sms', 'personnels', 'manager_employee_sms.manager_nc=personnels.national_code', null, null, array('employee_nc' => $sessId, 'manager_employee_sms.academy_id' => $academy_id, 'personnels.academy_id' => $academy_id));
            $contentData['financial_situation'] = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['count_of_course'] = $this->get_join->getCountOfTable('courses', array('course_master' => $sessId, 'academy_id' => $academy_id));
            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'courses.course_master=employers.national_code', array('national_code' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));

            $manager_ticket = $this->base->get_data('manager_tickets', '*', ['academy_id' => $academy_id, 'receiver_type' => 'emp', 'receiver_nc' => $sessId, 'readed_status' => '0']);
            $answer_ticket = $this->base->get_data('answer_manager_tickets', '*', ['academy_id' => $academy_id, 'receiver_type' => 'emp', 'receiver_nc' => $sessId, 'ticket_status' => '0']);
//            print_r($answer_ticket);
            $contentData['count_of_tickets'] = count($manager_ticket) + count($answer_ticket);

            $announcements = $this->base->get_announcement('*', 'announcements', ['academy_id' => $academy_id], 'receiver',['emp','all'], 'announcement_id');
            if(!empty($announcements)) {
                foreach ($announcements as $item) {
                    //   convert date shamsi to time()
                    $start = explode('-', $item->start_time);
                    $start_time = jmktime(0, 0, 0, $start[1], $start[2], $start[0]);
                    $stop = explode('-', $item->stop_time);
                    $stop_time = jmktime(0, 0, 0, $stop[1], $stop[2], $stop[0]);
                    //    end
                    if (time() >= $start_time && time() <= $stop_time) {
                        $contentData['announcements'][] = $item;
                    }
                }
            }
            $courses_employers = ($this->base->get_data('courses_employers', '*',['academy_id' => $academy_id, 'employee_nc'=> $sessId]));
            if(!empty($courses_employers)) {
                foreach ($courses_employers as $courses_employer) {
                    $announcements_crs[] = $this->get_join->get_data('announcements', 'courses', 'announcements.ant_course_id=courses.course_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', ['announcements.academy_id' => $academy_id, 'announcements.receiver' => 'crs', 'announcements.ant_course_id' => $courses_employer->course_id, 'courses.course_id' => $courses_employer->course_id], 'announcement_id');
                }
            }
            if(!empty($announcements_crs)) {
                // Convert two-dimensional array to one-dimensional
                $announcements_crs = call_user_func_array('array_merge', $announcements_crs);
                // end

                foreach ($announcements_crs as $crs) {
                    //   convert date shamsi to time()
                    $start = explode('-', $crs->start_time);
                    $start_time = jmktime(0, 0, 0, $start[1], $start[2], $start[0]);
                    $stop = explode('-', $crs->stop_time);
                    $stop_time = jmktime(0, 0, 0, $stop[1], $stop[2], $stop[0]);
                    //    end
                    if (time() >= $start_time && time() <= $stop_time) {
                        $contentData['announcements_crs'][] = $crs;
                    }
                }
            }
//			$sessId = $this->session->userdata('session_id');
//			$userType = $this->session->userdata('user_type');
//			if (!empty($sessId) && $userType === 'teachers') {
//
//				$academy_id = $this->session->userdata('academy_id');
//				$this->load->library('calc');
//				$contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
				$contentData['classes'] = $this->base->get_data('classes', '*', array('academy_id' => $academy_id));
				$contentData['count_student_course'] = $this->get_join->get_data('courses', 'courses_students', 'courses_students.course_id=courses.course_id', null, null, array('courses.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
//				$contentData['yield'] = 'my-courses';
//				$headerData['links'] = 'data-table-links';
//				$footerData['scripts'] = 'data-table-scripts';
//			} else {
//				redirect('teacher/courses/error-403', 'refresh');
//			}

            //  ************************************************
            //  $contentData['wallet'] = $this->base->get_data('wallet_students', '*', array('student_nc' => $sessId));
            //  $contentData['manager_employee_tickets'] = $this->get_join->get_data('manager_employee_tickets', 'personnels', 'manager_employee_tickets.manager_nc=personnels.national_code', null, null, array('employee_nc' => $sessId, 'manager_employee_tickets.academy_id' => $academy_id, 'personnels.academy_id' => $academy_id));
            //  $contentData['student_employee_tickets'] = $this->get_join->get_data('student_employee_tickets', 'students', 'student_employee_tickets.student_nc=students.national_code', null, null, array('employee_nc' => $sessId, 'student_employee_tickets.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            //  $contentData['employee_student_tickets'] = $this->get_join->get_data('employee_student_tickets', 'students', 'employee_student_tickets.student_nc=students.national_code', null, null, array('employee_nc' => $sessId, 'employee_student_tickets.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            //  $contentData['employee_manager_tickets'] = $this->get_join->get_data('employee_manager_tickets', 'personnels', 'employee_manager_tickets.manager_nc=personnels.national_code', null, null, array('employee_nc' => $sessId, 'employee_manager_tickets.academy_id' => $academy_id, 'personnels.academy_id' => $academy_id));
            //  ************************************************

            $headerData['links'] = 'data-table-links';
            $headerData['secondLinks'] = 'dropify-links';
            $footerData['scripts'] = 'data-table-scripts';
            $footerData['secondScripts'] = 'dashboard-scripts';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $contentData['yield'] = 'dashboard';
            $this->show_pages($title = 'پروفایل کاربری', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('./', 'refresh');
        }
    }

    public function inquiry() {
        if ($this->input->is_ajax_request()) {
            $academy_id = $this->session->userdata('academy_id');
            $nc = $this->input->post('student_nc', true);
            if ($this->exist->exist_entry('students', array('national_code' => $nc, 'academy_id' => $academy_id))) {
                echo json_encode(array('exist' => true));
            } else {
                echo json_encode(array('notexist' => true));
            }
        }
    }

    public function reply_ticket() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $reply_body = $this->input->post('reply_body', true);
            $id = $this->input->post('idreply', true);
            $uArray = array('answer_body' => $reply_body, 'answer_status' => '1');
            $this->base->update('manager_student_tickets', array('mst_id' => $id, 'academy_id' => $academy_id), $uArray);
            $this->session->set_flashdata('reply-success', 'پاسخ با موفقیت ارسال گردید.');
            redirect('teacher/profile', 'refresh');
        } else {
            redirect('teacher/profile/error-403', 'refresh');
        }
    }

    public function change_phone_number() {
        $this->form_validation->set_rules('change_phone', 'شماره تماس', 'required|exact_length[11]|numeric');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $this->form_validation->set_message('exact_length', 'شماره تماس باید 11 رقم باشد');
        $this->form_validation->set_message('numeric', '%s معتبر نیست');
        if ($this->form_validation->run() === True) {
            $academy_id = $this->session->userdata('academy_id');
            $phone_num = $this->input->post('change_phone', true);
            $em_nc = $this->session->userdata('session_id');
            if ($this->exist->exist_entry('employers', array('national_code' => $em_nc, 'academy_id' => $academy_id))) {
                $this->base->update('employers', array('national_code' => $em_nc, 'academy_id' => $academy_id), array('phone_num' => $phone_num));
                $this->session->set_flashdata('update-success', 'شماره تماس با موفقیت تغییر یافت.');
                redirect('teacher/profile', 'refresh');
            } else {
                $this->session->set_flashdata('user-not-exist', 'درخواست شما معتبر نمی باشد.');
                redirect('teacher/profile', 'refresh');
            }
        } else {
            $this->show_profile();
        }
    }
    public function edit_teacher_profile() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id', true);
            $user_info=$contentData['user_info'] = $this->base->get_data('employers', '*', array('national_code'=>$sessId,'academy_id'=>$academy_id));
            $birthday = $user_info[0]->birthday;
            $contentData['birthday'] = strtr($birthday, array('0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'));
            $contentData['yield'] = 'edit-teacher-profile';
            $headerData['links'] = 'custom-select-links';
            $footerData['scripts'] = 'custom-select-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $headerData['thirdLinks'] = 'dropify-links';
            $footerData['thirdScripts'] = 'dropify-scripts';
            $this->show_pages('ویرایش پروفایل', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/profile/error-403', 'refresh');
        }
    }
    public function update_teacher_profile(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $this->form_validation->set_rules('first_name_en', 'نام انگلیسی', 'required|max_length[60]');
            $this->form_validation->set_rules('last_name_en', 'نام خانوادگی انگلیسی', 'required|max_length[60]');
            $this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');
            $this->form_validation->set_rules('street', 'آدرس', 'max_length[180]');
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
                    'birthday' => $birthday,
                    'first_name_en' => $this->input->post('first_name_en', true),
                    'last_name_en' => $this->input->post('last_name_en', true),
                    'phone_num' => $this->input->post('phone_num', true),
                    'street' => $this->input->post('street', true),
                );
                $this->base->update('employers', array('national_code' => $sessId, 'academy_id' => $academy_id), $update_array);
                $this->session->set_flashdata('success-update', 'تغییرات مورد نظر اعمال گردید');
                $this->edit_teacher_profile();
            } else {
                $this->edit_teacher_profile();
            }
        } else {
            redirect('teacher/profile/error-403', 'refresh');
        }
    }
    public function teacher_update_pic(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $result_of_upload = $this->upload_pic($_FILES);
            if ($result_of_upload['result_image_name'] === '110') {
                $teacher_info = $this->base->get_data('employers', 'pic_name', array('academy_id' => $academy_id,'national_code'=>$sessId));
                if (!empty($teacher_info) && $teacher_info[0]->pic_name !== 'teacher-icon.png') {
                    unlink('../assets/profile-picture/thumb/' . $teacher_info[0]->pic_name);
                    unlink('../assets/profile-picture/' . $teacher_info[0]->pic_name);
                }
                $insert_array['pic_name'] = $result_of_upload['final_image_name'];
                $this->base->update('employers', array('academy_id' => $academy_id,'national_code'=>$sessId), $insert_array);
                $this->session->set_userdata('pic_name',$result_of_upload['final_image_name']);
                redirect('teacher/profile', 'refresh');
            } else {
                $this->session->set_flashdata('upload-msg', 'بارگزاری تصویر با مشکل مواجه شده است، لطفا مجددا تلاش نمایید.');
                redirect('teacher/profile', 'refresh');
            }
        } else {
            redirect('teacher/profile/error-403', 'refresh');
        }
    }
    public function upload_pic() {
        $this->load->library('upload');
        $config_array = array(
            'upload_path' => '../assets/profile-picture',
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
                'source_image' => '../assets/profile-picture/' . $pic_name,
                'new_image' => '../assets/profile-picture/thumb/' . $pic_name,
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
}
