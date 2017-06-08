<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Checklist
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Checklist</li>
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
        <div class="col-md-6 col-md-offset-3">
        
            <div class="portlet light tasks-widget bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Checklist Items
                    </div>
                </div>

                
                <div class="portlet-body">
                    <div class="task-content">
                        <ul class="task-list">
                            <?php foreach($checklists as $checklist) { ?>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" /> 
                                    </div>
                                    <div class="task-title">
                                        <span class="task-title-sp" style="font-size:16px;"> <?php echo $checklist['list_item']; ?> </span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="task-footer">
                        <div class="pull-right">
                            <button class="button" type="button" id="submit-checklist">Submit</button>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>