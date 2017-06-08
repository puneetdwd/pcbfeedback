<?php
class Audit_model extends CI_Model {

    function get_audit_judgement($audit_id) {
        $sql = "SELECT COUNT(ac.id) as checkpoint_count, 
        SUM(IF(ac.result = 'OK', 1, 0)) as ok_count, 
        SUM(IF(ac.result = 'NG', 1, 0)) as ng_count, 
        SUM(IF(ac.result IS NULL, 1, 0)) as pending_count 
        FROM audit_checkpoints ac 
        WHERE ac.audit_id = ?";
        
        return $this->db->query($sql, array($audit_id))->row_array();
    }
    
    function get_completed_audits($filters, $count = false, $limit = '') {
        $pass_array = array();
        
        $sql = "SELECT a.*, s.supplier_no, s.name as supplier_name,
        si.name as inspector_name, pr.name as product_name
        FROM audits a
        INNER JOIN suppliers s ON a.supplier_id = s.id
        INNER JOIN supplier_inspector si ON si.id = a.auditer_id
        INNER JOIN products pr ON pr.id = a.product_id
        WHERE state = 'completed'";
        
        if(!empty($filters['id'])) {
            $sql .= " AND a.id = ?";
            $pass_array[] = $filters['id'];
        }

        if(!empty($filters['start_range']) && !empty($filters['end_range'])) {
            $sql .= " AND a.audit_date BETWEEN ? AND ?";
            $pass_array[] = $filters['start_range'];
            $pass_array[] = $filters['end_range'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= " AND a.part_id = ?";
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_no'])) {
            $sql .= " AND a.part_no = ?";
            $pass_array[] = $filters['part_no'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= " AND a.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
        
        if($this->product_id && @$filters['product_all'] != 'all') {
            $sql .= ' AND a.product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        $sql .= " GROUP BY a.id
        ORDER BY a.audit_date DESC, a.id DESC";
        
        if($count) {
            $sql = "SELECT count(id) as c FROM (".$sql.") as sub";
        } else {
            $sql .= " ".$limit;
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_consolidated_audit_report($filters, $count = false, $limit = '') {
        $pass_array = array();
        $sql = "SELECT MAX(a.audit_date) as audit_date, a.supplier_id, a.part_no, a.part_name,
        s.supplier_no, s.name as supplier_name, 
        count(a.lot_no) as no_of_lots,
        SUM(IF(a.ng_count = 0, 1, 0)) as ok_lots,
        SUM(IF(a.ng_count > 0, 1, 0)) as ng_lots,
        pr.name as product_name
        FROM audits_completed a
        INNER JOIN suppliers s 
        ON a.supplier_id = s.id
        INNER JOIN products pr 
        ON pr.id = a.product_id ";
        
        $wheres = '';
        if(!empty($filters['id'])) {
            $wheres[] = "a.id = ?";
            $pass_array[] = $filters['id'];
        }

        if(!empty($filters['start_range']) && !empty($filters['end_range'])) {
            $wheres[] = "a.audit_date BETWEEN ? AND ?";
            $pass_array[] = $filters['start_range'];
            $pass_array[] = $filters['end_range'];
        }
        
        if(!empty($filters['part_id'])) {
            $wheres[] = "a.part_id = ?";
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_no'])) {
            $wheres[] = "a.part_no = ?";
            $pass_array[] = $filters['part_no'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $wheres[] = " a.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
        
        if($this->product_id && @$filters['product_all'] != 'all') {
            $wheres[] = " a.product_id = ?";
            $pass_array[] = $this->product_id;
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        $sql .= " GROUP BY a.supplier_id, a.part_id";
        
        if($count) {
            $sql = "SELECT count(*) as c FROM (".$sql.") as sub";
        } else {
            $sql .= " ".$limit;
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_audit($auditer_id, $state = '', $date = '', $id = '', $on_hold = 0, $product_id = '') {
        
        $sql = "SELECT a.*, p.name as product_name, p.org_name,
        s.name as supplier_name, s.supplier_no
        FROM audits a
        INNER JOIN products p
        ON a.product_id = p.id
        INNER JOIN suppliers s
        ON a.supplier_id = s.id";
        
        $wheres = array();
        $pass_array = array();
        
        if(!empty($auditer_id)) {
            $wheres[] = 'a.auditer_id = ?';
            $pass_array[] = $auditer_id;
        }
        
        if(!empty($product_id)) {
            $wheres[] = 'a.product_id = ?';
            $pass_array[] = $product_id;
        }
        
        if($on_hold !== null) {
            $wheres[] = "a.on_hold = ?";
            $pass_array[] = $on_hold;
        }
        
        if(!empty($state)) {
            if(!is_array($state)) {
                $wheres[] = "a.state = ?";
                $pass_array[] = $state;
            } else {
                $wheres[] = "a.state IN (". implode(',', array_fill(0, count($state), '?')).")";
                $pass_array = array_merge($pass_array, $state);
            }
        }
        if(!empty($date)) {
            $wheres[] = "a.audit_date = ?";
            $pass_array[] = $date;
        }
        if(!empty($id)) {
            $wheres[] = "a.id = ?";
            $pass_array[] = $id;
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        $sql .= " GROUP BY a.id";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }

    function get_on_hold_audits($auditer_id) {
        $sql = "SELECT a.*, p.name as product_name, p.org_name,
        s.name as supplier_name, s.supplier_no
        FROM audits a
        INNER JOIN products p
        ON a.product_id = p.id
        INNER JOIN suppliers s
        ON a.supplier_id = s.id
        WHERE a.auditer_id = ?
        AND on_hold = 1
        AND a.state NOT IN ('aborted', 'completed')";
        
        $pass_array = array($auditer_id);
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function check_already_inspected($data) {
        $this->db->where('audit_date'   , $data['audit_date']);
        $this->db->where('product_id'   , $data['product_id']);
        $this->db->where('part_id'      , $data['part_id']);
        $this->db->where('supplier_id'  , $data['supplier_id']);
        $this->db->where('state !='     , 'aborted');
        
        return $this->db->count_all_results('audits');
    }
    
    function update_audit($data, $audit_id) {
        $needed_array = array('audit_date', 'auditer_id', 'supplier_id', 'product_id', 'part_id', 'part_no', 'part_name', 'prod_lot_qty', 'state', 'on_hold', 'register_datetime');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($audit_id)) {
            $data['lot_no']     = $this->generate_lot_no();
            $data['created']    = date("Y-m-d H:i:s");
            return (($this->db->insert('audits', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $audit_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('audits', $data)) ? $audit_id : False);
        }
        
    }

    function change_state($audit_id, $auditer_id, $state) {
        $allowed_state = array('registered','aborted','started','finished','completed');
        if(!in_array($state, $allowed_state))
            return false;
        
        $this->db->where('id', $audit_id);
        $this->db->where('auditer_id', $auditer_id);
        $this->db->set('state', $state);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        $response = $this->db->update('audits');
        return $response;
    }
    
    function hold_resume_audit($audit_id, $on_hold = 1) {
        $this->db->where('id', $audit_id);
        $this->db->set('on_hold', $on_hold);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        return $this->db->update('audits');
    }
    
    function checkpoint_audited($product_id, $part_id, $checkpoint_id, $date) {
        $sql = "SELECT count(*) as count FROM audits a 
        INNER JOIN audit_checkpoints ac
        ON a.id = ac.audit_id AND ac.org_checkpoint_id = ?
        WHERE a.audit_date >= ?
        AND a.product_id = ?
        AND a.part_id = ?
        AND a.state = 'completed'";
        
        $pass_array = array($checkpoint_id, $date, $product_id, $part_id);
        
        $record = $this->db->query($sql, $pass_array);
        
        $count = 0;
        if($record->num_rows() > 0) {
            $record = $record->row_array();
            $count =  $record['count'];
        }
        
        return $count;
    }
    
    function create_audit_checkpoints($product_id, $part_id, $audit_id, $case, $exclude = '') {
        $this->db->where('audit_id', $audit_id);
        $this->db->delete('audit_checkpoints');
        
        $pass_array = array($product_id, $part_id);
        
        $sql = "INSERT INTO audit_checkpoints(`org_checkpoint_id`, `audit_id`, `checkpoint_no`, `insp_item`, `insp_item2`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `checkpoint_type`, `sampling_type`, `inspection_level`, `acceptable_quality`, `sampling_qty`, `created`)
        SELECT c.id, ".$audit_id." as audit_id, c.checkpoint_no, 
        c.insp_item, c.insp_item2, c.spec,
        if(c.lsl IS NULL, c.lsl, c.lsl) as lsl,
        if(c.usl IS NULL, c.usl, c.usl) as usl,
        if(c.tgt IS NULL, c.tgt, c.tgt) as tgt,
        if(c.unit IS NULL, c.unit, c.unit) as unit, 
        c.checkpoint_type, ic.sampling_type, ic.inspection_level, ic.acceptable_quality, ";
        
        $sql .= $case.', ';
        
        $sql .= "'".date("Y-m-d H:i:s")."' as created
        FROM checkpoints c 
        LEFT JOIN inspection_config ic
        ON ic.checkpoint_id = c.id
        WHERE c.product_id = ?
        AND c.part_id = ?
        AND c.is_deleted = 0
        AND (c.checkpoint_type = 'LG' OR c.approved_by IS NOT NULL)";
        
        if($exclude) {
            $sql .= " AND c.id NOT IN (?)";
            $pass_array[] = $exclude;
        }

        $sql .= " ORDER BY c.checkpoint_type DESC, c.checkpoint_no ASC";
        
        $this->db->query($sql, $pass_array);
        
        return TRUE;
    }
    
    function get_required_checkpoint_nos($audit_id) {
        $sql = "SELECT GROUP_CONCAT(`org_checkpoint_id` ORDER BY id) as nos,
        MAX(IF (pointer = 1, org_checkpoint_id, null)) as last
        FROM `audit_checkpoints` 
        WHERE audit_id = ?";
        
        $pass_array = array($audit_id);
        
        $sql .= " GROUP BY audit_id";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_all_audit_checkpoints($audit_id) {
        $this->db->where('audit_id', $audit_id);
        
        $this->db->order_by('checkpoint_type DESC, checkpoint_no ASC');
        
        return $this->db->get('audit_checkpoints')->result_array();
    }
    
    function get_count_checkpoint_by_result($audit_id, $result) {
        $this->db->where('audit_id', $audit_id);
        if($result) {
            $this->db->where('result', $result);
        } else {
            $this->db->where('result IS NULL');
        }
        return $this->db->count_all_results('audit_checkpoints');
    }
    
    function check_slippage($audit_id) {        
        $this->db->where('audit_id', $audit_id);
        $this->db->where('result IS NULL');
        
        return $this->db->count_all_results('audit_checkpoints');
    }
    
    function get_checkpoint($audit_id, $checkpoint_id) {
        $this->db->where('audit_id', $audit_id);
        $this->db->where('org_checkpoint_id', $checkpoint_id);
        
        return $this->db->get('audit_checkpoints')->row_array();
    }
    
    function record_checkpoint_result($data, $checkpoint_id, $audit_id) {
        $needed_array = array('remark', 'all_values', 'all_results', 'result');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        $this->db->where('id', $checkpoint_id);
        $this->db->where('audit_id', $audit_id);
        $data['result_datetime'] = date("Y-m-d H:i:s");
        $data['pointer'] = 1;
        $data['modified'] = date("Y-m-d H:i:s");
        
        return (($this->db->update('audit_checkpoints', $data)) ? $audit_id : False);
    }

    function get_all_audit_parts($auditer_id = '', $supplier_id = '') {
        $sql = "SELECT DISTINCT part_no, part_name 
        FROM audits WHERE product_id = ?";
        
        $pass_array = array($this->product_id);
        
        if(!empty($auditer_id)) {
            $sql .= " AND auditer_id = ?";
            $pass_array[] = $auditer_id;
        }
        
        if(!empty($supplier_id)) {
            $sql .= " AND supplier_id = ?";
            $pass_array[] = $supplier_id;
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function add_to_completed_audits($audit_id) {
        $sql = "INSERT INTO `audits_completed`(`lot_no`, `audit_id`, `audit_date`, `auditer_id`, `supplier_id`, `product_id`, `part_id`, `part_no`, `part_name`, `prod_lot_qty`, `checkpoint_count`, `ok_count`, `ng_count`, `created`)
        SELECT a.lot_no, a.id, a.audit_date, a.auditer_id, a.supplier_id, a.product_id, a.part_id, a.part_no, a.part_name, a.prod_lot_qty,
        COUNT(ac.id) as checkpoint_count,
        SUM(IF(ac.result = 'OK', 1, 0)) as ok_count,
        SUM(IF(ac.result = 'NG', 1, 0)) as ng_count, NOW()
        FROM audits a
        LEFT JOIN audit_checkpoints ac
        ON a.id = ac.audit_id
        WHERE a.id = ?";
        
        $pass_array = array($audit_id);
        return $this->db->query($sql, $pass_array);
    }
    
    function check_audit_complete_exists($audit_id) {
        $this->db->where('audit_id', $audit_id);
        
        return $this->db->count_all_results('audits_completed');
    }
    
    function delete_audit_complete($audit_id) {
        $this->db->where('audit_id', $audit_id);
        
        return $this->db->delete('audits_completed');
    }
    
    function generate_lot_no() {
        $org_name = $this->session->userdata('org_name');
        $sql = "SELECT MAX(lot_no) as lot_no
        FROM audits
        WHERE lot_no LIKE ?";
         
        $lot_start = 'S'.$org_name.date('y').date('m');
        $record = $this->db->query($sql, array($lot_start.'%'));

        $lot = 0;
        if($record->num_rows() > 0) {
            $record = $record->row_array();
            $lot =  $record['lot_no'];
        }

        if(empty($lot)) {
            return $lot_start.str_pad(1, 7, '0', STR_PAD_LEFT);
        }

        $new_lot = (int)str_replace($lot_start, '', $lot) + 1;
        return $lot_start.str_pad($new_lot, 7, '0', STR_PAD_LEFT);

    }
}