<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {
	public function get_user($user,$pass){
		$this->db->where('USERNAME',$user);
    	$this->db->where('PASSWORD',$pass);
		$result = $this->db->get('Account');
		return $result->result_array();
	}
}
?>