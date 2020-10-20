<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exams extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function error_403() {
        $this->session->set_flashdata('warning-msg', 'برای دسترسی به این بخش باید به عنوان مدیریتی وارد شوید.');
        $this->load->view('student/errors/403');
    }

    private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null) {
        $headerData['title'] = $title;
        $this->load->view('templates/header', $headerData);
        $this->load->view('pages/' . $path, $contentData);
        $this->load->view('templates/footer', $footerData);
    }

    public function sub_question() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $contentData['question_difficulty'] = $this->base->get_data('question_difficulty', '*');
            $contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
            $contentData['yield'] = 'sub-question';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('ثبت سوال امتحانی', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/exams/error-403', 'refresh');
        }
    }

    public function insert_question() {
        $this->form_validation->set_rules('body', 'صورت سوال', 'required');
        $this->form_validation->set_rules('first_ch', 'گزینه اول', 'required');
        $this->form_validation->set_rules('second_ch', 'گزینه دوم', 'required');
        $this->form_validation->set_rules('third_ch', 'گزینه سوم', 'required');
        $this->form_validation->set_rules('fourth_ch', 'گزینه چهارم', 'required');
        $this->form_validation->set_rules('correct_answer', 'پاسخ صحیح', 'required');
        $this->form_validation->set_rules('difficulty', 'سختی سوال', 'required');
        $this->form_validation->set_rules('lesson', 'درس', 'required');
        $this->form_validation->set_message('required', '%s را وارد نمایید');

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id');
            $body = $this->input->post('body', true);
            $first = $this->input->post('first_ch', true);
            $second = $this->input->post('second_ch', true);
            $third = $this->input->post('third_ch', true);
            $fourth = $this->input->post('fourth_ch', true);
            $answer = $this->input->post('correct_answer', true);
            $difficulty = $this->input->post('difficulty', true);
            $lesson = $this->input->post('lesson', true);
            $inserArray = array(
                'academy_id' => $academy_id,
                'question_body' => $body,
                'first_choice' => $first, 'second_choice' => $second,
                'third_choice' => $third, 'fourth_choice' => $fourth,
                'answer' => $answer, 'lesson_id' => $lesson,
                'employee_nc' => $this->session->userdata('session_id'),
                'difficulty' => $difficulty
            );
            $this->base->insert('questions_bank', $inserArray);
            $this->session->set_flashdata('success', 'اطلاعات سوال شما با  موفقیت ثبت گردید');
            redirect('teacher/exams/sub-question', 'refresh');
        } else {
            $this->sub_question();
        }
    }

    public function definition() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $courses = $this->base->get_data('courses', 'course_id, course_duration, course_tuition, course_description, start_date', array('course_master' => $sessId, 'academy_id' => $academy_id));
            $courses_students_this_employee = [];
            foreach ($courses as $key => $value) {
//                $courses_students_this_employee[] = $this->base->get_join('courses','courses_students', 'courses_students.course_student_id=courses', array('course_id' => $value->course_id, 'academy_id' => $academy_id));
                $courses_students_this_employee[] = $this->base->get_data('courses_students', 'course_student_id', array('course_id' => $value->course_id, 'academy_id' => $academy_id));
            }
            $contentData['courses_students'] = $courses_students_this_employee;
            $contentData['courses'] = $courses;
            $contentData['yield'] = 'courses-to-def-exam';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $headerData['secondScripts'] = 'persian-calendar-scripts';
            $footerData['secondLinks'] = 'persian-calendar-links';
            $this->show_pages('ایجاد آزمون برای دوره های من', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/exams/error-403', 'refresh');
        }
    }

    private function generateRandomString() {
        $this->load->helper('string');
        $rnd = 'U-' . random_string('numeric', 4) . '-' . random_string('alnum', 8);
        return $rnd;
    }

    public function create_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $hard = $this->input->post('hard', true);
            $difficult = $this->input->post('difficult', true);
            $almost_hard = $this->input->post('almost_hard', true);
            $easy = $this->input->post('easy', true);
            $course_id = $this->input->post('course_id', true);
            $course_student_id = $this->input->post('course_student_id', true);

            $total = (int) $hard + (int) $difficult + (int) $almost_hard + (int) $easy;
            $existedQ = $this->get_join->getCountOfTable('questions_bank', null);
            if ($existedQ >= $total) {
                $hardQ = $this->get_join->getRandomData('questions_bank', $hard, 'question_id', array('difficulty' => 4));
                $difficultQ = $this->get_join->getRandomData('questions_bank', $difficult, 'question_id', array('difficulty' => 3));
                $almostHardQ = $this->get_join->getRandomData('questions_bank', $almost_hard, 'question_id', array('difficulty' => 2));
                $easyQ = $this->get_join->getRandomData('questions_bank', $easy, 'question_id', array('difficulty' => 1));
                $allQuestions = array_merge($hardQ, $difficultQ, $almostHardQ, $easyQ);
                $exam_code = $this->generateRandomString();
                foreach ($allQuestions as $key => $value) {
                    $inArray = array(
                        'academy_id' => $academy_id,
                        'question_id' => $value->question_id,
                        'lesson_id' => $value->lesson_id,
                        'course_student_id' => $course_student_id,
                        'course_id' => $course_id,
                        'answer' => $value->answer,
                        'employee_nc' => $this->session->userdata('session_id'),
                        'exam_code' => $exam_code
                    );
                    $this->base->insert('online_exams', $inArray);
                }
                $this->session->set_flashdata('insert-success', 'آزمون مورد نظر با موفقیت ایجاد شد.');
                redirect('teacher/exams/definition', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'به تعداد سوالات درخواستی در بانک سوالات، سوال موجود نیست. لطفا به بخش اضافه کردن سوالات رفته و سوالات مورد نظر خود را وارد نمایید.');
                redirect('teacher/exams/definition');
            }
        } else {
            redirect('teacher/exams/error-403', 'refresh');
        }
    }

    public function my_questions() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {

            $academy_id = $this->session->userdata('academy_id');
            $this->load->helper('text');
            $contentData['myQuestions'] = $this->get_join->get_data('questions_bank', 'lessons', 'questions_bank.lesson_id=lessons.lesson_id', null, null, array('employee_nc' => $sessId, 'questions_bank.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
            $contentData['yield'] = 'my-questions';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('استاد - سوالات من', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/exams/error-403', 'refresh');
        }
    }

    public function edit_question($qId) {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'teachers') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['myQuestions'] = $this->base->get_data('questions_bank', '*', array('question_id' => $qId, 'academy_id' => $academy_id));
            $contentData['lessons'] = $this->base->get_data('lessons', '*', array('academy_id' => $academy_id));
            $contentData['question_difficulty'] = $this->base->get_data('question_difficulty', '*');
            $contentData['yield'] = 'edit-question';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('استاد - ویرایش سوال', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('teacher/exams/error-403', 'refresh');
        }
    }

    public function update_question() {
        $this->form_validation->set_rules('body', 'صورت سوال', 'required');
        $this->form_validation->set_rules('first_ch', 'گزینه اول', 'required');
        $this->form_validation->set_rules('second_ch', 'گزینه دوم', 'required');
        $this->form_validation->set_rules('third_ch', 'گزینه سوم', 'required');
        $this->form_validation->set_rules('fourth_ch', 'گزینه چهارم', 'required');
        $this->form_validation->set_rules('correct_answer', 'پاسخ صحیح', 'required');
        $this->form_validation->set_rules('difficulty', 'سختی سوال', 'required');
        $this->form_validation->set_rules('lesson', 'درس', 'required');
        $this->form_validation->set_message('required', '%s را وارد نمایید');
        $question_id = $this->input->post('qId', true);

        if ($this->form_validation->run() === TRUE) {
            $academy_id = $this->session->userdata('academy_id');
            $qId = $this->input->post('qId', true);
            $body = $this->input->post('body', true);
            $first = $this->input->post('first_ch', true);
            $second = $this->input->post('second_ch', true);
            $third = $this->input->post('third_ch', true);
            $fourth = $this->input->post('fourth_ch', true);
            $answer = $this->input->post('correct_answer', true);
            $difficulty = $this->input->post('difficulty', true);
            $lesson = $this->input->post('lesson', true);

            $inserArray = array(
                'question_body' => $body,
                'first_choice' => $first, 'second_choice' => $second,
                'third_choice' => $third, 'fourth_choice' => $fourth,
                'answer' => $answer, 'lesson_id' => $lesson,
                'employee_nc' => $this->session->userdata('session_id'),
                'difficulty' => $difficulty
            );
            $this->base->update('questions_bank', array('question_id' => $qId, 'academy_id' => $academy_id), $inserArray);
            $this->session->set_flashdata('insert-success', 'اطلاعات سوال شما با  موفقیت بروزرسانی شد.');
            redirect('teacher/exams/my-questions', 'refresh');
        } else {
            $this->edit_question($question_id);
        }
    }

}
