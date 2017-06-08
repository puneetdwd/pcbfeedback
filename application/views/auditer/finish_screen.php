<div class="page-content">

    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Part Inspection | Review Screen
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
    </div>
        
    <div class="row">    
        <div class="col-md-12">
            <div class="portlet light bordered">

                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="">
                                <label class="control-label"><b>Supplier:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $audit['supplier_no'].' - '.$audit['supplier_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="">
                                <label class="control-label"><b>Product:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $audit['product_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="">
                                <label class="control-label"><b>Part:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $audit['part_no'].' - '.$audit['part_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="">
                                <label class="control-label"><b>Inspection Lot Qty.:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $audit['prod_lot_qty']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"><b>Lot No:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $audit['lot_no']; ?>
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                
                <div class="portlet-title">
                    <div class="caption">
                        Inspection Items | Total <?php echo count($checkpoints); ?>
                        <small><?php echo ' (OK - '.$checkpoints_OK.', NG - '.$checkpoints_NG.' Others - '.$checkpoints_PD.')'; ?></small>
                    </div>
                    
                    <?php if(!isset($admin_edit_audit)) { ?>
                        <div class="actions">
                            <a href="<?php echo base_url().'auditer/mark_as_complete'; ?>" data-confirm="Are you sure you want to mark this inspection result as complete. Once marked as complete the inspection result can't be changed." class="button normals btn-circle">    
                                Mark As Completed
                            </a>
                            <a href="<?php echo base_url().'auditer/on_hold';?>" class="btn btn-circle btn-outline pull-right btn-sm sbold red"
                            data-confirm="Are you sure you want to mark this inspection on hold?">
                                On Hold
                            </a>
                            <a href="<?php echo base_url().'auditer/mark_as_abort';?>" class="btn btn-circle btn-outline pull-right btn-sm sbold red"
                            data-confirm="Are you sure you want to cancel this inspection?">
                                Abort
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="portlet-body form">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th class="text-center" style="vertical-align: middle;">Checkpoint No.</th>
                                <th class="text-center" style="vertical-align: middle;">Insp. Type</th>
                                <th class="text-center" style="vertical-align: middle;">Insp. Item</th>
                                <th class="text-center" style="vertical-align: middle;">Spec.</th>
                                <th class="text-center" style="vertical-align: middle;">LSL</th>
                                <th class="text-center" style="vertical-align: middle;">USL</th>
                                <th class="text-center" style="vertical-align: middle;">TGT</th>
                                <th class="text-center" style="vertical-align: middle;">Samples</th>
                                <th class="text-center" style="vertical-align: middle;">Remark</th>
                                <th class="text-center" style="vertical-align: middle;">Judgement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="warning">
                                <td colspan="11">LG Checkpoints</td>
                            </tr>
                            <?php $first = true; ?>
                            <?php foreach($checkpoints as $checkpoint) { ?>
                                <?php if($checkpoint['checkpoint_type'] == 'Supplier' && $first) { ?>
                                    <tr class="warning">
                                        <td colspan="11">Suppliers Checkpoints</td>
                                    </tr>
                                    <?php $first = false; ?>
                                <?php } ?>
                                <?php 
                                    $class = '';
                                    if(empty($checkpoint['result']) || $checkpoint['result'] == 'NA') {
                                        $class = "warning";
                                    } else if($checkpoint['result'] == 'NG') {
                                        $class = 'danger';
                                    }
                                    
                                    $url = base_url().'auditer/review_checkpoint/'.$checkpoint['org_checkpoint_id'];
                                    if(isset($admin_edit_audit)) {
                                        $url .= "/".$admin_edit_audit;
                                    }
                                ?>
                                <tr class="<?php echo $class; ?>" href="<?php echo $url; ?>" 
                                data-target="#change-checkpoint-modal" data-toggle="modal">
                                    <td><?php echo $checkpoint['checkpoint_no']; ?></td>
                                    <td><?php echo $checkpoint['insp_item']; ?></td>
                                    <td><?php echo $checkpoint['insp_item2']; ?></td>
                                    <td><?php echo $checkpoint['spec']; ?></td>
                                    <td nowrap class="text-center">
                                        <?php echo ($checkpoint['lsl'] || $checkpoint['lsl'] === '0') ? $checkpoint['lsl'].' '.$checkpoint['unit'] : ''; ?>
                                    </td>
                                    <td nowrap class="text-center">
                                        <?php echo ($checkpoint['usl'] || $checkpoint['usl'] === '0') ? $checkpoint['usl'].' '.$checkpoint['unit'] : ''; ?>
                                    </td>
                                    <td nowrap class="text-center">
                                        <?php echo ($checkpoint['tgt'] || $checkpoint['tgt'] === '0') ? $checkpoint['tgt'].' '.$checkpoint['unit'] : ''; ?>
                                    </td>
                                    <td class="text-center"><?php echo $checkpoint['sampling_qty']; ?></td>
                                    <td><?php echo $checkpoint['remark']; ?></td>
                                    <td class="text-center"><?php echo $checkpoint['result']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <?php if(!isset($admin_edit_audit)) { ?>
                        <div class="form-actions right">
                            <a href="<?php echo base_url().'auditer/mark_as_complete'; ?>" data-confirm="Are you sure you want to mark this inspection as complete. Once marked as complete the inspection can't be changed." class="button normals btn-circle">    
                                Mark As Completed
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<div class="modal fade bs-modal-lg modal-scroll" id="change-checkpoint-modal" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="../assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>