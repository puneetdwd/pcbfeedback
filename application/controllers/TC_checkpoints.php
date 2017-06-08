<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TC_Checkpoints extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //$this->is_supplier();
        //render template
        $this->template->write('title', 'SQIM | Timecheck Checkpoint Module');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }

    public function index() {
        $this->load->model('Product_model');
        $this->load->model('TC_Checkpoint_model');
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->id);
        
        $checkpoints = array();
        if($this->input->get('part_no')) {
            $checkpoints = $this->TC_Checkpoint_model->get_checkpoints($this->product_id, $this->id, $this->input->get('part_no'));
        }
        
        $data['checkpoints'] =  $checkpoints;

        $this->template->write_view('content', 'tc_checkpoints/index', $data);
        $this->template->render();
    }
    
    public function add_checkpoint($checkpoint_id = '') {
        $data = array();

        $this->load->model('TC_Checkpoint_model');
        $data['existing_checkpoints'] = '';
        
        $data['insp_types'] = $this->TC_Checkpoint_model->get_distinct_insp_type();
        if(!empty($checkpoint_id)) {
            $checkpoint = $this->TC_Checkpoint_model->get_checkpoint($checkpoint_id);
            if(empty($checkpoint))
                redirect(base_url().'tc_checkpoints');

            $data['checkpoint'] = $checkpoint;
        }

        $this->load->model('Product_model');
        $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->supplier_id);

        if($this->input->post()) {
            
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('checkpoint_no', 'Checkpoint No', 'trim|required|xss_clean');
            $validate->set_rules('part_id', 'Part', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $part = $this->Product_model->get_product_part($this->product_id, $post_data['part_id']);
                $post_data['product_id'] = $this->product_id;
                
                $id = !empty($checkpoint['id']) ? $checkpoint['id'] : '';
                $checkpoint_no = $this->input->post('checkpoint_no');
                
                $post_data['supplier_id'] = $this->id;
            
                $exists = $this->TC_Checkpoint_model->is_checkpoint_no_exists($this->product_id, $post_data['part_id'], $post_data['child_part_no'], $this->id, $checkpoint_no, $id);
                if($exists) {
                    $this->TC_Checkpoint_model->move_checkpoints($this->product_id, $post_data['part_id'], $post_data['child_part_no'], $this->id, $checkpoint_no);
                }
                
                $post_data['status'] = 'Pending';
                
                $checkpoint_id = $this->TC_Checkpoint_model->update_checkpoint($post_data, $id);
                if($checkpoint_id) {
                    $this->session->set_flashdata('success', 'Checkpoint successfully '.(($checkpoint_id) ? 'updated' : 'added').'.');
                    redirect(base_url().'tc_checkpoints?part_no='.$part['code']);
                } else {
                    $data['error'] = 'Something went wrong, Please try again';
                }

            } else {
                $data['error'] = validation_errors();
            }
            
        }

        $this->template->write_view('content', 'tc_checkpoints/add_checkpoint', $data);
        $this->template->render();
    }
    
    public function upload_checkpoints() {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');
        
        $data['product'] = $product;
        
        if($this->input->post()) {
            
            ini_set('memory_limit', '100M');
             
            if(!empty($_FILES['checkpoints_excel']['name'])) {
                $output = $this->upload_file('checkpoints_excel', 'checkpoints_excel', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_checkpoints($this->id, $output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Checkpoints successfully uploaded.');
                        redirect(base_url().'TC_checkpoints');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'tc_checkpoints/upload_checkpoints', $data);
        $this->template->render();
    }
    
    public function delete_checkpoint($checkpoint_id) {
        $this->load->model('TC_Checkpoint_model');
        $checkpoint = $this->TC_Checkpoint_model->get_checkpoint($checkpoint_id, $this->id);
        if(empty($checkpoint))
            redirect(base_url().'checkpoints');

        $deleted = $this->TC_Checkpoint_model->delete_checkpoint($this->product_id, $checkpoint_id, $this->id);

        if($deleted) {
            $this->TC_Checkpoint_model->move_checkpoints_down($this->product_id, $checkpoint['part_id'], $checkpoint['child_part_no'], $this->id, $checkpoint['checkpoint_no']);
            $this->session->set_flashdata('success', 'Checkpoint deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'tc_checkpoints?part_no='.$checkpoint['part_no']);
    }
    
    private function parse_checkpoints($supplier_id, $file_name) {
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);

        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $this->load->model('TC_Checkpoint_model');
        
        $checkpoints = array();
        $parts = array();
        $part_no = '';
        $part_id = '';
        $tmp_insp_item = '';
        $i=0; $j=0;
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;

            if(!trim($row['C']))
                continue;
            
            if(!trim($row['D']))
                continue;
            
            if(!trim($row['E']))
                continue;
            
            if(!trim($row['G']))
                continue;
            
            //echo "hi"; exit;
            /* if($org_name != trim($row['E']))
                continue; */
            
            $prod_code = trim($row['C']);
            $product = $this->Product_model->get_product_id_by_name($prod_code);

            if(empty($product))
                continue;
            
            $part_no = trim($row['D']);
            if(!array_key_exists($part_no, $parts)) {
                
                $exists = $this->Product_model->get_product_part_by_code($product['id'], $part_no);
                if(empty($exists)) {
                    continue;
                } else {
                    $part_id = $exists['id'];
                }

                $parts[$part_no] = $part_id;
            }

            $temp = array();

            $temp['product_id']         = $product['id'];
            $temp['supplier_id']        = $supplier_id;
            $temp['part_id']            = $parts[$part_no];
            $temp['child_part_no']      = trim($row['E']);
            $temp['child_part_name']    = trim($row['F']);
            $temp['mold_no']            = trim($row['G']);
            $temp['insp_item']          = trim($row['J']);
            $temp['spec']               = trim($row['K']);
            $temp['lsl']                = trim($row['L']);
            $temp['usl']                = trim($row['N']);
            $temp['tgt']                = trim($row['M']);
            $temp['unit']               = trim($row['O']);
            $temp['sample_qty']         = trim($row['Q']);
            $temp['measure_type']       = trim($row['I']);
            $temp['frequency']          = str_replace(array(' Hr', 'Hr', ' Hrs', 'Hrs'), '', trim($row['P']));
            $temp['stage']              = trim($row['H']);
            $temp['instrument']         = trim($row['R']);
            $temp['status']             = 'Pending';

            $temp['created']            = date("Y-m-d H:i:s");

            if(trim($row['S']) == 'N') {
                $temp['is_deleted']         = 1;
            } else {
                $temp['is_deleted']         = 0;
            }

            $exists_chk = $this->TC_Checkpoint_model->check_duplicate_checkpoint($temp);
            if($exists_chk) {
                $i++;
                $this->TC_Checkpoint_model->update_checkpoint($temp, $exists_chk['id']);
            } else {
                $j++;
                $checkpoints[]        = $temp;
            }

        }
        
        if(!empty($checkpoints)) {
            $this->TC_Checkpoint_model->insert_checkpoints($checkpoints, $product['id'], $supplier_id);
        }

        return TRUE;
    }
    
    public function checkpoint_approval_index(){
        
        $data = array();
        
        $this->load->model('TC_Checkpoint_model');
        $data['approval_items'] = $this->TC_Checkpoint_model->get_pending_checkpoints_by_product($this->product_id);
        
        $this->template->write_view('content', 'tc_checkpoints/checkpoint_approval_index', $data);
        $this->template->render();
    }
    
    public function checkpoint_status($checkpoint_id, $status){
        
        $data = array();
        $this->load->model('TC_Checkpoint_model');
        
        $update_status = $this->TC_Checkpoint_model->change_status($checkpoint_id, $status);
        
        if($update_status && $status == 'Approved') {
            $this->session->set_flashdata('success', 'Inspection Item successfully Approved.');
        } else {
            $this->session->set_flashdata('error', 'Inspection Item Declined.');
        }
        
        redirect(base_url().'tc_checkpoints/checkpoint_approval_index');
    }

    public function plans() {
        $data = array();
        $this->load->model('TC_Checkpoint_model');

        $plan_date = $this->input->get('plan_date') ? $this->input->get('plan_date') :  date('Y-m-d');
        $data['plan_date'] = $plan_date;
        $data['plans'] = $this->TC_Checkpoint_model->get_all_plans($this->product_id, $this->supplier_id, $plan_date);

        $this->template->write_view('content', 'tc_checkpoints/plans', $data);
        $this->template->render();
    }
    
    public function add_plan($plan_id = '') {
        $data = array();
        $this->load->model('TC_Checkpoint_model');
        
        $data['child_parts'] = array();
        $data['mold_nos'] = array();
        if(!empty($plan_id)) {
            $plan = $this->TC_Checkpoint_model->get_plan($plan_id, $this->supplier_id);
            if(empty($plan))
                redirect(base_url().'tc_checkpoints/plans');

            $data['plan'] = $plan;
            
            $data['child_parts'] = $this->TC_Checkpoint_model->get_child_parts_by_part_id($plan['part_id'], $this->supplier_id, $this->product_id);

            $data['mold_nos'] = $this->TC_Checkpoint_model->get_mold_no_by_child_part_no($plan['part_id'], $plan['child_part_no'], $this->supplier_id, $this->product_id);
        }
        
        $this->load->model('Product_model');
        $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->supplier_id);
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['supplier_id'] = $this->id;
            $post_data['product_id'] = $this->product_id;

            $response = $this->TC_Checkpoint_model->update_plan($post_data, $plan_id); 
            
            $parts = array();
            $child_parts = array();
            $mold_nos = array();
            $froms = array();
            $tos = array();
            foreach($post_data as $key => $value) {
                if(strpos($key, 'part_id_') === 0) {
                    $parts[str_replace('part_id_', '', $key)] = $value;
                }
                
                if(strpos($key, 'child_part_no_') === 0) {
                    $child_parts[str_replace('child_part_no_', '', $key)] = $value;
                }
                
                if(strpos($key, 'mold_no_') === 0) {
                    $mold_nos[str_replace('mold_no_', '', $key)] = $value;
                }
                
                if(strpos($key, 'from_time_') === 0) {
                    $froms[str_replace('from_time_', '', $key)] = $value;
                }
                
                if(strpos($key, 'to_time_') === 0) {
                    $tos[str_replace('to_time_', '', $key)] = $value;
                }
            }
            
            foreach($parts as $key => $part_id) {
                if(empty($froms[$key]) || empty($tos[$key])) {
                    continue;
                }

                $update_array                   = array();
                $update_array['plan_date']      = $post_data['plan_date'];
                $update_array['supplier_id']    = $this->id;
                $update_array['product_id']     = $this->product_id;
                $update_array['part_id']        = $part_id;
                $update_array['child_part_no']  = $child_parts[$key];
                $update_array['mold_no']        = $mold_nos[$key];
                $update_array['from_time']      = $froms[$key];
                $update_array['to_time']        = $tos[$key];
                
                $this->TC_Checkpoint_model->update_plan($update_array, ''); 
            }

            if($response) {
                $this->session->set_flashdata('success', 'Plan successfully '.(($plan_id) ? 'updated' : 'added').'.');
                redirect(base_url().'tc_checkpoints/plans?plan_date='.$post_data['plan_date']);
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }

        $this->template->write_view('content', 'tc_checkpoints/add_plan', $data);
        $this->template->render();
    }
    
    public function delete_plan($plan_id) {
        $this->load->model('TC_Checkpoint_model');

        $plan = $this->TC_Checkpoint_model->get_plan($plan_id, $this->supplier_id);
        if(empty($plan))
            redirect($_SERVER['HTTP_REFERER']);
            
        $deleted = $this->TC_Checkpoint_model->delete_plan($plan_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Plan deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function get_child_parts_by_part_id() {
        $data = array('child_part_nos' => array());
        
        if($this->input->post('part_id')) {
            $this->load->model('TC_Checkpoint_model');
            $data['child_part_nos'] = $this->TC_Checkpoint_model->get_child_parts_by_part_id($this->input->post('part_id'), $this->supplier_id, $this->product_id);
        }
        
        echo json_encode($data);
    }
    
    public function get_mold_no_by_child_part_no() {
        $data = array('mold_nos' => array());
        
        if($this->input->post('child_part_no') && $this->input->post('part_id')) {
            $this->load->model('TC_Checkpoint_model');
            $data['mold_nos'] = $this->TC_Checkpoint_model->get_mold_no_by_child_part_no($this->input->post('part_id'), $this->input->post('child_part_no'), $this->supplier_id, $this->product_id);
        }
        
        echo json_encode($data);
    }

}