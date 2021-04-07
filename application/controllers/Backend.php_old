<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	// constructor
	function __construct() {
		parent::__construct();
		
		$this->load->model('home_model');
		$this->load->model('admin_model');
	}


	public function signIn() {
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');

		$user_info = $this->admin_model->signIn($email, $password);
		$state = $user_info!=null ? true : false;
		$msg = !$state ? 'Your email or password is invalid.' : '';

		echo json_encode(array('state'=>$state, 'msg'=>$msg, "user" => $user_info, "year" =>date("Y")));
	}


	public function signUp() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');
		
		if ( $this->admin_model->isExistEmail($email) ) {
			
			$state = false;
			$msg = 'Sorry, email already exists.';
			$user_info = null;
		} else {
			
			$state = $this->admin_model->signUp($name, $email, $password);
			$msg = !$state ? 'Error access to database.' : '';
			
			$user_info = $this->admin_model->signIn($email, $password);
		}
		
		echo json_encode(array('state'=>$state, 'msg'=>$msg, "user" => $user_info, "year" =>date("Y")));
	}

	public function getData() {
		$uid = $this->input->post('uid');
		$data['user_answers'] = $this->home_model->getProblem($uid);
		$data['admin_answers'] = $this->home_model->getAnswer($uid);
        $data['oscar_title'] = $this->home_model->getInfo1($uid);
		$data['how_many'] = $this->home_model->getInfo2($uid);
		$data['correct_answer'] = $this->admin_model->getCountOfCorrectAnswers($uid);
		$data['user'] = $this->admin_model->getUserInfoById($uid);
		$data['problems'] = $this->config->item('problems');
		$data['year'] = date("Y");

		echo json_encode($data);
	}

	public function setProblem() {		
		$problems = $this->input->post('problems');
        $info1 = $this->input->post('oscar_title');
    	$info2 = $this->input->post('how_many');
		$uid = $this->input->post("uid");
		
		$this->home_model->setProblem($uid, $problems, $info1, $info2);		

		echo json_encode(array('status' => true));
	}

	public function changePassword() {	
		$new_pwd = $this->input->post('new_pwd');
		$old_pwd = $this->input->post('old_pwd');
		$uid = $this->input->post("uid");
	
		if ($this->admin_model->isExistUserById($uid, $old_pwd)) {
			$this->admin_model->changePasswordById($uid, $new_pwd);			
			$state = true;
			$msg = 'Your Password changed.';
		} else {
			$state = false;
			$msg = 'Please input old password again. This is invalidate.';
		}
		
		echo json_encode(array('state'=>$state, 'msg'=>$msg));
	}
}
	