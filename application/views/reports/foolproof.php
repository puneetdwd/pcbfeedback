<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Fool-Proof Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">View Fool-Proof Report</li>
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
            
            <div class="row">
                
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        <div class="portlet-body form">
                            <form role="form" class="validate-form" method="post">
                                <div class="form-body" style="padding:0px;">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        You have some form errors. Please check below.
                                    </div>
                                
                                
                                    <?php if(isset($error)) { ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php } ?>
                                    
                                    <input type="hidden" id="page-no" name="page_no" value="1"/>
                                    <?php $date = $this->input->post('date') ? $this->input->post('date') : date('Y-m-d'); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Date Range</label>
                                                <div class="input-group date date-picker col-md-6" data-date-format="yyyy-mm-dd" data-date-end-date="<?php echo date('Y-m-d'); ?>">
                                                    <input name="date" type="text" class="required form-control" readonly
                                                    value="<?php echo $date; ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                        <div class="col-md-6">
                                            <div class="form-group" id="report-sel-supplier-error">
                                                <label class="control-label" for="supplier_id">Supplier:</label>
                                                
                                                <select name="supplier_id" class="form-control select2me"
                                                data-placeholder="Select Supplier" data-error-container="#report-sel-supplier-error">
                                                    <option value=""></option>
                                                    
                                                    <?php $sel_supplier = $this->input->post('supplier_id'); ?>
                                                    <?php foreach($suppliers as $supplier) { ?>
                                                        <option value="<?php echo $supplier['id']; ?>" 
                                                        <?php if($sel_supplier == $supplier['id']) { ?> selected="selected" <?php } ?>>
                                                            <?php echo $supplier['supplier_no'].' - '.$supplier['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                </div>
                                
                                <div class="form-actions">
                                    <button class="button" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>List of Fool-Proofs
                            </div>
                            <div class="actions">
                                <!--<a class="button normals btn-circle" onclick="printPage('part_insp_table');" href="javascript:void(0);">
                                    <i class="fa fa-print"></i> Print
                                </a>-->
                                <?php $supplier_id = ($this->input->post('supplier_id'))?$this->input->post('supplier_id'):$this->supplier_id; ?>
                                <?php if($this->input->post()){ ?>
                                <a class="button normals btn-circle" href="<?php echo base_url()."reports/download_foolproof_report/".$this->input->post('date')."/".$supplier_id;?>">
                                    <i class="fa fa-print"></i> Download
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php if(empty($foolproofs)) { ?>
                                <p class="text-center">No Fool-Proof Done Yet.</p>
                            <?php } else { ?>
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                                <input type="hidden" name="date" value="<?php $this->input->post('date'); ?>" >
                                <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>" >
                                <!--<div class="table-scrollable">-->
                                    <table class="table table-hover table-light" border="1">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align:middle;">Sr.No.</th>
                                                <th style="vertical-align:middle;">Supplier</th>
                                                <th style="vertical-align:middle;">Date</th>
                                                <th style="vertical-align:middle;">Stage</th>
                                                <th style="vertical-align:middle;">Sub Stage</th>
                                                <th style="vertical-align:middle;">Major Control Parameter</th>
                                                <th style="vertical-align:middle;">LSL</th>
                                                <th style="vertical-align:middle;">USL</th>
                                                <th style="vertical-align:middle;">TGT</th>
                                                <th style="vertical-align:middle;">Unit</th>
                                                <th style="vertical-align:middle;">Measuring Equipment</th>
                                                <th style="vertical-align:middle;">Image</th>
                                                <th style="vertical-align:middle;">Input Value</th>
                                                <th style="vertical-align:middle;">Result</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach($foolproofs as $foolproof) { $i++; ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $foolproof['supplier_name']; ?></td>
                                                    <td><?php echo date('jS M, Y', strtotime($foolproof['created'])); ?></td>
                                                    <td><?php echo $foolproof['stage']; ?></td>
                                                    <td><?php echo $foolproof['sub_stage']; ?></td>
                                                    <td><?php echo $foolproof['major_control_parameters']; ?></td>
                                                    <td><?php echo $foolproof['lsl']; ?></td>
                                                    <td><?php echo $foolproof['tgt']; ?></td>
                                                    <td><?php echo $foolproof['usl']; ?></td>
                                                    <td><?php echo $foolproof['unit']; ?></td>
                                                    <td><?php echo $foolproof['measuring_equipment']; ?></td>
                                                    <td>
                                                        <?php if($foolproof['image'] == NULL){ echo 'NA'; }else{ ?>
                                                        <img src="<?php echo base_url().'assets/foolproof_captured/'.$foolproof['image']; ?>" 
                                                             height="70" width="100" alt="<?php $foolproof['image']; ?>" />
                                                        <?php } ?>
                                                    </td>
                                                    <?php 
                                                        if($foolproof['lsl'] == NULL && $foolproof['usl'] == NULL){
                                                            $value = 'NA';
                                                        }
                                                        else if($foolproof['lsl'] == '' && $foolproof['usl'] == ''){
                                                            $value = $foolproof['all_results'];
                                                        }else{
                                                            $value = $foolproof['all_values'];
                                                        }
                                                    ?>
                                                    <td><?php echo $value; ?></td>
                                                    <td><?php if($foolproof['result'] == NULL){ echo 'NA'; }else{ echo $foolproof['result']; } ?></td>
                                                    <!--<td nowrap>
                                                        <a class="button small gray" target="_blank" 
                                                            href="<?php echo base_url()."timecheck/view/".$plan['id'];?>">
                                                            <i class="fa fa-edit"></i> View
                                                        </a>
                                                        <a class="button small gray" target="_blank" 
                                                            href="<?php echo base_url()."reports/foolproof/?download=true";?>">
                                                            <i class="fa fa-edit"></i> Download
                                                        </a>
                                                        
                                                    </td>-->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <!--</div>-->
                                
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
</div>
