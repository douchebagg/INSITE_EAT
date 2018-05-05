<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {

	public function index() {
		$this->load->view('Map_View');
	}
}
?>