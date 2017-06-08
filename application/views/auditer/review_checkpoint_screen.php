<style>
.form-group{
    margin-bottom: 0px;
}
.table > thead > tr > th,.table > tbody > tr > td{
    padding : 4px 8px;
}
.btn-block{
    display: inline;
}
.mt-element-ribbon .ribbon{
    top: 6px;
}
.portlet.light > .portlet-title{
    min-height: 30px;
}
.portlet > .portlet-title{
    margin-bottom: 2px;
}
.portlet.light > .portlet-title > .actions {
    padding: 0 0 8px;
}
textarea.form-control {
    overflow-y: unset;
}
.mt-element-ribbon .ribbon {
    padding: 0.2em 1em;
}
.form-control-static{
    min-height: 25px;
    padding-top: 0;
}

.portlet.light.bordered > .portlet-title {
    border-bottom: 1px solid #ddd;
}
.portlet.light.bordered {
    border: 1px solid #ddd !important;
}
.guideline-image-section {
    /*height:350px;*/
    overflow-y:scroll;
    margin-bottom:20px;
}
.help-block {
    margin:0px;
}
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
    width: 100%;
    margin: auto;
}
.carousel-control.right{
    background-image: none;
}
.carousel-control.left{
    background-image: none;
}
.carousel-caption, .carousel-control{
    color: #C80541 !important;
}
.carousel-indicators li{
    border: 1px solid #C80541;
}
.carousel-indicators .active{
    background-color: #C80541;
}
</style>

<div class="page-content" style="padding:20px 10px;">

    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs" style="margin-bottom:5px;">
        <h1>
            Part Inspection | Checkpoint Screen | <?php echo $this->session->userdata('current_key')." of ".count($this->session->userdata('nos')); ?>
        </h1>
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
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
    </div>
        
    <div class="row">    
        <div class="col-md-12">
            <div class="portlet light bordered" style="padding-top: 5px; padding-bottom: 0px; margin-bottom: 2px;">

                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="">
                                <label class="control-label"><b>Supplier:</b></label>
                                <p class="form-control-static">
                                    <?php echo $audit['supplier_no'].' - '.$audit['supplier_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="">
                                <label class="control-label"><b>Product:</b></label>
                                <p class="form-control-static">
                                    <?php echo $audit['product_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="">
                                <label class="control-label"><b>Part:</b></label>
                                <p class="form-control-static">
                                    <?php echo $audit['part_no'].' - '.$audit['part_name']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="">
                                <label class="control-label"><b>Lot Qty:</b></label>
                                <p class="form-control-static">
                                    <?php echo $audit['prod_lot_qty']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="">
                                <label class="control-label"><b>LOT No.:</b></label>
                                <p class="form-control-static">
                                    <?php echo $audit['lot_no']; ?>
                                </p>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered mt-element-ribbon" style="padding-top: 8px;">
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip"></div> <b>Checkpoint #<?php echo $checkpoint['checkpoint_no']?></b> 
                </div>
                <div class="portlet-title">

                    <div class="actions">
                        <?php if(!empty($checkpoint['result'])) { ?>
                            <p class="font-red-mint" style="display:inline;"> Checkpoint already marked as <b><?php echo $checkpoint['result']; ?></b> </p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body" style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <?php $class = 'col-md-6'; ?>
                                    <div class="<?php echo $class; ?>">
                                        <div class="form-group">
                                            <label class="control-label"><b>Insp Type:</b></label>
                                            <p class="form-control-static">
                                                <?php echo $checkpoint['insp_item']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="<?php echo $class; ?>">
                                        <div class="form-group">
                                            <label class="control-label"><b>Insp Item:</b></label>
                                            <p class="form-control-static">
                                                <?php echo $checkpoint['insp_item2']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="control-label"><b>Spec:</b></label>
                                            <p class="form-control-static">
                                                <?php echo $checkpoint['spec']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php //if($doc != ''){ ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"><b>Drawing:</b></label>
                                            <p class="form-control-static">
                                                <a href="#" data-toggle="modal" data-target="#modal-agreement" id="pdf_link" >Click Here</a>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="modal-agreement">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-body">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
					      
                                                <!-- Bootstrap PDF Viewer -->
                                                <object type="application/pdf" data="data:application/pdf;base64,<?php echo base64_encode($doc); ?>" 
						width="100%" height="500" id="blob_file" >No Object </object>
                                                
                                            </div>
                                          </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <?php //} ?>
                                    
                                </div>
                                
                                <div class="row guideline-image-section">
                                
                                    <?php if(sizeof($checkpoint_images) == 1) { 
                                    
                                        for($i=0; $i<sizeof($checkpoint_images); $i++) { 
                                            if($checkpoint_images[$i] != ''){
                                                $img_path = base_url().'assets/inspection_guides/'.$audit['product_name'].'/'.$audit['part_no'].'/'.$checkpoint_images[$i].'.JPG';
                                            } else { 
                                                $img_path = base_url().'assets/inspection_guides/default_guide.jpg';
                                            }
                                    ?>
                                    <div class="col-md-12" style="background-color: #dfdfdf;">
                                        <img src="<?php echo $img_path; ?>" style="width:100%;"/>
                                    </div>
                                    <!--<div class="container">-->
                                        <?php } }else{ ?>
                                        <br>
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                                          <!-- Indicators -->
                                          <ol class="carousel-indicators">
                                            <?php for($i=0; $i<sizeof($checkpoint_images); $i++){ 
                                                if($i==0){
                                                    $act = 'active';
                                                }else{
                                                    $act = '';
                                                }
                                                ?>
                                                <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $act; ?>"></li>
                                            <?php } ?>
                                            <!--<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#myCarousel" data-slide-to="1"></li>
                                            <li data-target="#myCarousel" data-slide-to="2"></li>
                                            <li data-target="#myCarousel" data-slide-to="3"></li>-->
                                          </ol>

                                          <!-- Wrapper for slides -->
                                          <div class="carousel-inner" role="listbox">
                                              
                                              <?php for($i=0; $i<sizeof($checkpoint_images); $i++){ 
                                                if($i==0){
                                                    $act = 'active';
                                                }else{
                                                    $act = '';
                                                }
                                                //$img_path = base_url().'assets/inspection_guides/'.$audit['product_name'].'/'.$audit['part_no'].'/'.$checkpoint_images[$i].'.jpg';
                                                if($checkpoint_images[$i] != ''){
                                                    $img_path = base_url().'assets/inspection_guides/'.$audit['product_name'].'/'.$audit['part_no'].'/'.$checkpoint_images[$i].'.JPG';
                                                }else{
                                                    $img_path = base_url().'assets/inspection_guides/default_guide.jpg';
                                                }
                                                
                                                ?>
                                                    <div class="item <?php echo $act; ?>">
                                                      <img src="<?php echo $img_path; ?>" alt="<?php echo $audit['part_no']; ?>">
                                                    </div>
                                              <?php } ?>

                                            <!--<div class="item">
                                              <img src="<?php echo base_url(); ?>assets/checkpoint_gallery/MAY67408772/slide1.jpg" alt="Chania">
                                            </div>

                                            <div class="item">
                                              <img src="<?php echo base_url(); ?>assets/checkpoint_gallery/MAY67408772/slide2.jpg" alt="Flower">
                                            </div>

                                            <div class="item">
                                              <img src="<?php echo base_url(); ?>assets/checkpoint_gallery/MAY67408772/slide3.jpg" alt="Flower">
                                            </div>-->
                                          </div>

                                          <!-- Left and right controls -->
                                          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                          </a>
                                          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                          </a>
                                        </div>
                                        <?php } ?>
                                      </div>
                                <!--</div>-->
                                
                                
                            </div>

                            <div class="col-md-3">
                                <div class="portlet light"  style="padding: 6px 10px;">
                                    <div class="portlet-title">
                                        <b>Inspection Results</b> 
                                    </div>
                                    <div class="portlet-body form">
                                        <?php $all_values = explode(',', $checkpoint['all_values']); ?>
                                        <?php $all_results = explode(',', $checkpoint['all_results']); ?>
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Sample No</th>
                                                    <th class="text-center">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for($i = 1; $i <= $checkpoint['sampling_qty']; $i++) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $audit['lot_no'].'_'.$i; ?></td>
                                                        <td>
                                                            <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                                                                <?php echo isset($all_values[$i-1]) ? $all_values[$i-1] : ''; ?>
                                                            <?php } else { ?>
                                                                <?php echo isset($all_results[$i-1]) ? $all_results[$i-1] : ''; ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        
                                        <div class="row">
                                            <div class="col-md-12" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <label for="remark" class="control-label">Remarks: </label>
                                                    <?php echo $checkpoint['remark']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sampling Qty.</th>
                                                    <th>LSL</th>
                                                    <th>Target</th>
                                                    <th>USL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $checkpoint['sampling_qty']; ?></td>
                                                    <td><?php echo ($checkpoint['lsl']) ? $checkpoint['lsl'].' '.$checkpoint['unit'] : '--'; ?></td>
                                                    <td><?php echo ($checkpoint['tgt']) ? $checkpoint['tgt'].' '.$checkpoint['unit'] : '--'; ?></td>
                                                    <td><?php echo ($checkpoint['usl']) ? $checkpoint['usl'].' '.$checkpoint['unit'] : '--'; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-actions text-center">
                                    <?php $nos = $this->session->userdata('nos'); ?>
                                    <?php if($checkpoint['org_checkpoint_id'] != $nos[0]) { ?>
                                        <a href="<?php echo base_url().'auditer/navigate_checkpoint/prev/'.$audit['id']; ?>" class="btn btn-circle red-sunglo btn-outline pull-left">Previous</a>
                                    <?php } ?>
                                    
                                    <?php if($checkpoint['org_checkpoint_id'] != $nos[count($nos)-1]) { ?>
                                        <a href="<?php echo base_url().'auditer/navigate_checkpoint/next/'.$audit['id']; ?>" class="btn btn-circle red-sunglo btn-outline pull-right"> Next </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<script>
$(document).ready(function(){
    $("header").remove();
});
</script>
