
<div class="page-content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Please Reset Your Password Here.
                    </div>
                </div>
                <?php if($this->session->flashdata('error')) {?>
                    <div class="alert alert-danger">
                       <i class="fa fa-ban"></i>
                       <?php echo $this->session->flashdata('error');?>
                    </div>
                <?php } else if($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check"></i>
                       <?php echo $this->session->flashdata('success');?>
                    </div>
                <?php } ?>
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
                                <label class="control-label" for="new">New Password
                                <span class="required">*</span></label>
                                <input type="password" id="new-password" class="required form-control" name="new_password"/>
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
                            <div class="col-md-offset-5">
                                <button class="btn green" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>