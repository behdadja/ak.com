<?php

class base extends CI_Model {

    function rw($qr) {
        $query = $this->db->query($qr);
        return $query->result_object();
    }

    function get_random_place($table, $var, $where = NULL, $limit = NULL) {
        $this->db->select($var);
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->order_by('rand()');
        $query = $this->db->get($table, $limit);
        return $query->result_object();

        //$this->db->order_by('rand()');
        //$this->db->limit(5);
        //$query = $this->db->get('pages');
        //return $query->result_array();
    }

    function get_data($table, $var, $where = NULL, $like = NULL, $or_where = NULL, $where_in = NULL, $order_by = NULL, $limit = NULL, $offset = NULL, $group_by = NULL, $id = null) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
        if ($or_where != NULL) {
            $this->db->or_where($or_where);
        }
        if ($where_in != NULL) {
            $this->db->where_in($where_in);
        }
        if ($group_by != NULL) {
            $this->db->group_by($group_by);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }
        if ($id !== null) {
            $this->db->order_by($id, "desc");
        }
        $query = $this->db->get($table, $limit, $offset);

        return $query->result_object();
    }
	function search($keyword)
	{
		$this->db->like('lesson_name',$keyword);
		$query  =   $this->db->get('lessons');
		return $query->result();
	}

    function get_data_var($table, $var, $where = NULL, $like = NULL, $or_where = NULL, $where_in = NULL, $order_by = NULL, $limit = NULL, $offset = NULL, $group_by = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
        if ($or_where != NULL) {
            $this->db->or_where($or_where);
        }
        if ($where_in != NULL) {
            $this->db->where_in($where_in);
        }
        if ($group_by != NULL) {
            $this->db->group_by($group_by);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }

        $query = $this->db->get($table, $limit, $offset);

        return $query->result();
    }

    function wherein($table, $var, $where = NULL, $where_not_in) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($where_not_in != NULL) {
            $this->db->where_not_in('id', $where_not_in);
        }

        $query = $this->db->get($table);

        return $query->result_object();
    }

    function get_search($table, $var, $column, $like) {
        $this->db->select($var);
        $this->db->like($column, $like);
        $query = $this->db->get($table);

        return $query->result_object();
    }

    function get_news_send($var, $where = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }

        $query = $this->db->get('newsletter_send');

        return $query->result_object();
    }

    function get_mail($var, $where = NULL, $limit = NULL, $offset = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }

        $query = $this->db->get('hasan', $limit, $offset);

        return $query->result_object();
    }

    function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

//end of insert

    function insert_batch($table, $data) {
        $this->db->insert_batch($table, $data);
    }

//end of insert_batch

    function update($table, $where = NULL, $data) {
        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($this->db->update($table, $data)) {
            return 1;
        } else
            return 0;
    }

//end of update

    function delete($table, $id) {
        $this->db->where('id', $id);
        if ($this->db->delete($table)) {
            return TRUE;
        }
    }

//end delete

    function delete_data($table, $where) {
        $this->db->where($where);
        if ($this->db->delete($table)) {
            return TRUE;
        }
    }

    function vote_question($table, $data) {//insert to table and return id from table
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function counter($table, $where = NULL) {
        if ($where != NULL) {
            $this->db->where($where);
        }
        $query = $this->db->count_all($table);
        return $query;
    }

    function sum_decrease($userid) {
        $this->db->where(array('type' => '0', 'user_id' => $userid));
        $this->db->select_sum('cost');
        $query = $this->db->get('transaction');
        return $query->result_object();
    }

    function sum_increase($userid) {
        $this->db->where(array('type' => '1', 'user_id' => $userid));
        $this->db->select_sum('cost');
        $query = $this->db->get('transaction');
        return $query->result_object();
    }

    /* function get_join($var,$table,$table1,$where_join,$where=NULL,$order_by=NULL,$limit=NULL)
      {
      $this->db->select($var);

      if($where !=NULL)
      {
      $this -> db -> where($where);
      }
      if($order_by != NULL)
      {
      $this->db->order_by($order_by);
      }
      //$this->db->from($table);
      $this->db->join($table1, $where_join);


      $query = $this->db->get($table,$limit);
      return $query->result_object();
      } */

    function get_join($var, $table, $table1, $where_join, $where = NULL, $like = NULL, $order_by = NULL, $limit = NULL, $offset = NULL, $or_where = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($or_where != NULL) {
            $this->db->or_where($or_where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }
        //$this->db->from($table);
        $this->db->join($table1, $where_join);


        $query = $this->db->get($table, $limit, $offset);
        return $query->result_object();
    }

    function get_triple($var, $table1, $table2, $table3, $where_join1, $where_join2, $where = NULL, $order_by = NULL, $limit = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }
        //$this->db->from($table);
        $this->db->join($table2, $where_join1);
        $this->db->join($table3, $where_join2);


        $query = $this->db->get($table1, $limit);
        return $query->result_object();
    }

    function get_triple4($var, $table1, $table2, $table3, $table4 = null, $where_join1, $where_join2, $where_join3 = null, $where = NULL, $order_by = NULL, $limit = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }
        //$this->db->from($table);
        $this->db->join($table2, $where_join1);
        $this->db->join($table3, $where_join2);
        if ($table4 != NULL && $where_join3 != NULL) {
            $this->db->join($table4, $where_join3);
        }

        $query = $this->db->get($table1, $limit);
        return $query->result_object();
    }

    public function can_login($table, $email, $pass) {
        $this->db->where('email', $email);
        $this->db->where('password', sha1($pass));
        $query = $this->db->get($table);
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function count($table, $where = NULL) {
        if ($where != NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function count_join($var, $table, $table1, $where_join, $where = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }

        //$this->db->from($table);
        $this->db->join($table1, $where_join);

        $query = $this->db->get($table);
        return $query->num_rows();
    }


    // ------------- modal courses in page content ------------- \\
    function get_cluster_name($academy) {
        $this->db->where('type_academy', $academy);
        $this->db->select('DISTINCT(cluster_name),cluster_id');
        $query = $this->db->get('standards');
        return $query->result_object();
    }

    function get_group_name($cluster) {
        $this->db->where('cluster_id', $cluster);
        $this->db->select('DISTINCT(group_name),group_id');
        $query = $this->db->get('standards');
        return $query->result_object();
    }

    function get_standard_name($group) {
        $this->db->where('group_id', $group);
        $this->db->select('DISTINCT(standard_name),standard_id');
        $query = $this->db->get('standards');
        return $query->result_object();
    }

    // ------------- End ------------- //
    function join_five($var, $table1, $table2, $table3, $table4 = null, $table5 = null, $where_join1, $where_join2, $where_join3 = null, $where_join4 = null, $where = NULL, $order_by = NULL, $limit = NULL) {
        $this->db->select($var);

        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($order_by != NULL) {
            $this->db->order_by($order_by);
        }
        //$this->db->from($table);
        $this->db->join($table2, $where_join1);
        $this->db->join($table3, $where_join2);
        if ($table4 != NULL && $where_join3 != NULL) {
            $this->db->join($table4, $where_join3);
        }
        if ($table5 != NULL && $where_join4 != NULL) {
            $this->db->join($table5, $where_join4);
        }

        $query = $this->db->get($table1, $limit);
        return $query->result_object();
    }

    function city($id) {
        $this->db->where('province', $id);
        $this->db->select('name,id');
        $query = $this->db->get('city');
        return $query->result_object();
    }

}

//end model
// 03.94
