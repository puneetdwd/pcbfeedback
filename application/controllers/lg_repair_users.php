<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lg_repair_users extends Admin_Controller {
        
    public function __construct() {
        parent::__construct();

        //render template
        $this->template->write('title', 'SQIM | LG Repair Users Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');
		$this->load->model('Lg_repair_users_model');
    }
        
    public function index() {
        $this->is_super_admin();
        
        $data = array();
        
        //$data['lg_repair_users'] = $this->Lg_repair_users_model->get_all_lg_repair_users();

        $this->template->write_view('content', 'lg_repair_users/index', $data);
        $this->template->render();
    }
    
    public function add_lg_repair_users($lg_repair_user_id = '') {
        $this->is_super_admin();
        
        $data = array();
        
        if(!empty($lg_repair_user_id)) {
            $lg_repair_user = $this->Lg_repair_users_model->get_lg_repair_user($lg_repair_user_id);
            if(empty($lg_repair_user))
                redirect(base_url().'lg_repair_users');

            $data['lg_repair_user'] = $lg_repair_user;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
			//print_r($post_data);die();
            $post_data['password'] = 'lge@123';
            $response = $this->Lg_repair_users_model->add_lg_repair_user($post_data, $lg_repair_user_id); 
            if($response) {
                $this->session->set_flashdata('success', 'LG Repair User successfully '.(($lg_repair_user_id) ? 'updated' : 'added').'.');
                redirect(base_url().'lg_repair_users');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
       // print_r($data);die();
        $this->template->write_view('content', 'lg_repair_users/add_lg_repair_user', $data);
        $this->template->render();
    }
    
    public function upload_suppliers() {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Supplier_model');
        
        if($this->input->post()) {
             
            if(!empty($_FILES['supplier_excel']['name'])) {
                $output = $this->upload_file('supplier_excel', 'suppliers', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_suppliers($output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Suppliers successfully uploaded.');
                        redirect(base_url().'suppliers');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'suppliers/upload_suppliers', $data);
        $this->template->render();
    }
    
}