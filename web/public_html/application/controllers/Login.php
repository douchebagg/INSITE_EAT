<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Login_Model');
	}

	public function index() {
		if($this->input->method() === 'post') {
			if($this->input->post('token') !== NULL) {
				$token = md5($this->input->post('token'));
				$name = $this->input->post('name');

				$result = $this->Login_Model->get_user_by_token($token);

				if(empty($result)) {
					$this->Login_Model->add_user_by_token($token, $name);
				} else {
					if($result[0]['DISPLAY_NAME'] !== $name) {
						$this->Login_Model->update_user_by_token($token, $name);
					}
				}
				$session = array(
					'token' => $token,
					'name' => $name,
					'other' => true
				);
				$this->session->set_userdata('user_data', $session);
			} else {
				$this->login();
			}
		} else {
			if($this->session->userdata('user_data') === NULL) {
				$this->load->view('Login_View');
			} else {
				redirect(base_url('home'));
			}
		}
	}

	public function login() {
		$username = $this->input->post("USERNAME");
		$password = md5($this->input->post("PASSWORD"));

		$this->form_validation->set_rules("username", "Username", "trim|required|alpha_numeric");
		$this->form_validation->set_rules("password", "Password", "trim|required");

		$usr_result = $this->Login_Model->get_user($username, $password);
		if($usr_result) {
			foreach($usr_result as $row) {
				$sessArray = array(
					'token' => $row['ID'],
					'username' => $row['USERNAME'],
					'name' => $row['DISPLAY_NAME'],
					'other' => false
				);
				$this->session->set_userdata('user_data', $sessArray);
			}
			redirect(base_url('home'));
		} else {
			$this->load->view('Login_View', array('status' => 0));
		}
	}
}
?>