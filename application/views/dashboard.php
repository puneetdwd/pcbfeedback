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
    
    <div class="row dashboard-progress-section">
        <div class="col-md-12">
            <div class="text-right" id="dashboard-approve-decline" style="display:none;">
                <?php if(empty($exists)) { ?>
                    <a class="button small" href="<?php echo base_url()."dashboard/status/Approve"; ?>" data-confirm="Are you sure you want to approve?">
                        Approve
                    </a>
                    <a class="button small white" href="<?php echo base_url()."dashboard/status/Decline"; ?>" data-confirm="Are you sure you want to decline?">
                        Decline
                    </a>
                <?php } else { ?>
                    <b style="color:#d30e43;">
                        Marked as <?php echo $exists['status']; ?>
                    </c>
                <?php } ?>
            </div>
            <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> Today's Progress </div>
                <div class="ribbon-content">
                    <?php if(empty($sampling_plan)) {?>
                        No sampling plan added for Today.
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <?php foreach(array_slice($sampling_plan, 0, 1) as $plan) { ?>
                                            <?php foreach($plan as $k => $p) { ?>
                                                <?php if($k <= 4) { ?>
                                                    <th rowspan="2" style="vertical-align: middle;"><?php echo $p; ?></th>
                                                <?php } else { ?>
                                                    <th colspan="3" class="text-center"><?php echo $p; ?></th>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach(array_slice($sampling_plan, 0, 1) as $plan) { ?>
                                            <?php foreach($plan as $k => $p) { ?>
                                                
                                                <?php if($k > 4) { ?>
                                                    <th>Planned</th>
                                                    <th>Completed</th>
                                                    <th>In Progress</th>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach(array_slice($sampling_plan, 1) as $plan) { ?>
                                        <tr>
                                            <?php foreach($plan as $k => $p) { ?>
                                                <?php if($p == 'skip') { continue; } ?>
                                                
                                                <?php if(0 === strpos($p, '<td')) { ?>
                                                    <?php echo $p; ?>
                                                <?php } else { ?>
                                                    <td><?php echo $p; ?></td>
                                                <?php } ?>
                                            <?php } ?>
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

    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> Yesterday's Progress </div>
                <div class="ribbon-content">
                    <?php if(empty($sampling_plan_yesterday)) {?>
                        No sampling plan added for Yesterday.
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <?php foreach(array_slice($sampling_plan, 0, 1) as $plan) { ?>
                                            <?php foreach($plan as $k => $p) { ?>
                                                <?php if($k <= 5) { ?>
                                                    <th rowspan="2" style="vertical-align: middle;"><?php echo $p; ?></th>
                                                <?php } else { ?>
                                                    <th colspan="3" class="text-center"><?php echo $p; ?></th>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach(array_slice($sampling_plan, 0, 1) as $plan) { ?>
                                            <?php foreach($plan as $k => $p) { ?>
                                                
                                                <?php if($k > 5) { ?>
                                                    <th>Planned</th>
                                                    <th>Completed</th>
                                                    <th>In Progress</th>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach(array_slice($sampling_plan, 1) as $plan) { ?>
                                        <tr>
                                            <?php foreach($plan as $k => $p) { ?>
                                                <?php if($p == 'skip') { continue; } ?>
                                                
                                                <?php if(0 === strpos($p, '<td')) { ?>
                                                    <?php echo $p; ?>
                                                <?php } else { ?>
                                                    <td><?php echo $p; ?></td>
                                                <?php } ?>
                                            <?php } ?>
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
    
    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> Last 5 Completed Inspections
                </div>
                
                <div class="ribbon-content">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th>Audit Date</th>
                                <th>Auditer</th>
                                <th>Inspection</th>
                                <th>Product</th>
                                <th>Model.Suffix</th>
                                <th>Serial No.</th>
                                <th># Checkpoints</th>
                                <th>OK</th>
                                <th>NG</th>
                                <th class="no_sort" style="width:150px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($audits as $audit) { ?>
                                <tr>
                                    <td><?php echo date('jS M, Y', strtotime($audit['audit_date'])); ?></td>
                                    <td><?php echo $audit['auditer']; ?></td>
                                    <td><?php echo $audit['inspection_name']; ?></td>
                                    <td><?php echo $audit['product_name']; ?></td>
                                    <td><?php echo $audit['model_suffix']; ?></td>
                                    <td><?php echo $audit['serial_no']; ?></td>
                                    <td><?php echo $audit['checkpoint_count']; ?></td>
                                    <td><?php echo $audit['ok_count']; ?></td>
                                    <td><?php echo $audit['ng_count']; ?></td>
                                    <td nowrap>
                                        <a class="btn btn-xs purple" 
                                            href="<?php echo base_url()."reports/download_report/".$audit['id'];?>">
                                            <i class="fa fa-download"></i>
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
</div>