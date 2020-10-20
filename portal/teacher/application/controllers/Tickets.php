<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
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



    /*
       ___              display_type              ___

    0 -> Send employee to manager AND Send manager to employee
    1 -> Send manager to student AND Send  student to manager
    2 -> Send employee to student AND Send student to employee


        ___      answer_status      ___

                1 -> answer student
                2 -> answer employee
                3 -> answer manager
    */

    public function to_manager() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['managers_info'] = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'list-of-ma-em-to-send-ticket';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages($title = 'ارسال تیکت به مدیریت', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function send_to_manager() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_title = $this->input->post('ticket_title', true);
            $ticket_body = $this->input->post('ticket_body', true);
            $manager_nc = $this->input->post('manager_nc', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';
                $created_at = jdate('Y/n/j - H:i:s');
                $insertArray = array(
                    'academy_id' => $academy_id,
                    'ticket_title' => $ticket_title,
                    'ticket_body' => $ticket_body,
                    'display_type' => '0',
                    'sender_nc' => $sessId,
                    'sender_type' => 'emp',
                    'receiver_nc' => $manager_nc,
                    'receiver_type' => 'mng',
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                    'last_update' => $created_at,
                );
                $last_insert = $this->base->insert('manager_tickets', $insertArray);
                $this->session->set_flashdata(array('id' => $last_insert));
                redirect('teacher/tickets/to-manager');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('teacher/tickets/to-manager');
            }
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function manager_tickets() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $type_1 = 'emp';
            $type_2 = 'mng';
            $display_type = '0';

            $manager_tickets = $this->base->find_ticket('manager_tickets','*', $academy_id, $display_type, $sessId, $type_1, $type_2);
            if (!empty($manager_tickets)) {
                foreach ($manager_tickets as $mt) {
                    $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));
                }
                $contentData['manager_tickets'] = $manager_tickets;
            }
            if(!empty($answer_info)) {
                // Convert two-dimensional array to one-dimensional
                $answer_tickets = call_user_func_array('array_merge', $answer_info);
                // end
                $contentData['answer_tickets'] = $answer_tickets;
            }
            $contentData['yield'] = 'manager-tickets';
            $this->show_pages($title = 'تیکت های بخش مدیریت', 'content', $contentData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function info_manager_tickets($id) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $manager_tickets = $contentData['manager_tickets'] = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));
            $answer_tickets = $contentData['answer_manager_tickets'] = $this->base->get_data('answer_manager_tickets', '*', ['academy_id' => $academy_id, 'answer_id' => $id], null, null, null, 'answer_ticket_id');

            if($manager_tickets[0]->receiver_type == 'emp') {
                $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
            }
            if(!empty($answer_tickets)) {
                foreach ($answer_tickets as $item) {
                    if ($item->receiver_type == 'emp') {
                        $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'emp'], ['ticket_status' => '1']);
                    }
                }
            }

            $contentData['yield'] = 'info-manager-tickets';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $this->show_pages($title = 'مشاهده تیکت های بخش مدیریت', 'content', $contentData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function answer_manager_tickets() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $manager_nc = $this->session->userdata('manager_nc');
            $ticket_id = $this->input->post('ticket_id', true);
            $ticket_body = $this->input->post('ticket_body', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';
                $created_at = jdate('Y/n/j - H:i:s');
                $insertArray = array(
                    'academy_id' => $academy_id,
                    'answer_id' => $ticket_id,
                    'ticket_body' => $ticket_body,
                    'display_type' => '0',
                    'sender_nc' => $sessId,
                    'sender_type' => 'emp',
                    'receiver_nc' => $manager_nc,
                    'receiver_type' => 'mng',
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at
                );

                $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
                if($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'emp') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['readed_status'] = '0';
                    $updateArray['answer_status'] = '0';
                }elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'emp'){
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '2';
                }elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '2' || $manager_ticket[0]->answer_status == '3')){
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '2';
                }

                $this->base->insert('answer_manager_tickets', $insertArray);
                $this->base->update('manager_tickets', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id), $updateArray);
                $this->session->set_flashdata('success-insert-st', 'پاسخ شما با موفقیت ارسال گردید.');
                redirect(base_url('teacher/tickets/info-manager-tickets/' . $ticket_id));
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect(base_url('teacher/tickets/info-manager-tickets/' . $ticket_id));
            }
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function to_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $iCourses = $contentData['iCourses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, ['course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id]);
//            $iCourses = $this->base->get_data('courses', 'course_id', array('course_master' => $sessId, 'academy_id' => $academy_id));
            if(!empty($iCourses)){
                foreach ($iCourses as $value) {
                    $iStudent = $this->base->get_data('courses_students', 'student_nc', array('course_id' => $value->course_id, 'academy_id' => $academy_id));
                    if(!empty($iStudent)) {
                        foreach ($iStudent as $iStd) {
                            $sCourses[] = $this->base->get_data('students', 'student_id, national_code, first_name, last_name, pic_name', array('national_code' => $iStd->student_nc, 'academy_id' => $academy_id))[0];
                        }
                    }
                }
                $sCourses = array_map('json_encode', $sCourses);
                $sCourses = array_unique($sCourses);
                $sCourses = array_map('json_decode', $sCourses);
                $contentData['sCourses'] = $sCourses;
//                print_r($sCourses);
            }
            $contentData['yield'] = 'list-of-st-em-to-send-ticket';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $this->show_pages($title = 'ارسال تیکت به ' . $this->session->userdata('studentDName'), 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function send_to_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_title = $this->input->post('ticket_title', true);
            $ticket_body = $this->input->post('ticket_body', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_id = $this->input->post('course_id', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';

                if(!empty($student_nc)) {
                    $created_at = jdate('Y/n/j - H:i:s');
                    $insertArray = array(
                        'academy_id' => $academy_id,
                        'ticket_title' => $ticket_title,
                        'ticket_body' => $ticket_body,
                        'display_type' => '2',
                        'sender_nc' => $sessId,
                        'sender_type' => 'emp',
                        'receiver_nc' => $student_nc,
                        'receiver_type' => 'std',
                        'file_name' => $resultOfUploadFile['final_ticket_name'],
                        'created_at' => $created_at,
                        'last_update' => $created_at,
                    );
                    $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    $this->session->set_flashdata(array('id' => $last_insert));
                }elseif (!empty($course_id)){
                    $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
                    if(!empty($course_students)){
                        foreach ($course_students as $student) {
                            $created_at = jdate('Y/n/j - H:i:s');
                            $insertArray = array(
                                'academy_id' => $academy_id,
                                'ticket_title' => $ticket_title,
                                'ticket_body' => $ticket_body,
                                'display_type' => '2',
                                'sender_nc' => $sessId,
                                'sender_type' => 'emp',
                                'receiver_nc' => $student->national_code,
                                'receiver_type' => 'std',
                                'file_name' => $resultOfUploadFile['final_ticket_name'],
                                'created_at' => $created_at,
                                'last_update' => $created_at,
                            );
                            $this->base->insert('manager_tickets', $insertArray);
                        }
                    $this->session->set_flashdata('success','تیکت شما با موفقیت ارسال شد.');
                    }
                }
                redirect('teacher/tickets/to-student');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('teacher/tickets/to-student');
            }
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function student_tickets() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');

            $type_1 = 'emp';
            $type_2 = 'std';
            $display_type = '2';
            $manager_tickets = $this->base->find_ticket('manager_tickets','*', $academy_id, $display_type, $sessId, $type_1, $type_2);
            if (!empty($manager_tickets)){
                foreach ($manager_tickets as $mt){
                    $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));

                    if($mt->sender_type == 'std' && $mt->receiver_type == 'emp'){
                        $student_info[] = $this->base->get_data('students', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->sender_nc))[0];
                    }
                    if($mt->sender_type == 'emp' && $mt->receiver_type == 'std'){
                        $student_info[] = $this->base->get_data('students', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->receiver_nc))[0];
                    }
                }
                $student_info = array_map('json_encode', $student_info);
                $student_info = array_unique($student_info);
                $student_info = array_map('json_decode', $student_info);
                $contentData['student_info'] = $student_info;
                $contentData['manager_tickets'] = $manager_tickets;
            }
            if(!empty($answer_info)) {
                // Convert two-dimensional array to one-dimensional
                $answer_tickets = call_user_func_array('array_merge', $answer_info);
                // end
                $contentData['answer_tickets'] = $answer_tickets;
            }
            $contentData['yield'] = 'student-tickets';
            $this->show_pages($title = 'تیکت های ' . $this->session->userdata('studentDName'), 'content', $contentData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function info_student_tickets($id) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');

            $manager_tickets = $contentData['manager_tickets'] = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));
            if($manager_tickets[0]->sender_type == 'std')
                $students = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
            elseif($manager_tickets[0]->receiver_type == 'std')
                $students = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

            $contentData['student_name'] = $students[0]->first_name . ' ' . $students[0]->last_name;
            $contentData['student_pic'] = $students[0]->pic_name;
            $contentData['student_nc'] = $students[0]->national_code;
            $answer_tickets = $contentData['answer_manager_tickets'] = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $id), null, null, null, 'answer_ticket_id');

            if($manager_tickets[0]->receiver_type == 'emp') {
                $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
            }
            if(!empty($answer_tickets)) {
                foreach ($answer_tickets as $item) {
                    if ($item->receiver_type == 'emp') {
                        $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'emp'], ['ticket_status' => '1']);
                    }
                }
            }

            $contentData['yield'] = 'info-student-tickets';
            $this->show_pages($title = 'مشاهده تیکت های ' . $this->session->userdata('studentDName'), 'content', $contentData);
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    public function answer_student_tickets() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_id = $this->input->post('ticket_id', true);
            $ticket_body = $this->input->post('ticket_body', true);
            $student_nc = $this->input->post('student_nc', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';
                $created_at = jdate('Y/n/j - H:i:s');
                $insertArray = array(
                    'academy_id' => $academy_id,
                    'answer_id' => $ticket_id,
                    'ticket_body' => $ticket_body,
                    'display_type' => '2',
                    'sender_nc' => $sessId,
                    'sender_type' => 'emp',
                    'receiver_nc' => $student_nc,
                    'receiver_type' => 'std',
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at
                );

//                $answer_tickets = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $ticket_id, 'receiver_type' => 'emp'));
                $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
                if($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'emp') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['readed_status'] = '0';
                    $updateArray['answer_status'] = '0';
                }elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'emp'){
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '2';
                }elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '2' || $manager_ticket[0]->answer_status == '1')){
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '2';
                }

                $this->base->insert('answer_manager_tickets', $insertArray);
                $this->base->update('manager_tickets', ['ticket_id' => $ticket_id, 'academy_id' => $academy_id], $updateArray);
                $this->session->set_flashdata('success-insert-st', 'پاسخ شما با موفقیت ارسال گردید.');
                redirect(base_url('teacher/tickets/info-student-tickets/' . $ticket_id));
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect(base_url('teacher/tickets/info-student-tickets/' . $ticket_id));
            }
        } else {
            redirect('teacher/tickets/error-403', 'refresh');
        }
    }

    private function my_upload() {
        if(isset($_FILES['ticket_file']['name']) && !empty($_FILES['ticket_file']['name'])){
            $academy_id = $this->session->userdata('academy_id');
            $this->load->library('upload');
            $config_array = array(
                'upload_path' => './../assets/ticket-file',
                'allowed_types' => 'pdf|doc|docx|xlsx|xls|txt|jpg|jpeg|png',
                'max_size' => 20000,
                'file_name' => time().rand(1000,9999)
            );
            $this->upload->initialize($config_array);

            if ($this->upload->do_upload('ticket_file')) {
                $ticket_info = $this->upload->data();
                $ticket_name = $ticket_info['file_name'];
                $result_ticket_name = '110';
                $final_ticket_name = $ticket_name;
                $file_size = $ticket_info['file_size'];
                $academy = $this->base->get_data('academys_option', 'size_uploaded', array('academy_id' => $academy_id));
                $this->base->update('academys_option', array('academy_id' => $academy_id), array('size_uploaded' => $academy[0]->size_uploaded + $file_size));
            } else {
                $result_ticket_name = '404';
                $final_ticket_name = 'user-default.jpg';
            }
        } else {
            $result_ticket_name = '110';
            $final_ticket_name = '';
        }
        $result = array(
            'img_name' => $result_ticket_name,
            'final_ticket_name' => $final_ticket_name,
            'result_ticket_name' => $result_ticket_name
        );
        return $result;
    }


//    public function leave_ticket() {
//        $sessId = $this->session->userdata('session_id');
//        $userType = $this->session->userdata('user_type');
//        if (!empty($sessId) && $userType === 'teachers') {
//            $contentData['yield'] = 'leave-ticket';
//            $this->show_pages($title = 'ارسال در خواست مرخصی', 'content', $contentData);
//        } else {
//            redirect('teacher/tickets/error-403', 'refresh');
//        }
//    }
//
//    public function sending_request() {
//        $this->form_validation->set_rules('title', 'عنوان درخواست', 'required|max_length[250]');
//        $this->form_validation->set_rules('body', 'متن درخواست', 'required');
//        $this->form_validation->set_message('required', '%s را وارد نمایید');
//        $this->form_validation->set_message('max_length', 'لطفا کوتاه و مختصر بنویسید');
//
//        if ($this->form_validation->run() === TRUE) {
//            $academy_id = $this->session->userdata('academy_id');
//            $title = $this->input->post('title', true);
//            $body = $this->input->post('body', true);
//            $insertArray = array(
//                'academy_id' => $academy_id,
//                'leave_ticket_title' => $title,
//                'leave_ticket_body' => $body,
//                'employee_nc' => $this->session->userdata('session_id')
//            );
//            $this->base->insert('leave_tickets', $insertArray);
//            $sessArray = array(
//                'success-insert' => 'ثبت درخواست مرخصی شما با موفقیت ثبت گردید'
//            );
//            $this->session->set_flashdata($sessArray);
//            redirect('teacher/tickets/leave-ticket', 'refresh');
//        } else {
//            $this->leave_ticket();
//        }
//    }
//
//    public function all_leave_tickets_status() {
//        $sessId = $this->session->userdata('session_id');
//        $userType = $this->session->userdata('user_type');
//        if (!empty($sessId) && $userType === 'teachers') {
//            $academy_id = $this->session->userdata('academy_id');
//            $contentData['leave_tickets'] = $this->base->get_data('leave_tickets', '*', array('employee_nc' => $sessId, 'academy_id' => $academy_id));
//            $contentData['yield'] = 'list-of-employee-leave-tickets';
//            $this->show_pages($title = 'وضعیت درخواست های مرخصی', 'content', $contentData);
//        } else {
//            redirect('teacher/tickets/error-403', 'refresh');
//        }
//    }
}
