<style>
    .hiddenRow {
        padding:0px !important;
    }
    .hiddenRow .row {
        padding:8px !important;
    }
    .hiddenRow .form-group {
        margin-bottom:0px;
    }
</style>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    
    <div class="breadcrumbs">
        <h1>
            Sampling Configuration
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Supplier Inspection Items</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <div class="row">
        <!--<div class="col-md-3">
        
            <div class="portlet light bordered sampling-dashboard-search-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Filters
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="sampling-dashboard-inspection-error">
                                        <label class="control-label">Select Checkpoint:
                                            <span class="required"> * </span>
                                        </label>
                                                
                                        <select name="checkpoint_id" class="form-control required select2me"
                                            data-placeholder="Select Checkpoint" data-error-container="#sampling-dashboard-inspection-error">
                                            <option value="All">All</option>
                                            <?php $sel_checkpoint = $this->input->post('checkpoint_id'); ?>
                                            <?php foreach($checkpoints as $checkpoint) { ?>
                                                <option value="<?php echo $checkpoint['id']; ?>"
                                                <?php if($sel_checkpoint == $checkpoint['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $checkpoint['insp_item']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group" id="sampling-dashboard-line-error">
                                        <label class="control-label">Select Part Name:
                                        <span class="required"> * </span></label>
                                                
                                        <select name="part_name" class="required form-control select2me" id="part-selector"
                                            data-placeholder="Select Part Name" data-error-container="#sampling-dashboard-line-error">
                                            <option value="All">All</option>
                                            <?php $sel_part = $this->input->post('part_name'); ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['name'] == $sel_part) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group" id="sampling-dashboard-line-error">
                                        <label class="control-label">Select Part Number:
                                        <span class="required"> * </span></label>
                                                
                                        <select name="part_id" class="required form-control select2me" id="part-number-selector"
                                            data-placeholder="Select Part Number" data-error-container="#sampling-dashboard-line-error">
                                            <option value="All">All</option>
                                            <?php $sel_part = $this->input->post('part_id'); ?>
                                            <?php foreach($part_nums as $part_num) { ?>
                                                <option value="<?php echo $part_num['id']; ?>" <?php if($part_num['id'] == $sel_part) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part_num['code']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->
        
        <div class="col-md-12">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Supplier Inspection Items
                    </div>
                    
                    <div class="actions">
                        <!--<a class="button normals btn-circle" href="<?php echo base_url()."sampling/update_inspection_config"; ?>">
                            <i class="fa fa-plus"></i> Add Inspection Configuration
                        </a>
                        <a class="button normals btn-circle" href="<?php echo base_url()."sampling/sort_inspections"; ?>">
                            <i class="fa fa-plus"></i> Sort Inspections
                        </a>-->
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <?php if(!empty($approval_items)) { ?>
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr>
                                            <th>Supplier Name</th>
                                            <th>Product Name</th>
                                            <th>Part Name</th>
                                            <th>Part No.</th>
                                            <th>Insp Type</th>
                                            <th>Insp Item</th>
                                            <th>Insp Specification</th>
                                            <th>Status</th>
                                            <th class="no_sort" style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        <?php foreach($approval_items as $key => $approval_item) { ?>
                                            <tr>
                                                <td><?php echo $approval_item['supplier_name']; ?></td>
                                                <td><?php echo $approval_item['product_name']; ?></td>
                                                <td><?php echo $approval_item['part_name']; ?></td>
                                                <td><?php echo $approval_item['part_number']; ?></td>
                                                <td><?php echo $approval_item['insp_item']; ?></td>
                                                <td><?php echo $approval_item['insp_item2']; ?></td>
                                                <td><?php echo $approval_item['spec']; ?></td>
                                                <td><?php if($approval_item['status'] == NULL){ echo "Pending";}else{ echo $approval_item['status'];} ?></td>
                                                <td nowrap>
                                                    <button type="button" class="btn btn-default btn-xs accordion-toggle" data-toggle="collapse" data-target="#detail-<?php echo $key; ?>">
                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                    </button>
                                                    <?php if($approval_item['status'] == NULL){ ?>
                                                    <a class="button small gray" 
                                                        href="<?php echo base_url()."checkpoints/checkpoint_status/".$approval_item['id']."/Approved";?>">
                                                        <i class="fa fa-edit"></i> Approve
                                                    </a>

                                                    <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to decline this request ?"
                                                        href="<?php echo base_url()."checkpoints/checkpoint_status/".$approval_item['id']."/Declined";?>">
                                                        <i class="fa fa-trash-o"></i> Decline
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="hiddenRow">
                                                    <div class="accordian-body collapse row" id="detail-<?php echo $key; ?>">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-5">LSL:</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">
                                                                        <?php echo $approval_item['lsl']; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-5">Target:</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">
                                                                        <?php echo $approval_item['tgt']; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-5">USL:</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">
                                                                        <?php echo $approval_item['usl']; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-5">Unit:</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">
                                                                        <?php echo $approval_item['unit']; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    
                                </table>
                            <?php } else { ?>
                                <p class="text-center">No Inspection Item Found.</p>
                            <?php } ?>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>