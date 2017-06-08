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
                <a href="<?php echo base_url()."fool_proof"; ?>">
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
                            <?php } else if($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i>
                                   <?php echo $this->session->flashdata('success');?>
                                </div>
                            <?php } ?>

                            <input type="hidden" id="existing_checkpoints" value="<?php echo $existing_checkpoints; ?>">

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stage">Stage:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="stage" required="required"
                                        value="<?php echo isset($checkpoint['stage']) ? $checkpoint['stage'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="sub_stage">Sub Stage:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="sub_stage" required="required"
                                            value="<?php echo isset($checkpoint['sub_stage']) ? $checkpoint['sub_stage'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="major_control_parameters">Major Control Parameter :
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="major_control_parameters" required="required"
                                            value="<?php echo isset($checkpoint['major_control_parameters']) ? $checkpoint['major_control_parameters'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="measuring_equipment">Measuring Equipment:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="measuring_equipment" required="required"
                                            value="<?php echo isset($checkpoint['measuring_equipment']) ? $checkpoint['measuring_equipment'] : ''; ?>">
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
                                        <label class="control-label" for="period">Period:</label>
                                        <input type="text" class="form-control" name="period1" readonly="readonly"
                                               value="Days" placeholder="Days">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="cycle">No. of Days:
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control required" name="cycle" required="required"
                                        value="<?php echo isset($checkpoint['cycle']) ? $checkpoint['cycle'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
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
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'fool_proof'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>