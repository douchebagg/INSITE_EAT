<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Restaurant extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Restaurant_Model');
	}

    public function index_get() {

    }

    public function find_get($id) {

    }

    public function index_post() {
        
    }

    public function index_put($id) {

    }

    public function index_delete($id) {

    }
}
?>