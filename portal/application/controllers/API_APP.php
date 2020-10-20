<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;

class API_APP extends CI_Controller {

    private $salt = 'EYJNm3FzGEvg#zVLp7vG';

    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
//        $this->load->helper('Api_Helper');
        $this->load->library('user_agent');
        $this->load->library('zarinpal', array(
            'merchant_id' => '50a9ce9c-9cbd-11e9-b0b8-000c29344814'
		));
    }

    public function index() {
        echo 'API APP';
    }

    ////////////////////////////// Splash \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function splash() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);

        $admin = $this->base->get_data('admin', 'last_app_version,is_force', null);

        $data['last_app_version'] = $admin[0]->last_app_version;
        $data['is_force'] = $admin[0]->is_force;
        $result['data'] = $data;
        $result['response'] = (string) 1;

        if (isset($user_var['national_code']) && isset($user_var['academy_id']) && isset($user_var['app_version']) && !empty($user_var['national_code']) && !empty($user_var['academy_id']) && !empty($user_var['app_version'])) {
            $national_code = $user_var['national_code'];
            $academy_id = $user_var['academy_id'];
            $user_type = $user_var['user_type'];
            if (!empty($user_type) && isset($user_type) && $user_type == 1 && $this->exist->exist_entry('students', array('national_code' => $national_code, 'academy_id' => $academy_id))) {
                $app_version = $user_var['app_version'];
                $this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('app_version' => $app_version));
            } elseif ($user_type == 2 && $this->exist->exist_entry('employers', array('national_code' => $national_code, 'academy_id' => $academy_id))) {
                $app_version = $user_var['app_version'];
                $this->base->update('employers', array('national_code' => $national_code, 'academy_id' => $academy_id), array('app_version' => $app_version));
            }
        }
        echo json_encode($result);
    }

    ////////////////////////////// Send OTP (sms for login) \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function send_otp() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);

        if(isset($user_var['national_code']) && !empty($user_var['national_code'])){
			$national_code = $user_var['national_code'];
			$rand = rand(1000, 9999);

			if (!isset($user_var['phone_num']) && empty($user_var['phone_num']) &&
				isset($user_var['user_type']) && !empty($user_var['user_type'])) {
				$user_type = $user_var['user_type'];
				if ($national_code == '1111111111') {
					$result['response'] = (string) 1;
				} elseif ($user_type == '1' && $this->exist->exist_entry('students', array('national_code' => $national_code))) {
					$student = $this->base->get_data('students', 'phone_num', array('national_code' => $national_code));
					$phone_num = $student[0]->phone_num;
					$otp_array = array(
						'otp' => $rand,
						'national_code' => $national_code
					);
					if ($this->exist->exist_entry('save_otp', array('national_code' => $national_code)))
						$this->base->update('save_otp', array('national_code' => $national_code), array('otp' => $rand));
					else
						$this->base->insert('save_otp', $otp_array);

					$this->sendSms_otp($phone_num, $rand);

					$result['response'] = (string) 1;
					$result['mesg'] = "کد تاییدیه برای شما ارسال شد";
				} elseif ($user_type == '2' && $this->exist->exist_entry('employers', array('national_code' => $national_code))) {
					$student = $this->base->get_data('employers', 'phone_num', array('national_code' => $national_code));
					$phone_num = $student[0]->phone_num;
					$otp_array = array(
						'otp' => $rand,
						'national_code' => $national_code
					);
					if ($this->exist->exist_entry('save_otp', array('national_code' => $national_code)))
						$this->base->update('save_otp', array('national_code' => $national_code), array('otp' => $rand));
					else
						$this->base->insert('save_otp', $otp_array);

					$this->sendSms_otp($phone_num, $rand);

					$result['response'] = (string) 1;
					$result['mesg'] = "کد تاییدیه برای شما ارسال شد";
				} else {
					$result['response'] = (string) 0;
					$result['mesg'] = "این کد ملی ثبت نشده است";
				}
			}elseif (isset($user_var['phone_num']) && !empty($user_var['phone_num']) && !isset($user_var['user_type']) && empty($user_var['user_type'])){

				$mobile = $user_var['phone_num'];
				$otp_array = array(
					'otp' => $rand,
					'national_code' => $national_code
				);
				if ($this->exist->exist_entry('save_otp', array('national_code' => $national_code)))
					$this->base->update('save_otp', array('national_code' => $national_code), array('otp' => $rand));
				else
					$this->base->insert('save_otp', $otp_array);

				$this->sendSms_otp($mobile, $rand);
				$result['response'] = (string) 1;
				$result['mesg'] = "کد تاییدیه برای شما ارسال شد";

			}else{
			$result['response'] = (string) 0;
			$result['mesg'] = "خطای نقص ورودی";
		}
		}else{
			$result['response'] = (string) 0;
			$result['mesg'] = "خطای نقص ورودی";
		}
        echo json_encode($result);
    }

    public function sendSms_otp($phone_num, $rand) {
        /////send OTP
        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
		$pattern_code = "lx19h6cjh9";
        $to = array($phone_num);
        $input_data = array(
            "code" => $rand);
        $url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $verify_code = curl_exec($handler);
        /////End send OTP
    }

    ////////////////////////////// Login \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function login() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $national_code = $user_var['national_code'];
        $user_type = $user_var['user_type'];
        $user_Otp = $user_var['user_Otp'];

        $save_otp = $this->base->get_data('save_otp', '*', array('national_code' => $national_code));
        if (!empty($save_otp)) {
            $Otp = $save_otp[0]->otp;
        } else {
            $Otp = '1';
        }

        if ($user_Otp == $Otp ||  ($user_Otp == '1111' && $national_code == '1111111111')) {
            if ($user_type == '1') {
                $student = $this->base->get_data('students', 'academy_id', array('national_code' => $national_code));
                if (!empty($student)) {
                    $result['response'] = (string) 1;
                    $result['mesg'] = "لیست آموزشگاه ها";
                    foreach ($student as $std):
                        $academys_student = $this->base->get_data('academys_option', 'academy_id, academy_name, academy_display_name, logo', array('academy_id' => $std->academy_id));
                        foreach ($academys_student as $as):
                            $academy['academy_id'] = $as->academy_id;
                            $academy['academy_name'] = $as->academy_display_name . " " . $as->academy_name;
                            $academy['logo'] = base_url('assets/profile-picture/thumb/' . $as->logo);
                            $data['academy'][] = $academy;
                        endforeach;
                        $result['data'] = $data;
                    endforeach;
                    echo json_encode($result);
                }
                else {
                    $result['response'] = (string) 0;
                    $result['mesg'] = "اطلاعات وارد شده مجاز نمی باشد";
                    echo json_encode($result);
                }
            } elseif ($user_type == '2') {
                $employer = $this->base->get_data('employers', 'academy_id', array('national_code' => $national_code));
                if (!empty($employer)) {
                    $result['response'] = (string) 1;
                    $result['mesg'] = "لیست آموزشگاه ها";
                    foreach ($employer as $std):
                        $academys_employer = $this->base->get_data('academys_option', 'academy_id, academy_name, academy_display_name, logo', array('academy_id' => $std->academy_id));
                        foreach ($academys_employer as $as):
                            $academy['academy_id'] = $as->academy_id;
                            $academy['academy_name'] = $as->academy_display_name . " " . $as->academy_name;
                            $academy['logo'] = base_url('assets/profile-picture/thumb/' . $as->logo);
                            $data['academy'][] = $academy;
                        endforeach;
                        $result['data'] = $data;
                    endforeach;
                    echo json_encode($result);
                }else {
                    $result['response'] = (string) 0;
                    $result['mesg'] = "اطلاعات وارد شده مجاز نمی باشد";
                    echo json_encode($result);
                }
            }
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = $Otp;
            echo json_encode($result);
        }
    }

    ////////////////////////////// getUserAccount \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function get_user_account() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $national_code = $user_var['national_code'];
        $user_type = $user_var['user_type'];
        $academy_id = $user_var['academy_id'];

        $academys_option = $this->base->get_data('academys_option', 'student_display_name,teacher_display_name', array('academy_id' => $academy_id));
        $admin = $this->base->get_data('admin', 'announcement');

        if ($user_type == 1) {
            $courses_std = $this->base->get_data('students', 'first_name, last_name, pic_name, national_code', array('national_code' => $national_code, 'academy_id' => $academy_id));

            if (!empty($courses_std)) {
                $result['response'] = (string) 1;
                $full_name = $courses_std[0]->first_name . " " . $courses_std[0]->last_name;
                $data['full_name'] = $full_name;
                $data['image'] = base_url('assets/profile-picture/thumb/' . $courses_std[0]->pic_name);
                $financial_situation = $this->base->get_data('financial_situation', 'final_amount, final_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id));
                $data['financial_status'] = $financial_situation[0]->final_situation;
                $data['final_amount'] = (string) $financial_situation[0]->final_amount;
                $data['user_title'] = $academys_option[0]->student_display_name;
                $data['announcement'] = $admin[0]->announcement;
                $result['data'] = $data;
                echo json_encode($result);
            }
        } elseif ($user_type == 2) {
            $courses_emp = $this->base->get_data('employers', 'first_name, last_name, pic_name', array('national_code' => $national_code, 'academy_id' => $academy_id));

            if (!empty($courses_emp)) {
                $result['response'] = (string) 1;
                $full_name = $courses_emp[0]->first_name . " " . $courses_emp[0]->last_name;
                $data['full_name'] = $full_name;
                $data['image'] = base_url('assets/profile-picture/thumb/' . $courses_emp[0]->pic_name);
                $financial_situation_emp = $this->base->get_data('financial_situation_employer', 'final_amount, final_situation', array('employee_nc' => $national_code, 'academy_id' => $academy_id));
                $data['financial_status'] = $financial_situation_emp[0]->final_situation;
                $data['final_amount'] = (string) $financial_situation_emp[0]->final_amount;
                $data['user_title'] = $academys_option[0]->teacher_display_name;
                $data['announcement'] = $admin[0]->announcement;
                $result['data'] = $data;
                echo json_encode($result);
            }
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "Errrror";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Courses \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function courses() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $national_code = $user_var['national_code'];
        $user_type = $user_var['user_type'];
        $academy_id = $user_var['academy_id'];

        if ($user_type == '1') {
//            $courses_std = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('courses_students.student_nc' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
            $courses_std = $this->get_join->get_data4('courses_students', 'courses', 'courses_students.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id));
            if (!empty($courses_std)) {
                $result['response'] = (string) 1;
//                $A_courses_std = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('courses_students.student_nc' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id, 'courses.course_status' => '1'));
                $A_courses_std = $this->get_join->get_data4('courses_students', 'courses', 'courses_students.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '1'));
                if (!empty($A_courses_std)) {
                    foreach ($A_courses_std as $course):
                        $active_courses = [];
                        $active_courses['course_id'] = $course->course_id;
                        $active_courses['lesson_name'] = $course->lesson_name;
                        $active_courses['class_name'] = $course->class_name;
                        $employe = $this->base->get_data('employers', 'first_name,last_name', array('national_code' => $course->course_master));
                        $active_courses['teacher_name'] = $employe[0]->first_name . " " . $employe[0]->last_name;
                        $active_courses['start_date'] = $course->start_date;
                        $active_courses['course_duration'] = $course->course_duration;
                        $active_courses['time_meeting'] = $course->time_meeting;
                        if ($course->sat_status == '1')
                            $active_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $active_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $active_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $active_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $active_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $active_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $active_courses['type_holding'] = 'حضوری';
                            unset($active_courses['class_online']);
                        }else {
                            $active_courses['type_holding'] = 'آنلاین';
                            $class_online=[];
                            if($course->detail_online !== null) {
                                $detail_online = $course->detail_online;
                                $detail_online = json_decode($detail_online);
                                if ($detail_online->link_student !== 'null') {
                                    $class_online['link_student'] = $detail_online->link_student;
                                    $class_online['link_detail'] = "پیوستن به کلاس";
                                }else {
                                    $class_online['link_student'] = null;
                                    $class_online['link_detail'] = "کلاس آنلاین ایجاد نشده است";
                                }
                            }else{
                                $class_online['link_student'] = null;
                                $class_online['link_detail'] = "کلاس آنلاین ایجاد نشده است";
                            }
                            $active_courses['class_online'] = $class_online;
                        }

                        $data['active_courses'][] = $active_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['active_courses_std'] = [];
                    $result['data'] = $data;
                }
//                $W_courses_std = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('courses_students.student_nc' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id, 'courses.course_status' => '0'));
                $W_courses_std = $this->get_join->get_data4('courses_students', 'courses', 'courses_students.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '0'));
                if (!empty($W_courses_std)) {
                    foreach ($W_courses_std as $course):
                        $waiting_courses = [];
                        $waiting_courses['course_id'] = $course->course_id;
                        $waiting_courses['lesson_name'] = $course->lesson_name;
                        $waiting_courses['class_name'] = $course->class_name;
                        $employe = $this->base->get_data('employers', 'first_name,last_name', array('national_code' => $course->course_master));
                        $waiting_courses['teacher_name'] = $employe[0]->first_name . " " . $employe[0]->last_name;
                        $waiting_courses['start_date'] = $course->start_date;
                        $waiting_courses['course_duration'] = $course->course_duration;
                        $waiting_courses['time_meeting'] = $course->time_meeting;
                        if ($course->sat_status == '1')
                            $waiting_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $waiting_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $waiting_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $waiting_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $waiting_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $waiting_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $waiting_courses['type_holding'] = "حضوری";
                            unset($waiting_courses['class_online']);
                        }else {
                            $waiting_courses['type_holding'] = "آنلاین";
                            $class_online=[];
                            $class_online['link_student'] = null;
                            $class_online['link_detail'] = "دوره فعالسازی نشده است";
                            $waiting_courses['class_online'] = $class_online;
                        }

                        $data['waiting_courses'][] = $waiting_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['waiting_courses_std'] = [];
                    $result['data'] = $data;
                }
//                $C_courses_std = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('courses_students.student_nc' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id, 'courses.course_status' => '2'));
                $C_courses_std = $this->get_join->get_data4('courses_students', 'courses', 'courses_students.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '2'));
                if (!empty($C_courses_std)) {
                    foreach ($C_courses_std as $course):
                        $completed_courses = [];
                        $completed_courses['course_id'] = $course->course_id;
                        $completed_courses['lesson_name'] = $course->lesson_name;
                        $completed_courses['class_name'] = $course->class_name;
                        $employe = $this->base->get_data('employers', 'first_name,last_name', array('national_code' => $course->course_master));
                        $completed_courses['teacher_name'] = $employe[0]->first_name . " " . $employe[0]->last_name;
                        $completed_courses['start_date'] = $course->start_date;
                        $completed_courses['course_duration'] = $course->course_duration;
                        $completed_courses['time_meeting'] = $course->time_meeting;
                        if ($course->sat_status == '1')
                            $completed_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $completed_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $completed_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $completed_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $completed_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $completed_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $completed_courses['type_holding'] = "حضوری";
                            unset($completed_courses['class_online']);
                        }else {
                            $completed_courses['type_holding'] = "آنلاین";
                            $class_online=[];
                            $class_online['link_student'] = null;
                            $class_online['link_detail'] = "دوره اتمام یافته است";
                            $completed_courses['class_online'] = $class_online;
                        }

                        $data['completed_courses'][] = $completed_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['completed_courses'] = [];
                    $result['data'] = $data;
                }
                echo json_encode($result);
            } else {
                $result['response'] = (string) 0;
                $result['mesg'] = "کاربر گرامی دوره ای برای شما ثبت نشده است";
                echo json_encode($result);
            }
        } elseif ($user_type == '2') {
//            $courses_emp = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $courses_emp = $this->get_join->get_data4('courses_employers', 'courses', 'courses_employers.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('employee_nc' => $national_code, 'courses_employers.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id));
            if (!empty($courses_emp)) {
                $result['response'] = (string) 1;
//                $A_courses_emp = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.course_status' => '1'));
                $A_courses_emp = $this->get_join->get_data4('courses_employers', 'courses', 'courses_employers.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('employee_nc' => $national_code, 'courses_employers.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '1'));
                if (!empty($A_courses_emp)) {
                    foreach ($A_courses_emp as $course):
                        $active_courses = [];
                        $active_courses['course_id'] = $course->course_id;
                        $active_courses['lesson_name'] = $course->lesson_name;
                        $active_courses['class_name'] = $course->class_name;
                        $active_courses['start_date'] = $course->start_date;
                        $active_courses['course_duration'] = $course->course_duration;
                        $active_courses['time_meeting'] = $course->time_meeting;
                        if ($course->sat_status == '1')
                            $active_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $active_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $active_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $active_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $active_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $active_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $active_courses['type_holding'] = "حضوری";
                            unset($active_courses['class_online']);
                        }else {
                            $active_courses['type_holding'] = "آنلاین";
                            $class_online=[];
                            if($course->detail_online !== null) {
                                $detail_online = $course->detail_online;
                                $detail_online = json_decode($detail_online);
                                if ($detail_online->link_teacher !== 'null') {
                                    $class_online['link_teacher'] = $detail_online->link_teacher;
                                    $class_online['user'] = $detail_online->user;
                                    $class_online['pass'] = $detail_online->pass;
                                    $class_online['link_detail'] = "ورود به کلاس";
                                }else {
                                    $class_online['link_teacher'] = null;
                                    $class_online['link_detail'] = "کلاس آنلاین ایجاد نشده است";
                                }
                            }else{
                                $class_online['link_teacher'] = null;
                                $class_online['link_detail'] = "کلاس آنلاین ایجاد نشده است";
                            }
                            $active_courses['class_online'] = $class_online;
                        }

                        $data['active_courses'][] = $active_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['active_courses'] = [];
                    $result['data'] = $data;
                }
//                $W_courses_emp = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.course_status' => '0'));
                $W_courses_emp = $this->get_join->get_data4('courses_employers', 'courses', 'courses_employers.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('employee_nc' => $national_code, 'courses_employers.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '0'));
                if (!empty($W_courses_emp)) {
                    foreach ($W_courses_emp as $course):
                        $waiting_courses = [];
                        $waiting_courses['course_id'] = $course->course_id;
                        $waiting_courses['lesson_name'] = $course->lesson_name;
                        $waiting_courses['class_name'] = $course->class_name;
                        $waiting_courses['start_date'] = $course->start_date;
                        $waiting_courses['course_duration'] = $course->course_duration;
                        $waiting_courses['time_meeting'] = $course->time_meeting;
//                        $waiting_courses['clock'] = "شنبه: " . $course->sat_clock ." , یکشنبه: " . $course->sun_clock." , دوشنبه: " . $course->mon_clock." , سه شنبه: " . $course->tue_clock." , چهارشنبه: " . $course->wed_clock." , پنج شنبه: " . $course->thu_clock;
                        if ($course->sat_status == '1')
                            $waiting_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $waiting_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $waiting_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $waiting_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $waiting_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $waiting_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $waiting_courses['type_holding'] = "حضوری";
                            unset($waiting_courses['class_online']);
                        }else {
                            $waiting_courses['type_holding'] = "آنلاین";
                            $class_online=[];
                            $class_online['link_teacher'] = null;
                            $class_online['link_detail'] = "دوره فعالسازی نشده است";
                            $waiting_courses['class_online'] = $class_online;
                        }

                        $data['waiting_courses'][] = $waiting_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['waiting_courses'] = [];
                    $result['data'] = $data;
                }
//                $C_courses_emp = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', null, null, array('course_master' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.course_status' => '2'));
                $C_courses_emp = $this->get_join->get_data4('courses_employers', 'courses', 'courses_employers.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'classes', 'classes.class_id=courses.class_id', array('employee_nc' => $national_code, 'courses_employers.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'classes.academy_id' => $academy_id, 'course_status' => '2'));
                if (!empty($C_courses_emp)) {
                    foreach ($C_courses_emp as $course):
                        $completed_courses = [];
                        $completed_courses['course_id'] = $course->course_id;
                        $completed_courses['lesson_name'] = $course->lesson_name;
                        $completed_courses['class_name'] = $course->class_name;
                        $completed_courses['start_date'] = $course->start_date;
                        $completed_courses['course_duration'] = $course->course_duration;
                        $completed_courses['time_meeting'] = $course->time_meeting;
                        if ($course->sat_status == '1')
                            $completed_courses['sat_clock'] = "شنبه: " . substr($course->sat_clock, 0, 5);
                        if ($course->sun_status == '1')
                            $completed_courses['sun_clock'] = "یکشنبه: " . substr($course->sun_clock, 0, 5);
                        if ($course->mon_status == '1')
                            $completed_courses['mon_clock'] = "دوشنبه: " . substr($course->mon_clock, 0, 5);
                        if ($course->tue_status == '1')
                            $completed_courses['tue_clock'] = "سه شنبه: " . substr($course->tue_clock, 0, 5);
                        if ($course->wed_status == '1')
                            $completed_courses['wed_clock'] = "چهارشنبه: " . substr($course->wed_clock, 0, 5);
                        if ($course->thu_status == '1')
                            $completed_courses['thu_clock'] = "پنج شنبه: " . substr($course->thu_clock, 0, 5);

                        if ($course->type_holding == '0') {
                            $completed_courses['type_holding'] = "حضوری";
                            unset($completed_courses['class_online']);
                        }else {
                            $completed_courses['type_holding'] = "آنلاین";
                            $class_online=[];
                            $class_online['link_teacher'] = null;
                            $class_online['link_detail'] = "دوره اتمام یافته است";
                            $completed_courses['class_online'] = $class_online;
                        }

                        $data['completed_courses'][] = $completed_courses;
                        $result['data'] = $data;
                    endforeach;
                }else {
                    $data['completed_courses'] = [];
                    $result['data'] = $data;
                }
                echo (json_encode($result));
            } else {
                $result['response'] = (string) 0;
                $result['mesg'] = "مربی گرامی دوره ای برای شما ثبت نشده است";
                echo json_encode($result);
            }
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "Errrror";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Meeting of Course \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function sessions() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $national_code = $user_var['national_code'];
        $user_type = $user_var['user_type'];
        $academy_id = $user_var['academy_id'];
        $course_id = $user_var['course_id'];

        if ($user_type == 1) {
            $meeetingOfCourse = $this->get_join->get_data('courses_students', 'attendance', 'courses_students.course_id=attendance.course_id', null, null, array('courses_students.student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'attendance.academy_id' => $academy_id, 'attendance.course_id' => $course_id, 'courses_students.course_id' => $course_id, 'attendance.meeting_number !=' => null));
            $attendanceOfCourse = $this->base->get_data('attendance', '*', array('student_nc' => $national_code, 'course_id' => $course_id));

            if (!empty($meeetingOfCourse)) {
                $result['response'] = (string) 1;
                foreach ($meeetingOfCourse as $moc):

                    $session_list['session_id'] = $moc->attendance_id;
                    $session_list['session_number'] = $moc->meeting_number;
                    $session_list['session_date'] = $moc->date;
                    $session_list['session_time'] = $moc->time_meeting;
                    if (!empty($attendanceOfCourse)) {
                        foreach ($attendanceOfCourse as $aoc):
                            if ($aoc->meeting_number_std == $moc->meeting_number && $aoc->course_id == $moc->course_id) {
                                $session_list['presence'] = $aoc->type_attendance;
                                break;
                            } else {
                                $session_list['presence'] = (string) 0;
                            }
                        endforeach;
                    } else {
                        $session_list['presence'] = (string) 0;
                    }
                    $session_list['session_file'] = [];
                    $awarenessSubject = $this->base->get_data('awareness_subject', 'awareness_subject_title,meeting_number,file_name', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number' => $moc->meeting_number));
                    if (!empty($awarenessSubject)) {
                        foreach ($awarenessSubject as $asj):
                            $session_file['file_title'] = $asj->awareness_subject_title;
                            $session_file['file_url'] = base_url('assets/awareness/' . $asj->file_name);
                            $session_list['session_file'][] = $session_file;
                        endforeach;
                    } else {
                        $session_list['session_file'] = [];
                    }
                    $data['session_list'][] = $session_list;
                endforeach;
                $result['data'] = $data;
                echo json_encode($result);
            } else {
                $result['response'] = (string) 0;
                $result['mesg'] = "کاربر گرامی جلسه ای برای این دوره ثبت نشده است.";
                echo json_encode($result);
            }
        } elseif ($user_type == 2) {
            $courses_emp = $this->get_join->get_data('courses', 'attendance', 'courses.course_id=attendance.course_id', 'employers', 'employers.national_code=courses.course_master', array('national_code' => $national_code, 'attendance.meeting_number !=' => null, 'employers.academy_id' => $academy_id, 'attendance.course_id' => $course_id));
            if (!empty($courses_emp)) {
                $result['response'] = (string) 1;
                foreach ($courses_emp as $count):
                    $session_list['session_id'] = $count->attendance_id;
                    $session_list['session_number'] = $count->meeting_number;
                    $session_list['session_date'] = $count->date;
                    $session_list['session_time'] = $count->time_meeting;
                    $session_list['session_file'] = [];
                    $awarenessSubject = $this->base->get_data('awareness_subject', 'awareness_subject_title,meeting_number,file_name', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number' => $count->meeting_number));
                    if (!empty($awarenessSubject)) {
                        foreach ($awarenessSubject as $asj):
                            $session_file['file_title'] = $asj->awareness_subject_title;
                            $session_file['file_url'] = base_url('assets/awareness/' . $asj->file_name);
                            $session_list['session_file'][] = $session_file;
                        endforeach;
                    } else {
                        $session_list['session_file'] = [];
                    }
                    $data['session_list'][] = $session_list;
                endforeach;
                $result['data'] = $data;
                echo json_encode($result);
            } else {
                $result['response'] = (string) 0;
                $result['mesg'] = "مربی گرامی جلسه ای برای این دوره ثبت نشده است.";
                echo json_encode($result);
            }
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "Errrror";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Get Attendance List \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function get_attendance_list() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $course_id = $user_var['course_id'];
        $meeting_number = $user_var['meeting_number'];
        $studentListOfCourse = $this->get_join->get_data('courses_students', 'students', 'courses_students.student_nc=students.national_code', null, null, array('course_id' => $course_id, 'courses_students.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
        $attendanseList = $this->base->get_data('attendance', 'student_nc, type_attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number));
        if (!empty($studentListOfCourse)) {
            $result['response'] = (string) 1;
            foreach ($studentListOfCourse as $as):
                $attendance_list['student_name'] = $as->first_name . " " . $as->last_name;
                $attendance_list['student_image'] = base_url('assets/profile-picture/thumb/' . $as->pic_name);
                $attendance_list['student_melli_code'] = $as->national_code;
                if (!empty($attendanseList)) {
                    foreach ($attendanseList as $listSTD):
                        if ($listSTD->student_nc == $as->national_code) {
                            $attendance_list['student_presence_status'] = $listSTD->type_attendance;
                            break;
                        } else {
                            $attendance_list['student_presence_status'] = (string) 0;
                        }
                    endforeach;
                } else {
                    $attendance_list['student_presence_status'] = (string) 0;
                }

                $data['attendance_list'][] = $attendance_list;
            endforeach;
            $result['data'] = $data;
            echo json_encode($result);
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "دانشجویی برای این دوره ثبت نشده است.";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Add meeting \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function add_session() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $course_id = $user_var['course_id'];

        $courses = $this->base->get_data('courses', '*', array('course_id' => $course_id, 'academy_id' => $academy_id));
        $attendance = $this->base->get_data('attendance', 'meeting_number', array('meeting_number !=' => null, 'course_id' => $course_id, 'academy_id' => $academy_id));
        foreach ($attendance as $att) {
            (int) $meeting_number = (int) $att->meeting_number;
        }
        $time_meeting = $courses[0]->time_meeting;
        require_once 'jdf.php';
        $date = jdate('H:i:s - Y/n/j');
        $insert_array = array(
            'academy_id' => $academy_id,
            'employer_nc' => $courses[0]->course_master,
            'course_id' => $course_id,
            'meeting_number' => $meeting_number + 1,
            'time_meeting' => $time_meeting,
            'date' => $date
        );
        $time_total = $courses[0]->time_total;
        $update_time_total = array(
            'time_total' => (int) $time_meeting + $time_total
        );
        if ($courses[0]->type_course == '0') {
            if ($courses[0]->type_pay == '1') {
                // emp
                $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                // update financial_amount (employer) in table financial_situation_employer
                $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                $financial_situation_update = array(
                    'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                    'final_situation' => 1
                );
                $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                // end
                // update course_amount in table courses_employers
                $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
                $courses_employers_update = array(
                    'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                );
                $this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
                // end emp
            }
        } elseif ($courses[0]->type_course == '1') {
            if ($courses[0]->type_pay == '1' && $courses[0]->type_tuition == '1') {
                // emp
                $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                // update financial_amount (employer) in table financial_situation_employer
                $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                $financial_situation_update = array(
                    'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                    'final_situation' => 1
                );
                $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                // end
                // update course_amount in table courses_employers
                $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
                $courses_employers_update = array(
                    'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                );
                $this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
                // end emp
            } elseif ($courses[0]->type_pay == '1' && $courses[0]->type_tuition == '0') {
                // std
                $amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
                // update financial_amount (student) in table financial_situation_employer
                $financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
                foreach ($financial_state as $financial_situation) {
                    if ((int) $financial_situation->final_situation == 0 || (int) $financial_situation->final_situation == -1) {
                        $amount_update = array(
                            'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
                            'final_situation' => -1
                        );
                    } else {
                        if ((int) $amount_std > (int) $financial_situation->final_amount) {
                            $amount_update = array(
                                'final_amount' => (int) $amount_std - (int) $financial_situation->final_amount,
                                'final_situation' => -1
                            );
                        } elseif ((int) $amount_std == (int) $financial_situation->final_amount) {
                            $amount_update = array(
                                'final_amount' => 0,
                                'final_situation' => 0
                            );
                        } else {
                            $amount_update = array(
                                'final_amount' => (int) $financial_situation->final_amount - (int) $amount_std,
                                'final_situation' => 1
                            );
                        }
                    }
                    $this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
                    $course_cost = $financial_situation->course_cost + $amount_std;
                    $this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
                }
                // end std
                // emp
                $amount_emp = ($time_meeting / 60) * $courses[0]->value_pay;
                // update financial_amount (employer) in table financial_situation_employer
                $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                $financial_situation_update = array(
                    'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                    'final_situation' => 1
                );
                $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                // end
                // update course_amount in table courses_employers
                $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
                $courses_employers_update = array(
                    'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                );
                $this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
                // end emp
            } elseif ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '0') {
                // std
                $amount_std = $courses[0]->course_tuition * ($time_meeting / 60);
                // update financial_amount (student) in table financial_situation_employer
                $financial_state = $this->get_join->get_data('financial_situation', 'courses_students', 'courses_students.student_nc = financial_situation.student_nc ', null, null, array('courses_students.course_id' => $course_id, 'financial_situation.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id));
                foreach ($financial_state as $financial_situation) {
                    if ((int) $financial_situation->final_situation == 0 || (int) $financial_situation->final_situation == -1) {
                        $amount_update = array(
                            'final_amount' => (int) $financial_situation->final_amount + (int) $amount_std,
                            'final_situation' => -1
                        );
                    } else {
                        if ((int) $amount_std > (int) $financial_situation->final_amount) {
                            $amount_update = array(
                                'final_amount' => (int) $amount_std - (int) $financial_situation->final_amount,
                                'final_situation' => -1
                            );
                        } elseif ((int) $amount_std == (int) $financial_situation->final_amount) {
                            $amount_update = array(
                                'final_amount' => 0,
                                'final_situation' => 0
                            );
                        } else {
                            $amount_update = array(
                                'final_amount' => (int) $financial_situation->final_amount - (int) $amount_std,
                                'final_situation' => 1
                            );
                        }
                    }
                    $this->base->update('financial_situation', array('student_nc' => $financial_situation->student_nc, 'academy_id' => $academy_id), $amount_update);
                    $course_cost = $financial_situation->course_cost + $amount_std;
                    $this->base->update('courses_students', array('student_nc' => $financial_situation->student_nc, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost' => $course_cost));
                }
                // end std
                // emp
                $amount_emp = (($amount_std * $courses[0]->count_std) * $courses[0]->value_pay) / 100;
                // update financial_amount (employer) in table financial_situation_employer
                $financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
                $financial_situation_update = array(
                    'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount_emp,
                    'final_situation' => 1
                );
                $this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
                // end
                // update course_amount in table courses_employers
                $courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master));
                $courses_employers_update = array(
                    'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount_emp
                );
                $this->base->update('courses_employers', array('course_id' => $course_id, 'employee_nc' => $courses[0]->course_master), $courses_employers_update);
                // end emp
            }
        }
        $this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $update_time_total);
        $this->base->insert('attendance', $insert_array);
        $result['response'] = (string) 1;
        $result['mesg'] = "جلسه جدید ایجاد شد.";
        echo json_encode($result);
    }

    ////////////////////////////// Change Presence \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function change_presence() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $course_id = $user_var['course_id'];
        $national_code = $user_var['national_code'];
        $meeting_number = $user_var['meeting_number'];

        if ($this->exist->exist_entry('attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number, 'student_nc' => $national_code))) {
            $this->base->delete_data('attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number, 'student_nc' => $national_code));
            $result['response'] = (string) 1;
            $result['mesg'] = 'لغو غیبت با موفقیت انجام شد';
            $attendanceForStudent = $this->base->get_data('attendance', 'type_attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number, 'student_nc' => $national_code));
            if (empty($attendanceForStudent)) {
                $result['status'] = (string) 0;
            } else {
                $result['status'] = $attendanceForStudent[0]->type_attendance;
            }
            echo json_encode($result);
        } elseif (!$this->exist->exist_entry('attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number, 'student_nc' => $national_code))) {
            $course_masetr = $this->base->get_data('courses', 'course_master', array('academy_id' => $academy_id, 'course_id' => $course_id));
            $insert_array = array(
                'academy_id' => $academy_id,
                'course_id' => $course_id,
                'meeting_number_std' => $meeting_number,
                'type_attendance' => '1',
                'student_nc' => $national_code,
                'employer_nc' => $course_masetr[0]->course_master
            );
            $this->base->insert('attendance', $insert_array);
            $result['response'] = (string) 1;
            $result['mesg'] = 'ثبت غیبت با موفقیت انجام شد';
            $attendanceForStudent = $this->base->get_data('attendance', 'type_attendance', array('academy_id' => $academy_id, 'course_id' => $course_id, 'meeting_number_std' => $meeting_number, 'student_nc' => $national_code));
            if (empty($attendanceForStudent)) {
                $result['status'] = (string) 0;
            } else {
                $result['status'] = $attendanceForStudent[0]->type_attendance;
            }
            echo json_encode($result);
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "Errrror";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Teacher Financial Detail \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function teacher_financial_detail() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $national_code = $user_var['national_code'];

        $courses_emp = $this->get_join->get_data('courses_employers', 'courses', 'courses_employers.course_id=courses.course_id', 'lessons', 'lessons.lesson_id=courses.lesson_id', array('employee_nc' => $national_code, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_employers.academy_id' => $academy_id));
        $course_pouse = $this->base->get_data('course_pouse_pay', '*', array('employee_nc' => $national_code, 'academy_id' => $academy_id));
        $course_cash = $this->base->get_data('course_cash_pay', '*', array('employee_nc' => $national_code, 'academy_id' => $academy_id));
        $course_check = $this->base->get_data('course_check_pay', '*', array('employee_nc' => $national_code, 'academy_id' => $academy_id));
        if (!empty($courses_emp) || !empty($course_pouse) || !empty($course_cash) || !empty($course_check)) {
            $result['response'] = (string) 1;
            if (!empty($courses_emp)) {
                foreach ($courses_emp as $course):
                    $courses['course_id'] = $course->course_id;
                    $courses['course_name'] = $course->lesson_name;
                    $courses['student_count'] = $course->count_std;
                    $courses['time_total'] = $course->time_total;
                    if ($course->type_pay == '0') {
                        $courses['type'] = "درصدی";
                        $courses['amount'] = $course->value_pay;
//                        $courses['tuition_calculation'] = (string) 0;
                        $courses['tuition_description'] = "(تعداد زبان آموز * شهریه) درصد استاد";
                        $courses['course_tuition'] = $course->course_amount;
                        $courses['paid'] = $course->amount_received;
                        $remained = $course->course_amount - $course->amount_received;
                        $courses['remained'] = $remained;
                        if ($remained <= 0) {
                            $courses['status'] = "تسویه";
                        } else {
                            $courses['status'] = "بستانکار";
                        }
                    } elseif ($course->type_pay == '1') {
                        $courses['type'] = "ساعتی";
                        $courses['amount'] = $course->value_pay;
//                        $courses['tuition_calculation'] = (string) 0;
                        $courses['tuition_description'] = " مدت زمان تدریس(ساعت) * مبلغ هر ساعت ";
                        $courses['course_tuition'] = $course->course_amount;
                        $courses['paid'] = $course->amount_received;
                        $remained = $course->course_amount - $course->amount_received;
                        $courses['remained'] = $remained;
                        if ($remained <= 0) {
                            $courses['status'] = "تسویه";
                        } else {
                            $courses['status'] = "بستانکار";
                        }
                    } elseif ($course->type_pay == '2') {
                        $courses['type'] = "ماهیانه";
                    }

                    $data['courses'][] = $courses;
                endforeach;
            } else {
                $data['courses'] = $courses_emp;
            }

            if (!empty($course_pouse) || !empty($course_cash) || !empty($course_check)) {
                if (!empty($course_pouse)):
                    foreach ($course_pouse as $pouse_info):
                        $payment['course_id'] = $pouse_info->course_id;
                        $payment['payment_date'] = $pouse_info->date_payment;
                        $payment['paid_amount'] = $pouse_info->course_pouse_amount;
                        $payment['trans_num'] = $pouse_info->transaction_number;
                        $payment['payment_type'] = "کارت";
                        $data['payment'][] = $payment;
                    endforeach;
                endif;
                if (!empty($course_cash)):
                    foreach ($course_cash as $cash_info):
                        $payment['course_id'] = $cash_info->course_id;
                        $payment['payment_date'] = $cash_info->date_payment;
                        $payment['paid_amount'] = $cash_info->course_amount_of_pay;
                        $payment['trans_num'] = $cash_info->course_cash_pay_id;
                        $payment['payment_type'] = "نقد";
                        $data['payment'][] = $payment;
                    endforeach;
                endif;
                if (!empty($course_check)):
                    foreach ($course_check as $check_info):
                        $payment['course_id'] = $check_info->course_id;
                        $payment['payment_date'] = $check_info->check_date;
                        $payment['paid_amount'] = $check_info->check_amount;
                        $payment['trans_num'] = $check_info->serial_number;
                        $payment['payment_type'] = "چک";
                        $data['payment'][] = $payment;
                    endforeach;
                endif;
            }else {
                $data['payment'] = $course_check;
            }
            $result['data'] = $data;
            echo json_encode($result);
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "مربی گرامی اطلاعاتی برای شما ثبت نشده است.";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Student Financial Detail \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function student_financial_detail() {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        $academy_id = $user_var['academy_id'];
        $national_code = $user_var['national_code'];
//		$academy_id = $this->input->post('academy_id');
//		$national_code = $this->input->post('national_code');
//		var_dump($academy_id);

		$courses_std = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'courses_students', 'courses_students.course_id=courses.course_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));

//        $courses_std = $this->get_join->get_data('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $national_code, 'courses_students.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
        $exams_std = $this->get_join->get_data('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', null, null, array('student_nc' => $national_code, 'exams_students.academy_id' => $academy_id, 'exams.academy_id' => $academy_id));
        $online_payments = $this->base->get_data('online_payments', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
        $course_pouse = $this->base->get_data('course_pouse_pay', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
        $course_cash = $this->base->get_data('course_cash_pay', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
        $course_check = $this->base->get_data('course_check_pay', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
        $exam_pouse = $this->base->get_data('exam_pouse_pay', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
        $exam_cash = $this->base->get_data('exam_cash_pay', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));

        if (!empty($courses_std) || !empty($exams_std) || !empty($online_payments) || !empty($course_pouse) || !empty($course_cash) || !empty($course_check) || !empty($exam_pouse) || !empty($exam_cash)) {
            $result['response'] = (string) 1;
            if (!empty($courses_std)) {
                foreach ($courses_std as $course):
                    $courses['course_id'] = $course->course_id;
                    $courses['course_name'] = $course->lesson_name;
                    $courses['time_total'] = $course->time_total;
                    $courses['course_tuition'] = $course->course_cost;
                    $courses['discount'] = $course->amount_off;
                    $courses['paid'] = $course->course_cost_pay;
                    $remained = $course->course_cost - ($course->course_cost_pay + $course->amount_off);
                    $courses['remained'] = $remained;
                    if ($course->course_cost > ($course->course_cost_pay + $course->amount_off)) {
                        $courses['status'] = "بدهکار";
                    } elseif ($course->course_cost == ($course->course_cost_pay + $course->amount_off)) {
                        $courses['status'] = "تسویه";
                    }
                    $data['courses'][] = $courses;
                endforeach;
            } else {
                $data['courses'] = $courses_std;
            }

            if (!empty($exams_std)) {
                foreach ($exams_std as $exam):
                    $exams['course_id'] = $exam->course_id;
                    $exams['test_id'] = $exam->exam_id;
                    $exams['test_tuition'] = $exam->exam_cost;
                    $exams['discount'] = $exam->amount_off;
                    $exams['paid'] = $exam->exam_cost_pay;
                    $remained = $exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off);
                    $exams['remained'] = $remained;
                    if ($exam->exam_cost > ($exam->exam_cost_pay + $exam->amount_off)) {
                        $exams['status'] = "بدهکار";
                    } elseif ($exam->exam_cost <= ($exam->exam_cost_pay + $exam->amount_off)) {
                        $exams['status'] = "تسویه";
                    }
                    $data['exams'][] = $exams;
                endforeach;
            } else {
                $data['exams'] = $exams_std;
            }

            if (!empty($online_payments)) {
                foreach ($online_payments as $Opay):
                    $internet['course_id'] = $Opay->course_id;
                    $internet['test_id'] = $Opay->exam_id;
                    $internet['payment_date'] = $Opay->date_payment;
                    $internet['paid_amount'] = $Opay->paid_amount;
                    $internet['trans_num'] = $Opay->verify_code;
                    $internet['payment_type'] = "آنلاین";
                    $data['internet'][] = $internet;
                endforeach;
            }else {
                $data['internet'] = $online_payments;
            }

            if (!empty($course_pouse) || !empty($course_cash) || !empty($course_check) || !empty($exam_pouse) || !empty($exam_cash)) {
                if (!empty($course_pouse)):
                    foreach ($course_pouse as $pouse_info):
                        $clearing['course_id'] = $pouse_info->course_id;
                        $clearing['test_id'] = '';
                        $clearing['payment_date'] = $pouse_info->date_payment;
                        $clearing['paid_amount'] = $pouse_info->course_pouse_amount;
                        $clearing['trans_num'] = $pouse_info->transaction_number;
                        $clearing['payment_type'] = "کارت";
                        $data['clearing'][] = $clearing;
                    endforeach;
                endif;
                if (!empty($course_cash)):
                    foreach ($course_cash as $cash_info):
                        $clearing['course_id'] = $cash_info->course_id;
                        $clearing['test_id'] = '';
                        $clearing['payment_date'] = $cash_info->date_payment;
                        $clearing['paid_amount'] = $cash_info->course_amount_of_pay;
                        $clearing['trans_num'] = $cash_info->course_cash_pay_id;
                        $clearing['payment_type'] = "نقد";
                        $data['clearing'][] = $clearing;
                    endforeach;
                endif;
                if (!empty($course_check)):
                    foreach ($course_check as $check_info):
                        $clearing['course_id'] = $check_info->course_id;
                        $clearing['test_id'] = '';
                        $clearing['payment_date'] = $check_info->check_date;
                        $clearing['paid_amount'] = $check_info->check_amount;
                        $clearing['trans_num'] = $check_info->serial_number;
                        $clearing['payment_type'] = "چک";
                        $data['clearing'][] = $clearing;
                    endforeach;
                endif;

                if (!empty($exam_pouse)):
                    foreach ($exam_pouse as $exam_pouse_info):
                        $clearing['course_id'] = $exam_pouse_info->course_id;
                        $clearing['test_id'] = $exam_pouse_info->exam_id;
                        $clearing['payment_date'] = $exam_pouse_info->created_at;
                        $clearing['paid_amount'] = $exam_pouse_info->pouse_amount;
                        $clearing['trans_num'] = $exam_pouse_info->transaction_number;
                        $clearing['payment_type'] = "کارت";
                        $data['clearing'][] = $clearing;
                    endforeach;
                endif;
                if (!empty($exam_cash)):
                    foreach ($exam_cash as $exam_cash_info):
                        $clearing['course_id'] = $exam_cash_info->course_id;
                        $clearing['test_id'] = $exam_cash_info->exam_id;
                        $clearing['payment_date'] = $exam_cash_info->cash_date;
                        $clearing['paid_amount'] = $exam_cash_info->amount_of_pay;
                        $clearing['trans_num'] = $exam_cash_info->cash_pay_id;
                        $clearing['payment_type'] = "نقد";
                        $data['clearing'][] = $clearing;
                    endforeach;
                endif;
            }else {
                $data['clearing'] = $course_check;
            }
            $result['data'] = $data;
            echo json_encode($result);
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "کاربر گرامی اطلاعاتی برای شما ثبت نشده است.";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Upload File \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function upload_file() {
        $academy_id = $this->input->post('academy_id');
        $course_id = $this->input->post('course_id');
        $national_code = $this->input->post('national_code');
        $meeting_number = $this->input->post('meeting_number');
        $title = $this->input->post('title');
        $format = $this->input->post('format');

        $rand = rand(1000, 9999);
        $name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        if (isset($name)) {
            if (!empty($name)) {
                $location = '././assets/awareness/';
                $file_name = time(). $rand . ".";
                if (move_uploaded_file($temp_name, $location . $file_name . $format)) {
                    $insArrayFile = array(
                        'academy_id' => $academy_id,
                        'awareness_subject_title' => $title,
                        'file_name' => $file_name . $format,
                        'meeting_number' => $meeting_number,
                        'course_id' => $course_id,
                        'employee_nc' => $national_code
                    );
                    $this->base->insert('awareness_subject', $insArrayFile);
                    $result['response'] = (string) 1;
                    $result['mesg'] = "فایل شما با موفقیت ارسال شد";
                } else {
                    $result['response'] = (string) 1;
                    $result['mesg'] = "بارگذاری فایل با مشکل مواجه شده است";
                }
            }
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "فایلی برای ارسال انتخاب نشده است";
        }
        echo json_encode($result);
    }

    ////////////////////////////// Online Payment \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function online_payment() {
        $academy_id = $this->input->get('academy_id');
        $course_id = $this->input->get('course_id');
        $exam = $this->input->get('exam_id');
        $amount = $this->input->get('amount');
        $national_code = $this->input->get('national_code');

        $exam_id = !empty($exam) ? $exam : " ";
        $callback = 'https://amoozkadeh.com/portal/API_APP/pay_verify/' . $amount . "/" . $course_id . "/" . $national_code . "/" . $academy_id . "/" . $exam_id;
        $description = "description";
        if ($this->zarinpal->request($amount, $description, $callback)) {
            $authority = $this->zarinpal->get_authority();
            // do database stuff
            $this->zarinpal->redirect();
        } else {
            $result['response'] = (string) 1;
            $result['mesg'] = "خطا در ارسال اطلاعات";
            echo json_encode($result);
        }
    }

    public function pay_verify($amount, $course_id, $national_code, $academy_id, $exam_id) {
        $status = $this->input->get('Status', TRUE);
        $authority = $this->input->get('Authority', TRUE);
        if($exam_id == 0){
			$exam_id = null;
		}

        if ($status != 'OK' OR $authority == NULL) {
            $response = (string) 0;
            $mesg = "پرداخت لغو شد";
//            echo json_encode($result);
            header("location: myapputabedu://edu.com?response=$response&mesg=$mesg");
        }
        if ($this->zarinpal->verify($amount, $authority)) {
            $ref_id = $this->zarinpal->get_ref_id();
            require_once 'jdf.php';
            $date = jdate('H:i:s - Y/n/j');
            $success_payment = array(
                'paid_amount' => $amount,
                'verify_code' => $ref_id,
                'date_payment' => $date,
                'course_id' => $course_id,
                'exam_id' => $exam_id,
                'academy_id' => $academy_id,
                'student_nc' => $national_code
            );
            $this->base->insert('online_payments', $success_payment);

			$financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
			if ((int) $financial_situation[0]->final_situation == 0 || (int) $financial_situation[0]->final_situation == 1) {
				$amount_update = array(
					'final_amount' => (int) $financial_situation[0]->final_amount + (int) $national_code,
					'final_situation' => 1
				);
			} else {
				if ((int) $amount > (int) $financial_situation[0]->final_amount) {
					$amount_update = array(
						'final_amount' => (int) $amount - (int) $financial_situation[0]->final_amount,
						'final_situation' => 1
					);
				} elseif ((int) $amount == (int) $financial_situation[0]->final_amount) {
					$amount_update = array(
						'final_amount' => 0,
						'final_situation' => 0
					);
				} else {
					$amount_update = array(
						'final_amount' => (int) $financial_situation[0]->final_amount - (int) $amount,
						'final_situation' => -1
					);
				}
			}
			$this->base->update('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id), $amount_update);

			if(empty($exam_id) OR $exam_id == null) {
					$courseSelected = $this->base->get_data('courses_students', '*', array('student_nc' => $national_code, 'course_id' => $course_id, 'academy_id' => $academy_id));
					$courseSelected[0]->course_cost_pay += $amount;
					$this->base->update('courses_students', array('student_nc' => $national_code, 'course_id' => $course_id, 'academy_id' => $academy_id), array('course_cost_pay' => $courseSelected[0]->course_cost_pay));
			}else {
					$examSelected = $this->base->get_data('exams_students', '*', array('student_nc' => $national_code, 'exam_id' => $exam_id, 'academy_id' => $academy_id));
					$examSelected[0]->exam_cost_pay += $amount;
					$this->base->update('exams_students', array('student_nc' => $national_code, 'exam_id' => $exam_id, 'academy_id' => $academy_id), array('exam_cost_pay' => $examSelected[0]->exam_cost_pay));
			}
			/////////////////پیامک\\\\\\\\\\\\\\\
			$students = $this->base->get_data('students', '*', array('national_code' => $national_code, 'academy_id' => $academy_id));
			$academys_option = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
			$courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('courses.course_id' => $course_id,'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
			$lesson_name = $courses[0]->lesson_name;
			$phone_num = $students[0]->phone_num;
			$full_name = $students[0]->first_name .' '. $students[0]->last_name;
			$studentDName2 = $academys_option[0]->student_display_name;

			$name = $studentDName2 . " گرامی " . $full_name;
			$price = $amount . " تومان به صورت آنلاین";
			$course = $lesson_name;
			$academy_name = $academys_option[0]->academy_name;
			$academyDName = $academys_option[0]->academy_display_name;
			$this->smsForPaymentsStudent($phone_num, $name, $price, $course, $academyDName, $academy_name);

			$message = $name . " مبلغ " . $price . " بابت دوره " . $course . " با موفقیت ثبت گردید.";
			$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'manager_nc' => $academys_option[0]->national_code, 'academy_id' => $academy_id);

			$this->base->insert('manager_student_sms', $insertArray);
			/////////////////پیامک////////////////

//            $result['response'] = (string) 1;
//            $result['mesg'] = "رسید پرداخت";
//            $payment['paid_amount'] = $amount;
//            $payment['verify_code'] = $ref_id;
//            $payment['date_payment'] = $date;
//            $data['payment'] = $payment;
//            $result['data'] = $data;
//            echo json_encode($result);
            header("location: myapputabedu://edu.com");
        } else {
            $error = $this->zarinpal->get_error();
//            $result['response'] = (string) 1;
//            $result['mesg'] = "خطا؛ متاسفانه پرداخت انجام نشد";
//            echo json_encode($result);
        }
    }

    public function smsForPaymentsStudent($phone_num, $name, $price, $course, $academyDName, $academy_name){
		$academy = $academyDName . " " . $academy_name;
		$username = "mehritc";
		$password = '@utabpars1219';
		$from = "+983000505";
		$pattern_code = "ydx4lpds0l";
		$to = array($phone_num);
		$input_data = array(
			"name" => "$name",
			"price" => "$price",
			"cource" => "$course",
			"academy" => "$academy"
		);
		$url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$verify_code = curl_exec($handler);
	}

    public function return_app() {
        $callback = 'https://amoozkadeh.com/portal/app/' . $amount;
        $description = "description";
        if ($this->zarinpal->request($amount, $description, $callback)) {
            $authority = $this->zarinpal->get_authority();
            // do database stuff
            $this->zarinpal->redirect();
        } else {
            $result['response'] = (string) 1;
            $result['mesg'] = "لطفا مبلغ را صحیح وارد کنید";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Get General Info \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function get_General_Info() {
        $academys = $this->base->get_data('academys_option', '*');
        $cities = $this->base->get_data('city', '*');
        $courses1 = $this->get_join->get_data('academys_option', 'courses', 'academys_option.academy_id=courses.academy_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('courses.display_status_in_system' => '2'));
        $courses2 = $this->get_join->get_data('academys_option', 'courses', 'academys_option.academy_id=courses.academy_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('type_academy' => '1', 'courses.display_status_in_system' => '2'));
        $courses3 = $this->get_join->get_data('academys_option', 'courses', 'academys_option.academy_id=courses.academy_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('type_academy' => '4', 'courses.display_status_in_system' => '2'));
        $courses4 = $this->get_join->get_data('academys_option', 'courses', 'academys_option.academy_id=courses.academy_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('type_academy' => '3', 'courses.display_status_in_system' => '2'));

        if (!empty($courses1) || !empty($courses2) || !empty($courses3) || !empty($courses4)) {
            $result['response'] = (string) 1;

            if (!empty($courses1)) {
                $category1['category_title'] = 'دوره های جدید';
                $category1['category_type'] = '1';
                foreach ($courses1 as $course):
                    $category_items['item_id'] = $course->course_id;
                    $category_items['item_lesson_id'] = $course->lesson_id;
                    $category_items['item_title'] = $course->lesson_name;
//					$category_items['item_academy'] = $course->academy_display_name . " " . $course->academy_name;
                    $category_items['item_tuition'] = $course->course_tuition;
                    $category_items['item_capacity'] = $course->capacity;
					$province = $this->base->get_data('province', '*');
					foreach($province as $item):
						if($item->id == $course->province){
							$item_province = $item->name;
						}
					endforeach;
					foreach($cities as $item2):
						if($item2->id == $course->city){
							$item_city = $item2->name;
						}
					endforeach;
					$category_items['item_city'] =	$item_province . " - " . $item_city;
                    $category_items['item_image'] = base_url('assets/course-picture/thumb/' . $course->course_pic);
                    $category_items['item_logo'] = base_url('assets/profile-picture/thumb/' . $course->logo);
                    $category1['category_items'][] = $category_items;
                endforeach;
                $data['other_categories'][] = $category1;
            }


            if (!empty($courses2)) {
                $category2['category_title'] = 'دوره های IT';
                $category2['category_type'] = '1';
                foreach ($courses2 as $course):
                    $category_items['item_id'] = $course->course_id;
                    $category_items['item_lesson_id'] = $course->lesson_id;
                    $category_items['item_title'] = $course->lesson_name;
                    $category_items['item_tuition'] = $course->course_tuition;
                    $category_items['item_capacity'] = $course->capacity;
                    $category_items['item_image'] = base_url('assets/course-picture/thumb/' . $course->course_pic);
                    $category_items['item_logo'] = base_url('assets/profile-picture/thumb/' . $course->logo);
                    $category2['category_items'][] = $category_items;
                endforeach;
                $data['other_categories'][] = $category2;
            }

            if (!empty($courses3)) {
                $category3['category_title'] = 'دوره های هنری';
                $category3['category_type'] = '1';
                foreach ($courses3 as $course):
                    $category_items['item_id'] = $course->course_id;
                    $category_items['item_lesson_id'] = $course->lesson_id;
                    $category_items['item_title'] = $course->lesson_name;
                    $category_items['item_tuition'] = $course->course_tuition;
                    $category_items['item_capacity'] = $course->capacity;
                    $category_items['item_image'] = base_url('assets/course-picture/thumb/' . $course->course_pic);
                    $category_items['item_logo'] = base_url('assets/profile-picture/thumb/' . $course->logo);
                    $category3['category_items'][] = $category_items;
                endforeach;
                $data['other_categories'][] = $category3;
            }

            if (!empty($courses4)) {
                $category4['category_title'] = 'دوره های زبان';
                $category4['category_type'] = '1';
                foreach ($courses4 as $course):
                    $category_items['item_id'] = $course->course_id;
                    $category_items['item_lesson_id'] = $course->lesson_id;
                    $category_items['item_title'] = $course->lesson_name;
                    $category_items['item_tuition'] = $course->course_tuition;
                    $category_items['item_capacity'] = $course->capacity;
                    $category_items['item_image'] = base_url('assets/course-picture/thumb/' . $course->course_pic);
                    $category_items['item_logo'] = base_url('assets/profile-picture/thumb/' . $course->logo);
                    $category4['category_items'][] = $category_items;
                endforeach;
                $data['other_categories'][] = $category4;
            }

            if (!empty($academys)) {
                $category5['category_title'] = 'آموزشگاه های جدید';
                $category5['category_type'] = '0';
                foreach ($academys as $acm):
                    $category_items['item_lesson_id'] = '';
                    $category_items['item_capacity'] = '';
                    $category_items['item_tuition'] = '';
                    $category_items['item_id'] = $acm->academy_id;
                    $category_items['item_title'] = $acm->academy_display_name . " " . $acm->academy_name;
                    $province = $this->base->get_data('province', '*');
					foreach($province as $item):
						if($item->id == $acm->province){
							$item_province = $item->name;
						}
					endforeach;
					foreach($cities as $item2):
						if($item2->id == $acm->city){
							$item_city = $item2->name;
						}
					endforeach;
					$category_items['item_city'] =	$item_province . " - " . $item_city;
                    $category_items['item_image'] = '';
                    $category_items['item_logo'] = base_url('assets/profile-picture/thumb/' . $acm->logo);
                    $category5['category_items'][] = $category_items;
                endforeach;
                $data['other_categories'][] = $category5;
            }
            $data['cities'][] = $cities;
            $result['data'] = $data;
            echo json_encode($result);
        } else {
            $result['response'] = (string) 0;
            $result['mesg'] = "اطلاعات موجود نیست.";
            echo json_encode($result);
        }
    }

    ////////////////////////////// Course Details \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	public function item_details() {
		$user_var = file_get_contents('php://input');
		$user_var = json_decode($user_var, 1);

		if(isset($user_var['category_type'])){
			$category_type = $user_var['category_type'];

			if ($category_type == '1') {
				$course_id = $user_var['course_id'];
				$courses = $this->base->join_five('*', 'courses', 'lessons', 'courses_employers', 'employers', 'academys_option', 'courses.lesson_id=lessons.lesson_id', 'courses.course_id=courses_employers.course_id', 'courses_employers.employee_id=employers.employee_id', 'academys_option.academy_id=courses.academy_id', array('courses.course_id'=>$course_id));
				if (!empty($courses)) {
					$result['response'] = (string) 1;
					$course['course_id'] = $courses[0]->course_id;
					$course['lesson_id'] = $courses[0]->lesson_id;
					$course['course_name'] = $courses[0]->lesson_name;
					$course['course_academy'] = $courses[0]->academy_display_name . " " . $courses[0]->academy_name;
					$course['course_master'] = $courses[0]->first_name . " " . $courses[0]->last_name;

					if ($courses[0]->type_course == '0')
						$course['type_course'] = 'عمومی';
					if ($courses[0]->type_course == '1')
						$course['type_course'] = 'خصوصی';

					if ($courses[0]->type_course == '0')
						$course['course_tuition'] = $courses[0]->course_tuition . ' تومان';
					elseif ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0')
						$course['course_tuition'] = 'هر ساعت ' . $courses[0]->value_tuition_clock . ' تومان';
					elseif ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')
						$course['course_tuition'] = $courses[0]->value_tuition_course . ' تومان';

					if ($courses[0]->capacity !== '0') {
						if ($courses[0]->capacity - $courses[0]->count_std == 0) {
							$course['capacity'] = 'تکمیل';
						} else {
							$course['capacity'] = $courses[0]->capacity - $courses[0]->count_std;
						}
					} else {
						$course['capacity'] = 'نامحدود';
					}

					$course['course_duration'] = $courses[0]->course_duration . ' ساعت';
					$course['time_meeting'] = $courses[0]->time_meeting . ' دقیقه';
					$course['start_date'] = $courses[0]->start_date;
					$course['description'] = $courses[0]->course_description;

					if ($courses[0]->type_gender == '0')
						$course['type_gender'] = 'مختلط';
					elseif ($courses[0]->type_gender == '1')
						$course['type_gender'] = 'آقایان';
					else
						$course['type_gender'] = 'بانوان';

					$course['course_pic'] = base_url('assets/course-picture/thumb/' . $courses[0]->course_pic);
					$course['logo'] = base_url('assets/profile-picture/thumb/' . $courses[0]->logo);
					$data['course_details'] = $course;
					$result['data'] = $data;
				}else {
					$data['course_details'] = $courses;
					$result['data'] = $data;
				}
			} elseif ($category_type == '0') {
				$academy_id = $user_var['academy_id'];
				$academys = $this->base->get_data('academys_option', '*', array('academy_id'=>$academy_id));
				if (!empty($academys)) {
					$result['response'] = (string)1;
					$academy['academy_id'] = $academys[0]->academy_id;
					$academy['academy_name'] = $academys[0]->academy_display_name . " " . $academys[0]->academy_name;
					$academy['manage_name'] = $academys[0]->m_first_name . " " . $academys[0]->m_last_name;
					$academy['Introduction'] = $academys[0]->Introduction;
					$academy['manage_pic'] = base_url('assets/profile-picture/thumb/' . $academys[0]->manage_pic);
					$academy['logo'] = base_url('assets/profile-picture/thumb/' . $academys[0]->logo);
					$province = $this->base->get_data('province', '*');
					foreach($province as $item):
						if($item->id == $academys[0]->province){
							$academy_province = $item->name;
						}
					endforeach;
					$cities = $this->base->get_data('city', '*');
					foreach($cities as $item2):
						if($item2->id == $academys[0]->city){
							$academy_city = $item2->name;
						}
					endforeach;
					$academy['city'] = $academy_province . " - " . $academy_city;
					$academy['address'] = $academys[0]->address;
					$acdm_courses = $this->get_join->get_data('academys_option', 'courses', 'academys_option.academy_id=courses.academy_id', 'lessons', 'courses.lesson_id=lessons.lesson_id', array('academys_option.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
					if (!empty($acdm_courses)) {
						foreach ($acdm_courses as $course):
							$academy_courses['category_type'] = '1';
							$academy_courses['course_id'] = $course->course_id;
							$academy_courses['lesson_id'] = $course->lesson_id;
							$academy_courses['course_name'] = $course->lesson_name;
							$academy_courses['course_tuition'] = $course->course_tuition;
							$academy_courses['capacity'] = $course->capacity;
							$academy_courses['course_pic'] = base_url('assets/course-picture/thumb/' . $course->course_pic);

							$academy['academy_courses'][] = $academy_courses;
						endforeach;
					}else{
						$academy['academy_courses'] = $acdm_courses;
					}
					$data['academy'] = $academy;
					$result['data'] = $data;
				} else {
					$data['academy'] = $academys;
					$result['data'] = $data;
				}
			}
		}else{
			$result['response'] = (string) 0;
			$result['mesg'] = "خطای نقص ورودی";
		}
		echo json_encode($result);
	}

	////////////////////////////// Student authentication \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	public function student_authentication() {
		$user_var = file_get_contents('php://input');
		$user_var = json_decode($user_var, 1);

		if (isset($user_var['national_code']) && !empty($user_var['national_code']) &&
		isset($user_var['phone_num']) && !empty($user_var['phone_num'])) {
			$national_code = $user_var['national_code'];
			$mobile = $user_var['phone_num'];

			// search in all academys
			$students = $this->base->get_data('students', '*', array('national_code' => $national_code));
			if (empty($students)) {
				$result['response'] = (string) 1;
				$result['entity'] = 'false';
				$result['mesg'] = "اطلاعات خود را وارد کنید";
			} else {
				if($students[0]->phone_num == $mobile) {
					$result['response'] = (string)1;
					$result['entity'] = 'true';
					$result['mesg'] = 'اطلاعات شما قبلا در سامانه ثبت شده است.';
				}else {
					$result['response'] = (string)1;
					$result['entity'] = 'true';
					$result['old_phone_num'] = substr($students[0]->phone_num, 0, 4) . ' *** *' . substr($students[0]->phone_num, 8, 3);
					$result['mesg'] = "شماره ای که برای این کد ملی ثبت شده است با شماره جدید مطابقت ندارد یا از شماره قبل استفاده کنید و یا از طریق مدیریت آموزشگاه و پشتیبانی آموزکده نسبت به تغییر شماره اقدام نمایید";
				}
			}
		} else {
			$result['response'] = (string) 0;
			$result['mesg'] = 'خطای نقص ورودی';
		}
		echo json_encode($result);
	}

	////////////////////////////// Student registration \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	public function student_registration() {
		$user_var = file_get_contents('php://input');
		$user_var = json_decode($user_var, 1);

		if(isset($user_var['national_code']) && !empty($user_var['national_code']) && isset($user_var['type']) && !empty($user_var['type']) && isset($user_var['course_id']) && !empty($user_var['course_id'])){

			$type = $user_var['type'];
			$national_code = $user_var['national_code'];
			$course_id = $user_var['course_id'];
			$students = $this->base->get_data('students', '*', array('national_code' => $national_code));

			//  زمانی که فرد لاگین است
			if ($type == '3') {
				// course details
				$courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id = lessons.lesson_id', null, null, array('course_id' => $course_id));
				$academy_id = $courses[0]->academy_id;
				$courses_students = $this->base->get_data('courses_students', '*', array('student_nc' => $national_code, 'course_id' => $course_id));
//            $academy = $this->get_join->get_data('students', 'academys_option', 'students.academy_id=academys_option.academy_id', null, null, array('students.national_code' => $national_code, 'students.academy_id' => $academy_id, 'academys_option.academy_id' => $academy_id));
				if (!empty($courses_students)) {
					$result['response'] = (string) 1;
					$result['entity'] = 'true';
					$result['type'] = (string) 3;
					$result['mesg'] = "شما قبلا در این دوره ثبت نام شده اید";
				} else {
					$count = 0;
					foreach ($students as $std):
						if ($std->academy_id == $academy_id)
							$count ++;
					endforeach;
					if ($count > 0) {
						// فقط ثبت نام در دوره
						// ################################################################
						$insert_array['academy_id'] = $academy_id;
						$insert_array['course_id'] = $course_id;
						$insert_array['lesson_id'] = $courses[0]->lesson_id;
						$insert_array['student_nc'] = $national_code;
						if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
							$insert_array['course_cost'] = (int) 0;
						} else {
							$insert_array['course_cost'] = $courses[0]->course_tuition;
						}
						if ($courses[0]->type_course == '0') {
							if ($courses[0]->type_pay == '0') {
								$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
								// update financial_amount (employer) in table financial_situation_employer
								$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
								$financial_situation_update = array(
									'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
									'final_situation' => 1
								);
								$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
								// end
								// update course_amount in table courses_employers
								$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
								$courses_employers_update = array(
									'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
								);
								$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
								// end
							}
						} elseif ($courses[0]->type_course == '1') {
							if ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '1') {
								$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
								// update financial_amount (employer) in table financial_situation_employer
								$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
								$financial_situation_update = array(
									'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
									'final_situation' => 1
								);
								$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
								// end
								// update course_amount in table courses_employers
								$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
								$courses_employers_update = array(
									'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
								);
								$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
								// end
							}
						}
						// update count_std in table courses
						$cours_amount = $courses[0]->course_tuition;
						$count_std = array(
							'count_std' => $courses[0]->count_std + 1
						);
						// end update count_std

						if ($courses[0]->type_course == '0' || ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')) {
							// std
							$financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
							if ((int) $financial_situation[0]->final_situation == 0 || (int) $financial_situation[0]->final_situation == -1) {
								$amount_update = array(
									'final_amount' => (int) $financial_situation[0]->final_amount + (int) $cours_amount,
									'final_situation' => -1
								);
							} else {
								if ((int) $cours_amount > (int) $financial_situation[0]->final_amount) {
									$amount_update = array(
										'final_amount' => (int) $cours_amount - (int) $financial_situation[0]->final_amount,
										'final_situation' => -1
									);
								} elseif ((int) $cours_amount == (int) $financial_situation[0]->final_amount) {
									$amount_update = array(
										'final_amount' => 0,
										'final_situation' => 0
									);
								} else {
									$amount_update = array(
										'final_amount' => (int) $financial_situation[0]->final_amount - (int) $cours_amount,
										'final_situation' => 1
									);
								}
							}
							$this->base->update('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id), $amount_update);
							// end std
						}

						$this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
						$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

						$this->base->insert('courses_students', $insert_array);
						$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));

						///////////////پیامک\\\\\\\\\\\\\\\
						$lesson_name = $courses[0]->lesson_name;
						$phone_num = $students[0]->phone_num;
						$full_name = $students[0]->first_name . ' ' . $students[0]->last_name;
						$acdm = $academy[0]->academy_display_name . ' ' . $academy[0]->academy_name;
						$name = $academy[0]->student_display_name_2 . " گرامی " . $full_name;
						$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);
						$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
						$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

						$this->base->insert('manager_student_sms', $insertArray);
						/////////////پیامک////////////////

						$result['response'] = (string) 1;
						$result['entity'] = 'true';
						$result['mesg'] = "ثبت نام با موفقیت انجام شد";
						//#################################################################
					} else {
						// ثبت در آموزشگاه جدید و ثبت نام در دوره
						//#################################################################
						$insert_student = array(
							'academy_id' => $academy_id,
							'first_name' => $students[0]->first_name,
							'last_name' => $students[0]->last_name,
							'father_name' => $students[0]->father_name,
							'national_code' => $students[0]->national_code,
							'birthday' => $students[0]->birthday,
							'first_name_en' => $students[0]->first_name_en,
							'last_name_en' => $students[0]->last_name_en,
							'pic_name' => $students[0]->pic_name,
							'phone_num' => $students[0]->phone_num,
							'tell' => $students[0]->tell,
							'province' => $students[0]->province,
							'city' => $students[0]->city,
							'street' => $students[0]->street,
							'postal_code' => $students[0]->postal_code,
							'gender' => $students[0]->gender,
							'marital_status' => $students[0]->marital_status
						);

						// ################################################################
						$insert_array['academy_id'] = $academy_id;
						$insert_array['course_id'] = $course_id;
						$insert_array['lesson_id'] = $courses[0]->lesson_id;
						$insert_array['student_nc'] = $national_code;
						if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
							$insert_array['course_cost'] = (int) 0;
						} else {
							$insert_array['course_cost'] = $courses[0]->course_tuition;
						}
						if ($courses[0]->type_course == '0') {
							if ($courses[0]->type_pay == '0') {
								$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
								// update financial_amount (employer) in table financial_situation_employer
								$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
								$financial_situation_update = array(
									'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
									'final_situation' => 1
								);
								$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
								// end
								// update course_amount in table courses_employers
								$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
								$courses_employers_update = array(
									'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
								);
								$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
								// end
							}
						} elseif ($courses[0]->type_course == '1') {
							if ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '1') {
								$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
								// update financial_amount (employer) in table financial_situation_employer
								$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
								$financial_situation_update = array(
									'final_amount' => (int) $financial_situation_emp[0]->final_amount + (int) $amount,
									'final_situation' => 1
								);
								$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
								// end
								// update course_amount in table courses_employers
								$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
								$courses_employers_update = array(
									'course_amount' => (int) $courses_employers[0]->course_amount + (int) $amount
								);
								$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
								// end
							}
						}
						// update count_std in table courses
						$cours_amount = $courses[0]->course_tuition;
						$count_std = array(
							'count_std' => $courses[0]->count_std + 1
						);
						// end update count_std
						// std
						// insert student in table financial_situation
						$insert_financial_situation = array(
							'academy_id' => $academy_id,
							'student_nc' => $students[0]->national_code,
						);
						$last_id = $this->base->insert('financial_situation', $insert_financial_situation);
						// end insert student

						if ($courses[0]->type_course == '0' || ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')) {
							$financial_situation = $this->base->get_data('financial_situation', '*', array('financial_situation_id' => $last_id));
							if ((int) $financial_situation[0]->final_situation == 0 || (int) $financial_situation[0]->final_situation == -1) {
								$amount_update = array(
									'final_amount' => (int) $financial_situation[0]->final_amount + (int) $cours_amount,
									'final_situation' => -1
								);
							} else {
								if ((int) $cours_amount > (int) $financial_situation[0]->final_amount) {
									$amount_update = array(
										'final_amount' => (int) $cours_amount - (int) $financial_situation[0]->final_amount,
										'final_situation' => -1
									);
								} elseif ((int) $cours_amount == (int) $financial_situation[0]->final_amount) {
									$amount_update = array(
										'final_amount' => 0,
										'final_situation' => 0
									);
								} else {
									$amount_update = array(
										'final_amount' => (int) $financial_situation[0]->final_amount - (int) $cours_amount,
										'final_situation' => 1
									);
								}
							}
							$this->base->update('financial_situation', array('financial_situation_id' => $last_id), $amount_update);
							// end std
						}

						$this->base->insert('students', $insert_student);
						$this->base->insert('courses_students', $insert_array);

						$this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
						$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

						$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
						$this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academy[0]->number_of_student + 1));

						/////////////////پیامک\\\\\\\\\\\\\\\
						$lesson_name = $courses[0]->lesson_name;
						$phone_num = $students[0]->phone_num;
						$full_name = $students[0]->first_name . ' ' . $students[0]->last_name;
						$acdm = $academy[0]->academy_display_name . ' ' . $academy[0]->academy_name;
						$name = $academy[0]->student_display_name_2 . " گرامی " . $full_name;
						$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);

						$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
						$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

						$this->base->insert('manager_student_sms', $insertArray);
						/////////////////پیامک////////////////

						$result['response'] = (string) 1;
						$result['entity'] = 'true';
						$result['mesg'] = "ثبت نام با موفقیت انجام شد";
						//#################################################################
					}
				}
			} elseif($type == '1' || $type == '2') {

				if(isset($user_var['user_Otp']) && !empty($user_var['user_Otp'])){

				$user_Otp = $user_var['user_Otp'];
				$save_otp = $this->base->get_data('save_otp', '*', array('national_code' => $national_code));

				//  زمانی که فرد در سامانه ثبت شده ولی لاگین نیست
				if ($type == '1') {

					if (!empty($save_otp)) {
						$Otp = $save_otp[0]->otp;
					} else {
						$Otp = '1';
					}

					if ($user_Otp == $Otp) {

						// course details
						$courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id = lessons.lesson_id', null, null, array('course_id' => $course_id));
						$academy_id = $courses[0]->academy_id;
						$courses_students = $this->base->get_data('courses_students', '*', array('student_nc' => $national_code, 'course_id' => $course_id));
//            $academy = $this->get_join->get_data('students', 'academys_option', 'students.academy_id=academys_option.academy_id', null, null, array('students.national_code' => $national_code, 'students.academy_id' => $academy_id, 'academys_option.academy_id' => $academy_id));
						if (!empty($courses_students)) {
							$result['response'] = (string)1;
							$result['entity'] = 'true';
							$result['type'] = (string)1;
							$result['mesg'] = "شما قبلا در این دوره ثبت نام شده اید";
						} else {
							$count = 0;
							foreach ($students as $std):
								if ($std->academy_id == $academy_id)
									$count++;
							endforeach;
							if ($count > 0) {
								// فقط ثبت نام در دوره
								// ################################################################
								$insert_array['academy_id'] = $academy_id;
								$insert_array['course_id'] = $course_id;
								$insert_array['lesson_id'] = $courses[0]->lesson_id;
								$insert_array['student_nc'] = $national_code;
								if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
									$insert_array['course_cost'] = (int)0;
								} else {
									$insert_array['course_cost'] = $courses[0]->course_tuition;
								}
								if ($courses[0]->type_course == '0') {
									if ($courses[0]->type_pay == '0') {
										$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
										// update financial_amount (employer) in table financial_situation_employer
										$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
										$financial_situation_update = array(
											'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
											'final_situation' => 1
										);
										$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
										// end
										// update course_amount in table courses_employers
										$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
										$courses_employers_update = array(
											'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
										);
										$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
										// end
									}
								} elseif ($courses[0]->type_course == '1') {
									if ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '1') {
										$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
										// update financial_amount (employer) in table financial_situation_employer
										$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
										$financial_situation_update = array(
											'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
											'final_situation' => 1
										);
										$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
										// end
										// update course_amount in table courses_employers
										$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
										$courses_employers_update = array(
											'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
										);
										$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
										// end
									}
								}
								// update count_std in table courses
								$cours_amount = $courses[0]->course_tuition;
								$count_std = array(
									'count_std' => $courses[0]->count_std + 1
								);
								// end update count_std

								if ($courses[0]->type_course == '0' || ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')) {
									// std
									$financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
									if ((int)$financial_situation[0]->final_situation == 0 || (int)$financial_situation[0]->final_situation == -1) {
										$amount_update = array(
											'final_amount' => (int)$financial_situation[0]->final_amount + (int)$cours_amount,
											'final_situation' => -1
										);
									} else {
										if ((int)$cours_amount > (int)$financial_situation[0]->final_amount) {
											$amount_update = array(
												'final_amount' => (int)$cours_amount - (int)$financial_situation[0]->final_amount,
												'final_situation' => -1
											);
										} elseif ((int)$cours_amount == (int)$financial_situation[0]->final_amount) {
											$amount_update = array(
												'final_amount' => 0,
												'final_situation' => 0
											);
										} else {
											$amount_update = array(
												'final_amount' => (int)$financial_situation[0]->final_amount - (int)$cours_amount,
												'final_situation' => 1
											);
										}
									}
									$this->base->update('financial_situation', array('student_nc' => $national_code, 'academy_id' => $academy_id), $amount_update);
									// end std
								}

								$this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
								$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

								$this->base->insert('courses_students', $insert_array);
								$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));

								///////////////پیامک\\\\\\\\\\\\\\\
								$lesson_name = $courses[0]->lesson_name;
								$phone_num = $students[0]->phone_num;
								$full_name = $students[0]->first_name . ' ' . $students[0]->last_name;
								$acdm = $academy[0]->academy_display_name . ' ' . $academy[0]->academy_name;
								$name = $academy[0]->student_display_name_2 . " گرامی " . $full_name;
								$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);
								$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
								$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

								$this->base->insert('manager_student_sms', $insertArray);
								/////////////پیامک////////////////

								$result['response'] = (string)1;
								$result['entity'] = 'true';
								$result['mesg'] = "ثبت نام با موفقیت انجام شد";
								//#################################################################
							} else {
								// ثبت در آموزشگاه جدید و ثبت نام در دوره
								//#################################################################
								$insert_student = array(
									'academy_id' => $academy_id,
									'first_name' => $students[0]->first_name,
									'last_name' => $students[0]->last_name,
									'father_name' => $students[0]->father_name,
									'national_code' => $students[0]->national_code,
									'birthday' => $students[0]->birthday,
									'first_name_en' => $students[0]->first_name_en,
									'last_name_en' => $students[0]->last_name_en,
									'pic_name' => $students[0]->pic_name,
									'phone_num' => $students[0]->phone_num,
									'tell' => $students[0]->tell,
									'province' => $students[0]->province,
									'city' => $students[0]->city,
									'street' => $students[0]->street,
									'postal_code' => $students[0]->postal_code,
									'gender' => $students[0]->gender,
									'marital_status' => $students[0]->marital_status
								);

								// ################################################################
								$insert_array['academy_id'] = $academy_id;
								$insert_array['course_id'] = $course_id;
								$insert_array['lesson_id'] = $courses[0]->lesson_id;
								$insert_array['student_nc'] = $national_code;
								if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
									$insert_array['course_cost'] = (int)0;
								} else {
									$insert_array['course_cost'] = $courses[0]->course_tuition;
								}
								if ($courses[0]->type_course == '0') {
									if ($courses[0]->type_pay == '0') {
										$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
										// update financial_amount (employer) in table financial_situation_employer
										$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
										$financial_situation_update = array(
											'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
											'final_situation' => 1
										);
										$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
										// end
										// update course_amount in table courses_employers
										$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
										$courses_employers_update = array(
											'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
										);
										$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
										// end
									}
								} elseif ($courses[0]->type_course == '1') {
									if ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '1') {
										$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
										// update financial_amount (employer) in table financial_situation_employer
										$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
										$financial_situation_update = array(
											'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
											'final_situation' => 1
										);
										$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
										// end
										// update course_amount in table courses_employers
										$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
										$courses_employers_update = array(
											'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
										);
										$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
										// end
									}
								}
								// update count_std in table courses
								$cours_amount = $courses[0]->course_tuition;
								$count_std = array(
									'count_std' => $courses[0]->count_std + 1
								);
								// end update count_std
								// std
								// insert student in table financial_situation
								$insert_financial_situation = array(
									'academy_id' => $academy_id,
									'student_nc' => $students[0]->national_code,
								);
								$last_id = $this->base->insert('financial_situation', $insert_financial_situation);
								// end insert student

								if ($courses[0]->type_course == '0' || ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')) {
									$financial_situation = $this->base->get_data('financial_situation', '*', array('financial_situation_id' => $last_id));
									if ((int)$financial_situation[0]->final_situation == 0 || (int)$financial_situation[0]->final_situation == -1) {
										$amount_update = array(
											'final_amount' => (int)$financial_situation[0]->final_amount + (int)$cours_amount,
											'final_situation' => -1
										);
									} else {
										if ((int)$cours_amount > (int)$financial_situation[0]->final_amount) {
											$amount_update = array(
												'final_amount' => (int)$cours_amount - (int)$financial_situation[0]->final_amount,
												'final_situation' => -1
											);
										} elseif ((int)$cours_amount == (int)$financial_situation[0]->final_amount) {
											$amount_update = array(
												'final_amount' => 0,
												'final_situation' => 0
											);
										} else {
											$amount_update = array(
												'final_amount' => (int)$financial_situation[0]->final_amount - (int)$cours_amount,
												'final_situation' => 1
											);
										}
									}
									$this->base->update('financial_situation', array('financial_situation_id' => $last_id), $amount_update);
									// end std
								}

								$this->base->insert('students', $insert_student);
								$this->base->insert('courses_students', $insert_array);

								$this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
								$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

								$academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
								$this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academy[0]->number_of_student + 1));

								/////////////////پیامک\\\\\\\\\\\\\\\
								$lesson_name = $courses[0]->lesson_name;
								$phone_num = $students[0]->phone_num;
								$full_name = $students[0]->first_name . ' ' . $students[0]->last_name;
								$acdm = $academy[0]->academy_display_name . ' ' . $academy[0]->academy_name;
								$name = $academy[0]->student_display_name_2 . " گرامی " . $full_name;
								$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);

								$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
								$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

								$this->base->insert('manager_student_sms', $insertArray);
								/////////////////پیامک////////////////

								$result['response'] = (string)1;
								$result['entity'] = 'true';
								$result['mesg'] = "ثبت نام با موفقیت انجام شد";
								//#################################################################
							}
						}
					} else {
						$result['response'] = (string)0;
						$result['mesg'] = $Otp;
					}

					//  زمانی که فرد در سامانه ثبت نشده باشد
				} elseif ($type == '2') {

					if (!empty($save_otp)) {
						$Otp = $save_otp[0]->otp;
					} else {
						$Otp = '1';
					}

					if ($user_Otp == $Otp) {

						if (isset($user_var['first_name']) && !empty($user_var['first_name']) &&
							isset($user_var['last_name']) && !empty($user_var['last_name']) &&
							isset($user_var['father_name']) && !empty($user_var['father_name']) &&
							isset($user_var['birthday']) && !empty($user_var['birthday']) &&
							isset($user_var['phone_num']) && !empty($user_var['phone_num'])) {

							$first_name = $user_var['first_name'];
							$last_name = $user_var['last_name'];
							$father_name = $user_var['father_name'];
							$birthday = $user_var['birthday'];
							$phone_num = $user_var['phone_num'];

							// course details
							$courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id=lessons.lesson_id', 'academys_option', 'academys_option.academy_id=courses.academy_id', array('course_id' => $course_id));
							$academy_id = $courses[0]->academy_id;
							$insert_student = array(
								'academy_id' => $academy_id,
								'first_name' => $first_name,
								'last_name' => $last_name,
								'father_name' => $father_name,
								'national_code' => $national_code,
								'birthday' => $birthday,
								'phone_num' => $phone_num,
                                'pic_name' => 'student-icon.png'
							);

							$insert_array['academy_id'] = $academy_id;
							$insert_array['course_id'] = $course_id;
							$insert_array['lesson_id'] = $courses[0]->lesson_id;
							$insert_array['student_nc'] = $national_code;
							if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
								$insert_array['course_cost'] = (int)0;
							} else {
								$insert_array['course_cost'] = $courses[0]->course_tuition;
							}
							if ($courses[0]->type_course == '0') {
								if ($courses[0]->type_pay == '0') {
									$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
									// update financial_amount (employer) in table financial_situation_employer
									$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
									$financial_situation_update = array(
										'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
										'final_situation' => 1
									);
									$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
									// end
									// update course_amount in table courses_employers
									$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
									$courses_employers_update = array(
										'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
									);
									$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
									// end
								}
							} elseif ($courses[0]->type_course == '1') {
								if ($courses[0]->type_pay == '0' && $courses[0]->type_tuition == '1') {
									$amount = ($courses[0]->course_tuition * $courses[0]->value_pay) / 100;
									// update financial_amount (employer) in table financial_situation_employer
									$financial_situation_emp = $this->base->get_data('financial_situation_employer', '*', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id));
									$financial_situation_update = array(
										'final_amount' => (int)$financial_situation_emp[0]->final_amount + (int)$amount,
										'final_situation' => 1
									);
									$this->base->update('financial_situation_employer', array('employee_nc' => $courses[0]->course_master, 'academy_id' => $academy_id), $financial_situation_update);
									// end
									// update course_amount in table courses_employers
									$courses_employers = $this->base->get_data('courses_employers', '*', array('course_id' => $course_id));
									$courses_employers_update = array(
										'course_amount' => (int)$courses_employers[0]->course_amount + (int)$amount
									);
									$this->base->update('courses_employers', array('course_id' => $course_id), $courses_employers_update);
									// end
								}
							}
							// update count_std in table courses
							$cours_amount = $courses[0]->course_tuition;
							$count_std = array(
								'count_std' => $courses[0]->count_std + 1
							);
							// end update count_std
							// std
							// insert student in table financial_situation
							$insert_financial_situation = array(
								'academy_id' => $academy_id,
								'student_nc' => $national_code,
							);
							$last_id = $this->base->insert('financial_situation', $insert_financial_situation);
							// end insert student

							if ($courses[0]->type_course == '0' || ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '1')) {
								$financial_situation = $this->base->get_data('financial_situation', '*', array('financial_situation_id' => $last_id));
								if ((int)$financial_situation[0]->final_situation == 0 || (int)$financial_situation[0]->final_situation == -1) {
									$amount_update = array(
										'final_amount' => (int)$financial_situation[0]->final_amount + (int)$cours_amount,
										'final_situation' => -1
									);
								} else {
									if ((int)$cours_amount > (int)$financial_situation[0]->final_amount) {
										$amount_update = array(
											'final_amount' => (int)$cours_amount - (int)$financial_situation[0]->final_amount,
											'final_situation' => -1
										);
									} elseif ((int)$cours_amount == (int)$financial_situation[0]->final_amount) {
										$amount_update = array(
											'final_amount' => 0,
											'final_situation' => 0
										);
									} else {
										$amount_update = array(
											'final_amount' => (int)$financial_situation[0]->final_amount - (int)$cours_amount,
											'final_situation' => 1
										);
									}
								}
								$this->base->update('financial_situation', array('financial_situation_id' => $last_id), $amount_update);
								// end std
							}

							$this->base->insert('students', $insert_student);
							$this->base->insert('courses_students', $insert_array);

							$this->base->update('students', array('national_code' => $national_code, 'academy_id' => $academy_id), array('student_status' => 1));
							$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

							$academys_option = $this->base->get_data('academys_option', 'number_of_student', array('academy_id' => $academy_id));
							$this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academys_option[0]->number_of_student + 1));

							/////////////////پیامک\\\\\\\\\\\\\\\
							$lesson_name = $courses[0]->lesson_name;
							$full_name = $first_name . ' ' . $last_name;
							$acdm = $courses[0]->academy_display_name . ' ' . $courses[0]->academy_name;
							$name = $courses[0]->student_display_name_2 . " گرامی " . $full_name;
							$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);
							$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
							$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

							$this->base->insert('manager_student_sms', $insertArray);
							/////////////////پیامک////////////////

							$result['response'] = (string)1;
							$result['entity'] = 'true';
							$result['mesg'] = "ثبت نام با موفقیت انجام شد";
						} else {
							$result['response'] = (string)0;
							$result['mesg'] = "خطای نقص ورودی در type=2";
						}
					} else {
						$result['response'] = (string)0;
						$result['mesg'] = $Otp;
					}
				}
			}else {
				$result['response'] = (string)0;
				$result['mesg'] = "خطای نقص ورودی(کد تاییدیه)";
			}
			}
		} else {
			$result['response'] = (string) 0;
			$result['mesg'] = 'خطای نقص ورودی';
		}
		echo json_encode($result);
	}
	///////////////////   \\\\\\\\\\\\\\\\\\\\\\

    public function smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm) {
        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
        $pattern_code = "o6m2t2ijji";
        $to = array($phone_num);
        $input_data = array(
            "name" => "$name",
            "cource" => $lesson_name,
            "academy" => "$acdm"
        );
        $url = "https://panel.mediana.ir/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $verify_code = curl_exec($handler);
    }

    public function announcements()
    {
        $user_var = file_get_contents('php://input');
        $user_var = json_decode($user_var, 1);
        if (isset($user_var['city_name']) && !empty($user_var['city_name'])) {

			$city_name = $user_var['city_name'];
            $result['response'] = (string)1;
            $result['mesg'] = "اطلاعات خود را وارد کنید";
            $announcements['title'] = 'پیشنهاد ویژه آموزکده در ایام کرونایی';
            $announcements['announcement'] = 'آموزکده درنظر دارد در جهت';
            $result['announcements'][] = $announcements;
        }else{
            $result['response'] = (string)0;
            $result['mesg'] = "خطای نقص ورودی";
        }
        echo json_encode($result);
    }


	///////////////////////     API web online     \\\\\\\\\\\\\\\\\

//	public function create()
//	{
//		try {
//			$data = getRequest();
//
//			$bbb = new BigBlueButton();
//			$createMeetingParams = new CreateMeetingParameters($data->meeting_id, $data->meeting_name);
//			$createMeetingParams->setAttendeePassword($data->attendee_password);
//			$createMeetingParams->setModeratorPassword($data->moderator_password);
//
//			if (isset($data->is_recording)) {
//				$createMeetingParams->setRecord(true);
//				$createMeetingParams->setAllowStartStopRecording(true);
//				$createMeetingParams->setAutoStartRecording(true);
//			}
//
//			$response = $bbb->createMeeting($createMeetingParams);
//
//			if ($response->getReturnCode() == 'FAILED') {
//				return 'Can\'t create room! please contact our administrator.';
//			} else {
//				echo('<pre>');
//				print_r($response);
//				echo('</pre>');
//			}
//		} catch (\Exception $e) {
//			return show_error('Internal error '.$e, 500);
//		}
//	}
}

