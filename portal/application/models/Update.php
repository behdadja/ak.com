<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class update extends CI_Model {

    function updateExamStatus($student_nc, $course_student_id, $course_id, $exam_stage, $exam_stage_p, $academy_id) {
        $this->db->where('student_nc=' . $student_nc . ' AND course_student_id=' . $course_student_id . ' AND course_id=' . $course_id . ' AND academy_id=' . $academy_id);
        if ($this->db->update('courses_students', array($exam_stage => '1', $exam_stage_p => '1', 'academy_id' => $academy_id))) {
            return true;
        } else {
            return false;
        }
    }

    function updateWrittenExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, $final_w_status) {
        $this->db->where('student_nc=' . $student_nc . ' AND course_student_id=' . $course_student_id . ' AND course_id=' . $course_id . ' AND academy_id=' . $academy_id);

        if ($this->db->update('courses_students', array($exam_stage => '2', $mark_stage => $mark, 'final_w_status' => $final_w_status, 'final_w_mark' => $mark, 'academy_id' => $academy_id))) {
            return true;
        } else {
            return false;
        }
    }

    function updatePracticalExamMarkStatus($student_nc, $course_student_id, $course_id, $exam_stage, $mark_stage, $mark, $academy_id, $final_p_status) {
        $this->db->where('student_nc=' . $student_nc . ' AND course_student_id=' . $course_student_id . ' AND course_id=' . $course_id. ' AND academy_id=' . $academy_id);

        if ($this->db->update('courses_students', array($exam_stage => '2', $mark_stage => $mark, 'final_p_status' => $final_p_status, 'final_p_mark' => $mark, 'academy_id' => $academy_id))) {
            return true;
        } else {
            return false;
        }
    }

    function updateAloneExamStatus($student_nc, $course_student_id, $course_id, $exam_stage, $academy_id) {
        $this->db->where('student_nc=' . $student_nc . ' AND course_student_id=' . $course_student_id . ' AND course_id=' . $course_id. ' AND academy_id=' . $academy_id);
        if ($this->db->update('courses_students', array($exam_stage => '1', 'academy_id' => $academy_id))) {
            return true;
        } else {
            return false;
        }
    }

}
