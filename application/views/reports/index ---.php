<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Report
        </h1>
        <ol class="breadcrumb">
           
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
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>List of Inspections
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
                                                <th>Date</th>
                                                <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                                    <th>Supplier</th>
                                                <?php } ?>
                                                <th>Lot No</th>
                                                <th>Part Name</th>
                                                <th>Part No</th>
                                                <th>Insp Qty.</th>
                                                <th>Judgment</th>
                                                <th>Inspector Name</th>
                                                <th class="no_sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($audits as $audit) { ?>
                                                <tr>
                                                    <td nowrap><?php echo date('jS M, y', strtotime($audit['audit_date'])); ?></td>
                                                    <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector') { ?>
                                                        <td><?php echo $audit['supplier_name']; ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $audit['lot_no']; ?></td>
                                                    <td><?php echo $audit['part_name']; ?></td>
                                                    <td><?php echo $audit['part_no']; ?></td>
                                                    <td><?php echo $audit['prod_lot_qty']; ?></td>
                                                    <td class="judgement-col">
                                                        <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading" style="display:none;">
                                                    </td>
                                                    <td><?php echo $audit['inspector_name']; ?></td>
                                                    <td nowrap>
                                                        <a class="check-judgement-button button small gray" href="<?php echo base_url().'reports/check_judgement/'.$audit['id']; ?>" data-id="<?php echo $audit['id']; ?>" style="display:none;"> 
                                                            check
                                                        </a>
                                                        
                                                        <?php if($this->user_type == 'Admin') { ?>
                                                            <a class="button small gray" target="_blank" 
                                                                href="<?php echo base_url()."auditer/finish_screen/".$audit['id'];?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                        <?php } ?>
                                                        
                                                        <?php if($this->user_type == 'LG Inspector') { ?>
                                                            <a class="button small gray" target="_blank" 
                                                                href="<?php echo base_url()."auditer/review_inspection/".$audit['id']."/true";?>">
                                                                <i class="fa fa-edit"></i> Review
                                                            </a>
                                                        <?php } ?>
                                                        
                                                        <a class="button small gray" target="_blank" 
                                                            href="<?php echo base_url()."reports/part_inspection_report/".$audit['id'];?>">
                                                            <i class="fa fa-edit"></i> View
                                                        </a>
                                                        <a class="button small gray" target="_blank" 
                                                            href="<?php echo base_url()."reports/part_inspection_report/".$audit['id']."?download=true";?>">
                                                            <i class="fa fa-edit"></i> Download
                                                        </a>
                                                        
                                                    </td>
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
                first: '←',
                last: '→',
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
