<style type="text/css" media="print">
  @page { 
      /*size: landscape;*/
      size: A4;
      margin: 0;
  }
</style>
<div class="page-content">
    
    <?php if(!isset($download)) { ?>
        <div class="breadcrumbs">
            <h1>
                Part Inspection Report 
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Part Inspection Report</li>
            </ol>
            
        </div>
        <div class="caption">
            <!--<i class="fa fa-reorder"></i>List of Users-->
        </div>
        <div class="actions">
            <a class="button normals btn-circle" onclick="printPage('part_insp_table');" href="javascript:void(0);">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    <?php } ?>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row" id="part_insp_table">
        <div class="col-md-12">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" border="1">
                            <?php 
                                if(($total_col-28)%2 === 0) {
                                    $sign_cell1 = ($total_col-28)/2;
                                    $sign_cell2 = ($total_col-28)/2;
                                } else {
                                    $sign_cell1 = floor(($total_col-28)/2);
                                    $sign_cell2 = ceil(($total_col-28)/2);
                                }
                                
                                //echo $total_col." ".$sign_cell1." ".$sign_cell2;
                            ?>
                            <tr>
                                <td colspan="18">
                                    <span style="font-size: 24px; font-weight: bold;">Part Inspection Report</span>
                                </td>
                                <td class="text-center" colspan="<?php echo $sign_cell1; ?>">Vendor Inspector <br /> SIGN</td>
                                <td class="text-center" colspan="<?php echo $sign_cell2; ?>">LG Inspector <br /> SIGN</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Part Name: <?php echo $audit['part_name']; ?>
                                </td>
                                <td colspan="4">
                                    Part No: <?php echo $audit['part_no']; ?>
                                </td>
                                <td colspan="5">
                                    Lot Size: <?php echo $audit['prod_lot_qty']; ?>
                                </td>
                                <td colspan="5">
                                    Date: <?php echo $audit['register_datetime']; ?>
                                </td>
                                <td class="text-center" colspan="<?php echo $sign_cell1; ?>"></td>
                                <td class="text-center" colspan="<?php echo $sign_cell2; ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Supplier Name: <?php echo $audit['supplier_name']; ?>
                                </td>
                                <td colspan="1">
                                    ASN No: 
                                </td>
                                <td colspan="4">
                                    SQIM Lot No: <?php echo $audit['lot_no']; ?>
                                </td>
                                <td colspan="5">
                                    Supplier Inspector: <?php echo $audit['inspector_name']; ?>
                                </td>
                                <td colspan="5">
                                    LG Inspector: 
                                </td>
                                <td class="text-center" colspan="<?php echo $sign_cell1; ?>">
                                    Result: <?php echo $final_result; ?>
                                </td>
                                <td class="text-center" colspan="<?php echo $sign_cell2; ?>">Deviation / Segregation</td>
                            </tr>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Inspection Type</th>
                                <th>Inspection Item</th>
                                <th style="min-width: 300px;">Specification</th>
                                <th>LSL</th>
                                <th>Target</th>
                                <th>USL</th>
                                <th>Sampling STD</th>
                                <th>AQL</th>
                                <th>Sample Qty</th>
                                <th>Measuring Equipment</th>
                                <th>UOM</th>
                                <th>Place</th>
                                <?php 
                                if($max_qty >= 10)
                                {
                                    $cols = 10;
                                }else{
                                    $cols = $max_qty;
                                }   
                                for($i = 1; $i <= $cols; $i++) { ?>
                                    <th>#<?php echo $i;?></th>
                                <?php } ?>
                            </tr>
                            <tbody>
                                <?php foreach($checkpoints as $ind => $checkpoint) { ?>
                                    <tr>
                                        <td rowspan="2"><?php echo $ind+1;?></td>
                                        <td rowspan="2"><?php echo $checkpoint['insp_item'];?></td>
                                        <td rowspan="2"><?php echo $checkpoint['insp_item2'];?></td>
                                        <td rowspan="2"><?php echo $checkpoint['spec'];?></td>
                                        <td rowspan="2" style="text-align:center;"><?php echo $checkpoint['lsl'];?></td>
                                        <td rowspan="2" style="text-align:center;"><?php echo $checkpoint['tgt'];?></td>
                                        <td rowspan="2" style="text-align:center;"><?php echo $checkpoint['usl'];?></td>
                                        <td rowspan="2"><?php if($checkpoint['sampling_type'] == 'Fixed'){ echo 'User Defined';}
                                                                else if($checkpoint['sampling_type'] == 'Auto'){ echo 'MIL STD 105D';}
                                                                else{ echo $checkpoint['sampling_type'];}?></td>
                                        <td rowspan="2" style="text-align:center;">
                                            <?php if($checkpoint['sampling_type'] == 'Auto'){ 
                                                if($checkpoint['inspection_level']>=1 && $checkpoint['inspection_level'] <= 3){ $insp_level = 'G-'.$checkpoint['inspection_level'];}
                                                else{ $insp_level = $checkpoint['inspection_level']; }
                                                echo $insp_level." (".$checkpoint['acceptable_quality'].")"; }
                                            else{ echo $checkpoint['acceptable_quality'];}?></td>
                                        <td rowspan="2" style="text-align:center;"><?php echo $checkpoint['sampling_qty'];?></td>
                                        <td rowspan="2"><?php echo '';?></td>
                                        <td rowspan="2" style="text-align:center;"><?php echo $checkpoint['unit'];?></td>
                                        <td>Supp</td>
                                        <?php $result = explode(',', $checkpoint['all_results']);
                                              $result1 = explode(',', $checkpoint['all_values']);
                                        ?>
                                        <?php 
                                        if($checkpoint['lsl'] == '' && $checkpoint['tgt'] == '' && $checkpoint['usl'] == ''){ ?>
                                        <td colspan="<?php echo $cols; ?>">
                                        <?php 
                                            $ok_count = 0;
                                            $ng_count = 0;
                                            for($i = 1; $i <= $max_qty; $i++) { 
                                                if(@$result[$i-1] == 'OK'){
                                                    $ok_count++;
                                                }else if(@$result[$i-1] == 'NG'){
                                                    $ng_count++;
                                                }
                                            }
                                            echo "OK -".$ok_count.", NG - ".$ng_count;
                                        ?>
                                        </td>
                                        <?php }else{
                                        for($i = 1; $i <= $cols; $i++) { ?>
                                            <td style="text-align:center;"><?php if(@$result1[$i-1] != '' && @$result1[$i-1] != NULL) {
                                                        echo $result1[$i-1];
                                            }else{
                                                        echo isset($result[$i-1]) ? $result[$i-1] : '' ;
                                            }
                                        ?></td>
                                        <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>LG</td>
                                        <?php if($checkpoint['lsl'] == '' && $checkpoint['tgt'] == '' && $checkpoint['usl'] == ''){ ?>
                                        <td colspan="<?php echo $cols; ?>"></td>
                                        <?php }else{ ?>
                                        <?php for($i = 1; $i <= $cols; $i++) { ?>
                                            <td> </td>
                                        <?php } ?>
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