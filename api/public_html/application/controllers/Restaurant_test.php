<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_test extends CI_Controller {

	public function index() {
        $this->load->view('test_res_view.php');
    }
}
?>