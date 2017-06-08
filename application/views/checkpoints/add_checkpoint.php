<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($checkpoint) ? 'Edit': 'Add'); ?> Inspection Item
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."checkpoints"; ?>">
                    Manage Inspection Item
                </a>
            </li>
            <li class="active"><?php echo (isset($checkpoint) ? 'Edit': 'Add'); ?> Inspection Item</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Inspection Item Form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" id="add-checkpoint-form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <input type="hidden" id="existing_checkpoints" value="<?php echo $existing_checkpoints; ?>">
                                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="checkpoint_no">Checkpoint No:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" id="add-checkpoint-no" name="checkpoint_no"
                                        value="<?php echo isset($checkpoint['checkpoint_no']) ? $checkpoint['checkpoint_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="report-sel-part-error">
                                        <label class="control-label">Select Part:</label>
                                                
                                        <select name="part_id" class="form-control select2me"
                                            data-placeholder="Select Part" data-error-container="#report-sel-part-error">
                                            <option></option>
                                            <?php $sel_part = isset($checkpoint['part_id']) ? $checkpoint['part_id'] : ''; ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $sel_part) { $matched_part = $part['part_no']; ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="insp_item">Insp Type:</label>
                                        <?php if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){ ?>
                                        
                                            <select name="insp_item" class="form-control select2me"
                                                data-placeholder="Select Inspection Type" data-error-container="#report-sel-part-error">
                                                <option></option>
                                                <?php $sel_insp_item = isset($checkpoint['insp_item']) ? $checkpoint['insp_item'] : ''; ?>
                                                <?php foreach($insp_types as $insp_type) { ?>
                                                    <option value="<?php echo $insp_type['insp_item']; ?>" <?php if($insp_type['insp_item'] == $sel_insp_item) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $insp_type['insp_item']; ?>
                                                    </option>
                                                <?php } ?>        
                                            </select>
                                        <?php }else{ ?>
                                        
                                            <input type="text" class="form-control" name="insp_item"
                                            value="<?php echo isset($checkpoint['insp_item']) ? $checkpoint['insp_item'] : ''; ?>">
                                        <?php } ?>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="insp_item2">Insp Item</label>
                                        <textarea class="form-control" name="insp_item2"><?php echo isset($checkpoint['insp_item2']) ? $checkpoint['insp_item2'] : ''; ?></textarea>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="spec">Spec:
                                        <span class="required">*</span></label>
                                        <textarea class="required form-control" name="spec"><?php echo isset($checkpoint['spec']) ? $checkpoint['spec'] : ''; ?></textarea>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="lsl">LSL:</label>
                                        <input type="text" class="form-control" name="lsl"
                                        value="<?php echo isset($checkpoint['lsl']) ? $checkpoint['lsl'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="usl">USL:</label>
                                        <input type="text" class="form-control" name="usl"
                                        value="<?php echo isset($checkpoint['usl']) ? $checkpoint['usl'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tgt">TGT:</label>
                                        <input type="text" class="form-control" name="tgt"
                                        value="<?php echo isset($checkpoint['tgt']) ? $checkpoint['tgt'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="unit">Unit:</label>
                                        <input type="text" class="form-control" name="unit"
                                        value="<?php echo isset($checkpoint['unit']) ? $checkpoint['unit'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="inspection-config-sel-type-error">
                                        <label class="control-label">Select Sampling Standard:
                                            <span class="required"> * </span>
                                        </label>

                                        <select id="inspection-config-sampling-type" name="sampling_type" class="form-control required select2me"
                                            data-placeholder="Select Type" data-error-container="#inspection-config-sel-type-error">
                                            <option></option>
                                            <?php $sampling_type = (!empty($inspection_config['sampling_type']) ? $inspection_config['sampling_type'] : ''); ?>

                                            <option value="Auto" <?php if($sampling_type == 'Auto') { ?> selected="selected" <?php } ?>>Auto(MIL STD - 105D)</option>
                                            <!--<option value="User Defined" <?php if($sampling_type == 'User Defined') { ?> selected="selected" <?php } ?>>User Defined</option>-->
                                            <option value="C=0" <?php if($sampling_type == 'C=0') { ?> selected="selected" <?php } ?>>C=0</option>
                                            <option value="Fixed" <?php if($sampling_type == 'Fixed') { ?> selected="selected" <?php } ?>>Fixed Samples</option>
                                        </select>
                                    </div>
                                </div>                                        
                            </div>
                            
                            <div class="row type-specific-div" id="type-auto-div" <?php if($sampling_type != 'Auto') { ?> style="display:none;" <?php } ?>>
                                <div class="col-md-6">
                                    <div class="form-group" id="inspection-config-sel-inspection-level-error">
                                        <label class="control-label">Inspection Level:
                                            <span class="required"> * </span>
                                        </label>
                                                
                                        <select name="inspection_level" class="form-control required select2me"
                                            data-placeholder="Select Inspection Level" data-error-container="#inspection-config-sel-inspection-level-error">
                                            <option></option>
                                            <?php $inspection_level = (!empty($inspection_config['inspection_level']) ? $inspection_config['inspection_level'] : ''); ?>
                                            
                                            <option value="S-1" <?php if($inspection_level == 'S-1') { ?> selected="selected" <?php } ?>>S-1</option>
                                            <option value="S-2" <?php if($inspection_level == 'S-2') { ?> selected="selected" <?php } ?>>S-2</option>
                                            <option value="S-3" <?php if($inspection_level == 'S-3') { ?> selected="selected" <?php } ?>>S-3</option>
                                            <option value="S-4" <?php if($inspection_level == 'S-4') { ?> selected="selected" <?php } ?>>S-4</option>
                                            <option value="1" <?php if($inspection_level == '1') { ?> selected="selected" <?php } ?>>1</option>
                                            <option value="2" <?php if($inspection_level == '2') { ?> selected="selected" <?php } ?>>2</option>
                                            <option value="3" <?php if($inspection_level == '3') { ?> selected="selected" <?php } ?>>3</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="inspection-config-sel-acceptable-quality-level-error">
                                        <label class="control-label">Acceptable Quality Level(AQL):
                                            <span class="required"> * </span>
                                        </label>
                                        
                                        <select name="acceptable_quality" class="form-control required select2me"
                                            data-placeholder="Select Acceptable Quality" data-error-container="#inspection-config-sel-acceptable-quality-error">
                                            <option></option>
                                            <?php $sel_acceptable_quality = (!empty($inspection_config['acceptable_quality']) ? $inspection_config['acceptable_quality'] : ''); ?>
                                            <?php foreach($acceptable_qualities as $acceptable_quality) { ?>
                                                <option value="<?php echo $acceptable_quality['quality']; ?>" <?php if($acceptable_quality['quality'] == $sel_acceptable_quality) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $acceptable_quality['quality']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                                
                            <div class="row type-specific-div" id="type-c0-div" <?php if($sampling_type != 'C=0') { ?> style="display:none;" <?php } ?> >
                                <div class="col-md-6">
                                    <div class="form-group" id="inspection-config-sel-acceptable-quality-level-error">
                                        <label class="control-label">Acceptable Quality Level(AQL):
                                            <span class="required"> * </span>
                                        </label>
                                        
                                        <select name="acceptable_quality1" class="form-control required select2me"
                                            data-placeholder="Select acceptable_quality" data-error-container="#inspection-config-sel-acceptable-quality-error">
                                            <option></option>
                                            <?php $sel_acceptable_quality = (!empty($inspection_config['acceptable_quality']) ? $inspection_config['acceptable_quality'] : ''); ?>
                                            <option value="0.65" <?php if($sel_acceptable_quality == '0.65') { ?> selected="selected" <?php } ?> >0.65</option>
                                            <option value="1.5" <?php if($sel_acceptable_quality == '1.5') { ?> selected="selected" <?php } ?> >1.5</option>
                                            <option value="2.5" <?php if($sel_acceptable_quality == '2.5') { ?> selected="selected" <?php } ?> >2.5</option>       
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row type-specific-div" id="type-fixed-div" <?php if($sampling_type != 'Fixed') { ?> style="display:none;" <?php } ?> >
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="sample_qty">Sample Qty:
                                            <span class="required"> * </span>
                                        </label>
                                        <input type="text" class="required form-control" name="sample_qty"
                                        value="<?php echo isset($inspection_config['sample_qty']) ? $inspection_config['sample_qty'] : ''; ?>">
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row type-specific-div" id="lot-size-div" <?php if($sampling_type != 'User Defined' && $sampling_type != 'Interval') { ?> style="display:none;" <?php } ?>>
                            
                                <input type="hidden" id="lot-index" value="<?php echo (!empty($config_range) ? count($config_range)+1 : 3); ?>" />
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend style="font-size: 14px;">Specify Range
                                            <button id="add-lot-range" class="button small gray pull-right" type="button">Add Range</button>
                                        </legend>
                                        
                                        <div class="row items">
                                            <?php if(empty($config_range)) { ?>
                                                <div class="lot-item lot-item-1">
                                                    <div class="col-md-6">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="lower_val[1]" value="" placeholder="Lower">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1" style="padding-top: 5px; padding-bottom: 5px;">
                                                            <span class="">to</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="higher_val[1]" value="" placeholder="Higher">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="no_of_samples[1]" value="" placeholder="# of Samples">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a class="btn btn-icon-only btn-outline red remove-lot-range" href="javascript:;">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="lot-item lot-item-2">
                                                    <div class="col-md-6">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="lower_val[2]" value="" placeholder="Lower">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1" style="padding-top: 5px; padding-bottom: 5px;">
                                                            <span class="">to</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="higher_val[2]" value="" placeholder="Higher">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="required form-control" name="no_of_samples[2]" value="" placeholder="# of Samples">
                                                                <span class="help-block">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a class="btn btn-icon-only btn-outline red remove-lot-range" href="javascript:;">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <?php foreach($config_range as $c_key => $c_range) { ?>
                                                    <div class="lot-item lot-item-<?php echo $c_key+1; ?>">
                                                        <div class="col-md-6">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" class="required form-control" name="lower_val[<?php echo $c_key+1; ?>]" value="<?php echo $c_range['lower_val']; ?>" placeholder="Lower">
                                                                    <span class="help-block">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" style="padding-top: 5px; padding-bottom: 5px;">
                                                                <span class="">to</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" class="required form-control" name="higher_val[<?php echo $c_key+1; ?>]" value="<?php echo ($c_range['higher_val']) ? $c_range['higher_val'] : 'over'; ?>" placeholder="Higher">
                                                                    <span class="help-block">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" class="required form-control" name="no_of_samples[<?php echo $c_key+1; ?>]" value="<?php echo $c_range['no_of_samples']; ?>" placeholder="# of Samples">
                                                                    <span class="help-block">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-icon-only btn-outline red remove-lot-range" href="javascript:;">
                                                                    <i class="fa fa-trash-o"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            
                            <?php if(isset($checkpoint['id'])) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="remark">Remark:
                                            <span class="required">*</span></label>
                                            <textarea class="form-control required" name="remark"></textarea>
                                            <span class="help-block">
                                                Add remark for updating this checkpoint.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        
                        <?php   if($checkpoint['part_id']){
                                    $cancel = "checkpoints?part_no=".$matched_part;
                                }else{
                                    $cancel = "checkpoints";
                                } 
                        ?>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().$cancel; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>