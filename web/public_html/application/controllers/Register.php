<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
    	$this->load->library('session');
    	$this->load->model('Register_Model');
	}

	public function index() {
		if($this->input->method() === 'post') {
			
		} else {
			$this->load->view('Register_View');
		}
	}
	public function register_user(){

    $user=array(
        'USERNAME'=>$this->input->post('USERNAME'),
        'PASSWORD'=>md5($this->input->post('PASSWORD')),
        'DISPLAY_NAME'=>$this->input->post('USERNAME')
    );
    print_r($user);

    $username_check=$this->Register_Model->username_check($user['USERNAME']);

    if($username_check){
        $this->Register_Model->register_user($user);
        $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
        redirect('Login');

    }else{

        $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        redirect('Register');
    }

}
}
?>