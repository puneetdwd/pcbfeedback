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
    
    <?php if(!empty($on_holds) || !empty($on_going)) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-element-ribbon bg-grey-steel" id="dashboard-on-going-insp">
                    
                    <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                        <div class="ribbon-sub ribbon-clip"></div> Inspection Status
                    </div>
                    
                    <div class="ribbon-content">
                        <table class="table table-hover table-light dashboard-on-going-insp-table" id="make-data-table" style="background-color:inherit;">
                            <thead>
                                <tr>
                                    <th>Audit Date</th>
                                    <th>Part</th>
                                    <th>Lot No</th>
                                    <th class="text-center">Status</th>
                                    <th class="no_sort" style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($on_going)) { ?>
                                    <tr style="background-color:inherit;">
                                        <td><?php echo date('jS M, Y', strtotime($on_going['audit_date'])); ?></td>
                                        <td><?php echo $on_going['part_no'].' - '.$on_going['part_name']; ?></td>
                                        <td><?php echo $on_going['lot_no']; ?></td>
                                        <td class="text-center">
                                            <span class="label label-warning label-sm"> 
                                                <i class="fa fa-spinner"></i> On Going
                                            </span>
                                        </td>
                                        <td nowrap>
                                            <a class="button small" 
                                                href="<?php echo base_url()."register_inspection";?>">
                                                Resume
                                            </a>
                                            
                                            <a class="button small" href="<?php echo base_url().'auditer/mark_as_abort/';?>" data-confirm="Are you sure  you want to cancel this inspection?">
                                                Abort
                                            </a>
                                            
                                            <a class="button small" href="<?php echo base_url().'auditer/on_hold/'.$on_going['id'];?>" data-confirm="Are you sure  you want to mark this inspection ON HOLD?">
                                                On Hold
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php foreach($on_holds as $k_oh => $on_hold) { ?>
                                    <tr style="background-color:inherit;">
                                        <td><?php echo date('jS M, Y', strtotime($on_hold['audit_date'])); ?></td>
                                        <td><?php echo $on_hold['part_no'].' - '.$on_hold['part_name']; ?></td>
                                        <td><?php echo $on_hold['lot_no']; ?></td>
                                        <td class="text-center">
                                            <span class="label label-danger label-sm"> 
                                                <i class="fa fa-ban"></i> On Hold
                                            </span>
                                        </td>
                                        
                                        <td class="text-center" nowrap>
                                            <a class="button small" 
                                                href="<?php echo base_url()."auditer/resume/".$on_hold['id'];?>">
                                                    Resume
                                                </a>
                                            
                                            <a class="button small" href="<?php echo base_url().'auditer/mark_as_abort/'.$on_hold['id'].'/1';?>" data-confirm="Are you sure you want to cancel this inspection?">
                                                Abort
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
                                            <span class="label label-success label-sm"> 
                                                <i class="fa fa-play"></i> Started
                                            </span>
                                        <?php } else {  ?>
                                            <span class="label label-danger label-sm"> 
                                                <i class="fa fa-ban"></i> Not Started
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td nowrap class="text-center">
                                        <?php if($plan['plan_status'] == 'Started') { ?>
                                            <a class="button small gray" href="<?php echo base_url()."timecheck/view/".$plan['id']; ?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        <?php } ?>
                                        
                                        <?php if($plan['allowed'] == 'Yes') { ?>
                                            <a class="button small gray" href="<?php echo base_url()."timecheck/start/".$plan['id']; ?>">
                                                <i class="fa fa-play"></i> Start
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
</div>