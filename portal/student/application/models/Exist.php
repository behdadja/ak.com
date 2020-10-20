<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exist extends CI_Model{

	public function is_exist_mobile($phoneNum)
	{
		$this->db->where('phone_num',$phoneNum);
		$query = $this->db->get('users');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function del_all_temp_user_if_exist($phoneNum){
		$this->db->where('phone_num',$phoneNum);
		$this->db->delete('temp_users');
	}

	public function is_correct_verify_code($phoneNum, $verifyCode){
		$this->db->where('phone_num',$phoneNum);
		$this->db->where('activation_code',$verifyCode);
		$query = $this->db->get('temp_users');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function is_correct_user_info($national_code, $password, $academy_id, $category){
		$this->db->where('national_code',$national_code);
		$this->db->where('password',$password);
                $this->db->where('academy_id',$academy_id);
		if ($category === '1') {
			$query = $this->db->get('academys_option');
		}elseif($category === '2'){
			$query = $this->db->get('employers');
		}else{
			$query = $this->db->get('students');
		}
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function exist_entry($table, $where){
		$this->db->where($where);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function isExistCoursesEnroll($nc, $li, $ai)
	{
		$this->db->where(array('student_nc' => $nc));
		$this->db->where(array('course_id=' => $li));
                $this->db->where(array('academy_id=' => $ai));
		$query = $this->db->get('courses_students');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	function getExistExamEnroll($nc, $li)
	{
		$this->db->where(array('student_nc' => $nc));
		$this->db->where(array('course_id=' => $li));
		$query = $this->db->get('exams_students');
		return $query->result();
	}

	function isExistExamsEnroll($nc, $li){
		$this->db->where(array('student_nc' => $nc));
		$this->db->where(array('course_id=' => $li));
		$query = $this->db->get('exams_students');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
}
