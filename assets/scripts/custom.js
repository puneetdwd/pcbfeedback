 $(document).ready(function() {

    var base_url = $('#base_url').val();
    
    $('.dashboard-progress-section').load(base_url+'dashboard/show_day_progress');
    
    if($('#existing_checkpoints').length > 0) {
        $('#add-checkpoint-form').submit(function() {
            var check_no = $('#add-checkpoint-no').val();
            var existing = $('#existing_checkpoints').val();
            
            existing = existing.split(','); 
            if($.inArray(check_no, existing) > -1) {
                bootbox.dialog({
                    message: 'Checkpoint No '+check_no+' already exists for this inspection, Do you still want to place it at this position and shift other by 1?',
                    title: "Confirmation box",
                    buttons: {
                        confirm: {
                            label: "Continue",
                            className: "red",
                            callback: function() {
                                $('#add-checkpoint-form')[0].submit();
                            }
                        },
                        cancel: {
                            label: "Cancel",
                            className: "blue"
                        }
                    }
                });
                
                return false;
            }
        });
    }
    
    $('#product-part-selector').change(function() {
        var portlet_id = $('#product-part-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector :selected').val() != '') {
                    $('#part-selector').select2('val', null);
                }
                
                $('#part-selector').html('');
                
                $('#part-selector').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name+' ('+item.code+')', 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('#product-part-selector1').change(function() {
        var portlet_id = $('#product-part-selector1').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector1 :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector1 :selected').val() != '') {
                    $('#part-selector1').select2('val', null);
                }
                
                $('#part-selector1').html('');
                
                $('#part-selector1').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector1').append($('<option>', { 
                        value: item.id,
                        text : item.name+' ('+item.code+')', 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('#product-part-selector-supplier').change(function() {
        var portlet_id = $('#product-part-selector-supplier').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector-supplier :selected').val();
        var supplier_id = $('#supplier_id').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_all_product_parts_by_supplier',
            data: { product: product, supplier_id : supplier_id},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector-insp :selected').val() != '') {
                    $('#part-selector').select2('val', null);
                }
                
                $('#part-selector-insp').html('');
                
                $('#part-selector-insp').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector-insp').append($('<option>', { 
                        value: item.id,
                        text : item.name+' ('+item.code+')', 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('#product-part-selector-new').change(function() {
        var portlet_id = $('#product-part-selector-new').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector-new :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_distinct_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector :selected').val() != '') {
                    $('#part-selector').select2('val', null);
                }
                
                $('#part-selector').html('');
                
                $('#part-selector').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector').append($('<option>', { 
                        value: item.name,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('#part-selector').change(function() {
        var portlet_id = $('#part-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part_name = $('#part-selector :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_part_numbers_by_part_name',
            data: { part_name: part_name},
            dataType: 'json',
            success: function(resp) {
                if($('#part-number-selector :selected').val() != '') {
                    $('#part-number-selector').select2('val', null);
                }
                
                $('#part-number-selector').html('');
                
                $('#part-number-selector').append('<option value=""></option>');
                $.each(resp.part_nums, function (i, item) {
                    $('#part-number-selector').append($('<option>', { 
                        value: item.id,
                        text : item.code, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('.check-judgement-button').click(function() {
        var target = $(this).attr('href');
        var audit_id = $(this).attr('data-id');
        
        var current_row = $(this).closest('tr');
        
        current_row.find('.judgement-col .loading').show();
        
        $.ajax({
            type: 'POST',
            url: target,
            data: { audit_id: audit_id},
            dataType: 'json',
            success: function(resp) {
                if(resp.status === 'success') {
                    current_row.find('.judgement-col').html(resp.judgement);
                }
                
                current_row.next('tr').find('.check-judgement-button').trigger('click');
            }
        });
        
        return false;
    });
    
    if($('#page').length > 0 && $('#page').val() == 'realtime_dashboard') {
        setInterval(function() { realtime_dashboard(); }, 800000000);
    }
    var line_index = 1;
    $('#add-sampling-item').click(function() {
        $('#sampling-item-clone').find( ".sampling-item" ).clone().appendTo( ".items" ).addClass('sampling-item-'+line_index);
        //invoice_activate_plugins(line_index);
        line_index++;
    });
    
    $('#add-lot-range').click(function() {
        var lot_index = $('#lot-index').val();
        $('#lot-item-clone').find( ".lot-item" ).clone().appendTo( ".items" ).addClass('lot-item-'+lot_index);
        
        $('.lot-item-'+lot_index).find('.lower-val-input').attr('name', 'lower_val['+lot_index+']');
        $('.lot-item-'+lot_index).find('.higher-val-input').attr('name', 'higher_val['+lot_index+']');
        $('.lot-item-'+lot_index).find('.samples-val-input').attr('name', 'no_of_samples['+lot_index+']');
        lot_index++;
        $('#lot-index').val(lot_index);
    });
    
    $('.items').on('click', '.remove-lot-range', function() {
        $(this).closest('.lot-item').remove();
    });
    
    /*$('#add-user-type-sel').change(function() {
        var user_type = $('#add-user-type-sel :selected').val();
        
        if(user_type == 'Supplier') {
            $('#supplier_code_div').show();
        }else{
            $('#supplier_code_div').hide();
        }
    });*/
    
    $('#inspection-config-sampling-type').change(function() {
        var sampling_type = $('#inspection-config-sampling-type :selected').val();
        
        $('.type-specific-div').hide();
        if(sampling_type == 'Auto') {
            $('#type-auto-div').show();
        } else if(sampling_type == 'User Defined') {
            $('#lot-size-div').show();
        } else if(sampling_type == 'C=0') {
            $('#type-c0-div').show();
        } else if(sampling_type == 'Fixed') {
            $('#type-fixed-div').show();
        }
    });
    
    $('#product-part-selector').change(function() {
        var portlet_id = $('#product-part-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector :selected').val() != '') {
                    $('#part-selector').select2('val', null);
                }
                
                $('#part-selector').html('');
                
                $('#part-selector').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name+' ('+item.code+')', 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('#register-inspection-product').change(function() {
        
        App.blockUI({
            target: '.register-inspection-form-portlet',
            boxed: true
        });
        
        var product = $('#register-inspection-product :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'auditer/get_inspections_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#register-inspection-inspection :selected').val() != '') {
                    $('#register-inspection-inspection').select2('val', null);
                }
                
                $('#register-inspection-inspection').html('');
                
                $('#register-inspection-inspection').append('<option value=""></option>');
                $.each(resp.inspections, function (i, item) {
                    $('#register-inspection-inspection').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                App.unblockUI('.register-inspection-form-portlet');
            }
        });
    });
    
    $('#dashboard-barcode-scan').change(function() {
        App.blockUI({
            target: '#dashboard-on-going-insp',
            boxed: true
        });
        
        var barcode = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'auditer/get_barcode_details',
            data: { barcode: barcode},
            dataType: 'json',
            success: function(resp) {
                if(resp.BUYER_SERIAL_NO) {
                    $(".dashboard-on-going-insp-table tbody tr:not('.table-title-row')").each(function() {
                        var current_sn = $(this).find('.dashboard-on-going-insp-table-serial-no').html();
                      
                        if(current_sn != resp.BUYER_SERIAL_NO) {
                            $(this).hide();
                        }
                    });
                } else {
                    $(".dashboard-on-going-insp-table tbody tr:not('.table-title-row')").show();
                }
                
                App.unblockUI('#dashboard-on-going-insp');
            }
        });
    });
    
    $('#barcode-scan').change(function() {
        
        App.blockUI({
            target: '.register-inspection-form-portlet',
            boxed: true
        });
        
        var barcode = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'auditer/get_barcode_details',
            data: { barcode: barcode},
            dataType: 'json',
            success: function(resp) {
                if(resp.MTRLID) {
                    $('#register-inspection-model-suffix').val(resp.MTRLID);
                } else {
                    $('#register-inspection-model-suffix').val('');
                }
                if(resp.BUYER_SERIAL_NO) {
                    $('#register-inspection-serial').val(resp.BUYER_SERIAL_NO);
                } else {
                    $('#register-inspection-serial').val('');
                }
                if(resp.LINE) {
                    $('#register-inspection-line').select2('val', resp.LINE);
                } else {
                    $('#register-inspection-line').select2('val', null);
                }
                if(resp.WO_NAME) {
                    $('#register-inspection-workorder').val(resp.WO_NAME);
                } else {
                    $('#register-inspection-workorder').val('');
                }
                
                App.unblockUI('.register-inspection-form-portlet');
            }
        });
    });
    
    
    var show_registration_pop = false;
    $('#register-inspection-inspection').change(function() {
        App.blockUI({
            target: '.register-inspection-form-portlet',
            boxed: true
        });
        
        $(this).closest('form').ajaxSubmit({
            url: base_url+'auditer/get_model_sampling_details',
            success:function(data) {
                data = $.parseJSON(data);
                if(data.lot_size) {
                    $('#ri-production-lot').html(data.lot_size);
                } else {
                    $('#ri-production-lot').html('');
                }
                if(data.no_of_samples) {
                    $('#ri-sampling-plan').html(data.no_of_samples);
                } else {
                    $('#ri-sampling-plan').html('');
                }
                
                if(data.completed) {
                    $('#ri-completed').html(data.completed);
                } else {
                    $('#ri-completed').html('');
                }
                
                if(data.in_progess) {
                    $('#ri-in-progress').html(data.in_progess);
                } else {
                    $('#ri-in-progress').html('');
                }
                
                if(data.lot_size) {
                    if(parseInt(data.no_of_samples) <= (parseInt(data.completed)+parseInt(data.in_progess))) {
                        show_registration_pop = true;
                    } else {
                        show_registration_pop = false;
                    }
                    
                    $('#ri-suggestion-box').show();
                } else {
                    $('#ri-suggestion-box').hide();
                }
                
                App.unblockUI('.register-inspection-form-portlet');
            }
        });
    });
    
    $('#register-inspection-form').submit(function() {
        if($(this).valid()) {
            if(show_registration_pop) {
                bootbox.dialog({
                    message: 'Sampling plan for this Model.Suffix is already completed, Do you still want to continue?',
                    title: "Confirmation box",
                    buttons: {
                        confirm: {
                            label: "Yes",
                            className: "red",
                            callback: function() {
                                
                                $('#register-inspection-form')[0].submit();
                            }
                        },
                        cancel: {
                            label: "No",
                            className: "blue"
                        }
                    }
                });
                
                return false;
            }
        }
    });
    
    $('#register-inspection-submit').click(function() {
        $result_type = $('#checkpoint-result-type').val();
        var elem = $('#register-inspection-submit');
        
        if($result_type == 'value') {
            var lsl = $('#register-inspection-checkpoint-lsl').val();
            var usl = $('#register-inspection-checkpoint-usl').val();
        
            if($('.audit_values').length > 1) {
                var error = false;
                var same = true;
                var empty = false;
                var first = '';

                $('.audit_values').each(function(i, obj) {
                    var val = $(obj).val();
                    if(val == '') {
                        empty = true;
                    }
                    if(first == '') {
                        first = val;
                    }
                    
                    if(val != first && same) {
                        same = false;
                    }
                    
                    if(lsl != '' && parseFloat(val) < parseFloat(lsl)) {
                        error = true;
                    }
                    
                    if(usl != '' && parseFloat(val) > parseFloat(usl)) {
                        error = true;
                    }
                });
                
                if(same && !empty) {
                    bootbox.dialog({
                        message: "All samples readings are same. Press 'Continue' if it's ok else press 'Cancel'.",
                        title: "Confirmation box",
                        buttons: {
                            confirm: {
                                label: "Continue",
                                className: "red",
                                callback: function() {
                                
                                    elem.closest('form').submit();
                                }
                            },
                            cancel: {
                                label: "Cancel",
                                className: "blue"
                            }
                        }
                    });
                    
                    return false;
                }
                
            } else {
                var val = $('.audit_values').val();
                if(val == '') {
                    elem.closest('form').submit();
                }
                
                var error = false;
                if(lsl != '' && parseFloat(val) < parseFloat(lsl)) {
                    error = true;
                }
                
                if(usl != '' && parseFloat(val) > parseFloat(usl)) {
                    error = true;
                }
            }
            
            if(error) {
                $('#ng-confirm').trigger('click');
            } else {
                return true;
            }
            
        } else {
            $ngflag = false;
            $('.radio-list').each(function(i, obj) {
                $checked = $(obj).find('.audit_result_'+(i+1)+':checked').val();
                if($checked == undefined) {
                    bootbox.dialog({
                        message: 'Please fill result for all the samples before submit.',
                        title: 'Alert',
                        buttons: {
                            confirm: {
                                label: "OK",
                                className: "button"
                            }
                        }
                    });
                    
                    return false;
                } else {
                    if($checked == 'NG') {
                        $ngflag = true;
                    }
                }
            });
            
            if($ngflag) {
                $('#ng-confirm').trigger('click');
            } else {
                return true;
            }
        }
        
        return false;
    });
    
    $('.fetch-sample-qty-button').click(function() {
        var target = $(this).attr('href');
        var cid = $(this).attr('data-cid');
        var pid = $(this).attr('data-pid');
        var plq = $(this).attr('data-plq');
        
        var current_row = $(this).closest('tr');
        
        current_row.find('.sample-qty .loading').show();
        
        $.ajax({
            type: 'POST',
            url: target,
            data: { checkpoint_id: cid, part_id: pid, prod_lot_qty: plq},
            dataType: 'json',
            success: function(resp) {
                if(resp.status === 'success') {
                    current_row.find('.sample-qty').html(resp.judgement);
                }
                
                var tr = current_row.next('tr');
                if(current_row.next('tr').hasClass('warning')) {
                    tr = current_row.next('tr').next('tr');
                }
                if(tr.find('.fetch-sample-qty-button').length > 0) {
                    tr.find('.fetch-sample-qty-button').trigger('click');
                } else {
                    $('.start-inspection-button').show();
                }
            }
        });
        
        return false;
    });
    
    $('#tool-wise-model-sel').change(function() {
        
        App.blockUI({
            target: '.portlet',
            boxed: true
        });
        
        var tool = $('#tool-wise-model-sel :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_models_by_tool',
            data: { tool: tool},
            dataType: 'json',
            success: function(resp) {
                if($('#model-sel-by-tool :selected').val() != '' && $('#model-sel-by-tool :selected').val() != 'All') {
                    $('#model-sel-by-tool').select2('val', null);
                }
                
                $('#model-sel-by-tool').html('');
                
                $('#model-sel-by-tool').append('<option value="All">All</option>');
                $.each(resp.models, function (i, item) {
                    $('#model-sel-by-tool').append($('<option>', { 
                        value: item.model,
                        text : item.model, 
                    }));
                });
                App.unblockUI('.portlet');
            }
        });
    });

    $('#exclude-form-insp-sel').change(function() {
        
        App.blockUI({
            target: '.excluded_checkpoint-add-form-portlet',
            boxed: true
        });
        
        var insp        = $('#exclude-form-insp-sel :selected').val();
        var existing = 0;
        if($('#existing-id').length > 0) {
            var existing    = $('#existing-id').val();
        }
        
        $.ajax({
            type: 'POST',
            url: base_url+'inspections/get_inspection_checkpoints',
            data: { inspection_id: insp, existing: existing},
            success: function(resp) {
                $('#exclude-checkpoints-section').html(resp);
                
                App.unblockUI('.excluded_checkpoint-add-form-portlet');
            }
        });
    });

    $('#ref-link-checkpoint-config-insp-sel').change(function() {
        
        App.blockUI({
            target: '.checkpoint_config-add-form-portlet',
            boxed: true
        });
        
        var insp        = $('#ref-link-checkpoint-config-insp-sel :selected').val();
        var existing = 0;
        if($('#existing-id').length > 0) {
            var existing    = $('#existing-id').val();
        }
        
        $.ajax({
            type: 'POST',
            url: base_url+'references/get_inspection_checkpoints',
            data: { inspection_id: insp, existing: existing},
            success: function(resp) {
                $('#ref-link-checkpoints-section').html(resp);
                
                App.unblockUI('.checkpoint_config-add-form-portlet');
            }
        });
    });
    
    $('.page-content-wrapper').on('submit', '.lot-id-form', function() {
        $modal_content = $(this).closest('.modal-content');
        
        if($modal_content.find('#oqc_lot_id_field').val() == '') {
            $modal_content.find('.alert-danger').removeClass('display-hide');
            
            return false;
        }
    });
    
    $('.page-content-wrapper').on('submit', '.attach-guideline-form', function() {
        $target = $(this).attr('action');
        $parts = $target.split('/');
        $checkpoint_id = $parts[$parts.length-1];
        $checkpoint_row = $('.checkpoint-'+$checkpoint_id);
        $modal_content = $(this).closest('.modal-content');
        
        if($modal_content.find('.guideline-image-field').val() == '') {
            $modal_content.find('.alert-danger').removeClass('display-hide');
        } else {
            $checkpoint_row.find('.guideline-image-loading').show();
            $checkpoint_row.find('.guideline-image-href').hide();
            $(this).ajaxSubmit({
                success:function(data) {
                    data = $.parseJSON(data);
                    if(data.status == 'success') {
                        $checkpoint_row.find('.guideline-image-href').attr('href', base_url+data.file);
                        $checkpoint_row.find('.guideline-image-href').show();
                        
                    } else {
                        alert('Something went wrong, Please try again.');
                    }
                    $checkpoint_row.find('.guideline-image-loading').hide();
                    $modal_content.find('.attach-guideline-modal-close').trigger('click');
                }
            }); 
        }
        
        return false;
    });
    
    $('.page-content-wrapper').on('submit', '.adjust-production-form', function() {
        $target = $(this).attr('action');
        $parts = $target.split('/');
        $row_id = $parts[$parts.length-1];
        $row = $('.producton-plan-'+$row_id);
        $modal_content = $(this).closest('.modal-content');
        
        if($modal_content.find('input').val() == '') {
            $modal_content.find('.alert-danger').removeClass('display-hide');
        } else {
            $row.find('.ajay-image-loading').show();
            $row.find('.return-content-section').hide();
            $(this).ajaxSubmit({
                success:function(data) {
                    data = $.parseJSON(data);

                    if(data.status == 'success') {
                        $row.find('.return-content-section').html(data.html);
                        $row.find('.return-content-section').show();
                        
                    } else {
                        alert('Something went wrong, Please try again.');
                    }
                    
                    $row.find('.ajay-image-loading').hide();
                    $modal_content.find('.adjust-production-modal-close').trigger('click');
                }
            }); 
        }
        
        return false;
    });
    
    $('.page-content-wrapper').on('submit', '.adjust-sampling-form', function() {
        var btn = $(document.activeElement).val();
        if(btn == 'skip') {
            $(this).append('<input type="hidden" name="skip" value="skip" />');
        }
        $target = $(this).attr('action');
        $parts = $target.split('/');
        $row_id = $parts[$parts.length-1];
        $row = $('.sampling-plan-'+$row_id);
        $modal_content = $(this).closest('.modal-content');
        
        if(btn != 'skip' && $modal_content.find('input').val() == '') {
            $modal_content.find('.alert-danger').removeClass('display-hide');
        } else {
            $(this).ajaxSubmit({
                success:function(data) {
                    data = $.parseJSON(data);

                    if(data.status == 'success') {
                        $row.closest('td').html(data.html);
                    } else {
                        alert('Something went wrong, Please try again.');
                    }
                    
                    $modal_content.find('.adjust-sampling-modal-close').trigger('click');
                }
            }); 
        }
        
        return false;
    });
    
    $('.page-content-wrapper').on('submit', '.automate-settings-form', function() {
        $target = $(this).attr('action');
        $parts = $target.split('/');
        $checkpoint_id = $parts[$parts.length-1];
        $checkpoint_row = $('.checkpoint-'+$checkpoint_id);
        $modal_content = $(this).closest('.modal-content');
        
        if($modal_content.find('#automate_result_row').val() == '' || $modal_content.find('#automate_result_col').val() == '') {
            $modal_content.find('.alert-danger').removeClass('display-hide');
        } else {
            $checkpoint_row.find('.automate-setting-loading').show();
            $(this).ajaxSubmit({
                success:function(data) {
                    data = $.parseJSON(data);
                    if(data.status == 'success') {
                        $checkpoint_row.find('.automate-setting-text').html(data.col+data.row);
                    } else {
                        alert('Something went wrong, Please try again.');
                    }
                    $checkpoint_row.find('.automate-setting-loading').hide();
                    $modal_content.find('.automate-setting-modal-close').trigger('click');
                }
            }); 
        }
        
        return false;
    });

    if($('.dashboard-noti').length > 0) {
        $('.dashboard-noti').pulsate({
            color: "#fdbe41",
            reach: 50,
            speed: 1000,
            glow: true
        });
    }
    
    $('.easy-pie-chart .number.transactions').easyPieChart({
        animate: 1000,
        size: 75,
        lineWidth: 3,
        barColor: App.getBrandColor('yellow')
    });
    
    $('#na-confirm').click(function() {
        
        var elem = $(this);
        bootbox.dialog({
            message: 'Are you sure you want to mark this checkpoint as NA?',
            title: "Confirmation box",
            buttons: {
                confirm: {
                    label: "Yes",
                    className: "red",
                    callback: function() {
                        if($('#audit_value').length > 0) {
                            $('#audit_value').removeClass('required');
                        }
                        
                        $('#na-button').trigger('click');
                    }
                },
                cancel: {
                    label: "No",
                    className: "blue"
                }
            }
        });
    });
    
    $('#ng-confirm').click(function() {
        $('#register-inspection-remark').removeClass('required');
        
        var elem = $(this);
        bootbox.dialog({
            message: 'Are you sure you want to mark this checkpoint as NG?',
            title: "Confirmation box",
            buttons: {
                confirm: {
                    label: "Yes",
                    className: "red",
                    callback: function() {
                        $('#register-inspection-remark').addClass('required');
                        $('#ng-button').trigger('click');
                    }
                },
                cancel: {
                    label: "No",
                    className: "blue"
                }
            }
        });
    });
    
    // Example #3
    if($('#tool-master').length > 0) {
        var tools = new Bloodhound({
          datumTokenizer: function(d) { return d.tool; },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          remote: base_url+'products/get_all_tools'
        });
        tools.initialize();
        $('#tool-master').typeahead(null, {
            displayKey: 'tool',
            hint: (App.isRTL() ? false : true),
            source: tools.ttAdapter()
        });
    }
    
    if($('#model-master').length > 0) {
        var models = new Bloodhound({
          datumTokenizer: function(d) { d.model; },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          remote: base_url+'auditer/get_model_suggestions'
        });
        models.initialize();
        $('#model-master').typeahead(null, {
            displayKey: 'model',
            hint: (App.isRTL() ? false : true),
            source: models.ttAdapter()
        });
    }
    
    if($('#inspection-full-auto').length > 0) {
        $('#inspection-full-auto').change(function() {
            $is_checked = $('#inspection-full-auto:checked').val();
            if($is_checked == 1) {
                $('.non-full-auto').hide();
                $('.full-auto-section').show();
                $case = $('#automate-special-case :selected').val();
                if($case === 'With Checkpoints') {
                    $('.automate-settings').show();
                }
            } else {
                $('.non-full-auto').show();
                $('.full-auto-section').hide();
                $('.automate-settings').hide();
            }
        });
    }
    
    if($('#inspection-edit').length > 0) {
        $insp_type = $('#add-inspection-insp-type :selected').val();

        if($insp_type == 'regular') {
            $is_checked = $('#inspection-full-auto:checked').val();
            if($is_checked == 1) {
                $('.non-full-auto').hide();
                $('.full-auto-section').show();
                $case = $('#automate-special-case :selected').val();
                if($case === 'With Checkpoints') {
                    $('.automate-settings').show();
                }
            } else {
                $('.non-full-auto').show();
                $('.full-auto-section').hide();
            }
        } else if($insp_type == 'interval') {
            $is_checked = $('#interval-inspection-attach-report:checked').val();
            if($is_checked == 1) {
                $('.checkpoint-upload-section').hide();
                $('.automate-checkboxes').hide();
                $('.attach-report-div').show();
            } else {
                $('.checkpoint-upload-section').show();
                $('.automate-checkboxes').hide();
                $('.attach-report-div').hide();
            }
        }
    }

    if($('#interval-inspection-attach-report').length > 0) {
        $('#interval-inspection-attach-report').change(function() {
            $is_checked = $('#interval-inspection-attach-report:checked').val();
            if($is_checked == 1) {
                $('.checkpoint-upload-section').hide();
                $('.automate-checkboxes').hide();
                $('.attach-report-div').show();
            } else {
                $('.checkpoint-upload-section').show();
                $('.automate-checkboxes').hide();
                $('.attach-report-div').hide();
            }
        });
    }
    
    if($('#add-inspection-insp-type').length > 0) {
        $('#add-inspection-insp-type').change(function() {
            $insp_type = $('#add-inspection-insp-type :selected').val();
            if($insp_type == 'regular') {
                $('.automate-checkboxes').show();
                if($('#inspection-full-auto:checked').val()) {
                    $('.non-full-auto').hide();
                    $('.full-auto-section').show();
                    $case = $('#automate-special-case :selected').val();
                    if($case === 'With Checkpoints') {
                        $('.automate-settings').show();
                    }
                }
                $('.interval-type').hide();
            } else {
                $('.non-full-auto').show();
                $('.interval-type').show();
                $('.automate-checkboxes').hide();
                
                $('.full-auto-section').hide();
                $('.automate-settings').hide();
            }
        });
    }
    
    if($('.inspection-type').length > 0) {
        $('.inspection-type').change(function() {
            $type = $('.inspection-type:checked').val();
            if($type === 'Model.Suffix') {
                $('.config-model-sel-div').show();
                $('.config-tool-sel-div').hide();
            } else {
                $('.config-model-sel-div').hide();
                $('.config-tool-sel-div').show();
            }
        });
    }
    
    if($('.reference-sel-type').length > 0) {
        $('.reference-sel-type').change(function() {
            $type = $('.reference-sel-type:checked').val();
            if($type === 'File') {
                $('.add-reference-file-sel-div').show();
                $('.add-reference-url-sel-div').hide();
            } else {
                $('.add-reference-file-sel-div').hide();
                $('.add-reference-url-sel-div').show();
            }
        });
    }
    
    if($('#automate-special-case').length > 0) {
        $('#automate-special-case').change(function() {
            $case = $('#automate-special-case :selected').val();
            if($case === 'With Checkpoints') {
                $('.automate-settings').show();
            } else {
                $('.automate-settings').hide();
            }
        });
    }
    
    if($('#delete-multiple').length > 0) {
        $('#delete-multiple').click(function(){
            var form = $('#delete-multiple').closest('form');
            
            if(form.find('.checkboxes:checked').length == 0) {
                
                bootbox.dialog({
                    message: 'Please select the rows you want to deleted.',
                    title: 'Alert',
                    buttons: {
                        confirm: {
                            label: "OK",
                            className: "button"
                        }
                    }
                });
                
                return false;
            }
            
            bootbox.dialog({
                message: 'Are you sure you want to delete all these records?',
                title: "Confirmation box",
                buttons: {
                    confirm: {
                        label: "Yes",
                        className: "button",
                        callback: function() {
                            form.submit();
                        }
                    },
                    cancel: {
                        label: "No",
                        className: "button white"
                    }
                }
            });
        });
    }
    
    $('#update-inspection-config-inspection').change(function() {
        App.blockUI({
            target: '.portlet',
            boxed: true
        });
        
        var insp = $('#update-inspection-config-inspection :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'inspections/get_inspection_ajax',
            data: { inspection_id: insp},
            dataType: 'json',
            success: function(resp) {
                if(resp.insp_type == 'interval') {
                    $('#inspection-config-sampling-type').select2('val', 'Interval');
                    //$('#inspection-config-sampling-type').attr('readonly', 'true');
                } else {
                    if($('#inspection-config-sampling-type :selected').val()) {
                        $('#inspection-config-sampling-type').select2('val', null);
                    }
                    
                    //$('#inspection-config-sampling-type').removeAttr('readonly');
                }
                App.unblockUI('.portlet');
            }
        });
        
    });
    
    $('#dashboard-date').on('changeDate', function() {
        // if($('#first-time').val() == 1) {
            // $('#first-time').val(0);
            // return false;
        // }
        
        window.location.href = base_url+'dashboard/set_dashboard_date/'+$(this).find('input').val();
    });
    
    $('#submit-checklist').click(function(){
        if($('.liChild:checked').length == $('.liChild').length) {
            window.location.href = base_url+'auditer/checklist?status=done';
        } else {
            bootbox.dialog({
                message: 'Please complete all the check items before submit.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });
        }
    });
    
    var index = 1;
    $('#add-more-plan').click(function() {
        $('.to-clone').clone()
        $('.form-body').append($('.to-clone').clone().addClass('row-'+index).addClass('timecheck-row').removeClass('to-clone').show());
        
        $('.row-'+index+' .form-control').each(function() {
            var name = $(this).attr('name');
            
            if(name == 'part_id_idx' || name == 'child_part_no_idx' || name == 'mold_no_idx') {
                var id = $(this).attr('id');
                id = id.replace('idx', index);
                $(this).attr('id', id);
                
                var error_indx = $(this).attr('data-error-container');
                error_indx = error_indx.replace('idx', index);
                $(this).attr('data-error-container', error_indx);
                
                var error_indx = $(this).closest('.form-group').attr('id');
                error_indx = error_indx.replace('idx', index);
                $(this).closest('.form-group').attr('id', error_indx);
            }
            
            name = name.replace('idx', index);
            
            $(this).attr('name', name);
        });
        
        $('#part_id_'+index).select2({
            placeholder: "Select",
            width: 'auto', 
            allowClear: true
        });
        
        $('#child_part_no_'+index).select2({
            placeholder: "Select",
            width: 'auto', 
            allowClear: true
        });
        
        $('#mold_no_'+index).select2({
            placeholder: "Select",
            width: 'auto', 
            allowClear: true
        });
        
        $('.row-'+index+' .timepicker-no-seconds').timepicker({
            autoclose: true,
            minuteStep: 5
        });
        
        index++;
        
    });
    
    $( "#plan-add-form-portlet" ).on( "change", ".timecheck-part-sel", function() {
        var portlet_id = $(this).closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var elem = $(this);
        var row = $(this).closest('.timecheck-row');
        var part_id = $(row).find('.timecheck-part-sel :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'tc_checkpoints/get_child_parts_by_part_id',
            data: { part_id: part_id},
            dataType: 'json',
            success: function(resp) {
                if($(row).find('.timecheck-child-part-sel :selected').val() != '') {
                    $(row).find('.timecheck-child-part-sel').select2('val', null);
                }
                
                $(row).find('.timecheck-child-part-sel').html('');
                
                $(row).find('.timecheck-child-part-sel').append('<option value=""></option>');
                $.each(resp.child_part_nos, function (i, item) {
                    $(row).find('.timecheck-child-part-sel').append($('<option>', { 
                        value: item.child_part_no,
                        text : item.child_part_no, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $( "#plan-add-form-portlet" ).on( "change", ".timecheck-child-part-sel", function() {
        var portlet_id = $(this).closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var elem = $(this);
        var row = $(this).closest('.timecheck-row');
        var part_id = $(row).find('.timecheck-part-sel :selected').val();
        var child_part_no = $(row).find('.timecheck-child-part-sel :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'tc_checkpoints/get_mold_no_by_child_part_no',
            data: { part_id: part_id, child_part_no: child_part_no},
            dataType: 'json',
            success: function(resp) {
                if($(row).find('.timecheck-mold-sel :selected').val() != '') {
                    $(row).find('.timecheck-mold-sel').select2('val', null);
                }
                
                $(row).find('.timecheck-mold-sel').html('');
                
                $(row).find('.timecheck-mold-sel').append('<option value=""></option>');
                $.each(resp.mold_nos, function (i, item) {
                    $(row).find('.timecheck-mold-sel').append($('<option>', { 
                        value: item.mold_no,
                        text : item.mold_no, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
    $('.timecheck-result-sel').change(function() {
        var sel = $(this).find(':checked').val();
        if(sel == 'NG') {
            $(this).closest('td').addClass('danger ng-cell');
        } else {
            $(this).closest('td').removeClass('danger ng-cell');
        }
    });
    
    $('.timecheck-result-input').blur(function() {
        var lsl = $(this).closest('tr').find('.timecheck-lsl').val();
        var usl = $(this).closest('tr').find('.timecheck-usl').val();
        var val = $(this).val();
        
        if(val != '') {
            $(this).closest('td').removeClass('timecheck-required');
        } else {
            $(this).closest('td').addClass('timecheck-required');
        }

        var res = 'OK';
        if(lsl != '' && parseFloat(val) < parseFloat(lsl)) {
            res = 'NG';
        }
        
        if(usl != '' && parseFloat(val) > parseFloat(usl)) {
            res = 'NG';
        }
        
        if(res == 'NG') {
            $(this).closest('td').addClass('danger ng-cell');
        } else {
            $(this).closest('td').removeClass('danger ng-cell');
        }
    });
    
    $('#timecheck-save-button').click(function() {
        var elem = $(this);
        if($('.timecheck-required').length > 0) {
            bootbox.dialog({
                message: 'Please fill result for all the checkpoints before submit.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });
            
            return false;
        }
        
        if($('.ng-cell').length > 0) {
            bootbox.dialog({
                message: 'One or more checkpoints are marked as NG. Are you sure you want to save the results?',
                title: "Confirmation box",
                buttons: {
                    confirm: {
                        label: "Yes",
                        className: "red",
                        callback: function() {
                            $(elem).closest('form').submit();
                        }
                    },
                    cancel: {
                        label: "No",
                        className: "blue"
                    }
                }
            });
            
            return false;
        }
    });

    $("body").on("contextmenu", function(e) {
        e.preventDefault();
    });
    
    if(document.layers){
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = function(){
            return false;
        };
    }else{
        document.onmouseup = function(e){
            if(e != null && e.type == 'mouseup' ){
                if(e.which == 2 || e.which == 3){
                    return false;
                }
            }
        };
    }
     
    checkitem();
});


function view_drawing(part_no){
    
    //var reader = new window.FileReader();
    var base_url = $('#base_url').val();
    var base64data = '';
    
    //$('#modal-agreement').show(); 
    //return 0;
    //alert("here");
    $.ajax({
        type: 'POST',
        url: base_url+'auditer/get_drawing',
        data: { part_no: part_no},
        processData: false,
        contentType: false,
        success: function(blob) {
            
            alert("Success");
            
            // atob() is used to convert base64 encoded PDF to binary-like data.
            // (See also https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/
            // Base64_encoding_and_decoding.)
            'use strict';

            PDFJS.disableWorker = true; /* IMPORTANT TO DISABLE! */
            var pdfData = atob(blob);

            // Disable workers to avoid yet another cross-origin issue (workers need
            // the URL of the script to be loaded, and dynamically loading a cross-origin
            // script does not work).
            // PDFJS.disableWorker = true;

            // The workerSrc property shall be specified.
            PDFJS.workerSrc = base_url+'assets/pdfjs/build/pdf.worker.js';

            // Using DocumentInitParameters object to load binary data.
            var loadingTask = PDFJS.getDocument({data: pdfData});
            loadingTask.promise.then(function(pdf) {
              console.log('PDF loaded');

              // Fetch the first page
              var pageNumber = 1;
              pdf.getPage(pageNumber).then(function(page) {
                console.log('Page loaded');

                var scale = 1.5;
                var viewport = page.getViewport(scale);

                // Prepare canvas using PDF page dimensions
                var canvas = document.getElementById('the-canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                  canvasContext: context,
                  viewport: viewport
                };
                var renderTask = page.render(renderContext);
                renderTask.then(function () {
                  console.log('Page rendered');
                });
              });
            }, function (reason) {
              // PDF loading error
              console.error(reason);
            });
            
            
            //$(this).find('object').attr("data", "data:application/pdf;base64,"+blob);
            
            //$('#modal-agreement').show();
            
            alert("success1");
            
            /*var blob = new Blob([blob], {type : 'application/pdf;base64'});
            var newurl = window.URL.createObjectURL(blob);
            document.getElementById("myFrame").src = newurl;*/
            //var blob = new Blob(blob, {type: "application/pdf"});
            //.window.open("data:application/pdf;base64," + Base64.encode(blob));
        },
        error : function(){
            alert("Error");
        }
    });
}

function realtime_dashboard() {
    var base_url = $('#base_url').val();
    
    App.blockUI({
        target: '.portlet-body',
        boxed: true
    });
    
    $.ajax({
        type: 'POST',
        url: base_url+'dashboard/realtime',
        success: function(resp) {
            $('.realtime-dashboard-portlet').find('.portlet-body').html(resp);
            App.unblockUI('.portlet-body');
        }
    });
}

function mandatory_popup($links) {
    return true;
    bootbox.dialog({
        message: 'For this inspection <span style="color:#c80541;">'+$links+'</span> links are mandatory. You need to open these links else you wont be able to finish the inspection.',
        title: "Mandatory Box",
        buttons: {
            confirm: {
                label: "OK",
                className: "button"
            }
        }
    });
}

function show_page(page_no) {
    $('#page-no').val(page_no);
    
    $('#page-no').closest('form').submit();
}

function get_paired_insp(audit_id) {
    var base_url = $('#base_url').val();
    
    App.blockUI({
        target: '.inspection-detail-sidebar',
        boxed: true
    });
    
    $.ajax({
        type: 'POST',
        url: base_url+'auditer/get_paired_audit_details',
        data: { audit_id: audit_id},
        dataType: 'json',
        success: function(resp) {
            $.each(resp, function(i, item) {
                $('.paired-section-template').find('.paired-model-suffix').html(item.model_suffix);
                $('.paired-section-template').find('.paired-serial-no').html(item.serial_no);
                
                $('.paired-section').append($('.paired-section-template').html());
            });

            App.unblockUI('.inspection-detail-sidebar');
        }
    });
}

function save_foolproof_data(checkpoint_id){
    var base_url = $('#base_url').val();
    var all_results = $('#result_'+checkpoint_id).val();
    var all_values = $('#values_'+checkpoint_id).val();
    
    var lsl = $('#lsl_'+checkpoint_id).val();
    var usl = $('#usl_'+checkpoint_id).val();
    var np = '';
    
    all_results = (all_results) ? all_results : 0;
    all_values = (all_values) ? all_values : 0;
    
    //alert(all_values);
    
    /*if(lsl != '' || usl != ''){
        if(all_values == 0){
            bootbox.dialog({
                message: 'Please fill value before submit.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });
            
            $('#values_'+checkpoint_id).css('border','1px solid #e35b5a');
            
            return false;
        }
    }*/
    
    var formData = new FormData();
    formData.append('checkpoint_id', checkpoint_id);
    
    
    if ($('#np_'+checkpoint_id).is(":checked")){
        //alert("checked");
        np = $('#np_'+checkpoint_id).val();
        if(all_results == 0){
            all_values = np;
        }else if(all_values == 0){
            all_results = np;
        }
        formData.append('image', '');
        
    }else{
        
        if(lsl != '' || usl != ''){
            if(all_values == 0){
                bootbox.dialog({
                    message: 'Please fill value before submit.',
                    title: 'Alert',
                    buttons: {
                        confirm: {
                            label: "OK",
                            className: "button"
                        }
                    }
                });

                $('#values_'+checkpoint_id).css('border','1px solid #e35b5a');

                return false;
            }
        }
        
        if (!$('#capture_'+checkpoint_id).val()) {
            bootbox.dialog({
                message: 'Please Upload Proper Image.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });

            $('#capture_'+checkpoint_id).closest('label').css('border','1px solid #e35b5a');
            $('#capture_'+checkpoint_id).closest('label').css('color','#e35b5a');

            return false;
        }else{
            var image = $('#capture_'+checkpoint_id)[0].files[0];
            var image_name = $('#capture_'+checkpoint_id)[0].files[0].name;
            $('#capture_'+checkpoint_id).closest('label').css('border','none');
            $('#capture_'+checkpoint_id).closest('label').css('border-color','#EEE #CCC #CCC #EEE');
            $('#capture_'+checkpoint_id).closest('label').css('color','#000');
        }
        
        formData.append('image', image, image_name);
        
    }
    
    formData.append('all_results', all_results);
    formData.append('all_values', all_values);
    
    //alert(all_results+' '+all_values);
    $('#button_'+checkpoint_id).css('display','none');
    $.ajax({
        type: 'POST',
        url: base_url+'fool_proof/save_result',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(resp) {
            //alert("Success");
            if(all_results == 0){
                $('#values_'+checkpoint_id).attr('disabled','true');
            }else if(all_values == 0){
                $('#result_'+checkpoint_id).attr('disabled','true');
            }
            
            $('#np_'+checkpoint_id).attr('disabled','true');
            $('#capture_'+checkpoint_id).closest('label').css('display','none');
            if(all_values == 'NP' || all_results == 'NP'){
                $('#capture_'+checkpoint_id).closest('td').html('NP');
            }else{
                $('#capture_'+checkpoint_id).closest('td').html('<img src='+base_url+'assets/foolproof_captured/'+image_name+' alt=image height=70 width=100 />');
            }
            $('#button_'+checkpoint_id).css('display','none');
        },
        error: function(jqXHR, textStatus, errorMessage) {
           alert("something went wrong. Please try again."); // Optional
           $('#button_'+checkpoint_id).css('display','block');
        }
    });
}

function ng_check(checkpoint_id){
    
    var all_results = $('#result_'+checkpoint_id).val();
    var all_values = $('#values_'+checkpoint_id).val();
    
    all_results = (all_results) ? all_results : 0;
    all_values = (all_values) ? parseFloat(all_values) : 0;
    
    var lsl = parseFloat($('#lsl_'+checkpoint_id).val());
    var usl = parseFloat($('#usl_'+checkpoint_id).val());
    //alert(lsl+' '+usl+ ' '+all_values);
    if(lsl != '' || usl != ''){
        if(all_values == 0){
            bootbox.dialog({
                message: 'Please fill value before submit.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });
            
            $('#values_'+checkpoint_id).css('border','1px solid #e35b5a');
            
            return false;
        }
        else if((all_values > usl) || (all_values < lsl)){
            $('#values_'+checkpoint_id).closest('td').addClass('danger');
            $('#values_'+checkpoint_id).closest('td').addClass('ng-cell');
            $('#values_'+checkpoint_id).css('border','1px solid #c2cad8');
        }else{
            $('#values_'+checkpoint_id).closest('td').removeClass('danger');
            $('#values_'+checkpoint_id).closest('td').removeClass('ng-cell');
            $('#values_'+checkpoint_id).css('border','1px solid #c2cad8');
        }
    }else {
        if(all_results == 'NG'){
            $('#result_'+checkpoint_id).closest('td').addClass('danger');
            $('#result_'+checkpoint_id).closest('td').addClass('ng-cell');
            $('#result_'+checkpoint_id).css('border','1px solid #e35b5a');
        }else{
            $('#result_'+checkpoint_id).closest('td').removeClass('danger');
            $('#result_'+checkpoint_id).closest('td').removeClass('ng-cell');
            $('#result_'+checkpoint_id).css('border','1px solid #c2cad8');
        }
        //all_results = np;
    }
}

function printPage(id) {
    var html="<html>";
    html+= document.getElementById(id).innerHTML;
    html+="</html>";
    var printWin = window.open('','','left=0,top=0,width=500,height=500,toolbar=0,scrollbars=0,status =0');
    printWin.document.write(html);
    printWin.document.close();
    printWin.focus();
    printWin.print();
    printWin.close();
}

$('#myCarousel').on('slid.bs.carousel', '', checkitem);

function checkitem()                        // check function
{
  var $this = $('#myCarousel');
  if($('.carousel-inner .item:first').hasClass('active')) {
    $this.children('.left.carousel-control').hide();
    $this.children('.right.carousel-control').show();
  } else if($('.carousel-inner .item:last').hasClass('active')) {
    $this.children('.left.carousel-control').show();
    $this.children('.right.carousel-control').hide();
  } else {
    $this.children('.carousel-control').show();

  } 
  
}

function int_n_float_only(event){
        
        var e = event || window.event;
        /*var src = e.srcElement || e.target;
        var charCode = e.which || e.keyCode || e.charCode;
    //document.getElementById("label").value = src.id; //just for test/debug

        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        else 
        {
            var input = src.value;
            var len = input.length;
            var index = input.indexOf('.');

            if (index > 0 && charCode == 46) return false;

            if (index > 0 || index == 0) {
                var CharAfterdot = (len + 1) - index;
                if (CharAfterdot > 2) return false;
            }

            if (charCode == 46 && input.split('.').length > 1) {
                return false;
            }

        }*/
    
    return e.value.match(/^\d+(\.\d+)?$/);

        return true;
  }

