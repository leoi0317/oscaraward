<?php
Class Home_model extends CI_Model {

    function __construct() {
		parent::__construct();
	}
	
	public function setProblem($id='', $data='', $info1='', $info2='') {
		if ($this->isExist($id)) {
			$this->db->set('answer', $data);
			$this->db->where('id', $id);
			$this->db->update('tb_ballot');
		} else {
			$this->db->set('answer', $data);
			$this->db->set('id', $id);
			$this->db->insert('tb_ballot');
		}
		
		$this->db->set('last_update', time());
        $this->db->set('info1', $info1);
    	$this->db->set('info2', $info2);
		$this->db->where('id', $id);
		$this->db->update('tb_user');
	}
	
	public function setReset($id) {
		$query = "DELETE FROM tb_ballot WHERE id=$id";
		$query = $this->db->query($query);
	
		$query = "UPDATE tb_user SET score=0, last_update=".time()." WHERE id=$id";
		$query = $this->db->query($query);
	}
	
	public function getProblem($id='') {
		$result = '';
		
		if ($id == '')
			return $result;
		
		$query = "SELECT * FROM tb_ballot WHERE id='$id' LIMIT 1";
		$query = $this->db->query($query);
	
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			$temp = json_decode($row->answer);
			
			foreach ($temp as $item) {
				$result .= $item->value.',';
			}	
			
		}
	
		return $result;
	}
    
    public function getInfo1($id='') {
    	$result = '';
	
		if ($id == '')
			return $result;
	
		$query = "SELECT * FROM tb_user WHERE id='$id' LIMIT 1";
		$query = $this->db->query($query);

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$result = $row->info1;					
		}

		return $result;
	}
	
	public function getInfo2($id='') {
		$result = '';
	
		if ($id == '')
			return $result;
	
		$query = "SELECT * FROM tb_user WHERE id='$id' LIMIT 1";
		$query = $this->db->query($query);

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$result = $row->info2;
		}

		return $result;
	}
	
	public function getAnswer($user_id) {
		$id = '';
		$result = '';
		
		// $user_id = $this->session->userdata['sign']['id'];

		$query = "SELECT * FROM tb_user WHERE level=100 LIMIT 1";
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$id = $row->id;	
			
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
		}
	
		return $result;
	}
	
	public function isExist($id='') {
		if ($id == '')
			return false;
		
		$query = "SELECT id FROM tb_ballot WHERE id='$id'";
		$query = $this->db->query($query);
	
		return $query->num_rows()>0 ? true : false;
	}

	public function allBallots() {
		$query = $this->db->get('tb_ballot');
		$result = $query->result_array();
		return $result;
	}
	
}