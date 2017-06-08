<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkpoints extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'SQIM | Checkpoint Module');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }

    public function index() {
        $this->load->model('Product_model');
        $this->load->model('Checkpoint_model');
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        if($this->user_type == 'Admin'){
            $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        }else{
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->supplier_id);
        }
        //$data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        
        if($this->user_type == 'Supplier') {
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->id);
        } else {
            $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        }
        
        $checkpoints = array();
        if($this->input->get('part_no')) {
            $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
            
            $checkpoints = $this->Checkpoint_model->get_checkpoints($this->product_id, $supplier_id, $this->input->get('part_no'));
        }
        
        $data['checkpoints'] =  $checkpoints;

        //echo $this->db->last_query();exit;
        $this->template->write_view('content', 'checkpoints/index', $data);
        $this->template->render();
    }
    
    public function add_checkpoint($checkpoint_id = '') {
        $data = array();

        $this->load->model('Checkpoint_model');
        $data['existing_checkpoints'] = '';
        
        $this->load->model('Sampling_model');
        
        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
            $data['insp_types'] = $this->Checkpoint_model->get_distinct_insp_type();
        }
        if(!empty($checkpoint_id)) {
            $checkpoint = $this->Checkpoint_model->get_checkpoint($checkpoint_id);
            if(empty($checkpoint))
                redirect(base_url().'checkpoints');
            
            if(($this->user_type == 'Supplier' && $checkpoint['checkpoint_type'] == 'LG') || ($this->user_type !== 'Supplier' && $checkpoint['checkpoint_type'] == 'Supplier')) {
                $this->session->set_flashdata('error', 'Permission Error.');
                redirect(base_url().'checkpoints');
            }

            $data['checkpoint'] = $checkpoint;
            
            $config_id = $this->Sampling_model->get_config_id($checkpoint_id);
            
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
        }
        
        $lots = $this->Sampling_model->get_lot_template();
        $data['lots'] = $lots;
        
        $acceptable_qualities = $this->Sampling_model->get_acceptance_qualities();
        $data['acceptable_qualities'] = $acceptable_qualities;
        
        //echo "<pre>"; print_r($acceptable_qualities); exit;
        
        $this->load->model('Product_model');
        
        if($this->user_type == 'Admin'){
            $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        }else{
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->supplier_id);
        }

        if($this->input->post()) {
            
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('checkpoint_no', 'Checkpoint No', 'trim|required|xss_clean');
            $validate->set_rules('part_id', 'Part', 'trim|required|xss_clean');
            $validate->set_rules('sampling_type', 'Sampling Type', 'trim|required|xss_clean');
            
            if($this->input->post('sampling_type') == 'Auto') { 
                $validate->set_rules('inspection_level', 'Inspection Level', 'trim|required|xss_clean');
                //$validate->set_rules('acceptable_quality', 'Acceptance Quality', 'trim|required|xss_clean');
            } else if($this->input->post('sampling_type') == 'C=0') { 
                $validate->set_rules('acceptable_quality', 'Acceptance Quality', 'trim|required|xss_clean');
            } else if($this->input->post('sampling_type') == 'Fixed') { 
                $validate->set_rules('sample_qty', 'Sample Qty', 'trim|required|xss_clean');
            }
            
            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $part = $this->Product_model->get_product_part($this->product_id, $post_data['part_id']);
                $post_data['product_id'] = $this->product_id;
                
                $id = !empty($checkpoint['id']) ? $checkpoint['id'] : '';
                $checkpoint_no = $this->input->post('checkpoint_no');
            
                if($this->user_type !== 'Supplier') {
                    $exists = $this->Checkpoint_model->is_checkpoint_no_exists($this->product_id, $post_data['part_id'], $checkpoint_no, $id);
                    if($exists) {
                        $this->Checkpoint_model->move_checkpoints($this->product_id, $post_data['part_id'], $checkpoint_no);
                    }
                } else {
                    $post_data['checkpoint_type'] = 'Supplier';
                    $post_data['supplier_id'] = $this->id;
                }

                $checkpoint_id = $this->Checkpoint_model->update_checkpoint($post_data, $id);
                $post_data['checkpoint_id'] = $checkpoint_id;
                if($checkpoint_id) {
                    if($this->user_type !== 'Supplier') {
                        $type = !empty($id) ? 'Updated' : 'Added';
                        $before = !empty($checkpoint) ? $checkpoint : array();
                        
                        $this->add_history($before, $this->product_id, $checkpoint_id, $type, $this->input->post('remark'));
                    }
                    $this->session->set_flashdata('success', 'Checkpoint successfully '.(($checkpoint_id) ? 'updated' : 'added').'.');
                    //redirect(base_url().'checkpoints?part_no='.$part['code']);
                } else {
                    $data['error'] = 'Something went wrong, Please try again';
                }
                
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
                    
                    $post_data['chk_item'] = $post_data['insp_item2'];
                    if($post_data['sampling_type'] == 'C=0'){
                        $post_data['acceptable_quality'] = $post_data['acceptable_quality1'];
                    }
                    //echo "<pre>"; print_r($post_data); exit;
                    
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
                    
                    //redirect(base_url().'sampling/configs');
                    redirect(base_url().'checkpoints?part_no='.$part['code']);
                }
                
            } else {
                $data['error'] = validation_errors();
            }
            
        }

        $this->template->write_view('content', 'checkpoints/add_checkpoint', $data);
        $this->template->render();
    }
    
    public function upload_checkpoints() {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');
        
        $data['product'] = $product;
        //echo "upload ";
        if($this->input->post()) {
             //echo "upload1 ";
            if(!empty($_FILES['checkpoints_excel']['name'])) {
                $output = $this->upload_file('checkpoints_excel', 'checkpoints_excel', "assets/uploads/");
                //echo "upload2 ";
                if($output['status'] == 'success') {
                    //echo "upload3 ";
                    $res = $this->parse_checkpoints($this->product_id, $product['org_name'], $output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Checkpoints successfully uploaded.');
                        redirect(base_url().'checkpoints');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'checkpoints/upload_checkpoints', $data);
        $this->template->render();
    }
    
    public function delete_checkpoint($checkpoint_id) {
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        
        $this->load->model('Checkpoint_model');
        $checkpoint = $this->Checkpoint_model->get_checkpoint($checkpoint_id, $supplier_id);
        if(empty($checkpoint))
            redirect(base_url().'checkpoints');
        
        if(($this->user_type == 'Supplier' && $checkpoint['checkpoint_type'] == 'LG') || ($this->user_type !== 'Supplier' && $checkpoint['checkpoint_type'] == 'Supplier')) {
            $this->session->set_flashdata('error', 'Permission Error.');
            redirect(base_url().'checkpoints');
        }

        $deleted = $this->Checkpoint_model->delete_checkpoint($this->product_id, $checkpoint_id, $supplier_id);

        if($deleted) {
            if($this->user_type !== 'Supplier') {
                $this->add_history($checkpoint, $this->product_id, $checkpoint_id, 'Deleted');
            }
            $this->Checkpoint_model->move_checkpoints_down($this->product_id, $checkpoint['part_id'], $checkpoint['checkpoint_no']);
            $this->session->set_flashdata('success', 'Checkpoint deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'checkpoints');
    }
    
    public function view_revision_history() {
        $this->is_admin_user();
        $data = array();

        $this->load->model('Checkpoint_model');
        $data['histories'] = $this->Checkpoint_model->get_history($this->product_id, $this->input->post('revision_date'));

        $this->template->write_view('content', 'checkpoints/history', $data);
        $this->template->render();
    }
    
    public function excluded_checkpoints() {
        $this->is_admin_user();
        $this->load->model('Checkpoint_model');
        $data['excluded_checkpoints'] = $this->Checkpoint_model->get_all_excluded_checkpoints();

        $this->template->write_view('content', 'checkpoints/excluded_checkpoints', $data);
        $this->template->render();
    }

    public function exclude_checkpoint_form($id = '') {
        $this->is_admin_user();
        $data = array();
        $this->load->model('Checkpoint_model');
        $data['checkpoints'] = $this->Checkpoint_model->get_checkpoints($this->product_id);
        
        $this->load->model('Product_model');
        $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);
        //echo $this->db->last_query();exit;
        if(!empty($id)) {
            $excluded_checkpoint = $this->Checkpoint_model->get_excluded_checkpoint($id);
            if(empty($excluded_checkpoint))
                redirect(base_url().'checkpoints/excluded_checkpoints');

            $data['excluded_checkpoint'] = $excluded_checkpoint;
        }
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('part_id', 'Part', 'trim|required|xss_clean');
            $validate->set_rules('checkpoints_ids', 'Checkpoint Nos', 'required|xss_clean');
            
            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $post_data['checkpoints_ids'] = implode(',', $post_data['checkpoints_ids']);

                $exists = $this->Checkpoint_model->excluded_checkpoint_exists($this->input->post('part_id'), $id);
                if(!$exists) {
                    $excluded_id = $this->Checkpoint_model->update_excluded_checkpoints($post_data, $id);
                    if($excluded_id) {
                        $this->session->set_flashdata('success', 'Record successfully '.(($excluded_id) ? 'updated' : 'added').'.');
                        redirect(base_url().'checkpoints/excluded_checkpoints');
                    } else {
                        $data['error'] = 'Something went wrong, Please try again';
                    }

                } else {
                    $data['error'] = 'Record already exists for this Inspection and Model.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->template->write_view('content', 'checkpoints/exclude_checkpoint_form', $data);
        $this->template->render();
    }
    
    public function delete_exclude_checkpoint($id) {
        $this->is_admin_user();
        $this->load->model('Checkpoint_model');
        $excluded_checkpoint = $this->Checkpoint_model->get_excluded_checkpoint($id);
        if(empty($excluded_checkpoint))
            redirect(base_url().'checkpoints/excluded_checkpoints');

        $deleted = $this->Checkpoint_model->delete_exclude_checkpoint($id);

        if($deleted) {
            $this->session->set_flashdata('success', 'Record successfully deleted.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'checkpoints/excluded_checkpoints');
    }
    
    private function add_history($before, $product_id, $checkpoint_id, $type, $remark = '') {
        $this->load->model('Checkpoint_model');
        $version = $this->Checkpoint_model->get_revision_version($product_id);
        
        if(!empty($before)) {
            $before['version']          = $version+1;
            $before['type']             = 'Before';
            
            $before['change_type']      = $type;
            $before['changed_on']       = date('Y-m-d H:i:s');
            
            if(!empty($remark)) {
                $before['remark']     = $remark;
            }
            
            $added = $this->Checkpoint_model->add_history($before);
        }
        
        
        $after = $this->Checkpoint_model->get_checkpoint($checkpoint_id);

        $after['version']          = $version+1;
        $after['type']             = 'After';
        
        $after['change_type']      = $type;
        $after['changed_on']       = date('Y-m-d H:i:s');

        if(!empty($remark)) {
            $data['remark']     = $remark;
        }
        
        $added = $this->Checkpoint_model->add_history($after);
        return $added;
    }

    private function parse_checkpoints($product_id, $org_name, $file_name) {
        
        //ini_set('memory_limit', '100M');
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        ini_set("memory_limit","256M"); 
        //ini_set('max_execution_time', 300);
        //echo "here";
        //echo "<pre>";print_r($arr);exit;
        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        //echo "here2";
        $this->load->model('Product_model');
        $this->load->model('Checkpoint_model');
        
        $checkpoints = array();
        $samplings = array();
        $parts = array();
        $part_no = '';
        $part_id = '';
        $tmp_insp_item = '';
        $i=0; $j=0;
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            /*if(trim($row['AZ']) != 'Y')
                continue;*/

            if(!trim($row['G']))
                continue;
            
            /* if($org_name != trim($row['E']))
                continue; */
            //echo "here3";
            $part_no = trim($row['G']);
            if(!array_key_exists($part_no, $parts)) {
                
                $exists = $this->Product_model->get_product_part_by_code($product_id, $part_no);
                if(empty($exists)) {
                    $temp = array();
                    $temp['code']           = trim($row['G']);
                    $temp['name']           = trim($row['H']);
                    $temp['product_id']     = $product_id;
                    $part_id = $this->Product_model->update_product_part($temp, '');
                } else {
                    $part_id = $exists['id'];
                }

                $parts[$part_no] = $part_id;
            }
            
            $temp = array();

            $temp['product_id']         = $product_id;
            $temp['part_id']            = $parts[$part_no];
            $temp['insp_item']          = trim($row['P']);
            $temp['insp_item2']         = trim($row['X']);
            $temp['spec']               = trim($row['AC']);
            $temp['lsl']                = trim($row['AF']);
            $temp['usl']                = trim($row['AE']);
            $temp['tgt']                = trim($row['AG']);
            $temp['unit']               = trim($row['AD']);
            $temp['images']             = trim($row['BI']);
            
            if(trim($row['T']) == 'Y') {
                $temp['period']         = trim($row['U']);
                $temp['cycle']          = trim($row['V']);
            } else {
                $temp['period']         = null;
                $temp['cycle']          = null;
            }
            
            IF(trim($row['AZ']) == 'Y')
                $temp['is_deleted'] = 0;
            ELSE IF(trim($row['AZ']) == 'N')
                $temp['is_deleted'] = 1;
            ELSE
                CONTINUE;
            
            $temp['created']            = date("Y-m-d H:i:s");
            
            $sample = array();
            $sample['product_id']           = $product_id;
            $sample['part_id']              = $parts[$part_no];
            $sample['chk_item']             = trim($row['X']);
            $sample['sample_qty']           = null;
            $sample['acceptable_quality']   = null;
            $sample['inspection_level']     = null;
            
            if(trim($row['AL']) == 'UD') {
                $sample['sampling_type']        = 'Fixed';
                $sample['sample_qty']           = trim($row['AT']);
            } else if(trim($row['AL']) == 'M105D') {
                $sample['sampling_type']        = 'Auto';
                $sample['acceptable_quality']   = trim($row['AQ']);
                
                if(trim($row['AS']) == 'I') {
                    $sample['inspection_level']     = 1;
                } else if(trim($row['AS']) == 'II') {
                    $sample['inspection_level']     = 2;
                } else if(trim($row['AS']) == 'III') {
                    $sample['inspection_level']     = 3;
                } else {
                    $sample['inspection_level']     = trim($row['AS']);
                }
            } else if(trim($row['AL']) == 'C=0') {
                $sample['sampling_type']        = 'C=0';
                $sample['acceptable_quality']   = trim($row['AQ']);
            } else {
                continue;
            }
            
            $exists_chk = $this->Checkpoint_model->check_duplicate_checkpoint($temp);
            $this->load->model('Sampling_model');
            if($exists_chk) {
                //echo "update";
                $i++;
                $this->Checkpoint_model->update_checkpoint($temp, $exists_chk['id']);
                $sam_id = $this->Sampling_model->check_config_by_checkpoint($temp['product_id'], $temp['part_id'], $temp['insp_item2'], $exists_chk['id']);
                $this->Sampling_model->update_inspection_config($sample, $sam_id['id']);
            } else {
                $j++;
                //echo "insert";
                $checkpoints[]        = $temp;
                $samplings[]          = $sample;
            }
            //exit;
            //$checkpoints[]          = $temp;
            //$samplings[]            = $sample;
        }
        
        if(!empty($checkpoints)) {
            $this->Checkpoint_model->insert_checkpoints($checkpoints, $product_id);
        }

        if(!empty($samplings)) {
            
            $this->Sampling_model->insert_samplings($samplings, $product_id);
        }
        
        //echo $i." Update and ".$j."Inserted"; exit;
        
        return TRUE;
    }
    
    public function checkpoint_approval_index(){
        
        $data = array();
        
        $this->load->model('Checkpoint_model');
        $data['approval_items'] = $this->Checkpoint_model->get_supplier_checkpoints_by_product($this->product_id);
        
        $this->template->write_view('content', 'checkpoints/checkpoint_approval_index', $data);
        $this->template->render();
    }
    
    public function checkpoint_status($checkpoint_id, $status){
        
        $data = array();
        $this->load->model('Checkpoint_model');
        
        $update_status = $this->Checkpoint_model->change_status($checkpoint_id, $status);
        
        if($update_status) {
            $this->session->set_flashdata('success', 'Inspection Item successfully Approved.');
        } else {
            $this->session->set_flashdata('error', 'Inspection Item Declined.');
        }
        
        redirect(base_url().'checkpoints/checkpoint_approval_index');
    }
    
    public function oracle_connect(){
        $conn = oci_connect('ILLOCAL', 'viewer', '192.168.20.180:1522/ILLOCAL');
        if (!$conn) {
            die('Could not connect: ' . $e['message']);
        }else{
            echo "Success";
        }
        
        $sql = "select part_code, drawing_name, drawing_no, doc
                from lg_epis.xxsqis_part_drawing_v
                WHERE part_code = 'MAY66639267' ";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        if (!$row) {
            header('Status: 404 Not Found');
        } else {
            $img = $row['doc']->load();
            header("Content-type: image/jpeg");
            print $img;
        }

        //$nrows = oci_fetch_all($stid, $part_number, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        
        //echo "<pre>"; print_r($part_number); exit;

        return $conn;
    }
}