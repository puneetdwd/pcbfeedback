<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auditer extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        $page = 'inspections';
        $this->template->write_view('header', 'templates/header', array('page' => $page));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function checklist() {
        if($this->input->get('status') !== 'done') {
            $data = array();
            $this->load->model('Checklist_model');
            
            $data['checklists'] = $this->Checklist_model->get_all_checklists($this->product_id);

            $this->template->write('title', 'SQIM | Part Inspection | Checklist');
            $this->template->write_view('content', 'auditer/checklist', $data);
            $this->template->render();
        } else {
            $this->load->model('User_model');
            if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){
                $this->User_model->update_user(array('checklist_checked' => date('Y-m-d')), $this->id);
            }else if($this->user_type == 'Supplier'){
                $this->User_model->update_supplier_user(array('checklist_checked' => date('Y-m-d')), $this->id);
            }else{
                $this->User_model->update_supplier_inspector_user(array('checklist_checked' => date('Y-m-d')), $this->id);
            }
            
            redirect(base_url().'auditer/register_inspection');
        }
    }
    
    public function review_inspection($audit_id, $new = false) {
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit('', 'completed', '', $audit_id, 0, $this->product_id);
        if(empty($audit)) {
            redirect(base_url());
        }
        
        if($new) {
            $this->destroy_checkpoint_session();
        }

        $data['audit'] = $audit;

        if(!$this->session->userdata('current_checkpoint')) {
            $this->set_checkpoint_session($audit['id']);
        }
        
        $checkpoint = $this->Audit_model->get_checkpoint($audit['id'], $this->session->userdata('current_checkpoint'));
        $data['checkpoint'] = $checkpoint;
        
        $this->load->model('Checkpoint_model');
        $checkpoint_images = $this->Checkpoint_model->get_checkpoint_images($this->session->userdata('current_checkpoint'));

        $data['checkpoint_images'] = explode(',',$checkpoint_images['images']);
        
        $conn = $this->oracle_connect();	

	$sql = "select part_code, drawing_name, drawing_no, doc
                from lg_epis.xxsqis_part_drawing_v
                WHERE part_code = '".$audit['part_no']."'";
        
        //echo $sql; exit;
        
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        $nrows = oci_fetch_all($stid, $part_number, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	if(isset($part_number)){
            $doc = $part_number[0]['DOC'];
        }else{
            $doc = '';
        }
        
        //print $img; 
	$data['doc'] = $doc;
        
        $this->template->write('title', 'SQIM | Product Inspection | Checkpoint Screen');
        //$this->template->write_view('header', 'templates/header', $header);
        $this->template->write_view('content', 'auditer/review_checkpoint_screen', $data);
        $this->template->render();
    }
    
    public function register_inspection() {
        $data = array();
        $this->load->model('Audit_model');
        
        $audit = $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'));
        if(!empty($audit)) {
            $this->check_inspection($audit);
        }
        
        $this->destroy_checkpoint_session();
        
        $this->load->model('User_model');
        if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){
            $user = $this->User_model->get_user($this->username);
        }else if($this->user_type == 'Supplier'){
            $user = $this->User_model->get_supplier_user($this->id);
        }else{
            $user = $this->User_model->get_supplier_inspector_user($this->id);
        }
        

        if(@$user['checklist_checked'] != date('Y-m-d')) {
            $this->load->model('Checklist_model');
            $checklists = $this->Checklist_model->get_all_checklists($this->product_id);
            if(!empty($checklists)) {
                redirect(base_url().'auditer/checklist');
            }
        }

        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('audit_date', 'Production Plan Date', 'trim|required|xss_clean');
            $validate->set_rules('part_id', 'Part', 'trim|required|xss_clean');
            $validate->set_rules('prod_lot_qty', 'Production Lot Qty', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                
                $this->load->model('Product_model');
                $part = $this->Product_model->get_product_part($this->product_id, $post_data['part_id']);
                if(empty($part)) {
                    $this->session->set_flashdata('error', 'Invalid Part');
                    redirect(base_url().'auditer/register_inspection');
                }
                
                $post_data['supplier_id']       = $this->supplier_id;
                $post_data['product_id']        = $this->product_id;
                $post_data['part_no']           = $part['code'];
                $post_data['part_name']         = $part['name'];
                $post_data['register_datetime'] = date('Y-m-d H:i:s');
                $post_data['auditer_id']        = $this->id;
                
                $already = $this->Audit_model->check_already_inspected($post_data);
                if($already) {
                    $this->session->set_flashdata('error', 'Inspection for this Part has already been done.');
                    redirect(base_url().'auditer/register_inspection');
                }
                
                $audit_id = $this->Audit_model->update_audit($post_data, '');
                if($audit_id) {
                    $this->session->set_flashdata('success', 'Product Inspection successfully registered. Please review and click Start Inspection');
                    redirect(base_url().'auditer/inspection_start_screen');
                } else {
                    $data['error'] = 'Something went wrong. Please try again.';
                }
                
            } else {
                $data['error'] = validation_errors();
            }

        }
        
        $this->load->model('Product_model');
        $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->product_id, $this->supplier_id);

        $this->template->write('title', 'SQIM | Part Inspection | Register Screen');
        $this->template->write_view('content', 'auditer/register_inspection', $data);
        $this->template->render();
    }
    
    public function inspection_start_screen() {
        $data = array();
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, 'registered');
        if(empty($audit)) {
            $this->check_inspection();
        }

        $this->load->model('Checkpoint_model');
        
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';

        $checkpoints = $this->Checkpoint_model->get_checkpoints_for_audit($audit['product_id'], $audit['part_id'], $supplier_id);
        foreach($checkpoints as $key => $checkpoint) {
            if(!empty($checkpoint['period']) && !empty($checkpoint['cycle'])) {
                $date = date('Y-m-d', strtotime('-'.$checkpoint['cycle'].' days'));
                //echo $date; exit;
                $already_audited = $this->Audit_model->checkpoint_audited($audit['product_id'], $audit['part_id'], $checkpoint['id'], $date);
                if($already_audited) {
                    unset($checkpoints[$key]);
                }
            }
        }
        
        
		$exclude_checkpoints_nos = array();
        $data['audit'] = $audit;
        $data['checkpoints'] = $checkpoints;
        $data['excluded_count'] = count($exclude_checkpoints_nos);
        
        $this->template->write('title', 'SQIM | Product Inspection | Start Screen');
        $this->template->write_view('content', 'auditer/inspection_start_screen', $data);
        $this->template->render();
    }
    
    public function start_inspection() {
        $sampling = $this->session->userdata('sampling');
        if(empty($sampling)) {
            $this->check_inspection();
        }
        
        $case = 'CASE';
        foreach($sampling as $checkpoint_id => $qty) {
            $case .= ' WHEN c.id = '.$checkpoint_id.' THEN '.$qty;
        }
        $case .= ' END as sampling_qty';
        
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, 'registered');
        if(empty($audit)) {
            $this->check_inspection();
        }
        
		$this->load->model('Checkpoint_model');
        
        $supplier_id = $this->user_type == 'Supplier' ? $this->id : '';
        
        $exclude = [];
        $checkpoints = $this->Checkpoint_model->get_checkpoints_for_audit($audit['product_id'], $audit['part_id'], $supplier_id);
        foreach($checkpoints as $key => $checkpoint) {
            if(!empty($checkpoint['period']) && !empty($checkpoint['cycle'])) {
                $date = date('Y-m-d', strtotime('-'.$checkpoint['cycle'].' days'));
                
                $already_audited = $this->Audit_model->checkpoint_audited($audit['product_id'], $audit['part_id'], $checkpoint['id'], $date);
                if($already_audited) {
                    $exclude[] = $checkpoint['id'];
                }
            }
        }
        
        $exclude = implode(',', $exclude);
        $this->Audit_model->create_audit_checkpoints($audit['product_id'], $audit['part_id'], $audit['id'], $case, $exclude);
        //echo $this->db->last_query();exit;
        $this->Audit_model->change_state($audit['id'], $this->id, 'started');
        
        $this->set_checkpoint_session($audit['id']);
        
        redirect(base_url().'auditer/checkpoint_screen');
    }
    
    public function checkpoint_screen() {
        $data = array();
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, 'started');
        if(empty($audit)) {
            $this->check_inspection();
        }
        
        $data['audit'] = $audit;

        if(!$this->session->userdata('current_checkpoint')) {
            $this->set_checkpoint_session($audit['id'], 'find');
        }
        
        $checkpoint = $this->Audit_model->get_checkpoint($audit['id'], $this->session->userdata('current_checkpoint'));
        $data['checkpoint'] = $checkpoint;
        
        $this->load->model('Checkpoint_model');
        $checkpoint_images = $this->Checkpoint_model->get_checkpoint_images($this->session->userdata('current_checkpoint'));
        $data['checkpoint_images'] = explode(',',$checkpoint_images['images']);
        
        ini_set("memory_limit","-1");
        
	$conn = $this->oracle_connect();	
        
        $sql = "select part_code, drawing_name, drawing_no, doc
                from lg_epis.xxsqis_part_drawing_v
                WHERE part_code = '".$audit['part_no']."'
                AND LENGTH(doc) <= 2097152";
        
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        $nrows = oci_fetch_all($stid, $part_number, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	
        if(isset($part_number)){
            $doc = $part_number[0]['DOC'];
            
        }else{
            $doc = '';
        }
        
	$data['doc'] = $doc;
        
        $this->template->write('title', 'SQIM | Product Inspection | Checkpoint Screen');
        //$this->template->write_view('header', 'templates/header', $header);
        $this->template->write_view('content', 'auditer/checkpoint_screen', $data);
        $this->template->render();
    }

    public function oracle_connect(){
        $conn = oci_connect('viewer', 'viewer', '192.168.20.180:1522/ILLOCAL');
        if (!$conn) {
            die('Could not connect: ' . $e['message']);
        }else{
            return $conn;
            echo "Success";
        }
	return $conn;
    }

    public function record_result($checkpoint_id) {
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $this->load->model('Audit_model');
            $audit = $this->Audit_model->get_audit($this->id, 'started');
            if(empty($audit)) {
                $this->check_inspection();
            }
            
            $checkpoint = $this->Audit_model->get_checkpoint($audit['id'], $this->session->userdata('current_checkpoint'));
            if(!empty($checkpoint)) {
                if($checkpoint['id'] != $checkpoint_id) {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                    redirect(base_url().'auditer/checkpoint_screen');
                }

                if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) {
                    $all_values = array();
                    foreach ($post_data as $key => $value) {
                        if(strpos($key, 'audit_value_') === 0) {
                            $all_values[] = $value;
                        }
                    }
                    
                    //echo "<pre>"; print_r($all_values); exit;
                    
                    if(empty($all_values)) {
                        $this->session->set_flashdata('error', 'Something went wrong with storing result. Please try again');
                        redirect(base_url().'auditer/checkpoint_screen');
                    }
                    
                    if(!isset($post_data['result']) || $post_data['result'] != 'NA') {
                        $final_result = 'OK';
                        $all_results = array();
                        foreach($all_values as $ex_val) {
                            $audit_value = (float)$ex_val;
                            
                            if(!empty($checkpoint['lsl']) && $audit_value < $checkpoint['lsl']) {
                                $all_results[] = 'NG';
                                $final_result = 'NG';
                                continue;
                            }
                            
                            if(!empty($checkpoint['usl']) && $audit_value > $checkpoint['usl']) {
                                $all_results[] = 'NG';
                                $final_result = 'NG';
                                continue;
                            }
                            
                            $all_results[] = 'OK';
                        }
                        
                        $post_data['all_values'] = implode(',', $all_values);
                        $post_data['all_results'] = implode(',', $all_results);
                        $post_data['result'] = $final_result;
                    }
                    
                } else {
                    $all_results = array();
                    foreach ($post_data as $key => $value) {
                        if(strpos($key, 'audit_result_') === 0) {
                            $all_results[] = $value;
                        }
                    }
                    
                    $post_data['all_values'] = null;
                    $post_data['all_results'] = implode(',', $all_results);
                    $post_data['result'] = (strpos($post_data['all_results'], 'NG') === false) ? 'OK' : 'NG';
                }
                
                //echo "<pre>";print_r($post_data);exit;

                $response = $this->Audit_model->record_checkpoint_result($post_data, $checkpoint_id, $audit['id']);
                //$response = false;
                if($response) {
                    
                    if($post_data['result'] == 'NG' && base_url() != 'http://localhost/SQIM/') {
                        $this->load->model('Product_model');
                        $phone_numbers = $this->Product_model->get_all_phone_numbers($this->supplier_id);
                        if(!empty($phone_numbers)) {
                            $to = array();
                            
                            foreach($phone_numbers as $phone_number) {
                                $to[] = $phone_number['phone_number'];
                            }
                            
                            $to = implode(',', $to);
                            
                            $sms = $audit['supplier_name']." OQC- Inspn Rslt NG\nPart No. -".$audit['part_no']."(".$audit['org_name'];
                            $sms .= ")\nDefect-".$post_data['remark'];
                            
                            $ip_address = $this->get_server_ip();
                            
                            if($ip_address == '202.154.175.50'){
                                
                                if(isset($to) && isset($sms)){
                                    $sms1= urlencode($sms);
                                    $to1 = urlencode($to);
                                    $data = array('to' => $to1, 'sms' => $sms1);
                                    $url = "http://10.101.0.80:90/SQIM/auditer/send_sms_redirect";    	

                                    $ch = curl_init();
                                            curl_setopt_array($ch, array(
                                            CURLOPT_URL => $url,
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_POSTFIELDS => $data,
                                    ));
                                    //get response
                                    $output = curl_exec($ch);
                                    $flag = true;
                                    //Print error if any
                                    if(curl_errno($ch))
                                    {
                                            $flag = false;
                                    }
                                    curl_close($ch);
                                }
                            }else{
                                $this->send_sms($to, $sms);
                            }
                        }
                        
                    }
                    
                    $this->session->set_flashdata('success', 'Result recorded successfully');
                    
                    $new_checkpoint = $this->get_n_set_checkpoint_session();
                    if($new_checkpoint === 'Completed') {
                        $this->Audit_model->change_state($audit['id'], $this->id, 'finished');
                        redirect(base_url().'auditer/finish_screen');
                    }
                    
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong will storing result. Please try again');
                }
            }
        }
        
        redirect(base_url().'auditer/checkpoint_screen');
    }
    
    public function review_checkpoint($checkpoint_id, $audit_id = '') {
        $data = array();
        $this->load->model('Audit_model');

        if(!$audit_id) {
            $audit = $this->Audit_model->get_audit($this->id, 'finished');
        } else {
            $data['admin_edit_audit'] = $audit_id;
            $audit = $this->Audit_model->get_audit('', 'completed', '', $audit_id);
        }
        
        if(empty($audit)) {            
            echo "<div class='modal-body'>Something went wrong. Please refresh your screen.</div>";
            return;
        }
        
        $checkpoint = $this->Audit_model->get_checkpoint($audit['id'], $checkpoint_id);
        $data['checkpoint'] = $checkpoint;
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) {
                $all_values = array();
                foreach ($post_data as $key => $value) {
                    if(strpos($key, 'audit_value_') === 0) {
                        $all_values[] = $value;
                    }
                }
                
                if(empty($all_values)) {
                    $this->session->set_flashdata('error', 'Something went wrong will storing result. Please try again');
                    redirect(base_url().'auditer/checkpoint_screen');
                }
                
                if(!isset($post_data['result']) || $post_data['result'] != 'NA') {
                    $final_result = 'OK';
                    $all_results = array();
                    foreach($all_values as $ex_val) {
                        $audit_value = (float)$ex_val;
                        
                        if(!empty($checkpoint['lsl']) && $audit_value < $checkpoint['lsl']) {
                            $all_results[] = 'NG';
                            $final_result = 'NG';
                            continue;
                        }
                        
                        if(!empty($checkpoint['usl']) && $audit_value > $checkpoint['usl']) {
                            $all_results[] = 'NG';
                            $final_result = 'NG';
                            continue;
                        }
                        
                        $all_results[] = 'OK';
                    }
                    
                    $post_data['all_values'] = implode(',', $all_values);
                    $post_data['all_results'] = implode(',', $all_results);
                    $post_data['result'] = $final_result;
                }
            } else {
                $all_results = array();
                foreach ($post_data as $key => $value) {
                    if(strpos($key, 'audit_result_') === 0) {
                        $all_results[] = $value;
                    }
                }
                
                $post_data['all_values'] = null;
                $post_data['all_results'] = implode(',', $all_results);
                $post_data['result'] = (strpos($post_data['all_results'], 'NG') === false) ? 'OK' : 'NG';
            }
            
            $response = $this->Audit_model->record_checkpoint_result($post_data, $checkpoint['id'], $audit['id']);
            if($response) {
                $exists = $this->Audit_model->check_audit_complete_exists($audit['id']);
                if($exists || true) {
                    $this->Audit_model->delete_audit_complete($audit['id']);
                    $this->Audit_model->add_to_completed_audits($audit['id']);
                }
                
                if(!$audit_id) {
                    if($post_data['result'] == 'NG' && base_url() != 'http://localhost/SQIM/') {
                        $this->load->model('Product_model');
                        $phone_numbers = $this->Product_model->get_all_phone_numbers($audit['product_id']);
                        if(!empty($phone_numbers)) {
                            $to = array();
                            
                            foreach($phone_numbers as $phone_number) {
                                $to[] = $phone_number['phone_number'];
                            }
                            
                            $to = implode(',', $to);
                            
                            $sms = $audit['supplier_name']." OQC- Inspn Rslt NG\nPart No. -".$audit['part_no']."(".$audit['org_name'];
                            $sms .= ")\nDefect-".$post_data['remark'];
                            
                            $ip_address = $this->get_server_ip();
                            
                            if($ip_address == '202.154.175.50'){
                                
                                if(isset($to) && isset($sms)){
                                    $sms1= urlencode($sms);
                                    $to1 = urlencode($to);
                                    $data = array('to' => $to1, 'sms' => $sms1);
                                    $url = "http://10.101.0.80:90/SQIM/auditer/send_sms_redirect";    	

                                    $ch = curl_init();
                                            curl_setopt_array($ch, array(
                                            CURLOPT_URL => $url,
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_POSTFIELDS => $data,
                                    ));
                                    //get response
                                    $output = curl_exec($ch);
                                    $flag = true;
                                    //Print error if any
                                    if(curl_errno($ch))
                                    {
                                            $flag = false;
                                    }
                                    curl_close($ch);
                                }
                            }else{
                                $this->send_sms($to, $sms);
                            }
                        }
                        
                    }
                }
                
                $this->session->set_flashdata('success', 'Result recorded successfully');
            } else {
                $this->session->set_flashdata('error', 'Unable to update the result. Please try again.');
            }
            
            if($audit_id) {
                redirect(base_url().'auditer/finish_screen/'.$audit_id);
            } else {
                redirect(base_url().'auditer/finish_screen');
            }
        }
        
        echo $this->load->view('auditer/review_checkpoint_modal', $data, true);
    }
    
    public function finish_screen($audit_id = '') {
        $data = array();
        $this->load->model('Audit_model');
        
        if(!$audit_id) {
            $audit = $this->Audit_model->get_audit($this->id, 'finished');
        } else {
            $data['admin_edit_audit'] = $audit_id;
            $audit = $this->Audit_model->get_audit('', 'completed', '', $audit_id);
        }

        if(empty($audit)) {
            $this->check_inspection();
        }
        
        $checkpoints = $this->Audit_model->get_all_audit_checkpoints($audit['id']);
        
        $data['audit'] = $audit;
        $data['checkpoints'] = $checkpoints;
        $data['checkpoints_OK'] = $this->Audit_model->get_count_checkpoint_by_result($audit['id'], 'OK');
        $data['checkpoints_NG'] = $this->Audit_model->get_count_checkpoint_by_result($audit['id'], 'NG');
        $data['checkpoints_PD'] = $this->Audit_model->get_count_checkpoint_by_result($audit['id'], null);
        
        $this->template->write('title', 'SQIM | Product Inspection | Review Screen');
        $this->template->write_view('content', 'auditer/finish_screen', $data);
        $this->template->render();
        
        
    }
    
    public function mark_as_complete() {
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, 'finished');
        if(empty($audit)) {
            $this->check_inspection();
        }
        
        $check = $this->Audit_model->check_slippage($audit['id']);
        if($check) {
            $this->session->set_flashdata('error', 'Inspection can\'t be completed as there are 1 or more checkpoints with No Result.');
            //redirect(base_url().'auditer/finish_screen');
        }

        $response = $this->Audit_model->change_state($audit['id'], $this->id, 'completed');
        if($response) {
            $this->Audit_model->add_to_completed_audits($audit['id']);
            
            $this->destroy_checkpoint_session();
            $this->session->set_flashdata('success', 'Inspection successfully marked completed.');
            redirect(base_url().'auditer/register_inspection');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect(base_url().'auditer/finish_screen');
        }
        
    }
    
    public function mark_as_abort($audit_id = '', $on_hold = 0) {
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'), '', $audit_id, $on_hold);
        if(empty($audit)) {
            $this->check_inspection();
        }
        
        $response = $this->Audit_model->change_state($audit['id'], $this->id, 'aborted');
        if($response) {
            $this->destroy_checkpoint_session();
            $this->session->set_flashdata('success', 'Inspection successfully marked aborted.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function on_hold($audit_id = '') {
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'), '', $audit_id);

        if(empty($audit)) {
            $this->check_inspection();
        }
        
        $response = $this->Audit_model->hold_resume_audit($audit['id']);
        if($response) {
            $this->destroy_checkpoint_session();
            $this->session->set_flashdata('success', 'Inspection successfully marked on hold.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function resume($audit_id) {
        $this->load->model('Audit_model');
        $audit = $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'), '', $audit_id);
        
        $current = $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'));
        if(!empty($current)) {
            $this->Audit_model->hold_resume_audit($current['id']);
        }
        
        $response = $this->Audit_model->hold_resume_audit($audit_id, 0);

        if($response) {
            $this->destroy_checkpoint_session();
            $this->session->set_flashdata('success', 'Inspection successfully resumed.');
            redirect(base_url().'register_inspection');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function get_sample_qty() {
        $response = array('status' => 'error');
        if($this->input->post()) {
            $checkpoint_id = $this->input->post('checkpoint_id');
            $part_id = $this->input->post('part_id');
            $prod_lot_qty = $this->input->post('prod_lot_qty');
            
            $res = $this->create_sample_qty($checkpoint_id, $part_id, $prod_lot_qty);
            
            $sampling = $this->session->userdata('sampling');
            $sampling[$checkpoint_id] = $res;
            $this->session->set_userdata('sampling', $sampling);
            
            $response = array('status' => 'success', 'judgement' => $res);
        }
        
        echo json_encode($response);
    }
    
    public function navigate_checkpoint($type, $audit_id) {
        $currect_checkpoint = $this->session->userdata('current_checkpoint');
        $nos = $this->session->userdata('nos');
        
        if($currect_checkpoint == $nos[0] && $type == 'prev') {
            redirect(base_url().'auditer/review_inspection/'.$audit_id);
        }
        
        if($currect_checkpoint == $nos[count($nos)-1] && $type == 'next') {
            redirect(base_url().'auditer/review_inspection/'.$audit_id);
        }

        $new_checkpoint_no = $this->get_n_set_checkpoint_session($type);
        
        redirect(base_url().'auditer/review_inspection/'.$audit_id);
    }
    
    private function destroy_checkpoint_session() {
        //echo "here";exit;
        $this->session->unset_userdata('current_checkpoint');
        $this->session->unset_userdata('nos');
        $this->session->unset_userdata('mandatory_popup');
        $this->session->unset_userdata('references');
        $this->session->unset_userdata('mandatories');
        $this->session->unset_userdata('opened_link');
    }
    
    private function check_inspection($audit = '') {
        $audit = ($audit) ? $audit : $this->Audit_model->get_audit($this->id, array('registered','started', 'finished'));
        
        if(empty($audit)) {
            $this->session->set_flashdata('info', 'Please register an inspection, before moving ahead');
            redirect(base_url().'auditer/register_inspection');
        } else if($audit['state'] === 'registered') {
            $this->session->set_flashdata('info', 'You have already registered an inspection. Please complete it before starting a new registration.');
            redirect(base_url().'auditer/inspection_start_screen');
        } else if($audit['state'] === 'started') {
            $this->session->set_flashdata('info', 'You have one on going inspection. Please complete it.');
            redirect(base_url().'auditer/checkpoint_screen');
        } else if($audit['state'] === 'finished') {
            $this->session->set_flashdata('info', 'You have one inspection in finished queue. Please mark it complete before proceeding ahead.');
            redirect(base_url().'auditer/finish_screen');
        }
    }

    private function set_checkpoint_session($audit_id, $type = '') {
        $this->load->model('Audit_model');
        $checkpoint_nos = $this->Audit_model->get_required_checkpoint_nos($audit_id);
        
        $nos = explode(',', $checkpoint_nos['nos']);
        
        $this->session->set_userdata('nos', $nos);
        if($type == 'find') {
            $last = $checkpoint_nos['last'];

            $currect_key = array_search($last, $nos);
            $this->session->set_userdata('current_key', $currect_key+1);

            if($currect_key !== false && isset($nos[$currect_key+1])) {
                $currect_checkpoint = $this->session->set_userdata('current_checkpoint', $nos[$currect_key+1]);
                $this->session->set_userdata('current_key', $currect_key+2);
            } else {
                $currect_checkpoint = $this->session->set_userdata('current_checkpoint', $nos[$currect_key]);
            }
        } else {
            $this->session->set_userdata('current_checkpoint', $nos[0]);
            $this->session->set_userdata('current_key', 1);
        }
        
        $this->session->set_userdata('mandatory_popup', 1);
    }
    
    private function get_n_set_checkpoint_session($type = 'next') {
        $currect_checkpoint = $this->session->userdata('current_checkpoint');
        $nos = $this->session->userdata('nos');
        
        $currect_key = array_search($currect_checkpoint, $nos);
        if($type == 'prev') {
            if(isset($nos[$currect_key-1])) {
                $currect_checkpoint = $this->session->set_userdata('current_checkpoint', $nos[$currect_key-1]);
                $this->session->set_userdata('current_key', $currect_key);
                return $nos[$currect_key-1];
            }
        } else if($type == 'next') {
            if(isset($nos[$currect_key+1])) {
                $currect_checkpoint = $this->session->set_userdata('current_checkpoint', $nos[$currect_key+1]);
                $this->session->set_userdata('current_key', $currect_key+2);
                return $nos[$currect_key+1];
            } else {
                return 'Completed';
            }
        }
        
    }
    
    public function get_drawing(){
        
        $part_no = $this->input->post('part_no');
        
        $conn = $this->oracle_connect();
        
        $sql = "select part_code, drawing_name, drawing_no, LENGTH(doc) as doc
                from lg_epis.xxsqis_part_drawing_v
                WHERE part_code = '".$part_no."'";
        
        //echo $sql;
        
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        $nrows = oci_fetch_all($stid, $part_number, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	
        if(isset($part_number)){
            $doc = $part_number[0]['DOC'];
            //print_r($part_number);
            //echo "success";
        }else{
            $doc = '';
            //echo "failure";
        }
        
        //echo " here";
        //print $img; 
	//$data['doc'] = $doc;
        //echo json_encode($doc);
        return json_encode($doc);
    }
    
    public function send_sms_redirect() {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        
        $sms = $this->input->post('sms');
        $to = $this->input->post('to');
        $message = $sms;

        //API URL
        $url="http://193.105.74.58/api/v3/sendsms/plain?user=".$user."&password=".$password."&sender=".$sender."&SMSText=".$message."&GSM=".$to;
        
        // init the resource
        $ch = curl_init();
        
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));

        //get response
        $output = curl_exec($ch);

        $flag = true;
        //Print error if any
        if(curl_errno($ch))
        {
            $flag = false;
        }
        
        curl_close($ch);
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}