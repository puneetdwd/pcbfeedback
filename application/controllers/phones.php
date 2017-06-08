<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phones extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'SQIM | Phone Number Module');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function index() {
        $data = array();
        $this->load->model('Phone_model');
        
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        $data['phone_numbers'] = $this->Phone_model->get_all_phone_numbers($supplier_id);

        $this->template->write_view('content', 'phones/index', $data);
        $this->template->render();
    }
        
    public function add_phone_number($phone_number_id = '') {
        $data = array();
        $this->load->model('Phone_model');
        
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        if($this->user_type !== 'Supplier') {
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        }
        
        if(!empty($phone_number_id)) {
            $phone_number = $this->Phone_model->get_phone_number($phone_number_id, $supplier_id);
            if(empty($phone_number))
                redirect(base_url().'phones');

            $data['phone_number'] = $phone_number;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            if($this->user_type === 'Supplier') {
                $post_data['supplier_id'] = $this->id;
            }
            
            $response = $this->Phone_model->update_phone_number($post_data, $phone_number_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Phone Number successfully '.(($phone_number_id) ? 'updated' : 'added').'.');
                redirect(base_url().'phones');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }

        $this->template->write_view('content', 'phones/add_phone_number', $data);
        $this->template->render();
    }
    
    public function delete_phone_number($phone_number_id) {
        $this->load->model('Phone_model');

        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        $phone_number = $this->Phone_model->get_phone_number($phone_number_id, $supplier_id);
        if(empty($phone_number))
            redirect(base_url().'phones');
            
        $deleted = $this->Phone_model->delete_phone_number($phone_number_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Phone Number deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'phones');
    }
}