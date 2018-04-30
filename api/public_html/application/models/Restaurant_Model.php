<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_Model extends CI_Model {

	public function list_all_restaurants() {
		$sql = 'SELECT * FROM Restaurant ORDER BY RES_ID';
		$result = $this->db->query($sql);
		return json_encode($result->result_array());
	}

	public function list_restaurant($id) {
		$sql = 'SELECT * FROM Restaurant WHERE RES_ID=? LIMIT 1';
		$result = $this->db->query($sql, array('RES_ID' => $id));
		return json_encode($result->result_array());
	}

	public function add_restaurant($data) {
		$sql = 'INSERT INTO Restaurant VALUES(?, ?, ?, ?, ?, ?, ? ,?)';
		$this->db->trans_begin();
		$this->db->query($sql, $data);
		$result = $this->db->trans_status();
		$this->db->trans_commit();
		return $result;
	}
}
?>