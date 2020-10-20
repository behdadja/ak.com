<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['/student'] = 'main';

$route['login-page'] = 'auth/show_login_page';
$route['login'] = 'auth/login_process';
$route['logout'] = 'auth/logout';

$route['profile'] = 'profile/show_profile';
$route['profile/reply-ticket'] = 'profile/reply_ticket';
$route['profile/change-phone-number'] = 'profile/change_phone_number';
$route['edit-student-profile']='profile/edit_student_profile';
$route['update-student-profile']='profile/update_student_profile';
$route['student-update-pic'] = 'profile/student_update_pic';

$route['courses/error-403'] = 'courses/error_403';
$route['courses/my-courses'] = 'courses/my_courses';
$route['courses/list-of-courses'] = 'courses/list_of_courses';
$route['courses/enroll-course'] = 'courses/enroll_course';

$route['exams/error-403'] = 'exams/error_403';
$route['exams/my-exams'] = 'exams/my_exams';
$route['exams/my-online-exams'] = 'exams/my_online_exams';
$route['exams/start-online-exam'] = 'exams/start_online_exam';
$route['exams/correction-of-exam'] = 'exams/correction_of_exam';
$route['exams/result-of-online-exams'] = 'exams/result_of_online_exams';
$route['exams/result-view'] = 'exams/result_view';

$route['financialst/error-403'] = 'financialst/error_403';
$route['financialst/finst-inquiry'] = 'financialst/finst_inquiry';
$route['financialst/pay'] = 'financialst/online_payment';

$route['tickets/manager-tickets'] = 'tickets/manager_tickets';
$route['tickets/info-manager-tickets/(:any)'] = 'tickets/info_manager_tickets/$1';
$route['tickets/answer-manager-tickets'] = 'tickets/answer_manager_tickets';
$route['tickets/employee-tickets'] = 'tickets/employee_tickets';
$route['tickets/info-employee-tickets/(:any)'] = 'tickets/info_employee_tickets/$1';
$route['tickets/answer-employee-tickets'] = 'tickets/answer_employee_tickets';
$route['tickets/to-employee'] = 'tickets/to_employee';
$route['tickets/send-to-employee'] = 'tickets/send_to_employee';
$route['tickets/to-manager'] = 'tickets/to_manager';
$route['tickets/send-to-manager'] = 'tickets/send_to_manager';


$route['test'] = 'BBB/join_student';
