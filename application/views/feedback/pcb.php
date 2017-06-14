<style>
.mImgBox {
    cursor: pointer;
    float: left;
    margin: 1% 0 0 1%;
    width: 15%;
}
.mRepBox {
    cursor: pointer;
    float: left;
    margin: 1% 0 0 1%;
    width: 100%;
}
.modWidth {
	width: 100%;
	margin: 30px auto 0px auto;
	border: 1px solid #CCC;
	padding:5px;
}
.supReportDelete{
	 cursor: pointer;
    float: right;
    width: 5%;	
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid-theme.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/demos.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/prettyPhoto/css/magnific-popup.css" />
<?php //print_r($sessiondata);die(); ?>
<div><input type='checkbox' id='showAll' id='showAll' value='1' />SHOW ALL <br/> </div>
<div id="jsGrid"></div>
<div id="jsGrid1"></div>
<div class="modal fade" id="myModalPhoto" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
  <form id="form" enctype="multipart/form-data" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Modal Header</h4>
    </div>
    <div class="modal-body">
    <div class="container1">
  <div class="modWidth">
    	<div class="row">
			<div class="col-md-12" id='imgLayerDiv'>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
      
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </form>
  </div>
  
</div>


</div>
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
  <form id="form" enctype="multipart/form-data" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Modal Header</h4>
    </div>
    <div class="modal-body">
      <div>
      <input type='hidden' id='partNo' value=''>
      <input type="file" name="file" id="imgFile">
      <button type="submit" class="btn btn-primary" id='imgSave'>Save</button>
      <div id='uploadResponse'></div>
      </div>
      <div class="container1">
  <div class="modWidth">
    	<div class="row">
			<div class="col-md-12" id='imgLayerDivSupplier'>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
      
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </form>
  </div>
  
</div>
</div>

<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid.min.js"></script>
<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid-fr.js"></script>
<script src="<?php echo base_url(); ?>assets/prettyPhoto/js/jquery.magnific-popup.js"></script>

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
			{ name: "DefectDate", type: "date", width: 175,editing: false },
			{ name: "Part No", type: "text", width: 170,editing: false },
			{ name: "Defect Quantity", type: "number", width: 100,editing: false },
			{ name: "PCBG Main", type: "text", width: 150,editing: false },
			{ name: "Symptom Level 3", type: "text", width: 200,editing: false },
			{ name: "Cause Level 1", type: "text", width: 150,editing: false },
			{ name: "Cause Level 2", type: "text", width: 150,editing: false },
			{ name: "Cause Level 3", type: "text", width: 150,editing: false },
			{ name: "Repair Contents", type: "text", width: 230,editing: false },
			{ name: "Vendor", type: "text", width: 150,editing: false },
			{ name: "Part", type: "text", width: 150,editing: false },
			{ name: "Defect", type: "text", width: 150,editing: false},
			{ name: "Category", type: "text", width: 150,editing: false },
			{ name: "Cause Dept", type: "text", width: 150,editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150,editing: false },
			{ name: "Cause", type: "text", width: 150},
			{ name: "AOI Detection Status", type: "text"},
			{ name: "AOI Detection Possibility", type: "text", width: 150},
			{ name: "AOI Revision", type: "text", width: 150},
			{ name: "DFT Detection Status", type: "text", width: 150 },
			{ name: "DFT Detection Possibility", type: "text"},
			{ name: "DFT Revision", type: "text", width: 150},
			{ name: "CM Report", type: "text", width: 150,editing: false},
            { type: "control", deleteButton: false,width:100 },
        ]
    });

});
</script>
<script>
var base_url='<?php echo base_url(); ?>';
(function() {
	function getSelectData(type){
	var res=Array();
	$.ajax({
			url: base_url+"masters/get_all_data/"+type, 
			type: "POST",
			//data: {updatingClient:updatingClientString},
			dataType:"json",
			cache:false,
			async:false,
			success: function(data){ 
				res.push(data);
				if(res[0].length==0){
					//alert('0');
					var obj = {};
					obj[type+'_id']='0';
					obj[type+'_name']='';
					res[0].push(obj);	
				}
			}
				
	});
	
	
	return res;}
	getStatus=getSelectData('status');
	getCauseDept=getSelectData('cause_dept');
	getCategory=getSelectData('category');
	getDefect=getSelectData('defect');
	getAOIDetectStatus=getSelectData('aoi_detection_status');
	getAOIDetectPossibility=getSelectData('aoi_detection_possibility');
	getDFTDetectStatus=getSelectData('dft_detection_status');
	getDFTDetectPossibility=getSelectData('dft_detection_possibility');

    var db = {

        loadData: function(filter) {
			console.log(this.clients);
			var clientDataArray=new Array();
			var clientDataArray2=new Array();
			$.ajax({
						url: base_url+"suppliers/get_all_supplier_data",  
						type: "POST",
						dataType:"json",
						cache:false,
						async:false,
						success: function(response){ 
							console.log(response);
							$.each(response,function(key,data){
								if(data.photo !='')
								{
								var photo="<a href='' class='viewImg' data-toggle='modal' data-target='#myModalPhoto' data-id='"+data.set_sn+"'>View</a>";
								
								}/*if(data.photo=='' || data.photo==undefined ){
									var photo="";
								}
								else{
									var photo="<img width='64' height='64' src='"+base_url+"upload/images/LGREPAIR/"+data.set_sn+"/photo/"+data.photo+"'>"
								}*/
								//if(data.cm_report=='' || data.cm_report==undefined ){
									var cm_report="<a href='' class='uploadImg' data-toggle='modal' data-target='#myModal' data-id='"+data.set_sn+"'>Upload</a>";
								//}
								//else{
								//	var cm_report="<img width='64' height='64' src='"+base_url+"upload/images/LG/<?php echo $sessiondata['user_type']; ?>/<?php echo $sessiondata['id']; ?>/"+data.set_sn+"/report/"+data.cm_report+"'>"
								//}
								var obj={};
								obj['ID']=data.id;
								obj['Organization Name']=data.organization;
								obj['Production Line']=data.production_line;
								obj['Set S/N']=data.set_sn;
								obj['DefectDate']=data.defect_date;
								obj['Part No']=data.part_no;
								obj['Defect Quantity']=data.defect_qty;
								obj['PCBG Main']=data.pcbg_main;
								obj['Symptom Level 3']=data.symptom_level_3;
								obj['Cause Level 1']=data.cause_level_1;
								obj['Cause Level 2']=data.cause_level_2;
								obj['Cause Level 3']=data.cause_level_3;
								obj['Repair Contents']=data.repair_contents;
								obj['Vendor']=data.vendor;
								obj['Part']=data.part;
								obj['Defect']=data.defect;
								obj['Category']=data.category;
								obj['Cause Dept']=data.repair_user_cause_dept;
								obj['Photo']=photo;
								obj['Status']=data.status;
								obj['Cause']=data.supplier_cause;
								obj['AOI Detection Status']=data.aoi_detection_status;
								obj['AOI Detection Possibility']=data.aoi_detection_possibility;
								obj['AOI Revision']=data.aoi_revision;
								obj['DFT Detection Status']=data.dft_detection_status;
								obj['DFT Detection Possibility']=data.dft_detection_possibility;
								obj['DFT Revision']=data.dft_revision;
								obj['CM Report']=cm_report;
																
								clientDataArray.push(obj);
							});
							//console.log(clientDataArray);
						}
				})
				//return clientDataArray;
				
				return $.grep(clientDataArray, function(client) {
                return (!filter.Status || client.Status.indexOf(filter.Status) > -1)
				&& (!filter.Part || client.Part === filter.Part)
				&& (!filter.DefectDate.from || new Date(client.DefectDate) >= filter.DefectDate.from) 
                && (!filter.DefectDate.to || new Date(client.DefectDate) <= filter.DefectDate.to);
				
				//&& (!filter.DefectDate || client.DefectDate === filter.DefectDate);
                    
            });
			
        },

        insertItem: function(insertingClient) {
			//console.log('jjj');
            this.clients.push(insertingClient);
        },

        updateItem: function(updatingClient) {
			console.log(updatingClient.Cause);
			var updatingClientString=JSON.stringify(updatingClient ); 
			$.ajax({
					   url: base_url+"suppliers/supplier_save_data", 
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
	
	var DateField = function(config) {
    jsGrid.Field.call(this, config);
};

DateField.prototype = new jsGrid.Field({
    sorter: function(date1, date2) {
        return new Date(date1) - new Date(date2);
    },    

    itemTemplate: function(value) {
        return new Date(value).toDateString();
    },

    filterTemplate: function() {
        var now = new Date();
        this._fromPicker = $("<input>").datepicker({ defaultDate: now.setFullYear(now.getFullYear() - 1) });
        this._toPicker = $("<input>").datepicker({ defaultDate: now.setFullYear(now.getFullYear() + 1) });
        return $("<div>").append(this._fromPicker).append(this._toPicker);
    },

    insertTemplate: function(value) {
        return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
    },

    editTemplate: function(value) {
        return this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
    },

    insertValue: function() {
        return this._insertPicker.datepicker("getDate").toISOString();
    },

    editValue: function() {
        return this._editPicker.datepicker("getDate").toISOString();
    },

    filterValue: function() {
        return {
            from: this._fromPicker.datepicker("getDate"),
            to: this._toPicker.datepicker("getDate")
        };
    }
});

jsGrid.fields.date = DateField;
	
	 var db1 = {

        loadData: function(filter) {
			console.log(this.clients);
			var clientDataArray=new Array();
			var clientDataArray2=new Array();
			$.ajax({
						url: base_url+"suppliers/get_selected_all_supplier_data",  
						type: "POST",
						dataType:"json",
						cache:false,
						async:false,
						success: function(response){ 
							//console.log(response);
							$.each(response,function(key,data){
								if(data.photo !='')
								{
								var photo="<a href='' class='viewImg' data-toggle='modal' data-target='#myModalPhoto' data-id='"+data.set_sn+"'>View</a>";
								}
								/*if(data.photo=='' || data.photo==undefined ){
									var photo="";
								}
								else{
									var photo="<img width='64' height='64' src='"+base_url+"upload/images/LGREPAIR/"+data.set_sn+"/photo/"+data.photo+"'>"
								}*/
								//if(data.cm_report=='' || data.cm_report==undefined ){
									var cm_report="<a href='' class='uploadImg' data-toggle='modal' data-target='#myModal' data-id='"+data.set_sn+"'>Upload</a>";
								//}
								//else{
								//	var cm_report="<img width='64' height='64' src='"+base_url+"upload/images/LG/<?php echo $sessiondata['user_type']; ?>/<?php echo $sessiondata['id']; ?>/"+data.set_sn+"/report/"+data.cm_report+"'>"
								//}
								var obj={};
								obj['Organization Name']=data.organization;
								obj['Production Line']=data.production_line;
								obj['Set S/N']=data.set_sn;
								obj['DefectDate']=data.defect_date;
								obj['Part No']=data.part_no;
								obj['Defect Quantity']=data.defect_qty;
								obj['PCBG Main']=data.pcbg_main;
								obj['Symptom Level 3']=data.symptom_level_3;
								obj['Cause Level 1']=data.cause_level_1;
								obj['Cause Level 2']=data.cause_level_2;
								obj['Cause Level 3']=data.cause_level_3;
								obj['Repair Contents']=data.repair_contents;
								obj['Vendor']=data.vendor;
								obj['Part']=data.part;
								obj['Defect']=data.defect;
								obj['Category']=data.category;
								obj['Cause Dept']=data.repair_user_cause_dept;
								obj['Photo']=photo;
								obj['Status']=data.status;
								obj['Cause']=data.supplier_cause;
								obj['AOI Detection Status']=data.aoi_detection_status;
								obj['AOI Detection Possibility']=data.aoi_detection_possibility;
								obj['AOI Revision']=data.aoi_revision;
								obj['DFT Detection Status']=data.dft_detection_status;
								obj['DFT Detection Possibility']=data.dft_detection_possibility;
								obj['DFT Revision']=data.dft_revision;
								obj['CM Report']=cm_report;
																
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
					   url: base_url+"suppliers/supplier_save_data", 
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

    window.db1 = db1;
	
	
	

	 db.countries = [
        { Name: "", Id: 0 },
        { Name: "United States", Id: 1 },
        { Name: "Canada", Id: 2 },
        { Name: "United Kingdom", Id: 3 },
        { Name: "France", Id: 4 },
        { Name: "Brazil", Id: 5 },
        { Name: "China", Id: 6 },
        { Name: "Russia", Id: 7 }
    ];
	db.defect = [
        { Name: "", Id: 0 },
        { Name: "Short", Id: 1 },
        { Name: "Damage", Id: 2 },
        
    ];
	
	db.category = [
        { Name: "", Id: 0 },
        { Name: "SMT Defect", Id: 1 },
        { Name: "Part Damage", Id: 2 },
        
    ];
	
	db.cause_dept = [
        { Name: "", Id: 0 },
        { Name: "Vendor", Id: 1 },
        { Name: "WMS", Id: 2 },
        
    ];
	
	
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
<script>

$(document).ready(function(){
	var base_url='http://crgroup.co.in/lg/sqim/';
	$(document).on("click", ".uploadImg", function () {
		 var Id = $(this).data('id');
		 $(".modal-body #partNo").val( Id );
		 $.ajax({
						url: base_url+"suppliers/get_supplier_uploaded_photo/"+Id, 
						//data:new FormData(this),
						type: "POST",
						dataType:"json",
						//contentType: false,
						cache: false,   
						//processData:false, 
						async:false,
						success: function(response){
							
							$('#imgLayerDivSupplier').html('');
							//console.log(response[0].photo); 
							var photoname=response[0].cm_report;
							var sno=response[0].lg_serial_no;
							if(photoname!=''){
								var photoArr=photoname.split(",");
								$.each(photoArr,function(key,val){
									$('#imgLayerDivSupplier').append("<div class='mRepBox'><div class='reportName' style='float:left;'><a href='"+base_url+"upload/images/LG/<?php echo $sessiondata['user_type']; ?>/<?php echo $sessiondata['id']; ?>/"+sno+"/report/"+val+"' >"+val+"</a></div><div class='supReportDelete' >X</div></div");
								});
							}
							else{
								$('#imgLayerDivSupplier').html('No Reports uploaded yet.');
							}
							$('.image-link').magnificPopup({type:'image'});
							
						}
					})
	});
	$(document).on("click", ".viewImg", function () {
		 var Id = $(this).data('id');
		 $(".modal-body #partNo").val( Id );
		 $.ajax({
			url: base_url+"suppliers/get_uploaded_photo/"+Id, 
			//data:new FormData(this),
			type: "POST",
			dataType:"json",
			//contentType: false,
			cache: false,   
			//processData:false, 
			async:false,
			success: function(response){
				
				$('#imgLayerDiv').html('');
				//console.log(response[0].photo); 
				var photoname=response[0].photo;
				var sno=response[0].set_sn;
				if(photoname!=''){
					var photoArr=photoname.split(",");
					$.each(photoArr,function(key,val){
						$('#imgLayerDiv').append("<div class='mImgBox'><a href='"+base_url+"upload/images/LGREPAIR/"+sno+"/photo/"+val+"' class='image-link' rel='prettyPhoto'><img src='"+base_url+"upload/images/LGREPAIR/"+sno+"/photo/"+val+"' class='img-thumbnail'></a></div>");
					});
				}
				else{
					$('#imgLayerDiv').html('No Images uploaded yet.');
				}
				$('.image-link').magnificPopup({type:'image'});
    			
			}
		})
	});
	$(document).on('submit','#form',function(e){
		e.preventDefault();
		imgName=$('#imgFile').val();
		sno=$('#partNo').val();
		$.ajax({
			url: base_url+"suppliers/upload_supplier_image/"+sno, 
			data:new FormData(this),
			type: "POST",
			dataType:"json",
			contentType: false,
			cache: false,   
			processData:false, 
			async:false,
			success: function(response){
				console.log(); 
				if(response==1){
					$('#uploadResponse').html('<br/>Report Successfully Uploaded.');
					$.ajax({
						url: base_url+"suppliers/get_supplier_uploaded_photo/"+sno, 
						//data:new FormData(this),
						type: "POST",
						dataType:"json",
						//contentType: false,
						cache: false,   
						//processData:false, 
						async:false,
						success: function(response){
							
							$('#imgLayerDivSupplier').html('');
							//console.log(response[0].photo); 
							var photoname=response[0].cm_report;
							//var sno=response[0].set_sn;
							if(photoname!=''){
								var photoArr=photoname.split(",");
								$.each(photoArr,function(key,val){
									$('#imgLayerDivSupplier').append("<div class='mRepBox'><div class='reportName' style='float:left;'><a href='"+base_url+"upload/images/LG/<?php echo $sessiondata['user_type']; ?>/<?php echo $sessiondata['id']; ?>/"+sno+"/report/"+val+"' >"+val+"</a></div><div class='supReportDelete' >X</div></div");
								});
							}
							else{
								$('#imgLayerDivSupplier').html('No Reports uploaded yet.');
							}
							$('.image-link').magnificPopup({type:'image'});
							
						}
					})
				}else{
					$('#uploadResponse').html('<br/>Report Upload Unsuccessful.');
				}
			}
		})
	});
	
	$(document).on('click','.supReportDelete',function(e){
		//alert($(this).html());
		var reportName=$(this).parent().find('.reportName').text();
  		var sno=$(this).parent().parent().parent().parent().parent().parent().find('#partNo').val();	
		$.ajax({
			url: base_url+"suppliers/delete_supplier_report/"+sno+"/"+reportName, 
			//data:new FormData(this),
			type: "POST",
			dataType:"json",
			//contentType: false,
			cache: false,   
			//processData:false, 
			async:false,
			success: function(response){
				if(response==1){
					$("#uploadResponse").html('').html('File Deleted Successfully');	
					$.ajax({
						url: base_url+"suppliers/get_supplier_uploaded_photo/"+sno, 
						//data:new FormData(this),
						type: "POST",
						dataType:"json",
						//contentType: false,
						cache: false,   
						//processData:false, 
						async:false,
						success: function(response){
							
							$('#imgLayerDivSupplier').html('');
							//console.log(response[0].photo); 
							var photoname=response[0].cm_report;
							//var sno=response[0].set_sn;
							if(photoname!=''){
								var photoArr=photoname.split(",");
								$.each(photoArr,function(key,val){
									$('#imgLayerDivSupplier').append("<div class='mRepBox'><div class='reportName' style='float:left;'><a href='"+base_url+"upload/images/LG/<?php echo $sessiondata['user_type']; ?>/<?php echo $sessiondata['id']; ?>/"+sno+"/report/"+val+"'>"+val+"</a></div><div class='supReportDelete' >X</div></div");
								});
							}
							else{
								$('#imgLayerDivSupplier').html('No Reports uploaded yet.');
							}
							$('.image-link').magnificPopup({type:'image'});
							
						}
					})
				}	
				else{
					$("#uploadResponse").html('').html('Problem while deleting file. Please try again.');
				}
			}
		})
	})
	
	$(document).on("click", "#showAll", function () {
			
			if($(this).prop("checked") == true){
            	alert("Checkbox is checked.");
				$("#jsGrid1").css('display','none');
				$("#jsGrid").css('display','block');
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

        controller: db1,

        fields: [
			{ name: "SN", type: "text", width: 50,editing: false },
            { name: "Organization Name", type: "text", width: 150,editing: false },
			{ name: "Production Line", type: "text", width: 150,editing: false },
			{ name: "Set S/N", type: "text", width: 150,editing: false },
			{ name: "DefectDate", type: "date", width: 175,editing: false },
			{ name: "Part No", type: "text", width: 170,editing: false },
			{ name: "Defect Quantity", type: "number", width: 100,editing: false },
			{ name: "PCBG Main", type: "text", width: 150,editing: false },
			{ name: "Symptom Level 3", type: "text", width: 200,editing: false },
			{ name: "Cause Level 1", type: "text", width: 150,editing: false },
			{ name: "Cause Level 2", type: "text", width: 150,editing: false },
			{ name: "Cause Level 3", type: "text", width: 150,editing: false },
			{ name: "Repair Contents", type: "text", width: 230,editing: false },
			{ name: "Vendor", type: "text", width: 150,editing: false },
			{ name: "Part", type: "text", width: 150,editing: false },
			{ name: "Defect", type: "text", width: 150, items: getDefect[0], valueField: "defect_id", textField: "defect_name",editing: false},
			{ name: "Category", type: "text", width: 150, items: getCategory[0], valueField: "category_id", textField: "category_name",editing: false },
			{ name: "Cause Dept", type: "text", width: 150, items: getCauseDept[0], valueField: "cause_dept_id", textField: "cause_dept_name" ,editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150,  items: getStatus[0], valueField: "status_id", textField: "status_name" ,editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "AOI Detection Status", type: "select", width: 150, items: getAOIDetectStatus[0], valueField: "aoi_detection_status_id", textField: "aoi_detection_status_name"},
			{ name: "AOI Detection Possibility", type: "select", width: 150, items: getAOIDetectPossibility[0], valueField: "aoi_detection_possibility_id", textField: "aoi_detection_possibility_name"},
			{ name: "AOI Revision", type: "text", width: 150},
			{ name: "DFT Detection Status", type: "select", width: 150, items: getDFTDetectStatus[0], valueField: "dft_detection_status_id", textField: "dft_detection_status_name" },
			{ name: "DFT Detection Possibility", type: "select", width: 150, items: getDFTDetectPossibility[0], valueField: "dft_detection_possibility_id", textField: "dft_detection_possibility_name" },
			{ name: "DFT Revision", type: "text", width: 150},
			{ name: "CM Report", type: "text", width: 150,editing: false},
			
			
			
			/*
            { name: "Age", type: "number", width: 50 },
            { name: "Address", type: "text", width: 200 },
            { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
            { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
			*/
            { type: "control", deleteButton: false,width:100 }
			
        ]
    });
				
            }
            else if($(this).prop("checked") == false){
                alert("Checkbox is unchecked.");
				$("#jsGrid").css('display','none');
				$("#jsGrid1").css('display','block');
				$("#jsGrid1").jsGrid({
        
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
			{ name: "DefectDate", type: "date", width: 175,editing: false },
			{ name: "Part No", type: "text", width: 170,editing: false },
			{ name: "Defect Quantity", type: "number", width: 100,editing: false },
			{ name: "PCBG Main", type: "text", width: 150,editing: false },
			{ name: "Symptom Level 3", type: "text", width: 200,editing: false },
			{ name: "Cause Level 1", type: "text", width: 150,editing: false },
			{ name: "Cause Level 2", type: "text", width: 150,editing: false },
			{ name: "Cause Level 3", type: "text", width: 150,editing: false },
			{ name: "Repair Contents", type: "text", width: 230,editing: false },
			{ name: "Vendor", type: "text", width: 150,editing: false },
			{ name: "Part", type: "text", width: 150,editing: false },
			{ name: "Defect", type: "text", width: 150, items: getDefect[0], valueField: "defect_id", textField: "defect_name",editing: false},
			{ name: "Category", type: "text", width: 150, items: getCategory[0], valueField: "category_id", textField: "category_name",editing: false },
			{ name: "Cause Dept", type: "text", width: 150, items: getCauseDept[0], valueField: "cause_dept_id", textField: "cause_dept_name" ,editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150,  items: getStatus[0], valueField: "status_id", textField: "status_name" ,editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "AOI Detection Status", type: "select", width: 150, items: getAOIDetectStatus[0], valueField: "aoi_detection_status_id", textField: "aoi_detection_status_name"},
			{ name: "AOI Detection Possibility", type: "select", width: 150, items: getAOIDetectPossibility[0], valueField: "aoi_detection_possibility_id", textField: "aoi_detection_possibility_name"},
			{ name: "AOI Revision", type: "text", width: 150},
			{ name: "DFT Detection Status", type: "select", width: 150, items: getDFTDetectStatus[0], valueField: "dft_detection_status_id", textField: "dft_detection_status_name" },
			{ name: "DFT Detection Possibility", type: "select", width: 150, items: getDFTDetectPossibility[0], valueField: "dft_detection_possibility_id", textField: "dft_detection_possibility_name" },
			{ name: "DFT Revision", type: "text", width: 150},
			{ name: "CM Report", type: "text", width: 150,editing: false},
			
			/*
            { name: "Age", type: "number", width: 50 },
            { name: "Address", type: "text", width: 200 },
            { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
            { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
			*/
            { type: "control", deleteButton: false,width:100 }
			
        ]
    });
            }
		});
		
});
</script>