<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Cronp extends CI_Controller {



    public function __construct() {

        parent::__construct(true);

    }



	public function sendMail(){

        $yearImg = $this->input->post('yearImg');

		$monthImg = $this->input->post('monthImg');

		$weekImg = $this->input->post('weekImg');

		

        $data = array();

		$this->load->model('report_model');

		$year = isset($_POST['yearTxt']) ? $_POST['yearTxt']  : '';

		$month = isset($_POST['monthTxt']) ? $_POST['monthTxt']  : '';

		$week = isset($_POST['weekTxt']) ? $_POST['weekTxt']  : '';

		

		$week_explode = explode('-',$week);

		$startDate = str_replace('/','-',trim(current($week_explode)));

		$endDate = str_replace('/','-',trim(end($week_explode)));

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

		foreach($vendors as $v){

			$total_production =  $this->report_model->getProductionQtyForVendorForYear($v['vendor'],$year);

			$production_year[$v['vendor']] = $total_production['total'];

			$tpqy = $tpqy + $total_production['total'];

		}

		$production_year['Total'] = $tpqy;

		// Total Production Quantity For Month

		$tpqm = 0; 

		foreach($vendors as $v){

			$total_production_month =  $this->report_model->getProductionQtyForVendorForMonth($v['vendor'],$month);

			$production_month[$v['vendor']] = $total_production_month['total'];

			$tpqm = $tpqm + $total_production_month['total'];

		}

		$production_month['Total'] = $tpqm;

		

		// Total Production Quantity For Week

		$tpqw = 0; $pw = 0;

		foreach($vendors as $v){

			$total_production_week =  $this->report_model->getProductionQtyForVendorForWeek($v['vendor'],$ndate,$date_from,$date_to);

			$production_week[$v['vendor']] = $total_production_week;

			$tpqw = $tpqw + $total_production_week;

		}

		$production_week['Total'] = $tpqw;

		

		

		//Year

		$defect_qty_year  = 0;

		if(!empty($categories)){

			foreach($categories as $c){

				if(!empty($vendors)){

					foreach($vendors as $v){

						if(!empty($c['category'])){

							$category_count = $this->report_model->calculate_category_count_year($v['vendor'],$c['category'],$year);

							$count_yr = @(($category_count['total'] * 1000000)/$production_year[$v['vendor']]);

							if(false === $count_yr) {

							  $count_yr = 0;

							}

							$count_yr = round($count_yr);

							$total_counts_year[trim($c['category'])][] = $count_yr;

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

							$category_count = $this->report_model->calculate_category_count_year($v['vendor'],$c['category'],$year);

							$count = @(($category_count['total'] * 1000000)/$production_year[$v['vendor']]);

							if(false === $count) {

							  $count = 0;

							}

							$count = round($count);

							$defect_qty_year = $defect_qty_year + $category_count['total'];

							$total = $total +$count;

						}

					}

					$totals['TTL'][] = $total;

					$defectQtyYear['DEF QTY.'][] = $defect_qty_year;	

					$total = 0;

					$defect_qty_year = 0;

				}

			}	

			$defectQtyYear['DEF QTY.'][] = array_sum($defectQtyYear['DEF QTY.']);

			$totals['TTL'][] = array_sum($totals['TTL']);

		}

		

		//Month

		$defect_qty_month  = 0;

		if(!empty($categories)){

			foreach($categories as $c){

				if(!empty($vendors)){

					foreach($vendors as $v){

						if(!empty($c['category'])){

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

		$total_month = 0;

		if(!empty($vendors)){

			foreach($vendors as $v){

				if(!empty($categories)){

					foreach($categories as $c){

						if(!empty($c['category'])){

							$category_count = $this->report_model->calculate_category_count_month($v['vendor'],$c['category'],$month);

							$count = @(($category_count['total'] * 1000000)/$production_month[$v['vendor']]); 

							if(false === $count) {

							  $count = 0;

							}

							$count = round($count);

							$defect_qty_month = $defect_qty_month + $category_count['total'];

							$total_month = $total_month + $count;

						}

					}

					

					$totals_month['TTL'][] = $total_month;	

					$defectQtyMonth['DEF QTY.'][] = $defect_qty_month;

					

					$total_month = 0;

					$defect_qty_month = 0;

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

		

		

		//Week

		$defect_qty_week  = 0;

		if(!empty($categories)){

			foreach($categories as $c){

				if(!empty($vendors)){

					foreach($vendors as $v){

							if(!empty($c['category'])){

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

							$category_count = $this->report_model->calculate_category_count_week($v['vendor'],$c['category'],

							$ndate,$date_from,$date_to);

							$count = @(($category_count * 1000000)/$production_week[$v['vendor']]);

							if(false === $count) {

							  $count = 0;

							}

							$count = round($count);

							$defect_qty_week = $defect_qty_week + $category_count;

							$total_week = $total_week + $count;

						}

					}

					$totals_week['TTL'][] = $total_week;

					$defectQtyWeek['DEF QTY.'][] = $defect_qty_week;

					$total_week = 0;

					$defect_qty_week = 0;

				}

			}

			$totals_week['TTL'][] = array_sum($totals_week['TTL']);

			$defectQtyWeek['DEF QTY.'][] = array_sum($defectQtyWeek['DEF QTY.']);

		}



		$data['totals'] = $totals;

		$data['totals_month'] = $totals_month;

		$data['totals_week'] = $totals_week;

		$data['production_year'] = $production_year;

		$data['production_month'] = $production_month;

		$data['production_week'] = $production_week;

		$data['total_counts_year'] = $total_counts_year;

		$data['total_counts_month'] = $total_counts_month;

		$data['total_counts_week'] = $total_counts_week;

		$data['defectQtyYear'] = $defectQtyYear;

		$data['defectQtyMonth'] = $defectQtyMonth;

		$data['defectQtyWeek'] = $defectQtyWeek;

        $url = base_url().'assets/pcb_reports/';

        $year_content = file_get_contents($yearImg);

		$month_content = file_get_contents($monthImg);

		$week_content = file_get_contents($weekImg);


		$yname = rand(0,10000000).'year.png';

		$wname = rand(0,10000000).'week.png';

		$mname = rand(0,10000000).'month.png';


        file_put_contents(FCPATH.'assets/pcb_reports/'.$yname, $year_content);

		file_put_contents(FCPATH.'assets/pcb_reports/'.$mname, $month_content);

		file_put_contents(FCPATH.'assets/pcb_reports/'.$wname, $week_content);

		

		$data['year_image'] = $url.$yname;

		$data['month_image'] = $url.$mname; 

		$data['week_image'] = $url.$wname;

		$body = $this->load->view('reports/pcbreport_body',$data,true);

        require FCPATH.'assets/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();

        $msg = 'Hello';

        $mail->setFrom('graheja@crgroup.co.in','PCB Report');

		$mail->isHTML(true);

        $mail->Subject = 'PCB Report';

		$mail->addAddress('matainja006@gmail.com');
		
		$mail->addAddress('graheja@crgroup.co.in');
		
		$mail->addAddress('itmindmap@gmail.com');

        $mail->msgHTML($body); 

        $mail->send();

    } 

	public function cron_pcb_report() {

        $data = array();

		$this->load->model('report_model');

		

		//Current Week

		$week_start = date( 'd/m/Y', strtotime( 'sunday previous week' ) );

		$week_end = date( 'd/m/Y', strtotime( 'saturday this week' ) );

		$current_week = $week_start . ' - '. $week_end;



		$year = date('Y');

		$month = intval(date('m'));

		$week = $current_week;

		

		$week_explode = explode('-',$week);

		$startDate = str_replace('/','-',trim(current($week_explode)));

		$endDate = str_replace('/','-',trim(end($week_explode)));

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

			$total_production =  $this->report_model->getProductionQtyForVendorForYear($v['vendor'],$year);

			$production_year[$v['vendor']] = $total_production['total'];

			$tpqy = $tpqy + $total_production['total'];

		}

		$production_year['Total'] = $tpqy;

		// Total Production Quantity For Month

		$tpqm = 0; 

		foreach($vendors as $v){

			$total_production_month =  $this->report_model->getProductionQtyForVendorForMonth($v['vendor'],$month);

			$production_month[$v['vendor']] = $total_production_month['total'];

			$tpqm = $tpqm + $total_production_month['total'];

		}

		$production_month['Total'] = $tpqm;

		

		// Total Production Quantity For Week

		$tpqw = 0; $pw = 0;

		foreach($vendors as $v){

			$total_production_week =  $this->report_model->getProductionQtyForVendorForWeek($v['vendor'],$ndate,$date_from,$date_to);

			$production_week[$v['vendor']] = $total_production_week;

			$tpqw = $tpqw + $total_production_week;

		}

		$production_week['Total'] = $tpqw;

		

		//Year

		$defect_qty_year  = 0;

		if(!empty($categories)){

			foreach($categories as $c){

				if(!empty($vendors)){

					foreach($vendors as $v){

						if(!empty($c['category'])){

							$category_count = $this->report_model->calculate_category_count_year($v['vendor'],$c['category'],$year);

							$count_yr = @(($category_count['total'] * 1000000)/$production_year[$v['vendor']]);

							if(false === $count_yr) {

							  $count_yr = 0;

							}

							$count_yr = round($count_yr);

							$total_counts_year[trim($c['category'])][] = $count_yr;

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

						}

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
		$defect_qty_month  = 0;

		if(!empty($categories)){

			foreach($categories as $c){

				if(!empty($vendors)){

					foreach($vendors as $v){

						if(!empty($c['category'])){

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

		$total_month = 0;

		if(!empty($vendors)){

			foreach($vendors as $v){

				if(!empty($categories)){

					foreach($categories as $c){

						if(!empty($c['category'])){

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

		$this->template->write('title', 'SQIM | PCB Report');

        $this->template->write_view('content', 'reports/cronreport', $data);

        $this->template->render();

    }  
	
	
	public function mailCheck(){
		require FCPATH.'assets/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();

        $body = 'Hello';

        $mail->setFrom('graheja@crgroup.co.in','PCB Report');

        $mail->Subject = 'PCB Report';

		$mail->addAddress('matainja006@gmail.com');

        $mail->msgHTML($body); 

        $mail->send();
	} 

}