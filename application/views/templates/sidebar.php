<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="false" data-auto-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <!--
            <li class="start ">
                <a href="<?php echo base_url(); ?>admin">
                    <i class="fa fa-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            -->
            
            <?php if($this->session->userdata('user_type') === 'Admin') { ?>
                <li class="start">
                    <a href="<?php echo base_url(); ?>users">
                        <i class="fa fa-users"></i>
                        <span class="title">Manage Users</span>
                    </a>
                </li>
            
                <li>
                    <a href="<?php echo base_url(); ?>products">
                        <i class="fa fa-briefcase"></i>
                        <span class="title">Manage Products</span>
                    </a>
                </li>
            
                <li>
                    <a href="<?php echo base_url(); ?>inspections">
                        <i class="fa fa-search"></i>
                        <span class="title">Manage Inspections</span>
                    </a>
                </li>
            
                <li>
                    <a href="<?php echo base_url(); ?>inspections/excluded_checkpoints">
                        <i class="icon-ban"></i>
                        <span class="title">Manage Excluded Checkpoints</span>
                    </a>
                </li>
            
                <li>
                    <a href="<?php echo base_url(); ?>sampling">
                        <i class="fa fa-list"></i>
                        <span class="title">Manage Sampling Plans</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>