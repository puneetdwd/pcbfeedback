<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lg_users extends Admin_Controller {
        
    public function __construct() {
        parent::__construct();

        //render template
        $this->template->write('title', 'SQIM | LG User Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Lg_users_model');
       // $data['lg_users'] = $this->Lg_users_model->get_all_lg_users();

        $this->template->write_view('content', 'lg_users/index', $data);
        $this->template->render();
    }
    
    public function add_supplier($supplier_id = '') {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Supplier_model');
        
        if(!empty($supplier_id)) {
            $supplier = $this->Supplier_model->get_supplier($supplier_id);
            if(empty($supplier))
                redirect(base_url().'suppliers');

            $data['supplier'] = $supplier;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
			//print_r($post_data);die();
            $post_data['password'] = 'lge@123';
            $response = $this->Supplier_model->add_supplier($post_data, $supplier_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Supplier successfully '.(($supplier_id) ? 'updated' : 'added').'.');
                redirect(base_url().'suppliers');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
       // print_r($data);die();
        $this->template->write_view('content', 'suppliers/add_supplier', $data);
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