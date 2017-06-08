<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($excluded_checkpoint) ? 'Edit': 'Add'); ?> Exclude Checkpoints
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."checkpoints/excluded_checkpoints"; ?>">
                    Manage Checkpoints
                </a>
            </li>
            <li class="active"><?php echo (isset($excluded_checkpoint) ? 'Edit': 'Add'); ?> Exclude Checkpoints</li>
        </ol>
        
    </div>
    
    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered excluded_checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Exclude Checkpoint Form
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

                            <?php if(isset($excluded_checkpoint['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $excluded_checkpoint['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="exclude-checkpoint-part-error">
                                        <label class="control-label">Select Part:
                                            <span class="required"> * </span>
                                        </label>
                                                
                                        <select name="part_id" class="form-control required select2me"
                                            data-placeholder="Select Part" data-error-container="#exclude-checkpoint-part-error">
                                            <option value=""></option>
                                            <?php $sel_part = (!empty($excluded_checkpoint['part_id']) ? $excluded_checkpoint['part_id'] : ''); ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>"
                                                <?php if($sel_part == $part['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if(empty($checkpoints)) { ?>
                                <p class="text-center">No Checkpoints.</p>
                            <?php } else { ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-light table-checkable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Checkpoint No.</th>
                                                <th>Insp. Item</th>
                                                <th>Insp. Item</th>
                                                <th>Insp. Item</th>
                                                <th>Spec.</th>
                                                <th>LSL</th>
                                                <th>USL</th>
                                                <th>TGT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $existing = isset($excluded_checkpoint['checkpoints_ids']) ? explode(',', $excluded_checkpoint['checkpoints_ids']) : array(); ?>
                                            <?php foreach($checkpoints as $checkpoint) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="checkboxes" name="checkpoints_ids[]" value="<?php echo $checkpoint['id']; ?>" 
                                                        <?php if(in_array($checkpoint['id'], $existing)) { ?> checked="checked" <?php } ?>
                                                        />
                                                    </td>
                                                    <td><?php echo $checkpoint['checkpoint_no']; ?></td>
                                                    <td><?php echo $checkpoint['insp_item']; ?></td>
                                                    <td><?php echo $checkpoint['insp_item2']; ?></td>
                                                    <td><?php echo $checkpoint['insp_item3']; ?></td>
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
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'checkpoints/excluded_checkpoints'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>