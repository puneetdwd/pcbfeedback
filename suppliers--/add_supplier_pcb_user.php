<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($user) ? 'Edit': 'Add'); ?> User
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."suppliers/view"; ?>">Manage Users</a>
            </li>
            <li class="active"><?php echo (isset($user) ? 'Edit': 'Add'); ?> User</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered user-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> PCB User form
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

                            <?php if(isset($user['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name" placeholder="Name *"
                                        value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                <?php if(isset($user['id'])) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password *" value="">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="password">Password
                                            <span class="required">*</span></label>
                                            <input type="password" class="required form-control" name="password" placeholder="Password *" value="">
                                            <span class="help-block">
                                            </span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email ID
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="email" placeholder="User ID *"
                                        value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'suppliers/view'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>