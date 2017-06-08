<?php
class Report_model extends CI_Model {
	function getAllVendors(){
		$this->db->distinct();
		$this->db->select('vendor');
		$this->db->order_by('vendor', "asc"); 	
		return $this->db->get('Damaged_pcb_detail')->result_array();
	}
	function getAllCategories(){
		$this->db->distinct();
		$this->db->select('category');	
		return $this->db->get('Damaged_pcb_detail')->result_array();
	}
	function calculate_category_count_year($vendor,$category,$year){
		$year = '%'.$year.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where('defect_date LIKE', $year);
		$this->db->where('vendor',$vendor);
		$this->db->where('category',$category);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('Damaged_pcb_detail');
		//echo $this->db->last_query();
		return $query->row_array();	
	}
	function calculate_category_count_month($vendor,$category,$month){
		$m =  '__'.$month.'%';
		$n =  '___'.$month.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where("(defect_date LIKE '$m' OR defect_date LIKE'$n')");
		$this->db->where('vendor',$vendor);
		$this->db->where('category',$category);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('Damaged_pcb_detail');
		//echo $this->db->last_query();
		return $query->row_array();	
	}
	function calculate_category_count_week($vendor,$category,$date,$start,$end){
		
		$total = 0;
		foreach($date as $d){
			$this->db->select('COUNT(*) AS total', FALSE);
			$this->db->where("defect_date LIKE '$d%'");
			$this->db->where('vendor',$vendor);
			$this->db->where('category',$category);
			$this->db->order_by('vendor', "asc"); 
			$query = $this->db->get('Damaged_pcb_detail');
			$counts = $query->row_array();
			$total = $total + $counts['total'];
		}
		return $total;
		
	}
	function getProductionQtyForVendorForYear($vendor,$year){
		$year = substr($year,2);
		$year = '_______'.$year.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where('out_scan_time LIKE', $year);
		$this->db->where('vendor',$vendor);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('total_pcb_used_today');
		//echo $this->db->last_query();
		return $query->row_array();		
	}
	function getProductionQtyForVendorForMonth($vendor,$month){
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$month = $dateObj->format('M'); 
		$m = '___'.$month.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where('out_scan_time LIKE', $m);
		$this->db->where('vendor',$vendor);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('total_pcb_used_today');
		//echo $this->db->last_query();
		return $query->row_array();		
	}
	function getProductionQtyForVendorForWeek($vendor,$date,$start,$end){
		$total = 0;
		foreach($date as $d){
			$startDate   = str_replace('/','-',$d);
			$startDate = date("d-M-y", strtotime($startDate));
			$this->db->select('COUNT(*) AS total', FALSE);
			$this->db->where("out_scan_time LIKE '$startDate%'");
			$this->db->where('vendor',$vendor);
			$this->db->order_by('vendor', "asc"); 
			$query = $this->db->get('total_pcb_used_today');
			$counts = $query->row_array();
			$total = $total + $counts['total'];
		}
		return $total;
	}
}