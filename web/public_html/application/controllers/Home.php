<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		if($this->session->userdata('user_data') !== NULL) {
			$this->load->view('Home_View');
		} else {
			redirect(base_url('login'));
		}
	}
}
?>