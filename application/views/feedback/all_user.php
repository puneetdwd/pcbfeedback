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
<!--<div><input type='checkbox' id='showAll' id='showAll' value='1' />SHOW ALL <br/> </div>-->
<div id="jsGrid"></div>
<div id="jsGrid1"></div>
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
$(function() {

    $("#jsGrid").jsGrid({

        
		height: "auto",
        width: "100%",
		

        filtering: true,
        //editing: true,
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
			{ name: "Defect", type: "text", width: 150, items: db.defect, valueField: "Id", textField: "Name",editing: false},
			{ name: "Category", type: "text", width: 150, items: db.category, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause Dept", type: "text", width: 150, items: db.cause_dept, valueField: "Id", textField: "Name",editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150, items: db.status, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "Operator Name", type: "text", width: 150 },
			{ name: "Action", type: "text", width: 150 },
		/*	
			
            { name: "Age", type: "number", width: 50 },
            { name: "Address", type: "text", width: 200 },
            { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
            { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
			*/
            { type: "control", deleteButton: false,width:100 }
			
        ]
    });

});
</script>
<script>

//var base_url='http://crgroup.co.in/lg/sqim/';

var base_url= 'http://10.101.0.80:90/pcbfeedback/';

$(function() {

    var db = {
 
        loadData: function(filter) {
           // console.log(this.clients);
			var clientDataArray=new Array();
			var clientDataArray2=new Array();
			

                                               $.ajax({
						url: base_url+"suppliers/get_all_user_data_total", 
						type: "POST",
						dataType:"json",
						cache:false,
						async:false,
						success: function(response){ 
			                    	$.each(response,function(key,data){

								var photo="<a href='' class='uploadImg' data-toggle='modal' data-target='#myModal' data-id='"+data.set_sn+"'>View</a>";
								/*if(data.photo=='' || data.photo==undefined ){
									var photo="";
								}
								else{
									var photo="<img width='64' height='64' src='"+base_url+"upload/images/LGREPAIR/"+data.set_sn+"/photo/"+data.photo+"'>"
								}*/
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
								//obj['Photo']=data.photo;
								obj['Cause']=data.user_cause;
								obj['Operator Name']=data.operator_name;
								obj['Action']=data.action;
																
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
            this.clients.push(insertingClient);
        },

        updateItem: function(updatingClient) {
			var updatingClientString=JSON.stringify(updatingClient ); 
			$.ajax({
					   url: base_url+"suppliers/lg_user_save_data", 
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
			{ name: "DefectDate", type: "text", width: 175,editing: false },
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
			{ name: "Defect", type: "text", width: 150, items: db1.defect, valueField: "Id", textField: "Name",editing: false},
			{ name: "Category", type: "text", width: 150, items: db1.category, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause Dept", type: "text", width: 150, items: db1.cause_dept, valueField: "Id", textField: "Name",editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150, items: db1.status, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "Operator Name", type: "text", width: 150 },
			{ name: "Action", type: "text", width: 150 },
			
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
			{ name: "DefectDate", type: "text", width: 175,editing: false },
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
			{ name: "Defect", type: "text", width: 150, items: db.defect, valueField: "Id", textField: "Name",editing: false},
			{ name: "Category", type: "text", width: 150, items: db.category, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause Dept", type: "text", width: 150, items: db.cause_dept, valueField: "Id", textField: "Name",editing: false },
			{ name: "Photo", type: "text", width: 150,editing: false },
			{ name: "Status", type: "text", width: 150, items: db.status, valueField: "Id", textField: "Name",editing: false },
			{ name: "Cause", type: "text", width: 150 },
			{ name: "Operator Name", type: "text", width: 150 },
			{ name: "Action", type: "text", width: 150 },
			
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