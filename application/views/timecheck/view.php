<style>
    .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    
</style>

<style type="text/css" media="print">
  @page { 
      /*size: landscape;*/
      size: A4;
      margin: 0;
  }
</style>

<div class="page-content">

    <?php if(!isset($download)) { ?>
        <!-- BEGIN PAGE HEADER-->
        <div class="breadcrumbs">
            <h1>
                Timecheck
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Timecheck</li>
            </ol>
        </div>
        
        <div class="actions">
            <a class="button normals btn-circle" onclick="printPage('part_insp_table');" href="javascript:void(0);">
                <i class="fa fa-print"></i> Print
            </a>
            <a class="button normals btn-circle" href="<?php echo base_url()."timecheck/view/".$plan['id']."?download=true";?>">
                <i class="fa fa-print"></i> Download
            </a>
        </div>
        <!-- END PAGE HEADER-->
    <?php } ?>
    
    <!-- BEGIN PAGE CONTENT-->
    
    <div class="row" style="margin-top:15px;"  id="part_insp_table">
        
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="fa fa-times"></i>
                   <?php echo $this->session->flashdata('error');?>
                </div>
            <?php } else if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                   <?php echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Checkpoints <small>for</small> Part : <?php echo $plan['part_name'].'( '.$plan['part_no'].' )';?>, Supplier : <?php echo $plan['supplier_name']; ?>, Date : <?php echo $plan['plan_date'] ?>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($checkpoints)) { ?>
                        <p class="text-center">No Checkpoints.</p>
                    <?php } else { ?>
                        <form method="post" action="<?php echo base_url().'timecheck/save_result'; ?>">
                            <input type="hidden" value=" <?php echo $plan['id'];?>" name="plan_id" />
                            <input type="hidden" value=" <?php echo $plan['part_id'];?>" name="part_id" />
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" style="vertical-align:middle">#</th>
                                            <th rowspan="3" style="vertical-align:middle">Insp. Item</th>
                                            <th rowspan="3" style="vertical-align:middle">Chars.</th>
                                            <th rowspan="3" style="vertical-align:middle">Judgement Criteria</th>
                                            <th rowspan="2" colspan="3" class="text-center">Specification</th>
                                            <th rowspan="3" style="vertical-align:middle">Frequency</th>
                                            <th rowspan="3" style="vertical-align:middle">Sample Qty</th>
                                            <th rowspan="3" style="vertical-align:middle">Instrument</th>
                                            <th rowspan="3" style="vertical-align:middle">UOM</th>
                                            
                                            <?php foreach($frequency_headers as $freq_header) { ?>
                                                <th class="text-center" colspan="<?php echo $sample_qty; ?>" nowrap><?php echo $freq_header; ?></th>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <th class="text-center" colspan="<?php echo $sample_qty; ?>" nowrap>
                                                    <?php 
                                                        $fr = isset($freq_results[$i+1]) ? $freq_results[$i+1] : '';
                                                        $for = isset($freq_org_results[$i+1]) ? $freq_org_results[$i+1] : '';
                                                    ?>
                                                    Result : <?php echo $fr; ?>
                                                    <?php if($fr != $for) { ?>
                                                        <small style="text-decoration:line-through;"><?php echo $for; ?></small>
                                                    <?php } ?>
                                                </th>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>LSL</th>
                                            <th>USL</th>
                                            <th>TGT</th>
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <?php for($s = 1; $s <= $sample_qty; $s++) { ?>
                                                    <th class="text-center">
                                                        <?php echo '#'.$s; ?>
                                                    </th>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($checkpoints as $k => $checkpoint) { ?>
                                            <tr class="checkpoint-<?php echo $checkpoint['id']; ?>">
                                                <td><?php echo $k+1; ?></td>
                                                <td><?php echo $checkpoint['insp_item']; ?></td>
                                                <td><?php echo $checkpoint['measure_type']; ?></td>
                                                <td><?php echo $checkpoint['spec']; ?></td>
                                                <td nowrap>
                                                    <?php echo ($checkpoint['lsl']) ? $checkpoint['lsl'].' '.$checkpoint['unit'] : ''; ?>
                                                </td>
                                                <td nowrap>
                                                    <?php echo ($checkpoint['usl']) ? $checkpoint['usl'].' '.$checkpoint['unit'] : ''; ?>
                                                </td>
                                                <td nowrap>
                                                    <?php echo ($checkpoint['tgt']) ? $checkpoint['tgt'].' '.$checkpoint['unit'] : ''; ?>
                                                </td>
                                                <td><?php echo $checkpoint['frequency'].' hours'; ?></td>
                                                <td><?php echo $checkpoint['sample_qty']; ?></td>
                                                
                                                <td><?php echo $checkpoint['instrument']; ?></td>
                                                <td><?php echo $checkpoint['unit']; ?></td>
                                                
                                                <?php 
                                                    $all_results = explode(',', $checkpoint['all_results']);
                                                    $all_values = explode(',', $checkpoint['all_values']);
                                                    
                                                    $org_all_results = explode(',', $checkpoint['org_all_results']);
                                                    $org_all_values = explode(',', $checkpoint['org_all_values']);
                                                    $current = 0;
                                                ?>
                                                <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                    <?php
                                                        $freq_period = floor(($i*$freq_step)/$checkpoint['frequency']);
                                                        $freq_passed_slot = $i-($freq_period*($checkpoint['frequency']/$freq_step));
                                                        $freq_remaining = ($checkpoint['frequency']/$freq_step)-$freq_passed_slot-1;
                                                        
                                                        $slice_start = ($freq_period*($checkpoint['frequency']/$freq_step)*$sample_qty);
                                                        if($slice_start < 0) {
                                                            $slice_start = 0;
                                                        }
                                                        
                                                        $passed = ($freq_period+1)*($checkpoint['frequency']/$freq_step)*$sample_qty;
                
                                                        if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) {
                                                            $sliced = array_slice($all_values, $slice_start, $passed);
                                                        } else {
                                                            $sliced = array_slice($all_results, $slice_start, $passed);
                                                        }
                                                        
                                                        $already_filled = false;
                                                        foreach($sliced as $slice) {
                                                            if(!empty($slice)) {
                                                                $already_filled = true;
                                                            }
                                                        }
                                                    ?>
                                                
                                                    <?php for($s = 1; $s <= $sample_qty; $s++) { ?>
                                                        
                                                        <td nowrap>
                                                            <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                                                                <?php $iresult = !empty($all_values[$current]) ? $all_values[$current] : ''?>
                                                                <?php $org_iter_value = !empty($org_all_values[$current]) ? $org_all_values[$current] : ''; ?>
                                                                
                                                                <?php 
                                                                    $iflag = 'OK';
                                                                    if($iresult !== '') {
                                                                        if(!empty($checkpoint['lsl']) && $iresult < $checkpoint['lsl']) {
                                                                            $iflag = 'NG';
                                                                        }
                                                                        
                                                                        if(!empty($checkpoint['usl']) && $iresult > $checkpoint['usl']) {
                                                                            $iflag = 'NG';
                                                                        }
                                                                    } else {
                                                                        $iflag = 'NA';
                                                                    }
                                                                ?>

                                                                <?php 
                                                                    $show_change = false; 
                                                                    if($iflag == 'NG') {
                                                                        $show_change = true;
                                                                    } else if($iflag == 'NA') {
                                                                        if(!$already_filled &&  $freq_passed_slot === 0) {
                                                                            $show_change = true;
                                                                        }
                                                                    }
                                                                ?>
                                                                
                                                                <?php echo !empty($all_values[$current]) ? $all_values[$current].' '.$checkpoint['unit'] : ''; ?>
                                                                <?php if($iresult != $org_iter_value) { ?>
                                                                    <br />
                                                                    <small style="text-decoration:line-through;"><?php echo $org_iter_value.' '.$checkpoint['unit']; ?></small>
                                                                <?php } ?>
                                                                
                                                                <?php if($show_change) { ?>
                                                                    <br />
                                                                    <a class="timecheck-freq-<?php echo $checkpoint['id'].'-'.$i.'-'.$s; ?>" href="<?php echo base_url()."timecheck/edit_freq/".$plan['id'].'-'.$checkpoint['id'].'-'.$i.'-'.$s; ?>" data-target="#adjust-timecheck-modal" data-toggle="modal">
                                                                        ( Change )
                                                                    </a>
                                                                <?php } ?>
                                                                
                                                            <?php } else { ?>
                                                                <?php $iresult = !empty($all_results[$current]) ? $all_results[$current] : ''; ?>
                                                                <?php $org_iresult = !empty($org_all_results[$current]) ? $org_all_results[$current] : ''; ?>
                                                                
                                                                <?php echo $iresult; ?>
                                                                <?php if($iresult != $org_iresult) { ?>
                                                                    <small style="text-decoration:line-through;"> <?php echo $org_iresult; ?></small>
                                                                <?php } ?>
                                                                
                                                                <?php 
                                                                    $show_change = false; 
                                                                    if($iresult == 'NG') {
                                                                        $show_change = true;
                                                                    } else if(!$iresult) {
                                                                        if(!$already_filled && $freq_passed_slot == 0) {
                                                                            $show_change = true;
                                                                        }
                                                                    }
                                                                ?>
                                                                
                                                                <?php if($show_change) { ?>
                                                                    <br />
                                                                    <a class="timecheck-freq-<?php echo $checkpoint['id'].'-'.$i.'-'.$s; ?>" href="<?php echo base_url()."timecheck/edit_freq/".$plan['id'].'-'.$checkpoint['id'].'-'.$i.'-'.$s; ?>" data-target="#adjust-timecheck-modal" data-toggle="modal">
                                                                        ( Change )
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            
                                                        </td>
                                                        
                                                        <?php $current++; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        
                                        <tr>
                                            <td colspan="11" class="text-right">Production Quantity</td>
                                            
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <td colspan="<?php echo $sample_qty; ?>"><?php echo isset($production_qties[$i+1]) ? $production_qties[$i+1] : ''; ?></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="adjust-timecheck-modal" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
