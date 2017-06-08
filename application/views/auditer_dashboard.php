<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            <?php echo $this->session->userdata('name'); ?>
            <small>Welcome to your dashboard - <?php echo date('jS M, Y', strtotime($this->session->userdata('dashboard_date'))); ?></small>
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
    
    <input type="hidden" id="first-time" value="1" />
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="form-group">
                <label class="control-label col-md-6" style="font-size: 15px; margin-top: 6px; text-align: right;">
                    Dashboard Date &nbsp; <i class="fa fa-arrow-right"></i>
                </label>
                <div id="dashboard-date" class="input-group date date-picker col-md-6" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
                    <input id="audit_date" name="audit_date" type="text" class="required form-control" readonly
                    value="<?php echo $this->session->userdata('dashboard_date'); ?>">
                    <span class="input-group-btn">
                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </div>    
        </div>    
    </div>
    
    <?php if(!empty($on_holds) || !empty($on_going)) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-element-ribbon bg-grey-steel" id="dashboard-on-going-insp">
                    <div class="">
                        <div class="col-md-3 col-md-offset-9" style="margin-top: -10px;">
                            <input type="text" id="dashboard-barcode-scan" class="form-control" name="barcode" placeholder="Search by barcode">
                        </div>
                    </div>
                    
                    <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                        <div class="ribbon-sub ribbon-clip"></div> Inspection Status
                    </div>
                    
                    <div class="ribbon-content">
                        <table class="table table-hover table-light dashboard-on-going-insp-table" id="make-data-table" style="background-color:inherit;">
                            <thead>
                                <tr>
                                    <th>Audit Date</th>
                                    <th>Inspection</th>
                                    <th>Model.Suffix</th>
                                    <th>Serial No.</th>
                                    <th class="text-center">Status</th>
                                    <th class="no_sort" style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($on_going)) { ?>
                                    <tr style="background-color:inherit;">
                                        <td><?php //echo date('jS M, Y', strtotime($on_going['audit_date']));
                                                    echo date('Y/m/d', strtotime($on_going['audit_date']));?></td>
                                        <td><?php echo $on_going['inspection_name']; ?></td>
                                        <td><?php echo $on_going['model_suffix']; ?></td>
                                        <td class="dashboard-on-going-insp-table-serial-no"><?php echo $on_going['serial_no']; ?></td>
                                        <td class="text-center">
                                            <?php if($on_going['insp_type'] == 'interval') { ?>
                                                <span class="label label-warning"> 
                                                    <i class="fa fa-spinner"></i> On Going - Iteration <?php echo $on_going['current_iteration'];?>
                                                </span>
                                            <?php } else { ?>
                                                <span class="label label-warning"> 
                                                    <i class="fa fa-spinner"></i> On Going
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td nowrap>
                                            <a class="button small" 
                                                href="<?php echo base_url()."register_inspection";?>">
                                                Resume
                                            </a>
                                            
                                            <?php if($on_going['insp_type'] == 'interval') { ?>
                                                <a href="<?php echo base_url().'auditer/abort_request';?>" class="button small" data-confirm="Are you sure you want to abort this inspection?">
                                                    Request Abort
                                                </a>
                                            <?php } else { ?>
                                                <a class="button small" href="<?php echo base_url().'auditer/mark_as_abort/';?>" data-confirm="Are you sure  you want to cancel this inspection?">
                                                    Abort
                                                </a>
                                            <?php } ?>
                                            
                                            <a class="button small" href="<?php echo base_url().'auditer/on_hold/'.$on_going['id'];?>" data-confirm="Are you sure  you want to mark this inspection ON HOLD?">
                                                On Hold
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                
                                <?php $show_regular = array_values(array_filter($on_holds, function($v) {
                                        return $v['insp_type'] != 'interval';
                                    }));
                                ?>

                                <?php foreach($show_regular as $k_oh => $on_hold) { ?>
                                    <?php if($k_oh == 0) { ?>
                                        <tr class="table-title-row" style="background-color:inherit;">
                                            <td>Regular Inspections</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    
                                    <?php if($on_hold['paired'] && !empty($on_hold['paired_with'])) { continue; } ?>
                                    
                                    <tr  style="background-color:inherit;">
                                        <td><?php echo date('Y/m/d', strtotime($on_hold['audit_date'])); ?></td>
                                        <td><?php echo $on_hold['inspection_name']; ?></td>
                                        <td><?php echo $on_hold['model_suffix']; ?></td>
                                        <td class="dashboard-on-going-insp-table-serial-no"><?php echo $on_hold['serial_no']; ?></td>
                                        <td class="text-center">
                                            <span class="label label-danger"> 
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
                                
                                <?php $show_interval = array_values(array_filter($on_holds, function($v) {
                                        return $v['insp_type'] == 'interval' && strtotime($v['iteration_datetime']) <= strtotime('now');
                                    }));
                                ?>
                                <?php foreach($show_interval as $k_oh => $on_hold) { ?>
                                    <?php if($k_oh == 0) { ?>
                                        <tr class="table-title-row" style="background-color:inherit;">
                                            <td>Interval Inspections</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    
                                    <?php if($on_hold['paired'] && !empty($on_hold['paired_with'])) { continue; } ?>
                                    
                                    <tr style="background-color:inherit;">
                                        <td><?php echo date('Y/m/d', strtotime($on_hold['audit_date'])); ?></td>
                                        <td><?php echo $on_hold['inspection_name']; ?></td>
                                        <td><?php echo $on_hold['model_suffix']; ?></td>
                                        <td class="dashboard-on-going-insp-table-serial-no"><?php echo $on_hold['serial_no']; ?></td>
                                        <td class="text-center">
                                            <span class="label label-danger"> 
                                                <i class="fa fa-check"></i> Iteration <?php echo $on_hold['current_iteration']?> activated
                                            </span>
                                        </td>
                                        
                                        <td class="text-center" nowrap>
                                            <?php if(!$on_hold['abort_requested']) { ?>
                                                <a class="button small" 
                                                href="<?php echo base_url()."auditer/resume/".$on_hold['id'];?>">
                                                    Resume
                                                </a>
                                                
                                                <a class="button small" href="<?php echo base_url().'auditer/abort_request/'.$on_hold['id'].'/1';?>" data-confirm="Are you sure you want to cancel this inspection?">
                                                    Request Abort
                                                </a>
                                            <?php } else { ?>
                                                <span class="label label-danger"> 
                                                    Abort Requested
                                                </span>
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
    <?php } ?>
    
    <div class="row dashboard-progress-section">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-clip ribbon-color-danger">
                    <div class="ribbon-sub ribbon-clip"></div> <?php echo date('jS M, Y', strtotime($this->session->userdata('dashboard_date'))); ?>'s PROGRESS </div>
                <div class="ribbon-content text-center">
                    <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading"> Loading Progress
                </div>
            </div>
        </div>
    </div>
    
    
</div>