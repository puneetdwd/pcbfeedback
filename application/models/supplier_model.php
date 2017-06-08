<?php
class Supplier_model extends CI_Model {

    function __construct() {
        parent::__construct();

        require_once APPPATH .'libraries/pass_compat/password.php';
    }
    
    function add_supplier($data, $supplier_id){
        $needed_array = array('name', 'supplier_no', 'email', 'password', 'is_active','type-supplier','suffixVal');
		
        $data = array_intersect_key($data, array_flip($needed_array));
        if(!empty($data['name'])) {
            $data['name'] = ucwords(strtolower($data['name']));
        }
        
        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }
        
        if(empty($supplier_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('suppliers', $data)) ? $this->db->insert_id() : False);
        } else {
            //echo $supplier_id; exit;
            $this->db->where('id', $supplier_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('suppliers', $data)) ? $supplier_id : False);
        }
        
    }
        
    function get_all_suppliers(){
        $sql = "SELECT s.* FROM suppliers s
                INNER JOIN sp_mappings sp ON sp.supplier_id = s.id AND sp.product_id = ".$this->product_id."
                INNER JOIN product_parts pp ON pp.id = sp.supplier_id
                WHERE s.is_active = 1
                GROUP BY sp.supplier_id";
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_supplier($id) {
        $this->db->where('id', $id);

        return $this->db->get('suppliers')->row_array();
    }
    
    function get_inspector($id) {
        $this->db->where('id', $id);

        return $this->db->get('supplier_inspector')->row_array();
    }

    function get_supplier_by_name($name) {
        $this->db->where('name', $name);
        
        return $this->db->get('suppliers')->row_array();
    }

    function get_supplier_by_code($code) {
        $this->db->where('supplier_no', $code);
        
        return $this->db->get('suppliers')->row_array();
    }
    
    function get_all_inspectors() {
        $sql = "SELECT * FROM supplier_inspector";
        
        $pass_array = array();
        if($this->id) {
            $sql .= ' WHERE supplier_id = ?';
            $pass_array = array($this->id);
        }
        
        $users = $this->db->query($sql, $pass_array);
        return $users->result_array();
    }
    
    function is_supplier_inspector_exists($email, $id = '') {
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }

        $this->db->where('email', $email);

        return $this->db->count_all_results('supplier_inspector');
    }
    
    function update_supplier_inspector($data, $id = '') {
            
        $needed_array = array('supplier_id', 'name', 'password', 'email', 'is_active');
        
        $data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('supplier_inspector', $data)) ? $this->db->insert_id() : False);
            
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");
            return (($this->db->update('supplier_inspector', $data)) ? $id : False);
        }
    }
    
    function get_all_sp_mappings($filters) {
        $sql = "SELECT sp.*, s.name as supplier_name, s.supplier_no,
        pp.name as part_name, pp.code as part_code, p.name as product_name
        FROM sp_mappings sp
        INNER JOIN suppliers s
        ON sp.supplier_id = s.id
        INNER JOIN product_parts pp
        ON sp.part_id = pp.id
        INNER JOIN products p
        ON pp.product_id = p.id";
        
        $wheres = array();
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $wheres[] = 'sp.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }else{
            $wheres[] = 'sp.product_id = ?';
            $pass_array[] = $this->product_id;
        }
        
        if(!empty($filters['part_name'])) {
            $wheres[] = 'pp.name like ?';
            $pass_array[] = $filters['part_name'];
        }
        
        if(!empty($filters['part_id'])) {
            $wheres[] = 'sp.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $wheres[] = 'sp.supplier_id = ?';
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }

    function get_sp_mapping($sp_mapping) {
        $sql = "SELECT sp.*, s.name as supplier_name, s.supplier_no,
        pp.name as part_name
        FROM sp_mappings sp
        INNER JOIN suppliers s
        ON sp.supplier_id = s.id
        INNER JOIN product_parts pp
        ON sp.part_id = pp.id
        WHERE sp.id = ?";
        
        return $this->db->query($sql, array($sp_mapping))->result_array();
    }
    
    function add_sp_mapping($data, $sp_mapping_id){
        $needed_array = array('supplier_id', 'part_id');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($sp_mapping_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('sp_mappings', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $sp_mapping_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('sp_mappings', $data)) ? $sp_mapping_id : False);
        }
        
    }
    
    function change_status($supplier_id, $status) {
        if(!empty($supplier_id) && !empty($status)) {
            $supplier_active = ($status == 'active') ? 1 : 0;
            
            $this->db->where('id', $supplier_id);
            $this->db->set('is_active', $supplier_active);
            $this->db->update('suppliers');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
    
    function change_inspector_status($inspector_id, $status) {
        if(!empty($inspector_id) && !empty($status)) {
            $active = ($status == 'active') ? 1 : 0;
            
            $this->db->where('id', $inspector_id);
            $this->db->set('is_active', $active);
            $this->db->update('supplier_inspector');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
    
    function insert_suppliers($suppliers) {
        $this->db->insert_batch('suppliers', $suppliers);
        
        $this->remove_dups_suppliers();
    }
    
    function remove_dups_suppliers() {
        $sql = "DELETE FROM suppliers 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM suppliers 
                GROUP BY supplier_no, name
            ) as d
        )";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
    
    function insert_sp_mappings($data) {
        $this->db->insert_batch('sp_mappings', $data);
    }
    
    function remove_dups() {
        $sql = "DELETE FROM sp_mappings WHERE id NOT IN (
            SELECT * FROM (
                SELECT min(id) FROM sp_mappings GROUP BY supplier_id, part_id
            ) as sub
        )";

        return $this->db->query($sql);
    }

    function get_supplier_products($supplier_id) {
        $sql = "SELECT DISTINCT p.id, p.name, p.org_id 
        FROM `sp_mappings` sp 
        INNER JOIN products p 
        ON sp.product_id = p.id 
        WHERE sp.supplier_id = ?";
        
        return $this->db->query($sql, array($supplier_id))->result_array();
    }

function get_all_user_data_total(){
		
		$sql = "SELECT * FROM  `Damaged_pcb_detail` ";
      // echo $sql;die();
        return $this->db->query($sql)->result_array();
	}


    function get_all_supplier_data_prefix($id=NULL){
	$sql = "SELECT suffixVal FROM `suppliers` WHERE id=".$id;

        return $this->db->query($sql)->row_array();
    }
    function get_all_supplier_data($val=NULL){
		//print_r($this->session->userdata);die('');
		$all_Data=array();
		$i=0;
		$uid=$this->session->userdata('id');
		$uType=$this->session->userdata('user_type');
		$this->db->select("*");
		$this->db->from('Damaged_pcb_detail');
		$this->db->where("repair_user_cause_dept !=''");
		//$this->db->where('vendor', $this->session->userdata('name'));
		$this->db->where('pcbg_main LIKE  "'.$val.'%"');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			foreach($result as $val){ 
					//$all_Data[$i]=$val;
					$this->db->select("*");
					$this->db->from('supplier_data');
					$this->db->where('supplier_id', $this->session->userdata('id'));
					$this->db->where('lg_serial_no', $val['set_sn']);
					$query1 = $this->db->get();
					//echo $this->db->last_query();
					//echo $query1->num_rows();
					if($query1->num_rows() > 0){
						$result1 = $query1->result_array();
						$arrData=array_merge($val,$result1[0]);
						//print_r($all_data);
					}
					else{
						$arrData=$val;
					}
					
					$all_data[]=$arrData;
					$i++;
					//echo $this->db->last_query();
			}
			//die('jm');
			//print_r($arrData);
			//echo "jsdjdvbjxvjxcnvxjvjxmcvbjmxcvjmkxbvbxcmkvbkxj";
			//print_r($all_data);
		}
		//$sql = "SELECT *
      //  FROM `Damaged_pcb_detail`";
       // echo $sql;die();
	  // $x=$this->db->query($sql)->result_array();
		//print_r($all_data);
		//die('o');
		return $all_data;
//        return $this->db->query($sql)->result_array();
	}
}