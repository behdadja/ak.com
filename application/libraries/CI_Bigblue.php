<?php
class CI_Bigblue{

	private $secret_key = 'tYPxw3B3RvRQQ0vtcAQAsjpyitkxh1VkZpeqA76A2Q8';
	private $end_point_address = 'https://online.amoozkadeh.com/bigbluebutton/api/';
	######################### General Functions ##################################

	public function sinozit_response($link){
		ini_set('max_execution_time', 600);
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $link );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $this->xml_array(simplexml_load_string($result));

	}

	public function xml_array ( $xml ){
		$out = array ();
		foreach ( (array) $xml as $index => $node )
			$out[$index] = ( is_object ( $node ) ) ? $this->xml_array ( $node ) : $node;

		return $out;
	}

	public function generate_checksum($method,$query){

		return sha1($method.$query.$this->secret_key);
	}

	public function generate_link($method,$query = ""){

		$checksum = $this->generate_checksum($method,$query);
		return $method.'?'.$query."&checksum=".$checksum;

	}

	public function generate_query($params,$query = "",$count = 0){

		foreach($params as $key => $item)

			try{
				$count++;
				($count == 1) ? $query .= $key."=".$item : $query .= "&".$key."=".$item;
			}catch (Error $e){
				//ignore
			}


		return $query;

	}

	public function  unique_id(){

		$chars = array_merge(range('a', 'z'), range(0, 9));
		shuffle($chars);
		return implode(array_slice($chars, 0,15));

	}

	################# Api Methods ########################################################################################################

	public function create_meeting($params){

		$method = "create";
		$query = $this->generate_query($params);
		return $this->sinozit_response($this->end_point_address.$this->generate_link($method,$query));
	}

	public function get_meetings(){

		$method = "getMeetings";
		return $this->sinozit_response($this->end_point_address.$this->generate_link($method));
	}

	public function join_meeting($params){

		$method = "join";
		$query = $this->generate_query($params);
		return $this->end_point_address.$this->generate_link($method,$query);

	}

	public function meeting_status($params){
		$method = "isMeetingRunning";
		$query = $this->generate_query($params);
		return $this->sinozit_response($this->end_point_address.$this->generate_link($method,$query));
	}


	public function meeting_end($params){
		$method = "end";
		$query = $this->generate_query($params);
		return $this->sinozit_response($this->end_point_address.$this->generate_link($method,$query));
	}

	public function meeting_info($params){
		$method = "getMeetingInfo";
		$query = $this->generate_query($params);
		return $this->sinozit_response($this->end_point_address.$this->generate_link($method,$query));
	}
}
