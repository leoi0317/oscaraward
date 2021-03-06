<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	// constructor
	function __construct() {
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->helper('email');

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
	
	public function forgetpassword(){
		$email = $this->input->post('email');
		$result = $this->admin_model->isExistEmail($email);

		$msg1=$this->check_email($email);
		if($msg1!='true')
		{
			$url = base_url().'admin/user';
			echo json_encode(array('state'=>false, 'msg'=>$msg1, 'url'=>$url , 'verify'=>false));
			return ;
		}

		if($result==false){
			echo json_encode(array('state'=>false,'msg'=>"Email is not Exist!",'isemail'=>$result));
			return ;
		}

		$this->admin_model->changePassword($email , "123456");

		$from = "blue.apple30k@gmail.com";
        $subject = "Your Password";
        $message = rand(1000,100000);
		$result1=$this->admin_model->send_email($from , $email , $subject , $message);
		echo json_encode(array('state'=>$result1,'isemail'=>$result , 'msg'=>"Sucess Set password!"));
	}

	public function send_email() {
		$from = "blue.apple30k@gmail.com";
        $to = $this->input->post('to');
        $subject = $this->input->post('subject');
        $message = rand(1000,100000);
		$result=$this->admin_model->send_email($from , $to , $subject , $message);
		echo json_encode(array('state'=>$result,'message'=>$message));
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

	private static function get_banned_domains()
    {
        //where we store the banned domains
        $file = 'banned_domains.json';

        //if the json file is not in local or the file exists but is older than 1 week, regenerate the json
        if (!file_exists($file) OR (file_exists($file) AND filemtime($file) < strtotime('-1 week')) )
        {
            $banned_domains = file_get_contents("https://rawgit.com/ivolo/disposable-email-domains/master/index.json");
            if ($banned_domains !== FALSE)
                file_put_contents($file,$banned_domains,LOCK_EX);
        }
        else//get the domains from the file
            $banned_domains = file_get_contents($file);

        return json_decode($banned_domains);
    }

	public function check_email($email){
        //get the email to check up, clean it
        $email = filter_var($email,FILTER_SANITIZE_STRING);

        // 1 - check valid email format using RFC 822
        if (filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE) 
            return 'No valid email format';

        //get email domain to work in nexts checks
        $email_domain = preg_replace('/^[^@]++@/', '', $email);

        // 2 - check if its from banned domains.
        // if (in_array($email_domain,self::get_banned_domains()))
        //     return 'Banned domain '.$email_domain;

        // 3 - check DNS for MX records
        if ((bool) checkdnsrr($email_domain, 'MX')==FALSE)
            return 'DNS MX not found for domain '.$email_domain;
		
        // 4 - wow actually a real email! congrats ;)
        return 'true';
	}

	public function signIn() {
		$email = $this->input->post('email');
		$password = $this->input->post('pwd');

		$msg1=$this->check_email($email);
		if($msg1!='true')
		{
			$url = base_url().'admin/user';
			echo json_encode(array('state'=>false, 'msg'=>$msg1, 'url'=>$url , 'verify'=>false));
			return ;
		}

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

		$msg1=$this->check_email($email);

		if($msg1!='true')
		{
			$url = base_url().'admin/user';
			echo json_encode(array('state'=>false, 'msg'=>$msg1,));
			return ;
		}

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