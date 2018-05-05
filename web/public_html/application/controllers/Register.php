<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if($this->input->method() === 'post') {
			
		} else {
			$this->load->view('Register_View');
		}
	}
}
?>