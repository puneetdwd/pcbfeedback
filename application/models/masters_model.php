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

		$data=array($type.'_name'=>$post_data['name']);
		//print_r($data);die();
        if(empty($id)) {
            //$data['created'] = date("Y-m-d H:i:s");
			//print_r($data);die();  
			//$this->db->insert('master_'.$type, $data);
			//echo $this->db->last_query();die('ii');
            return (($this->db->insert('master_'.$type, $data)) ? $this->db->insert_id() : False); 
			
            
        } else {
            $this->db->where($type.'_id', $id);
            //$data['modified'] = date("Y-m-d H:i:s");
            
			//$this->db->update('master_'.$type, $data);
			//echo $this->db->last_query();die('uu');
			return (($this->db->update('master_'.$type, $data)) ? $id : False);
            
        }	
	}
	
	function get_type_by_id($type,$id){
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		$this->db->where($type."_id",$id);
		$query = $this->db->get();
		
		//print_r($result);
		//echo $this->db->last_query();
		//die('cxv');
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
        
        
    
	}
	
	function delete_type_by_id($type,$id){
		$result=array();
		$this->db->select("*");
		$this->db->from("master_".$type);
		$this->db->where($type."_id",$id);
		$query = $this->db->get();	
		if($query->num_rows() > 0){
			$this->db->where($type.'_id', $id);
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
		return $result;	
	}
    
}
?>