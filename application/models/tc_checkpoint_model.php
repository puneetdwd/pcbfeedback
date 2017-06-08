<?php
class TC_Checkpoint_model extends CI_Model {

    function get_checkpoints($product_id, $supplier_id = '', $part_code = '', $child_part_no = '', $mold_no = '') {
        $sql = "SELECT c.id, c.product_id, c.child_part_no, c.child_part_name, c.mold_no, 
        c.checkpoint_no, c.insp_type, c.insp_item, c.spec, c.lsl, c.usl, c.tgt, c.unit, 
        c.status, c.instrument, c.stage, c.supplier_id, c.part_id, c.sample_qty, c.frequency, 
        c.measure_type, p.code as part_no, p.name as part_name,
        s.name as supplier_name
        FROM tc_checkpoints c
        INNER JOIN product_parts p
        ON c.part_id = p.id
        LEFT JOIN suppliers s
        ON c.supplier_id = s.id
        WHERE c.product_id = ?
        AND c.is_deleted = 0";
        
        $pass_array = array($product_id);
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        if(!empty($part_code)) {
            $sql .= ' AND p.code = ?';
            $pass_array[] = $part_code;
        }
        
        if(!empty($child_part_no)) {
            $sql .= ' AND c.child_part_no = ?';
            $pass_array[] = $child_part_no;
        }
        
        if(!empty($mold_no)) {
            $sql .= ' AND c.mold_no = ?';
            $pass_array[] = $mold_no;
        }
        
        $sql .= " ORDER BY checkpoint_no ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_checkpoint($id, $supplier_id = '') {
        $sql = "SELECT c.id, c.product_id, c.part_id, c.child_part_no, c.child_part_name, c.mold_no, 
        c.checkpoint_no, c.insp_type, c.insp_item, c.spec, c.lsl, c.usl, c.tgt, c.unit, c.status, 
        c.instrument, c.stage, c.supplier_id, c.part_id, c.sample_qty, c.frequency, c.measure_type,
        p.code as part_no, p.name as part_name
        FROM tc_checkpoints c
        INNER JOIN product_parts p
        ON c.part_id = p.id
        WHERE c.id = ?
        AND c.is_deleted = 0";
        
        $pass_array = array($id);
        if($this->product_id) {
            $sql .= ' AND c.product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        if(!empty($supplier_id)) {
            $sql .= ' AND c.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_distinct_insp_type(){
        $sql = "SELECT distinct insp_item as insp_item FROM tc_checkpoints";
        
        return $this->db->query($sql)->result_array();
    }
    
    function is_checkpoint_no_exists($product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no, $id = '') {
        $this->db->where('product_id', $product_id);
        $this->db->where('part_id', $part_id);
        $this->db->where('child_part_no', $child_part_no);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('checkpoint_no', $checkpoint_no);
        $this->db->where('is_deleted', 0);
        
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }
        
        return $this->db->count_all_results('tc_checkpoints');
    }
    
    function update_checkpoint($data, $checkpoint_id){
        $needed_array = array('product_id', 'part_id', 'child_part_no', 'child_part_name', 'checkpoint_no', 'mold_no', 'stage', 'insp_item', 'spec', 'lsl', 'usl', 
        'tgt', 'unit', 'supplier_id', 'sample_qty', 'frequency', 'measure_type', 'instrument', 'action_by', 'status', 'is_deleted');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        if(empty($checkpoint_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('tc_checkpoints', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $checkpoint_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('tc_checkpoints', $data)) ? $checkpoint_id : False);
        }
        
    }
    
    function delete_checkpoint($product_id, $checkpoint_id, $supplier_id = '') {
        $this->db->where('id', $checkpoint_id);
        $this->db->where('product_id', $product_id);
        
        if(!empty($supplier_id)) {
            $this->db->where('supplier_id', $supplier_id);
        }
        
        $this->db->set('is_deleted', 1);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        return $this->db->update('tc_checkpoints');
    }
    
    function move_checkpoints($product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no) {
        $sql = "UPDATE tc_checkpoints SET 
        checkpoint_no = checkpoint_no + 1 
        WHERE product_id = ? 
        AND part_id = ?
        AND supplier_id = ?
        AND child_part_no = ?
        AND checkpoint_no >= ? 
        AND checkpoint_no <= (
            SELECT * FROM (
                SELECT min(c1.checkpoint_no)
                FROM `tc_checkpoints` as c1
                LEFT JOIN `tc_checkpoints` as c2
                ON (
                    c1.checkpoint_no = c2.checkpoint_no-1
                    AND c1.`product_id` = c2.`product_id`
                    AND c1.`part_id` = c2.`part_id`
                    AND c1.`child_part_no` = c2.`child_part_no`
                    AND c1.`supplier_id` = c2.`supplier_id`
                )
                WHERE c1.product_id = ? 
                AND c1.part_id = ? 
                AND c1.child_part_no = ?
                AND c1.supplier_id = ? 
                AND c1.checkpoint_no >= ?
                AND c2.id IS NULL
            ) as sub
        )";

        $pass_array = array($product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no, $product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no);
        return $this->db->query($sql, $pass_array);
    }
    
    function move_checkpoints_down($product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no) {
        $sql = "UPDATE tc_checkpoints 
        SET checkpoint_no = checkpoint_no - 1
        WHERE product_id = ?
        AND part_id = ?
        AND child_part_no = ?
        AND supplier_id = ?
        AND checkpoint_no > ?";
        
        $pass_array = array($product_id, $part_id, $child_part_no, $supplier_id, $checkpoint_no);
        return $this->db->query($sql, $pass_array);
    }
    
    function check_duplicate_checkpoint($data) {
        $sql = "SELECT id FROM tc_checkpoints 
            WHERE product_id = ?
            AND part_id = ?
            AND child_part_no = ?
            AND stage = ?
            AND insp_item = ?";
        
        return $this->db->query($sql, array($data['product_id'], $data['part_id'], $data['child_part_no'], $data['stage'], $data['insp_item']))->row_array();
    }
    
    function insert_checkpoints($checkpoints, $product_id, $supplier_id) {
        $this->db->insert_batch('tc_checkpoints', $checkpoints);
        
        //$this->remove_dups_checkpoints($product_id, $supplier_id);
        
        //$this->db->query('CALL UpdateTCNO('.$product_id.', '.$supplier_id.')');
    }
    
    function remove_dups_checkpoints($product_id, $supplier_id) {
        $sql = "DELETE FROM tc_checkpoints 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM tc_checkpoints 
                WHERE product_id = ? 
                AND supplier_id = ?
                GROUP BY product_id, part_id, insp_type, insp_item
            ) as d
        ) AND product_id = ? 
        AND supplier_id = ?";
        
        return $this->db->query($sql, array($product_id, $supplier_id, $product_id, $supplier_id));
    }
    
    function update_plan($data, $plan_id){
        $needed_array = array('product_id', 'supplier_id', 'part_id', 'child_part_no', 'mold_no', 'plan_date', 'from_time', 'to_time');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($plan_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('timecheck_plans', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $plan_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('timecheck_plans', $data)) ? $plan_id : False);
        }
        
    }
    
    function update_plan_freq($plan_id, $total_frequencies) {
        $this->db->where('id', $plan_id);
        $this->db->set('total_frequencies', $total_frequencies);
        
        return $this->db->update('timecheck_plans');
    }
    
    function get_all_plans($product_id, $supplier_id, $plan_date = '') {
        $sql = "SELECT pl.*, 
        p.code as part_no, p.name as part_name
        FROM timecheck_plans pl
        INNER JOIN product_parts p
        ON pl.part_id = p.id
        WHERE pl.product_id = ?
        AND pl.supplier_id = ?";
        
        $pass_array = array($product_id, $supplier_id);
        if(!empty($plan_date)) {
            $sql .= ' AND pl.plan_date = ?';
            $pass_array[] = $plan_date;
        }

        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_plan($plan_id, $supplier_id = '') {
        $sql = "SELECT pl.*, 
        p.code as part_no, p.name as part_name, s.name as supplier_name
        FROM timecheck_plans pl
        INNER JOIN product_parts p
        ON pl.part_id = p.id
        INNER JOIN suppliers s ON s.id = pl.supplier_id
        WHERE pl.id = ?";
        
        $pass_array = array($plan_id);
        if(!empty($supplier_id)) {
            $sql .= ' AND pl.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " ";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_all_child_parts_by_supplier($product_id, $supplier_id){
        
        $sql = "SELECT DISTINCT child_part_no as child_part_no
               FROM tc_checkpoints
               WHERE product_id = ?
               AND supplier_id = ?";
        
        return $this->db->query($sql, array($product_id, $supplier_id))->result_array();
    }
    
    function get_all_mold_nos_by_supplier($product_id, $supplier_id){
        
        $sql = "SELECT DISTINCT mold_no as mold_no
               FROM tc_checkpoints
               WHERE product_id = ?
               AND supplier_id = ?";
        
        return $this->db->query($sql, array($product_id, $supplier_id))->result_array();
    }
    
    function delete_plan($plan_id) {
        if(!empty($plan_id)) {
            $this->db->where('id', $plan_id);
        
            $this->db->delete('timecheck_plans');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
    
    function change_plan_status($plan_id, $status) {
        if(!empty($plan_id) && !empty($status)) {
            $this->db->where('id', $plan_id);
            $this->db->set('plan_status', $status);
        
            return $this->db->update('timecheck_plans');
        }

        return FALSE;
    }
    
    function get_checkpoints_for_audit($product_id, $part_id, $supplier_id='') {
        $sql = "SELECT c.id, c.product_id, c.checkpoint_no, c.insp_item, c.insp_item2, 
            c.insp_item3, c.spec, c.has_multiple_specs, c.checkpoint_type, c.period, c.cycle,
            if(c.lsl IS NULL, c.lsl, c.lsl) as lsl,
            if(c.usl IS NULL, c.usl, c.usl) as usl,
            if(c.tgt IS NULL, c.tgt, c.tgt) as tgt,
            if(c.unit IS NULL, c.unit, c.unit) as unit
            FROM checkpoints c
            WHERE c.product_id = ?
            AND c.part_id = ?
            AND c.is_deleted = 0
            AND (c.checkpoint_type = 'LG' OR (c.status IS NOT NULL AND c.status = 'Approved' )) ";
            
        if(!empty($supplier_id)){
            $sql .= " AND c.supplier_id = ".$supplier_id." ";
        }
        $pass_array = array($product_id, $part_id);
        
        $sql .= " ORDER BY checkpoint_type DESC, checkpoint_no ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    
    
    function get_all_checkpoint() {
        $sql = "SELECT * FROM checkpoints where is_deleted = 0 ";
        
        $pass_array = array();
        if($this->product_id) {
            $sql .= ' and product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        //echo $sql; exit;
        
        return $this->db->query($sql, $pass_array)->result_array();
    }

    

    
    
    
    
    function get_checkpoint_images($checkpoint_id){
        $sql = "SELECT images from checkpoints where id = ?";
        
        return $this->db->query($sql, array($checkpoint_id))->row_array();
    }
    

    
    
    
    
    
    function delete_checkpoint_by_part($product_id, $part_id) {
        $this->db->where('product_id', $product_id);
        $this->db->where('part_id', $part_id);
        
        $this->db->delete('checkpoints');

        if($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }
    
    
    
    function get_history($product_id, $revision_date = '') {
        $sql = "SELECT h.*
        FROM checkpoint_history h
        WHERE h.product_id = ? ";
        
        $pass_array = array($product_id);
        if($revision_date) {
            $sql .= " AND DATE_FORMAT(changed_on, '%Y-%m-%d') = ? ";
            $pass_array[] = $revision_date;
        }
        $sql .= " ORDER BY version ASC, `Type` ASC";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function add_history($data) {
        $needed_array = array('version', 'type', 'product_id', 'part_id', 'checkpoint_no', 'insp_item', 'insp_item2', 'spec', 'lsl', 'usl', 'tgt', 'unit', 'supplier_id', 'checkpoint_type', 'approved_by', 'change_type', 'changed_on', 'remark');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        $data['created'] = date("Y-m-d H:i:s");
        return (($this->db->insert('checkpoint_history', $data)) ? $this->db->insert_id() : False);
    }
    
    function get_revision_version($product_id) {
        $sql = "SELECT MAX(version) as version
        FROM checkpoint_history h
        WHERE h.product_id = ?";
        
        $version = $this->db->query($sql, array($product_id))->row_array();
        return $version['version'];
    }

    function get_all_excluded_checkpoints() {
        $sql = "SELECT ex.`id`, ex.`part_id`, ex.`checkpoints_ids`, 
        GROUP_CONCAT(c.`checkpoint_no` ORDER BY c.`checkpoint_no`) as checkpoints_nos,
        p.name as part_name, p.product_id, p.code as part_code
        FROM `excluded_checkpoints` ex 
        INNER JOIN `product_parts` p
        ON ex.part_id = p.id
        LEFT JOIN checkpoints c
        ON (
            FIND_IN_SET(c.id, ex.`checkpoints_ids`)
            AND c.is_deleted = 0
        )
        WHERE ex.is_deleted = 0
        AND p.is_deleted = 0";
        
        $pass_array = array();
        if($this->product_id) {
            $sql .= ' AND p.product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        $sql .= " GROUP BY ex.id";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_excluded_checkpoint($id) {
        $sql = "SELECT ex.`id`, ex.`part_id`, ex.`checkpoints_ids`, 
        p.name as part_name, p.product_id, p.code as part_code
        FROM `excluded_checkpoints` ex 
        INNER JOIN `product_parts` p
        ON ex.part_id = p.id
        WHERE ex.id = ?
        AND ex.is_deleted = 0";
        
        $pass_array = array($id);
        if($this->product_id) {
            $sql .= ' AND p.product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function excluded_checkpoint_exists($part_id, $id) {
        $this->db->where('part_id', $part_id);
        $this->db->where('is_deleted', 0);
        
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }
        
        return $this->db->get('excluded_checkpoints')->row_array();
    }
    
    function update_excluded_checkpoints($data, $excluded_id) {
        $needed_array = array('part_id', 'checkpoints_ids');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($excluded_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('excluded_checkpoints', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $excluded_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('excluded_checkpoints', $data)) ? $excluded_id : False);
        }
    }
    
    function delete_exclude_checkpoint($id) {
        $this->db->where('id', $id);
        $this->db->set('is_deleted', 1);
        $this->db->set('modified', date("Y-m-d H:i:s"));
        
        return $this->db->update('excluded_checkpoints');
    }

    function get_excluded_checkpoint_by_part($part_id) {
        $sql = "SELECT ex.`id`, ex.`part_id`, ex.`checkpoints_ids`, 
        GROUP_CONCAT(c.`checkpoint_no` ORDER BY c.`checkpoint_no`) as checkpoints_nos
        FROM `excluded_checkpoints` ex 
        INNER JOIN checkpoints c
        ON (
            FIND_IN_SET(c.id, ex.`checkpoints_ids`)
            AND c.part_id = ex.part_id
            AND c.is_deleted = 0
        )
        WHERE ex.is_deleted = 0
        AND ex.part_id = ?
        GROUP BY ex.id";
        
        return $this->db->query($sql, array($part_id))->row_array();
    }
    
    
    
    function get_supplier_checkpoints_by_product($product_id){
        
        $sql = "SELECT c.id, c.insp_item, c.insp_item2, c.spec, c.lsl, c.usl, c.tgt, c.unit, c.status,
                p.name as product_name, pp.code as part_number, pp.name as part_name,
                s.supplier_no, s.name as supplier_name
                FROM tc_checkpoints c
                LEFT JOIN products p ON p.id = c.product_id
                LEFT JOIN product_parts pp ON pp.id = c.part_id
                LEFT JOIN suppliers s ON s.id = c.supplier_id
                where c.product_id = ? and c.checkpoint_type = 'Supplier' ";
        
        return $this->db->query($sql, array($product_id))->result_array();
    }
    
    function get_pending_checkpoints_by_product($product_id){
        
        $sql = "SELECT c.*, p.name as product_name, pp.code as part_number, 
                pp.name as part_name, s.supplier_no, s.name as supplier_name
                FROM tc_checkpoints c
                LEFT JOIN products p ON p.id = c.product_id
                LEFT JOIN product_parts pp ON pp.id = c.part_id
                LEFT JOIN suppliers s ON s.id = c.supplier_id
                where c.product_id = ? and (c.status = 'Pending' or c.status IS NULL )
                and c.is_deleted = 0";
        
        return $this->db->query($sql, array($product_id))->result_array();
    }
    
    function change_status($checkpoint_id, $status){
        
        $sql = "UPDATE tc_checkpoints SET status = ? WHERE id = ?";
        
        return $this->db->query($sql, array($status, $checkpoint_id));
    }
    
    function get_child_parts_by_part_id($part_id, $supplier_id, $product_id){
        $sql = "SELECT DISTINCT child_part_no as child_part_no
               FROM tc_checkpoints
               WHERE product_id = ?
               AND part_id = ?
               AND supplier_id = ?";
        
        return $this->db->query($sql, array($product_id, $part_id, $supplier_id))->result_array();
    }
    
    function get_mold_no_by_child_part_no($part_id, $child_part_no, $supplier_id, $product_id){
        $sql = "SELECT DISTINCT mold_no as mold_no
               FROM tc_checkpoints
               WHERE product_id = ?
               AND part_id = ?
               AND child_part_no = ?
               AND supplier_id = ?";
        
        return $this->db->query($sql, array($product_id, $part_id, $child_part_no, $supplier_id))->result_array();
    }
    
}