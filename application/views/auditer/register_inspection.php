<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Part Inspection | Register Screen
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Part Inspection</li>
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
        <div class="col-md-12">
        
            <div class="portlet light bordered register-inspection-form-portlet" id="register-inspection-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Register Inspection Form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" id="register-inspection-form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            
                            <input type="hidden" id="supplier_id" name="supplier_id" 
                                   value="<?php echo $this->session->userdata('supplier_id'); ?>" >
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Inspection Date:
                                        <!--<span class="required"> * </span>--></label>
                                        <!--<div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">-->
                                            <input id="audit_date" name="audit_date" type="text" class="required form-control" readonly
                                            value="<?php echo date('Y-m-d h:i:s A'); ?>">
                                            <!--<span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Inspector: </label>
                                        <br />
                                        <p class="form-control-static">
                                            <?php echo $this->session->userdata('supplier_no'); ?> - <?php echo $this->session->userdata('supplier_name'); ?> 
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="register-inspection-part-error">
                                        <label class="control-label" for="product_id">Part:
                                        <span class="required">*</span></label>
                                        
                                        <select name="part_id" class="form-control required select2me"
                                        data-placeholder="Select Part" data-error-container="#register-inspection-part-error">
                                            <option value=""></option>
                                            
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>">
                                                    <?php echo $part['name'].' ('.$part['part_no'].')'; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="prod_lot_qty">Inspection Lot Qty.:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="prod_lot_qty" value="">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Register Inspection</button>
                            <a href="<?php echo base_url(); ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>