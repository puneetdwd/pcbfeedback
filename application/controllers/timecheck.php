<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timecheck extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        $page = 'timecheck';
        $this->template->write_view('header', 'templates/header', array('page' => $page));
        $this->template->write_view('footer', 'templates/footer');

    }

    public function index() {
        $data = array();
        $this->load->model('TC_Checkpoint_model');

        $plan_date = date('Y-m-d');
        $data['plan_date'] = $plan_date;
        $plans = $this->TC_Checkpoint_model->get_all_plans($this->product_id, $this->supplier_id, $plan_date);

        $allowed = array();
        foreach($plans as $plan) {
            $from = strtotime(date('Y-m-d').' '.$plan['from_time']);
            $to = strtotime(date('Y-m-d').' '.$plan['to_time']);

            if($from > strtotime('now')) {
                continue;
            }
            
            if($to < strtotime('-30 minute')) {
                continue;
            }
            
            $allowed[] = $plan;
        }

        $data['plans'] = $allowed;

        $this->template->write('title', 'SQIM | Scheduled Timechecks');
        $this->template->write_view('content', 'timecheck/scheduled', $data);
        $this->template->render();
    }
    
    public function view($plan_id) {
        $this->load->model('TC_Checkpoint_model');
        
        $plan = $this->TC_Checkpoint_model->get_plan($plan_id, $this->supplier_id);
        if(empty($plan) || empty($plan['plan_status']))
            redirect($_SERVER['HTTP_REFERER']);

        $checkpoints = $this->TC_Checkpoint_model->get_checkpoints($this->product_id, $this->supplier_id, $plan['part_no']);
        //echo "<pre>"; print_r($plan); exit;
        
        $from = strtotime($plan['plan_date'].' '.$plan['from_time']);
        $to = strtotime($plan['plan_date'].' '.$plan['to_time']);
        
        $total_hours = round(($to-$from)/3600, 2);
        $data['plan'] = $plan;
        
        $this->load->model('Timecheck_model');
        
        $results = $this->Timecheck_model->get_plan_all_freq_results($plan['id']);
        $freq_results = array();
        $freq_org_results = array();
        $production_qties = array();
        foreach($results as $result) {
            $freq_results[$result['freq_index']] = $result['result'];
            $freq_org_results[$result['freq_index']] = $result['org_result'];
            $production_qties[$result['freq_index']] = $result['production_qty'];
        }
        
        $data['freq_results'] = $freq_results;
        $data['freq_org_results'] = $freq_org_results;
        $data['production_qties'] = $production_qties;
        
        $data['freq_results'] = $freq_results;

        $checkpoints = $this->Timecheck_model->get_checkpoints($plan['id']);
        $data['checkpoints'] = $checkpoints;

        $details = $this->Timecheck_model->get_sample_n_frequency($plan['id']);
        $freq_step = $this->get_freq_step($details);
        
        $no_of_results          = $details['sample_qty']*$freq_step;
        $data['no_of_results']  = $no_of_results;
        $data['sample_qty']     = $details['sample_qty'];

        $freq                   = ceil($total_hours/$freq_step);
        $data['frequency']      = $freq;
        $data['freq_step']      = $freq_step;
        
        $frequency_headers = array();
        for($i = 1; $i <= $freq; $i++) {
            $header = date('h:i A', strtotime('+'.($i-1)*$freq_step.' hours', strtotime($plan['plan_date'].$plan['from_time'])));
            $header .= '<br /><small>to</small><br />';
            if($i != $freq) {
                $header .= date('h:i A', strtotime('+'.($i)*$freq_step.' hours', strtotime($plan['plan_date'].$plan['from_time'])));
            } else {
                $header .= date('h:i A', strtotime($plan['plan_date'].$plan['to_time']));
            }
            $frequency_headers[] = $header;
        }
        $data['frequency_headers'] = $frequency_headers;
        
        if($this->input->get('download')) {
            $data['download'] = true;
            $str = $this->load->view('timecheck/download', $data, true);
        
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Timecheck_'.$plan['part_no'].'.xls');
            // Fix for crappy IE bug in download.
            header("Pragma: ");
            header("Cache-Control: ");
            echo $str;
        } else {
            $this->template->write('title', 'SQIM | Timechecks');
            $this->template->write_view('content', 'timecheck/view', $data);
            $this->template->render();
        }
        
    }
    
    public function start($plan_id) {
        $this->load->model('TC_Checkpoint_model');
        
        $plan = $this->TC_Checkpoint_model->get_plan($plan_id, $this->supplier_id);
        if(empty($plan))
            redirect($_SERVER['HTTP_REFERER']);
        
        $from = strtotime($plan['plan_date'].' '.$plan['from_time']);
        if($from > strtotime('now')) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $checkpoints = $this->TC_Checkpoint_model->get_checkpoints($this->product_id, $this->supplier_id, $plan['part_no'], $plan['child_part_no'], $plan['mold_no']);

        if(empty($checkpoints)) {
            $this->session->set_flashdata('error', 'No checkpoint found for this part.');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        $from = strtotime($plan['plan_date'].' '.$plan['from_time']);
        $to = strtotime($plan['plan_date'].' '.$plan['to_time']);
        $total_hours = round(($to-$from)/3600, 2);
        
        $data['plan'] = $plan;
        
        $this->load->model('Timecheck_model');
        if(!$this->Timecheck_model->is_plan_timecheck_exists($plan['id'])) {
            $this->Timecheck_model->create_timecheck($plan['id'], $plan['part_id'], $plan['child_part_no'], $plan['mold_no'], $this->supplier_id);
            $this->TC_Checkpoint_model->change_plan_status($plan['id'], 'Started');
        }
        
        
        $checkpoints = $this->Timecheck_model->get_checkpoints($plan['id']);
        $data['checkpoints'] = $checkpoints;

        $details = $this->Timecheck_model->get_sample_n_frequency($plan['id']);

        $freq_step = $this->get_freq_step($details);
        
        $no_of_results          = $details['sample_qty']*$freq_step;
        $data['no_of_results']  = $no_of_results;
        $data['sample_qty']     = $details['sample_qty'];

        $freq                   = ceil($total_hours/$freq_step);
        $data['frequency']      = $freq;
        $data['freq_step']      = $freq_step;
        
        $allowed = @array_fill(0, $freq, 'No');
        //echo $total_hours.' '.$freq_step.' '.$freq; exit;
        $frequency_headers = array();

        for($i = 1; $i <= $freq; $i++) {
            $from_time  = date('h:i A', strtotime('+'.($i-1)*$freq_step.' hours', strtotime($plan['plan_date'].$plan['from_time'])));

            if($i != $freq) {
                $to_time = date('h:i A', strtotime('+'.($i)*$freq_step.' hours', strtotime($plan['plan_date'].$plan['from_time'])));
            } else {
                $to_time = date('h:i A', strtotime($plan['plan_date'].$plan['to_time']));
            }
            
            $frequency_headers[] = $from_time.'<br /><small>to</small><br />'.$to_time;

            $allowed_time = date('Y-m-d H:i', strtotime('+30 minutes', strtotime($to_time)));
            $from_date_time = date('Y-m-d H:i', strtotime('+'.($i-1)*$freq_step.' hours', strtotime($plan['plan_date'].$plan['from_time'])));

            if(strtotime($from_date_time) <= strtotime('now') AND strtotime($allowed_time) >= strtotime('now')) {
                $allowed[$i-1] = 'Yes';
            }
        }
        
        $results = $this->Timecheck_model->get_plan_all_freq_results($plan['id']);
        $freq_results = array();
        $production_qties = array();
        foreach($results as $result) {
            $freq_results[$result['freq_index']] = $result['result'];
            $production_qties[$result['freq_index']] = $result['production_qty'];
        }
        
        $data['freq_results'] = $freq_results;
        $data['production_qties'] = $production_qties;
        //echo "<pre>";print_r($production_qties);exit;
        
        /* $allowed[0] = 'No';
        $allowed[1] = 'No';
        $allowed[2] = 'No';
        $allowed[3] = 'Yes'; */
        //echo "<pre>";print_r($allowed);exit;
        
        
        /* foreach($checkpoints as $k => $checkpoint) {
            $all_results = explode(',', $checkpoint['all_results']);
            $all_values = explode(',', $checkpoint['all_values']);
            $current = 0;
            
            if($k !== 3) {
                continue;
            }
            
            $last_allowed_freq = null;
            echo "<pre>";
            echo "-----<br />";
            echo "Checkpoint ".($k+1).' Frequency '.$checkpoint['frequency'].'<br />';
            for($i = 0; $i < $freq; $i++) {
                
                echo '----Freq '.$i.'----<br />';
                $freq_period = floor(($i*$freq_step)/$checkpoint['frequency']);
                echo 'Freq Period '.$freq_period.'<br />';
                
                $freq_passed_slot = $i-($freq_period*($checkpoint['frequency']/$freq_step));
                echo 'Freq Passed '.$freq_passed_slot.'<br />';
                
                $freq_remaining = ($checkpoint['frequency']/$freq_step)-$freq_passed_slot-1;
                echo 'Freq Remaining '.$freq_remaining.'<br />';
                
                $slice_start = ($freq_period*($checkpoint['frequency']/$freq_step)*$data['sample_qty']);
                if($slice_start < 0) {
                    $slice_start = 0;
                }
                
                echo 'Slice Start '.$slice_start.'<br />';
                $passed = ($freq_period+1)*($checkpoint['frequency']/$freq_step)*$data['sample_qty'];
                echo 'Passed '.$passed.'<br />';
                
                if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) {
                    $sliced = array_slice($all_values, $slice_start, $passed);
                } else {
                    $sliced = array_slice($all_results, $slice_start, $passed);
                }
                
                print_r($sliced);
                $already_filled = false;
                foreach($sliced as $slice) {
                    if(!empty($slice)) {
                        $already_filled = true;
                    }
                }
                
                echo 'Already Filled '.(($already_filled) ? 'Yes' : 'No').'<br />';
            }
            echo "-----<br />";
            break;
        }
        
        exit; */
        
        $data['allowed'] = $allowed;
        $data['frequency_headers'] = $frequency_headers;
        
        $this->template->write('title', 'SQIM | Timechecks');
        $this->template->write_view('content', 'timecheck/timecheck', $data);
        $this->template->render();
    }
    
    function save_result() {
        if(!$this->input->post('plan_id')) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $part_id = $this->input->post('part_id');
        $current_frequency = $this->input->post('current_frequency');
        $plan_id = $this->input->post('plan_id');
        
        $this->load->model('TC_Checkpoint_model');
        $plan = $this->TC_Checkpoint_model->get_plan($plan_id, $this->supplier_id);
        if(empty($plan))
            redirect($_SERVER['HTTP_REFERER']);
        
        $from = strtotime($plan['plan_date'].' '.$plan['from_time']);
        $to = strtotime($plan['plan_date'].' '.$plan['to_time']);
        $total_hours = round(($to-$from)/3600, 2);

        $this->load->model('Timecheck_model');
        $checkpoints = $this->Timecheck_model->get_checkpoints($plan_id);
        $details = $this->Timecheck_model->get_sample_n_frequency($plan_id);
        
        $freq_step = $this->get_freq_step($details);

        $current_frequency = $current_frequency-1;
        $current_index = ($current_frequency*$details['sample_qty']);
        
        
        $freq   = ceil($total_hours/$freq_step);

        $result = $this->input->post('result');
        if(!$result) {
            $result = array();
        }
        $values = $this->input->post('values');
        if(!$values) {
            $values = array();
        }

        $final = array();
        $freq_result = 'OK';
        foreach($checkpoints as $checkpoint) {
            $lsl            = $checkpoint['lsl'];
            $usl            = $checkpoint['usl'];
            $final_result   = $checkpoint['result'];
            $all_results    = empty($current_index) ? array() : array_fill(0, $current_index, '');
            $all_values     = empty($current_index) ? array() : array_fill(0, $current_index, '');
            $all_results    = array_slice(array_replace($all_results, explode(',', $checkpoint['all_results'])), 0, $current_index);
            $all_values     = array_slice(array_replace($all_values, explode(',', $checkpoint['all_values'])), 0, $current_index);

        
            foreach($result as $id => $res) {
                if($checkpoint['id'] == $id) {
                    $all_results = array_merge($all_results, array_pad($res, $details['sample_qty'], ""));
                    $final[$id]['results'] = implode(',', $all_results);
                    $final[$id]['final'] = (strpos($final[$id]['results'], 'NG') === false ? 'OK' : 'NG');

                    if(strpos(implode(',', $res), 'NG') !== false) {
                        $freq_result = 'NG';
                    }

                    $final[$id]['values'] = implode(',', array_merge($all_values, array_fill(0, $details['sample_qty'], '')));
                    continue 2;
                }
            }
            
            foreach($values as $id => $val) {

                if($checkpoint['id'] == $id) {
                    foreach($val as $v) {
                        if(!empty($lsl) && $v < $lsl) {
                            $final_result = 'NG';
                            $freq_result = 'NG';
                            continue;
                        }
                        
                        if(!empty($usl) && $v > $usl) {
                            $final_result = 'NG';
                            $freq_result = 'NG';
                            continue;
                        }
                    }
                    
                    $all_values = array_merge($all_values, array_pad($val, $details['sample_qty'], ""));
                    $final[$id]['values'] = implode(',', $all_values);
                    $final[$id]['results'] = implode(',', array_merge($all_results, array_fill(0, $details['sample_qty'], '')));
                    $final[$id]['final'] = $final_result;
                    
                    continue 2;
                }
                
               
            }
            
            $final[$checkpoint['id']]['results'] = implode(',', array_merge($all_results, array_fill(0, $details['sample_qty'], '')));
            $final[$checkpoint['id']]['values'] = implode(',', array_merge($all_values, array_fill(0, $details['sample_qty'], '')));
            $final[$checkpoint['id']]['final'] = $final_result;

        }
        
        $case_res = "CASE ";
        $case_val = "CASE ";
        $case_fin = "CASE ";
        
        foreach($final as $id => $f) {
            $r = isset($f['results']) ? $f['results'] : '';
            $v = isset($f['values']) ? $f['values'] : '';
            $f = isset($f['final']) ? $f['final'] : '';
            //echo $r;
            
            $case_res .= "WHEN id = ".$id." THEN '".$r."' ";
            $case_val .= "WHEN id = ".$id." THEN '".$v."' ";
            $case_fin .= "WHEN id = ".$id." THEN '".$f."' ";
        }
        
        $case_res .= " END";
        $case_val .= " END";
        $case_fin .= " END";
        
        /* echo "<pre>";
        print_r($all_results);
        print_r($all_values);
        print_r($final);
        print_r($freq_result);
        exit; */
        
        if($plan['total_frequencies'] != $freq) {
            $this->TC_Checkpoint_model->update_plan_freq($plan['id'], $freq);
        }
        
        $this->Timecheck_model->update_result($case_res, $case_val, $case_fin, $plan['id']);

        $plan_freq = array();
        $plan_freq['plan_id'] = $plan_id;
        $plan_freq['freq_index'] = $current_frequency+1;
        $plan_freq['from_time'] = date('Y-m-d H:i:s', strtotime('+'.($current_frequency)*$details['frequency'].' hours', strtotime($plan['plan_date'].$plan['from_time'])));
        $plan_freq['to_time'] = date('Y-m-d H:i:s', strtotime('+'.($current_frequency+1)*$details['frequency'].' hours', strtotime($plan['plan_date'].$plan['from_time'])));
        $plan_freq['result'] = $freq_result;
        $plan_freq['org_result'] = $freq_result;
        $plan_freq['production_qty'] = $this->input->post('production_qty');
        
        $plan_freq_exists = $this->Timecheck_model->get_plan_freq_result($plan_id, $current_frequency+1);
        $plan_freq_id = !empty($plan_freq_exists) ? $plan_freq_exists['id'] : '';
        
        $this->Timecheck_model->update_plan_freq_result($plan_freq, $plan_freq_id);
        
        if(($current_frequency+1) == $plan['total_frequencies']) {
            $this->TC_Checkpoint_model->change_plan_status($plan['id'], 'Completed');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    private function get_freq_step($details) {
        $frequencies = explode(',',$details['all_frequencies']);
        
        $all_evens = true;
        if(count($frequencies) !== 1) {
            foreach($frequencies as $f) {
                if($f%2 !== 0) {
                    $all_evens = false;
                    break;
                }
            }
            
            if($all_evens) {
                $freq_step = 2;
            } else {
                $freq_step = 1;
            }
        } else {
            $freq_step = $details['frequency'];
        }
        
        return $freq_step;
    }
    
    function edit_freq($detail) {
        $data['detail'] = $detail;
        $detail = explode('-', $detail);
        $plan_id = $detail[0];
        $checkpoint_id = $detail[1];
        $frequency = $detail[2];
        $sample = $detail[3];
        
        
        $this->load->model('Timecheck_model');
        $sample_n_freq =  $this->Timecheck_model->get_sample_n_frequency($plan_id);

        $sample_qty = $sample_n_freq['sample_qty'];
        $result_index = ($frequency*$sample_qty)+$sample-1;
        
        $checkpoint = $this->Timecheck_model->get_checkpoint($plan_id, $checkpoint_id);

        if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) {
            $all_results = explode(',', $checkpoint['all_values']);
        } else {
            $all_results = explode(',', $checkpoint['all_results']);
        }
        
        if($this->input->post('result')) {
            $all_results[$result_index] = $this->input->post('result');
            
            $this->Timecheck_model->update_checkpoint(implode(',', $all_results), $checkpoint['id'], !empty($checkpoint['lsl']) || !empty($checkpoint['usl']));
            
            $freq_result_start = $frequency*$sample_qty;
            
            $checkpoints = $this->Timecheck_model->get_checkpoints($plan_id);
            
            $freq_res = 'OK';
            foreach($checkpoints as $c) {
                if(!empty($c['lsl']) || !empty($c['usl'])) {
                    $freq_data = array_slice(explode(',', $c['all_values']), $freq_result_start, $sample_qty);
                    foreach($freq_data as $d) {
                        if(!empty($c['lsl']) && $d < $c['lsl']) {
                            $freq_res = 'NG';
                            continue;
                        }
                        
                        if(!empty($c['usl']) && $d > $c['usl']) {
                            $freq_res = 'NG';
                            continue;
                        }
                    }
                } else {
                    $freq_data = array_slice(explode(',', $c['all_results']), $freq_result_start, $sample_qty);
                    foreach($freq_data as $d) {
                        if($d == 'NG') {
                            $freq_res = 'NG';
                        }
                    }
                }
            }
            
            $this->Timecheck_model->change_plan_freq_result($plan_id, $frequency+1, $freq_res);
            /* echo "<pre>";
            print_r($freq_res);
            exit; */
            
            redirect(base_url().'timecheck/view/'.$plan_id);
        }
        $data['value'] = isset($all_results[$result_index]) ? $all_results[$result_index] : '';
        $data['result_index'] = $result_index;
        $data['checkpoint'] = $checkpoint;
        
        echo $this->load->view('timecheck/edit_frequency_ajax.php', $data);
        
    }
}