<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid-theme.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/demos.css" />

<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            <?php echo $this->session->userdata('name'); ?>
            <small>Welcome to your dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">Dashboard</li> 
        </ol>
        
    </div>
        
    <?php if($this->session->flashdata('error')) {?>
        <div class="alert alert-danger">
           <i class="icon-remove"></i>
           <?php echo $this->session->flashdata('error');?>
        </div>
    <?php } else if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i>
           <?php echo $this->session->flashdata('success');?>
        </div>
    <?php } ?>
    <div class="row">
    </div>
</div>
