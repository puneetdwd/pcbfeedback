<?php
class Checklist_model extends CI_Model {

    function get_all_checklists($product_id) {
        $this->db->where('product_id', $product_id);
        $this->db->order_by('item_no');
        
        return $this->db->get('checklists')->result_array();
    }
    
    function get_checklist($product_id, $id) {
        $this->db->where('id', $id);
        $this->db->where('product_id', $product_id);
        
        return $this->db->get('checklists')->row_array();
    }
    
    function update_checklist($data, $checklist_id){
        $needed_array = array('list_item', 'item_no', 'product_id');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($checklist_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('checklists', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $checklist_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('checklists', $data)) ? $checklist_id : False);
        }
    }
    
    function delete_checklist($product_id, $checklist_id) {
        if(!empty($product_id) && !empty($checklist_id)) {
            $this->db->where('id', $checklist_id);
            $this->db->where('product_id', $product_id);
        
            $this->db->delete('checklists');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
}