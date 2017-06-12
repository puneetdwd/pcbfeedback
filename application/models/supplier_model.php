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
	
	function get_all_lg_user_data(){
		//$uid=$this->session->userdata('id');
		//$uType=$this->session->userdata('user_type');
		//$uType='LG USER';
		
		/*$sql = "SELECT *
        FROM `Damaged_pcb_detail` 
        WHERE user_id = '".$uid."' AND user_type = '".$uType."'";
		$sql = "SELECT *
        FROM `Damaged_pcb_detail` where repair_user_cause_dept != Vendor";*/
		
		$sql = "SELECT * FROM  `Damaged_pcb_detail` WHERE  `repair_user_cause_dept` !=  'Vendor' AND `repair_user_cause_dept` !=  ' '";
      // echo $sql;die();
        return $this->db->query($sql)->result_array();
	}
	
		function insertLGUserData($postData) {
		$dataToInsert=$postData['updatingClient'];
		$dataArray=json_decode($dataToInsert, true);
		//print_r($dataArray['Organization Name']);
		//print_r($dataArray);die();
		$insertData=array(
			//"organization"=>array_key_exists('Organization Name', $dataArray)?$dataArray['Organization Name']:'',
			//"production_line"=>array_key_exists('Production Line', $dataArray)?$dataArray['Production Line']:'',
			//"set_sn"=>array_key_exists('Set S/N', $dataArray)?$dataArray['Set S/N']:'',
			//"defect_date"=>array_key_exists('Defect Date', $dataArray)?$dataArray['Defect Date']:'',
			//"part_no"=>array_key_exists('Part No', $dataArray)?$dataArray['Part No']:'',
		//	"defect_qty"=>array_key_exists('Defect Quantity', $dataArray)?$dataArray['Defect Quantity']:'',
		//	"pcbg_main"=>array_key_exists('PCBG Main', $dataArray)?$dataArray['PCBG Main']:'',
			//"symptom_level_3"=>array_key_exists('Symptom Level 3', $dataArray)?$dataArray['Symptom Level 3']:'',
			//"cause_level_1"=>array_key_exists('Cause Level 1', $dataArray)?$dataArray['Cause Level 1']:'',
		//	"cause_level_2"=>array_key_exists('Cause Level 2', $dataArray)?$dataArray['Cause Level 2']:'',
		//	"cause_level_3"=>array_key_exists('Cause Level 3', $dataArray)?$dataArray['Cause Level 3']:'',
			//"repair_contents"=>array_key_exists('Repair Contents', $dataArray)?$dataArray['Repair Contents']:'',
			//"user_cause"=>array_key_exists('Cause', $dataArray)?$dataArray['Cause']:'',
			//"defect"=>array_key_exists('Defect', $dataArray)?$dataArray['Defect']:'',
			//"category"=>array_key_exists('Category', $dataArray)?$dataArray['Category']:'',
			//"repair_user_cause_dept"=>array_key_exists('Cause Dept', $dataArray)?$dataArray['Cause Dept']:'',
			//"status"=>array_key_exists('Status', $dataArray)?$dataArray['Status']:'',
			//"defect"=>array_key_exists('Defect', $dataArray)?$dataArray['Defect']:'',
			"user_cause"=>array_key_exists('Cause', $dataArray)?$dataArray['Cause']:'',
			"operator_name"=>array_key_exists('Operator Name', $dataArray)?$dataArray['Operator Name']:'',
			"action"=>array_key_exists('Action', $dataArray)?$dataArray['Action']:'',
			
			//"user_id"=>$this->session->userdata('id'),
			//"user_type"=>$this->session->userdata('user_type'));
			//"user_type"=>"LG USER"
			);
		
		//print_r($insertData);die();
		//$this->db->where('user_id',$this->session->userdata('id'));
		//$this->db->where('user_type',"LG USER");
		$this->db->where('id',$dataArray['ID']);
		$this->db->update('Damaged_pcb_detail',$insertData);
		echo $this->db->last_query();die;
		//return (($this->db->insert('Damaged_pcb_detail', $insertData)) ? $this->db->insert_id() : False);
		//echo $this->db->last_query();die();
        /*$sql = "SELECT DISTINCT p.id, p.name, p.org_id 
        FROM `sp_mappings` sp 
        INNER JOIN products p 
        ON sp.product_id = p.id 
        WHERE sp.supplier_id = ?";
        
        return $this->db->query($sql, array($supplier_id))->result_array();*/
    }
	
}