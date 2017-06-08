<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="http://www.webdetails.pt/ctools/charts/lib/tipsy.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.yearText {
	background-color: #ededed;
	border: 1px solid #e0dede;
	font-size: 14px;
	margin-bottom: 10px;
	padding: 1px 0;
}

.tdCustom .table td
{
	padding: 9px 5px !important;
    text-align: center;
    width: 53px !important;
}
</style>
</head>
<body>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            PCB Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">PCB Report</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    	<div class="col-md-12" style="margin-bottom:10px;">
        	<a class="pull-right button normals btn-circle" id="get_pcb_email" style="display:none;">Email This Report</a>
        </div>
    </div>
    <div class="row tdCustom">
        <div class="col-md-12">

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
  			 <div class="col-md-4">
             <form id="yearFrm" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="pull-left" style="width: 20%;"><strong>Year</strong></div>
                    <div class="form-group pull-left" style="width: 80%;">
                     <?php $options = array('2014' => 2014, '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018');?>
                      <select name="yearDropDwn" class="form-control select2me" id="yearDropDwn" placeholder="Select Year">
                        <option>Select Year</option>
                        <?php foreach($options as $key => $option){ ?>
                        <option value="<?php echo $key; ?>" <?php echo($key == $year) ? "selected='selected'" : ''; ?>><?php echo $option; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                </form>
                <div class="row">
                  <div class="col-md-12 text-center" style="width:100%">
                    <div class="yearText"><strong>Year</strong></div>
                  </div>
                </div>
                <!--<div class="row" style="margin-bottom:10px;">
                  <div class="col-md-12"> 
                  	 <?php foreach($totals as $key => $value){?>
                      <span>
                          <?php foreach($value as $val){ ?>
                          	<input class="form-control" type="text" style="width:23.5%;display:inline;" value="<?= $val ?>" />
                          <?php } ?>
                       </span>
                      <?php } ?>
                    </div>
                </div>-->
                 <div id = "yearCanvas">  </div> 
                <div class="row">
                  <div class="col-md-12">
                  
                    <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <?php foreach($production_year as $pkey=>$py){?>
                          	<td class="tableBodyText"><?= $py ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                    <table class="table table-bordered">
                      <tbody><tr>
                       <?php foreach($defectQtyYear as $index => $defQty){?>
                          <td class="tableBodyText"><strong><?= $index ?></strong></td>
                          <?php foreach($defQty as $dqy){ ?>
                          	<td class="tableBodyText"><?= $dqy ?></td>
                          <?php } ?>
                      <?php } ?></tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <tbody>
                       <?php foreach($total_counts_year as $key1=>$values1){?>
                       <tr>
                          <td class="tableBodyText"><strong><?= $key1 ?></strong></td>
                          <?php foreach($values1 as $val){ ?>
                          	<td class="tableBodyText"><?= $val ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals as $key2 => $total){?>
                      <tr>
                          <td class="tableBodyText"><strong><?= $key2 ?></strong></td>
                          <?php foreach($total as $val2){ ?>
                          	<td class="tableBodyText"><?= $val2 ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                   </div>
                </div>
              </div>
             <div class="col-md-4">
             <form id="monthFrm" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="pull-left" style="width: 25%;"><strong>Month</strong></div>
                    <div class="form-group pull-left" style="width: 75%;">
                     <select name="monthDropDwn" class="form-control select2me" id="monthDropDwn" placeholder="Select Month">
                        <option>Select Month</option>
                        <?php $options = array(
								'1' => 'January',
								'2' => 'February',
								'3' => 'March',
								'4' => 'April',
								'5' => 'May',
								'6' => 'June',
								'7' => 'July',
								'8' => 'August',
								'9' => 'September',
								'10' => 'October',
								'11' => 'November',
								'12' => 'December',
								);
						?>
                        <?php foreach($options as $key => $option){ ?>
                        <option value="<?php echo $key; ?>" <?php echo($key == $month) ? "selected='selected'" : ''; ?>><?php echo $option; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
             </form>
                <div class="row">
                  <div class="col-md-12 text-center" style="width:100%">
                    <div class="yearText"><strong>Month</strong></div>
                  </div>
                </div>
                <!--<div class="row" style="margin-bottom:10px;">
                  <div class="col-md-12"><?php foreach($totals_month as $key6 => $value6){?>
                      <span>
                          <?php foreach($value6 as $valu){ ?>
                          	<input class="form-control" type="text" style="width:23.5%;display:inline;" value="<?= $valu ?>" />
                          <?php } ?>
                       </span>
                      <?php } ?></div>
                </div>-->
                
                <div id = "monthCanvas">  </div> 
                <div class="row">
                  <div class="col-md-12" style="padding-left:60px;">
                  
                    <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <?php foreach($production_month as $pkey=>$py){?>
                          	<td class="tableBodyText"><?= $py ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                    <table class="table table-bordered">
                      <tbody>
                      <tr>
                           <?php foreach($defectQtyMonth as $index1 => $defQtyMnt){?>
                          <?php foreach($defQtyMnt as $dqm){ ?>
                          	<td class="tableBodyText"><?= $dqm ?></td>
                          <?php } ?>
                      <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                      <tbody>
                       <?php foreach($total_counts_month as $key4=>$values4){?>
                       <tr>
                          
                          <?php foreach($values4 as $value){ ?>
                          	<td class="tableBodyText"><?= $value ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals_month as $key5 => $total5){?>
                      <tr>
                          <?php foreach($total5 as $val5){ ?>
                          	<td class="tableBodyText"><?= $val5 ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                   </div>
                </div>
              </div>
             <div class="col-md-4">
             
                <div class="row">
                  <div class="col-md-12">
                    <div class="pull-left" style="width: 15%;"><strong>Week</strong></div>
                    <div class="form-group pull-left" style="width: 85%;">
                    <form id="weekFrm" method="POST" >
                      <input name="weekTxt" type="text" class="form-control weekTxt" value="<?php echo $week; ?>" />
                      </form>
                    </div>
                  </div>
                </div>
             
                <div class="row">
                	<div class="col-md-12">
                    	<div class="week-picker"></div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-center" style="width:100%">
                    <div class="yearText"><strong>Week</strong></div>
                  </div>
                </div>
                <!--<div class="row" style="margin-bottom:10px;">
                  <div class="col-md-12"><?php foreach($totals_week as $tws => $tw){?>
                      <span>
                          <?php foreach($tw as $w){ ?>
                          	<input class="form-control" type="text" style="width:23.5%;display:inline;" value="<?= $w ?>" />
                          <?php } ?>
                       </span>
                      <?php } ?></div>
                </div>-->
                
                 <div id = "weekCanvas1">  </div> 
                <div class="row">
                  <div class="col-md-12" style="padding-left:60px;">
                 
                   <table class="table table-bordered">
                  <tbody>
                    <tr>
                       <?php foreach($production_week as $pw){ ?>
                      		<td class="tableBodyText"><?= $pw; ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                 <table class="table table-bordered">
                      <tbody>
                      <tr>
                           <?php foreach($defectQtyWeek as $index=> $defQtyWk){?>
                          <?php foreach($defQtyWk as $dqw){ ?>
                          	<td class="tableBodyText"><?= $dqw ?></td>
                          <?php } ?>
                      <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                   <table class="table table-bordered">
                      <tbody>
                       <?php foreach($total_counts_week as $tcsw=>$val){?>
                       <tr>
                          <?php foreach($val as $tcw){ ?>
                          	<td class="tableBodyText"><?= $tcw ?></td>
                          
                          <?php } ?>
                        </tr>
                       
                       <?php } ?>
                        
					  <?php foreach($totals_week as $tlw => $tw){?>
                      <tr>
                          <?php foreach($tw as $w){ ?>
                          	<td class="tableBodyText"><?= $w ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table> 
                    
                   </div>
                </div>
              </div>
        </div>
    </div>
    <input type="hidden" id="hidden_data_yr" name="hidden_type_yr"/>
    <input type="hidden" id="hidden_data_month" name="hidden_type_month"/>
    <input type="hidden" id="hidden_data_wk" name="hidden_type_wk"/>
    <!-- END PAGE CONTENT-->
</div>
</body>
<script src="http://www.webdetails.pt/ctools/charts/lib/protovis.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/jquery.tipsy.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/protovis-msie.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/tipsy.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/def.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/pvc-r2.0.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/q01-01.js" type="text/javascript"></script>
<script src="http://www.webdetails.pt/ctools/charts/lib/bp.js" type="text/javascript"></script>
<script src="http://www.chartjs.org/assets/Chart.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/feedback/js/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/feedback/js/html2canvas.svg.js"></script>
<script type="text/javascript" src="http://canvg.github.io/canvg/canvg.js"></script> 
<script type="text/javascript">
var initialYearData = <?php echo $json_year;?>;
var initialMonthData = <?php echo $json_month;?>;
var initialWeekData = <?php echo $json_week;?>;

/* Year Canvas */
var budgetAnalisysData = {
    "resultset": initialYearData,
    "metadata": [
        {"colType": "",  "colName": ""},
        {"colType": "",  "colName": ""},
        {"colType": "", "colName": ""}, 
        {"colType": "", "colName": "" },
    ]
};

new pvc.BarChart({
    canvas: "yearCanvas",
    width:  375,
    height: 375,    
    animate:    true,
    selectable: true,
    hoverable:  true,
    legend:     false,
    stacked:    true,
    legendPosition: 'bottom',
    baseAxisComposite: true,
    baseAxisGrid: true,
    barSizeMax: 50,
    
    // Logical row structure always places crosstab columns in "column role" as first columns.
    // Col | Row | Val
    readers: ['account, supplier, category, value'],
    
    visualRoles: {
        series:   'category, account',
        category: 'supplier, account'
        //value: 'value'
    },
    
    // Extreme Makeover of Composite axis - totally unadvisable!
    extensionPoints: {
		plot_add: function() {
            return new pv.Label()
                .data(function() {
                    // A Bar chart's visibleData is grouped by Category > Series.
                    var cccContext = this.getContext();
                    // Return the category Data children.
                    return cccContext.panel.visibleData().childNodes;
                })
                .font('bold 12px sans-serif')
                .top(0)
                .textBaseline('top')
               .textAlign('center')
                .left(function(catData) {
                    // Scales use the keys, not the values.
                    return this.getContext().panel.axes.base.scale(catData.key);
                })
                .text(function(catData) {
                    // Getting the sum of each category is easy.
                    
                    // The name of the dimension to which the "value" visual role is bound.
                    var valueDimName = this.getContext().panel.visualRoles.value.firstDimensionName();
                    
                    // catData's local dimension object
                    var valueDim = catData.dimensions(valueDimName);
                    
                    // Sum the value dimension over all Datums in catData.
                    var catSum = valueDim.sum();
                    
                    // Now format it with the value dimension's formatter.
                    return valueDim.format(catSum);
                });
        },
        // Hide 1st row of labels (leaf nodes)
        baseAxisLabel_visible: function(s) { return s.depth < 1;  },
        
        // Move axis up
        baseAxis_bottom: function() { return this.delegate() + 20; }
		
		
        
       /* // Hide grid lines separating hidden category
        baseAxisGrid_visible: function() { return !(this.index % 2); },
        baseAxisGrid_strokeStyle: 'gray'*/
    },
    
    // TODO: There's no extension point for the "bar" that outlines the cells of the composite axis
    // so we have to hack our way through :-(
    renderCallback: function() {
        var baseAxisPanel = this.chart.axesPanels.base;
        
        // First child is the bar, second is the label.
        baseAxisPanel._pvLayout.children[0].visible(false);
    }

})
.setData(budgetAnalisysData)
.render();


/* Month Canvas */

var budgetAnalisysData = {
    "resultset": initialMonthData,
    "metadata": [
        {"colType": "",  "colName": ""},
        {"colType": "",  "colName": ""},
        {"colType": "", "colName": ""}, 
        {"colType": "", "colName": "" },
    ]
};
            
new pvc.BarChart({
    canvas: "monthCanvas",
    width:  375,
    height: 375,    
    animate:    true,
    selectable: true,
    hoverable:  true,
    legend:     false,
    stacked:    true,
    legendPosition: 'bottom',
    baseAxisComposite: true,
    baseAxisGrid: true,
    barSizeMax: 50,
    
    // Logical row structure always places crosstab columns in "column role" as first columns.
    // Col | Row | Val
    readers: ['account, supplier, category, value'],
    
    visualRoles: {
        series:   'category, account',
        category: 'supplier, account'
        //value: 'value'
    },
    
    // Extreme Makeover of Composite axis - totally unadvisable!
    extensionPoints: {
		plot_add: function() {
            return new pv.Label()
                .data(function() {
                    // A Bar chart's visibleData is grouped by Category > Series.
                    var cccContext = this.getContext();
                    // Return the category Data children.
                    return cccContext.panel.visibleData().childNodes;
                })
                .font('bold 12px sans-serif')
                .top(0)
                .textBaseline('top')
               .textAlign('center')
                .left(function(catData) {
                    // Scales use the keys, not the values.
                    return this.getContext().panel.axes.base.scale(catData.key);
                })
                .text(function(catData) {
                    // Getting the sum of each category is easy.
                    
                    // The name of the dimension to which the "value" visual role is bound.
                    var valueDimName = this.getContext().panel.visualRoles.value.firstDimensionName();
                    
                    // catData's local dimension object
                    var valueDim = catData.dimensions(valueDimName);
                    
                    // Sum the value dimension over all Datums in catData.
                    var catSum = valueDim.sum();
                    
                    // Now format it with the value dimension's formatter.
                    return valueDim.format(catSum);
                });
        },
        // Hide 1st row of labels (leaf nodes)
        baseAxisLabel_visible: function(s) { return s.depth < 1;  },
        
        // Move axis up
        baseAxis_bottom: function() { return this.delegate() + 20; },
        
        // Hide grid lines separating hidden category
       /* baseAxisGrid_visible: function() { return !(this.index % 2); },
        baseAxisGrid_strokeStyle: 'gray'*/
    },
    
    // TODO: There's no extension point for the "bar" that outlines the cells of the composite axis
    // so we have to hack our way through :-(
    renderCallback: function() {
        var baseAxisPanel = this.chart.axesPanels.base;
        
        // First child is the bar, second is the label.
        baseAxisPanel._pvLayout.children[0].visible(false);
    }

})
.setData(budgetAnalisysData)
.render();

/* Weekly Canvas */

var budgetAnalisysData = {
    "resultset": initialWeekData,
    "metadata": [
        {"colType": "",  "colName": ""},
        {"colType": "",  "colName": ""},
        {"colType": "", "colName": ""}, 
        {"colType": "", "colName": "" }
    ]
};
            
new pvc.BarChart({
    canvas: "weekCanvas1",
    width:  375,
    height: 375,    
    animate:    true,
    selectable: true,
    hoverable:  true,
    legend:     false,
    stacked:    true,
    legendPosition: 'bottom',
    baseAxisComposite: true,
    baseAxisGrid: true,
    barSizeMax: 50,
    
    // Logical row structure always places crosstab columns in "column role" as first columns.
    // Col | Row | Val
    readers: ['account, supplier, category, value'],
    
    visualRoles: {
        series:   'category, account',
        category: 'supplier, account'
        //value: 'value'
    },
    
    // Extreme Makeover of Composite axis - totally unadvisable!
    extensionPoints: {
		plot_add: function() {
            return new pv.Label()
                .data(function() {
                    // A Bar chart's visibleData is grouped by Category > Series.
                    var cccContext = this.getContext();
                    // Return the category Data children.
                    return cccContext.panel.visibleData().childNodes;
                })
                .font('bold 12px sans-serif')
                .top(0)
                .textBaseline('top')
               .textAlign('center')
                .left(function(catData) {
                    // Scales use the keys, not the values.
                    return this.getContext().panel.axes.base.scale(catData.key);
                })
                .text(function(catData) {
                    // Getting the sum of each category is easy.
                    
                    // The name of the dimension to which the "value" visual role is bound.
                    var valueDimName = this.getContext().panel.visualRoles.value.firstDimensionName();
                    
                    // catData's local dimension object
                    var valueDim = catData.dimensions(valueDimName);
                    
                    // Sum the value dimension over all Datums in catData.
                    var catSum = valueDim.sum();
                    
                    // Now format it with the value dimension's formatter.
                    return valueDim.format(catSum);
                });
        },
        // Hide 1st row of labels (leaf nodes)
        baseAxisLabel_visible: function(s) { return s.depth < 1;  },
        
        // Move axis up
        baseAxis_bottom: function() { return this.delegate() + 20; },
        
        // Hide grid lines separating hidden category
        /*baseAxisGrid_visible: function() { return !(this.index % 2); },
        baseAxisGrid_strokeStyle: 'gray'*/
    },
    
    // TODO: There's no extension point for the "bar" that outlines the cells of the composite axis
    // so we have to hack our way through :-(
    renderCallback: function() {
        var baseAxisPanel = this.chart.axesPanels.base;
        
        // First child is the bar, second is the label.
        baseAxisPanel._pvLayout.children[0].visible(false);
    }

})
.setData(budgetAnalisysData)
.render();

$("#yearDropDwn").on('change',function(){
	$('#yearFrm').submit();	
});

$("#monthDropDwn").on('change',function(){
	$('#monthFrm').submit();	
});

//Week Picker
var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.weekTxt').datepicker('widget').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('.weekTxt').datepicker( {
        showOtherMonths: false,
        selectOtherMonths: false,
        onSelect: function(dateText, inst) { 
            var date = new Date(dateText);
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = 'dd/mm/yy';
            $('.weekTxt').val($.datepicker.formatDate( dateFormat, startDate, inst.settings )
                 + ' - ' + $.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            $('#weekFrm').submit();
            selectCurrentWeek();
			
        },
        beforeShow: function() {
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    }).datepicker('widget').addClass('ui-weekpicker');
    
    $('.ui-weekpicker .ui-datepicker-calendar tr').on('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.ui-weekpicker .ui-datepicker-calendar tr').on('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
//Convert Report to Image
var base_url = '<?php echo base_url(); ?>';
var pic_year = ""; 
var pic_month = "";  
var pic_week = "";   
setTimeout(function(){  	  
	html2canvas($("#yearCanvas"), {
	onrendered: function(canvas) {
		theCanvas = canvas;
		document.body.appendChild(canvas);
		pic_year = canvas.toDataURL("image/png");
		$('#hidden_data_yr').val(pic_year);
		// Clean up 
		document.body.removeChild(canvas);
	},});
	html2canvas($("#monthCanvas"), {
	onrendered: function(canvas1) {
		theCanvas1 = canvas1;
		document.body.appendChild(canvas1);
		pic_month = canvas1.toDataURL("image/png");
		$('#hidden_data_month').val(pic_month);
		// Clean up 
		document.body.removeChild(canvas1);
	}});
	html2canvas($("#weekCanvas1"), {
	onrendered: function(canvas2) {
		theCanvas2 = canvas2;
		document.body.appendChild(canvas2);
		pic_week = canvas2.toDataURL("image/png");
		$('#hidden_data_wk').val(pic_week);
		// Clean up 
		document.body.removeChild(canvas2);
	}
});
}, 5000);
// Email Report
$('#get_pcb_email').on('click',function(){
    var yearImg = $('#hidden_data_yr').val();
    var monthImg = $('#hidden_data_month').val();
    var weekImg = $('#hidden_data_wk').val();
	var yearTxt = $('#yearDropDwn').val();
	var monthTxt = $('#monthDropDwn').val();
	var weekTxt = $('.weekTxt').val();
	
    $.ajax({
                    type:'POST',
                    url: base_url+'cronp/sendMail',
                    data: {
						yearImg : yearImg,
						monthImg : monthImg,
						weekImg : weekImg,
						yearTxt:yearTxt,
						monthTxt:monthTxt,
						weekTxt:weekTxt
                    },
                    success: function(data) {
                        alert('Report Emailed Successfully..!! ');
                    },
                });
});
setTimeout(function(){ 
$('#get_pcb_email').trigger('click');
}, 10000);
</script>