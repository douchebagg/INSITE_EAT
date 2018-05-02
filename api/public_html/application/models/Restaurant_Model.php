<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_Model extends CI_Model {

    public function list_restaurant($id) {
		$sql = 'SELECT * FROM Restaurant WHERE RES_ID=? LIMIT 1';
		$result = $this->db->query($sql, array('RES_ID' => $id));
		return $result->result_array();
    }

	public function list_all_restaurants() {
		$sql = 'SELECT * FROM Restaurant ORDER BY RES_ID';
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function add_restaurant($data) {
		$sql = 'INSERT INTO Restaurant VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function update_restaurant($data) {
		$sql = 'UPDATE Restaurant SET RES_NAME=?, RES_REVIEW=?, RES_LOCALTION=?, OPENNING_TIME=?, CLOSING_TIME=?, RES_PHONE=?, RES_SCORE=?, UPDATE_TIME=? WHERE RES_ID=?';
		$this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function delete_restaurant($id) {
		$sql = 'DELETE FROM Restaurant WHERE RES_ID=?';
		$result = $this->db->query($sql, array('RES_ID' => $id));
		return (bool)($this->db->affected_rows() > 0);
	}
}
?>