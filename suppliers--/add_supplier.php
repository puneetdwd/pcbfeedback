<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($supplier) ? 'Edit': 'Add'); ?> Supplier
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."suppliers"; ?>">
                        Manage Suppliers
                    </a>
            </li>
            <li class="active"><?php echo (isset($supplier) ? 'Edit': 'Add'); ?> Supplier</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Supplier Form
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

                            <?php if(isset($supplier['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>" />
                            <?php } ?>
                            
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Supplier Code:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="supplier_no"
                                        value="<?php echo isset($supplier['supplier_no']) ? $supplier['supplier_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Supplier Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name"
                                        value="<?php echo isset($supplier['name']) ? $supplier['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Supplier Email:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="email"
                                        value="<?php echo isset($supplier['email']) ? $supplier['email'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style='margin-top:4%'>
                                        <label class="control-label" for="type-supplier">Is Pcb Supplier
                                        <span class="required">*</span></label>
                                        <input type="checkbox" class="form-control" name="type-supplier"
                                        value="1" <?php echo isset($supplier['type-supplier']) && $supplier['type-supplier']==1?'checked':''; ?>>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" <?php echo isset($supplier['type-supplier']) &&  $supplier['type-supplier']==1 ? "style='display:block'" : "style='display:none'" ; ?>>
                                        <label class="control-label" for="suffixVal">Suffix Value:</label>
                                        <input type="text"  class=" form-control" name="suffixVal" id="suffixVal"
                                        value="<?php echo isset($supplier['suffixVal']) ? $supplier['suffixVal'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                                
                        </div>
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'suppliers'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<script>
$(document).ready(function(){
	$('input[type="checkbox"]').click(function(){
		
    if($(this).is(":checked")){
		$('#suffixVal').parent().css('display','block');
        //alert("Checkbox is checked.");

    }

    else if($(this).is(":not(:checked)")){
		$('#suffixVal').parent().css('display','none');
       // alert("Checkbox is unchecked.");

    }

});	
})

</script>