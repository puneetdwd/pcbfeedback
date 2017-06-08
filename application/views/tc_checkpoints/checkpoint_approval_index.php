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
            Supplier Timecheck Inspection Approval Screen
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Supplier Timecheck Inspection Items</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
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
                        <i class="fa fa-reorder"></i>Supplier Timecheck Inspection Items
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
                        <div class="table-responsive form-body">
                            <?php if(!empty($approval_items)) { ?>
                            <table class="table table-hover table-light" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Supplier Name</th>
                                            <th>Product Name</th>
                                            <th>Part Name</th>
                                            <th>Part No.</th>
                                            <th>Child Part name</th>
                                            <th>Child Part No.</th>
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
                                                <td><?php echo $approval_item['child_part_name']; ?></td>
                                                <td><?php echo $approval_item['child_part_no']; ?></td>
                                                <td><?php echo $approval_item['mold_no']; ?></td>
                                                <td><?php echo $approval_item['stage']; ?></td>
                                                <td><?php echo $approval_item['instrument']; ?></td>
                                                <td><?php echo $approval_item['insp_item']; ?></td>

                                                <td><?php echo $approval_item['spec']; ?></td>
                                                <td>
                                                    <?php echo ($approval_item['lsl']) ? $approval_item['lsl'].' '.$approval_item['unit'] : ''; ?>
                                                </td>
                                                <td>
                                                    <?php echo ($approval_item['usl']) ? $approval_item['usl'].' '.$approval_item['unit'] : ''; ?>
                                                </td>
                                                <td>
                                                    <?php echo ($approval_item['tgt']) ? $approval_item['tgt'].' '.$approval_item['unit'] : ''; ?>
                                                </td>
                                                <td><?php echo $approval_item['sample_qty']; ?></td>
                                                <td><?php echo $approval_item['frequency'].' hours'; ?></td>
                                                <td>
                                                    <?php if($approval_item['status'] == NULL || $approval_item['status'] == 'Pending'){ echo "Pending"; } else { echo $approval_item['status']; } ?>
                                                </td>
                                                <td nowrap>
                                                    <?php if($approval_item['status'] == NULL || $approval_item['status'] == 'Pending'){ ?>
                                                    <a class="button small gray" 
                                                        href="<?php echo base_url()."tc_checkpoints/checkpoint_status/".$approval_item['id']."/Approved";?>">
                                                        <i class="fa fa-edit"></i> Approve
                                                    </a>

                                                    <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to decline this request ?"
                                                        href="<?php echo base_url()."tc_checkpoints/checkpoint_status/".$approval_item['id']."/Declined";?>">
                                                        <i class="fa fa-trash-o"></i> Decline
                                                    </a>
                                                    <?php } ?>
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