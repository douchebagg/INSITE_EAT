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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
    	$data = array(
    		'RES_ID' => $request->RES_ID,
    		'RES_NAME' => $request->RES_NAME,
    		'RES_REVIEW' => $request->RES_REVIEW,
    		'RES_LOCALTION' => $request->RES_LOCALTION,
    		'OPENNING_TIME' => $request->OPENNING_TIME,
    		'CLOSING_TIME' => $request->CLOSING_TIME,
    		'RES_PHONE' => $request->RES_PHONE,
    		'RES_SCORE' => $request->RES_SCORE
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
        $putdata = file_get_contents("php://input");
        $request = json_decode($putdata);
        $data = array(
            'RES_NAME' => $request->RES_NAME,
            'RES_REVIEW' => $request->RES_REVIEW,
            'RES_LOCALTION' => $request->RES_LOCALTION,
            'OPENNING_TIME' => $request->OPENNING_TIME,
            'CLOSING_TIME' => $request->CLOSING_TIME,
            'RES_PHONE' => $request->RES_PHONE,
            'RES_SCORE' => $request->RES_SCORE,
            'RES_ID' => $id
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