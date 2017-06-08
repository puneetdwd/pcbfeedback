<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($sp_mapping) ? 'Edit': 'Add'); ?> Supplier-Part Mapping
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."suppliers/sp_mappings"; ?>">
                        Manage Supplier-Part Mapping
                    </a>
            </li>
            <li class="active"><?php echo (isset($sp_mapping) ? 'Edit': 'Add'); ?> Supplier-Part Mapping</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
        
            <div class="portlet light bordered" id="add-sp-mapping-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Supplier-Part Mapping Form
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

                            <?php if(isset($sp_mapping['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $sp_mapping['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-ptc-mapping-product-error">
                                        <label class="control-label" for="product_id">Product:
                                        <span class="required">*</span></label>
                                        
                                        <select name="product_id" id="product-part-selector1" class="form-control required select2me"
                                        data-placeholder="Select Product" data-error-container="#add-ptc-mapping-product-error">
                                            <option value=""></option>
                                            
                                            <?php $sel_product = (!empty($sp_mapping['product_id']) ? $sp_mapping['product_id'] : ''); ?>
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>" 
                                                <?php if($sel_product == $product['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-ptc-mapping-part-error">
                                        <label class="control-label" for="part_id">Part:
                                        <span class="required">*</span></label>
                                        
                                        <select name="part_id" id="part-selector1" class="form-control required select2me"
                                        data-placeholder="Select Part" data-error-container="#add-ptc-mapping-part-error">
                                            <option value=""></option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-sp-mapping-supplier-error">
                                        <label class="control-label" for="supplier_id">Suppliers:
                                        <span class="required">*</span></label>
                                        
                                        <select name="supplier_id" id="add-sp-mapping-supplier" class="form-control required select2me"
                                        data-placeholder="Select Supplier" data-error-container="#add-sp-mapping-supplier-error">
                                            <option value=""></option>
                                            
                                            <?php $sel_supplier = (!empty($sp_mapping['supplier_id']) ? $sp_mapping['supplier_id'] : ''); ?>
                                            <?php foreach($suppliers as $supplier) { ?>
                                                <option value="<?php echo $supplier['id']; ?>" 
                                                <?php if($sel_supplier == $supplier['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $supplier['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'suppliers/sp_mappings'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>