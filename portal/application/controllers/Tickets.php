<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->library('calc');
    }

    public function error_403()
    {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null)
    {
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

    3 -> Send to students of a course


        ___      answer_status      ___

                1 -> answer student
                2 -> answer employee
                3 -> answer manager
    */

    public function to_student()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['students'] = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $contentData['yield'] = 'list-of-st-co-to-send-ticket';
            $this->show_pages($title = 'ارسال تیکت به دانشجویان', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function send_to_student() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_title = $this->input->post('ticket_title', true);
            $ticket_body = $this->input->post('ticket_body', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_id = $this->input->post('course_id', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {

                if(!empty($student_nc)){
                    require_once 'jdf.php';
                    $created_at = jdate('Y/n/j - H:i:s');
                    $insertArray = [
                        'academy_id' => $academy_id,
                        'ticket_title' => $ticket_title,
                        'ticket_body' => $ticket_body,
                        'display_type' => '1',
                        'sender_nc' => $sessId,
                        'sender_type' => 'mng',
                        'receiver_nc' => $student_nc,
                        'receiver_type' => 'std',
                        'file_name' => $resultOfUploadFile['final_ticket_name'],
                        'created_at' => $created_at,
                        'last_update' => $created_at,
                    ];
                    $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    $this->session->set_flashdata(array('id' => $last_insert));
                }elseif (!empty($course_id)){
                    $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
                    if(!empty($course_students)) {
                        foreach ($course_students as $student) {
                            require_once 'jdf.php';
                            $created_at = jdate('Y/n/j - H:i:s');
                            $insertArray = [
                                'academy_id' => $academy_id,
                                'ticket_title' => $ticket_title,
                                'ticket_body' => $ticket_body,
                                'display_type' => '1',
                                'sender_nc' => $sessId,
                                'sender_type' => 'mng',
                                'receiver_nc' => $student->national_code,
                                'receiver_type' => 'std',
                                'file_name' => $resultOfUploadFile['final_ticket_name'],
                                'created_at' => $created_at,
                                'last_update' => $created_at,
                            ];
                            $this->base->insert('manager_tickets', $insertArray);
                        }
                    }
                    $this->session->set_flashdata('success', 'تیکت شما با موفقیت ارسال شد');
                }else{
                    $students = $this->base->get_data('students', 'national_code', ['academy_id' => $academy_id]);
                    if (!empty($students)) {
                        foreach ($students as $std) {
                            require_once 'jdf.php';
                            $created_at = jdate('Y/n/j - H:i:s');
                            $insertArray = [
                                'academy_id' => $academy_id,
                                'ticket_title' => $ticket_title,
                                'ticket_body' => $ticket_body,
                                'display_type' => '1',
                                'sender_nc' => $sessId,
                                'sender_type' => 'mng',
                                'receiver_nc' => $std->national_code,
                                'receiver_type' => 'std',
                                'file_name' => $resultOfUploadFile['final_ticket_name'],
                                'created_at' => $created_at,
                                'last_update' => $created_at,
                            ];
                            $this->base->insert('manager_tickets', $insertArray);
                        }
                    }
                    $this->session->set_flashdata('success', 'تیکت شما با موفقیت ارسال شد');
                }

                redirect('tickets/to-student');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('tickets/to-student');
            }
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function student_tickets()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');

            $type_1 = 'mng';
            $type_2 = 'std';
            $display_type = '1';
            $manager_tickets = $this->base->find_ticket('manager_tickets', '*', $academy_id, $display_type, $sessId, $type_1, $type_2);
            if (!empty($manager_tickets)) {
                foreach ($manager_tickets as $mt) {
                    $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));

                    if ($mt->sender_type == 'std' && $mt->receiver_type == 'mng') {
                        $student_info[] = $this->base->get_data('students', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->sender_nc))[0];
                    }
                    if ($mt->sender_type == 'mng' && $mt->receiver_type == 'std') {
                        $student_info[] = $this->base->get_data('students', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->receiver_nc))[0];
                    }
                }
                $student_info = array_map('json_encode', $student_info);
                $student_info = array_unique($student_info);
                $student_info = array_map('json_decode', $student_info);
                $contentData['student_info'] = $student_info;
                $contentData['manager_tickets'] = $manager_tickets;

            }
            if (!empty($answer_info)) {
                // Convert two-dimensional array to one-dimensional
                $answer_tickets = call_user_func_array('array_merge', $answer_info);
                // end
                $contentData['answer_tickets'] = $answer_tickets;
            }
            $contentData['yield'] = 'student-tickets';
            $this->show_pages($title = 'تیکت های ' . $this->session->userdata('studentDName'), 'content', $contentData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function info_student_tickets($id)
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $manager_tickets = $contentData['manager_tickets'] = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));

            if($manager_tickets[0]->sender_type == 'std')
                $contentData['info_std'] = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
            elseif($manager_tickets[0]->receiver_type == 'std')
                $contentData['info_std'] = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

            $answer_tickets = $contentData['answer_manager_tickets'] = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $id), null, null, null, 'answer_ticket_id');

            if ($manager_tickets[0]->receiver_type == 'mng') {
                $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
            }
            if (!empty($answer_tickets)) {
                foreach ($answer_tickets as $item) {
                    if ($item->receiver_type == 'mng') {
                        $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'mng'], ['ticket_status' => '1']);
                    }
                }
            }

            $contentData['yield'] = 'info-student-tickets';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'financial-data-table-scripts';
            $this->show_pages($title = 'مشاهده تیکت های ' . $this->session->userdata('studentDName'), 'content', $contentData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function answer_student_tickets()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
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
                    'display_type' => '1',
                    'sender_nc' => $sessId,
                    'sender_type' => 'mng',
                    'receiver_nc' => $student_nc,
                    'receiver_type' => 'std',
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at
                );

                $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
                if ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'mng') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['readed_status'] = '0';
                    $updateArray['answer_status'] = '0';
                } elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'mng') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '3';
                } elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '3' || $manager_ticket[0]->answer_status == '1')) {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '3';
                }

                $this->base->insert('answer_manager_tickets', $insertArray);
                $this->base->update('manager_tickets', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id), $updateArray);
                $this->session->set_flashdata('success-insert-st', 'پاسخ شما با موفقیت ارسال گردید.');
                redirect(base_url('tickets/info-student-tickets/' . $ticket_id));
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect(base_url('tickets/info-student-tickets/' . $ticket_id));
            }
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function to_employee()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['employers_info'] = $this->base->get_data('employers', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'list-of-em-to-send-ticket';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages($title = 'ارسال تیکت به ' . $this->session->userdata('teacherDName'), 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function send_to_employee()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_title = $this->input->post('ticket_title', true);
            $ticket_body = $this->input->post('ticket_body', true);
            $employee_nc = $this->input->post('employee_nc', true);

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {

                if (!empty($employee_nc)){
                    require_once 'jdf.php';
                    $created_at = jdate('Y/n/j - H:i:s');
                    $insertArray = array(
                        'academy_id' => $academy_id,
                        'ticket_title' => $ticket_title,
                        'ticket_body' => $ticket_body,
                        'display_type' => '0',
                        'sender_nc' => $sessId,
                        'sender_type' => 'mng',
                        'receiver_nc' => $employee_nc,
                        'receiver_type' => 'emp',
                        'file_name' => $resultOfUploadFile['final_ticket_name'],
                        'created_at' => $created_at,
                        'last_update' => $created_at,
                    );
                    $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    $this->session->set_flashdata(array('id' => $last_insert));
                }elseif (empty($employee_nc)){
                    $employers = $this->base->get_data('employers', '*', array('academy_id' => $academy_id));
                    if (!empty($employers)) {
                        foreach ($employers as $emp) {
                            require_once 'jdf.php';
                            $created_at = jdate('Y/n/j - H:i:s');
                            $insertArray = [
                                'academy_id' => $academy_id,
                                'ticket_title' => $ticket_title,
                                'ticket_body' => $ticket_body,
                                'display_type' => '0',
                                'sender_nc' => $sessId,
                                'sender_type' => 'mng',
                                'receiver_nc' => $emp->national_code,
                                'receiver_type' => 'emp',
                                'file_name' => $resultOfUploadFile['final_ticket_name'],
                                'created_at' => $created_at,
                                'last_update' => $created_at,
                            ];
                            $this->base->insert('manager_tickets', $insertArray);
                        }
                    }
                    $this->session->set_flashdata('success', 'تیکت شما با موفقیت ارسال شد');
                }
                redirect('tickets/to-employee');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('tickets/to-employee');
            }
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function employee_tickets()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $type_1 = 'mng';
            $type_2 = 'emp';
            $display_type = '0';
            $manager_tickets = $this->base->find_ticket('manager_tickets', '*', $academy_id, $display_type, $sessId, $type_1, $type_2);
            if (!empty($manager_tickets)) {
                foreach ($manager_tickets as $mt) {
                    $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));

                    if ($mt->sender_type == 'emp' && $mt->receiver_type == 'mng') {
                        $employee_info[] = $this->base->get_data('employers', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->sender_nc))[0];
                    }
                    if ($mt->sender_type == 'mng' && $mt->receiver_type == 'emp') {
                        $employee_info[] = $this->base->get_data('employers', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->receiver_nc))[0];
                    }
                }
                $employee_info = array_map('json_encode', $employee_info);
                $employee_info = array_unique($employee_info);
                $employee_info = array_map('json_decode', $employee_info);
                $contentData['employee_info'] = $employee_info;
                $contentData['manager_tickets'] = $manager_tickets;
            }
            if (!empty($answer_info)) {
                // Convert two-dimensional array to one-dimensional
                $answer_tickets = call_user_func_array('array_merge', $answer_info);
                // end
                $contentData['answer_tickets'] = $answer_tickets;
            }
            $contentData['yield'] = 'employee-tickets';
            $this->show_pages($title = 'تیکت های ' . $this->session->userdata('teacherDName'), 'content', $contentData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function info_employee_tickets($id)
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $manager_tickets = $contentData['manager_tickets'] = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));

            if($manager_tickets[0]->sender_type == 'emp')
                $contentData['info_emp'] = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
            elseif($manager_tickets[0]->receiver_type == 'emp')
                $contentData['info_emp'] = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

            $answer_tickets = $contentData['answer_manager_tickets'] = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $id), null, null, null, 'answer_ticket_id');

            if ($manager_tickets[0]->receiver_type == 'mng') {
                $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
            }
            if (!empty($answer_tickets)) {
                foreach ($answer_tickets as $item) {
                    if ($item->receiver_type == 'mng') {
                        $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'mng'], ['ticket_status' => '1']);
                    }
                }
            }

            $contentData['yield'] = 'info-employee-tickets';
            $this->show_pages($title = 'مشاهده تیکت های ' . $this->session->userdata('teacherDName'), 'content', $contentData);
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function answer_employee_tickets()
    {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $ticket_id = $this->input->post('ticket_id', true);
            $employee_nc = $this->input->post('employee_nc', true);
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
                    'sender_type' => 'mng',
                    'receiver_nc' => $employee_nc,
                    'receiver_type' => 'emp',
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at
                );

                $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
                if ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'mng') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['readed_status'] = '0';
                    $updateArray['answer_status'] = '0';
                } elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'mng') {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '3';
                } elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '3' || $manager_ticket[0]->answer_status == '2')) {
                    $updateArray['last_update'] = $created_at;
                    $updateArray['answer_status'] = '3';
                }
                $this->base->insert('answer_manager_tickets', $insertArray);
                $this->base->update('manager_tickets', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id), $updateArray);
                $this->session->set_flashdata('success-insert-st', 'پاسخ شما با موفقیت ارسال گردید.');
                redirect(base_url('tickets/info-employee-tickets/' . $ticket_id));
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect(base_url('tickets/info-employee-tickets/' . $ticket_id));
            }
        } else {
            redirect('tickets/error-403', 'refresh');
        }
    }

    public function send_sms_to_employee() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $sms_body = $this->input->post('sms_body', true);
            $employee_nc = $this->input->post('employee_nc', true);
            $user = $this->session->userdata('teacherDName');

            if (!empty($employee_nc)) {
                $employer = $this->base->get_data('employers', '*', ['national_code' => $employee_nc, 'academy_id' => $academy_id]);
                $phone_num = $employer[0]->phone_num;
                $this->send_sms($phone_num, $sms_body, $user);
                $insertArray = [
                    'academy_id' => $academy_id,
                    'mss_body' => $sms_body,
                    'manager_nc' => $sessId,
                    'employee_nc' => $employee_nc,
                    'mss_from' => '1'
                ];
                $this->base->insert('manager_employee_sms', $insertArray);
            } else {
                $employers = $this->base->get_data('employers', '*', ['academy_id' => $academy_id]);
                if (!empty($employers)) {
                    foreach($employers as $emp){
                        $phone_num = $emp->phone_num;
                        $this->send_sms($phone_num, $sms_body,  $user);
                        $insertArray = [
                            'academy_id' => $academy_id,
                            'mss_body' => $sms_body,
                            'manager_nc' => $sessId,
                            'employee_nc' => $employee_nc,
                            'mss_from' => '1'
                        ];
                        $this->base->insert('manager_employee_sms', $insertArray);
                    }
                }
            }
            $this->session->set_flashdata('success', 'پیامک با موفقیت ارسال گردید.');
            redirect('tickets/to-employee');
        } else
            redirect('tickets/error-403', 'refresh');
    }

    public function send_sms_to_student(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $sms_body = $this->input->post('sms_body', true);
            $student_nc = $this->input->post('student_nc', true);
            $course_id = $this->input->post('course_id', true);
            $user = $this->session->userdata('studentDName');

            if (!empty($student_nc)) {
                $students = $this->base->get_data('students', '*', ['national_code' => $student_nc, 'academy_id' => $academy_id]);
                $phone_num = $students[0]->phone_num;
                $this->send_sms($phone_num, $sms_body, $user);
                $insertArray = [
                    'academy_id' => $academy_id,
                    'mss_body' => $sms_body,
                    'manager_nc' => $sessId,
                    'student_nc' => $student_nc,
                    'mss_from' => '1'
                ];
                $this->base->insert('manager_student_sms', $insertArray);
            }elseif (!empty($course_id)) {
                $students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, ['courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id,'course_id'=>$course_id]);
                if (!empty($students)) {
                    foreach($students as $student){
                        $phone_num = $student->phone_num;
                        $this->send_sms($phone_num, $sms_body,  $user);
                        $insertArray = [
                            'academy_id' => $academy_id,
                            'mss_body' => $sms_body,
                            'manager_nc' => $sessId,
                            'student_nc' => $student_nc,
                            'mss_from' => '1'
                        ];
                        $this->base->insert('manager_student_sms', $insertArray);
                    }
                }
            } elseif(empty($course_id) && empty($student_nc)) {
                $students = $this->base->get_data('students', '*', ['academy_id' => $academy_id]);
                if (!empty($students)) {
                    foreach($students as $student){
                        $phone_num = $student->phone_num;
                        $this->send_sms($phone_num, $sms_body,  $user);
                        $insertArray = [
                            'academy_id' => $academy_id,
                            'mss_body' => $sms_body,
                            'manager_nc' => $sessId,
                            'student_nc' => $student_nc,
                            'mss_from' => '1'
                        ];
                        $this->base->insert('manager_student_sms', $insertArray);
                    }
                }
            }
            $this->session->set_flashdata('success', 'پیامک با موفقیت ارسال گردید.');
            redirect('tickets/to-student');
        } else
            redirect('tickets/error-403', 'refresh');
    }

    public function send_announcement(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['employers'] = $this->base->get_data('employers','*', ['academy_id'=> $academy_id]);
            $contentData['students'] = $this->base->get_data('students','*', ['academy_id'=> $academy_id]);
            $contentData['courses'] = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', array('courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
            $contentData['yield'] = 'send_announcement';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('ارسال اطلاعیه','content',$contentData, $headerData, $footerData);
        }else
            redirect('tickets/error-403', 'refresh');
    }

    public function insert_announcement(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $ant_title = $this->input->post('ant_title', true);
            $ant_body = $this->input->post('ant_body', true);
            $receiver = $this->input->post('receiver', true);
            $course_id = $this->input->post('course_id', true);
            $start_time = strtr($this->input->post('start_time', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
            $stop_time = strtr($this->input->post('stop_time', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));

            $resultOfUploadFile = $this->my_upload($_FILES);
            if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';
                $created_at = jdate('Y/n/j - H:i:s');
                $insertArray = [
                    'academy_id' => $academy_id,
                    'title' => $ant_title,
                    'body' => $ant_body,
                    'sender_type' => 'mng',
                    'sender_nc' => $sessId,
                    'start_time' => $start_time,
                    'stop_time' => $stop_time,
                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                ];
                if($receiver == 'std' && empty($course_id)) {
                    $insertArray['receiver'] = $receiver;
                }elseif($receiver == 'emp' && empty($course_id)){
                    $insertArray['receiver'] = $receiver;
                }elseif($receiver == 'all' && empty($course_id)){
                    $insertArray['receiver'] = $receiver;
                }elseif($receiver == 'crs' && !empty($course_id)){
                    $insertArray['receiver'] = $receiver;
                    $insertArray['ant_course_id'] = $course_id;
                }
                $this->base->insert('announcements', $insertArray);
                $this->session->set_flashdata('success','ok');
                redirect('send-announcement');
            } else {
                $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                redirect('send-announcement');
            }
        }else
            redirect('tickets/error-403', 'refresh');
    }

    public function manage_announcement(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['announcements'] = $this->base->get_data('announcements','*',['academy_id' => $academy_id, 'ant_course_id' => null], null, null, null, 'announcement_id');
            $contentData['announcement_courses'] = $this->get_join->get_data('announcements','courses', 'announcements.ant_course_id=courses.course_id', 'lessons', 'courses.lesson_id=lessons.lesson_id',['announcements.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'announcements.ant_course_id !=' => null], 'announcement_id');
            $contentData['yield'] = 'manage-announcements';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('مدیریت اطلاعیه ها','content',$contentData, $headerData, $footerData);
        } else
            redirect('tickets/error-403', 'refresh');
    }

    public function edit_announcement(){
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {

            $academy_id = $this->session->userdata('academy_id');
            $ant_id = $this->input->post('ant_id',true);
            $category = $this->input->post('category',true);

                if($category == 'date'){
                    $start_time = strtr($this->input->post('start_time', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
                    $stop_time = strtr($this->input->post('stop_time', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
                    $this->base->update('announcements', ['academy_id' => $academy_id, 'announcement_id' => $ant_id], ['start_time'=> $start_time, 'stop_time' => $stop_time]);
                    $this->session->set_flashdata('success', 'تغییرات با موفقیت انجام شد');
                }elseif($category == 'text'){
                    $resultOfUploadFile = $this->my_upload($_FILES);
                    if ($resultOfUploadFile['result_ticket_name'] === '110') {
                        $ant_course_id = $this->input->post('ant_course_id',true);
                        $title = $this->input->post('title',true);
                        $body = $this->input->post('body',true);
                        if(!empty($ant_course_id)){
                            $update_array=[
                                'title' => $title,
                                'body' => $body,
                                'ant_course_id'=> $ant_course_id,
                                'file_name' => $resultOfUploadFile['final_ticket_name']
                            ];
                        }else{
                            $update_array = [
                                'title' => $title,
                                'body' => $body,
                                'file_name' => $resultOfUploadFile['final_ticket_name']
                            ];
                        }
                        $this->base->update('announcements', ['academy_id' => $academy_id, 'announcement_id' => $ant_id], $update_array);
                        $this->session->set_flashdata('success', 'تغییرات با موفقیت انجام شد');
                    } else {
                        $this->session->set_flashdata('error-upload', 'بارگزاری فایل با مشکل مواجه شد لطفا مجددا تلاش نمایید');
                        redirect('send-announcement');
                    }
                }elseif($category == 'delete'){
                    $this->base->delete_data('announcements',['academy_id'=>$academy_id, 'announcement_id' => $ant_id]);
                    $this->session->set_flashdata('success', 'اطلاعیه مورد نظر شما حذف شد');
                }
            redirect('manage-announcement');
        }else
            redirect('tickets/error-403', 'refresh');
    }

    private function send_sms($phone_num, $sms_body,  $user) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'managers') {
            $academy = $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name');

            $username = "mehritc";
            $password = '@utabpars1219';
            $from = "+983000505";
            $pattern_code = "8e5v8h3634";
            $to = array($phone_num);
            $input_data = array(
                "user" => "$user",
                "courseName" => "$sms_body",
                "academy" => "$academy"
            );
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $verify_code = curl_exec($handler);
        } else
            redirect('tickets/error-403', 'refresh');
    }

    private function my_upload() {
        if(isset($_FILES['ticket_file']['name']) && !empty($_FILES['ticket_file']['name'])){
            $this->load->library('upload');
            $academy_id = $this->session->userdata('academy_id');
            $config_array = array(
                'upload_path' => './assets/ticket-file',
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
}
