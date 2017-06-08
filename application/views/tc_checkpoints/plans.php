<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Plan - <?php echo date('jS M, Y', strtotime($plan_date)); ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">View Plan</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
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
        </div>
    </div>
    
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-5 col-md-offset-7 text-right">
            <form role="form" class="form-inline" method="get" action="<?php echo base_url().'tc_checkpoints/plans'; ?>">
                <div class="form-group">
                    <label class="control-label col-md-6" style="font-size: 15px; margin-top: 6px; text-align: right;">
                        Date <i class="fa fa-arrow-right"></i>
                    </label>
                    <div class="input-group date date-picker col-md-6" data-date-format="yyyy-mm-dd">
                        <input name="plan_date" type="text" class="required form-control" readonly
                        value="<?php echo $plan_date; ?>">
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
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Plans for date - <?php echo date('jS M, Y', strtotime($plan_date));?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."tc_checkpoints/add_plan"; ?>">
                            <i class="fa fa-plus"></i> Add Plan
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($plans)) { ?>
                        <p class="text-center">No Plan added yet for this date.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Part</th>
                                        <th>Child Part No.</th>
                                        <th>Mold No.</th>
                                        <th>From Time</th>
                                        <th>To Item</th>
                                        <th class="no_sort" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($plans as $plan) { ?>
                                        <tr>
                                            <td><?php echo $plan['part_name'].' ('.$plan['part_no'].')'; ?></td>
                                            <td><?php echo $plan['child_part_no']; ?></td>
                                            <td><?php echo $plan['mold_no']; ?></td>
                                            <td><?php echo $plan['from_time']; ?></td>
                                            <td><?php echo $plan['to_time']; ?></td>
                                            <td nowrap class="text-center">
                                                <a class="button small gray" href="<?php echo base_url()."tc_checkpoints/add_plan/".$plan['id']; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <a class="btn btn-outline btn-xs sbold red-thunderbird" href="<?php echo base_url()."tc_checkpoints/delete_plan/".$plan['id']; ?>" data-confirm="Are you sure you want to delete this plan?">
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
