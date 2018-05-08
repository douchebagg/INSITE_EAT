<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {

	public function index() {
		$data['id'] = $this->input->get('id');
		$this->load->view('Review_View', $data);
	}
}
?>