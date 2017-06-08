<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Users
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Masters</li>
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
                        <i class="fa fa-reorder"></i>List of Users
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."suppliers/add_pcb_user"; ?>">
                            <i class="fa fa-plus"></i> Add New PCB User
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($users)) { ?>
                        <p class="text-center">No User exist yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th class="no_sort">Active</th>
                                    <th class="no_sort" style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) { ?>
                                    <tr>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo ($user['is_active'] ? '<i class="fa fa-check"></i>': '<i class="fa fa-times"></i>'); ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."suppliers/add_inspector/".$user['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."suppliers/view_inspector/".$user['id'];?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to mark this user as <?php echo $user['is_active'] ? 'inactive' : 'active';?>?"
                                                href="<?php echo base_url()."suppliers/inspector_status/".$user['id'].'/'.($user['is_active'] ? 'inactive' : 'active' );?>">
                                                <i class="fa fa-trash-o"></i> <?php echo $user['is_active'] ? 'Mark Inactive' : 'Mark Active';?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
