<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Skyroom extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $url = 'https://www.skyroom.online/skyroom/api/apikey-5152223-1-e411b3d4dc2f05ff61db508510e9f5a5';
        require_once 'HttpRequest.php';
        $this->http = new Skyroom\HttpRequest($url);
    }
    public function call($action, $params = array()) {
        $data = array(
            'action' => $action,
            'params' => $params,
        );
        try {
            return $this->http->post(json_encode($data));
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }

    public function create_room ($room_name, $room_title, $max_users)
    {
        $action = 'createRoom';
        $params = array(
            'name' => strval($room_name),
            'title' => strval($room_title),
            'guest_login' => TRUE,
            'op_login_first' => TRUE,
            'max_users' => $max_users,
        );

        return $this->call($action, $params);
    }

    public function create_users ($username, $nickname)
    {
        $action = 'createUser';
        $params = array(
            'username' => strval($username),
            'password' => '123456',
            'nickname' => $nickname,
            'status' => 1,
            'is_public' => TRUE,
        );

        return $this->call($action, $params);

    }

    public function add_user_to_rooms ($user_id, $rooms_id)
    {
        $action = 'addUserRoom';

        $rooms = array();
        foreach ($rooms_id as $room_id) {
            $rooms[] = array('room_id' => $room_id);
        }

        $params = array(
            'user_id' => $user_id,
            'rooms' => $rooms,
        );

        return $this->call($action, $params);

    }

    public function get_login_url ($room_id, $user_id)
    {
        $action = 'getLoginUrl';

        $params = array(
            'room_id' => intval($room_id),
            'user_id' => intval($user_id),
            'language' => 'fa',
            'ttl' => 9999999
        );

        return $this->call($action, $params);
    }

    public function delete_room ($room_id)
    {
        $action = 'deleteRoom';
        $params['room_id'] = $room_id;

        return $this->call($action, $params);
    }

    public function get_room_users ($room_id)
    {
        $action = 'getRoomUsers';
        $params['room_id'] = $room_id;

        return $this->call($action, $params);
    }

    public function add_room_users ($room_id, $users)
    {
        $action = 'addRoomUsers';
        $all_users = array();
        foreach ($users as $user) {
            $all_users[] = array('user_id' => $user);
        }

        $params = array(
            'room_id' => $room_id,
            'users' => $all_users,
        );

        return $this->call($action, $params);
    }

    public function add_room_users_ta ($room_id, $users)
    {
        $action = 'addRoomUsers';
        $all_users = array();
        foreach ($users as $user) {
            $all_users[] = array('user_id' => $user, 'access' => 3);
        }

        $params = array(
            'room_id' => $room_id,
            'users' => $all_users,
        );

        return $this->call($action, $params);
    }

    public function remove_room_users ($room_id, $users)
    {
        $action = 'removeRoomUsers';
        $params = array(
            'room_id' => $room_id,
            'users' => $users,
        );

        return $this->call($action, $params);
    }

    public function update_room_user ($room_id, $user_id, $access)
    {
        $action = 'updateRoomUser';
        $params = array(
            'room_id' => $room_id,
            'user_id' => $user_id,
            'access' => $access,
        );

        return $this->call($action, $params);
    }

    public function get_users()
    {
        $action = 'getUsers';

        return $this->call($action);
    }

    public function get_user ($username)
    {
        $action = 'getUser';
        $params['username'] = $username;

        return $this->call($action, $params);
    }

    public function delete_user ($user_id)
    {
        $action = 'deleteUser';
        $params['user_id'] = $user_id;

        return $this->call($action, $params);
    }

    public function get_user_rooms ($user_id)
    {
        $action = 'getUserRooms';
        $params['user_id'] = $user_id;

        return $this->call($action, $params);
    }

    public function get_room_by_name ($room_name)
    {
        $action = 'getRoom';
        $params = array('name' => $room_name);

        return $this->call($action, $params);
    }

    public function get_room_by_id ($room_id)
    {
        $action = 'getRoom';
        $params = array('room_id' => $room_id);

        return $this->call($action, $params);
    }

    public function get_rooms ()
    {
        $action = 'getRooms';
        return $this->call($action);
    }

    public function count_rooms ()
    {
        $action = 'countRooms';
        return $this->call($action);
    }

    public function add_student ($academy_id, $course_id)
    {

        $national_code = $this->session->userdata('national_code');
        $sky = $this->base->get_data('courses', 'skyroom_id', array('course_id' => $course_id));
        $std = $this->base->get_data('students', '*', array('national_code' => $national_code));
        $username = $std[0]->national_code;
        $nickname = $std[0]->first_name . '_' . $std[0]->last_name;
        $response = $this->create_users($username, $nickname);

        if( isset( $response['result'] ) ) {

            $this->base->update('students', array('national_code' => $national_code), array('skyroom_id' => $response['result']));
            $stds = array($response['result']);
            $this->add_room_users($sky[0]->skyroom_id, $stds);
            $response = $this->get_login_url($sky[0]->skyroom_id, $stds[0]);
            if( isset( $response['result'] ) ) {
                $this->base->update('courses_students', array('course_id' => $course_id, 'student_nc' => $national_code), array('skyroom_url' => $response['result']));
            }
        }

        redirect('course-detail/' . $academy_id . '/' . $course_id);
    }

    public function add_std_manager (){
        $course_id = $this->session->userdata('course_id');
        $national_code = $this->session->userdata('national_code');

        $sky = $this->base->get_data('courses', 'skyroom_id', array('course_id' => $course_id));
        $std = $this->base->get_data('students', '*', array('national_code' => $national_code));
        $username = $std[0]->national_code;
        $nickname = $std[0]->first_name . '_' . $std[0]->last_name;
        $response = $this->create_users($username, $nickname);


        if( isset( $response['result'] ) ) {

            $this->base->update('students', array('national_code' => $national_code), array('skyroom_id' => $response['result']));
            $stds = array($response['result']);
            $this->add_room_users($sky[0]->skyroom_id, $stds);
            $response = $this->get_login_url($sky[0]->skyroom_id, $stds[0]);
            if( isset( $response['result'] ) ) {
                $this->base->update('courses_students', array('course_id' => $course_id, 'student_nc' => $national_code), array('skyroom_url' => $response['result']));
            }
        } else {
            $student = $this->base->get_data('students', '*', array('national_code' => $national_code));
            $stds = array($student[0]->skyroom_id);
            $this->add_room_users($sky[0]->skyroom_id, $stds);
            $response = $this->get_login_url($sky[0]->skyroom_id, $stds[0]);
            if( isset( $response['result'] ) ) {
                $this->base->update('courses_students', array('course_id' => $course_id, 'student_nc' => $national_code), array('skyroom_url' => $response['result']));
            }
        }

        redirect('portal/training/manage-courses', 'refresh');
    }

    public function add_room_teacher () {
        $courses = $this->base->get_data('courses', 'course_id');
        $course_id = 0;
        for ($i = 0 ; $i < count($courses) ; $i++) {
            if ($course_id == 0){
                $course_id = $courses[$i]->course_id;
            } elseif($course_id < $courses[$i]->course_id) {
                $course_id = $courses[$i]->course_id;
            }
        }

        $course = $this->base->get_data('courses', '*', array('course_id' => $course_id));
        $lesson = $this->base->get_data('lessons', 'lesson_name', array('lesson_id' => $course[0]->lesson_id));
        $response = $this->create_room($course_id, $lesson[0]->lesson_name, intval($course[0]->capacity));
        if (isset($response['result'])){
            $room_id = $response['result'];
            $this->base->update('courses', array('course_id' => $course_id), array('skyroom_id' => $response['result']));
            $teachers = $this->base->get_data('employers', '*', array('national_code' => $course[0]->course_master));
            $response = $this->create_users($teachers[0]->national_code, $teachers[0]->first_name.'_'.$teachers[0]->last_name);
            if (isset($response['result'])){
                $this->base->update('employers', array('national_code' => $course[0]->course_master), array('skyroom_id' => $response['result']));
            }
            $teacher = $this->base->get_data('employers', '*', array('national_code' => $course[0]->course_master));
            $users = array($teacher[0]->skyroom_id);
            $this->add_room_users_ta($room_id, $users);
            $response = $this->get_login_url($room_id, $teacher[0]->skyroom_id);
            if (isset($response['result'])){
                $this->base->update('courses_employers', array('employee_nc' => $course[0]->course_master, 'course_id' => $course_id), array('skyroom_url' => $response['result']));
            }

        }

        $this->session->set_flashdata('success-insert', 'ثبت دوره جدید با موفقیت انجام شد.');
        redirect('portal/training/manage-courses', 'refresh');
    }

    public function test() {
        $courses_employers = $this->base->get_data('courses_employers' ,'*');
        for ($i = 0 ; $i < count($courses_employers) ; $i++){
            if ($courses_employers[$i]->skyroom_url == NULL){
                $user_id = $this->base->get_data('employers', 'skyroom_id', array('national_code' => $courses_employers[$i]->employee_nc));
                $room_id = $this->base->get_data('courses', 'skyroom_id', array('course_id' => $courses_employers[$i]->course_id));
                if ($room_id[0]->skyroom_id != '0' and $user_id[0]->skyroom_id != '0'){
                    $users = array($user_id[0]->skyroom_id);
                    $this->add_room_users_ta($room_id[0]->skyroom_id, $users);
                    $response = $this->get_login_url($room_id[0]->skyroom_id, $user_id[0]->skyroom_id);
                    var_dump($response);
                    echo '<br><br>';
                    if (isset($response['result'])){
                        $this->base->update('courses_employers', array('course_id' => $courses_employers[$i]->course_id, 'employee_nc' => $courses_employers[$i]->employee_nc), array('skyroom_url' => $response['result']));
                    }
                }

            }

        }
    }

    public function addAll ()
    {
        
    }


}
