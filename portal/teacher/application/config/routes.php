<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = 'main/error_403';
$route['translate_uri_dashes'] = FALSE;
$route['/teacher'] = 'main';


$route['login-page'] = 'auth/show_login_page';
$route['login'] = 'auth/login_process';
$route['logout'] = 'auth/logout';

$route['profile'] = 'profile/show_profile';
$route['profile/reply-ticket'] = 'profile/reply_ticket';
$route['profile/change-phone-number'] = 'profile/change_phone_number';
$route['edit-teacher-profile']='profile/edit_teacher_profile';
$route['update-teacher-profile']='profile/update_teacher_profile';
$route['teacher-update-pic'] = 'profile/teacher_update_pic';

$route['courses/error-403'] = 'courses/error_403';
$route['courses/my-courses'] = 'courses/my_courses';
$route['courses/insert-new-meeting/(:num)/(:any)'] = 'courses/insert_new_meeting/$1/$2';
$route['courses/list-of-courses'] = 'courses/list_of_courses';
$route['courses/enroll-course'] = 'courses/enroll_course';
$route['courses/ufile-awareness'] = 'courses/ufile_awareness';
$route['courses/detail/(:num)/(:any)'] = 'courses/detail/$1';

$route['exams/error-403'] = 'exams/error_403';
$route['exams/sub-question'] = 'exams/sub_question';
$route['exams/insert-question'] = 'exams/insert_question';
$route['exams/definition'] = 'exams/definition';
$route['exams/create-exam'] = 'exams/create_exam';
$route['exams/my-questions'] = 'exams/my_questions';
$route['exams/edit-question/(:num)/(:any)'] = 'exams/edit_question/$1';
$route['exams/update-question'] = 'exams/update_question';

$route['financialem/error-403'] = 'financialem/error_403';
$route['financialem/finst-inquiry'] = 'financialem/finst_inquiry';
$route['financialem/financial-situation'] = 'financialem/financial_situation';

$route['tickets/manager-tickets'] = 'tickets/manager_tickets';
$route['tickets/info-manager-tickets/(:any)'] = 'tickets/info_manager_tickets/$1';
$route['tickets/answer-manager-tickets'] = 'tickets/answer_manager_tickets';
$route['tickets/to-student'] = 'tickets/to_student';
$route['tickets/send-to-student'] = 'tickets/send_to_student';
$route['tickets/student-tickets'] = 'tickets/student_tickets';
$route['tickets/info-student-tickets/(:any)'] = 'tickets/info_student_tickets/$1';
$route['tickets/answer-student-tickets'] = 'tickets/answer_student_tickets';
$route['tickets/to-manager'] = 'tickets/to_manager';
$route['tickets/send-to-manager'] = 'tickets/send_to_manager';

//$route['tickets/leave-ticket'] = 'tickets/leave_ticket';
//$route['tickets/sending-request'] = 'tickets/sending_request';
//$route['tickets/all-leave-tickets-status'] = 'tickets/all_leave_tickets_status';

$route['awareness/errors/403'] = 'awareness/error_403';
$route['awareness/existing-courses'] = 'awareness/courses_to_send_ufile';
$route['awareness/ufile-awareness'] = 'awareness/ufile_awareness';


$route['test'] = 'BBB/create_join_meeting';
