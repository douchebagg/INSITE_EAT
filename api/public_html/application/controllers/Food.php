<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Food extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Food_Model');
    }

    public function index_get($res_id) {
        $result = $this->Food_Model->list_all_foods_by_res_id($res_id);
        if(!empty($result)) {
            $this->response(array('food' => $result), 200);
        } else {
            $this->response(array('food' => 'No data in Restaurant api.'), 200);
        }
    }

    public function all_get() {
        $result = $this->Food_Model->list_all_foods();
        if(!empty($result)) {
            $this->response(array('food' => $result), 200);
        } else {
            $this->response(array('food' => 'No data in Restaurant api.'), 200);
        }
    }

    public function find_get($res_id, $food_id) {
        $data = array(
            'RES_ID' => $res_id,
            'FOOD_ID' => $food_id
        );
        $result = $this->Food_Model->list_food($data);
        if(!empty($result)) {
            $this->response(array('food' => $result), 200);
        } else {
            $this->response(array('food' => 'No data in Restaurant api.'), 200);
        }
    }

    public function count_all_get() {
        $result = $this->Food_Model->list_all_foods();
        $this->response(array('size' => count($result)), 200);
    }

    public function count_get($res_id) {
        $result = $this->Food_Model->list_all_foods_by_res_id($res_id);
        $this->response(array('size' => count($result)), 200);
    }

    public function index_post($res_id) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $data = array(
            'FOOD_ID' => $request->FOOD_ID,
            'FOOD_NAME' => $request->FOOD_NAME,
            'FOOD_REVIEW' => $request->FOOD_REVIEW,
            'FOOD_PRICE' => $request->FOOD_PRICE,
            'FOOD_SCORE' => $request->FOOD_SCORE,
            'FOOD_IMAGE' => $request->FOOD_IMAGE,
            'RES_ID' => $res_id,
            'POST_BY' => $request->POST_BY
        );

        $result = $this->Food_Model->add_food($data);
        if($result) {
            $data = array(
                'RES_ID' => $data['RES_ID'],
                'FOOD_ID' => $data['FOOD_ID']
            );
            $result = $this->Food_Model->list_food($data);
            $this->response(array('food' => $result), 201);
        } else {
            $this->response(array('food' => 'Add Food failed.'), 200);
        }
    }

    public function index_put($res_id, $food_id) {
        $putdata = file_get_contents("php://input");
        $request = json_decode($putdata);
        $data = array(
            'FOOD_NAME' => $request->FOOD_NAME,
            'FOOD_REVIEW' => $request->FOOD_REVIEW,
            'FOOD_PRICE' => $request->FOOD_PRICE,
            'FOOD_SCORE' => $request->FOOD_SCORE,
            'POST_BY' => $request->POST_BY,
            'FOOD_IMAGE' => $request->FOOD_IMAGE,
            'RES_ID' => $res_id,
            'FOOD_ID' => $food_id
        );

        $result = $this->Food_Model->update_food($data);
        if($result) {
            $data = array(
                'RES_ID' => $data['RES_ID'],
                'FOOD_ID' => $data['FOOD_ID']
            );
            $result = $this->Food_Model->list_food($data);
            $this->response(array('food' => $result), 200);
        } else {
            $this->response(array('food' => 'Update Food failed.'), 200);
        }
    }

    public function index_delete($res_id, $food_id) {
        $data = array(
            'RES_ID' => $res_id,
            'FOOD_ID' => $food_id
        );
        $result = $this->Food_Model->delete_food($data);
        if($result) {
            $this->response(array('food' => 'Food is deleted successfully.'), 200);
        } else {
            $this->response(array('food' => 'Delete Food failed.'), 200);
        }
    }
}
?>