<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
	// constructor
	function __construct() {
		parent::__construct();
	
		$this->load->model('home_model');
		$this->load->model('admin_model');
		if (isset($this->session->userdata['sign'])) {
			$userInfo = $this->admin_model->getUserCurInfo();
			$this->session->set_userdata('sign', $userInfo);
            if ($userInfo['level'] == '100') {
               echo '<script> window.location="'.base_url().'admin/user";</script>';
            }
		}
	}
	
	// view
	public function index() {
		$data['title'] = "OSCARS BALLOT";
		$data['isLogin'] = isset($this->session->userdata['sign']);
		$data['info'] = isset($this->session->userdata['sign']) ? $this->session->userdata['sign'] : null;		
		$data['problems'] = $this->config->item('problems');
		$data['admin_answers'] ='';
		$data['user_answers'] = '';
        $data['info1'] = '';
    	$data['info2'] = '';

    	$data['percent'] = $this->calcPercent();
    	$data['info3'] = 0;
		
		if (isset($this->session->userdata['sign'])) {

			$info = $this->session->userdata['sign'];
			$data['user_answers'] = $this->home_model->getProblem($info['id']);
			$data['admin_answers'] = $this->home_model->getAnswer($info['id']);
            $data['info1'] = $this->home_model->getInfo1($info['id']);
    		$data['info2'] = $this->home_model->getInfo2($info['id']);
    		$data['info3'] = $this->admin_model->getCountOfCorrectAnswers($info['id']);
		}
		
		$this->load->view('home', $data);
	}
	
	// action
	public function setProblem() {
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
		
		$problems = $this->input->post('problems');
        $info1 = $this->input->post('info1');
    	$info2 = $this->input->post('info2');
		$info = $this->session->userdata['sign'];
		
		$this->home_model->setProblem($info['id'], $problems, $info1, $info2);		
	}
	
	public function setReset() {
		if (!isset($this->session->userdata['sign']))
			header("Location: " . base_url());
		
		$info = $this->session->userdata['sign'];
		
		$this->home_model->setReset($info['id']);
	}

	public function allBallots() {
		$ballots = $this->home_model->allBallots();
		return $ballots;
	}

	public function calcPercent() {
		$ballots = $this->allBallots();
		$problems = $this->config->item('problems');
		$percentArray = array();
		$answers = array();
		if (count($ballots) != 0) {
			foreach ($ballots as $ballot) {
				if ($ballot['answer'] != "") {
				$answer = json_decode($ballot['answer']);
				

					//var_dump($answer);
					foreach ($answer as $answer_item) {
						if (isset($answers[$answer_item->name][$answer_item->value])) {
							$answers[$answer_item->name][$answer_item->value] ++;
						} else {
							$answers[$answer_item->name][$answer_item->value] = 1;
						}
					}
				}
			}
		}
		
		for ($i = 0 ; $i< count($problems) ; $i ++) {
			for ($j = 0; $j< count($problems[$i]['data']); $j++ ) {
				// var_dump($problems[$i]['data'][$j]);
				if (isset($answers[$i])) {
					$all_count = array_sum($answers[$i]);
					foreach ($answers[$i] as $key => $value) {
						$percentArray[$i][$key] = round($value / $all_count * 100);
					}	
				}
				
			}
		}
		// var_dump($percentArray);
		return $percentArray;
	}
	
	
}