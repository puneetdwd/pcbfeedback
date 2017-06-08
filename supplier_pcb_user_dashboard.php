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
        <div id="jsGrid"></div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid.min.js"></script>
<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid-fr.js"></script>
<script>

$(document).ready(function(){


});
</script>
<script>
$(function() {

    $("#jsGrid").jsGrid({
        
		height: "auto",
        width: "100%", 

        filtering: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,

        pageSize: 10,
        pageButtonCount: 5,

        deleteConfirm: "Do you really want to delete the client?",

        controller: db,

        fields: [
			{ name: "SN", type: "text", width: 50,editing: false },
			{ name: "Organization Name", type: "text", width: 150,editing: false },
			{ name: "Production Line", type: "text", width: 150,editing: false },
			{ name: "Set S/N", type: "text", width: 150,editing: false },
			{ name: "Defect Date", type: "text", width: 175,editing: false },
			{ name: "Part No", type: "text", width: 170,editing: false },
			{ name: "Defect Quantity", type: "number", width: 100,editing: false },
			{ name: "PCBG Main", type: "text", width: 150,editing: false },
			{ name: "Symptom Level 3", type: "text", width: 200,editing: false },
			{ name: "Cause Level 1", type: "text", width: 150,editing: false },
			{ name: "Cause Level 2", type: "text", width: 150,editing: false },
			{ name: "Cause Level 3", type: "text", width: 150,editing: false },
			{ name: "Repair Contents", type: "text", width: 230,editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "AOI Detection Status", type: "select", width: 150, items: db.aoi_Detection_Status, valueField: "Id", textField: "Name"},
			{ name: "AOI Detection Possibility", type: "select", width: 150, items: db.aoi_Detection_Possibility, valueField: "Id", textField: "Name"},
			{ name: "AOI Revision", type: "text", width: 150},
			{ name: "DFT Detection Status", type: "select", width: 150, items: db.dft_Detection_Status, valueField: "Id", textField: "Name" },
			{ name: "DFT Detection Possibility", type: "select", width: 150, items: db.dft_Detection_Possibility, valueField: "Id", textField: "Name" },
			{ name: "DFT Revision", type: "text", width: 150},
			{ name: "CM Report", type: "text", width: 150},
            /*{ name: "Name", type: "text", width: 150 },
            { name: "Age", type: "number", width: 50 },
            { name: "Address", type: "text", width: 200 },
            { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
            { name: "Married", type: "checkbox", title: "Is Married", sorting: false },*/
            { type: "control", width:100 }
        ]
    });

});
</script>
<script>
var base_url='http://crgroup.co.in/lg/sqim/';
(function() {
	  

    var db = {

        loadData: function(filter) {
			console.log(this.clients);
			var clientDataArray=new Array();
			var clientDataArray2=new Array();
			$.ajax({
						url: "http://crgroup.co.in/lg/sqim/suppliers/get_all_pcb_data", 
						type: "POST",
						dataType:"json",
						cache:false,
						async:false,
						success: function(response){ 
							//console.log(response);
							$.each(response,function(key,data){
								var obj={};
								obj['Organization Name']=data.organization;
								obj['Production Line']=data.production_line;
								obj['Set S/N']=data.set_sn;
								obj['Defect Date']=data.defect_date;
								obj['Part No']=data.part_no;
								obj['Defect Quantity']=data.defect_qty;
								obj['PCBG Main']=data.pcbg_main;
								obj['Symptom Level 3']=data.symptom_level_3;
								obj['Cause Level 1']=data.cause_level_1;
								obj['Cause Level 2']=data.cause_level_2;
								obj['Cause Level 3']=data.cause_level_3;
								obj['Repair Contents']=data.repair_contents;
								obj['Cause']=data.supplier_cause;
								obj['AOI Detection Status']=data.aoi_detection_status;
								obj['AOI Detection Possibility']=data.aoi_detection_possibility;
								obj['AOI Revision']=data.aoi_revision;
								obj['DFT Detection Status']=data.dft_detection_status;
								obj['DFT Detection Possibility']=data.dft_detection_possibility;
								obj['DFT Revision']=data.dft_revision;
								obj['CM Report']=data.cm_report;
																
								clientDataArray.push(obj);
							});
							//console.log(clientDataArray);
						}
				})
				return clientDataArray;
        },

        insertItem: function(insertingClient) {
			//console.log('jjj');
            this.clients.push(insertingClient);
        },

        updateItem: function(updatingClient) {
			//console.log(updatingClient.Cause);
			var updatingClientString=JSON.stringify(updatingClient ); 
			$.ajax({
					   url: base_url+"suppliers/pcb_save_data", 
					   type: "POST",
					   data: {updatingClient:updatingClientString},
					   dataType:"json",
					   cache:false,
					   async:true,
					   success: function(data){ 
						
						}
			})
		 },

        deleteItem: function(deletingClient) {
			//console.log('ttt');
           // var clientIndex = $.inArray(deletingClient, this.clients);
          //  this.clients.splice(clientIndex, 1);
        }

    };

    window.db = db;


    db.aoi_Detection_Status = [
        { Name: "", Id: 0 },
        { Name: "Detect", Id: 1 },
        { Name: "Not Detect", Id: 2 },
        
    ];
	
	db.aoi_Detection_Possibility = [
        { Name: "", Id: 0 },
        { Name: "Yes", Id: 1 },
        { Name: "No", Id: 2 },
        
    ];
	
	db.dft_Detection_Status = [
        { Name: "", Id: 0 },
        { Name: "Detect", Id: 1 },
        { Name: "Not Detect", Id: 2 },
        
    ];
	
	db.dft_Detection_Possibility = [
        { Name: "", Id: 0 },
        { Name: "Yes", Id: 1 },
        { Name: "No", Id: 2 },
        
    ];
	
	db.status = [
        { Name: "", Id: 0 },
        { Name: "OK", Id: 1 },
        { Name: "OS&D", Id: 2 },
        
    ];

}());
</script>