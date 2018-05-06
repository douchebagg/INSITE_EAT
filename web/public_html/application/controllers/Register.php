<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
    	$this->load->model('Register_Model');
	}

	public function index() {
        if($this->session->userdata('user_data') === NULL) {
            if($this->input->method() === 'post') {
                $this->register_user();
            } else {
                $this->load->view('Register_View');
            }
        } else {
            redirect(base_url('home'));
        }
	}

	public function register_user(){
        $user=array(
            'ID'=> md5(uniqid() . $this->input->post('USERNAME')),
            'USERNAME'=>$this->input->post('USERNAME'),
            'PASSWORD'=>md5($this->input->post('PASSWORD')),
            'DISPLAY_NAME'=>$this->input->post('USERNAME')
        );

        $username_check=$this->Register_Model->username_check($user['USERNAME']);

        if($username_check){
            $this->Register_Model->register_user($user);
            $this->load->view('Register_View', array('status' => 1));
        }else{
            $this->load->view('Login_View', array('status' => 0));
        }

    }
}
?>