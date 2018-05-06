<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index() {
		if($this->session->userdata('user_data') !== NULL) {
			$this->session->unset_userdata('user_data');
			$this->session->sess_destroy();
			redirect(base_url('login'));
		} else {
			redirect(base_url('home'));
		}
	}
}
?>