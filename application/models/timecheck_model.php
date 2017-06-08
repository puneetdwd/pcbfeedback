<?php
class Timecheck_model extends CI_Model {

    function create_timecheck($plan_id, $part_id, $child_part_no, $mold_no, $supplier_id) {        
        $sql = "INSERT INTO timechecks(`org_checkpoint_id`, `plan_id`, `product_id`, `part_id`, `child_part_no`, `mold_no`, `checkpoint_no`, `insp_type`, `insp_item`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `supplier_id`, `stage`, `sample_qty`, `frequency`, `measure_type`, `instrument`, `created`)
        SELECT `id`, ".$plan_id.", `product_id`, `part_id`, `child_part_no`, `mold_no`, `checkpoint_no`, `insp_type`, `insp_item`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `supplier_id`, `stage`, `sample_qty`, `frequency`, `measure_type`, `instrument`, '".date("Y-m-d H:i:s")."' as created
        FROM tc_checkpoints c
        WHERE c.part_id = ?
        AND c.child_part_no = ?
        AND c.mold_no = ?
        AND c.supplier_id = ?
        AND c.is_deleted = 0
        ORDER BY c.checkpoint_no";
        
        $pass_array = array($part_id, $child_part_no, $mold_no, $supplier_id);
        
        $this->db->query($sql, $pass_array);
    }

    function is_plan_timecheck_exists($plan_id) {
        $this->db->where('plan_id', $plan_id);
        
        return $this->db->count_all_results('timechecks');
    }

    function get_sample_n_frequency($plan_id) {
        $sql = "SELECT MAX(sample_qty) as sample_qty, MIN(frequency) as frequency, GROUP_CONCAT(DISTINCT frequency ORDER BY frequency) as all_frequencies
        FROM timechecks
        WHERE plan_id = ?
        GROUP BY plan_id";
        
        $pass_array = array($plan_id);
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_checkpoints($plan_id) {
        $this->db->where('plan_id', $plan_id);
        
        return $this->db->get('timechecks')->result_array();
    }
    
    function get_checkpoint($plan_id, $checkpoint_id) {
        $this->db->where('plan_id', $plan_id);
        $this->db->where('id', $checkpoint_id);
        
        return $this->db->get('timechecks')->row_array();
    }
    
    function update_checkpoint($result, $checkpoint_id, $value = false) {
        $this->db->where('id', $checkpoint_id);
        
        if($value) {
            $this->db->set('all_values', $result);
        } else {
            $this->db->set('all_results', $result);
        }
        
        $this->db->update('timechecks');
    }

    function update_result($all_results, $all_values, $result, $plan_id) {
        $sql = "UPDATE timechecks SET all_results = ".$all_results."
        , all_values = ".$all_values.", result = ".$result.", org_all_results = ".$all_results."
        , org_all_values = ".$all_values."
        WHERE plan_id = ?";
        
        $this->db->query($sql, array($plan_id));
    }

    function get_timecheck_plan_report($filters, $count = false, $limit = '') {
        $pass_array = array();
        
        $sql = "SELECT p.*, pp.code as part_no, pp.name as part_name,
        COUNT(f.id) as frequency_count,
        SUM(IF(f.result = 'OK', 1, 0)) as ok_count, 
        SUM(IF(f.result = 'NG', 1, 0)) as ng_count,
        GROUP_CONCAT(f.result ORDER BY f.freq_index) as freq_results,
        GROUP_CONCAT(f.freq_index ORDER BY f.freq_index) as freq_indexs
        FROM timecheck_plans p
        LEFT JOIN product_parts pp
        ON p.part_id = pp.id
        LEFT JOIN tc_frequency_result f
        ON p.id = f.plan_id";
        
        $wheres = array();
        if(!empty($filters['start_range']) && !empty($filters['end_range'])) {
            $wheres[] = "p.plan_date BETWEEN ? AND ?";
            $pass_array[] = $filters['start_range'];
            $pass_array[] = $filters['end_range'];
        }
        
        if(!empty($filters['part_id'])) {
            $wheres[] = "p.part_id = ?";
            $pass_array[] = $filters['part_id'];
        }
        
        
        if(!empty($filters['supplier_id'])) {
            $wheres[] = " p.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        $sql .= " GROUP BY p.id";
        
        if($count) {
            $sql = "SELECT count(*) as c FROM (".$sql.") as sub";
        } else {
            $sql .= " ".$limit;
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function update_plan_freq_result($data, $id){
        $needed_array = array('plan_id', 'freq_index', 'from_time', 'to_time', 'result', 'org_result', 'production_qty');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('tc_frequency_result', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('tc_frequency_result', $data)) ? $id : False);
        }
        
    }
    
    function change_plan_freq_result($plan_id, $freq_index, $result) {
        $this->db->where('plan_id', $plan_id);
        $this->db->where('freq_index', $freq_index);
        
        $this->db->set('result', $result);
        
        return $this->db->update('tc_frequency_result');
    }
    
    function get_plan_freq_result($plan_id, $freq_index) {
        $this->db->where('plan_id', $plan_id);
        $this->db->where('freq_index', $freq_index);
        
        return $this->db->get('tc_frequency_result')->row_array();
    }
    
    function get_plan_all_freq_results($plan_id) {
        $this->db->where('plan_id', $plan_id);
        $this->db->order_by('freq_index');
        
        return $this->db->get('tc_frequency_result')->result_array();
    }
}