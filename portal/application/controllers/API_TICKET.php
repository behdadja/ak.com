<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;

class API_TICKET extends CI_Controller
{

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('user_agent');
        //  $this->load->helper('Api_Helper');
    }

    // =======================================================================================\\
    //    ---------------------------    student to manager   ---------------------------     \\
    // =======================================================================================\\

    public function std_listManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $managers_info = $this->base->get_data('academys_option', 'm_first_name,m_last_name,manage_pic', array('academy_id' => $academy_id));
        if(!empty($managers_info)){
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            $manager['mng_name'] = $managers_info[0]->m_first_name . ' ' . $managers_info[0]->m_last_name;
            $manager['mng_pic'] = base_url('assets/profile-picture/thumb/'.$managers_info[0]->manage_pic);
            $data['manager'][] = $manager;
            $result['data'] = $data;
        }else{
            $result['response'] = (string)1;
            $result['mesg'] = "مدیر ثبت نشده است";
        }
        echo json_encode($result);
    }

    public function std_sendToManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['student_nc'];
        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $manager_nc = $manager_info[0]->national_code;

        $resultOfUploadFile = $this->my_upload($_FILES);
        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            require_once 'jdf.php';
            $created_at = jdate('Y/n/j - H:i:s');
            $insertArray = array(
                'academy_id' => $academy_id,
                'ticket_title' => $ticket_title,
                'ticket_body' => $ticket_body,
                'display_type' => '1',
                'sender_nc' => $sessId,
                'sender_type' => 'std',
                'receiver_nc' => $manager_nc,
                'receiver_type' => 'mng',
                'file_name' => $resultOfUploadFile['final_ticket_name'],
                'created_at' => $created_at,
                'last_update' => $created_at,
            );
            $last_insert = $this->base->insert('manager_tickets', $insertArray);
            if(!empty($last_insert)) {
                $result['response'] = (string)1;
                $result['mesg'] = "successful";
            }else{
                $result['response'] = (string)1;
                $result['mesg'] = "fail";
            }
        }else{
            $result['response'] = (string)1;
            $result['mesg'] = "not_upload";
        }
        echo json_encode($result);
    }

    public function std_managerTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['student_nc'];
        $manager_info = $this->base->get_data('academys_option', 'm_first_name,m_last_name,student_display_name', ['academy_id' => $academy_id]);
        $manage_name = $manager_info[0]->m_first_name.' '.$manager_info[0]->m_last_name;

        $type_1 = 'std';
        $type_2 = 'mng';
        $display_type = '1';
        $manager_tickets = $this->base->find_ticket('manager_tickets','*', $academy_id, $display_type, $sessId, $type_1, $type_2);
        if (!empty($manager_tickets)) {
            foreach ($manager_tickets as $mt) {
                $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));
            }
        }
        if(!empty($answer_info)) {
            // Convert two-dimensional array to one-dimensional
            $answer_tickets = call_user_func_array('array_merge', $answer_info);
            // end
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == '0') {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'mng') {
                    $ticket['sender'] = $manage_name . ' (مدیر)';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'mng') {
                    $ticket['receiver'] = $manage_name . ' (مدیر)';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '1') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->student_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '3') {
                    $ticket['status'] = 'پاسخ مدیر';
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;
            }
        }else{
            $data['ticket'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function std_infoManagerTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', '*', ['academy_id' => $academy_id]);
        $sessId = $user_var['student_nc'];
        $info_std = $this->base->get_data('students','*', ['national_code' => $sessId, 'academy_id' => $academy_id]);
        $id = $user_var['ticket_id'];

        $manager_tickets  = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));
        $answer_tickets  = $this->base->get_data('answer_manager_tickets', '*', ['academy_id' => $academy_id, 'answer_id' => $id], null, null, null, 'answer_ticket_id');

        if($manager_tickets[0]->receiver_type == 'std') {
            $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
        }
        if(!empty($answer_tickets)) {
            foreach ($answer_tickets as $item) {
                if ($item->receiver_type == 'std') {
                    $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'std'], ['ticket_status' => '1']);
                }
            }
        }

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        if($manager_tickets[0]->sender_type == 'std'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $info_std[0]->pic_name);
        else:
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
        endif;
        if($manager_tickets[0]->sender_type == 'std'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = 'مدیر '.$manager_info[0]->academy_display_name . ' ' . $manager_info[0]->academy_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)){
            $ticket_main['file_name'] = base_url('./assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($answer_tickets)):
            foreach ($answer_tickets as $answer):
                if ($answer->sender_type === 'std'):
                    $ticket_answers['picture'] = base_url('./assets/profile-picture/thumb/' . $info_std[0]->pic_name);
                    $ticket_answers['sender'] =  'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('./assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'mng'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
                    $ticket_answers['sender'] = 'مدیر';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('./assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
            $result['mesg'] = "successful";
        else:
            $data['ticket_answers'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی برای این تیکت ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function std_answerToManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['student_nc'];
        $manager_info = $this->base->get_data('academys_option', '*', ['academy_id' => $academy_id]);
        $manager_nc = $manager_info[0]->national_code;

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
                'sender_type' => 'std',
                'receiver_nc' => $manager_nc,
                'receiver_type' => 'mng',
                'file_name' => $resultOfUploadFile['final_ticket_name'],
                'created_at' => $created_at
            );

            $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
            if($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'std') {
                $updateArray['last_update'] = $created_at;
                $updateArray['readed_status'] = '0';
                $updateArray['answer_status'] = '0';
            }elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'std'){
                $updateArray['last_update'] = $created_at;
                $updateArray['answer_status'] = '1';
            }elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '1' || $manager_ticket[0]->answer_status == '3')){
                $updateArray['last_update'] = $created_at;
                $updateArray['answer_status'] = '1';
            }

            $this->base->insert('answer_manager_tickets', $insertArray);
            $this->base->update('manager_tickets', ['ticket_id' => $ticket_id, 'academy_id' => $academy_id], $updateArray);

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
        }else{
            $result['response'] = (string)1;
            $result['mesg'] = "not_upload";
        }
        echo json_encode($result);
    }

    // =======================================================================================\\
    //    ---------------------------    student to teacher   ---------------------------     \\
    // =======================================================================================\\

    public function std_listTeachers(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['student_nc'];

        $iStudent = $this->get_join->get_data('courses_students', 'courses', 'courses.course_id=courses_students.course_id', null, null, array('courses_students.student_nc' => $sessId, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id));
        foreach ($iStudent as $iStd) {
            $sCourses[] = $this->base->get_data('employers', 'employee_id, national_code, first_name, last_name, pic_name', array('national_code' => $iStd->course_master, 'academy_id' => $academy_id))[0];
        }
        $sCourses = array_map('json_encode', $sCourses);
        $sCourses = array_unique($sCourses);
        $sCourses = array_map('json_decode', $sCourses);

        $result['response'] = (string)1;
        if (!empty($sCourses)){
            $result['mesg'] = "successful";
            foreach ($sCourses as $sCourse):
                $teacher['std_id'] = $sCourse->employee_id;
                $teacher['picture'] = base_url('assets/profile-picture/thumb/' . $sCourse->pic_name);
                $teacher['std_name'] = $sCourse->first_name . ' ' . $sCourse->last_name;
                $teacher['national_code'] = $sCourse->national_code;
                $data['teacher'][] = $teacher;
            endforeach;
            $result['data'] = $data;
        }else {
            $result['mesg'] = "استادی ثبت نشده است";
            $result['data'] = null;
        }
        echo json_encode($result);
    }

    public function std_sendToTeacher()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['student_nc'];
        $employee_nc = $user_var['teacher_nc'];

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
                require_once 'jdf.php';
                $created_at = jdate('Y/n/j - H:i:s');
                $insertArray = array(
                    'academy_id' => $academy_id,
                    'ticket_title' => $ticket_title,
                    'ticket_body' => $ticket_body,
                    'display_type' => '2',
                    'sender_nc' => $sessId,
                    'sender_type' => 'std',
                    'receiver_nc' => $employee_nc,
                    'receiver_type' => 'emp',
//                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                    'last_update' => $created_at,
                );
                $last_insert = $this->base->insert('manager_tickets', $insertArray);
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    public function std_teacherTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['student_nc'];
        $manager_info = $this->base->get_data('academys_option', 'teacher_display_name', ['academy_id' => $academy_id]);

        $type_1 = 'std';
        $type_2 = 'emp';
        $display_type = '2';
        $manager_tickets = $this->base->find_ticket('manager_tickets','*', $academy_id, $display_type, $sessId, $type_1, $type_2);
        if (!empty($manager_tickets)) {
            foreach ($manager_tickets as $mt) {
                $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));

                if ($mt->sender_type == 'emp' && $mt->receiver_type == 'std') {
                    $employee_info[] = $this->base->get_data('employers', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->sender_nc))[0];
                }
                if ($mt->sender_type == 'std' && $mt->receiver_type == 'emp') {
                    $employee_info[] = $this->base->get_data('employers', 'first_name,last_name,national_code', array('academy_id' => $academy_id, 'national_code' => $mt->receiver_nc))[0];
                }
            }
            $employee_info = array_map('json_encode', $employee_info);
            $employee_info = array_unique($employee_info);
            $employee_info = array_map('json_decode', $employee_info);
        }
        if(!empty($answer_info)) {
            // Convert two-dimensional array to one-dimensional
            $answer_tickets = call_user_func_array('array_merge', $answer_info);
            // end
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == 0) {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'emp') {
                    foreach ($employee_info as $item) {
                        if ($item->national_code == $value->sender_nc) {
                            $employee_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['sender'] = $employee_name . ' (' . $manager_info[0]->teacher_display_name . ')';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'emp') {
                    foreach ($employee_info as $item) {
                        if ($item->national_code == $value->receiver_nc) {
                            $employee_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['receiver'] = $employee_name . ' (' . $manager_info[0]->teacher_display_name . ')';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '1') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->teacher_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '2') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->student_display_name;
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;
            }
            $result['mesg'] = "successful";
        }else{
            $data['ticket'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function std_infoTeacherTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['student_nc'];
        $std_info = $this->base->get_data('students', 'pic_name', ['academy_id' => $academy_id, 'national_code' => $sessId]);
        $manager_info = $this->base->get_data('academys_option', 'teacher_display_name', ['academy_id' => $academy_id]);

        $id = $user_var['ticket_id'];
        $manager_tickets = $this->base->get_data('manager_tickets', '*', ['academy_id' => $academy_id, 'ticket_id' => $id]);

        if($manager_tickets[0]->sender_type == 'emp')
            $employers = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
        elseif($manager_tickets[0]->receiver_type == 'emp')
            $employers = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

        $employee_name = $employers[0]->first_name . ' ' . $employers[0]->last_name;
        $employee_pic = $employers[0]->pic_name;

        $answer_tickets = $this->base->get_data('answer_manager_tickets', '*', ['academy_id' => $academy_id, 'answer_id' => $id], null, null, null, 'answer_ticket_id');

        if($manager_tickets[0]->receiver_type == 'std') {
            $this->base->update('manager_tickets', ['ticket_id' => $id], ['readed_status' => '1']);
        }
        if(!empty($answer_tickets)) {
            foreach ($answer_tickets as $item) {
                if ($item->receiver_type == 'std') {
                    $this->base->update('answer_manager_tickets', ['answer_id' => $id, 'receiver_type' => 'std'], ['ticket_status' => '1']);
                }
            }
        }

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        if($manager_tickets[0]->sender_type == 'std'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $std_info[0]->pic_name);
        else:
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $employee_pic);
        endif;
        if($manager_tickets[0]->sender_type == 'std'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = $manager_info[0]->teacher_display_name . ' ' . $employee_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)){
            $ticket_main['file_name'] = base_url('assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($answer_tickets)):
            foreach ($answer_tickets as $answer):
                if ($answer->sender_type === 'emp'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $employee_pic);
                    $ticket_answers['sender'] =  $manager_info[0]->teacher_display_name . ' ' . $employee_name;
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'std'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $std_info[0]->manage_pic);
                    $ticket_answers['sender'] = 'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
            $result['mesg'] = "successful";
        else:
            $data['ticket_answers'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function std_answerToTeacher(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $employee_nc = $user_var['teacher_nc'];
        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            require_once 'jdf.php';
            $created_at = jdate('Y/n/j - H:i:s');
            $insertArray = [
                'academy_id' => $academy_id,
                'answer_id' => $ticket_id,
                'ticket_body' => $ticket_body,
                'display_type' => '2',
                'sender_nc' => $sessId,
                'sender_type' => 'std',
                'receiver_nc' => $employee_nc,
                'receiver_type' => 'emp',
//                'file_name' => $resultOfUploadFile['final_ticket_name'],
                'created_at' => $created_at
            ];

            $manager_ticket = $this->base->get_data('manager_tickets', '*', array('ticket_id' => $ticket_id, 'academy_id' => $academy_id));
            if($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->sender_type == 'std') {
                $updateArray['last_update'] = $created_at;
                $updateArray['readed_status'] = '0';
                $updateArray['answer_status'] = '0';
            }elseif ($manager_ticket[0]->readed_status == '1' && $manager_ticket[0]->answer_status == '0' && $manager_ticket[0]->receiver_type == 'std'){
                $updateArray['last_update'] = $created_at;
                $updateArray['answer_status'] = '1';
            }elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '1' || $manager_ticket[0]->answer_status == '2')){
                $updateArray['last_update'] = $created_at;
                $updateArray['answer_status'] = '1';
            }

            $this->base->insert('answer_manager_tickets', $insertArray);
            $this->base->update('manager_tickets', ['ticket_id' => $ticket_id, 'academy_id' => $academy_id], $updateArray);

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }


    // =======================================================================================\\
    //    ---------------------------    teacher to manager   ---------------------------     \\
    // =======================================================================================\\

    public function emp_listManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $managers_info = $this->base->get_data('academys_option', 'm_first_name,m_last_name,manage_pic', array('academy_id' => $academy_id));
        if(!empty($managers_info)){
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            $manager['mng_name'] = $managers_info[0]->m_first_name . ' ' . $managers_info[0]->m_last_name;
            $manager['mng_pic'] = base_url('assets/profile-picture/thumb/'.$managers_info[0]->manage_pic);
            $data['manager'][] = $manager;
        }else{
            $result['response'] = (string)1;
            $result['mesg'] = "مدیر ثبت نشده است";
        }
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_sendToManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['teacher_nc'];
        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $manager_nc = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
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
//                'file_name' => $resultOfUploadFile['final_ticket_name'],
                'created_at' => $created_at,
                'last_update' => $created_at,
            );
            $last_insert = $this->base->insert('manager_tickets', $insertArray);
            if(!empty($last_insert)) {
                $result['response'] = (string)1;
                $result['mesg'] = "successful";
            }else{
                $result['response'] = (string)1;
                $result['mesg'] = "fail";
            }
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    public function emp_managerTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['teacher_nc'];
        $manager_info = $this->base->get_data('academys_option', 'm_first_name,m_last_name,teacher_display_name', ['academy_id' => $academy_id]);
        $manage_name = $manager_info[0]->m_first_name.' '.$manager_info[0]->m_last_name;

        $type_1 = 'emp';
        $type_2 = 'mng';
        $display_type = '0';
        $manager_tickets = $this->base->find_ticket('manager_tickets','*', $academy_id, $display_type, $sessId, $type_1, $type_2);
        if (!empty($manager_tickets)) {
            foreach ($manager_tickets as $mt) {
                $answer_info[] = $this->base->get_data('answer_manager_tickets', '*', array('answer_id' => $mt->ticket_id));
            }
        }
        if(!empty($answer_info)) {
            // Convert two-dimensional array to one-dimensional
            $answer_tickets = call_user_func_array('array_merge', $answer_info);
            // end
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == '0') {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'mng') {
                    $ticket['sender'] = $manage_name . ' (مدیر)';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'mng') {
                    $ticket['receiver'] = $manage_name . ' (مدیر)';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '2') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->teacher_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '3') {
                    $ticket['status'] = 'پاسخ مدیر';
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;
            }
        }else{
            $data['ticket'][] = null;
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_infoManagerTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', '*', ['academy_id' => $academy_id]);
        $sessId = $user_var['teacher_nc'];
        $info_emp = $this->base->get_data('employers','*', ['national_code' => $sessId, 'academy_id' => $academy_id]);
        $id = $user_var['ticket_id'];

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

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        if($manager_tickets[0]->sender_type == 'emp'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $info_emp[0]->pic_name);
        else:
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
        endif;
        if($manager_tickets[0]->sender_type == 'emp'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = 'مدیر '.$manager_info[0]->academy_display_name . ' ' . $manager_info[0]->academy_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)){
            $ticket_main['file_name'] = base_url('assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($manager_tickets)):
            foreach ($manager_tickets as $answer):
                if ($answer->sender_type === 'emp'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $info_emp[0]->pic_name);
                    $ticket_answers['sender'] =  'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'mng'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
                    $ticket_answers['sender'] = 'مدیر';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
            $result['mesg'] = "successful";
        else:
            $data['ticket_answers'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی برای این تیکت ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_answerToManager(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['teacher_nc'];
        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $manager_nc = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
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
//                'file_name' => $resultOfUploadFile['final_ticket_name'],
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

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    // =======================================================================================\\
    //    ---------------------------    teacher to student   ---------------------------     \\
    // =======================================================================================\\

    public function emp_listStudents(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['teacher_nc'];

        $iCourses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, ['course_master' => $sessId, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id]);
        if(!empty($iCourses)){
            foreach ($iCourses as $value) {
                $iStudent = $this->base->get_data('courses_students', 'student_nc', array('course_id' => $value->course_id, 'academy_id' => $academy_id));
                if(!empty($iStudent)) {
                    foreach ($iStudent as $iStd) {
                        $sCourses[] = $this->base->get_data('students', 'student_id,national_code,first_name,last_name,pic_name', array('national_code' => $iStd->student_nc, 'academy_id' => $academy_id))[0];
                    }
                }
            }
            $sCourses = array_map('json_encode', $sCourses);
            $sCourses = array_unique($sCourses);
            $sCourses = array_map('json_decode', $sCourses);
        }
        $result['response'] = (string)1;
        if(!empty($iCourses) || !empty($iStudent)) {
            $result['mesg'] = "successful";
        }else{
            $result['mesg'] = "دانشجویی ثبت نشده است";
        }
        if(!empty($sCourses)) {
            foreach ($sCourses as $std) {
                $student['std_id'] = $std->student_id;
                $student['picture'] = base_url('assets/profile-picture/thumb/' . $std->pic_name);
                $student['std_name'] = $std->first_name . ' ' . $std->last_name;
                $student['national_code'] = $std->national_code;
                $data['students'][] = $student;
            }
        }else
            $data['students'][] = [];

        if(!empty($iCourses)) {
            foreach ($iCourses as $crs) {
                $course['crs_id'] = $crs->course_id;
                $course['crs_picture'] = base_url('assets/profile-picture/thumb/'.$crs->course_pic);
                $course['crs_name'] = $crs->lesson_name;
                $course['master_nc'] = $crs->course_master;
                $data['courses'][] = $course;
            }
        }else
            $data['courses'][] = [];

        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_sendToStudent()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['teacher_nc'];
        $category = $user_var['category'];
        if($category == '1')
            $student_nc = $user_var['student_nc'];
        elseif($category == '2')
            $course_id = $user_var['course_id'];

//        $resultOfUploadFile = $this->upload_file($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            if ($category == '1') {
                require_once 'jdf.php';
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
//                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                    'last_update' => $created_at,
                );
                $last_insert = $this->base->insert('manager_tickets', $insertArray);
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            } elseif ($category == '2') {
                $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
                if (!empty($course_students)) {
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
//                            'file_name' => $resultOfUploadFile['final_ticket_name'],
                            'created_at' => $created_at,
                            'last_update' => $created_at,
                        ];
                        $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    }
                }
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            }else{
                $result['response'] = (string)1;
                $result['mesg'] = "ورودی غیر مجاز";
            }
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    public function emp_studentTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['teacher_nc'];
        $manager_info = $this->base->get_data('academys_option', 'teacher_display_name,student_display_name', ['academy_id' => $academy_id]);

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
        }
        if(!empty($answer_info)) {
            // Convert two-dimensional array to one-dimensional
            $answer_tickets = call_user_func_array('array_merge', $answer_info);
            // end
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == '0') {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'std') {
                    foreach ($student_info as $item) {
                        if ($item->national_code == $value->sender_nc) {
                            $student_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['sender'] = $student_name . ' (' . $manager_info[0]->student_display_name . ')';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'std') {
                    foreach ($student_info as $item) {
                        if ($item->national_code == $value->receiver_nc) {
                            $student_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['receiver'] = $student_name . ' (' . $manager_info[0]->student_display_name . ')';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '1') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->student_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '2') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->teacher_display_name;
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;
            }
        }else{
            $data['ticket'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_infoStudentTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $sessId = $user_var['teacher_nc'];
        $emp_info = $this->base->get_data('employers', 'pic_name', ['academy_id' => $academy_id, 'national_code' => $sessId]);
        $manager_info = $this->base->get_data('academys_option', 'student_display_name', ['academy_id' => $academy_id]);
        $id = $user_var['ticket_id'];
        $manager_tickets = $this->base->get_data('manager_tickets', '*', ['academy_id' => $academy_id, 'ticket_id' => $id]);

        if($manager_tickets[0]->sender_type == 'std')
            $students = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
        elseif($manager_tickets[0]->receiver_type == 'std')
            $students = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

        $student_name = $students[0]->first_name . ' ' . $students[0]->last_name;
        $student_pic = $students[0]->pic_name;
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

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        if($manager_tickets[0]->sender_type == 'emp'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $emp_info[0]->pic_name);
        else:
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $student_pic);
        endif;
        if($manager_tickets[0]->sender_type == 'emp'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = $manager_info[0]->student_display_name . ' ' . $student_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)) {
            $ticket_main['file_name'] = base_url('assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($answer_tickets)):
            foreach ($answer_tickets as $answer):
                if ($answer->sender_type === 'std'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $student_pic);
                    $ticket_answers['sender'] =  $manager_info[0]->student_display_name . ' ' . $student_name;
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)) {
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'emp'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $emp_info[0]->pic_name);
                    $ticket_answers['sender'] = 'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
            $result['mesg'] = "successful";
        else:
            $data['ticket_answers'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function emp_answerToStudent(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $sessId = $user_var['teacher_nc'];
        $manager_ticket = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $ticket_id));
        if($manager_ticket[0]->sender_type == 'std')
            $student_nc = $manager_ticket[0]->sender_nc;
        elseif($manager_ticket[0]->receiver_type == 'std')
            $student_nc = $manager_ticket[0]->receiver_nc;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
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
//                'file_name' => $resultOfUploadFile['final_ticket_name'],
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
            }elseif ($manager_ticket[0]->readed_status == '1' && ($manager_ticket[0]->answer_status == '2' || $manager_ticket[0]->answer_status == '1')){
                $updateArray['last_update'] = $created_at;
                $updateArray['answer_status'] = '2';
            }

            $this->base->insert('answer_manager_tickets', $insertArray);
            $this->base->update('manager_tickets', ['ticket_id' => $ticket_id, 'academy_id' => $academy_id], $updateArray);

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }



    // =======================================================================================\\
    //    ---------------------------    manager to student   ---------------------------     \\
    // =======================================================================================\\

    public function mng_listStudents(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $students = $this->base->get_data('students', '*', array('academy_id' => $academy_id));
        $courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'employers', 'employers.national_code=courses.course_master', ['courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id]);
        $result['response'] = (string)1;
        if(!empty($students) || !empty($courses))
            $result['mesg'] = "successful";
        else
            $result['mesg'] = "دانشجویی ثبت نشده است";

        if(!empty($students)) {
            foreach ($students as $std) {
                $student['std_id'] = $std->student_id;
                $teacher['picture'] = base_url('./assets/profile-picture/thumb/' . $std->pic_name);
                $student['std_name'] = $std->first_name . ' ' . $std->last_name;
                $student['national_code'] = $std->national_code;
                $data['student'][] = $student;
            }
        }
        if(!empty($courses)) {
            foreach ($courses as $crs) {
                $course['crs_id'] = $crs->course_id;
                $course['crs_picture'] = base_url('assets/profile-picture/thumb/'.$crs->course_pic);
                $course['crs_name'] = $crs->lesson_name;
                $course['master_name'] = $crs->first_name . ' ' . $crs->last_name;
                $course['master_nc'] = $crs->course_master;
                $data['course'][] = $course;
            }
        }
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function mng_sendToStudent()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $category = $user_var['category'];
        if($category == '1')
            $student_nc = $user_var['student_nc'];
        if($category == '2')
            $course_id = $user_var['course_id'];
        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->upload_file($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            if ($category == '1') {
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
//                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                    'last_update' => $created_at,
                ];
                $last_insert = $this->base->insert('manager_tickets', $insertArray);
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            } elseif ($category == '2') {
                $course_students = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
                if (!empty($course_students)) {
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
//                            'file_name' => $resultOfUploadFile['final_ticket_name'],
                            'created_at' => $created_at,
                            'last_update' => $created_at,
                        ];
                        $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    }
                }
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            } elseif($category == '3') {
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
//                            'file_name' => $resultOfUploadFile['final_ticket_name'],
                            'created_at' => $created_at,
                            'last_update' => $created_at,
                        ];
                        $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    }
                }
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            }else{
                $result['response'] = (string)1;
                $result['mesg'] = "ورودی غیر مجاز";
            }
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    public function mng_studentTickets(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', 'national_code,student_display_name', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

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
            if (!empty($answer_info)) {
                // Convert two-dimensional array to one-dimensional
                $answer_tickets = call_user_func_array('array_merge', $answer_info);
                // end
            }
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == '0') {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'std') {
                    foreach ($student_info as $item) {
                        if ($item->national_code == $value->sender_nc) {
                            $student_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['sender'] = $student_name . ' (' . $manager_info[0]->student_display_name . ')';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'std') {
                    foreach ($student_info as $item) {
                        if ($item->national_code == $value->receiver_nc) {
                            $student_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['receiver'] = $student_name . ' (' . $manager_info[0]->student_display_name . ')';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '1') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->student_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '3') {
                    $ticket['status'] = 'پاسخ مدیر';
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;
            }
        }else{
            $data['ticket'][] = null;
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function mng_infoStudentTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', 'student_display_name,manage_pic', ['academy_id' => $academy_id]);
        $id = $user_var['ticket_id'];
        $manager_tickets = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));

        if($manager_tickets[0]->sender_type == 'std')
            $info_std = $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
        elseif($manager_tickets[0]->receiver_type == 'std')
            $info_std= $this->base->get_data('students', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

        $answer_tickets = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $id), null, null, null, 'answer_ticket_id');

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

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        $result['mesg'] = "successful";
        if($manager_tickets[0]->sender_type == 'mng'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
        else:
            $ticket_main['picture'] = base_url('./assets/profile-picture/thumb/' . $info_std[0]->pic_name);
        endif;
        if($manager_tickets[0]->sender_type == 'mng'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = $manager_info[0]->student_display_name . ' ' . $info_std[0]->first_name . ' ' . $info_std[0]->last_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)){
            $ticket_main['file_name'] = base_url('./assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($answer_tickets)):
            foreach ($answer_tickets as $answer):
                if ($answer->sender_type === 'std'):
                    $ticket_answers['picture'] = base_url('./assets/profile-picture/thumb/' . $info_std[0]->pic_name);
                    $ticket_answers['sender'] =  $manager_info[0]->student_display_name . ' ' . $info_std[0]->first_name . ' ' . $info_std[0]->last_name;
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('./assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'mng'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
                    $ticket_answers['sender'] = 'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('./assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
        else:
            $data['ticket_answers'][] = null;
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function mng_answerToStudent(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $student_nc = $user_var['student_nc'];
        $manager_info = $this->base->get_data('academys_option', 'student_display_name,manage_pic,national_code', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

        $resultOfUploadFile = $this->my_upload($_FILES);
        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            require_once 'jdf.php';
            $created_at = jdate('Y/n/j - H:i:s');
            $insertArray = [
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
            ];

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

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
        }else{
            $result['response'] = (string)1;
            $result['mesg'] = "not_upload";
        }
        echo json_encode($result);
    }


    // =======================================================================================\\
    //    ---------------------------    manager to teacher   ---------------------------     \\
    // =======================================================================================\\

    public function mng_listTeachers(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $teachers = $this->base->get_data('employers', '*', array('academy_id' => $academy_id));
        $result['response'] = (string)1;
        if(!empty($teachers)) {
            $result['mesg'] = "successful";
            foreach ($teachers as $tch) {
                $teacher['tch_id'] = $tch->employee_id;
                $teacher['picture'] = base_url('./assets/profile-picture/thumb/' . $tch->pic_name);
                $teacher['tch_name'] = $tch->first_name . ' ' . $tch->last_name;
                $teacher['national_code'] = $tch->national_code;
                $data['teacher'][] = $teacher;
            }
            $result['data'] = $data;
        }else{
            $result['mesg'] = "استادی ثبت نشده است";
            $result['data'] = null;
        }
        echo json_encode($result);
    }

    public function mng_sendToTeacher()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_title = $user_var['ticket_title'];
        $ticket_body = $user_var['ticket_body'];
        $category = $user_var['category'];
        if($category == '1')
            $employee_nc = $user_var['teacher_nc'];

        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
            if ($category == '1'){
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
//                    'file_name' => $resultOfUploadFile['final_ticket_name'],
                    'created_at' => $created_at,
                    'last_update' => $created_at,
                );
                $last_insert = $this->base->insert('manager_tickets', $insertArray);
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            }elseif ($category == '2'){
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
//                            'file_name' => $resultOfUploadFile['final_ticket_name'],
                            'created_at' => $created_at,
                            'last_update' => $created_at,
                        ];
                        $last_insert = $this->base->insert('manager_tickets', $insertArray);
                    }
                }
                if(!empty($last_insert)) {
                    $result['response'] = (string)1;
                    $result['mesg'] = "successful";
                }else{
                    $result['response'] = (string)1;
                    $result['mesg'] = "fail";
                }
            }else{
                $result['response'] = (string)1;
                $result['mesg'] = "ورودی غیر مجاز";
            }
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    public function mng_teacherTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', 'national_code,teacher_display_name', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

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
        }
        if (!empty($answer_info)) {
            // Convert two-dimensional array to one-dimensional
            $answer_tickets = call_user_func_array('array_merge', $answer_info);
            // end
        }
        // view
        if (!empty($manager_tickets)) {
            $result['response'] = (string)1;
            $result['mesg'] = "successful";
            foreach ($manager_tickets as $value) {
                $count = 0;
                if (!empty($answer_tickets)) {
                    foreach ($answer_tickets as $answer) {
                        if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == 0) {
                            $count++;
                        }
                    }
                }
                $ticket['ticket_id'] = $value->ticket_id;
                $ticket['ticket_title'] = $value->ticket_title;
                if ($value->sender_type === 'emp') {
                    foreach ($employee_info as $item) {
                        if ($item->national_code == $value->sender_nc) {
                            $employee_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['sender'] = $employee_name . ' (' . $manager_info[0]->teacher_display_name . ')';
                } else {
                    $ticket['sender'] = 'شما';
                }
                if ($value->receiver_type === 'emp') {
                    foreach ($employee_info as $item) {
                        if ($item->national_code == $value->receiver_nc) {
                            $employee_name = $item->first_name . ' ' . $item->last_name;
                        }
                    }
                    $ticket['receiver'] = $employee_name . ' (' . $manager_info[0]->teacher_display_name . ')';
                } else {
                    $ticket['receiver'] = 'شما';
                }
                if ($value->readed_status === '0' && $value->answer_status === '0') {
                    $ticket['status'] = 'خوانده نشده';
                } elseif ($value->readed_status === '1' && $value->answer_status === '0') {
                    $ticket['status'] = 'در انتظار پاسخ';
                } elseif ($value->readed_status === '1' && $value->answer_status === '2') {
                    $ticket['status'] = 'پاسخ ' . $manager_info[0]->teacher_display_name;
                } elseif ($value->readed_status === '1' && $value->answer_status === '3') {
                    $ticket['status'] = 'پاسخ مدیر';
                }
                if($count > 0)
                    $ticket['count'] = (string)$count;
                else
                    unset($ticket['count']);
                $ticket['created_at'] = $value->created_at;
                $ticket['last_update'] = $value->last_update;
                $data['ticket'][] = $ticket;

            }
        }else{
            $data['ticket'][] = null;
            $result['response'] = (string)1;
            $result['mesg'] = "تیکتی موجود نیست";
        }
        // end view
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function mng_infoTeacherTickets()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $manager_info = $this->base->get_data('academys_option', 'student_display_name,manage_pic', ['academy_id' => $academy_id]);
        $id = $user_var['ticket_id'];
        $manager_tickets = $this->base->get_data('manager_tickets', '*', array('academy_id' => $academy_id, 'ticket_id' => $id));

        if($manager_tickets[0]->sender_type == 'emp')
            $info_emp = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->sender_nc, 'academy_id' => $academy_id]);
        elseif($manager_tickets[0]->receiver_type == 'emp')
            $info_emp = $this->base->get_data('employers', 'first_name,last_name,pic_name,national_code', ['national_code' => $manager_tickets[0]->receiver_nc, 'academy_id' => $academy_id]);

        $answer_tickets = $this->base->get_data('answer_manager_tickets', '*', array('academy_id' => $academy_id, 'answer_id' => $id), null, null, null, 'answer_ticket_id');

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

        // ^^^^^^^^^^^  ticket main  ^^^^^^^^^^^ \\
        $result['response'] = (string)1;
        if($manager_tickets[0]->sender_type == 'mng'):
            $ticket_main['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
        else:
            $ticket_main['picture'] = base_url('./assets/profile-picture/thumb/' . $info_emp[0]->pic_name);
        endif;
        if($manager_tickets[0]->sender_type == 'mng'){
            $ticket_main['sender'] = 'تیکت شما';
        }else{
            $ticket_main['sender'] = $manager_info[0]->teacher_display_name . ' ' . $info_emp[0]->first_name . ' ' . $info_emp[0]->last_name;
        }
        $ticket_main['created_at'] = $manager_tickets[0]->created_at;
        $ticket_main['ticket_title'] = $manager_tickets[0]->ticket_title;
        $ticket_main['ticket_body'] = $manager_tickets[0]->ticket_body;
        if (!empty($manager_tickets[0]->file_name)){
            $ticket_main['file_name'] = base_url('assets/ticket-file/' . $manager_tickets[0]->file_name);
        }else{
            unset($ticket_main['file_name']);
        }
        $data['ticket_main'] = $ticket_main;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\

        // ^^^^^^^^^^^  ticket answers  ^^^^^^^^^^^ \\
        if (!empty($answer_tickets)):
            foreach ($answer_tickets as $answer):
                if ($answer->sender_type === 'emp'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $info_emp[0]->pic_name);
                    $ticket_answers['sender'] =  $manager_info[0]->teacher_display_name . ' ' . $info_emp[0]->first_name . ' ' . $info_emp[0]->last_name;
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                elseif ($answer->sender_type === 'mng'):
                    $ticket_answers['picture'] = base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic);
                    $ticket_answers['sender'] = 'پاسخ شما';
                    $ticket_answers['created_at'] = $answer->created_at;
                    $ticket_answers['ticket_body'] = $answer->ticket_body;
                    if (!empty($answer->file_name)){
                        $ticket_answers['file_name'] = base_url('assets/ticket-file/' . $answer->file_name);
                    }else{
                        unset($ticket_answers['file_name']);
                    }
                endif;
                $data['ticket_answers'][] = $ticket_answers;
            endforeach;
            $result['mesg'] = "successful";
        else:
            $data['ticket_answers'][] = [];
            $result['response'] = (string)1;
            $result['mesg'] = "پاسخی برای این تیکت ثبت نشده است";
        endif;
        // ^^^^^^^^^^^  END  ^^^^^^^^^^^ \\
        $result['data'] = $data;
        echo json_encode($result);
    }

    public function mng_answerToTeacher(){
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $ticket_id = $user_var['ticket_id'];
        $ticket_body = $user_var['ticket_body'];
        $employee_nc = $user_var['teacher_nc'];

        $manager_info = $this->base->get_data('academys_option', 'national_code', ['academy_id' => $academy_id]);
        $sessId = $manager_info[0]->national_code;

//        $resultOfUploadFile = $this->my_upload($_FILES);
//        if ($resultOfUploadFile['result_ticket_name'] === '110') {
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
//                'file_name' => $resultOfUploadFile['final_ticket_name'],
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

            $result['response'] = (string)1;
            $result['mesg'] = "پاسخ ثبت شد";
//        }else{
//            $result['response'] = (string)1;
//            $result['mesg'] = "not_upload";
//        }
        echo json_encode($result);
    }

    // =======================================================================================\\
    //    ---------------------------    upload file   ---------------------------     \\
    // =======================================================================================\\

    private function my_upload() {
        $format = $this->input->post('format');
        $name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        if (isset($name) && !empty($name)) {
            $location = '././assets/ticket-picture/';
            $file_name = time().rand(1000, 9999);
            if (move_uploaded_file($temp_name, $location . $file_name . $format)) {
                $result_ticket_name = '110';
                $final_ticket_name = $file_name . $format;
            } else {
                $result_ticket_name = '404';
                $final_ticket_name = '';
            }

        } else {
            $result_ticket_name = '110';
            $final_ticket_name = '';
        }
        $result = [
            'final_ticket_name' => $final_ticket_name,
            'result_ticket_name' => $result_ticket_name
        ];
        return $result;
    }

}
