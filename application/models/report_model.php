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
		$m =  '%'.$month.'%';
		$n =  '%'.$month.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where("(defect_date LIKE '$m' OR defect_date LIKE'$n')");
		$this->db->where('vendor',$vendor);
		$this->db->where('category',$category);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('Damaged_pcb_detail');
		//echo $this->db->last_query();die;
		return $query->row_array();	
	}
	function calculate_category_count_week($vendor,$category,$date,$start,$end){
		
		$total = 0;
		foreach($date as $d){

                       $date1 = date('Y-m-d',strtotime($d));

			$this->db->select('COUNT(*) AS total', FALSE);
			$this->db->where("defect_date LIKE '$date1%'");
			$this->db->where('vendor',$vendor);
			$this->db->where('category',$category);
			$this->db->order_by('vendor', "asc"); 
			$query = $this->db->get('Damaged_pcb_detail');
			$counts = $query->row_array();
                     //    echo $this->db->last_query();die;
			$total = $total + $counts['total'];
		}
		return $total;
		
	}
	function getProductionQtyForVendorForYear($vendor,$year){
		$year = substr($year,2);
		$year = '%0'.$year.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where('out_scan_time LIKE', $year);
		$this->db->where('vendor',$vendor);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('total_pcb_used_today');
		//echo $this->db->last_query();die;
		return $query->row_array();		
	}
	function getProductionQtyForVendorForMonth($vendor,$month){
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$month = $dateObj->format('m'); 
		$m = '%'.$month.'%';
		$this->db->select('COUNT(*) AS total', FALSE);
		$this->db->where('out_scan_time LIKE', $m);
		$this->db->where('vendor',$vendor);
		$this->db->order_by('vendor', "asc"); 
		$query = $this->db->get('total_pcb_used_today');
		//echo $this->db->last_query();die;
		return $query->row_array();		
	}
	function getProductionQtyForVendorForWeek($vendor,$date,$start,$end){

		$total = 0;
		foreach($date as $d){
			$startDate   = str_replace('/','-',$d);
			$startDate = date("Y-m-d", strtotime($startDate));
			$this->db->select('COUNT(*) AS total', FALSE);
			$this->db->where("out_scan_time LIKE '%$startDate%'");
			$this->db->where('vendor',$vendor);
			$this->db->order_by('vendor', "asc"); 
			$query = $this->db->get('total_pcb_used_today');

			$counts = $query->row_array();
			return $total = $total + $counts['total'];
		}
//echo $total ;die;
	}
}