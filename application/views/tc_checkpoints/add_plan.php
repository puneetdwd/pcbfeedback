<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($plan) ? 'Edit': 'Add'); ?> Add Plan
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."tc_checkpoints/plans"; ?>">
                    Manage Plans
                </a>
            </li>
            <li class="active"><?php echo (isset($plan) ? 'Edit': 'Add'); ?> Inspection Item</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered plan-add-form-portlet" id="plan-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Add Plan Form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" id="add-plan-form" class="validate-form" method="post">
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
                                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Plan Date:
                                        <span class="required"> * </span></label>
                                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" data-date-end-date="+7d">
                                            <input id="audit_date" name="plan_date" type="text" class="required form-control" readonly
                                            value="<?php echo isset($plan['plan_date']) ? $plan['plan_date'] : date('Y-m-d'); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <?php if(!isset($plan)) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">&nbsp;</label>
                                            <div>
                                                <button type="button" id="add-more-plan" class="button normals btn-circle">
                                                    <i class="fa fa-plus"></i> Add More Plan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row timecheck-row">
                                <div class="col-md-4">
                                    <div class="form-group" id="report-sel-part-error">
                                        <label class="control-label">Select Part:
                                        <span class="required"> * </span></label>
                                                
                                        <select name="part_id" class="timecheck-part-sel required form-control select2me" data-placeholder="Select Part" data-error-container="#report-sel-part-error">
                                            <option></option>
                                            <?php $sel_part = isset($plan['part_id']) ? $plan['part_id'] : ''; ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $sel_part) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name'].' ('.$part['part_no'].')'; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group" id="report-sel-child-part-error">
                                        <label class="control-label">Select Child Part:
                                        <span class="required"> * </span></label>

                                        <select name="child_part_no" class="timecheck-child-part-sel required form-control select2me" data-placeholder="Select Child Part" data-error-container="#report-sel-child-part-error">
                                            <option></option>
                                            <?php $sel_child_part = isset($plan['child_part_no']) ? $plan['child_part_no'] : ''; ?>
                                            <?php foreach($child_parts as $child_part) { ?>
                                                <option value="<?php echo $child_part['child_part_no']; ?>" <?php if($child_part['child_part_no'] == $sel_child_part) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $child_part['child_part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="report-mold-number-error">
                                        <label class="control-label">Select Mold No.:
                                        <span class="required"> * </span></label>

                                        <select name="mold_no" class="timecheck-mold-sel required form-control select2me" data-placeholder="Select Mold Number" data-error-container="#report-mold-number-error">
                                            <option></option>
                                            <?php $sel_mold_no = isset($plan['mold_no']) ? $plan['mold_no'] : ''; ?>
                                            <?php foreach($mold_nos as $mold_no) { ?>
                                                <option value="<?php echo $mold_no['mold_no']; ?>" <?php if($mold_no['mold_no'] == $sel_mold_no) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $mold_no['mold_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>

                                <div style="clear:both"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">From Time:
                                        <span class="required"> * </span></label>
                                        <div class="input-group">
                                            <input type="text" name="from_time" class="required form-control timepicker timepicker-no-seconds" readonly
                                            value="<?php echo isset($plan['from_time']) ? $plan['from_time'] : date('Y-m-d'); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">To Time:
                                        <span class="required"> * </span></label>
                                        <div class="input-group">
                                            <input type="text" name="to_time" class="required form-control timepicker timepicker-no-seconds" readonly
                                            value="<?php echo isset($plan['to_time']) ? $plan['to_time'] : date('Y-m-d'); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'plans'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<div class="row to-clone" style="display:none;">
    <div class="col-md-4">
        <div class="form-group" id="report-sel-part-error-idx">
            <label class="control-label">Select Part:
            <span class="required"> * </span></label>
                    
            <select name="part_id_idx" id="part_id_idx" class="timecheck-part-sel required form-control" data-placeholder="Select Part" data-error-container="#report-sel-part-error-idx">
                <option></option>
                <?php foreach($parts as $part) { ?>
                    <option value="<?php echo $part['id']; ?>">
                        <?php echo $part['name'].' ('.$part['part_no'].')'; ?>
                    </option>
                <?php } ?>        
            </select>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group" id="report-sel-child-part-error-idx">
            <label class="control-label">Select Child Part:
            <span class="required"> * </span></label>
                    
            <select name="child_part_no_idx" id="child_part_no_idx" class="timecheck-child-part-sel required form-control" data-placeholder="Select Child Part" data-error-container="#report-sel-child-part-error-idx">
                <option></option>
                <?php foreach($child_parts as $child_part) { ?>
                    <option value="<?php echo $child_part['child_part_no']; ?>">
                        <?php echo $child_part['child_part_no']; ?>
                    </option>
                <?php } ?>        
            </select>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group" id="report-mold-number-error-idx">
            <label class="control-label">Select Mold No.:
            <span class="required"> * </span></label>
                    
            <select name="mold_no_idx" id="mold_no_idx" class="timecheck-mold-sel required form-control" data-placeholder="Select Mold Number" data-error-container="#report-mold-number-error-idx">
                <option></option>
                <?php foreach($mold_nos as $mold_no) { ?>
                    <option value="<?php echo $mold_no['mold_no']; ?>">
                        <?php echo $mold_no['mold_no']; ?>
                    </option>
                <?php } ?>        
            </select>
        </div>
    </div>
    <div style="clear:both"></div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">From Time:
            <span class="required"> * </span></label>
            <div class="input-group">
                <input type="text" name="from_time_idx" class="required form-control timepicker timepicker-no-seconds" readonly>
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-clock-o"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">To Time:
            <span class="required"> * </span></label>
            <div class="input-group">
                <input type="text" name="to_time_idx" class="required form-control timepicker timepicker-no-seconds" readonly>
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-clock-o"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>