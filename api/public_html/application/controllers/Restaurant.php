<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Restaurant extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Restaurant_Model');
	}

    public function index_get() {
    	$result = $this->Restaurant_Model->list_all_restaurants();
    	if(!empty($result)) {
			$this->response(array('restaurant' => $result), 200);
    	} else {
    		$this->response(array('restaurant' => array('No data in Restaurant api.')), 204);
    	}
    }

    public function find_get($id) {
    	$result = $this->Restaurant_Model->list_restaurant($id);
    	if(!empty($result)) {
			$this->response(array('restaurant' => $result), 200);
    	} else {
    		$this->response(array('restaurant' => 'No data in Restaurant api.'), 204);
    	}
    }

    public function index_post() {
    	$data = array(
    		'RES_ID' => $this->post('id'),
    		'RES_NAME' => $this->post('name'),
    		'RES_REVIEW' => $this->post('review'),
    		'RES_LOCALTION' => $this->post('location'),
    		'OPENNING_TIME' => $this->post('openning'),
    		'CLOSING_TIME' => $this->post('closing'),
    		'RES_PHONE' => $this->post('phone'),
    		'RES_SCORE' => $this->post('score')
    	);
		$result = $this->Restaurant_Model->add_restaurant($data);

		if($result) {
            $result = $this->Restaurant_Model->list_restaurant($data['RES_ID']);
			$this->response(array('restaurant' => $result), 201);
		} else {
			$this->response(array('restaurant' => 'Add Restaurant failed.'), 204);
		}
    }

    public function index_put($id) {
        $data = array(
            'RES_ID' => $id,
            'RES_NAME' => $this->post('name'),
            'RES_REVIEW' => $this->post('review'),
            'RES_LOCALTION' => $this->post('location'),
            'OPENNING_TIME' => $this->post('openning'),
            'CLOSING_TIME' => $this->post('closing'),
            'RES_PHONE' => $this->post('phone'),
            'RES_SCORE' => $this->post('score')
        );
        $result = $this->Restaurant_Model->update_restaurant($data);

        if($result) {
            $result = $this->Restaurant_Model->list_restaurant($id);
            $this->response(array('restaurant' => $result), 200);
        } else {
            $this->response(array('restaurant' => 'Update Restaurant failed.'), 204);
        }
    }

    public function index_delete($id) {
        $result = $this->Restaurant_Model->delete_restaurant($id);

        if($result) {
            $result = $this->Restaurant_Model->list_restaurant($id);
            $this->response(array('restaurant' => $result), 200);
        } else {
            $this->response(array('restaurant' => 'Delete Restaurant failed.'), 204);
        }
    }
}
?>