<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	// constructor
	function __construct() {
		parent::__construct();
		
		$this->load->model('admin_model');
    
		if (isset($this->session->userdata['sign'])) {
			$userInfo = $this->admin_model->getUserCurInfo();
			$this->session->set_userdata('sign', $userInfo);
            if ($userInfo['level'] == '101') {
               echo '<script> window.location="'.base_url().'";</script>';
            }
		}
	}
	
	// view
	
	public function user() {
		if (!isset($this->session->userdata['sign'])) {
			
			header("Location: " . base_url());
		} else {
			
			$data['title'] = "OSCARS BALLOT-ADMIN";
			$data['isLogin'] = isset($this->session->userdata['sign']);
			$data['list'] = $this->admin_model->getUserList();
			
			$this->load->view('user', $data);
		}
	}
	
	public function problem() {
		if (!isset($this->session->userdata['sign'])) {
			
			header("Location: " . base_url());
		} else {
			
			$data['title'] = "OSCARS BALLOT-ADMIN";
			$data['isLogin'] = isset($this->session->userdata['sign']);
			$data['problems'] = $this->config->item('problems');
			
			$data['admin_answers'] = '';
			
			if (isset($this->session->userdata['sign'])) {
				$info = $this->session->userdata['sign'];
				$data['admin_answers'] = $this->admin_model->getAnswer($info['id']);
			}
			
			$this->load->view('problem', $data);
		}
	}
	
	public function sendmail($from , $to , $subject , $message){

		$this->load->library('phpmailer_lib');
		$mail = $this->phpmailer_lib->load();
		
		$auth = true;

		if ($auth) {
			$mail->IsSMTP(); 
			// $mail->SMTPAuth = true; 
			$mail->SMTPSecure = "ssl"; 
			$mail->Host = "mail.example.com"; 
			$mail->Port = 465; 
			$mail->Username = "blue.apple30k@gmail.com"; 
			$mail->Password = "Pureness1201!"; 
		}

		$mail->addAddress($to);
		$mail->SetFrom("blue.apple30k@gmail.com", "John Deo");
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $message;

		try {
			$result = $mail->Send();
			echo json_encode(array('state'=>$result,'message'=>$message));
		} catch(Exception $e){
			echo json_encode(array('state'=>false,'message'=>$message));
		}
	}

	public function forgetpassword(){
		$email = $this->input->post('email');
		$result = $this->admin_model->changePassword($email , "123456");

		$from = "blue.apple30k@gmail.com";
        $subject = "Your Password";
        $message = "123456";

		$this->sendmail($from , $email , $subject , $message);
	}

	public function send_email() {
		$from = "blue.apple30k@gmail.com";
        $to = $this->input->post('to');
        $subject = $this->input->post('subject');
        $message = rand(1000,100000);
		
		$this->sendmail($from , $to , $subject , $message);
    }

	// action
	public function userverify(){
		$email= $this->input->post('email');
		$sval= $this->input->post('inputkey');
		$vk = $this->input->post('key');
		$rlt=false;
		if($sval[0]==$vk[0]){
			$rlt = $this->admin_model->changeverify($email);
		}
		echo json_encode(array('state'=>$rlt));
	}

	public function signIn() {
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');
		
		$user_info = $this->admin_model->signIn($email, $password);
		// register user information into Session
		$state = $user_info!=null ? true : false;
		$msg = !$state ? 'Your email or password is invalid.' : '';
		
		$url = base_url();
		if($user_info != null) {
			if($user_info['level'] == "100")
				$url = base_url().'admin/user';
		}

		if($user_info['Verify']==0 and $user_info!=null){
			echo json_encode(array('state'=>$state, 'msg'=>$msg, 'url'=>$url , 'verify'=>false));
			return ;
		}

		$this->session->set_userdata('sign', $user_info);
		
		
		echo json_encode(array('state'=>$state, 'msg'=>$msg, 'url'=>$url , 'verify'=>true));
	}
	
	public function signOut() {
		$this->session->unset_userdata('sign');
		echo json_encode(array('state'=>true, 'msg'=>''));
	}
	
	public function signUp() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');
		
		if ( $this->admin_model->isExistEmail($email) ) {
			
			$state = false;
			$msg = 'Sorry, email already exists.';
		} else {
			$state = $this->admin_model->signUp($name, $email, $password);
			$msg = !$state ? 'Error access to database.' : '';			
			// $user_info = $this->admin_model->signIn($email, $password);
			// $this->session->set_userdata('sign', $user_info);
		}
		
		echo json_encode(array('state'=>$state, 'msg'=>$msg));
	}
	
	public function changePassword() {	
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
		
		$info = $this->session->userdata['sign'];
		$email = $info['email'];
		$new_pwd = $this->input->post('new_pwd');
		$old_pwd = $this->input->post('old_pwd');
		
		if ($this->admin_model->isExistUser($email, $old_pwd)) {
			$this->admin_model->changePassword($email, $new_pwd);
			
			$user_info = $this->admin_model->signIn($email, $new_pwd);
			$this->session->unset_userdata('sign');
			$this->session->set_userdata('sign', $user_info);
			
			$state = true;
			$msg = 'Your Password changed.';
		} else {
			$state = false;
			$msg = 'Please input old password again. This is invalidate.';
		}
		
		echo json_encode(array('state'=>$state, 'msg'=>$msg));
	}
	
	public function isExistUser() {
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');
	}	
	
	public function setProblem() {
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
	
		$problems = $this->input->post('problems');
		$info = $this->session->userdata['sign'];

		$this->admin_model->setAnswer($info['id'], $problems);
        
        $users = $this->admin_model->getUserList();
        foreach($users as $user) {
            if ($user["level"] == '101') {
                $this->admin_model->getCountOfCorrectAnswers($user['id']);
            }    
        }
        echo base_url().'admin/problem';
	}
	
	public function setReset() {
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
	
		$info = $this->session->userdata['sign'];

		$this->admin_model->setReset($info['id']);
        $users = $this->admin_model->getUserList();
        foreach($users as $user) {
            if ($user["level"] == '101') {
                $this->admin_model->setUserData($user['id'], array('correct_categories' => 0));
            }    
        }
         echo base_url().'admin/problem';
	}
	
	public function deleteUser() {
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
		
		$id = $this->input->post('id');
		$this->admin_model->deleteUser($id);
        
         echo base_url().'admin/user';
	}
	
}