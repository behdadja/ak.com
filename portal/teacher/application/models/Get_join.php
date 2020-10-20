<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_join extends CI_Model{

    public function get_data($from1, $join1, $condition1, $join2 = null, $condition2 = null, $where = null, $order_by = null) {
        $this->db->select('*');
        $this->db->from($from1);
        if ($where !== null)
            $this->db->where($where);
        $this->db->join($join1, $condition1);
        if ($condition2 !== null)
            $this->db->join($join2, $condition2);
        if ($order_by !== null)
            $this->db->order_by($order_by, "desc");
        $query = $this->db->get();
        return $query->result();
    }

     public function get_data2($from1, $join1, $condition1, $condition2 = null, $where = null)
	{
		$this->db->select('*');
		$this->db->from($from1);
		if ($where !== null)
			$this->db->where($where);
		$this->db->join($join1, $condition1, $condition2);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data4($from1, $join1, $condition1, $join2 = null, $condition2 = null,$join3 = null, $condition3 = null, $where = null)
	{
		$this->db->select('*');
		$this->db->from($from1);
		if ($where !== null)
			$this->db->where($where);
		$this->db->join($join1, $condition1);
		if ($condition2 !== null)
			$this->db->join($join2, $condition2);
		if ($condition3 !== null)
			$this->db->join($join3, $condition3);
		$query = $this->db->get();
		return $query->result();
	}

	public function unlinkPic($picName)
	{
		if ($picName !== 'default.png')
		{
			unlink(FCPATH . 'uploads\img\/' . $picName);
			unlink('uploads/thumb/'.$picName);
		}else{
			return true;
		}
	}

	function get_search($match) {
		$this->db->like('title',$match,'both');
		$query = $this->db->get('fancy_breads')->row_array();
		$query1 = $this->db->get('main_breads_category')->row_array();
		$data['1'] = $query1;
		$data['2'] = $query;
		return $data;
	}

	function getCountOfTable($tableName, $where)
	{
		$this->db->select('*');
		if ($where != null) {
			$this->db->where($where);
		}
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function getProductForYield($id, $tableName, $PCode)
	{
		$this->db->select('id');
		$this->db->select($PCode);
		$this->db->from($tableName);
		$this->db->where('id =', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function getCoursesForRegistration(){
		$this->db->select('course_id');
		$this->db->select('lesson_id');
		$this->db->select('course_tuition');
		$this->db->select('course_duration');
		$this->db->select('start_date');
		$this->db->from('courses');
		$query = $this->db->get();
		return $query->result();
	}

	function getCoursesIdAndName(){
		$this->db->select('course_id');
		$this->db->select('course_name');
		$this->db->from('courses');
		$query = $this->db->get();
		return $query->result();
	}

	function getMiniInfoOfStudent($student_nc){
		$this->db->select('last_name');
		$this->db->select('first_name');
		$this->db->select('father_name');
		$this->db->select('national_code');
		$this->db->select('phone_num');
		$this->db->select('pic_name');
		$this->db->from('students');
		$this->db->where('national_code =', $student_nc);
		$query = $this->db->get();
		return $query->result();
	}

	function getAmountOfCourse($course_id){
		$this->db->where('course_id='.$course_id);
		$this->db->select('course_tuition');
		$this->db->from('courses');
		$query = $this->db->get();
		return $query->result();
	}

	function getAmountOfExam($exam_id){
		$this->db->where('exam_id='.$exam_id);
		$this->db->select('exam_cost');
		$this->db->from('exams');
		$query = $this->db->get();
		return $query->result();
	}

	function getStudentCoursesId($student_nc){
		$this->db->select('course_id');
		$this->db->where("student_nc=".$student_nc);
		$this->db->from('courses_students');
		$q = $this->db->get();
		return $q->result();
	}

	function getStudentCoursesMaster($course_id){
		$this->db->select('course_master');
		$this->db->where("course_id=".$course_id);
		$this->db->from('courses');
		$q = $this->db->get();
		return $q->result();
	}

	function getMasterInfo($master_nc){
		$this->db->select('employee_id');
		$this->db->select('first_name');
		$this->db->select('last_name');
		$this->db->select('national_code');
		$this->db->select('pic_name');
		$this->db->where("national_code=".$master_nc);
		$this->db->from('employers');
		$q = $this->db->get();
		return $q->result_array();
	}

	function getRandomData($table, $limit, $key, $where){
		$this->db->order_by($key, 'RANDOM');
		$this->db->where($where);
		$this->db->limit($limit);
		$query = $this->db->get($table);
		return $query->result();
	}

}
