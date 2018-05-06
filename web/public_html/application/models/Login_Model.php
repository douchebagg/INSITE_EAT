<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {
	public function get_user($user,$pass){
		$this->db->where('USERNAME',$user);
    	$this->db->where('PASSWORD',$pass);
		$result = $this->db->get('Account');
		return $result->result_array();
	}

	public function get_user_by_token($token) {
		$result = $this->db->where('ID', $token)->get('Account');
		return $result->result_array();
	}

	public function add_user_by_token($token, $name) {
		$data = array(
			'ID' => $token,
			'USERNAME' => 'OTHER_ACCOUNT',
			'PASSWORD' => 'OTHER_ACCOUNT',
			'DISPLAY_NAME' => $name
		);
		$this->db->insert('Account', $data);
	}

	public function update_user_by_token($token, $name) {
		$data = array(
			'DISPLAY_NAME' => $name
		);
		$result = $this->db->where('ID', $token)->update('Account', $data);
		return $result->result_array();
	}
}
?>