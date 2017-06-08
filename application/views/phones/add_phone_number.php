<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($phone_number) ? 'Edit': 'Add'); ?> Phone Number
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."phones"; ?>">
                    Manage Phone Numbers
                </a>
            </li>
            <li class="active"><?php echo (isset($phone_number) ? 'Edit': 'Add'); ?> Phone Number</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Phone Number Form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if(isset($phone_number['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $phone_number['id']; ?>" />
                            <?php } ?>

                            <?php if(isset($suppliers)) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="add-phone-number-supplier-error">
                                            <label class="control-label" for="supplier_id">Supplier:
                                            <span class="required">*</span></label>
                                            
                                            <select name="supplier_id" class="form-control required select2me"
                                            data-placeholder="Select Supplier" data-error-container="#add-phone-number-supplier-error">
                                                <option value=""></option>
                                                
                                                <?php $sel_supplier = (!empty($phone_number['supplier_id']) ? $phone_number['supplier_id'] : ''); ?>
                                                <?php foreach($suppliers as $supplier) { ?>
                                                    <option value="<?php echo $supplier['id']; ?>" 
                                                    <?php if($sel_supplier == $supplier['id']) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $supplier['supplier_no'].' - '.$supplier['name']; ?>
                                                    </option>
                                                <?php } ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Supplier: </label>
                                        <br />
                                        <p class="form-control-static">
                                            <?php echo $this->session->userdata('supplier_no'); ?> - <?php echo $this->session->userdata('supplier_name'); ?> 
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:</label>
                                        <input type="text" class="form-control" name="name"
                                        value="<?php echo isset($phone_number['name']) ? $phone_number['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="phone_number">Phone Number:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="phone_number"
                                        value="<?php echo isset($phone_number['phone_number']) ? $phone_number['phone_number'] : '91'; ?>">
                                        <span class="help-block">
                                        Phone Number should start with 91 and after that 10 digit phone number e.g. 91XXXXXXXXXX
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'phones'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>