<?php

Class Admin_model extends CI_Model {
    
	function __construct() {
		parent::__construct();
	}
	
	public function signIn($email='', $pwd='') {
		if ($this->isExistUser($email, $pwd)) 
			return $this->getUserInfo($email, $pwd);		
		
		return null;
	}
	
	public function signUp($name='', $email='', $pwd='') {
		$this->db->set('pwd', md5($pwd));
		$this->db->set('email', $email);
		$this->db->set('name', $name);
		$this->db->set('last_update', time());
		$this->db->insert('tb_user');	
		
		return true;
	}
	
	public function changePassword($email='', $pwd='') {
		$this->db->set('pwd', md5($pwd));
		$this->db->where('email', $email);
		$this->db->update('tb_user');
		
		return true;
	}

	public function changePasswordById($id='', $pwd='') {
		$this->db->set('pwd', md5($pwd));
		$this->db->where('id', $id);
		$this->db->update('tb_user');
		
		return true;
	}
	
	public function isExistEmail($email='') {
		if ($email == '')
			return false;
		
		$query = "SELECT id FROM tb_user WHERE email='$email'";
		$query = $this->db->query($query);
	
		return $query->num_rows()>0 ? true : false;
	}

	public function isExistUserById($id, $password) {
		
		
		$query = "SELECT id FROM tb_user WHERE id='$id' AND pwd=MD5('$password')";
		
		$query = $this->db->query($query);
		
		return $query->num_rows()>0 ? true : false;
	}
	
	public function isExistUser($email='', $pwd='') {
		if ($email == '' || $pwd == '')
			return false;
		
		$query = "SELECT id FROM tb_user WHERE email='$email' AND pwd=MD5('$pwd')";
		$query = $this->db->query($query);
		
		return $query->num_rows()>0 ? true : false;
	}
	
	public function getUserInfo($email='', $pwd='') {
		$result = array();
		
		if ($email == '' || $pwd == '')
			return $result;
		
		$query = "SELECT * FROM tb_user WHERE email='$email' AND pwd=MD5('$pwd') LIMIT 1";
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
		
			$result = array('id'=>$row->id, 'name'=>$row->name, 'email'=>$row->email, 'password'=>$row->pwd, 'level'=>$row->level, 'score'=>$row->score, 'how_many'=>$row->info2, 'oscar_title' => $row->info1);
		}		
		
		return $result;		
	}

	public function getUserCurInfo() {
		$info = $this->session->userdata['sign'];
		$this->db->where('id', $info['id']);
		$query = $this->db->get('tb_user');
		$result = $query->result_array();
		if (count($result) > 0)
		{
			return $result[0];
		}
		return null;
	}
	
	public function getUserList() {
		$result = array();
		
		$query = "SELECT * FROM tb_user WHERE level<>100";
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
		
			foreach ($query->result() as $row) {
				$result[] = array(
						'id' => $row->id,
						'name' => $row->name,
						'email' => $row->email,
                        'info1' => $row->info1,
    					'info2' => $row->info2,
						'lastUpdate' => gmdate("Y-m-d", $row->last_update),
						'score' => $row->score,
                        'correct_categories' => $row->correct_categories,
                        'level' => $row->level
				);
			}
		}
		
		return $result;
	}
	
	public function setAnswer($id, $answer) {
		$query = "SELECT * FROM tb_ballot WHERE id=$id";
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
			$this->db->set('answer', $answer);
			$this->db->where('id', $id);
			$this->db->update('tb_ballot');
		} else {
			$this->db->set('answer', $answer);
			$this->db->set('id', $id);
			$this->db->insert('tb_ballot');
		}
		
		$this->setScore($id);
	}
	
	public function getAnswer($id='') {
		$result = '';
	
		if ($id == '')
			return $result;
	
		$query = "SELECT * FROM tb_ballot WHERE id='$id' LIMIT 1";
		$query = $this->db->query($query);

		if ($query->num_rows() > 0) {
			$row = $query->row();
				
			$temp = json_decode($row->answer);
			if ($temp != "") {
				foreach ($temp as $item) {
					$result .= $item->value.',';
				}	
			}
			
				
		}

		return $result;
	}

	public function getAdminAnswer() {
		$result = '';
		$adminID = $this->getAdminID();
		$query = "SELECT * FROM tb_ballot WHERE id=$adminID LIMIT 1";
		$query = $this->db->query($query);

		if ($query->num_rows() > 0) {
			$row = $query->row();
				
			$temp = json_decode($row->answer);
			if ($temp != "") {
				foreach ($temp as $item) {
					$result .= $item->value.',';
				}	
			}
			
				
		}
		return $result;
	}
	
	public function setReset($id) {
		$query = "DELETE FROM tb_ballot WHERE id=$id";
		$query = $this->db->query($query);
		
		$this->setResetScore();
	}
	
	public function setScore($id) {
		//$dic = array(3,3,3,3,3,2,3,3,7,7,5,5,2,7,2,5,2,3,5,3,10,2,6,6);
		$dic = $this->config->item('problems');
		$answer = $this->getAnswer($id);		
		
		$query = "SELECT * FROM tb_ballot WHERE id<>$id";
		$query = $this->db->query($query);
			
		foreach ($query->result() as $row) {
			$score = 0;
			$data = json_decode($row->answer, true);
		
			foreach ($data as $item) {
				$aaa = $item['value'];
				if(strpos($answer, $item['value'])!==false) {
					$score += $dic[$item['name']]['score'];
				}
			}
		
			$this->db->set('score', $score);
			$this->db->where('id', $row->id);
			$this->db->update('tb_user');
		}
	}

	public function getCountOfCorrectAnswers($id) {
		$dic = $this->config->item('problems');
		$answer = $this->getAdminAnswer();		
		
		if($answer == "") {
			return 0;
		}

		$query = "SELECT * FROM tb_ballot WHERE id=$id";
		$query = $this->db->query($query);
		$count = 0;

		foreach ($query->result() as $row) {
			$score = 0;
			// var_dump($row);
			$data = json_decode($row->answer, true);
		
			foreach ($data as $item) {
				$aaa = $item['value'];
				if(strpos($answer, $item['value'])!==false) {
					// $score += $dic[$item['name']]['score'];
					$count ++;
				}
			}
		}
        
        $this->db->where('id', $id);
        $this->db->update("tb_user", array('correct_categories' => $count));
		return $count;
	}
	
	public function setResetScore() {
		$query = "UPDATE tb_user SET score=0";
		$query = $this->db->query($query);
	}
	
	public function deleteUser($id) {
		$this->db->where('id', $id);
		$this->db->delete('tb_user');
		
		$this->db->where('id', $id);
		$this->db->delete('tb_ballot');
	}

	public function getAdminID() {
		$this->db->where('level', 100);
		$query = $this->db->get('tb_user');
		$result = $query->result_array();
		if (count($result) == 0) {
			return false;
		}
		else {
			return $result[0]['id'];
		}
	}
    
    public function setUserData($userId, $data) {
        $this->db->where('id', $userId);
        $this->db->update('tb_user', $data);
    }

    public function getUserInfoById($id) {
		$result = array();
		
		if ($id == "")
			return $result;
		
		$query = "SELECT * FROM tb_user WHERE id=".$id." LIMIT 1";
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
		
			$result = array('id'=>$row->id, 'name'=>$row->name, 'email'=>$row->email, 'password'=>$row->pwd, 'level'=>$row->level, 'score'=>$row->score);
		}		
		
		return $result;		
	}
	
}
