<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
//        $this->load->view('templates/navbar');
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function course_detail($academy_id, $course_id) {
        $contentData['course'] = $this->get_join->get_data4('courses', 'lessons', 'lessons.lesson_id=courses.lesson_id', 'employers', 'employers.national_code=courses.course_master', 'academys_option', 'academys_option.academy_id=courses.academy_id', array('courses.course_id' => $course_id, 'courses.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'employers.academy_id' => $academy_id));
        $contentData['yield'] = 'course-detail';
        $headerData['secondLinks'] = 'persian-calendar-links';
        $footerData['secondScripts'] = 'persian-calendar-scripts';
        $this->show_pages('دوره ها', 'content', $contentData, $headerData, $footerData);
    }

    ////////////////////////////// Student authentication \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function student_authentication() {
        $course_id = $this->input->post('course_id', true);
        $academy_id = $this->input->post('academy_id', true);
		$type = $this->input->post('type');

		if(isset($type) && !empty($type)) {
			$national_code = $this->session->userdata('session_id');
			$courses_students = $this->base->get_data('courses_students', '*', array('student_nc' => $national_code, 'course_id' => $course_id));
			if (!empty($courses_students)) {
				$this->session->set_flashdata('pre-registered', 'شما قبلا در این دوره ثبت نام شده اید.');
			} else {
				$user_data['data'] = array(
					'type' => '1',
					'course_id' => $course_id,
					'academy_id' => $academy_id,
					'user_nc' => $national_code
				);
				$this->session->set_userdata($user_data);
				$this->course_registration();
				$user_data['data'] = array(
					'type',
					'course_id',
					'academy_id',
					'user_nc'
				);
				$this->session->unset_userdata($user_data);
				$this->session->set_flashdata('registration-completed', 'ثبت نام با موفقیت انجام شد.');
                redirect('skyroom_std/' . $academy_id . '/' . $course_id);
			}
			redirect('course-detail/' . $academy_id . '/' . $course_id);
		}else {
			$this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|min_length[10]|numeric');
			$this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|min_length[11]|numeric');
			$this->form_validation->set_message('required', '%s را وارد نمایید');
			$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
			$this->form_validation->set_message('min_length', 'طول %s معتبر نیست');
			$this->form_validation->set_message('numeric', '%s معتبر نیست');

			if ($this->form_validation->run() === TRUE) {

				// search in all academys
				$national_code = $this->input->post('national_code', true);

				$phone_num = $this->input->post('phone_num', true);

				$students = $this->base->get_data('students', '*', array('national_code' => $national_code));
				$rand = rand(1000, 9999);

				if (empty($students)) {
					$user_data['data'] = array(
						'type' => '3',
						'user_nc' => $national_code,
						'phone_num' => $phone_num,
						'course_id' => $course_id,
						'academy_id' => $academy_id,
						'otp' => $rand
					);
				    $this->send_otp($phone_num, $rand);
					$this->session->set_flashdata('authentication', 'کد دریافتی را وارد کنید');
					$this->session->set_userdata($user_data);
					redirect('course-detail/' . $academy_id . '/' . $course_id);
				} else {
					if ($students[0]->phone_num == $phone_num) {
						$courses_students = $this->base->get_data('courses_students', '*', array('student_nc' => $national_code, 'course_id' => $course_id, 'academy_id'=>$academy_id));
						if (!empty($courses_students)) {
							$this->session->set_flashdata('pre-registered', 'شما قبلا در این دوره ثبت نام شده اید.');
							redirect('course-detail/' . $academy_id . '/' . $course_id);
						} else {
							$user_data['data'] = array(
								'type' => '1',
								'user_nc' => $national_code,
								'phone_num' => $phone_num,
								'course_id' => $course_id,
								'academy_id' => $academy_id,
								'otp' => $rand
							);
						$this->send_otp($phone_num, $rand);
							$this->session->set_flashdata('authentication', 'کد دریافتی را وارد کنید');
							$this->session->set_userdata($user_data);
							redirect('course-detail/' . $academy_id . '/' . $course_id);
						}
					} else {
						$old_phone_num = substr($students[0]->phone_num, 0, 4) . ' *** *' . substr($students[0]->phone_num, 8, 3);
						$this->session->set_flashdata(array('pre-registered' => 'ok', 'notExistPhoneNum' => $old_phone_num));
						redirect('course-detail/' . $academy_id . '/' . $course_id);
					}
				}
			} else {
				$this->session->set_flashdata('national-code', validation_errors());
				redirect('course-detail/' . $academy_id . '/' . $course_id);
			}
		}
    }

	public function resend_otp() {
		$phone_num = $this->session->userdata('data')['phone_num'];
		$course_id = $this->session->userdata('data')['course_id'];
		$academy_id = $this->session->userdata('data')['academy_id'];
		$rand = rand(1000, 9999);

		$this->send_otp($phone_num, $rand);

		$user_data['data'] = array_replace($this->session->userdata('data'), array('otp' => $rand));
		$this->session->set_userdata($user_data);

		$this->session->set_flashdata('authentication', 'کد دریافتی را وارد کنید');
		redirect('course-detail/' . $academy_id . '/' . $course_id);
	}

	public function user_authentication() {
		$course_id = $this->session->userdata('data')['course_id'];
		$academy_id = $this->session->userdata('data')['academy_id'];

		$this->form_validation->set_rules('user_otp', 'کد تاییدیه', 'required|exact_length[4]|numeric');
		$this->form_validation->set_message('required', '%s را وارد نمایید');
		$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
		$this->form_validation->set_message('numeric', '%s معتبر نیست');

		if ($this->form_validation->run() === TRUE) {
			$user_otp = $this->input->post('user_otp', true);
			$type = $this->session->userdata('data')['type'];
			$otp = $this->session->userdata('data')['otp'];

			if ($otp == $user_otp) {

				if($type == '1'){
					$this->course_registration();
					$user_data['data'] = array(
						'type',
						'user_nc',
						'phone_num',
						'course_id',
						'academy_id',
						'otp'
					);
					$this->session->unset_userdata($user_data);
					$this->session->set_flashdata('registration-completed', 'ثبت نام با موفقیت انجام شد.');
				}elseif ($type == '3'){
					$this->session->set_flashdata('get-user-information','ok');
				}
			} else {
				$this->session->set_flashdata('error-otp', 'کد وارد شده صحیح نیست.');
			}
		} else {
			$this->session->set_flashdata('error-otp', validation_errors());
		}
		redirect('course-detail/' . $academy_id . '/' . $course_id);
	}


	// type = 1    زمانی که کاربر لاگین باشد
	// type = 2    زمانی که کاربر در یکی از آموزشگاه های موجود در سامانه ثبت شده باشد
	// type = 3    زمانی که کاربر در سامانه وجود نداشته باشد

    public function course_registration() {
    	$type = $this->session->userdata('data')['type'];
		$course_id = $this->session->userdata('data')['course_id'];
		$academy_id = $this->session->userdata('data')['academy_id'];
		$national_code = $this->session->userdata('data')['user_nc'];
        $this->session->set_userdata(array('national_code' => $national_code));

        if ($type == '1' || $type == '2') {

            $students = $this->base->get_data('students', '*', array('national_code' => $national_code));
            $courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id = lessons.lesson_id', null, null, array('courses.course_id' => $course_id, 'courses.academy_id'=>$academy_id, 'lessons.academy_id'=>$academy_id));

                $count = 0;
                foreach ($students as $std):
                    if ($std->academy_id === $academy_id)
                        $count ++;
                endforeach;
                if ($count > 0) {
                    // فقط ثبت نام در دوره
                    // ################################################################
                    $insert_array['academy_id'] = $academy_id;
                    $insert_array['course_id'] = $course_id;
                    $insert_array['lesson_id'] = $courses[0]->lesson_id;
                    $insert_array['student_nc'] = $national_code;
					$insert_array['reg_site'] = '1';
                    if ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '0') {
                        $insert_array['course_cost'] = (int) 0;
                    } else {
                        $insert_array['course_cost'] = $courses[0]->course_tuition;
                    }
                    if ($courses[0]->type_course === '0') {
                        if ($courses[0]->type_pay === '0') {
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
                    } elseif ($courses[0]->type_course === '1') {
                        if ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '1') {
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
//                    $count_std = array(
//                        'count_std' => $courses[0]->count_std + 1
//                    );
                    // end update count_std

                    if ($courses[0]->type_course === '0' || ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '1')) {
                        // std
                        $financial_situation = $this->base->get_data('financial_situation', '*', array('student_nc' => $national_code, 'academy_id' => $academy_id));
                        if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === -1) {
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
                            } elseif ((int) $cours_amount === (int) $financial_situation[0]->final_amount) {
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
//                    $this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

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

                } else {
                    // ثبت در آموزشگاه جدید و ثبت نام در دوره
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
					$insert_array['reg_site'] = '1';
                    if ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '0') {
                        $insert_array['course_cost'] = (int) 0;
                    } else {
                        $insert_array['course_cost'] = $courses[0]->course_tuition;
                    }
                    if ($courses[0]->type_course === '0') {
                        if ($courses[0]->type_pay === '0') {
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
                    } elseif ($courses[0]->type_course === '1') {
                        if ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '1') {
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
//                    $count_std = array(
//                        'count_std' => $courses[0]->count_std + 1
//                    );
                    // end update count_std
                    // std
                    // insert student in table financial_situation
                    $insert_financial_situation = array(
                        'academy_id' => $academy_id,
                        'student_nc' => $students[0]->national_code,
                    );
                    $last_id = $this->base->insert('financial_situation', $insert_financial_situation);
                    // end insert student
                    if ($courses[0]->type_course === '0' || ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '1')) {

                        $financial_situation = $this->base->get_data('financial_situation', '*', array('financial_situation_id' => $last_id));
                        if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === -1) {
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
                            } elseif ((int) $cours_amount === (int) $financial_situation[0]->final_amount) {
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
//					$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

                    $academy = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
//                    $this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academy[0]->number_of_student + 1));

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
                }
                return true;
        } elseif ($type == '3') {

			$this->form_validation->set_rules('first_name', 'نام', 'required|max_length[40]');
			$this->form_validation->set_rules('last_name', 'نام خانوادگی', 'required|max_length[40]');
			$this->form_validation->set_rules('father_name', 'نام پدر', 'required|max_length[40]');
			$this->form_validation->set_rules('birthday', 'تاریخ تولد', 'required|exact_length[10]');
			$this->form_validation->set_rules('national_code', 'کد ملی', 'required|exact_length[10]|numeric');
			$this->form_validation->set_rules('phone_num', 'شماره همراه', 'required|exact_length[11]|numeric');

			$this->form_validation->set_message('required', '%s را وارد نمایید');
			$this->form_validation->set_message('max_length', 'طول %s معتبر نمی باشد');
			$this->form_validation->set_message('exact_length', 'طول %s معتبر نیست');
			$this->form_validation->set_message('numeric', '%s معتبر نیست');

			if ($this->form_validation->run() === TRUE) {

				$first_name = $this->input->post('first_name', true);
				$last_name = $this->input->post('last_name', true);
				$father_name = $this->input->post('father_name', true);
				$birthday = strtr($this->input->post('birthday', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
				$national_code = $this->session->userdata('data')['user_nc'];
				$phone_num = $this->session->userdata('data')['phone_num'];

				$courses = $this->get_join->get_data('courses', 'lessons', 'courses.lesson_id = lessons.lesson_id',null,null, array('courses.course_id' => $course_id, 'courses.academy_id'=>$academy_id, 'lessons.academy_id'=>$academy_id));

					$insert_student = array(
						'academy_id' => $academy_id,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'father_name' => $father_name,
						'birthday' => $birthday,
						'national_code' => $national_code,
						'phone_num' => $phone_num,
                        'pic_name' => 'student-icon.png'
					);

					// ################################################################
					$insert_array['academy_id'] = $academy_id;
					$insert_array['course_id'] = $course_id;
					$insert_array['lesson_id'] = $courses[0]->lesson_id;
					$insert_array['student_nc'] = $national_code;
					$insert_array['reg_site'] = '1';
					if ($courses[0]->type_course == '1' && $courses[0]->type_tuition == '0') {
						$insert_array['course_cost'] = (int) 0;
					} else {
						$insert_array['course_cost'] = $courses[0]->course_tuition;
					}
					if ($courses[0]->type_course === '0') {
						if ($courses[0]->type_pay === '0') {
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
					} elseif ($courses[0]->type_course === '1') {
						if ($courses[0]->type_pay === '0' && $courses[0]->type_tuition === '1') {
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
//					$count_std = array(
//						'count_std' => $courses[0]->count_std + 1
//					);
					// end update count_std
					// std
					// insert student in table financial_situation
					$insert_financial_situation = array(
						'academy_id' => $academy_id,
						'student_nc' => $national_code
					);

					$last_id = $this->base->insert('financial_situation', $insert_financial_situation);
					// end insert student
					if ($courses[0]->type_course === '0' || ($courses[0]->type_course === '1' && $courses[0]->type_tuition === '1')) {

						$financial_situation = $this->base->get_data('financial_situation', '*', array('financial_situation_id' => $last_id));
						if ((int) $financial_situation[0]->final_situation === 0 || (int) $financial_situation[0]->final_situation === -1) {
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
							} elseif ((int) $cours_amount === (int) $financial_situation[0]->final_amount) {
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
//					$this->base->update('courses', array('course_id' => $course_id, 'academy_id' => $academy_id), $count_std);

					$academys_option = $this->base->get_data('academys_option', '*', array('academy_id' => $academy_id));
//					$this->base->update('academys_option', array('academy_id' => $academy_id), array('number_of_student' => $academys_option[0]->number_of_student + 1));

					/////////////////پیامک\\\\\\\\\\\\\\\
					$lesson_name = $courses[0]->lesson_name;
					$phone_num = $phone_num;
					$full_name = $first_name . ' ' . $last_name;
					$acdm = $academys_option[0]->academy_display_name . ' ' . $academys_option[0]->academy_name;
					$name = $academys_option[0]->student_display_name_2 . " گرامی " . $full_name;
					$this->smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm);

					$message = $name . " ثبت نام شما در دوره" . $lesson_name . " با موفقیت انجام شد.";
					$insertArray = array('mss_body' => $message, 'student_nc' => $national_code, 'academy_id' => $academy_id);

					$this->base->insert('manager_student_sms', $insertArray);
					/////////////////پیامک////////////////

					$user_data['data'] = array(
						'type',
						'user_nc',
						'phone_num',
						'course_id',
						'academy_id',
						'otp'
					);
					$this->session->unset_userdata($user_data);
					$this->session->set_flashdata('registration-completed', 'ثبت نام با موفقیت انجام شد.');
                    redirect('skyroom_std/' . $academy_id . '/' . $course_id);
					redirect('course-detail/' . $academy_id . '/' . $course_id);
			} else {
				$this->session->set_flashdata('error-user-information', validation_errors());
				redirect('course-detail/' . $academy_id . '/' . $course_id);
			}
        }
    }

    public function send_otp($phone_num, $rand) {
        // send OTP
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
        //  End send OTP
    }

    public function smsForCourseRegistration($phone_num, $name, $lesson_name, $acdm) {
        $username = "mehritc";
        $password = '@utabpars1219';
        $from = "+983000505";
        $pattern_code = "o6m2t2ijji";
        $to = array($phone_num);
        $input_data = array(
            "name" => "$name",
            "cource" => "$lesson_name",
            "academy" => "$acdm"
        );
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $verify_code = curl_exec($handler);
    }

}
