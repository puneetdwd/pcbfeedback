
    
    <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
        <input type="hidden" value="<?php echo $checkpoint['lsl']; ?>"  id="register-inspection-checkpoint-lsl" />
        <input type="hidden" value="<?php echo $checkpoint['usl']; ?>"  id="register-inspection-checkpoint-usl" />
        
        <input type="hidden" value="value"  id="checkpoint-result-type" />
    <?php } else { ?>
        <input type="hidden" value="radio"  id="checkpoint-result-type" />
    <?php } ?>
    
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
                    <td class="text-center"><?php echo $audit['lot_no'].$i; ?></td>
                    <td>
                        <?php if(!empty($checkpoint['lsl']) || !empty($checkpoint['usl'])) { ?>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2" style="padding-right:0px;">
                                    <div class="form-group">
                                        <input type="text" class="required form-control input-sm audit_values" id="audit_value_<?php echo $i; ?>" onkeydown="return int_n_float_only();" name="audit_value_<?php echo $i; ?>" value="<?php echo isset($all_values[$i-1]) ? $all_values[$i-1] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <?php $res = isset($all_results[$i-1]) ? $all_results[$i-1] : ''; ?>
                                            <label class="radio-inline" style="padding-left:0;">
                                                <input class="required audit_result_<?php echo $i; ?>" type="radio" name="audit_result_<?php echo $i; ?>" value="OK" <?php if($res == 'OK') { ?> checked="checked" <?php } ?>> OK
                                            </label>
                                            <label class="radio-inline" style="padding-left:0;">
                                                <input class="required audit_result_<?php echo $i; ?>" type="radio" name="audit_result_<?php echo $i; ?>" value="NG" <?php if($res == 'NG') { ?> checked="checked" <?php } ?>> NG
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <button type="button" id="ng-confirm" class="btn btn-block red-sunglo" style="display:none;">NG</button>
    <button type="submit" id="na-button" name="result" value="NA" class="btn yellow-gold" style="display:none;">NA</button>
    <button type="submit" id="ng-button" class="btn btn-block red-sunglo" style="display:none;">NG</button>
    <div class="row">
        <div class="col-md-12" style="padding-right: 0;">
            <div class="form-group">
                <label for="remark" class="control-label">Remarks: </label>
                <textarea class="form-control" id="register-inspection-remark" name="remark" placeholder="Remarks" rows="2"><?php echo $checkpoint['remark']; ?></textarea>
                <span class="help-block"></span>
                
            </div>
        </div>
    </div>
    
    <div class="form-actions text-center">
        <button type="submit" id="register-inspection-submit" class="btn btn-circle green-meadow">Submit</button>
    </div>
