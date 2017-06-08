<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sampling extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        if(!$this->product_id) {
            redirect(base_url());
        }
        
        $page = 'pp';
        $sampling_configs_fns = array('configs', 'delete_config', 'update_inspection_config');
        if(in_array($this->router->fetch_method(), $sampling_configs_fns)) {
            $page = 'sampling_configs';
        }
        //echo $page;exit;
        //render template
        $this->template->write('title', 'SQIM | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => $page));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function index() {
        $data = array();
        $this->load->model('Sampling_model');
        $data['production_plans'] = $this->Sampling_model->get_production_plans();
        
        $this->template->write_view('content', 'sampling_plans/index', $data);
        $this->template->render();
    }
    
    public function configs() {
        $data = array();
        
        $this->load->model('Checkpoint_model');
        $data['checkpoints'] = $this->Checkpoint_model->get_all_checkpoint();
        
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        $this->load->model('Product_model');
        $data['parts'] = $this->Product_model->get_all_distinct_part_name($this->product_id, $supplier_id);

        if($this->input->post()) {
            $data['part_nums'] = $this->Product_model->get_all_part_numbers_by_part_name($this->input->post('part_name'));
            
            $this->load->model('Sampling_model');
            
            $data['configs'] = $this->Sampling_model->get_configs($this->input->post('checkpoint_id'), $this->input->post('part_id'), $supplier_id);
        }else{
            $data['part_nums'] = '';
            $data['configs'] = '';
        }
        
        $this->template->write_view('content', 'sampling_plans/configs', $data);
        $this->template->render();
    }   
    
    public function update_inspection_config($config_id = '') {
        $data = array();
        
        $this->load->model('Sampling_model');
        if(!empty($config_id)) {
            $config = $this->Sampling_model->get_inspection_config_by_id($config_id, $this->product_id);
            //echo "<pre>"; print_r($config); exit;
            if(empty($config)) {
                $this->session->set_flashdata('error', 'Invalid record.');
                redirect(base_url().'sampling/configs');
            }
            
            $range = $this->Sampling_model->get_lot_range_samples($config['id']);
            
            $sampling_config = $this->Sampling_model->get_lot_range_samples_c($config['id']);
            //echo "<pre>";print_r($range);exit;
            $data['inspection_config'] = $config;
            $data['config_range'] = $range;
            $data['sampling_config'] = $sampling_config;
        }
        
        $this->load->model('Checkpoint_model');
        $data['checkpoints'] = $this->Checkpoint_model->get_all_checkpoint();
        
        $this->load->model('Product_model');
        if($this->user_type == 'Supplier') {
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->id);
        } else {
            $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        }
        
        $lots = $this->Sampling_model->get_lot_template();
        $data['lots'] = $lots;
        
        $acceptable_qualities = $this->Sampling_model->get_acceptance_qualities();
        $data['acceptable_qualities'] = $acceptable_qualities;
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('checkpoint_id', 'Checkpoint', 'required|xss_clean');
            $validate->set_rules('part_id', 'Part', 'required|xss_clean');

            $validate->set_rules('sampling_type', 'Sampling Type', 'trim|required|xss_clean');
            
            if($this->input->post('sampling_type') == 'Auto') { 
                $validate->set_rules('inspection_level', 'Inspection Level', 'trim|required|xss_clean');
                $validate->set_rules('acceptable_quality', 'Acceptance Quality', 'trim|required|xss_clean');
            } else if($this->input->post('sampling_type') == 'C=0') { 
                $validate->set_rules('acceptable_quality', 'Acceptance Quality', 'trim|required|xss_clean');
            } else if($this->input->post('sampling_type') == 'Fixed') { 
                $validate->set_rules('sample_qty', 'Sample Qty', 'trim|required|xss_clean');
            }
            
            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                
                /* $type = $this->Sampling_model->get_inspection_config_type($post_data['checkpoint_id'], $post_data['part_id']);
                if(!empty($type) && $type != $post_data['sampling_type']) {
                    $data['error'] = "This inspection is already marked as ".$type;
                } */
                
                if(!isset($data['error'])) {
                    if($post_data['sampling_type'] == 'User Defined') {
                        $lower_val = isset($post_data['lower_val']) ? $post_data['lower_val']   : array();
                        $higher_val = isset($post_data['higher_val']) ? $post_data['higher_val'] : array();
                        $no_of_samples = isset($post_data['no_of_samples']) ? $post_data['no_of_samples'] : array();
                        
                        if(count($lower_val) !== count($higher_val) || count($lower_val) !== count($no_of_samples)) {
                            $data['error'] = "Please fill lot range properly";
                        }
                    }
                }
                if(!isset($data['error'])) {
                    $post_data['product_id'] = $this->product_id;

                    if($post_data['sampling_type'] != 'Auto') {
                        $post_data['inspection_level'] = null;
                        if($post_data['sampling_type'] != 'C=0') {
                            $post_data['acceptable_quality'] = null;
                        }
                    }
                    
                    if($post_data['sampling_type'] != 'Fixed') {
                        $post_data['sample_qty'] = null;
                    }
                    
                    $response_id = $this->Sampling_model->update_inspection_config($post_data, $config_id);
                    
                    if($response_id) {
                        $this->Sampling_model->delete_lot_range_samples($response_id);
                        if($post_data['sampling_type'] == 'User Defined') {
                            $lot_size = array();
                            foreach($lower_val as $key => $val) {
                                $temp = array();
                                $temp['config_id'] = $response_id;
                                $temp['lower_val'] = $val;
                                $temp['higher_val'] = $higher_val[$key];
                                $temp['no_of_samples'] = $no_of_samples[$key];

                                $lot_size[] = $temp;
                            }

                            $this->Sampling_model->insert_lot_range_samples($lot_size, $response_id);
                        }
                    }
                    
                    redirect(base_url().'sampling/configs');
                }

            } else {
                $data['error'] = validation_errors();
            }
            
        }
        
        $this->template->write_view('content', 'sampling_plans/update_inspection_config', $data);
        $this->template->render();
    }
    
    public function delete_config($config_id) {
        $this->load->model('Sampling_model');
        $config = $this->Sampling_model->get_inspection_config_by_id($config_id, $this->product_id);
        if(empty($config)) {
            $this->session->set_flashdata('error', 'Invalid record.');
            redirect(base_url().'sampling/configs');
        }
        
        $deleted = $this->Sampling_model->delete_config($config_id);
        if($deleted) {
            $this->session->set_flashdata('success', 'Config deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'sampling/configs');
    }
    
}