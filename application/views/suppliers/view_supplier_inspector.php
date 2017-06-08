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
                <a href="<?php echo base_url()."suppliers/view"; ?>">Manage Inspectors</a>
            </li>
            <li class="active">View Inspector</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> View Inspectors - <?php echo $user['name']; ?>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Name:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo $user['name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">User Type:</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php echo 'Inspector'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <?php /*if(!$this->product_id) { ?>
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
                                <?php }*/ ?>
                                
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
                                            <a href="<?php echo base_url().'suppliers/view'; ?>" class="button white">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>

                                            <a class="button" 
                                                href="<?php echo base_url()."suppliers/add_inspector/".$user['id'];?>">
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