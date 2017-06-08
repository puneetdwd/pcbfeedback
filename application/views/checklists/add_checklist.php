<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($checklist) ? 'Edit': 'Add'); ?> Checklist
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."checklist"; ?>">
                    Manage Checklists
                </a>
            </li>
            <li class="active"><?php echo (isset($checklist) ? 'Edit': 'Add'); ?> Checklist</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Checklist
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
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

                            <?php if(isset($checklist['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $checklist['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="item_no">Item No:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="item_no"
                                        value="<?php echo isset($checklist['item_no']) ? $checklist['item_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="list_item">Checklist:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="list_item"
                                        value="<?php echo isset($checklist['list_item']) ? $checklist['list_item'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'checklist'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>