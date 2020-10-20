<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = 'main/error_403';
$route['translate_uri_dashes'] = FALSE;
$route['/portal'] = 'main';

$route['login-page'] = 'auth/show_login_page';
$route['login'] = 'auth/login_process';
$route['verify'] = 'auth/verify';
$route['verify-complete'] = 'auth/verify_complete';
$route['logout'] = 'auth/logout';

$route['profile'] = 'profile/show_profile';
$route['wallet']='profile/wallet';
$route['profile/inquiry'] = 'profile/inquiry';
$route['profile/pre-register-st'] = 'profile/pre_register_st';
$route['profile/user-profile'] = 'profile/user_profile';
$route['edit-profile'] = 'profile/edit_profile';
$route['update-profile'] = 'profile/update_profile';
$route['manager-update-pic'] = 'profile/manager_update_pic';
$route['manager-update-logo'] = 'profile/manager_update_logo';
$route['manager-edit-birthday'] = 'profile/manager_edit_birthday';

$route['training/error-403'] = 'training/error_403';
$route['training/create-new-class-page'] = 'training/create_new_class';
$route['training/insert-new-class'] = 'training/insert_new_class';
$route['training/manage-classes'] = 'training/manage_classes';
$route['training/edit-class'] = 'training/edit_class';
$route['training/delete-class'] = 'training/delete_class';
$route['training/update-class'] = 'training/update_class';

$route['new-lesson'] = 'training/create_new_lesson';
$route['refresh-new-lesson'] = 'training/refresh_new_lesson';
$route['training/insert-new-lesson'] = 'training/insert_new_lesson';
$route['training/manage-lessons'] = 'training/manage_lessons';
$route['training/edit-lesson'] = 'training/edit_lesson';
$route['training/delete-lesson'] = 'training/delete_lesson';
$route['training/update-lesson'] = 'training/update_lesson';

$route['default-test'] = 'training/default_test';

$route['training/create-new-course-page'] = 'training/create_new_course';
$route['training/insert-new-course'] = 'training/insert_new_course';
$route['training/manage-courses'] = 'training/manage_courses';
$route['training/manage-course'] = 'training/manage_course'; //force
$route['training/edit-course'] = 'training/edit_course';
$route['training/delete-course'] = 'training/delete_course';
//$route['edit-start-date'] = 'training/edit_start_date';
$route['training/update-course'] = 'training/update_course';
$route['training/insert-wallet'] = 'training/insert_wallet';
$route['training/change-time-meeting'] = 'training/change_time_meeting';
$route['schedule-meetings/(:any)'] = 'training/schedule_meetings/$1';
$route['course-update-pic'] = 'training/course_update_pic';
//$route['show-course-edit-after/(:any)'] = 'training/show_course_edit_after/$1';

$route['users/error-403'] = 'users/error_403';
$route['users/create-new-student-page'] = 'users/create_new_student';
$route['users/insert-new-student'] = 'users/insert_new_student';
$route['users/manage-students'] = 'users/manage_students';
$route['users/edit-student'] = 'users/edit_student';
$route['users/update-student'] = 'users/update_student';
$route['users/create-new-employee-page'] = 'users/create_new_employee';
$route['users/insert-new-employee'] = 'users/insert_new_employee';
$route['users/manage-employers'] = 'users/manage_employers';
$route['users/edit-employee'] = 'users/edit_employee';
$route['users/update-employee'] = 'users/update_employee';
$route['users/create-new-personnel'] = 'users/create_new_personnel';
$route['users/insert-new-personnel'] = 'users/insert_new_personnel';
$route['users/manage-personnels'] = 'users/manage_personnels';
$route['users/edit-personnel'] = 'users/edit_personnel';
$route['users/update-personnel'] = 'users/update_personnel';
$route['users/manage-employers-pay'] = 'users/manage_employers_pay';
$route['users/employer-inquiry'] = 'users/employer_inquiry';
$route['users/edit-course-amount'] = 'users/edit_course_amount';
$route['users/edit-course-cost'] = 'users/edit_course_cost';
$route['student-update-pic'] = 'users/student_update_pic';
$route['teacher-update-pic'] = 'users/teacher_update_pic';
$route['personnel-update-pic'] = 'users/personnel_update_pic';
$route['edit-birthday'] = 'users/edit_birthday';

$route['enrollment/error-403'] = 'enrollment/error_403';
$route['enrollment/course/(:num)/(:any)'] = 'enrollment/course/$1/$2';
$route['enrollment/enroll-course'] = 'enrollment/enroll_course';
$route['enrollment/registration-of-course/(:num)'] = 'enrollment/registration_of_course/$1';
$route['enrollment/registration-of-access'] = 'enrollment/registration_of_access';
$route['enrollment/registration-course-list'] = 'enrollment/registration_course_list';
$route['enrollment/before-reg-exam'] = 'enrollment/before_reg_exam';
$route['enrollment/search-all-student-info'] = 'enrollment/search_student_info';
$route['enrollment/registration-exam'] = 'enrollment/registration_exam';
$route['enrollment/exam/(:num)/(:num)'] = 'enrollment/exam/$1/$2';
$route['enrollment/enroll-exam'] = 'enrollment/enroll_exam';
$route['enrollment/registration-exam-list'] = 'enrollment/registration_exam_list';
$route['enrollment/delete-exam-student'] = 'enrollment/delete_exam_student';
$route['enrollment/delete-course-student'] = 'enrollment/delete_course_student';
$route['enrollment/create-exam'] = 'enrollment/create_exam';
$route['enrollment/all-of-exams'] = 'enrollment/all_of_exams';
$route['enrollment/edit-exam-type'] = 'enrollment/edit_exam_type';
$route['enrollment/update-exam'] = 'enrollment/update_exam';
$route['enrollment/insert-new-exam'] = 'enrollment/insert_new_exam';

$route['enrollment/student-enroll-in-exam'] = 'enrollment/student_enroll_in_exam';
$route['enrollment/student-enroll-written-exam-mark'] = 'enrollment/student_enroll_written_exam_mark';
$route['enrollment/student-enroll-practical-exam-mark'] = 'enrollment/student_enroll_practical_exam_mark';
$route['enrollment/student-enroll-in-practical-alone'] = 'enrollment/student_enroll_in_practical_alone';

$route['financial/error-403'] = 'financial/error_403';
$route['financial/finan-get-student-nc'] = 'financial/finan_get_student_nc';
$route['financial/student-inquiry'] = 'financial/student_inquiry';
$route['financial/student-exam-tuition-pay'] = 'financial/student_exam_tuition_pay';
$route['financial/get-all-exam-tuition'] = 'financial/get_all_exam_tuition';
$route['financial/cash-exam-pay'] = 'financial/cash_exam_pay';
$route['financial/pouse-exam-pay'] = 'financial/pouse_exam_pay';
$route['financial/check-exam-pay'] = 'financial/check_exam_pay';
$route['online_payment']='financial/online_payment';
$route['financial/students-payments']='financial/student_payments';
$route['countOfStd']='financial/countOfStd';

$route['financial/cash-course-pay-em'] = 'financial/cash_course_pay_em';
$route['financial/pouse-course-pay-em'] = 'financial/pouse_course_pay_em';
$route['financial/check-course-pay-em'] = 'financial/checkـcourseـpay_em';

$route['financial/student-course-tuition-pay'] = 'financial/student_course_tuition_pay';
$route['financial/get-all-course-tuition'] = 'financial/get_all_course_tuition';
$route['financial/cash-course-pay'] = 'financial/cash_course_pay';
$route['financial/pouse-course-pay'] = 'financial/pouse_course_pay';
$route['financial/check-course-pay'] = 'financial/check_course_pay';

$route['financial/manage-exams-check'] = 'financial/manage_exams_check';
$route['financial/pass-ckeck'] = 'financial/pass_ckeck';
$route['financial/return-ckeck'] = 'financial/return_ckeck';
$route['financial/manage-courses-check'] = 'financial/manage_courses_check';
$route['reckon_request']='financial/reckon_request';

$route['tickets/error-403'] = 'tickets/error_403';
$route['tickets/to-student'] = 'tickets/to_student';
$route['tickets/send-to-student'] = 'tickets/send_to_student'; // send ticket to student and all students and courses students
$route['tickets/student-tickets'] = 'tickets/student_tickets';
$route['tickets/info-student-tickets/(:any)'] = 'tickets/info_student_tickets/$1';
$route['tickets/answer-student-tickets'] = 'tickets/answer_student_tickets';

$route['tickets/to-employee'] = 'tickets/to_employee';
$route['send-to-employee'] = 'tickets/send_to_employee'; // send ticket to employer and all employers
$route['tickets/employee-tickets'] = 'tickets/employee_tickets';
$route['tickets/info-employee-tickets/(:any)'] = 'tickets/info_employee_tickets/$1';
$route['tickets/answer-employee-tickets'] = 'tickets/answer_employee_tickets';

$route['send-sms-to-student'] = 'tickets/send_sms_to_student'; // send sms to student and all students and courses students
$route['send-sms-to-employee'] = 'tickets/send_sms_to_employee'; // send sms to student and all students

// announcements
$route['send-announcement'] = 'tickets/send_announcement';
$route['insert-announcement'] = 'tickets/insert_announcement';
$route['manage-announcement'] = 'tickets/manage_announcement';
$route['edit-announcement'] = 'tickets/edit_announcement';

//for dropdown in page create new lesson
$route['dropdown/academy/(:any)'] = 'users/getClusterList/$1';
$route['dropdown/cluster/(:any)'] = 'users/getGroupList/$1';
$route['dropdown/group/(:any)'] = 'users/getStandardList/$1';

//$route['dropdown/academy/(:any)'] = 'training/getClusterList/$1';
//$route['dropdown/cluster/(:any)'] = 'training/getGroupList/$1';
//$route['dropdown/group/(:any)'] = 'training/getStandardList/$1';

//$route['course'] = 'welcome/test';
//$route['test-course'] = 'welcome/test_course';
//$route['test-insert'] = 'welcome/test_insert';


//           API APP           \\
$route['api-v1/splash'] ['post'] = 'API_APP/splash';
$route['api-v1/sendOtp'] ['post'] = 'API_APP/send_otp';
$route['api-v1/login'] ['post'] = 'API_APP/login';
$route['api-v1/courses'] ['post'] = 'API_APP/courses';
$route['api-v1/getUserAccount'] ['post'] = 'API_APP/get_user_account';
$route['api-v1/sessions'] ['post'] = 'API_APP/sessions';
$route['api-v1/getAttendanceList'] ['post'] = 'API_APP/get_attendance_list';
$route['api-v1/changePresence'] ['post'] = 'API_APP/change_presence';
$route['api-v1/addSession'] ['post'] = 'API_APP/add_session';
$route['api-v1/teacherFinancialDetail'] ['post'] = 'API_APP/teacher_financial_detail';
$route['api-v1/studentFinancialDetail'] ['post'] = 'API_APP/student_financial_detail';
$route['api-v1/uploadFile'] ['post'] = 'API_APP/upload_file';
$route['api-v1/onlinePayment'] ['post'] = 'API_APP/online_payment';
$route['api-v1/getGeneralInfo'] ['post'] = 'API_APP/get_General_Info';
$route['api-v1/itemDetails'] ['post'] = 'API_APP/item_details';
$route['api-v1/studentAuthentication'] ['post'] = 'API_APP/student_authentication';
$route['api-v1/studentRegisteration'] ['post'] = 'API_APP/student_registration';
$route['api-v1/announcements'] ['post'] = 'API_APP/announcements';

//           API BBB           \\
$route['api-v1/createMeetingByTeacher'] ['post'] = 'API_BBB/create_meeting_by_teacher';
$route['api-v1/joinStudent'] ['post'] = 'API_BBB/join_student';
$route['api-v1/returnToApp'] ['post'] = 'API_BBB/return_to_app';

//           API TICKET           \\
// student
$route['api-v1/std_ListManager']['post'] = 'API_TICKET/std_listManager';
$route['api-v1/std_SendToManager']['post'] = 'API_TICKET/std_sendToManager';
$route['api-v1/std_ManagerTickets']['post'] = 'API_TICKET/std_managerTickets';
$route['api-v1/std_InfoManagerTickets']['post'] = 'API_TICKET/std_infoManagerTickets';
$route['api-v1/std_AnswerToManager']['post'] = 'API_TICKET/std_answerToManager';
$route['api-v1/std_ListTeachers']['post'] = 'API_TICKET/std_listTeachers';
$route['api-v1/std_SendToTeacher']['post'] = 'API_TICKET/std_sendToTeacher';
$route['api-v1/std_TeacherTickets']['post'] = 'API_TICKET/std_teacherTickets';
$route['api-v1/std_InfoTeacherTickets']['post'] = 'API_TICKET/std_infoTeacherTickets';
$route['api-v1/std_AnswerToTeacher']['post'] = 'API_TICKET/std_answerToTeacher';
// teacher
$route['api-v1/emp_ListManager']['post'] = 'API_TICKET/emp_listManager';
$route['api-v1/emp_SendToManager']['post'] = 'API_TICKET/emp_sendToManager';
$route['api-v1/emp_ManagerTickets']['post'] = 'API_TICKET/emp_ManagerTickets';
$route['api-v1/emp_InfoManagerTickets']['post'] = 'API_TICKET/emp_infoManagerTickets';
$route['api-v1/emp_AnswerToManager']['post'] = 'API_TICKET/emp_answerToManager';
$route['api-v1/emp_ListStudents']['post'] = 'API_TICKET/emp_listStudents';
$route['api-v1/emp_SendToStudent']['post'] = 'API_TICKET/emp_sendToStudent';
$route['api-v1/emp_StudentTickets']['post'] = 'API_TICKET/emp_studentTickets';
$route['api-v1/emp_InfoStudentTickets']['post'] = 'API_TICKET/emp_infoStudentTickets';
$route['api-v1/emp_AnswerToStudent']['post'] = 'API_TICKET/emp_answerToStudent';
// manager
$route['api-v1/mng_ListStudents']['post'] = 'API_TICKET/mng_listStudents';
$route['api-v1/mng_SendToStudent']['post'] = 'API_TICKET/mng_sendToStudent';
$route['api-v1/mng_StudentTickets']['post'] = 'API_TICKET/mng_studentTickets';
$route['api-v1/mng_InfoStudentTickets']['post'] = 'API_TICKET/mng_infoStudentTickets';
$route['api-v1/mng_AnswerToStudent']['post'] = 'API_TICKET/mng_answerToStudent';
$route['api-v1/mng_ListTeachers']['post'] = 'API_TICKET/mng_listTeachers';
$route['api-v1/mng_SendToTeacher']['post'] = 'API_TICKET/mng_sendToTeacher';
$route['api-v1/mng_TeacherTickets']['post'] = 'API_TICKET/mng_teacherTickets';
$route['api-v1/mng_InfoTeacherTickets']['post'] = 'API_TICKET/mng_infoTeacherTickets';
$route['api-v1/mng_AnswerToTeacher']['post'] = 'API_TICKET/mng_answerToTeacher';
//API online
$route['api-v1/create'] ['post'] = 'API_APP/create';
// API MANAGER
$route['api-v2/testApi']['post'] = 'API_MANAGER/test_api';


$route['online_classes'] = 'BBB/running_classes';
$route['online'] = 'BBB/joinManager';
$route['class_info'] = 'BBB/more_info';

