<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    // for courses dropdown page name welcome
    public function index() {
        $this->load->view('test_courses');
    } 
    
    public function getClusterList($academy_id) {
         $data = $this->base->get_cluster_name($academy_id);
       echo json_encode($data);
   }
    
    public function getGroupList($cluster_id) {
         $data = $this->base->get_group_name($cluster_id);
       echo json_encode($data);
   }
   
   
   public function getStandardList($group_id) {
         $data = $this->base->get_standard_name($group_id);
       echo json_encode($data);
   }
   // End for courses dropdown
   


}
