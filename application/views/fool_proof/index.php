<style>
    .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Fool Proof Checkpoints
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Fool Proof Checkpoints</li>
        </ol>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <form role="form" class="validate-form form-inline" method="get">

                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <!--<div class="form-group" id="report-sel-part-error">
                    <label class="control-label">Select Part:&nbsp;&nbsp;</label>
                            
                    <select name="part_no" class="form-control select2me" data-placeholder="Select Part" data-error-container="#report-sel-part-error" style="width:300px !important;">
                        <option></option>
                        <?php foreach($parts as $part) { ?>
                            <option value="<?php echo $part['part_no']; ?>" <?php if($part['part_no'] == $this->input->get('part_no')) { ?> selected="selected" <?php } ?>>
                                <?php echo $part['name'].' ('.$part['part_no'].')'; ?>
                            </option>
                        <?php } ?>        
                    </select>
                </div>
                &nbsp;&nbsp;
                <button class="button" type="submit">Search</button>-->
            </form>
        </div>
    </div>
    
    <div class="row" style="margin-top:15px;">
        
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
                        <i class="fa fa-reorder"></i>Fool Proof Checkpoints
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."fool_proof/add_checkpoint"; ?>">
                            <i class="fa fa-plus"></i> Add New Fool Proof Checkpoint
                        </a>
                        
                        <a class="button normals btn-circle" href="<?php echo base_url()."fool_proof/upload_checkpoints"; ?>">
                            <i class="fa fa-plus"></i> Upload Fool Proof Checkpoints
                        </a>
                        
                        <?php /*if($this->user_type !== 'Supplier' && false) { ?>
                            <a class="button normals btn-circle" href="<?php echo base_url()."checkpoints/view_revision_history/"; ?>">
                                <i class="fa fa-eye"></i> View Revisions
                            </a>
                        <?php }*/ ?>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($checkpoints)) { ?>
                        <p class="text-center">No Checkpoints.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-light" id="make-data-table">
                                <thead>
                                    <tr>
                                        <th>Stage</th>
                                        <th>Sub Stage</th>
                                        <th>Major Ctrl Param</th>
                                        <th>LSL</th>
                                        <th>USL</th>
                                        <th>TGT</th>
                                        <th>UOM</th>
                                        <th>Freq(Days)</th>
                                        <th>Status</th>
                                        <th>Deleted</th>
                                        <th class="no_sort" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($this->user_type !== 'Supplier') { ?>
                                        <tr class="warning">
                                            <td colspan="11">LG Checkpoints</td>
                                        </tr>
                                    <?php } ?>
                                    <?php $first = true; ?>
                                    <?php foreach($checkpoints as $checkpoint) { ?>
                                    
                                        <?php if($this->user_type !== 'Supplier' && $checkpoint['checkpoint_type'] == 'Supplier' && $first) { ?>
                                            <tr class="warning">
                                                <td colspan="11">Suppliers Checkpoints</td>
                                            </tr>
                                            <?php $first = false; ?>
                                        <?php } ?>
                                    
                                        <tr class="checkpoint-<?php echo $checkpoint['id']; ?>">
                                            <td><?php echo $checkpoint['stage']; ?></td>
                                            <td><?php echo $checkpoint['sub_stage']; ?></td>
                                            <td><?php echo $checkpoint['major_control_parameters']; ?></td>
                                            <td><?php echo $checkpoint['lsl']; ?></td>
                                            <td><?php echo $checkpoint['usl']; ?></td>
                                            <td><?php echo $checkpoint['tgt']; ?></td>
                                            <td><?php echo $checkpoint['unit']; ?></td>
                                            <td><?php echo $checkpoint['cycle']; ?></td>
                                            <td nowrap>
                                                <?php if($checkpoint['status'] == NULL && $this->user_type === 'Supplier'){ echo "Pending";}else{ echo $checkpoint['status'];} ?>
                                            </td>
                                            <td><?php if($checkpoint['is_deleted'] == 0) echo 'No'; else echo 'Yes'; ?></td>
                                            <td nowrap class="text-center">
                                                <?php if($this->user_type === 'Supplier') { ?>
                                                    <a class="button small gray" href="<?php echo base_url()."fool_proof/add_checkpoint/".$checkpoint['id']; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <a class="btn btn-outline btn-xs sbold red-thunderbird" href="<?php echo base_url()."fool_proof/delete_checkpoint/".$checkpoint['id']; ?>" data-confirm="Are you sure you want to delete this checkpoint?">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
