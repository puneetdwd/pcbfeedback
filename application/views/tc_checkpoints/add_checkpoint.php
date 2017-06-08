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
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="report-sel-part-error">
                                        <label class="control-label">Select Part:</label>
                                                
                                        <select name="part_id" class="form-control select2me"
                                            data-placeholder="Select Part" data-error-container="#report-sel-part-error">
                                            <option></option>
                                            <?php $sel_part = isset($checkpoint['part_id']) ? $checkpoint['part_id'] : ''; ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $sel_part) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stage">Stage:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" required="" name="stage" value="<?php echo isset($checkpoint['stage']) ? $checkpoint['stage'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stage">Child Part No.
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" required="" name="child_part_no" value="<?php echo isset($checkpoint['child_part_no']) ? $checkpoint['child_part_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stage">Child Part Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" required="" name="child_part_name" value="<?php echo isset($checkpoint['child_part_name']) ? $checkpoint['child_part_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stage">Mold No.
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" required="" name="mold_no" value="<?php echo isset($checkpoint['mold_no']) ? $checkpoint['mold_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="insp_item">Insp Item</label>
                                        <textarea class="form-control" name="insp_item"><?php echo isset($checkpoint['insp_item']) ? $checkpoint['insp_item'] : ''; ?></textarea>
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
                                    <div class="form-group">
                                        <label class="control-label" for="sample_qty">Sample Qty:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="sample_qty"
                                        value="<?php echo isset($checkpoint['sample_qty']) ? $checkpoint['sample_qty'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="frequency">Frequency:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="frequency"
                                        value="<?php echo isset($checkpoint['frequency']) ? $checkpoint['frequency'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="measure_type">Measure Type:
                                        <span class="required">*</span></label>
                                        <select name="measure_type" class="form-control select2me"
                                            data-placeholder="Select Measure Type" data-error-container="#report-sel-part-error">
                                            <option></option>
                                            <option value="Discrete" <?php if($checkpoint['measure_type'] == 'Discrete') { ?> selected="selected" <?php } ?>>
                                                Discrete
                                            </option>
                                            <option value="Continuous" <?php if($checkpoint['measure_type'] == 'Continuous') { ?> selected="selected" <?php } ?>>
                                                Continuous
                                            </option>
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="instrument">Instrument:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="instrument"
                                        value="<?php echo isset($checkpoint['instrument']) ? $checkpoint['instrument'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'checkpoints'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>