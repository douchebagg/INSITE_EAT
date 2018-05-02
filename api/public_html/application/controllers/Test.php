<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function restaurant() {
        $this->load->view('test_res_view');
    }

    public function food() {
    	$this->load->view('test_food_view');
    }
}
?>