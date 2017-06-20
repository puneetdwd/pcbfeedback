<?php
$typeArr=explode('_',ucfirst($type));
$m_type=implode(' ',$typeArr);
?>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage <?php echo $m_type; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Masters</li>
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
                        <i class="fa fa-reorder"></i>List of <?php echo $m_type; ?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."masters/add/".$type; ?>">
                            <i class="fa fa-plus"></i> Add New <?php echo $m_type; ?>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php 
					
					//print_r($masters);die;
					if(empty($masters)) { ?>
                        <p class="text-center">No <?php echo $m_type; ?> exist yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th class="no_sort" style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($masters as $master) { ?>
                                    <tr>
                                        <td><?php echo $master["id"]; ?></td>
                                        <td><?php echo $master["name"]; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."masters/add/".$type."/".$master["id"];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."masters/delete/".$type."/".$master["id"];?>">
                                                <i class="fa fa-remove"></i> Delete
                                            </a>
                                        </td>
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