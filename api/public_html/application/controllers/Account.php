<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Account extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Restaurant_Model');
	}

    public function index_get($id) {
    	$result = $this->Restaurant_Model->list_all_restaurants_by_acc_id($id);
    	if(!empty($result)) {
			$this->response(array('restaurant' => $result), 200);
    	} else {
    		$this->response(array('restaurant' => 'No data in Restaurant api.'), 200);
    	}
    }
}
?>