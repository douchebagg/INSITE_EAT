<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if($this->input->method() === 'post') {
			if($this->input->post('token') !== NULL) {
				$session = array(
					'token' => $this->input->post('token'),
					'name' => $this->input->post('name')
				);
				$this->session->set_userdata('user_data', $session);
			} else {
				$this->login();
				redirect('home');
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
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		//set validations
		$this->form_validation->set_error_delimiters('<div class="error" style="color: red;">', '</div>');
		$this->form_validation->set_rules("username", "Username", "trim|required|alpha_numeric");
		$this->form_validation->set_rules("password", "Password", "trim|required");

		if ($this->form_validation->run() == FALSE) {
			//validation fails
			$exception = array(
				'username' => form_error('username')
			);
			$this->load->view('Login_View', $exception);
		} else {
			//validation succeeds
			if ($this->input->post('login') == "Login") {
				//check if username and password is correct
				$usr_result = $this->Login_Model->get_user($username, $password);
				if($usr_result) {
					foreach($usr_result as $row) {
						$sessArray = array(
						'token' => $row->ID,
						'name' => $row->DISPLAY_NAME,
						);
						$this->session->set_userdata($sessArray);
					}

				} else {
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Invalid username and password!</div>');
					redirect('Login/login');
				}
			} else {
				redirect('Login/login');
			}
		}
	}
}
?>