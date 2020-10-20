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

    public function my_exams() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $contentData['exams'] = $this->get_join->get_data4('exams_students', 'exams', 'exams_students.exam_id=exams.exam_id', 'students', 'exams_students.student_nc=students.national_code', 'courses', 'exams_students.course_id=courses.course_id', array('student_nc' => $sessId, 'exams_students.academy_id' => $academy_id, 'exams.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            $contentData['yield'] = 'my-exams';
            $headerData['links'] = 'data-table-links';
            $footerData['scripts'] = 'data-table-scripts';
            $this->show_pages('دانشجو - آزمون های من', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

    public function my_online_exams() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $my_course = $this->get_join->get_data4('courses_students', 'lessons', 'courses_students.lesson_id=lessons.lesson_id', 'students', 'courses_students.student_nc=students.national_code', 'courses', 'courses_students.course_id=courses.course_id', array('student_nc' => $sessId, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses.academy_id' => $academy_id, 'students.academy_id' => $academy_id));
            foreach ($my_course as $key => $value) {
                $online_exams = $this->get_join->get_data_limit('online_exams', 'courses_students', 'online_exams.course_id = courses_students.course_id', 'lessons', 'online_exams.lesson_id=lessons.lesson_id', array('course_student_id' => $value->course_student_id, 'online_exams.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id), null, null, 1);
            }
            $contentData['courses_list'] = $online_exams;
            $contentData['yield'] = 'list-of-courses-for-online-exams';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('دانشجو - لیست آزمون های آنلاین', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

    public function start_online_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $code = $this->input->post('exam_code', true);
            if ($this->exist->exist_entry('final_result_st_on_exam', array('exam_code' => $code, 'student_nc' => $sessId, 'academy_id' => $academy_id))) {
                $this->session->set_flashdata('enroll-e', 'شما این آزمون را قبلا انجام داده اید.');
                redirect('student/exams/my-online-exams', 'refresh');
            } else {
                $contentData['examQ'] = $this->get_join->get_data('online_exams', 'questions_bank', 'online_exams.question_id=questions_bank.question_id', 'lessons', 'online_exams.lesson_id=lessons.lesson_id', array('exam_code' => $code, 'online_exams.academy_id' => $academy_id, 'questions_bank.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id));
                $contentData['yield'] = 'exam';
                $headerData['secondLinks'] = 'wizard-links';
                $footerData['secondScripts'] = 'wizard-scripts';
                $this->show_pages('دانشجو - لیست آزمون های آنلاین', 'content', $contentData, $headerData, $footerData);
            }
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

    public function correction_of_exam() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $examCode = $this->input->post('exam_code', true);
            $student_nc = $this->session->userdata('session_id');
            $i = 1;
            $correctAnswer = 0;
            $wrongAnswer = 0;
            $noneAnswer = 0;
            $answerArray = [];
            while (TRUE):
                if (!$this->input->post('question_' . $i, true) && (!$answerArray['question_id'] = $this->input->post('question_id_' . $i, true))) {
                    break;
                } else {
                    $answerArray['exam_code'] = $examCode;
                    $answerArray['student_nc'] = $student_nc;
                    $answerArray['question_id'] = $this->input->post('question_id_' . $i, true);
                    $answerArray['student_answer'] = $this->input->post('question_' . $i, true);
                    $answerArray['question_answer'] = $this->base->get_data('questions_bank', 'answer', array('question_id' => $answerArray['question_id'], 'questions_bank.academy_id' => $academy_id, 'answer.academy_id' => $academy_id))[0]->answer;
                    if ((int) $answerArray['student_answer'] === (int) $answerArray['question_answer']) {
                        $answerArray['is_correct'] = "1";
                        $correctAnswer++;
                    } elseif ((int) $answerArray['student_answer'] !== (int) $answerArray['question_answer'] && !empty($answerArray['student_answer'])) {
                        $answerArray['is_correct'] = "-1";
                        $wrongAnswer++;
                    } elseif ((int) $answerArray['student_answer'] !== (int) $answerArray['question_answer'] && !($answerArray['student_answer'])) {
                        $answerArray['is_correct'] = "0";
                        $noneAnswer++;
                    }
                    $this->base->insert('correction_of_exam', $answerArray);
                    $i++;
                    continue;
                }
            endwhile;
            $finalResult = array(
                'academy_id' => $academy_id,
                'exam_code' => $examCode,
                'student_nc' => $student_nc,
                'count_of_questions' => (int) $correctAnswer + (int) $wrongAnswer + (int) $noneAnswer,
                'count_of_correct_ans' => $correctAnswer,
                'correct_percent' => (100 * (int) $correctAnswer) / ((int) $correctAnswer + (int) $wrongAnswer + (int) $noneAnswer),
                'count_of_wrong_ans' => $wrongAnswer,
                'wrong_percent' => (100 * (int) $wrongAnswer) / ((int) $correctAnswer + (int) $wrongAnswer + (int) $noneAnswer),
                'count_of_none_ans' => $noneAnswer,
                'none_percent' => (100 * (int) $noneAnswer) / ((int) $correctAnswer + (int) $wrongAnswer + (int) $noneAnswer)
            );
            $contentData['finalResult'] = $finalResult;
            $contentData['examInfo'] = $this->get_join->get_data_limit('online_exams', 'lessons', 'online_exams.lesson_id=lessons.lesson_id', null, null, null, null, array('online_exams.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id), 1);
            $contentData['yield'] = 'online-exam-result';
            $headerData['secondLinks'] = 'wizard-links';
            $footerData['secondScripts'] = 'wizard-scripts';
            $this->base->insert('final_result_st_on_exam', $finalResult);
            $this->show_pages('نتیجه نهایی', 'content', $contentData);
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

    public function result_of_online_exams() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $my_results = $this->base->get_data('final_result_st_on_exam', 'exam_code', array('student_nc' => $sessId, 'academy_id' => $academy_id));
            foreach ($my_results as $key => $value) {
                $contentData['courses_list'] = $online_exams = $this->get_join->get_data_limit('online_exams', 'courses_students', 'online_exams.course_id = courses_students.course_id', 'lessons', 'online_exams.lesson_id=lessons.lesson_id', array('exam_code' => $value->exam_code), null, array('online_exams.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id, 'courses_students.academy_id' => $academy_id), 1);
            }
            // print_r($online_exams);
//            $contentData['courses_list'] = $online_exams;
            $contentData['yield'] = 'online-exams-result';
            $headerData['secondLinks'] = 'persian-calendar-links';
            $footerData['secondScripts'] = 'persian-calendar-scripts';
            $this->show_pages('دانشجو - مشاهده نتایج آزمون های آنلاین', 'content', $contentData, $headerData, $footerData);
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

    public function result_view() {
        $sessId = $this->session->userdata('session_id');
        $userType = $this->session->userdata('user_type');
        if (!empty($sessId) && $userType === 'students') {
            $academy_id = $this->session->userdata('academy_id');
            $code = $this->input->post('exam_code', true);
            $contentData['finalResult'] = $this->base->get_data('final_result_st_on_exam', '*', array('exam_code' => $code, 'student_nc' => $sessId, 'academy_id' => $academy_id));
            $contentData['examInfo'] = $this->get_join->get_data_limit('online_exams', 'lessons', 'online_exams.lesson_id=lessons.lesson_id', null, null, null, null, array('exam_code' => $code, 'online_exams.academy_id' => $academy_id, 'lessons.academy_id' => $academy_id), 1);
            $contentData['yield'] = 'exam-result';
            $this->show_pages('نتیجه نهایی', 'content', $contentData);
        } else {
            redirect('student/exams/error-403', 'refresh');
        }
    }

}
