user
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage LG Users
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage LG Users</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="fa fa-times"></i>
                   <?php echo $this->session->flashdata('error');?>
                </div>
            <?php } else if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                   <?php echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>LG Users
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."lg_users/add_lg_users"; ?>">
                            <i class="fa fa-plus"></i> Add New LG Users
                        </a>
                        
                        <a class="button normals btn-circle" href="<?php echo base_url()."lg_users/upload_lg_users"; ?>">
                            <i class="fa fa-plus"></i> Upload LG Users
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($suppliers)) { ?>
                        <p class="text-center">No LG Users.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Users Code</th>
                                    <th>Users Name</th>
                                    <th>Users Email</th>
                                    <th class="no_sort">Is User</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>