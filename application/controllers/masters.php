<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Masters extends Admin_Controller {
	public function __construct() {
        parent::__construct();
        
        $this->template->write('title', 'SQIM | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');
		$this->load->model('Masters_model');
    }
	
	public function index($type) {
		//echo $type;die();
        $this->is_admin_user();
        $data['masters'] = $this->Masters_model->get_all_type($type);
		$data['type'] = $type;
        
        //echo "<pre>"; print_r($data['users']); exit;
        
        $this->template->write_view('content', "masters/index", $data);
        $this->template->render();
    }
	
	public function add($type,$id = '') {
		//echo $type;
		//echo $id;
		//die('n');
        $this->is_admin_user();
        $data = array();
        
        

        if(!empty($id)) {
            $type_response = $this->Masters_model->get_type_by_id($type,$id);
            $type_response=$type_response[0];
            if(empty($type_response)){
                redirect(base_url().'masters/index/'.$type);
            }

            $data['type_response'] = $type_response;
          //  print_r($data);
        }
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('name', 'Name', 'trim|required|xss_clean');
            //$validate->set_rules('mobile', 'Product', 'required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data                  = $this->input->post();

                $id = !empty($type_response[$type.'_id']) ? $type_response[$type.'_id'] : '';
//echo $id;die();

				$type_id = $this->Masters_model->update_type($post_data, $id,$type);
				if($type_id) {

					$this->session->set_flashdata('success', $type.' successfully added.');
					redirect(base_url().'masters/index/'.$type );
				} else {
					$data['error'] = 'Something went wrong, Please try again.';
				}

                

            } else {
                $data['error'] = validation_errors();
            }
        }
		$data['type']=$type;
        $this->template->write_view('content', 'masters/add_type', $data);
        $this->template->render();
    }
	
	
	public function delete($type,$id = '') {
		if(empty($id)){
			redirect(base_url().'masters/index/'.$type);
		}
		$delete_response = $this->Masters_model->delete_type_by_id($type,$id);
		if($delete_response){
			$this->session->set_flashdata('success', $type.' successfully deleted.');
					redirect(base_url().'masters/index/'.$type );
		}
		else{
			$data['error'] = 'Something went wrong, Please try again.'; 
		}
		$data['type']=$type;
        $this->template->write_view('content', 'masters/index/'.$type, $data);
        $this->template->render();
	}
	
	public function get_all_data($type){
		$get_id = $this->Masters_model->get_all_data($type);
		
		echo json_encode($get_id);
	}
	
	public function get_all_repair_data(){
		$get_id = $this->Masters_model->get_all_repair_data();
		
		echo json_encode($get_id);
	}
	
	public function lg_repair_save_data(){
			$postData=$this->input->post();
		$this->load->model('Supplier_model');

		$responseData=$this->Masters_model->insertLGRepairData($postData);
	}
	
}