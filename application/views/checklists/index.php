<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Checklists
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Checklists</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-offset-2 col-md-8">

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
                        <i class="fa fa-reorder"></i>
                        Checklists
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."checklist/add_checklist"; ?>">
                            <i class="fa fa-plus"></i> Add Checklist
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($checklists)) { ?>
                        <p class="text-center">No items exists yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Item No</th>
                                    <th>List Item</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($checklists as $checklist) { ?>
                                    <tr>
                                        <td><?php echo $checklist['item_no']; ?></td>
                                        <td><?php echo $checklist['list_item']; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."checklist/add_checklist/".$checklist['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to this List Item?" href="<?php echo base_url()."checklist/delete_checklist/".$checklist['id'];?>">
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