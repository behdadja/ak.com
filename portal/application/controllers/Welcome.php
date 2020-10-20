<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		$this->load->library('calc');
	}

	private function show_pages($title = null, $path, $contentData = null, $headerData = null, $footerData = null)
	{
		$headerData['title'] = $title;
		$this->load->view('templates/header', $headerData);
		$this->load->view('pages/' . $path, $contentData);
		$this->load->view('templates/footer', $footerData);
	}


//	public function result_test(){
//		require_once 'jdf.php';
//		echo '<br>'.$start_date = strtr($this->input->post('start_date', true), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
//		$start_date = explode('-', $start_date);
//		echo '<br>'.$year = $start_date[0];
//		echo '<br>'.$month = $start_date[1];
//		echo '<br>'.$day = $start_date[2];
//		$d = $year . '-' . $month . '-' . $year;
//
//		$sat_clock = $this->input->post('sat_clock', true);
//		$sat_clock = explode(':', $sat_clock);
//		$sat_hours = $sat_clock[0];
//		$sat_minute = $sat_clock[1];
//		echo '<br>' . jdate("l j F Y - H:i", jmktime($sat_hours, $sat_minute, 0, $month, $day, $year));
//
//		$d = $year . '-' . $month . '-' . $day;
//		$g = (int)$year . '-' . (int)$month . '-' . (int)$day;
//		echo'<hr>'. strtotime($this->calc->jalali_to_gregorian($d));
//		echo'<br>'. strtotime($this->calc->jalali_to_gregorian($g));
//		$num_day = jdate("N", jmktime(0, 0, 0, $month, $day, $year));
//		$sat_text = '7';
//		echo '<hr>'.$num_day = strtr($num_day, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'));
//		var_dump($sat_text);
//		echo '<hr>';
//		var_dump($num_day);
//
//	}

}
