<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            <?php echo $this->session->userdata('name'); ?>
            <small>Welcome to your dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">Dashboard</li>
        </ol>
        
    </div>
        
    <?php if($this->session->flashdata('error')) {?>
        <div class="alert alert-danger">
           <i class="icon-remove"></i>
           <?php echo $this->session->flashdata('error');?>
        </div>
    <?php } else if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i>
           <?php echo $this->session->flashdata('success');?>
        </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel" id="dashboard-on-going-insp">
                
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> Scheduled Timechecks
                </div>
                
                <div class="ribbon-content">
                    <table class="table table-hover table-light dashboard-on-going-insp-table" id="make-data-table" style="background-color:inherit;">
                        <thead>
                            <tr>
                                <th>Part</th>
                                <th>Child Part</th>
                                <th>Mold No.</th>
                                <th>Scheduled</th>
                                <th class="text-center">Status</th>
                                <th class="no_sort" style="width:150px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($plans as $plan) { ?>
                                <tr>
                                    <td><?php echo $plan['part_name'].' ('.$plan['part_no'].')'; ?></td>
                                    <td><?php echo $plan['child_part_no']; ?></td>
                                    <td><?php echo $plan['mold_no']; ?></td>
                                    <td><?php echo $plan['from_time'].' <small>to</small> '.$plan['to_time']; ?></td>
                                    <td class="text-center">
                                        <?php if($plan['plan_status'] == 'Started') { ?>
                                            <span class="label label-warning label-sm"> 
                                                <i class="fa fa-play"></i> Started
                                            </span>
                                        <?php } else if($plan['plan_status'] == 'Completed') { ?>
                                            <span class="label label-success label-sm"> 
                                                <i class="fa fa-check"></i> Completed
                                            </span>
                                        <?php } else {  ?>
                                            <span class="label label-danger label-sm"> 
                                                <i class="fa fa-ban"></i> Not Started
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td nowrap class="text-center">
                                        <?php if($plan['plan_status'] == 'Started' || $plan['plan_status'] == 'Completed') { ?>
                                            <a class="button small gray" href="<?php echo base_url()."timecheck/view/".$plan['id']; ?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel" id="dashboard-on-going-insp">
                
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> Foolproof Count(Today)
                </div>
                
                <div class="ribbon-content">
                    <table class="table table-hover table-light" style="background-color:inherit;">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th class="text-center">Total Foolproofs</th>
                                <th class="text-center">Completed Foolproofs</th>
                                <th class="text-center">Pending Foolproofs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($foolproof_counts as $foolproof_count) { ?>
                            <tr style="background-color: #fff;">
                                    <td class="text-center">#1</td>
                                    <td class="text-center"><?php echo $foolproof_count['total']; ?></td>
                                    <td class="text-center"><?php echo $foolproof_count['completed']; ?></td>
                                    <td class="text-center"><?php echo ($foolproof_count['total']-$foolproof_count['completed']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
</div>