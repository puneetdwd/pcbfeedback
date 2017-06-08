<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($lg_repair_user) ? 'Edit': 'Add'); ?> LG Repair User
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."lg_repair_users"; ?>">
                        Manage LG Repair User
                    </a>
            </li>
            <li class="active"><?php echo (isset($lg_repair_user) ? 'Edit': 'Add'); ?> LG Repair User</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> LG Repair User Form
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

                            <?php if(isset($lg_repair_user['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $lg_repair_user['id']; ?>" />
                            <?php } ?>
                            
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">LG Repair User Code:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="lg_repair_user_no"
                                        value="<?php echo isset($lg_repair_user['supplier_no']) ? $lg_repair_user['supplier_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">LG Repair User Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name"
                                        value="<?php echo isset($lg_repair_user['name']) ? $lg_repair_user['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">LG Repair User Email:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="email"
                                        value="<?php echo isset($lg_repair_user['email']) ? $lg_repair_user['email'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'lg_repair_users'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>