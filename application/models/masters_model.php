<?php
class Masters_model extends CI_Model {

    function __construct() {
        parent::__construct();

        require_once APPPATH .'libraries/pass_compat/password.php';
    }
	
	
	function get_all_type($type){
		//echo $type;die('ff');	
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		
		$query = $this->db->get();
		
		//print_r($result);
		//echo $this->db->last_query();
		//die('cxv');
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}
	
	function update_type($post_data, $id,$type){

		$data=array('name'=>$post_data['name']);
        if(empty($id)) {
			$this->db->select("*");
		    $this->db->from("master_".$type);
			$this->db->order_by('id', 'DESC');
             $this->db->limit('1');
			$query = $this->db->get();
			if($query->num_rows() > 0){
			$result = $query->result_array();
		    }
			
			$data['id'] = $result[0]['id']+1;
            $data['created'] = date("Y-m-d H:i:s");
			return $InsertData = $this->db->insert('master_'.$type, $data);
			//echo $this->db->last_query();die('ii');
			//print_r($data);die;
            
        } else {
            $this->db->where('id', $id);
           // $data['modified'] = date("Y-m-d H:i:s");
			return (($this->db->update('master_'.$type, $data)) ? $id : False);
            
        }	
	}
	
	function get_type_by_id($type,$id){
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		$this->db->where("id",$id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
        
        
    
	}
	
	function delete_type_by_id($type,$id){
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		$this->db->where("id",$id);
		$query = $this->db->get();	
		if($query->num_rows() > 0){
			$this->db->where('id', $id);
			//$this->db->delete('master_'.$type);
			//echo $this->db->last_query();die();
			return (($this->db->delete('master_'.$type, $data)) ? TRUE : False);
		}
		return $result;
	}
	
	function get_all_data($type){
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		$query = $this->db->get();	
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		//echo $this->db->last_query();die;
		return $result;	
	}
	function get_all_repair_data($type){
		$result=array();
		$this->db->select("*");
		$this->db->from("damaged_pcb_detail");
		$query = $this->db->get();	
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		//echo $this->db->last_query();die;
		return $result;	
	}
	
		function insertLGRepairData($postData) {
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
			"vendor"=>array_key_exists('Vendor', $dataArray)?$dataArray['Vendor']:'',
			"part"=>array_key_exists('Part', $dataArray)?$dataArray['Part']:'',
			"defect"=>array_key_exists('Defect', $dataArray)?$dataArray['Defect']:'',
			"category"=>array_key_exists('Category', $dataArray)?$dataArray['Category']:'',
			"repair_user_cause_dept"=>array_key_exists('Cause Dept', $dataArray)?$dataArray['Cause Dept']:'',
			"status"=>array_key_exists('Status', $dataArray)?$dataArray['Status']:'',
			//"user_cause"=>array_key_exists('Cause', $dataArray)?$dataArray['Cause']:'',
			//"operator_name"=>array_key_exists('Operator Name', $dataArray)?$dataArray['Operator Name']:'',
			//"action"=>array_key_exists('Action', $dataArray)?$dataArray['Action']:'',
			//"user_id"=>$this->session->userdata('id'),
			//"user_type"=>$this->session->userdata('user_type'));
			//"user_type"=>"LG USER"
			);
		
		//print_r($insertData);die();
		//$this->db->where('user_id',$this->session->userdata('id'));
		//$this->db->where('user_type',"LG USER");
		$this->db->where('id',$dataArray['ID']);
		$this->db->update('Damaged_pcb_detail',$insertData);
	//	echo $this->db->last_query();die;
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
?>