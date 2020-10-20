<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function error_403(){
        $this->session->set_flashdata('warning-msg', 'این صفحه وجود ندارد');
        $this->load->view('errors/403');
    }

  private function show_pages($title = null, $path, $contentData = null)
	{
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/'.$path, $contentData);
		$this->load->view('templates/footer');
	}

  public function index() {
      $contentData['schools'] = $this->base->get_data('academys_option', '*');
      $sessId = $this->session->userdata('session_id');
      $userType = $this->session->userdata('user_type');
      if (!empty($sessId) && $userType === 'teachers') {
          redirect('teacher/profile', 'refresh');
      }else{
          redirect('profile', 'refresh');
//          $this->show_pages( 'ورود به پروفایل شخصی', '../login-form', $contentData);
      }
  }


}
