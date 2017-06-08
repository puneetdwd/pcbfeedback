<style>
.form-group {
    margin-bottom: 0px;
}
</style>
<div class="modal-header">
    <h4 class="modal-title">Checkpoint Review form</h4>
</div>

<?php 
    $url = base_url().'auditer/review_checkpoint/'.$checkpoint['org_checkpoint_id'];
    if(isset($admin_edit_audit)) {
        $url .= "/".$admin_edit_audit;
    }
?>
<form role="form" class="confirmation-form validate-form" action="<?php echo $url; ?>" method="post">
    <div class="modal-body">
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger">
                <i class="fa fa-times"></i>
                <?php echo $error; ?>
            </div>
        <?php } ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-clip ribbon-color-danger uppercase">
                        <div class="ribbon-sub ribbon-clip"></div> <b>Checkpoint #<?php echo $checkpoint['checkpoint_no']; ?></b>
                    </div>
                    <div class="ribbon-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label"><b>Insp Item:</b></label>
                                <p class="form-control-static">
                                    <?php echo $checkpoint['insp_item']; ?>
                                </p>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label"><b>Insp Item:</b></label>
                                <p class="form-control-static">
                                    <?php echo $checkpoint['insp_item2']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!--<div class="col-md-6">
                                <label class="control-label"><b>Insp Item:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $checkpoint['insp_item3']; ?>
                                </p>
                            </div>-->
                            
                            <div class="col-md-12">
                                <label class="control-label"><b>Spec:</b></label><br />
                                <p class="form-control-static">
                                    <?php echo $checkpoint['spec']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:50px;">
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
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                
                <?php
                    $v = array('checkpoint' => $checkpoint);
                    $this->view('auditer/checkpoint_result_form', $v);
                ?>
                
            </div>
        </div>
    </div>
    
    <div class="modal-footer">
        <div class="form-actions text-center">
            <button type="button" class="btn default" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>