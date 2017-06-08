<style>
    .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    label.cameraButton {
        display: inline-block;
        /*margin: 1em 0;*/

        /* Styles to make it look like a button */
        padding: 0.2em 0.3em;
        border: 2px solid #666;
        border-color: #EEE #CCC #CCC #EEE;
        background-color: #DDD;
    }

      /* Look like a clicked/depressed button */
    label.cameraButton:active {
        border-color: #CCC #EEE #EEE #CCC;
    }

    /* This is the part that actually hides the 'Choose file' text box for camera inputs */
    label.cameraButton input[accept*="image"] {
        display: none;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Fool-Proof Audit
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Fool-Proof Audit</li>
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
                        <i class="fa fa-reorder"></i>Checkpoints
                    </div>
                    <div class="actions">
                        <?php echo "Audit Date : ".date('d-m-Y'); ?>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($checkpoints)) { ?>
                        <p class="text-center">No Checkpoints.</p>
                    <?php } else { ?>
                        <form method="post" action="<?php echo base_url().'fool_proof/save_result'; ?>" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align:middle">Sr.No.</th>
                                            <th rowspan="2" style="vertical-align:middle">Stage</th>
                                            <th rowspan="2" style="vertical-align:middle">Sub Stage</th>
                                            <th rowspan="2" style="vertical-align:middle">Major Control Parameter</th>
                                            <th rowspan="2" style="vertical-align:middle">Frequency</th>
                                            <th rowspan="2" style="vertical-align:middle">Measuring Equipment</th>
                                            <th rowspan="2" style="vertical-align:middle">UOM</th>
                                            <th rowspan="2" style="vertical-align:middle">LSL</th>
                                            <th rowspan="2" style="vertical-align:middle">TGT</th>
                                            <th rowspan="2" style="vertical-align:middle">USL</th>
                                            <th rowspan="2" style="vertical-align:middle; width: 100px;">Result</th>
                                            <th rowspan="2" style="vertical-align:middle">Photo</th>
                                            <th rowspan="2" style="vertical-align:middle">No Production</th>
                                            <th rowspan="2" style="vertical-align:middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($checkpoints as $k => $checkpoint) { 
                                            $saved = array();
                                            $date = date('Y-m-d');
                                            
                                            $saved = $this->foolproof_model->saved_checkpoint($checkpoint['id'], $date, $this->supplier_id);
                                            
                                            //print_r($saved); exit;
                                            ?>
                                            <tr class="checkpoint-<?php echo $checkpoint['id']; ?>">
                                                <td style="vertical-align:middle"><?php echo $k+1; ?></td>
                                                <td style="vertical-align:middle"><?php echo $checkpoint['stage']; ?></td>
                                                <td style="vertical-align:middle"><?php echo $checkpoint['sub_stage']; ?></td>
                                                <td style="vertical-align:middle"><?php echo $checkpoint['major_control_parameters']; ?></td>
                                                <td style="vertical-align:middle"><?php echo $checkpoint['cycle'].' Days'; ?></td>
                                                <td style="vertical-align:middle"><?php echo $checkpoint['measuring_equipment']; ?></td>
                                                <td nowrap style="vertical-align:middle">
                                                    <?php echo $checkpoint['unit']; ?>
                                                </td>
                                                <td nowrap style="vertical-align:middle">
                                                    <?php echo $checkpoint['lsl']; ?>
                                                    <input type="hidden" id="lsl_<?php echo $checkpoint['id']; ?>" 
                                                           value="<?php echo $checkpoint['lsl']; ?>" />
                                                </td>
                                                <td nowrap style="vertical-align:middle">
                                                    <?php echo $checkpoint['tgt']; ?>
                                                    <input type="hidden" id="tgt_<?php echo $checkpoint['id']; ?>" 
                                                           value="<?php echo $checkpoint['tgt']; ?>" />
                                                </td>
                                                <td nowrap style="vertical-align:middle">
                                                    <?php echo $checkpoint['usl']; ?>
                                                    <input type="hidden" id="usl_<?php echo $checkpoint['id']; ?>" 
                                                           value="<?php echo $checkpoint['usl']; ?>" />
                                                </td>
                                                
                                                <?php 
                                                    @$all_results = $saved['all_results'];
                                                    @$all_values = $saved['all_values'];
                                                    $current = 0;
                                                ?>
                                                <?php //for($i = 0; $i < @$frequency; $i++) { ?>
                                                    <?php //for($s = 1; $s <= $sample_qty; $s++) { ?>
                                                        
                                                        <?php /*if($s > $checkpoint['sample_qty']) { ?>
                                                            <td></td>
                                                        <?php } else { */ ?>
                                                            <td class="text-center" style="vertical-align:middle">
                                                                <?php if(empty($saved)) { ?>
                                                                    <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { 
                                                                            //$input_id = "values_".$checkpoint['id'];
                                                                        ?>
                                                                        <input type="text" class="form-control input-sm" onkeydown="return int_n_float_only();" 
                                                                               name="values_<?php echo $checkpoint['id']; ?>" onblur="return ng_check(<?php echo $checkpoint['id']; ?>)"
                                                                               id="values_<?php echo $checkpoint['id']; ?>" value="<?php echo isset($all_values) ? $all_values : ''; ?>">
                                                                    <?php } else { 
                                                                            //$input_id = "result_".$checkpoint['id'];
                                                                        ?>
                                                                        <?php $selected = isset($all_results) ? $all_results : ''; ?>
                                                                        <select class="form-control input-sm" name="result_<?php echo $checkpoint['id']; ?>" 
                                                                                onchange="return ng_check(<?php echo $checkpoint['id']; ?>);" id="result_<?php echo $checkpoint['id']; ?>">
                                                                            <option value="OK" <?php if($selected == 'OK') { ?>selected="selected"<?php } ?>>OK</option>
                                                                            <option value="NG" <?php if($selected == 'NG') { ?>selected="selected"<?php } ?>>NG</option>
                                                                        </select>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                                                                        <?php echo isset($all_values) ? $all_values : ''; ?>
                                                                    <?php } else { ?>
                                                                        <?php echo isset($all_results) ? $all_results : ''; ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            
                                                            <td class="text-center" style="vertical-align:middle">
                                                                <?php if(empty($saved)) { ?>
                                                                <label class="cameraButton">Take&nbsp;Photo
                                                                    <input type="file" accept="image/*" id="capture_<?php echo $checkpoint['id']; ?>" capture="camera">  
                                                                </lable>
                                                                <?php }else if($all_results == 'NP' || $all_values == 'NP'){ echo 'NP'; }
                                                                else{ ?>
                                                                <img src="<?php echo base_url()."assets/foolproof_captured/".$saved['image'];?>"
                                                                     alt="image" height="70" width="100" />
                                                                <?php } ?>
                                                            </td>
                                                            
                                                            <td class="text-center" style="vertical-align:middle">
                                                                <?php 
                                                                    if(!empty($saved)){
                                                                        $readonly = "disabled";
                                                                        if($saved['result'] == 'NP'){
                                                                            $chkd = "checked='checked'";
                                                                        }else{
                                                                            $chkd = "";
                                                                        }
                                                                    }else{
                                                                        $chkd = "";
                                                                        $readonly = "";
                                                                    }
                                                                ?>
                                                                <input type="checkbox" value="NP" id="np_<?php echo $checkpoint['id']; ?>" <?php echo $chkd.' '.$readonly; ?> />
                                                            </td>
                                                            
                                                            <td class="text-center" style="vertical-align:middle">
                                                                <?php if(empty($saved)){ ?>
                                                                <button type="button" id="button_<?php echo $checkpoint['id']; ?>" 
                                                                        class="button small observation-modal-btn" 
                                                                        onclick="return save_foolproof_data(<?php echo $checkpoint['id']; ?>)">
                                                                    Save Result
                                                                </button>
                                                                <?php } ?>
                                                            </td>
                                                            <?php //$current++; ?>
                                                        <?php //} ?>
                                                    <?php //} ?>
                                                <?php //} ?>
                                            </tr>
                                        <?php } ?>
                                        
                                        <tr>
                                            <td colspan="14">&nbsp;</td>
                                            
                                            <?php /*for($i = 0; $i < $frequency; $i++) { ?>
                                                <?php if($allowed[$i] == 'Yes') { ?>
                                                    <input type="hidden" value=" <?php echo $i+1;?>" name="current_frequency" />
                                                    <td colspan="<?php echo $sample_qty; ?>" class="text-center">
                                                        <button type="submit" class="button small observation-modal-btn" data-index="<?php echo $i; ?>">
                                                            Save Result
                                                        </button>
                                                    </td>
                                                <?php } else { ?>
                                                    <td colspan="<?php echo $sample_qty; ?>">&nbsp;</td>
                                                <?php } ?>
                                            <?php } */ ?>
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
