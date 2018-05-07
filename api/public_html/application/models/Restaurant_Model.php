<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_Model extends CI_Model {

    public function list_restaurant($id) {
		$sql = 'SELECT * FROM RESTAURANT WHERE RES_ID=? LIMIT 1';
		$result = $this->db->query($sql, array('RES_ID' => $id));
		return $result->result_array();
    }

	public function list_all_restaurants() {
		$sql = 'SELECT * FROM RESTAURANT ORDER BY RES_ID';
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function list_all_restaurants_by_acc_id($id) {
		$sql = 'SELECT * FROM RESTAURANT WHERE POST_BY_ID=?';
		$result = $this->db->query($sql, array('POST_BY_ID' => $id));
		return $result->result_array();
	}

	public function add_restaurant($data) {
		$sql = 'INSERT INTO Restaurant VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function update_restaurant($data) {
		$sql = 'UPDATE Restaurant SET RES_NAME=?, RES_REVIEW=?, RES_LOCALTION=?, OPENNING_TIME=?, CLOSING_TIME=?, RES_PHONE=?, RES_SCORE=?, RES_IMAGE=?, POST_BY=? WHERE RES_ID=?';
		$this->db->query($sql, $data);
		return (bool)($this->db->affected_rows() > 0);
	}

	public function delete_restaurant($id) {
		$sql_res = 'DELETE FROM Restaurant WHERE RES_ID=?';
		$sql_food = 'DELETE FROM Food WHERE RES_ID=?';
		$this->db->trans_begin();
		$this->db->query($sql_res, array('RES_ID' => $id));
		$this->db->query($sql_food, array('RES_ID' => $id));
		if($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
}
?>