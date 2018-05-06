<?php
class Profile_Model extends CI_Model {
	public function edit_profile($token,$dispname) {
		$data = array(
			'DISPLAY_NAME' => $dispname
		);
		$this->db->where('ID',$token);
		$this->db->update('Account',$data);
	}
}
?>