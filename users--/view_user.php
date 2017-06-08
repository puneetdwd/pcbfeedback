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
            <li>
                <a href="<?php echo base_url()."users"; ?>">Manage Users</a>
            </li>
            <li class="active">View User</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> View User - <?php echo $user['first_name'].' '.$user['last_name']; ?>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">First Name:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['first_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Last Name:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['last_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Username:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['username']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">User Type:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['user_type']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <?php if(!$this->product_id) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Product:</label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    <?php echo $user['product_name']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Active:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['is_active'] ? 'True': 'False' ; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a href="<?php echo base_url().'users'; ?>" class="button white">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>

                                            <a class="button" 
                                                href="<?php echo base_url()."users/add/".$user['username'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>