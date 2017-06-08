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

                <div class="form-group" id="report-sel-part-error">
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
                <button class="button" type="submit">Search</button>
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
                    <!--<div class="caption">
                        <i class="fa fa-reorder"></i>Checkpoints - <?php echo $product['name'];?>
                    </div>-->
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."fool_proof/add_pc_mapping"; ?>">
                            <i class="fa fa-plus"></i> Add New Mapping
                        </a>
                        
                        <a class="button normals btn-circle" href="<?php echo base_url()."fool_proof/upload_pc_mappings"; ?>">
                            <i class="fa fa-plus"></i> Upload Mappings
                        </a>
                        
                        <?php /*if($this->user_type !== 'Supplier' && false) { ?>
                            <a class="button normals btn-circle" href="<?php echo base_url()."checkpoints/view_revision_history/"; ?>">
                                <i class="fa fa-eye"></i> View Revisions
                            </a>
                        <?php }*/ ?>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($mappings)) { ?>
                        <p class="text-center">No Checkpoints.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th class="text-center">Part Number</th>
                                        <th class="text-center">Part Name</th>
                                        <th>Stage</th>
                                        <th>Sub Stage</th>
                                        <th>Major Control Parameters</th>
                                        <th>LSL</th>
                                        <th>USL</th>
                                        <th>TGT</th>
                                        <th>UOM</th>
                                        <th>Status</th>
                                        <th>Deleted</th>
                                        <th class="no_sort" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach($mappings as $mapping) { ?>
                                    
                                        <tr class="checkpoint-<?php echo $mapping['id']; ?>">
                                            <td><?php echo $mapping['part_no']; ?></td>
                                            <td><?php echo $mapping['part_name'] ? $mapping['part_name'] : '--'; ?></td>
                                            <td><?php echo $mapping['stage']; ?></td>
                                            <td><?php echo $mapping['sub_stage']; ?></td>
                                            <td><?php echo $mapping['major_control_parameters']; ?></td>
                                            <td><?php echo $mapping['lsl']; ?></td>
                                            <td><?php echo $mapping['usl']; ?></td>
                                            <td><?php echo $mapping['tgt']; ?></td>
                                            <td><?php echo $mapping['unit']; ?></td>
                                            <td nowrap>
                                                <?php if($mapping['status'] == NULL && $this->user_type === 'Supplier'){ echo "Pending";}else{ echo $mapping['status'];} ?>
                                            </td>
                                            <td><?php if($mapping['is_deleted'] == 0) echo 'No'; else echo 'Yes'; ?></td>
                                            <td nowrap class="text-center">
                                                <?php if($this->user_type === 'Supplier' && $mapping['status'] == NULL) { ?>
                                                    <a class="button small gray" href="<?php echo base_url()."fool_proof/add_pc_mapping/".$mapping['id']; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <a class="btn btn-outline btn-xs sbold red-thunderbird" href="<?php echo base_url()."fool_proof/delete_pc_mapping/".$mapping['id']; ?>" data-confirm="Are you sure you want to delete this checkpoint?">
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
