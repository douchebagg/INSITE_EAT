<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food extends CI_Controller {

	public function index() {
		$this->load->view('Food_View');
	}
}
?>