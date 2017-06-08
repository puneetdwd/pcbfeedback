<?php
class Product_model extends CI_Model {

    function add_product($data, $product_id){
        $needed_array = array('org_id', 'org_name', 'code', 'name');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($product_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('products', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $product_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('products', $data)) ? $product_id : False);
        }
        
    }
        
    function get_all_products() {
        $sql = 'SELECT * FROM products';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_all_phone_numbers($supplier_id) {
        $this->db->where('supplier_id', $supplier_id);
        $this->db->order_by('name');
        
        return $this->db->get('phone_numbers')->result_array();
    }
    
    function get_product($id) {
        $this->db->where('id', $id);

        return $this->db->get('products')->row_array();
    }
    
    function get_product_id_by_name($code) {
        $this->db->where('code', $code);

        return $this->db->get('products')->row_array();
    }
    
    function get_part_id_by_name($code, $product_id) {
        
        $this->db->where('product_id', $product_id);
        $this->db->where('code', $code);
        return $this->db->get('product_parts')->row_array();
    }

    function get_all_product_parts($product_id) {
        $sql = "SELECT pp.*, pp.code as part_no
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.product_id = ?
        ORDER BY pp.name";
        
        return $this->db->query($sql, array($product_id))->result_array();
    }
    
    function get_all_product_parts_by_supplier($product_id, $supplier_id) {
        $sql = "SELECT pp.*, pp.code as part_no
            FROM product_parts pp
            INNER JOIN sp_mappings sp 
            ON sp.part_id = pp.id
            WHERE pp.is_deleted = 0
            AND pp.product_id = ?
            AND sp.supplier_id = ?
            GROUP BY pp.code
            ORDER BY pp.name";
        
        return $this->db->query($sql, array($product_id, $supplier_id))->result_array();
    }
    
    function get_all_distinct_product_parts($product_id) {
        $sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.product_id = ?
        GROUP BY pp.name
        ORDER BY pp.name";
        
        return $this->db->query($sql, array($product_id))->result_array();
    }
    
    function get_all_part_numbers_by_part_name($part_name) {
        $sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.name = ?
        ORDER BY pp.code";
        
        return $this->db->query($sql, array($part_name))->result_array();
    }
    
    function get_all_parts() {
       $sql = "SELECT pp.*, p.name as product_name, 
       p.code as product_code
       FROM product_parts as pp
       INNER JOIN products as p
       ON pp.product_id = p.id";
       
       return $this->db->query($sql)->result_array();
    }
    
    function get_all_distinct_part_name($product_id='', $supplier_id='') {
        $sql = "SELECT pp.*
        FROM product_parts as pp";
       
        if(!empty($supplier_id)) {
            $sql .= " INNER JOIN sp_mappings sp 
            ON sp.part_id = pp.id";
        }
        
        $sql .= " WHERE pp.is_deleted = 0
        AND pp.product_id = ?";
        
        $pass_array = array($product_id);
        if(!empty($supplier_id)) {
            $sql .= ' AND sp.supplier_id = ?';
            $pass_array[] = $supplier_id;
        }
        
        $sql .= " GROUP BY pp.name";
       
       return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_product_part_by_code($product_id, $code) {
        $this->db->where('code', $code);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->row_array();
    }
    
    function get_product_part($product_id, $id) {
        $sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.product_id = ?
        AND pp.id = ?";
        
        return $this->db->query($sql, array($product_id, $id))->row_array();
    }
    
    function update_product_part($data, $part_id){
        $needed_array = array('code', 'name', 'product_id', 'is_deleted');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($part_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('product_parts', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $part_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('product_parts', $data)) ? $part_id : False);
        }
    }

    function insert_parts($parts, $product_id) {
        $this->db->insert_batch('product_parts', $parts);
        
        $this->remove_dups_parts($product_id);
    }
    
    function remove_dups_parts($product_id) {
        $sql = "DELETE FROM product_parts 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM product_parts 
                WHERE product_id = ? 
                GROUP BY product_id, code, name
            ) as d
        ) AND product_id = ?";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
}