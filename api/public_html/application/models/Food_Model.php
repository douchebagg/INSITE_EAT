<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_Model extends CI_Model {

    public function list_food($id) {
		$sql = 'SELECT * FROM Food WHERE RES_ID=? AND FOOD_ID=? LIMIT 1';
		$result = $this->db->query($sql, $id);
		return $result->result_array();
    }

	public function list_all_foods_by_res_id($res_id) {
		$sql = 'SELECT * FROM Food WHERE RES_ID=? ORDER BY FOOD_ID';
		$result = $this->db->query($sql, array('RES_ID' => $res_id));
		return $result->result_array();
	}

	public function list_all_foods() {
		$sql = 'SELECT * FROM Food ORDER BY FOOD_ID';
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function add_food($data) {
		$sql = 'INSERT INTO Food VALUES(?, ?, ?, ?, ?, ?, ?)';
		$result = $this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function update_food($data) {
		$sql = 'UPDATE Food SET FOOD_NAME=?, FOOD_REVIEW=?, FOOD_PRICE=?, FOOD_SCORE=?, UPDATE_TIME=? WHERE RES_ID=? AND FOOD_ID=?';
		$this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function delete_food($id) {
		$sql = 'DELETE FROM Food WHERE RES_ID=? AND FOOD_ID=?';
		$result = $this->db->query($sql, $id);
		return (bool)($this->db->affected_rows() > 0);
	}
}
?>