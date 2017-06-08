<style>
    .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    
</style>

<div class="page-content">
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
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    
    <div class="row" style="margin-top:15px;">
        
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
                        <i class="fa fa-reorder"></i>Checkpoints <small>for</small> Part : <?php echo $plan['part_name'].'( '.$plan['part_no'].' )';?>,
                        Child Part : <?php echo $plan['child_part_no'];?>, Mold No. : <?php echo $plan['mold_no'];?>
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
                                            <th rowspan="2" style="vertical-align:middle">#</th>
                                            <th rowspan="2" style="vertical-align:middle">Insp. Item</th>
                                            <th rowspan="2" style="vertical-align:middle">Chars.</th>
                                            <th rowspan="2" style="vertical-align:middle">Judgement Criteria</th>
                                            <th colspan="3" class="text-center">Specification</th>
                                            <th rowspan="2" style="vertical-align:middle">Frequency</th>
                                            <th rowspan="2" style="vertical-align:middle">Sample Qty</th>
                                            <th rowspan="2" style="vertical-align:middle">Instrument</th>
                                            <th rowspan="2" style="vertical-align:middle">UOM</th>

                                            <?php foreach($frequency_headers as $freq_header) { ?>
                                                <th class="text-center" colspan="<?php echo $sample_qty; ?>" nowrap><?php echo $freq_header; ?></th>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>LSL</th>
                                            <th>USL</th>
                                            <th>TGT</th>
                                            
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <?php for($s = 1; $s <= $sample_qty; $s++) { ?>
                                                    <th class="text-center">
                                                        <?php if($allowed[$i] == 'Yes') { ?>
                                                            <span style="visibility: hidden;">ToIncSize</span>
                                                        <?php } ?>
                                                        <?php echo '#'.$s; ?>
                                                        
                                                    </th>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($checkpoints as $k => $checkpoint) { ?>
                                            <tr class="checkpoint-<?php echo $checkpoint['id']; ?>">
                                                <input type="hidden" class="timecheck-lsl" value="<?php echo $checkpoint['lsl']; ?>" />
                                                <input type="hidden" class="timecheck-usl" value="<?php echo $checkpoint['usl']; ?>" />
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
                                                    $current = 0;
                                                ?>
                                                <?php $last_allowed_freq = null; ?>
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
                                                        
                                                        <?php if($s > $checkpoint['sample_qty']) { ?>
                                                            <td></td>
                                                        <?php } else { ?>
                                                            <?php if($allowed[$i] == 'Yes' && !$already_filled && ($last_allowed_freq === null || $last_allowed_freq == $i)) { ?>
                                                                
                                                                <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                                                                    <?php $cell_val = isset($all_values[$current]) ? $all_values[$current] : ''; ?>
                                                                    
                                                                    <?php 
                                                                        $class = '';
                                                                        if(!empty($cell_val)) {
                                                                            if(!empty($checkpoint['lsl']) && $cell_val < $checkpoint['lsl']) {
                                                                                $class = 'danger ng-cell';
                                                                            }
                                                                            
                                                                            if(!empty($checkpoint['usl']) && $cell_val > $checkpoint['usl']) {
                                                                                $class = 'danger ng-cell';
                                                                            }
                                                                        } else {
                                                                            $class = ($freq_remaining) ? '' :'timecheck-required';
                                                                            if(($i+1) == $frequency) {
                                                                                $class = 'timecheck-required';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    
                                                                    
                                                                    <td class="<?php echo $class; ?>">
                                                                        <input type="text" class="form-control input-sm timecheck-result-input" onkeydown="return int_n_float_only();" name="values[<?php echo $checkpoint['id']; ?>][<?php echo $s; ?>]" value="<?php echo $cell_val; ?>">
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <?php $selected = isset($all_results[$current]) ? $all_results[$current] : 'OK'; ?>
                                                                    
                                                                    <?php $class = ($selected == 'NG') ? 'danger ng-cell' : ''; ?>
                                                                    
                                                                    <td class="<?php echo $class; ?>">
                                                                        <select class="form-control input-sm timecheck-result-sel" name="result[<?php echo $checkpoint['id']; ?>][<?php echo $s; ?>]">
                                                                            <option value="OK" <?php if($selected == 'OK') { ?>selected="selected"<?php } ?>>OK</option>
                                                                            <option value="NG" <?php if($selected == 'NG') { ?>selected="selected"<?php } ?>>NG</option>
                                                                        </select>
                                                                    </td>
                                                                <?php } ?>
                                                                
                                                                <?php $last_allowed_freq = $i; ?>
                                                            <?php } else { ?>
                                                                <td>
                                                                    <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                                                                        <?php echo !empty($all_values[$current]) ? $all_values[$current].' '.$checkpoint['unit'] : ''; ?>
                                                                    <?php } else { ?>
                                                                        <?php echo !empty($all_results[$current]) ? $all_results[$current] : ''; ?>
                                                                    <?php } ?>
                                                                </td>
                                                            <?php } ?>
                                                            
                                                        <?php } ?>
                                                        <?php $current++; ?>
                                                    <?php } ?>
                                                    
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        
                                        <tr>
                                            <td colspan="11" class="text-right">Production Quantity</td>
                                            
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <?php if($allowed[$i] == 'Yes' && !isset($production_qties[$i+1]) && $last_allowed_freq == $i) { ?>
                                                    <td colspan="<?php echo $sample_qty; ?>" class="text-center timecheck-required">
                                                        <input type="text" class="form-control input-sm timecheck-result-input" onkeydown="return int_n_float_only();" name="production_qty">
                                                    </td>
                                                <?php } else { ?>
                                                    <td colspan="<?php echo $sample_qty; ?>"><?php echo isset($production_qties[$i+1]) ? $production_qties[$i+1] : ''; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="11">&nbsp;</td>
                                            
                                            <?php for($i = 0; $i < $frequency; $i++) { ?>
                                                <?php if($allowed[$i] == 'Yes' && !isset($freq_results[$i+1]) && $last_allowed_freq == $i) { ?>
                                                    <input type="hidden" value=" <?php echo $i+1;?>" name="current_frequency" />
                                                    <td colspan="<?php echo $sample_qty; ?>" class="text-center">
                                                        <button type="submit" id="timecheck-save-button" class="button small observation-modal-btn" data-index="<?php echo $i; ?>">
                                                            Save Result
                                                        </button>
                                                    </td>
                                                <?php } else { ?>
                                                    <td colspan="<?php echo $sample_qty; ?>">&nbsp;</td>
                                                <?php } ?>
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
