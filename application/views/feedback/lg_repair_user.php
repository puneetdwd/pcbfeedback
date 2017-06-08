<style>
.mImgBox {
    cursor: pointer;
    float: left;
    margin: 1% 0 0 1%;
    width: 15%;
}
.modWidth {
	width: 100%;
	margin: 30px auto 0px auto;
	border: 1px solid #CCC;
	padding:5px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/jsgrid-theme.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/feedback/css/demos.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/prettyPhoto/css/magnific-popup.css" />

<?php //print_r($sessiondata);die(); ?>
<div id="jsGrid"></div>
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
<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid.min.js"></script>
<script src="<?php echo base_url(); ?>assets/feedback/js/jsgrid-fr.js"></script>
<script src="<?php echo base_url(); ?>assets/prettyPhoto/js/jquery.magnific-popup.js"></script>
<script>
$(document).ready(function(){
	//$("a[rel^='prettyPhoto']").prettyPhoto();	
	$('.image-link').magnificPopup({type:'image'});
})
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
			{ name: "Vendor", type: "text", width: 150 },
			{ name: "Part", type: "text", width: 150 },
			{ name: "Defect", type: "select", width: 150, items: getDefect[0], valueField: "defect_id", textField: "defect_name"},
			{ name: "Category", type: "select", width: 150, items: getCategory[0], valueField: "category_id", textField: "category_name" },
			{ name: "Cause Dept", type: "select", width: 150, items: getCauseDept[0], valueField: "cause_dept_id", textField: "cause_dept_name" },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "select", width: 150, items: getStatus[0], valueField: "status_id", textField: "status_name" },
			{ type: "control", width:100 },
			 
			/*
            { name: "Age", type: "number", width: 50 },
            { name: "Address", type: "text", width: 200 },
            { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
            { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
			*/
           
			
        ]
    });

});
</script>
<script>
var base_url='http://crgroup.co.in/lg/sqim/';

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
	
	
	return res;
}
	getStatus=getSelectData('status');
	getCauseDept=getSelectData('cause_dept');
	getCategory=getSelectData('category');
	getDefect=getSelectData('defect');
    var db = {

        loadData: function(filter) {
			// console.log(this.clients);
			var clientDataArray=new Array();
			var clientDataArray2=new Array();
			$.ajax({
						url: base_url+"suppliers/get_all_lg_repair_user_data", 
						type: "POST",
						dataType:"json",
						cache:false,
						async:false,
						success: function(response){ 
							//console.log(response);
							$.each(response,function(key,data){
								//if(data.photo==''){
									var photo="<a href='' class='uploadImg' data-toggle='modal' data-target='#myModal' data-id='"+data.set_sn+"'>Upload</a>";
								//}
								//else{
									//var photo="<img width='64' height='64' src='"+base_url+"upload/images/LGREPAIR/"+data.set_sn+"/photo/"+data.photo+"'>"
								//}
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
								obj['Vendor']=data.vendor;
								obj['Part']=data.part;
								obj['Defect']=data.defect;
								obj['Category']=data.category;
								obj['Cause Dept']=data.repair_user_cause_dept;
								//obj['Photo']=data.photo;
								obj['Status']=data.status;
								obj['Photo']=photo;
																
								clientDataArray.push(obj);
							});
							//console.log(clientDataArray);
						}
				})
			return clientDataArray;	
		},

        insertItem: function(insertingClient) {
            this.clients.push(insertingClient);
        },

        updateItem: function(updatingClient) {
			var updatingClientString=JSON.stringify(updatingClient ); 
			$.ajax({
					   url: base_url+"suppliers/lg_repair_user_save_data", 
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
            var clientIndex = $.inArray(deletingClient, this.clients);
            this.clients.splice(clientIndex, 1);
        }

    };

    window.db = db;


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
			url: base_url+"suppliers/upload_repair_user_image/"+sno, 
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
					$('#uploadResponse').html('<br/>Image Successfully Uploaded.');	
					$.ajax({
						url: base_url+"suppliers/get_uploaded_photo/"+sno, 
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
				}else{
					$('#uploadResponse').html('<br/>Image Upload Unsuccessful.');
				}
			}
		})
	});
});
</script>