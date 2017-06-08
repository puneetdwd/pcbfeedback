<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklist extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'SQIM | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($this->product_id);
        $data['product'] = $product;
        
        $this->load->model('Checklist_model');
        
        $data['checklists'] = $this->Checklist_model->get_all_checklists($this->product_id);

        $this->template->write_view('content', 'checklists/index', $data);
        $this->template->render();
    }
    
    public function add_checklist($checklist_id = '') {
        $data = array();
        
        $this->load->model('Checklist_model');
        if(!empty($checklist_id)) {
            $checklist = $this->Checklist_model->get_checklist($this->product_id, $checklist_id);
            if(empty($checklist))
                redirect(base_url().'checklists');

            $data['checklist'] = $checklist;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['product_id'] = $this->product_id;
            
            $response = $this->Checklist_model->update_checklist($post_data, $checklist_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Checklist successfully '.(($checklist_id) ? 'updated' : 'added').'.');
                redirect(base_url().'checklist');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'checklists/add_checklist', $data);
        $this->template->render();
    }
    
    public function delete_checklist($checklist_id) {
        $this->load->model('Checklist_model');

        $checklist = $this->Checklist_model->get_checklist($this->product_id, $checklist_id);
        if(empty($checklist))
            redirect(base_url().'checklist');
            
        $deleted = $this->Checklist_model->delete_checklist($this->product_id, $checklist_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Checklist deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'checklist');
    }
    
    public function status($status) {
        $this->load->model('Product_model');

        $s = ($status == 'active') ? 1 : 0;
        if($this->Product_model->add_product(array('checklist_active' => $s), $this->product_id)) {
            $this->session->set_flashdata('success', 'Status as '.$status);
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
        }

        redirect(base_url().'checklist');
    }

}