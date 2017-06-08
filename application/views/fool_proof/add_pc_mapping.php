<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($checkpoint) ? 'Edit': 'Add'); ?> Part-Checkpoint Mapping
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."fool_proof"; ?>">
                    Manage Part-Checkpoint Mapping
                </a>
            </li>
            <li class="active"><?php echo (isset($checkpoint) ? 'Edit': 'Add'); ?> Part-Checkpoint Mapping</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Part-Checkpoint Mapping Form
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
                                        <select name="stage" class="form-control required select2me" data-placeholder="Select Stage" data-error-container="#report-sel-part-error" style="width:300px !important;">
                                        <option></option>
                                        <?php foreach($stages as $stage) { ?>
                                            <option value="<?php echo $stage['stage']; ?>" <?php if($stage['stage'] == @$mapping['stage']) { ?> selected="selected" <?php } ?>>
                                                <?php echo $stage['stage']; ?>
                                            </option>
                                        <?php } ?>        
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="sub_stage">Sub Stage:
                                        <span class="required">*</span></label>
                                        <select name="sub_stage" class="form-control required select2me" data-placeholder="Select Sub Stage" data-error-container="#report-sel-part-error" style="width:300px !important;">
                                        <option></option>
                                        <?php foreach($sub_stages as $sub_stage) { ?>
                                            <option value="<?php echo $sub_stage['sub_stage']; ?>" <?php if($sub_stage['sub_stage'] == @$mapping['sub_stage']) { ?> selected="selected" <?php } ?>>
                                                <?php echo $sub_stage['sub_stage']; ?>
                                            </option>
                                        <?php } ?>        
                                        </select>
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
                                        <select name="major_control_parameters" class="form-control required select2me" data-placeholder="Select Major Control Parameter" data-error-container="#report-sel-part-error" style="width:300px !important;">
                                        <option></option>
                                        <?php foreach($mcps as $mcp) { ?>
                                            <option value="<?php echo $mcp['major_control_parameters']; ?>" <?php if($mcp['major_control_parameters'] == @$mapping['major_control_parameters']) { ?> selected="selected" <?php } ?>>
                                                <?php echo $mcp['major_control_parameters']; ?>
                                            </option>
                                        <?php } ?>        
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="part_id">Part:
                                        <span class="required">*</span></label>
                                        <select name="part_id" class="form-control required select2me" data-placeholder="Select Part" data-error-container="#report-sel-part-error" style="width:300px !important;">
                                        <option></option>
                                        <?php foreach($parts as $part) { ?>
                                            <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == @$mapping['part_id']) { ?> selected="selected" <?php } ?>>
                                                <?php echo $part['name'].' ('.$part['part_no'].')'; ?>
                                            </option>
                                        <?php } ?>        
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'fool_proof/pc_mappings'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>