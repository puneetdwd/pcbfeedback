<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {
	

    public function __construct() {
        parent::__construct();
        
        $this->template->write_view('header', 'templates/header', array('page' => 'reports'));
        $this->template->write_view('footer', 'templates/footer');
    }

    public function index() {
 
        $data = array();
        $this->load->model('Audit_model');
         

        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
        }
        $data['parts'] = $this->Audit_model->get_all_audit_parts('', $sup_id);
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        
        $data['total_records'] = 0;
        
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector') {
                $filters['supplier_id'] = $this->supplier_id;
            }
            if(@$filters['product_all']) {
                $filters['product_id'] = "all";
            } else {
                $filters['product_id'] = $this->product_id;
            }
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = 'LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Audit_model->get_completed_audits($filters, true);
            $count = $count[0]['c'];
            $data['total_records'] = $count;
            $data['total_page'] = ceil($count/50);
            
            $data['audits'] = $this->Audit_model->get_completed_audits($filters, false);
            //echo $this->db->last_query();exit;
        }
      
        $this->template->write('title', 'SQIM | Edit Inspections');
        $this->template->write_view('content', 'reports/index', $data);
        $this->template->render();
    }
    
    public function lot_wise_report() {
        $data = array();
        $this->load->model('Audit_model');

        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
        }
        
        $data['parts'] = $this->Audit_model->get_all_audit_parts('', $sup_id);
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        
        $data['total_records'] = 0;
        
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            if(@$filters['product_all']) {
                $filters['product_id'] = "all";
            } else {
                $filters['product_id'] = $this->product_id;
            }
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = 'LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Audit_model->get_consolidated_audit_report($filters, true);
            $count = $count[0]['c'];
            $data['total_records'] = $count;
            $data['total_page'] = ceil($count/50);
            
            $data['audits'] = $this->Audit_model->get_consolidated_audit_report($filters, false, $limit);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Inspections Report');
        $this->template->write_view('content', 'reports/lot_wise_report', $data);
        $this->template->render();
    }

    public function part_inspection_report($audit_id) {
        $data = array();
        $this->load->model('Audit_model');
        $filters = array('id' => $audit_id);
        $audit = $this->Audit_model->get_completed_audits($filters, false, 'LIMIT 1');
        if(empty($audit)) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect(base_url().'reports');
        }
        
        $audit = $audit[0];
        $checkpoints = $this->Audit_model->get_all_audit_checkpoints($audit['id']);
        
        $max_qty = 0;
        foreach($checkpoints as $checkpoint) {
            if($checkpoint['sampling_qty'] > $max_qty) {
                $max_qty = $checkpoint['sampling_qty'];
            }
        }
        
        foreach($checkpoints as $chk){
            if($chk['result'] == 'NG'){
                $final_result = $chk['result'];
                break;
            }else{
                $final_result = $chk['result'];
            }
        }
        
        $data['final_result'] = $final_result;
        $data['audit'] = $audit;
        $data['checkpoints'] = $checkpoints;
        $data['max_qty'] = $max_qty;
        $data['total_col'] = $max_qty+13;
        
        //echo "<pre>";print_r($checkpoints); exit;
        
        if($this->input->get('download')) {
            $data['download'] = true;
            $str = $this->load->view('reports/part_inspection_report', $data, true);
        
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Part_Inspection_'.$audit['part_no'].'.xls');
            // Fix for crappy IE bug in download.
            header("Pragma: ");
            header("Cache-Control: ");
            echo $str;
        } else {
            $this->template->write('title', 'SQIM | Part Inspection Report');
            $this->template->write_view('content', 'reports/part_inspection_report', $data);
            $this->template->render();
        }
    }
    
    public function check_judgement() {
        $response = array('status' => 'error');
        if($this->input->post('audit_id')) {
            $audit_id = $this->input->post('audit_id');
            
            $this->load->model('Audit_model');
            $res = $this->Audit_model->get_audit_judgement($audit_id);
            
            $response = array('status' => 'success', 'judgement' => ($res['ng_count'] > 0 ? 'NG' : 'OK'));
        }
        
        echo json_encode($response);
    }

    public function timecheck() {
        if($this->user_type == 'Supplier Inspector') {
            //redirect($_SERVER['HTTP_REFERER']);
        }
        
        $data = array();
        $this->load->model('Audit_model');
        $this->load->model('Timecheck_model');

        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector') {
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
            
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        }

        $data['parts'] = $this->Audit_model->get_all_audit_parts('', $sup_id);

        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        
        $data['total_records'] = 0;
        
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector') {
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = 'LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Timecheck_model->get_timecheck_plan_report($filters, true);
            $count = $count[0]['c'];
            $data['total_records'] = $count;
            $data['total_page'] = ceil($count/50);
            
            $data['plans'] = $this->Timecheck_model->get_timecheck_plan_report($filters, false);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Timecheck Report');
        $this->template->write_view('content', 'reports/timecheck', $data);
        $this->template->render();
    }
    
    function foolproof(){
        
        if($this->user_type == 'Supplier Inspector') {
            //redirect($_SERVER['HTTP_REFERER']);
        }
        
        $data = array();

        if($this->user_type == 'Supplier') {
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
            
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        }
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier') {
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            $this->load->model('foolproof_model');
            $data['foolproofs'] = $this->foolproof_model->get_foolproof_report($filters);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Fool-Proof Report');
        $this->template->write_view('content', 'reports/foolproof', $data);
        $this->template->render();
    }
    
    function download_foolproof_report($date, $supplier_id = ''){
        
        $filter = array();
        $data = array();
        
        $filter['date'] = $date;
        
        if(!empty($supplier_id)){
            $filter['supplier_id'] = $supplier_id;
        }
        
        $this->load->model('foolproof_model');
        $data['foolproofs'] = $this->foolproof_model->get_foolproof_report($filter);
        
        $str = $this->load->view('fool_proof/view', $data, true);
        
        header('Content-Type: application/force-download');
        header('Content-disposition: attachment; filename=FoolProof_Report.xls');
        // Fix for crappy IE bug in download.
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
        
        //header("location:".base_url()."reports/foolproof");
        
    }

public function pcb_report() {
        $data = array();
		$this->load->model('report_model');
		
		//Current Week
		$week_start = date( 'd/m/Y', strtotime( 'sunday previous week' ) );
		$week_end = date( 'd/m/Y', strtotime( 'saturday this week' ) );
		$current_week = $week_start . ' - '. $week_end;

		$year = isset($_POST['yearDropDwn']) ? $_POST['yearDropDwn']  : date('Y');
		$month = isset($_POST['monthDropDwn']) ? $_POST['monthDropDwn']  : intval(date('m'));
		$week = isset($_POST['weekTxt']) ? $_POST['weekTxt']  : $current_week;
		
		$week_explode = explode('-',$week);
		$startDate = str_replace('/','-',trim(current($week_explode)));
                // echo $startDate ;  
 		$endDate = str_replace('/','-',trim(end($week_explode)));
		// echo $endDate ;
		$df = strtotime($startDate);
		$de = strtotime($endDate);
		
		for ($i=$df; $i<=$de; $i+=86400) {  
			$ndate[] = date("j/n/Y", $i); 
		}
		
		$date_from = date("j/n/Y", $df);
		$date_to = date("j/n/Y", $de); // Convert date to a UNIX timestamp 
		
		$vendors = $this->report_model->getAllVendors();
                           

		$categories = $this->report_model->getAllCategories();
             
		
		foreach($categories as $cat){
			if(!empty($cat['category'])){
				$new_cat[] = $cat;	
			}	
		}
		$categories = $new_cat;

		// Total Production Quantity For Year
		$tpqy = 0; 
		$production_year[] = '<strong>'.'PROD QTY.'.'</strong>';
		foreach($vendors as $v){
if(!empty($v['vendor']))
{			$total_production =  $this->report_model->getProductionQtyForVendorForYear($v['vendor'],$year);

			$production_year[$v['vendor']] = $total_production['total'];
			$tpqy = $tpqy + $total_production['total'];
}
		}
		$production_year['Total'] = $tpqy;
              //echo "<pre>";print_r($production_year['Total']);die;
		// Total Production Quantity For Month
		$tpqm = 0; 
		foreach($vendors as $v){
if(!empty($v['vendor']))
{	
			$total_production_month =  $this->report_model->getProductionQtyForVendorForMonth($v['vendor'],$month);
			$production_month[$v['vendor']] = $total_production_month['total'];
			$tpqm = $tpqm + $total_production_month['total'];
}
		}
		$production_month['Total'] = $tpqm;
		
		// Total Production Quantity For Week
		$tpqw = 0; $pw = 0;
		foreach($vendors as $v){
if(!empty($v['vendor']))
{
			$total_production_week =  $this->report_model->getProductionQtyForVendorForWeek($v['vendor'],$ndate,$date_from,$date_to);
			$production_week[$v['vendor']] = $total_production_week;
			$tpqw = $tpqw + $total_production_week;
}
		}
		$production_week['Total'] = $tpqw;
		
		
		//Year
		$defect_qty_year  = 0;
		if(!empty($categories)){
			foreach($categories as $c){
				if(!empty($vendors)){
					foreach($vendors as $v){
						if(!empty($c['category'])){
                                                                  if(!empty($v['vendor'])){
							$category_count = $this->report_model->calculate_category_count_year($v['vendor'],$c['category'],$year);
							$count_yr = @(($category_count['total'] * 1000000)/$production_year[$v['vendor']]);
							if(false === $count_yr) {
							  $count_yr = 0;
							}
							$count_yr = round($count_yr);
							$total_counts_year[trim($c['category'])][] = $count_yr;
						}
                                           }
					}
					$total_counts_year[trim($c['category'])][] = $total_category_year[trim($c['category'])] = array_sum($total_counts_year[trim($c['category'])]);	
				}
				
			}	
			
		}
               
		$total = 0;
		if(!empty($vendors)){
			foreach($vendors as $v){
				if(!empty($categories)){
					foreach($categories as $c){
						if(!empty($c['category'])){
                                                          if(!empty($v['vendor'])){
							$category_count = $this->report_model->calculate_category_count_year($v['vendor'],$c['category'],$year);
							$count = @(($category_count['total'] * 1000000)/$production_year[$v['vendor']]);
							if(false === $count) {
							  $count = 0;
							}
							$count = round($count);
							$json[] = trim($v['vendor']);
							$json[] = trim($c['category']);
							$json[] = $count;
							$defect_qty_year = $defect_qty_year + $category_count['total'];
							$total = $total +$count;
						}}
						$custom_cat_json[] = $json;
						$json= array();
					}
					$totals['TTL'][] = $total;
					$defectQtyYear['DEF QTY.'][] = $defect_qty_year;	
					$total = 0;
					$defect_qty_year = 0;
				}
				$new_json_array_year[] = $custom_cat_json;
				$custom_cat_json = array();
			}	
			$defectQtyYear['DEF QTY.'][] = array_sum($defectQtyYear['DEF QTY.']);
			$totals['TTL'][] = array_sum($totals['TTL']);
		}
		
		foreach($new_json_array_year as $array){
			foreach($array as $arr){
				if(!empty($arr)){
					$year_json_array[] = $arr;
				}
			}	
		}
		
		foreach($total_category_year as $k => $tcat){
			$new_total_category_count[] = 'Total';
			$new_total_category_count[] = $k;
			$new_total_category_count[] = $tcat;
			$year_json_array[] = $new_total_category_count;
			$new_total_category_count = array();	
		}
		//Month
//echo "<pre>";
//print_r($vendors);
		$defect_qty_month  = 0;
		if(!empty($categories)){
			foreach($categories as $c){
				if(!empty($vendors)){
					foreach($vendors as $v){
						if(!empty($c['category'])){
                                                           if(!empty($v['vendor'])){

							$category_count = $this->report_model->calculate_category_count_month($v['vendor'],$c['category'],$month);
							$count_month = @(($category_count['total'] * 1000000)/$production_month[$v['vendor']]);
							if(false === $count_month) {
							  $count_month = 0;
							}
							$total_counts_month[trim($c['category'])][] = round($count_month);
}
						}
					}	
				}
				
			}	
			
		}
		$total_month = 0;
		if(!empty($vendors)){
			foreach($vendors as $v){
				if(!empty($categories)){
					foreach($categories as $c){
						if(!empty($c['category'])){
                                                       if(!empty($v['vendor'])){
							$category_count = $this->report_model->calculate_category_count_month($v['vendor'],$c['category'],$month);
							$count = @(($category_count['total'] * 1000000)/$production_month[$v['vendor']]); 
							if(false === $count) {
							  $count = 0;
							}
							$count = round($count);
							$json[] = trim($v['vendor']);
							$json[] = trim($c['category']);
							$json[] = $count;
							$defect_qty_month = $defect_qty_month + $category_count['total'];
							$total_month = $total_month + $count;
						}
                                              }
						$custom_cat_json[] = $json;
						$json= array();
					
					}
					
					$totals_month['TTL'][] = $total_month;	
					$defectQtyMonth['DEF QTY.'][] = $defect_qty_month;
					
					$total_month = 0;
					$defect_qty_month = 0;
				}
				$new_json_array_month[] = $custom_cat_json;
				$custom_cat_json = array();
			}	
			
		}
		foreach($new_json_array_month as $array){
			foreach($array as $arr){
				if(!empty($arr)){
					$month_json_array[] = $arr;
				}
			}	
		}
		foreach($total_counts_month as $t => $mt){
			$sum = array_sum($mt);
			array_push($mt,$sum);
			$total_counts_month[$t] = $mt;
			$total_category[trim($t)] = $sum;
		}
		foreach($totals_month as $tt => $tm){
			$sum = array_sum($tm);
			array_push($tm,$sum);
			$totals_month[$tt] = $tm;
		}
		foreach($defectQtyMonth as $dqm => $m){
			$sum = array_sum($m);
			array_push($m,$sum);
			$defectQtyMonth[$dqm] = $m;
		}
		
		foreach($total_category as $k => $tcat){
			$new_total_category_count[] = 'Total';
			$new_total_category_count[] = $k;
			$new_total_category_count[] = $tcat;
			
			
			$month_json_array[] = $new_total_category_count;
			$new_total_category_count = array();	
		}
		//Week
	$defect_qty_week  = 0;
		if(!empty($categories)){
			foreach($categories as $c){
				if(!empty($vendors)){
					foreach($vendors as $v){
							if(!empty($c['category'])){
                                                               if(!empty($v['vendor'])){
								$category_count = $this->report_model->calculate_category_count_week($v['vendor'],$c['category'],
								$ndate,$date_from,$date_to); 
	
								$count_wk = @(($category_count * 1000000)/$production_week[$v['vendor']]);
								if(false === $count_wk) {
								  $count_wk = 0;
								}
								$count_wk = round($count_wk);
								$total_counts_week[trim($c['category'])][] = $count_wk;
							}
                                                     }
						}
						$total_counts_week[trim($c['category'])][] = $total_category_week[trim($c['category'])] = array_sum($total_counts_week[trim($c['category'])]);	
					}
					
			}	
			
		}
		
		
		$total_week = 0;
		if(!empty($vendors)){
			foreach($vendors as $v){
				if(!empty($categories)){
					foreach($categories as $c){
						if(!empty($c['category'])){
                                                               if(!empty($v['vendor'])){
							$category_count = $this->report_model->calculate_category_count_week($v['vendor'],$c['category'],
							$ndate,$date_from,$date_to);
							$count = @(($category_count * 1000000)/$production_week[$v['vendor']]);
							if(false === $count) {
							  $count = 0;
							}
							$count = round($count);
							$json[] = trim($v['vendor']);
							$json[] = trim($c['category']);
							$json[] = $count;
							$defect_qty_week = $defect_qty_week + $category_count;
							$total_week = $total_week + $count;
						}
                                          }
						$custom_cat_json[] = $json;
						$json= array();
					}
					$totals_week['TTL'][] = $total_week;
					$defectQtyWeek['DEF QTY.'][] = $defect_qty_week;
					$total_week = 0;
					$defect_qty_week = 0;
				}
				
				$new_json_array_week[] = $custom_cat_json;
				$custom_cat_json = array();
			}
			$totals_week['TTL'][] = array_sum($totals_week['TTL']);
			$defectQtyWeek['DEF QTY.'][] = array_sum($defectQtyWeek['DEF QTY.']);
		}
		
		
		foreach($new_json_array_week as $array){
			foreach($array as $arr){
				if(!empty($arr)){
					$week_json_array[] = $arr;
				}
			}	
		}
		
		foreach($total_category_week as $k => $tcat){
			$new_total_category_count[] = 'Total';
			$new_total_category_count[] = $k;
			$new_total_category_count[] = $tcat;
			$week_json_array[] = $new_total_category_count;
			$new_total_category_count = array();	
		}
echo "<pre>";
print_r($new_total_category_count);
print_r($year_json_array);
print_r($month_json_array);

print_r($week_json_array);die;
		
		$data['totals'] = $totals;
		$data['totals_month'] = $totals_month;
		$data['totals_week'] = $totals_week;
		$data['production_year'] = $production_year;
		$data['production_month'] = $production_month;
		$data['production_week'] = $production_week;
		$data['categories'] = $categories;
		$data['total_counts_year'] = $total_counts_year;
		$data['total_counts_month'] = $total_counts_month;
		$data['total_counts_week'] = $total_counts_week;
		$data['defectQtyYear'] = $defectQtyYear;
		$data['defectQtyMonth'] = $defectQtyMonth;
		$data['defectQtyWeek'] = $defectQtyWeek;
		$data['json_year'] = json_encode($year_json_array);
		$data['json_month'] = json_encode($month_json_array);
		$data['json_week'] = json_encode($week_json_array);
		$data['year'] = $year;
		$data['month'] = $month;
		$data['week'] = $week;
		
		//echo "<pre>"; print_r($data); exit;
		
        $this->template->write('title', 'SQIM | PCB Report');
        $this->template->write_view('content', 'reports/pcb_report', $data);
        $this->template->render();
    }

}