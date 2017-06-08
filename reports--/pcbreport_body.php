<html>
<head>
<style>
.yearText {
	background-color: #ededed;
	border: 1px solid #e0dede;
	font-size: 14px;
	margin-bottom: 10px;
	padding: 1px 0;
	margin-right:15px;
}

.tdCustom .table td
{
	padding: 9px 5px !important;
    text-align: center;
}


</style>
</head>
<body>
<div class="page-content" style="width:900px;">

    <!-- BEGIN PAGE CONTENT-->
    
    <div class="row tdCustom">
        <div class="col-md-12" style="width:100%;">
  			 <div style="width:300px;float:left;">
                  <div style="text-align:center;">
                    <div class="yearText"><strong>Year</strong></div>
                </div>
                <div id = "yearCanvas"> <img src="<?php echo $year_image; ?>" width="100%"  /> </div> 
                <div class="row" style="clear: both;">
                  <div class="col-md-12" style="width:100%;">
                    <table class="table table-bordered" style="width:300px;">
                  <tbody>
                    <tr>
                    <td class="tableBodyText"><strong>PROD QTY.</strong></td>
                      <?php foreach($production_year as $pkey=>$py){?>
                      		 
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $py ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                    <table class="table table-bordered" style="width:300px;padding-right:12px;">
                      <tbody><tr>
                       <?php foreach($defectQtyYear as $index => $defQty){?>
                          <td class="tableBodyText"><strong><?= $index ?></strong></td>
                          <?php foreach($defQty as $dqy){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $dqy ?>"</td>
                          <?php } ?>
                      <?php } ?></tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered" style="width:300px;padding-right:12px;">
                      <tbody>
                       <?php foreach($total_counts_year as $key1=>$values1){?>
                       <tr>
                          <td class="tableBodyText"><strong><?= $key1 ?></strong></td>
                          <?php foreach($values1 as $val){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $val ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals as $key2 => $total){?>
                      <tr>
                          <td class="tableBodyText"><strong><?= $key2 ?></strong></td>
                          <?php foreach($total as $val2){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $val2 ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                   </div>
                </div>
              </div>
             <div style="width:300px;float:left;">
                <div class="row">
                   <div style="width:100%;text-align:center;">
                    <div class="yearText"><strong>Month</strong></div>
                  </div>
                </div>
                <div id = "monthCanvas"> <img src="<?php echo $month_image; ?>" width="100%"  /> </div> 
                <div class="row">
                  <div class="col-md-12" style="width:100%;padding-left:22px;">
                    <table class="table table-bordered" style="width:300px;">
                  <tbody>
                    <tr>
                      <?php foreach($production_month as $pkey=>$py){?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $py ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                    <table class="table table-bordered" style="width:300px;">
                      <tbody>
                      <tr>
                           <?php foreach($defectQtyMonth as $index1 => $defQtyMnt){?>
                          <?php foreach($defQtyMnt as $dqm){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $dqm ?></td>
                          <?php } ?>
                      <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered" style="width:300px;">
                      <tbody>
                       <?php foreach($total_counts_month as $key4=>$values4){?>
                       <tr>
                          
                          <?php foreach($values4 as $value){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $value ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals_month as $key5 => $total5){?>
                      <tr>
                          <?php foreach($total5 as $val5){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $val5 ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                   </div>
                </div>
              </div>
             <div class="col-md-4" style="width:300px;float:left;">
                <div class="row">
                  <div style="width:100%;text-align:center;">
                    <div class="yearText"><strong>Week</strong></div>
                  </div>
                </div>
                
                 <div id = "weekCanvas1">  <img src="<?php echo $week_image; ?>" width="100%"  /> </div> 
                <div class="row">
                  <div class="col-md-12" style="width:100%;padding-left:50px;">
                 
                   <table class="table table-bordered" style="300px;">
                  <tbody>
                    <tr>
                       <?php foreach($production_week as $pw){ ?>
                      		<td class="tableBodyText" style="text-align:center; width:30px;"><?= $pw ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                 <table class="table table-bordered" style="300px;">
                      <tbody>
                      <tr>
                           <?php foreach($defectQtyWeek as $index=> $defQtyWk){?>
                          <?php foreach($defQtyWk as $dqw){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $dqw ?></td>
                          <?php } ?>
                      <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                   <table class="table table-bordered" style="300px;">
                      <tbody>
                       <?php foreach($total_counts_week as $tcsw=>$val){?>
                       <tr>
                          <?php foreach($val as $tcw){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $tcw ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals_week as $tlw => $tw){?>
                      <tr>
                          <?php foreach($tw as $w){ ?>
                          	<td class="tableBodyText" style="text-align:center; width:30px;"><?= $w ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table> 
                    
                   </div>
                </div>
              </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
</body>
</html>