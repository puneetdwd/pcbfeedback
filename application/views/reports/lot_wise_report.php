<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">View Report</li>
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
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Date Range</label>
                                                <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                    <input type="text" class="form-control" name="start_range" 
                                                    value="<?php echo $this->input->post('start_range'); ?>">
                                                    <span class="input-group-addon">
                                                    to </span>
                                                    <input type="text" class="form-control" name="end_range"
                                                    value="<?php echo $this->input->post('end_range'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-4">
                                            <div class="form-group" id="report-sel-part-error">
                                                <label class="control-label">Select Part:</label>
                                                        
                                                <select name="part_no" class="form-control select2me"
                                                    data-placeholder="Select Part" data-error-container="#report-sel-part-error">
                                                    <option></option>
                                                    <?php foreach($parts as $part) { ?>
                                                        <option value="<?php echo $part['part_no']; ?>" <?php if($part['part_no'] == $this->input->post('part_no')) { ?> selected="selected" <?php } ?>>
                                                            <?php echo $part['part_no']; ?>
                                                        </option>
                                                    <?php } ?>        
                                                </select>
                                            </div>
                                        </div>

                                    <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                        <div class="col-md-4">
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
                                    <?php if($this->session->userdata('is_super_admin')){ ?>
                                        <label class="control-label" for="supplier_id">All Product:</label>
                                        <input type="checkbox" name="product_all" class="form-control" value="all" 
                                        <?php if($this->input->post('product_all') == 'all'){echo "checked";} ?> />
                                    <?php } ?>
                                    <button class="button" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12" style="padding:0;">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>List of Inspections
                            </div>
                            <div class="actions">
                                <!--<a class="button normals btn-circle" onclick="printPage('part_insp_table');" href="javascript:void(0);">
                                    <i class="fa fa-print"></i> Print
                                </a>-->
                                <?php $supplier_id = ($this->input->post('supplier_id'))?$this->input->post('supplier_id'):$this->supplier_id; ?>
                                <?php if($this->input->post()){ ?>
                                <a class="button normals btn-circle" href="<?php echo base_url()."reports/lot_wise_report/".$this->input->post('date')."/".$supplier_id;?>">
                                    <i class="fa fa-print"></i> Download
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php if(empty($audits)) { ?>
                                <p class="text-center">No inspection done yet.</p>
                            <?php } else { ?>
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                                
                                <!--<div class="table-scrollable">-->
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="merged-cell text-center">Last Inspect Date</th>
                                                <th rowspan="2" class="merged-cell text-center">Product</th>
                                                <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                                    <th rowspan="2" class="merged-cell text-center">Supplier</th>
                                                <?php } ?>
                                                <th rowspan="2" class="merged-cell text-center">Part</th>
                                                <th colspan="3" class="merged-cell text-center">No. Of Lots</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Inspected</th>
                                                <th class="text-center">OK</th>
                                                <th class="text-center">NG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($audits as $audit) { ?>
                                                <tr>
                                                    <td nowrap><?php echo date('jS M, y', strtotime($audit['audit_date'])); ?></td>
                                                    <td><?php echo $audit['product_name']; ?></td>
                                                    <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                                        <td><?php echo $audit['supplier_no'].' - '.$audit['supplier_name']; ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $audit['part_no'].' - '.$audit['part_name']; ?></td>
                                                    <td class="text-center"><?php echo $audit['no_of_lots']; ?></td>
                                                    <td class="text-center"><?php echo $audit['ok_lots']; ?></td>
                                                    <td class="text-center"><?php echo $audit['ng_lots']; ?></td>
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
<?php if(!empty($audits)) { ?>
    <script>
        $(window).load(function() {
            $('.check-judgement-button:first').trigger('click');
            
            $('.pagination-sec').bootpag({
                total: <?php echo $total_page; ?>,
                page: <?php echo $page_no; ?>,
                maxVisible: 5,
                leaps: true,
                firstLastUse: true,
                first: 'â†?',
                last: 'â†’',
                wrapClass: 'pagination',
                activeClass: 'active',
                disabledClass: 'disabled',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first'
            }).on("page", function(event, num){
                show_page(num); // or some ajax content loading...
            }); 
        });
    </script>
<?php } ?>
