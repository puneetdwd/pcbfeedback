<?php
class Sampling_model extends CI_Model {
    
    function get_configs($checkpoint_id, $part_id, $supplier_id = '') {
        $sql = "SELECT i.*, p.name as part_name, p.code as part_code, c.insp_item as checkpoint_name, c.insp_item2
        FROM inspection_config i
        INNER JOIN checkpoints c ON i.checkpoint_id = c.id
        INNER JOIN product_parts p ON i.part_id = p.id";
        
        if(!empty($supplier_id)) {
            $sql .= " INNER JOIN sp_mappings sp 
            ON sp.part_id = i.part_id";
        }
        
        $sql .= " WHERE c.product_id = ?";
        
        $pass_array = array($this->product_id);
        
        if(!empty($inspection_id) && $inspection_id != 'All') {
            $sql .= ' AND i.checkpoint_id = ?';
            $pass_array[] = $checkpoint_id;
        }
        
        if(!empty($part_id) && $part_id != 'All') {
            $sql .= ' AND i.part_id = ?';
            $pass_array[] = $part_id;
        }
        
        if(!empty($supplier_id)) {
            $sql .= ' AND sp.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " ORDER BY c.insp_item, p.name";
        
        $configs = $this->db->query($sql, $pass_array)->result_array();
        
        foreach($configs as $key => $config) {
            if($config['sampling_type'] == 'User Defined') {
                $lots = $this->get_lot_range_samples($config['id']);
                
                $configs[$key]['lots'] = $lots;
            }
        }
        
        return $configs;
    }
    
    function check_config_by_checkpoint($product_id, $part_id, $chk_item, $checkpoint_id){
        $sql = "SELECT id FROM inspection_config 
                WHERE product_id = ?
                AND part_id = ?
                AND chk_item = ?
                AND checkpoint_id = ?";
        
        return $this->db->query($sql, array($product_id, $part_id, $chk_item,$checkpoint_id))->row_array();
    }
    
    function get_inspection_config_by_id($config_id, $product_id) {
        $this->db->where('id', $config_id);
        $this->db->where('product_id', $product_id);
        
        return $this->db->get('inspection_config')->row_array();
    }
    
    function insert_samplings($samplings, $product_id) {
        $this->db->insert_batch('inspection_config', $samplings);
        //$this->remove_dups_samplings($product_id);
        $this->update_checkpoint_id($product_id);
    }
    
    function remove_dups_samplings($product_id) {
        $sql = "DELETE FROM inspection_config 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM inspection_config 
                WHERE product_id = ? 
                GROUP BY product_id, part_id, chk_item
            ) as d
        ) AND product_id = ?";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
    
    function update_checkpoint_id($product_id) {
        $sql = "UPDATE `inspection_config` ic 
        INNER JOIN checkpoints c
        ON (
            ic.product_id = c.product_id
            AND ic.part_id = c.part_id
            AND ic.chk_item = c.insp_item2
        ) SET ic.checkpoint_id = c.id
        WHERE ic.product_id = ?";
        
        return $this->db->query($sql, array($product_id,));
    }
    
    function get_lot_template() {
        return $this->db->get('lot_template')->result_array();
    }
    
    function get_acceptance_qualities() {
        $sql = "SELECT DISTINCT acceptable_quality as quality FROM auto_code_acceptance_sample_mapping";
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_lot_range_samples($config_id) {
        $this->db->where('config_id', $config_id);
        
        return $this->db->get('inspection_lot_range')->result_array();
    }
    
    function get_lot_range_samples_c($config_id) {
        $this->db->where('config_id', $config_id);
        
        return $this->db->get('inspection_lot_range')->result_array();
    }
    
    function delete_config($config_id) {
        $this->db->where('id', $config_id);
        
        $this->db->delete('inspection_config');
        if($this->db->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    function get_inspection_config_type($checkpoint_id, $part_id) {
        $sql = "SELECT sampling_type 
        FROM inspection_config
        WHERE checkpoint_id = ? 
        AND part_id = ?
        GROUP BY checkpoint_id";
        
        $result = $this->db->query($sql, array($checkpoint_id, $part_id))->row_array();
        if(!empty($result)) {
            return $result['sampling_type'];
        }
        
        return '';
    }
    
    function update_inspection_config($data, $config_id){
        $needed_array = array('product_id', 'checkpoint_id', 'chk_item', 'part_id', 'sampling_type', 
            'inspection_level', 'acceptable_quality', 'sample_qty');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($config_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('inspection_config', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $config_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('inspection_config', $data)) ? $config_id : False);
        }
        
    }
    
    function delete_lot_range_samples($config_id) {
        $this->db->where('config_id', $config_id);
        
        return $this->db->delete('inspection_lot_range');
    }
    
    function insert_lot_range_samples($lots, $config_id) {
        $this->db->where('config_id', $config_id);
        $this->db->delete('inspection_lot_range');

        $this->db->insert_batch('inspection_lot_range', $lots);
    }
    
    function get_specific_config($product_id, $checkpoint_id, $part_id) {
        $sql = "SELECT c.*
        FROM inspection_config c
        WHERE c.product_id = ?";
        
        $pass_array = array($product_id);
        if(!empty($checkpoint_id)) {
            $sql .= " AND c.checkpoint_id = ?";
            $pass_array[] = $checkpoint_id;
        } else {
            $sql .= " AND c.checkpoint_id IS NULL";
        }
        
        if(!empty($part_id)) {
            $sql .= " AND c.part_id = ?";
            $pass_array[] = $part_id;
        } else {
            $sql .= " AND c.part_id IS NULL";
        }

        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_no_of_samples_auto($lot_size, $inspection_level, $acceptable_quality) {
        $sql = "
        SELECT no_of_samples FROM auto_code_acceptance_sample_mapping
        WHERE code = (
            SELECT code
            FROM `auto_lot_code_mapping` 
            WHERE lower_val = (
                SELECT max(lower_val) FROM `auto_lot_code_mapping` WHERE `lower_val` <= ?
            )
            AND inspection_level = ?
        ) AND acceptable_quality = ?";
        
        $result = $this->db->query($sql, array($lot_size, $inspection_level, $acceptable_quality));
        
        if($result->num_rows() > 0) {
            $result = $result->row_array();
            return $result['no_of_samples'];
        } else {
            return 0;
        }
    }
    
    function get_no_of_samples_c0($lot_size, $acceptable_quality) {
        $sql = "SELECT sample_qty
        FROM `c=0` 
        WHERE lower_val = (
            SELECT max(lower_val) FROM `c=0` WHERE `lower_val` <= ? AND aql = ?
        )
        AND aql = ?";
        
        $result = $this->db->query($sql, array($lot_size, $acceptable_quality, $acceptable_quality));

        if($result->num_rows() > 0) {
            $result = $result->row_array();
            return $result['sample_qty'];
        } else {
            return 0;
        }
    }
    
    function get_no_of_samples($config_id, $lot_size) {
        $sql = "SELECT no_of_samples
        FROM `inspection_lot_range` 
        WHERE lower_val = (
            SELECT max(lower_val) FROM `inspection_lot_range` WHERE `lower_val` <= ? AND config_id = ?
        )
        AND config_id = ?";
        
        $result = $this->db->query($sql, array($lot_size, $config_id, $config_id));

        if($result->num_rows() > 0) {
            $result = $result->row_array();
            return $result['no_of_samples'];
        } else {
            return 0;
        }
    }
    
    function get_config_id($checkpoint_id){
        $sql = "SELECT id from inspection_config WHERE checkpoint_id = ?";
        
        $result = $this->db->query($sql, array($checkpoint_id))->row_array();
        
        return $result['id'];
    }
}