<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Phone Numbers
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Phone Numbers</li>
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

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Phone Numbers
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."phones/add_phone_number"; ?>">
                            <i class="fa fa-plus"></i> Add Phone Number
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($phone_numbers)) { ?>
                        <p class="text-center">No Phone Number exists yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th>Person Name</th>
                                    <th>Phone Number</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($phone_numbers as $phone_number) { ?>
                                    <tr>
                                        <td><?php echo $phone_number['supplier_no'].' - '.$phone_number['supplier_name']; ?></td>
                                        <td><?php echo $phone_number['name']; ?></td>
                                        <td><?php echo $phone_number['phone_number']; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."phones/add_phone_number/".$phone_number['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to this Phone Number?" href="<?php echo base_url()."phones/delete_phone_number/".$phone_number['id'];?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>