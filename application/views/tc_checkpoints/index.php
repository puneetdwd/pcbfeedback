<style>
    .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    
</style>

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
            <li class="active">Manage Checkpoints</li>
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
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Checkpoints - <?php echo $product['name'];?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."tc_checkpoints/add_checkpoint"; ?>">
                            <i class="fa fa-plus"></i> Add New Checkpoint
                        </a>

                        <a class="button normals btn-circle" href="<?php echo base_url()."tc_checkpoints/upload_checkpoints"; ?>">
                            <i class="fa fa-plus"></i> Upload Checkpoints
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($checkpoints)) { ?>
                        <p class="text-center">No Checkpoints.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Part</th>
                                        <th>Child Part No.</th>
                                        <th>Child Part Name</th>
                                        <th>Mold</th>
                                        <th>Stage</th>
                                        <th>Insp. Item</th>
                                        <th>Spec.</th>
                                        <th>Instrument</th>
                                        <th>LSL</th>
                                        <th>USL</th>
                                        <th>TGT</th>
                                        <th>Sample Qty</th>
                                        <th>Frequency</th>
                                        <th>Status</th>
                                        <th class="no_sort" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($checkpoints as $checkpoint) { ?>
                                        <tr class="checkpoint-<?php echo $checkpoint['id']; ?>">
                                            <td><?php echo $checkpoint['checkpoint_no']; ?></td>
                                            <td><?php echo $checkpoint['part_no']; ?></td>
                                            <td><?php echo $checkpoint['child_part_no']; ?></td>
                                            <td><?php echo $checkpoint['child_part_name']; ?></td>
                                            <td><?php echo $checkpoint['mold_no']; ?></td>
                                            <td><?php echo $checkpoint['stage']; ?></td>
                                            <td><?php echo $checkpoint['instrument']; ?></td>
                                            <td><?php echo $checkpoint['insp_item']; ?></td>

                                            <td><?php echo $checkpoint['spec']; ?></td>
                                            <td nowrap>
                                                <?php echo ($checkpoint['lsl']) ? $checkpoint['lsl'].' '.$checkpoint['unit'] : ''; ?>
                                            </td>
                                            <td nowrap>
                                                <?php echo ($checkpoint['usl']) ? $checkpoint['usl'].' '.$checkpoint['unit'] : ''; ?>
                                            </td>
                                            <td nowrap>
                                                <?php echo ($checkpoint['tgt']) ? $checkpoint['tgt'].' '.$checkpoint['unit'] : ''; ?>
                                            </td>
                                            <td><?php echo $checkpoint['sample_qty']; ?></td>
                                            <td><?php echo $checkpoint['frequency'].' hours'; ?></td>
                                            <td nowrap>
                                                <?php if($checkpoint['status'] == NULL){ echo "Pending"; } else { echo $checkpoint['status']; } ?>
                                            </td>
                                            <td nowrap class="text-center">
                                                <a class="button small gray" href="<?php echo base_url()."tc_checkpoints/add_checkpoint/".$checkpoint['id']; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <a class="btn btn-outline btn-xs sbold red-thunderbird" href="<?php echo base_url()."tc_checkpoints/delete_checkpoint/".$checkpoint['id']; ?>" data-confirm="Are you sure you want to delete this checkpoint?">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
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
