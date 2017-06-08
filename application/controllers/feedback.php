<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->template->write_view('header', 'templates/header', array('page' => 'pcb-feedback'));
        $this->template->write_view('footer', 'templates/footer');
    }
	
	public function pcb() {
		$data='';
		$data['sessiondata']=$this->session->userdata;
		$this->template->write('title', 'SQIM | PCB Feedback');
		$this->template->write_view('content', 'feedback/pcb', $data);
        	$this->template->render();
	}
	public function lg_user() {
		if($this->session->userdata('user_type')!='LG User'){
			redirect(base_url());	
		}
		$data='';
		$data['sessiondata']=$this->session->userdata;
		// print_r($this->session->userdata);die();
		$this->template->write('title', 'SQIM | User Feedback');
		$this->template->write_view('content', 'feedback/lg_user', $data);
        $this->template->render();
	}
	public function all_user() {
		echo "aaa";
		$data='';
		$data['sessiondata']=$this->session->userdata;
                //echo  "<pre>";
		//print_r($this->session);die();
		$this->template->write('title', 'SQIM | User Feedback');
		$this->template->write_view('content', 'feedback/all_user', $data);
        $this->template->render();
	}
	
	public function lg_repair() {
		if($this->session->userdata('user_type')!='LG Repair'){
			redirect(base_url());	
		}
		$data='';
		$data['sessiondata']=$this->session->userdata;
		//print_r($this->session->userdata);die(); 
		$this->template->write('title', 'SQIM | Repair Feedback');
		$this->template->write_view('content', 'feedback/lg_repair_user', $data);
        $this->template->render();
	}

}