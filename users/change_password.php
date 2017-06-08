<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View User
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Change Password</li>
        </ol>
        
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Change Password Form
                    </div>
                </div>

                <div class="portlet-body form" id="change-password-portlet">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label" for="old">Old Password
                                <span class="required">*</span></label>
                                <input type="password" class="required form-control" name="old"/>
                                <span class="help-block">
                                </span>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="new">New Password
                                <span class="required">*</span></label>
                                <input type="password" id="new-password" class="required form-control" name="new"/>
                                <span class="help-block">
                                </span>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="confirm_password">Confirm Password
                                <span class="required">*</span></label>
                                <input type="password" class="required form-control" name="confirm_password"/>
                                <span class="help-block">
                                </span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url(); ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>