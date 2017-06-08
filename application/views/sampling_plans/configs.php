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
            <li class="active">Sampling Configuration</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <div class="row">
        <div class="col-md-3">
        
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
        </div>
        
        <div class="col-md-9">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Configurations
                    </div>
                    
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."sampling/update_inspection_config"; ?>">
                            <i class="fa fa-plus"></i> Add Inspection Configuration
                        </a>
                        <!--<a class="button normals btn-circle" href="<?php echo base_url()."sampling/sort_inspections"; ?>">
                            <i class="fa fa-plus"></i> Sort Inspections
                        </a>-->
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <?php if(!empty($configs)) { ?>
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr>
                                            <th>Insp Type</th>
                                            <th>Insp Item</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <th>Sampling Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        <?php foreach($configs as $key => $config) { ?>
                                            <tr>
                                                <td><?php echo $config['checkpoint_name']; ?></td>
                                                <td><?php echo $config['insp_item2']; ?></td>
                                                <td><?php echo $config['part_name']; ?></td>
                                                <td><?php echo $config['part_code']; ?></td>
                                                <td><?php echo $config['sampling_type']; ?></td>
                                                <td nowrap>
                                                    <button type="button" class="btn btn-default btn-xs accordion-toggle" data-toggle="collapse" data-target="#detail-<?php echo $key; ?>">
                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                    </button>
                                                    <a class="button small gray" href="<?php echo base_url()."sampling/update_inspection_config/".$config['id'];?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to this configuration?"
                                                        href="<?php echo base_url()."sampling/delete_config/".$config['id'];?>">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="hiddenRow">
                                                    <div class="accordian-body collapse row" id="detail-<?php echo $key; ?>">
                                                        <?php if($config['sampling_type'] == 'Auto') { ?>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-5">Inspection Level:</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">
                                                                            <?php echo $config['inspection_level']; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-5">Acceptable Quality:</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">
                                                                            <?php echo $config['acceptable_quality']; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                            
                                                        <?php if($config['sampling_type'] == 'C=0') { ?>

                                                            <div class="col-md-6 col-md-offset-3">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-5">Acceptable Quality:</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">
                                                                            <?php echo $config['acceptable_quality']; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                            
                                                        <?php if($config['sampling_type'] == 'Fixed') { ?>

                                                            <div class="col-md-6 col-md-offset-3">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-5">Sample Quantity:</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">
                                                                            <?php echo $config['sample_qty']; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                    
                                                        <?php if($config['sampling_type'] == 'User Defined') { ?>
                                                            <div class="row" style="margin: 0px 8px;">
                                                                <div class="col-md-6">
                                                                    <table class="table table-hover table-light">
                                                                        <thead>
                                                                            <tr>
                                                                                <th colspan="3" class="text-center">Lot Range</th>
                                                                                <th># of Samples</th>
                                                                            </tr>
                                                                        </thead>
                                                                        
                                                                        <tbody>
                                                                            <?php foreach(array_slice($config['lots'], 0, ceil(count($config['lots'])/2)) as $lot) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $lot['lower_val']; ?></td>
                                                                                    <td>to</td>
                                                                                    <td><?php echo ($lot['higher_val']) ? $lot['higher_val'] : 'over'; ?></td>
                                                                                    <td><?php echo $lot['no_of_samples']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <table class="table table-hover table-light">
                                                                        <thead>
                                                                            <tr>
                                                                                <th colspan="3" class="text-center">Lot Range</th>
                                                                                <th># of Samples</th>
                                                                            </tr>
                                                                        </thead>
                                                                        
                                                                        <tbody>
                                                                            <?php foreach(array_slice($config['lots'], ceil(count($config['lots'])/2)) as $lot) { ?>
                                                                                <tr>
                                                                                    <tr>
                                                                                        <td><?php echo $lot['lower_val']; ?></td>
                                                                                        <td>To</td>
                                                                                        <td><?php echo ($lot['higher_val']) ? $lot['higher_val'] : 'over'; ?></td>
                                                                                        <td><?php echo $lot['no_of_samples']; ?></td>
                                                                                    </tr>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    
                                </table>
                            <?php } else { ?>
                                <p class="text-center">No Configs found.</p>
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