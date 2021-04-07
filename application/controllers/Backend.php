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
        
        /* UserList POST API  */
        function userlist(){
            $userdata = $this->admin_model->getUserData();
            if(isset($userdata) && !empty($userdata) && count($userdata)>0){
                $data['msg'] = 1;
                $data['data'] = $userdata;
            }else{
                $data['msg'] = 0;
                $data['data'] = array();
            }
            echo json_encode($data);
        }
        /* ProblemList POST API  */
        function problems(){
            $data['problems'] = $this->config->item('problems');
            $data['admin_answers'] = $this->admin_model->getAdminAnswer();
            $data['msg'] = "Problems and Admin Answers.";
            echo json_encode($data);
        }
        /* Reset Problem POST API  */
        function reset(){
            $id = $this->input->post('a_id');
            $this->admin_model->setReset($id);
            $users = $this->admin_model->getUserList();

            foreach($users as $user) {
                if ($user["level"] == '101') {
                    $this->admin_model->setUserData($user['id'], array('correct_categories' => 0));
                }    
            }
            $resetuserslist = $this->admin_model->getUserList();
            if(isset($resetuserslist) && !empty($resetuserslist) && count($resetuserslist)>0){
                $data['msg'] = 1;
                $data['data'] = $resetuserslist;
            }else{
                $data['msg'] = 0;
                $data['data'] = array();
            }
            echo json_encode($data);
        }
       
        /* Delete User POST API */
        function deleteUser() {
            $uid = $this->input->post('uid');
            $userdata = $this->admin_model->delete_User($uid);
            if(isset($userdata) && !empty($userdata) && count($userdata)>0){
                $data['msg'] = "User Deleted Successfully.";
            }else{
                $data['msg'] = "User Not Found.";
            }
            echo json_encode($data);
	}
        
        /* Admin Save Problems GET API */
        public function AdminSaveProblem() {
           $problems = $this->input->post('problems');
                $uid = $this->input->post("uid");
    	
		$status = $this->home_model->AdminSaveProblem($uid, $problems);		

                if(isset($status) && !empty($status) && count($status) > 0){
                    echo json_encode(array('msg' => 1,'data' => 'Answer Added Successfully'));
                }else{
                    echo json_encode(array('msg' => 0,'data' => 'Something went wrong.'));
                }
		
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
	