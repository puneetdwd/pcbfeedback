<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Revision History
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."checkpoints"; ?>">
                    Manage Checkpoints
                </a>
            </li>
            <li class="active">View Revision History</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-5 col-md-offset-7 text-right">
            <form role="form" class="form-inline" method="post" action="<?php echo base_url().'inspections/view_revision_history'; ?>">
                <div class="form-group">
                    <label class="control-label col-md-6" style="font-size: 15px; margin-top: 6px; text-align: right;">
                        Date <i class="fa fa-arrow-right"></i>
                    </label>
                    <div class="input-group date date-picker col-md-6" data-date-format="yyyy-mm-dd">
                        <input name="revision_date" type="text" class="required form-control" readonly
                        value="<?php echo $this->input->post('revision_date'); ?>">
                        <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
                
                <button class="button" type="submit">Search</button>
            </form>
        </div>    
    </div>
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
                        <i class="fa fa-reorder"></i>View History
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."checkpoints"; ?>">
                            <i class="fa fa-eye"></i> View Checkpoints
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($histories)) { ?>
                        <p class="text-center">No History.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Version</th>
                                        <th>Type</th>
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
                                    <?php foreach($histories as $history) { ?>
                                    
                                        <?php 
                                            $class = "success";
                                            if($history['change_type'] == 'Deleted') {
                                                $class = "danger";
                                            } else if($history['change_type'] == 'Updated') {
                                                $class = "warning";
                                            }
                                        ?>
                                        
                                        <?php 
                                            $show = false; 
                                            if($history['change_type'] == 'Added' && $history['type'] == 'After') {
                                                $show = true;
                                            }
                                            
                                            if($history['change_type'] != 'Added' && $history['type'] == 'Before') {
                                                $show = true;
                                            }
                                        ?>
                                        
                                        <?php if($show) { ?>
                                            <tr class="<?php echo $class; ?>">
                                                <td colspan="4"><b><?php echo $history['change_type'].' on '.$history['changed_on']; ?></b></td>
                                                <td colspan="7"><b><?php echo ($history['remark']) ? 'Remark - '.$history['remark']: ''; ?></b></td>
                                            </tr>
                                        <?php } ?>
                                        
                                        <tr class="<?php echo $class; ?>">
                                            <?php if($history['change_type'] == 'Updated') { ?>
                                                <?php if($history['type'] == 'Before') { ?>
                                                    <td rowspan="2" style="text-align:center;vertical-align:middle;"><?php echo $history['version']; ?></td>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <td style="text-align:center;vertical-align:middle;"><?php echo $history['version']; ?></td>
                                            <?php } ?>
                                            <td><?php echo $history['type']; ?></td>
                                            <td><?php echo $history['checkpoint_no']; ?></td>
                                            
                                            <td><?php echo $history['insp_item']; ?></td>
                                            <td><?php echo $history['insp_item2']; ?></td>
                                            <td><?php echo $history['insp_item3']; ?></td>
                                            <td><?php echo $history['spec']; ?></td>
                                            <td nowrap>
                                                <?php echo ($history['lsl']) ? $history['lsl'].' '.$history['unit'] : ''; ?>
                                            </td>
                                            <td nowrap>
                                                <?php echo ($history['usl']) ? $history['usl'].' '.$history['unit'] : ''; ?>
                                            </td>
                                            <td nowrap>
                                                <?php echo ($history['tgt']) ? $history['tgt'].' '.$history['unit'] : ''; ?>
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