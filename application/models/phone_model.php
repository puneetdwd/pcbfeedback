<?php
class Phone_model extends CI_Model {

    function update_phone_number($data, $phone_number_id){
        $needed_array = array('supplier_id', 'name', 'phone_number');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($phone_number_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('phone_numbers', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $phone_number_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('phone_numbers', $data)) ? $phone_number_id : False);
        }
        
    }
        
    function get_all_phone_numbers($supplier_id = '') {
        $sql = 'SELECT pn.*, s.supplier_no, s.name as supplier_name 
        FROM phone_numbers as pn
        INNER JOIN suppliers s
        ON pn.supplier_id = s.id';
        
        $pass_array = array();
        if($supplier_id) {
            $sql .= ' WHERE pn.supplier_id = ?';
            $pass_array = array($supplier_id);
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_phone_number($id, $supplier_id = '') {
        $this->db->where('id', $id);
        
        if($supplier_id) {
            $this->db->where('supplier_id', $supplier_id);
        }
        
        return $this->db->get('phone_numbers')->row_array();
    }
    
    function delete_phone_number($id, $supplier_id = '') {
        if(!empty($id)) {
            $this->db->where('id', $id);
            
            if($supplier_id) {
                $this->db->where('supplier_id', $supplier_id);
            }
        
            $this->db->delete('phone_numbers');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
}