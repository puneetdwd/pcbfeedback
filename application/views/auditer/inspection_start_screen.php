<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Part Inspection | Start Screen
        </h1>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
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
        
        <div class="col-md-3">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        Part Inspection Details
                    </div>
                </div>
                <div class="portlet-body form inspection-detail-sidebar">
                    <!-- BEGIN FORM-->
                    <form role="form">
                        <div class="form-body">
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Supplier:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['supplier_no'].' - '.$audit['supplier_name']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Product:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['product_name']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Part Name:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['part_name']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Part No:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['part_no']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Inspection Lot Qty.:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['prod_lot_qty']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><b>Lot No:</b></label><br />
                                        <p class="form-control-static">
                                            <?php echo $audit['lot_no']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Inspection | <small>Total No. of Inspection Items <?php echo count($checkpoints)+$excluded_count; ?> <!--Applicable Checkpoints <?php echo count($checkpoints); ?>--></small>
                    </div>
                    <div class="actions">
                        <a href="<?php echo base_url().'auditer/start_inspection';?>" class="button normals btn-circle start-inspection-button" style="display:none;">    
                            Start Inspection
                        </a>
                        <a href="<?php echo base_url().'auditer/mark_as_abort';?>" class="btn btn-circle btn-outline pull-right btn-sm sbold red" data-confirm="Are you sure you want to cancel this inspection?">
                            Abort
                        </a>
                        <a href="<?php echo base_url().'auditer/on_hold';?>" class="btn btn-circle btn-outline pull-right btn-sm sbold red"
                        data-confirm="Are you sure you want to mark this inspection on hold?">
                            On Hold
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <?php if(empty($checkpoints)) { ?>
                        <p class="text-center">No Inspection Item.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle;">No.</th>
                                    <th class="text-center" style="vertical-align: middle;">Insp. Type</th>
                                    <th class="text-center" style="vertical-align: middle;">Insp. Item</th>
                                    <th class="text-center" style="vertical-align: middle;">Spec.</th>
                                    <th class="text-center" style="vertical-align: middle;">LSL</th>
                                    <th class="text-center" style="vertical-align: middle;">USL</th>
                                    <th class="text-center" style="vertical-align: middle;">TGT</th>
                                    <th class="text-center" style="vertical-align: middle;">Sample Qty.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="warning">
                                    <td colspan="10">LG Inspection Items</td>
                                </tr>
                                <?php $first = true; ?>
                                <?php foreach($checkpoints as $checkpoint) { ?>
                                    <?php if($checkpoint['checkpoint_type'] == 'Supplier' && $first) { ?>
                                        <tr class="warning">
                                            <td colspan="10">Suppliers Inspection Items</td>
                                        </tr>
                                        <?php $first = false; ?>
                                    <?php } ?>
                                    <tr>
                                        <td><?php echo $checkpoint['checkpoint_no']; ?></td>
                                        <td><?php echo $checkpoint['insp_item']; ?></td>
                                        <td><?php echo $checkpoint['insp_item2']; ?></td>
                                        <td><?php echo $checkpoint['spec']; ?></td>
                                        <td nowrap class="text-center">
                                            <?php echo ($checkpoint['lsl']) ? $checkpoint['lsl'].' '.$checkpoint['unit'] : ''; ?>
                                        </td>
                                        <td nowrap class="text-center">
                                            <?php echo ($checkpoint['usl']) ? $checkpoint['usl'].' '.$checkpoint['unit'] : ''; ?>
                                        </td>
                                        <td nowrap class="text-center">
                                            <?php echo ($checkpoint['tgt']) ? $checkpoint['tgt'].' '.$checkpoint['unit'] : ''; ?>
                                        </td>
                                        <td class="sample-qty" class="text-center">
                                            <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading" style="display:none;">
                                            
                                            <a class="fetch-sample-qty-button button small gray" href="<?php echo base_url().'auditer/get_sample_qty'; ?>" data-cid="<?php echo $checkpoint['id']; ?>" data-pid="<?php echo $audit['part_id']; ?>" data-plq="<?php echo $audit['prod_lot_qty']; ?>" style="display:none;"> 
                                                Fetch
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                    <div class="form-actions right">
                        <a href="<?php echo base_url().'auditer/start_inspection';?>" class="button normals btn-circle start-inspection-button" style="display:none;">    
                            Start Inspection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>


<?php if(!empty($checkpoints)) { ?>
    <script>
        $(window).load(function() {
            $('.fetch-sample-qty-button:first').trigger('click');
        });
    </script>
<?php } ?>