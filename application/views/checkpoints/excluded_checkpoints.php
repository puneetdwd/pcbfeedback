<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Checkpoints
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Excluded Checkpoints</li>
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
                        <i class="fa fa-reorder"></i>Excluded Checkpoints
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."checkpoints/exclude_checkpoint_form"; ?>">
                            <i class="fa fa-plus"></i> Add Excluded Checkpoints
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($excluded_checkpoints)) { ?>
                        <p class="text-center">No Record found.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Part Code</th>
                                    <th>Part Name</th>
                                    <th>Checkpoint NOs</th>
                                    <th class="no_sort" style="width:200px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($excluded_checkpoints as $excluded_checkpoint) { ?>
                                    <tr>
                                        <td><?php echo $excluded_checkpoint['part_code']; ?></td>
                                        <td><?php echo $excluded_checkpoint['part_name']; ?></td>
                                        <td><?php echo $excluded_checkpoint['checkpoints_nos']; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."checkpoints/exclude_checkpoint_form/".$excluded_checkpoint['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-outline btn-xs sbold red-thunderbird" data-confirm="Are you sure you want to this record?" 
                                                href="<?php echo base_url()."checkpoints/delete_exclude_checkpoint/".$excluded_checkpoint['id'];?>">
                                                <i class="fa fa-trash-o"></i> Delete
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