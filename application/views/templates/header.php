<!-- BEGIN HEADER -->

<style>
.dropdown-backdrop {
    position: unset !important;
    z-index : -1 !important;
}
    
</style><?php
$user_type=$this->session->userdata('user_type');
//echo "aaaaaa";
//print_r($this->session->userdata);die();

?>
<?php $page = isset($page) ? $page : ''; ?>
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a class="ir" href="<?php echo base_url(); ?>" id="logo" role="banner" title="Home" style="margin-top:0px;height:54px;">LG India</a>
                
                <!-- END LOGO -->
                
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">
                    <div style="text-align: right; margin-right: 10px;">
                        <span id="user-info">Welcome, <?php echo $this->session->userdata('name');
                                                             // print_r($this->session);
                                                                     // die; ?>
                        <?php if($this->product_id) { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> - <?php echo $this->session->userdata('product_name'); ?> ]</small>
                        <?php }
						else if($this->user_type == 'Supplier') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }
						else if($this->user_type == 'PCB') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }else if($this->user_type == 'Supplier Inspector') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }else if($this->user_type == 'LG User') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }else if($this->user_type == 'LG Repair') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }
						
						 else { ?>
                            <small> &nbsp; [ Super Admin ]</small>
                        <?php } ?>
                        </span>
                    
                    </div>
                    <div>
                        
                        <ul class="user-info-links">
                            <?php $allowed_products = $this->session->userdata('products'); ?>
                            <?php if(count($allowed_products) > 1) { ?>
                                <li>
                                    <div class="btn-group">
                                        <a class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" href="javascript:;"> 
                                            Switch Product
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php foreach($allowed_products as $ap) { ?>
                                                <li>
                                                    <a href="<?php echo base_url().'users/switch_product/'.$ap['id']; ?>"> 
                                                        <?php echo $ap['name']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?php echo base_url(); ?>users/change_password" class="btn btn-link btn-sm">
                                    Change Password
                                </a>
                            </li>
                            <li>
                                <?php if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector' || $this->user_type == 'PCB'){ ?>
                                    <a href="<?php echo base_url(); ?>supplier_logout" class="btn btn-link btn-sm">
                                        Log Out 
                                    </a>
                                <?php }else{ ?>
                                    <a href="<?php echo base_url(); ?>logout" class="btn btn-link btn-sm">
                                        Log Out 
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <!-- END TOPBAR ACTIONS -->
                
                <div class="page-logo-text page-logo-text-new text-left">SQIM - Supplier Quality Integrated Module</div>
            </div>
            <!-- BEGIN HEADER MENU -->
            <?php if(!isset($no_header_links)) { ?>
                <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse header-nav-links">
                    <ul class="nav navbar-nav">
                        <li class="<?php if($page == '') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>" target="_blank" class="text-uppercase">
                                <i class="icon-home"></i> Dashboard 
                            </a>
                        </li>
                        
                        <?php if($this->session->userdata('user_type') == 'Admin') { ?>
                        
                        
                            <li class="dropdown more-dropdown <?php if($page == 'masters') { ?>active selected<?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>users">
                                            <i class="icon-users"></i> Users 
                                        </a>
                                    </li>
                                    <?php if($this->session->userdata('is_super_admin')) { ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>products">
                                                <i class="icon-briefcase"></i> Products 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>suppliers">
                                                <i class="icon-briefcase"></i> Suppliers 
                                            </a>
                                        </li>
                                        
                                        <?php /*?><li>
                                            <a href="<?php echo base_url(); ?>lg_user">
                                                <i class="icon-briefcase"></i> LG Users 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>lg_repair_user">
                                                <i class="icon-briefcase"></i> LG Repair Users 
                                            </a>
                                        </li><?php */?>
                                    <?php } ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/parts">
                                            <i class="icon-briefcase"></i> Product Parts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>checkpoints">
                                            <i class="icon-briefcase"></i> Checkpoints
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>phones">
                                            <i class="icon-briefcase"></i> Phone Numbers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>checklist">
                                            <i class="icon-briefcase"></i> Checklist
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                   
                              
                        <?php } ?>
                        
                        <?php if($this->session->userdata('user_type') == 'Supplier') { ?>
                            <li class="dropdown more-dropdown <?php if($page == 'masters') { ?>active selected<?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>suppliers/view">
                                            <i class="icon-users"></i> Inspectors 
                                        </a>
                                    </li>
                                    <!--<li>
                                        <a href="<?php //echo base_url(); ?>suppliers/pcb_view">
                                            <i class="icon-users"></i> PCB Users 
                                        </a>
                                    </li>-->
                                    <li>
                                        <a href="<?php echo base_url(); ?>checkpoints">
                                            <i class="icon-briefcase"></i> Checkpoints
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>tc_checkpoints">
                                            <i class="icon-briefcase"></i> Timecheck Checkpoints
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>tc_checkpoints/plans">
                                            <i class="icon-briefcase"></i> Timecheck Plans
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>fool_proof">
                                            <i class="icon-briefcase"></i> Fool Proof Checkpoints
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Upload Mappings
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>fool_proof/pc_mappings">
                                            <i class="icon-briefcase"></i> Part-Checkpoint Mapping 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        
                        <?php if($this->session->userdata('user_type') == 'Admin') { ?>
                            
                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Upload Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/sp_master">
                                            <i class="icon-briefcase"></i> Supplier-Part Mapping 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown more-dropdown <?php if($page == 'masters') { ?>active selected<?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> PCB Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    
                                    <?php /*if($this->session->userdata('is_super_admin')) {*/ ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/defect">
                                                <i class="icon-briefcase"></i> Defect 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/category">
                                                <i class="icon-briefcase"></i> Category 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/cause_dept">
                                                <i class="icon-briefcase"></i> Cause Dept 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/status">
                                                <i class="icon-briefcase"></i> Status 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/aoi_detection_status">
                                                <i class="icon-briefcase"></i> Aoi detection status 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/aoi_detection_possibility">
                                                <i class="icon-briefcase"></i> Aoi detection possibility 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/dft_detection_status">
                                                <i class="icon-briefcase"></i> Dft detection status 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/dft_detection_possibility">
                                                <i class="icon-briefcase"></i> Dft detection possibility 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>masters/index/dft_revision">
                                                <i class="icon-briefcase"></i> Dft revision 
                                            </a>
                                        </li>
                                          <li>
                                            <a href="<?php echo base_url(); ?>masters/index/operator">
                                                <i class="icon-briefcase"></i> OPERATOR NAME 
                                            </a>
                                        </li>
                                        
                                    <?php //} ?>
                                </ul>
                            </li>
                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Mappings
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>suppliers/sp_mappings">
                                            <i class="icon-briefcase"></i> Supplier-Part Mapping 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        
                        
                        
                        <?php /*if($this->user_type == 'Supplier' || $this->user_type == 'Admin') { ?>    
                            <li class="<?php if($page == 'sampling_config') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>sampling/configs" target="_blank" class="text-uppercase">
                                    <i class="icon-home"></i> Inspection Planning <!--Sampling Config--> 
                                </a>
                            </li>
                        <?php }*/ ?>    
                        
                        <?php if($this->user_type == 'Supplier Inspector') { ?>
                            <li class="<?php if($page == 'inspections') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>register_inspection" class="text-uppercase">
                                    <i class="icon-magnifier"></i> Part Inspection 
                                </a>
                            </li>
                            <li class="<?php if($page == 'inspections') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>timecheck" class="text-uppercase">
                                    <i class="icon-magnifier"></i> Timecheck
                                </a>
                            </li>
                            <li class="<?php if($page == 'inspections') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>fool_proof/start" class="text-uppercase">
                                    <i class="icon-magnifier"></i> Fool Proof
                                </a>
                            </li>
                        <?php } ?>
                            
                        <?php if($this->user_type == 'Admin') { ?>
                        <li class="dropdown more-dropdown <?php if($page == 'checkpoints') { ?>active selected<?php } ?>">
                            <a href="javascript:;" class="text-uppercase">
                                <i class="icon-layers"></i> Approval 
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>checkpoints/checkpoint_approval_index" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Checkpoint Approval
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>tc_checkpoints/checkpoint_approval_index" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Timecheck Checkpoint Approval
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>fool_proof/checkpoint_approval_index" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Fool-Proof Checkpoint Approval
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        
                       
                        <li class="dropdown more-dropdown <?php if($page == 'reports') { ?>active selected<?php } ?>">
                            <a href="javascript:;" class="text-uppercase">
                                <i class="icon-layers"></i> Reports 
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>reports" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> View Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/lot_wise_report" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Lot Wise Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/timecheck" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Timecheck Report
                                    </a>
                                </li>
                                 <?php if($this->user_type == 'Admin') { ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/pcb_report" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> PCB Report
                                    </a>
                                </li>
                                
                                <li class="<?php if($page == 'pcb-feedback') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>feedback/all_user"  class="text-uppercase">
                                <i class="icon-home"></i> All PCB Feedback
                                </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php //} ?>
                        <?php 
						if($user_type == 'LG User'){ ?>
                        <li class="<?php if($page == 'pcb-feedback') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>feedback/lg_user"  class="text-uppercase">
                                <i class="icon-home"></i> Feedback
                            </a>
                        </li>
                        <?php }
						if($user_type == 'LG Repair'){ ?>
                        <li class="<?php if($page == 'pcb-feedback') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>feedback/lg_repair"  class="text-uppercase">
                                <i class="icon-home"></i> Feedback 
                            </a>
                        </li>
                        <?php }
						if($user_type == 'Supplier' || $user_type == 'Supplier Inspector'){ ?>
                        <li class="<?php if($page == 'pcb-feedback') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>feedback/pcb"  class="text-uppercase">
                                <i class="icon-home"></i> PCB FEEDBACK 
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->