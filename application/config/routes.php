<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['error-403'] = 'adminator/error_403';
$route['404_override'] = 'main/error_403';
$route['translate_uri_dashes'] = FALSE;
$route['/'] = 'main';

// Profile Controller
$route['profile'] = 'profile/show_index';

// Courses Controller
$route['course-detail/(:any)/(:num)'] = 'courses/course_detail/$1/$2';
$route['course-registration'] = 'courses/course_registration';
$route['student-authentication'] = 'courses/student_authentication';
$route['completing-course-registration'] = 'courses/completing_course_registration';
$route['user-authentication'] = 'courses/user_authentication';
$route['resend-otp'] = 'courses/resend_otp';

// Admin Controller
$route['admin'] = 'adminator';
$route['manage-academys'] = 'adminator/manage_academy';
$route['edit-academy'] = 'adminator/edit_academy';
$route['update-academy'] = 'adminator/update_academy';
$route['manager-update-pic'] = 'adminator/manager_update_pic';
$route['manager-update-logo'] = 'adminator/manager_update_logo';
$route['activation-academy'] = 'adminator/activation_academy';
$route['online-course'] = 'adminator/online_course';
$route['insert-link-online'] = 'adminator/insert_link_online';
$route['edit-link-online'] = 'adminator/edit_link_online';
$route['manage-teachers'] = 'adminator/manage_teachers';
$route['manage-students'] = 'adminator/manage_students';
$route['numCheck'] = 'adminator/demo_phone_num_request';
$route['isValid'] = 'adminator/validCode';
$route['logout'] = 'adminator/logout';
$route['requests'] = 'adminator/requests';
$route['details-course'] = 'adminator/details_course';
$route['display-status-course-in-system'] = 'adminator/display_status_course_in_system';
$route['admin/running_classes'] = 'BBB/running_classes';
$route['admin/class_info'] = 'BBB/more_info';

// Users Controller
$route['reg_academy'] = 'users/reg_academy';
$route['insert-new-academy'] = 'users/insert_new_academy';
$route['guide'] = 'users/guide';
$route['guide-register'] = 'users/guide_register';
$route['academy/(:any)'] = 'users/academy_details/$1';
$route['about-us'] = 'users/about_us';
$route['contact-us'] = 'users/contact_us';
$route['demo-request'] = 'users/demo_request';
$route['demo-resend-otp'] = 'users/demo_resend_otp';
$route['demo-auth'] = 'users/demo_auth';
$route['search/search_keyword']='users/search_keyword';

// login to profile
$route['login-to-academy-profile'] = 'adminator/login_to_academy_profile';
$route['login-to-teacher-profile'] = 'adminator/login_to_teacher_profile';
$route['login-to-student-profile'] = 'adminator/login_to_student_profile';

//$route['test'] = 'users/test';

//for dropdown province in reg-academy
$route['dropdown/city/(:any)'] = 'users/getCityList/$1';

//for dropdown courses in page content
$route['dropdown/academy/(:any)'] = 'users/getClusterList/$1';
$route['dropdown/cluster/(:any)'] = 'users/getGroupList/$1';
$route['dropdown/group/(:any)'] = 'users/getStandardList/$1';


//API online.amoozkadeh
$route['api-v1/create'] ['post'] = 'API_APP/create';

$route['CD'] = 'BBB/ended_class';

$route['servers_info'] = 'BBB/servers_info';
$route['turn_off_on'] = 'BBB/turn_off_on';
$route['online'] = 'BBB/joinAdmin';
$route['class_info'] = 'BBB/more_info';
$route['clear'] = 'BBB/clear';

//$route['pass'] = 'BBB/pass';

$route['skyroom'] = 'Skyroom/test';
$route['skyroom_std/(:any)/(:num)'] = 'Skyroom/add_student/$1/$2';
$route['add_std_manager'] = 'Skyroom/add_std_manager';
$route['add_room_teacher'] = 'Skyroom/add_room_teacher';