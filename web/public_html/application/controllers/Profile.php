<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function index() {
		$this->load->view('EditProfile_View');
	}

	public function edit() {
		$token = $this->session->userdata('user_data')['token'];
        $dispname = $this->input->post('DISPLAY_NAME');
      
		$this->load->model("Profile_Model");
		$this->Profile_Model->edit_profile($token, $dispname);
		$session = array(
			'token' => $token,
			'username' => $this->session->userdata('user_data')['username'],
			'name' => $dispname,
			'other' => false
		);
		$this->session->set_userdata('user_data', $session);
		redirect('home');
	}
}
?>