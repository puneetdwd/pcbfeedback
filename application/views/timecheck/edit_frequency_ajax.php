<div class="modal-header">
    <h4 class="modal-title">Timecheck Frequency Edit</h4>
</div>
<form role="form" class="adjust-timecheck-form validate-form form-horizontal" action="<?php echo base_url()."timecheck/edit_freq/".$detail; ?>" method="post">
    <div class="modal-body">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            Please fill No of Samples or else SKIP.
        </div>
        <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>LSL</th>
                                <th>USL</th>
                                <th>TGT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo ($checkpoint['lsl']) ? $checkpoint['lsl'].' '.$checkpoint['unit'] : '--'; ?></td>
                                <td><?php echo ($checkpoint['usl']) ? $checkpoint['usl'].' '.$checkpoint['unit'] : '--'; ?></td>
                                <td><?php echo ($checkpoint['tgt']) ? $checkpoint['tgt'].' '.$checkpoint['unit'] : '--'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="result">Value:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="result" value="<?php echo $value; ?>">
                        </div>
                    </div>
                </div>
            </div>
            
        <?php } else { ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="value">Result:</label>
                        <div class="col-md-8">
                            <select class="form-control input-sm" name="result">
                                <option value="OK" <?php if($value == 'OK') { ?>selected="selected"<?php } ?>>OK</option>
                                <option value="NG" <?php if($value == 'NG') { ?>selected="selected"<?php } ?>>NG</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
    
    <div class="modal-footer">
        <button type="button" class="adjust-sampling-modal-close button white" data-dismiss="modal">Close</button>
        <button type="submit" id="adjust-sampling-modal-save" class="button">Save</button>
    </div>
</form>