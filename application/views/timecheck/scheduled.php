<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Scheduled Timecheck
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Scheduled Timecheck</li>
        </ol>
        
    </div>
    
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
        <div class="col-md-8 col-md-offset-2">
        
            <div class="portlet light tasks-widget bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Scheduled Timecheck List
                    </div>
                </div>

                
                <div class="portlet-body">
                    <?php if(empty($plans)) { ?>
                        <p class="text-center">No Plan added available.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Part</th>
                                        <th>Scheduled</th>
                                        <th class="no_sort" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($plans as $plan) { ?>
                                        <tr>
                                            <td><?php echo $plan['part_name'].' ('.$plan['part_no'].')'; ?></td>
                                            <td><?php echo $plan['from_time'].' <small>to</small> '.$plan['to_time']; ?></td>
                                            <td nowrap class="text-center">
                                                <a class="button small gray" href="<?php echo base_url()."timecheck/start/".$plan['id']; ?>">
                                                    <i class="fa fa-play"></i> Start
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