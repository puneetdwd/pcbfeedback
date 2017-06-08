<?php
class foolproof_model extends CI_Model {
    
    function get_all_checkpoints($supplier_id = '') {
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, c.cycle, 
        c.lsl, c.usl, c.tgt, c.unit, c.status, c.supplier_id, c.approved_by, c.is_deleted, s.name as supplier_name
        FROM foolproof_checkpoints c
        LEFT JOIN suppliers s ON c.supplier_id = s.id
        WHERE c.is_deleted = 0 ";
        
        $pass_array = array();
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " ORDER BY id, supplier_id ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }

    function get_checkpoints($supplier_id = '') {
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, c.cycle, 
        c.lsl, c.usl, c.tgt, c.unit, c.status, c.supplier_id, c.approved_by, c.is_deleted, s.name as supplier_name
        FROM foolproof_checkpoints c
        LEFT JOIN suppliers s ON c.supplier_id = s.id
        WHERE c.status = 'Approved' and c.is_deleted = 0 ";
        
        $pass_array = array();
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " ORDER BY id, supplier_id ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function saved_checkpoint($checkpoint_id, $date, $supplier_id=''){
        $sql = "SELECT c.id, c.all_results, c.all_values, c.result, c.image
        FROM foolproofs c
        LEFT JOIN suppliers s ON c.supplier_id = s.id";
        
        $pass_array = array();
        if(!empty($checkpoint_id)) {
            $sql .= ' WHERE c.org_checkpoint_id = ?';
            $pass_array[] = $checkpoint_id;
        }
        
        $sql .= " AND c.created like '%".$date."%' ";
        
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " GROUP BY c.org_checkpoint_id";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_checkpoint($id, $supplier_id = '') {
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, 
        c.lsl, c.usl, c.tgt, c.unit, c.status, c.cycle, c.supplier_id, c.approved_by
        FROM foolproof_checkpoints c
        WHERE c.id = ?
        AND c.is_deleted = 0 ";
        
        $pass_array = array($id);
        
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_mappings($part_no, $supplier_id=''){
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, c.cycle, 
        c.lsl, c.usl, c.tgt, c.unit, c.status, c.supplier_id, c.approved_by, c.is_deleted, s.name as supplier_name,
        pp.name as part_name, pp.code as part_no
        FROM foolproof_pc_mapping pc
        INNER JOIN foolproof_checkpoints c ON c.id = pc.checkpoint_id
        INNER JOIN product_parts pp ON pp.id = pc.part_id
        INNER JOIN suppliers s ON c.supplier_id = s.id
        WHERE pc.is_deleted = 0";
        
        $pass_array = array();
        
        if(!empty($part_no)) {
            $sql .= ' AND pp.code = ?';
            $pass_array[] = $part_no;
        }
        
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " ORDER BY id, supplier_id ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_mapping($mapping_id){
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, c.cycle, 
        c.lsl, c.usl, c.tgt, c.unit, c.status, c.supplier_id, c.approved_by, c.is_deleted, s.name as supplier_name,
        pp.name as part_name, pp.code as part_no
        FROM foolproof_pc_mapping pc
        INNER JOIN foolproof_checkpoints c ON c.id = pc.checkpoint_id
        INNER JOIN product_parts pp ON pp.id = pc.part_id
        INNER JOIN suppliers s ON c.supplier_id = s.id
        WHERE pc.is_deleted = 0";
        
        $pass_array = array();
        
        if(!empty($mapping_id)) {
            $sql .= ' AND pc.id = ?';
            $pass_array[] = $mapping_id;
        }
        
        $sql .= " ORDER BY id, supplier_id ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_unique_stages_by_supplier($supplier_id){
        $sql = "SELECT distinct stage 
                FROM foolproof_checkpoints 
                WHERE is_deleted = 0
                AND supplier_id = ?";
        
        return $this->db->query($sql, array($supplier_id))->result_array();
    }
    
    function get_unique_sub_stages_by_supplier($supplier_id, $stage=''){
        $sql = "SELECT distinct sub_stage
                FROM foolproof_checkpoints 
                WHERE is_deleted = 0";
        
                $pass_array = array();

                if(!empty($supplier_id)) {
                    $sql .= ' AND supplier_id = ?';
                    $pass_array[] = $supplier_id;
                }
                if(!empty($stage)) {
                    $sql .= ' AND stage = ?';
                    $pass_array[] = $stage;
                }
                
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_unique_mcp_by_supplier($supplier_id, $stage='', $sub_stage=''){
        $sql = "SELECT distinct major_control_parameters 
                FROM foolproof_checkpoints 
                WHERE is_deleted = 0";
        
                $pass_array = array();

                if(!empty($supplier_id)) {
                    $sql .= ' AND supplier_id = ?';
                    $pass_array[] = $supplier_id;
                }
                if(!empty($stage)) {
                    $sql .= ' AND stage = ?';
                    $pass_array[] = $stage;
                }
                if(!empty($sub_stage)) {
                    $sql .= ' AND sub_stage = ?';
                    $pass_array[] = $sub_stage;
                }
                
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_distinct_insp_type(){
        $sql = "SELECT distinct insp_item as insp_item FROM foolproof_checkpoints WHERE is_deleted = 0";
        
        return $this->db->query($sql)->result_array();
    }
    
    function is_checkpoint_no_exists($product_id, $part_id, $checkpoint_no, $id = '') {
        $this->db->where('product_id', $product_id);
        $this->db->where('part_id', $part_id);
        $this->db->where('checkpoint_type', 'LG');
        $this->db->where('checkpoint_no', $checkpoint_no);
        $this->db->where('is_deleted', 0);
        
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }
        
        return $this->db->count_all_results('foolproof_checkpoints');
    }
    
    function move_checkpoints($product_id, $part_id, $checkpoint_no) {
        $sql = "UPDATE foolproof_checkpoints SET 
        checkpoint_no = checkpoint_no + 1 
        WHERE product_id = ? 
        AND part_id = ?
        AND checkpoint_type = 'LG'
        AND checkpoint_no >= ? 
        AND checkpoint_no <= (
            SELECT * FROM (
                SELECT min(c1.checkpoint_no)
                FROM `foolproof_checkpoints` as c1
                LEFT JOIN `foolproof_checkpoints` as c2
                ON (
                    c1.checkpoint_no = c2.checkpoint_no-1
                    AND c1.`product_id` = c2.`product_id`
                    AND c1.`part_id` = c2.`part_id`
                )
                WHERE c1.product_id = ? 
                AND c1.part_id = ? 
                AND c1.checkpoint_no >= ?
                AND c2.id IS NULL
            ) as sub
        )";

        $pass_array = array($product_id, $part_id, $checkpoint_no, $product_id, $part_id, $checkpoint_no);
        return $this->db->query($sql, $pass_array);
    }
    
    function update_checkpoint($data, $checkpoint_id){
        $needed_array = array('stage', 'sub_stage', 'major_control_parameters', 'lsl', 'usl', 'tgt', 'unit', 
        'measuring_equipment', 'period', 'cycle', 'supplier_id', 'is_deleted');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        $data['status'] = 'Pending';
        
        if(empty($checkpoint_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('foolproof_checkpoints', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $checkpoint_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('foolproof_checkpoints', $data)) ? $checkpoint_id : False);
        }
        
    }
    
    function update_pc_mapping($data, $id){
        $needed_array = array('checkpoint_id', 'part_id', 'is_deleted');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('foolproof_pc_mapping', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('foolproof_pc_mapping', $data)) ? $id : False);
        }
    }
    
    function insert_checkpoints($checkpoints) {
        $this->db->insert_batch('foolproof_checkpoints', $checkpoints);
        
        //$this->remove_dups_checkpoints($product_id);
        
        //$this->db->query('CALL UpdateFoolproofCNO('.$product_id.')');
    }
    
    function insert_pc_mappings($mappings) {
        $this->db->insert_batch('foolproof_pc_mapping', $mappings);
    }
    
    function add_history($data) {
        $needed_array = array('version', 'type', 'product_id', 'part_id', 'checkpoint_no', 'insp_item', 'insp_item2', 'spec', 'lsl', 
        'usl', 'tgt', 'unit', 'sample_qty', 'supplier_id', 'checkpoint_type', 'approved_by', 'change_type', 'changed_on', 'remark');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        $data['created'] = date("Y-m-d H:i:s");
        return (($this->db->insert('foolproof_checkpoint_history', $data)) ? $this->db->insert_id() : False);
    }
    
    function get_revision_version($product_id) {
        $sql = "SELECT MAX(version) as version
        FROM foolproof_checkpoint_history h
        WHERE h.product_id = ?";
        
        $version = $this->db->query($sql, array($product_id))->row_array();
        return $version['version'];
    }
    
    function check_duplicate_checkpoint($data, $supplier_id){
        $sql = "SELECT id FROM foolproof_checkpoints 
                WHERE stage = ?
                AND sub_stage = ?
                AND major_control_parameters = ?
                AND supplier_id = ?";
        
        return $this->db->query($sql, array($data['stage'],$data['sub_stage'],$data['major_control_parameters'],$supplier_id))->row_array();
    }
    
    function check_duplicate_pc_mapping($data){
        $sql = "SELECT id FROM foolproof_pc_mapping
                WHERE checkpoint_id = ?
                AND part_id = ? ";
        
        return $this->db->query($sql, array($data['checkpoint_id'],$data['part_id']))->row_array();
    }
    
    function remove_dups_checkpoints($product_id) {
        $sql = "DELETE FROM foolproof_checkpoints 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM checkpoints 
                WHERE product_id = ? 
                GROUP BY product_id, part_id, insp_item, insp_item2
            ) as d
        ) AND product_id = ?";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
    
    /*Inspection Model Starts*/
    
    function get_audit($auditer_id, $state = '', $date = '', $id = '', $on_hold = 0, $product_id = '') {
        
        $sql = "SELECT a.*, p.name as product_name, p.org_name,
        s.name as supplier_name, s.supplier_no
        FROM foolproof_audits a
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
    
    function get_audit_judgement($audit_id) {
        $sql = "SELECT COUNT(ac.id) as checkpoint_count, 
        SUM(IF(ac.result = 'OK', 1, 0)) as ok_count, 
        SUM(IF(ac.result = 'NG', 1, 0)) as ng_count, 
        SUM(IF(ac.result IS NULL, 1, 0)) as pending_count 
        FROM foolproof_audit_checkpoints ac 
        WHERE ac.audit_id = ?";
        
        return $this->db->query($sql, array($audit_id))->row_array();
    }
    
    function check_already_inspected($data) {
        $this->db->where('audit_date'   , $data['audit_date']);
        $this->db->where('product_id'   , $data['product_id']);
        $this->db->where('part_id'      , $data['part_id']);
        $this->db->where('supplier_id'  , $data['supplier_id']);
        $this->db->where('state !='     , 'aborted');
        
        return $this->db->count_all_results('foolproof_audits');
    }
    
    function update_audit($data, $audit_id) {
        $needed_array = array('audit_date', 'auditer_id', 'supplier_id', 'product_id', 'part_id', 'part_no', 'part_name', 'prod_lot_qty', 'state', 'on_hold', 'register_datetime');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($audit_id)) {
            $data['lot_no']     = '';
            //$data['lot_no']     = $this->generate_lot_no();
            $data['created']    = date("Y-m-d H:i:s");
            return (($this->db->insert('foolproof_audits', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $audit_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('foolproof_audits', $data)) ? $audit_id : False);
        }
        
    }
    
    function get_checkpoints_for_audit($product_id, $part_id, $supplier_id='') {
        $sql = "SELECT c.id, c.stage, c.sub_stage, c.major_control_parameters, c.measuring_equipment, 
            c.status, c.supplier_id, c.approved_by,
            if(c.lsl IS NULL, c.lsl, c.lsl) as lsl,
            if(c.usl IS NULL, c.usl, c.usl) as usl,
            if(c.tgt IS NULL, c.tgt, c.tgt) as tgt,
            if(c.unit IS NULL, c.unit, c.unit) as unit
            FROM foolproof_checkpoints c
            WHERE c.is_deleted = 0
            AND (c.status IS NOT NULL AND c.status = 'Approved' ) ";
            
        if(!empty($supplier_id)){
            $sql .= " AND c.supplier_id = ".$supplier_id." ";
        }
        $pass_array = array($product_id, $part_id);
        
        $sql .= " ORDER BY id, supplier_id ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function checkpoint_audited($product_id, $part_id, $checkpoint_id, $date) {
        $sql = "SELECT count(*) as count FROM foolproof_audits a 
        INNER JOIN foolproof_audit_checkpoints ac
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
    
    function change_state($audit_id, $auditer_id, $state) {
        $allowed_state = array('registered','aborted','started','finished','completed');
        if(!in_array($state, $allowed_state))
            return false;
        
        $this->db->where('id', $audit_id);
        $this->db->where('auditer_id', $auditer_id);
        $this->db->set('state', $state);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        $response = $this->db->update('foolproof_audits');
        return $response;
    }
    
    function hold_resume_audit($audit_id, $on_hold = 1) {
        $this->db->where('id', $audit_id);
        $this->db->set('on_hold', $on_hold);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        return $this->db->update('foolproof_audits');
    }
    
    function create_audit_checkpoints($product_id, $part_id, $audit_id, $case, $exclude = '') {
        $this->db->where('audit_id', $audit_id);
        $this->db->delete('foolproof_audit_checkpoints');
        
        $pass_array = array($product_id, $part_id);
        
        $sql = "INSERT INTO foolproof_audit_checkpoints(`org_checkpoint_id`, `audit_id`, `checkpoint_no`, `insp_item`, `insp_item2`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `checkpoint_type`, `sampling_qty`, `created`)
        SELECT c.id, ".$audit_id." as audit_id, c.checkpoint_no, 
        c.insp_item, c.insp_item2, c.spec,
        if(c.lsl IS NULL, c.lsl, c.lsl) as lsl,
        if(c.usl IS NULL, c.usl, c.usl) as usl,
        if(c.tgt IS NULL, c.tgt, c.tgt) as tgt,
        if(c.unit IS NULL, c.unit, c.unit) as unit, 
        c.checkpoint_type, c.sample_qty, ";
        
        //$sql .= $case.', ';
        
        $sql .= "'".date("Y-m-d H:i:s")."' as created
        FROM foolproof_checkpoints c 
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
    
    function insert_result($data) {
        $sql = "INSERT INTO foolproofs(`org_checkpoint_id`, `stage`, `sub_stage`, `major_control_parameters`, `lsl`, `usl`, `tgt`, `unit`, `supplier_id`, `measuring_equipment`, `cycle`, `image`, `all_values`, `all_results`, `result`, `created`)
        SELECT `id`, `stage`, `sub_stage`, `major_control_parameters`, `lsl`, `usl`, `tgt`, `unit`, `supplier_id`, `measuring_equipment`, `cycle`, '".$data["image"]."', '".$data["all_values"]."', '".$data["all_results"]."', '".$data["result"]."', '".date("Y-m-d H:i:s")."' as created
        FROM foolproof_checkpoints c
        WHERE c.id = ? and c.status = 'Approved' and c.is_deleted = 0";
        
        $pass_array = array($data['id']);
        
        $this->db->query($sql, $pass_array);
    }
    
    function get_checkpoint_count($date, $supplier_id = ''){
        $sql = "SELECT fc.supplier_id, s.name as supplier_name, 
                count(fc.id) as total,count(f.id) as completed
                FROM foolproofs f 
                RIGHT JOIN foolproof_checkpoints fc 
                ON (fc.id = f.org_checkpoint_id AND f.created like '".$date."%')
                LEFT JOIN suppliers s 
                ON s.id = fc.supplier_id 
                WHERE fc.status = 'Approved' and fc.is_deleted = 0 ";
        
        if($supplier_id){
            $sql .= " AND fc.supplier_id = ".$supplier_id." ";
        }
        
        $sql.= " GROUP BY fc.supplier_id";
        
        return $this->db->query($sql)->result_array();
    }
    
    /*Inspection Model Ends*/
    
    function get_foolproof_report($filters) {
        $pass_array = array();
        
        $sql = "SELECT s.name as supplier_name, fc.*, f.image, f.all_values, f.all_results, f.created, f.result
                FROM foolproofs f 
                RIGHT JOIN foolproof_checkpoints fc 
                ON (fc.id = f.org_checkpoint_id AND f.created like '".$filters['date']."%')
                LEFT JOIN suppliers s ON s.id = fc.supplier_id";
        
        $wheres = array();
        
        if(!empty($filters['supplier_id'])) {
            $wheres[] = " fc.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        $sql .= " ORDER BY fc.supplier_id";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_pending_checkpoints(){
        
        $sql = "SELECT c.*, s.supplier_no, s.name as supplier_name
                FROM foolproof_checkpoints c
                LEFT JOIN suppliers s ON s.id = c.supplier_id
                where (c.status = 'Pending' or c.status IS NULL )
                and c.is_deleted = 0";
        
        return $this->db->query($sql)->result_array();
    }
    
    function change_status($checkpoint_id, $status){
        
        $sql = "UPDATE foolproof_checkpoints SET status = ? WHERE id = ?";
        
        return $this->db->query($sql, array($status, $checkpoint_id));
    }
    
}