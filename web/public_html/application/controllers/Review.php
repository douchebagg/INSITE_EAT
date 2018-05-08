<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {
	public function index() {
		if($this->session->userdata('user_data') !== NULL) {
			$this->load->view('MyReview_View');
		} else {
			redirect(base_url('home'));
		}
	}

	public function add() {
		if($this->session->userdata('user_data') !== NULL) {
			if($this->input->method() === 'post') {
var_dump($_FILES); die;
				if($_FILES['photo']['name'] !== '') {
                    $config['upload_path'] = '/var/www/html/images/';
                    $config['file_name'] = $photo['name'];
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = '512';
                    $config['min_width'] = '200';
                    $config['min_height'] = '200';
                    
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('photo')) {
                        $do_upload = true;
                        array_push($data, $config['file_name']);
                    } else {
                        $this->load->view('AddReview_View', array("exception" => "Upload image failed, " . $this->upload->display_errors()));
                        return;
                    }
                }
				$this->load->view('AddReview_View', array('added' => true));
			} else {
				$this->load->view('AddReview_View');
			}
		} else {
			redirect(base_url('home'));
		}
	}

	public function edit() {
		if($this->session->userdata('user_data') !== NULL) {
			$data['data'] = array(
				'type' => $this->input->get('type'),
				'res_id' => $this->input->get('res_id'),
				'food_id' => $this->input->get('food_id')
			);
			$this->load->view('EditReview_View', $data);
		} else {
			redirect(base_url('home'));
		}
	}
}
?>