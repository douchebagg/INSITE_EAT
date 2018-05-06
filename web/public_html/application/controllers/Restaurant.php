<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {

	public function index() {
		$this->load->view('Review_View');
	}
}
?>