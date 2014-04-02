<?php 
//echo $this->Html->script('jquery.ui.datepicker');
echo $this->Html->script('jquery.validate');
//echo $this->Html->script('visa_app_validation');
echo $this->fetch('script');	
?>
<style>
#my_file {
    display: none;
}
input.error,select.error
{
border:1px solid red;
}
#get_file {
width: 10px;
position: absolute;
cursor: pointer;
margin-left: 40px;
background:red;
}
#customfileupload
{
background: #f5f5f5;
margin: 0;
padding: 1px;
border: 1px solid #ebebeb;
vertical-align: top;
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
color: #646464;
resize: none;
width: 75px;
}
.notify-info{
margin:5px;
font-size:12px!important;
}

.date_style{
width: 59px;
font-size: 12px;
margin-left:2px;
} 

.airline_select{
min-width : 100px!important;
}

.message1{
padding:7px 13px!important;
}

.ui-state-highlight{
border-color: none!important;
background-color: #F8C1C1!important;
}
</style>
		
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
					<div class="widget-head green">
							<h3>Extensions</h3>
						</div>
						<div class="widget-container">
<form action="<?php echo $this->webroot; ?>extension" id="extension1" name="extension1" class="dropzone" novalidate="novalidate" enctype="multipart/form-data" method="post" accept-charset="utf-8" >
<input type = "hidden" name = "rowcount" id = "rowcount" value = "1" />

<?php if($this->UserAuth->getGroupName() != 'User'){ ?>
	<div class="control-group" >
	<label class="control-label"><?php echo __('Select Agent');?></label>
		<div class="controls" style = "float:left;width:400px;">
		<?php if(!isset($agent)) $agent = array('select'=>'Select'); ?>
				<?php echo $this->Form->input("agent" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$agent,'style'=>'width:356px;','onchange'=>'get_agent_ext(this.value)'))?>
		
		</div>
		<div style = "float:left;" id = "BalAmt"></div>
		<div style = "clear:both;" ></div>
	</div>
<?php } ?>

<table class = 'table table-striped table-bordered dataTable' id="form-table">
	<tr class="form-field_header ">
		<th scope="row"><label for="name"><?php echo 'Name';?></label></th>
		<th scope="row"><label for="passport"><?php echo 'Passport No.';?></label></th>
		<th scope="row"><label for="visa"><?php echo 'Visa'; ?></label></th>
		<th scope="row" class = "delete"><label for="add">Action</label></th>
	</tr>
	<tr> 
		<td><?php echo $this->Form->input("name1" ,array('label' => false,'div' => false,'placeholder'=>'Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("passportno1" ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->file("visa1" ,array('label' => false,'div' => false,'id'=>"my_file_two1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_two1" class = "fileU" title="Select a Visa scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload2">Select a file</div></td>
		<td class = "delete"><input type = "button" class = "delete" name = "delete1" onclick='killRow(this);' value = "Delete" /></td>	
	</tr>

</table><br/>
<button id="add" class="btnAddMore" onclick="addRow()">+ Add More</button>	
<div style="clear:both;"></div>

<div class = "form-actions"><button type="submit" class="btn btn-primary"> Save</button></div>
</form>

</div>
<div style="clear:both;">&nbsp;</div>
</div></div></div></div>

<script type="text/javascript">


 function addRow(){ 	
	 	   var table = document.getElementById('form-table');
           var rowCount = table.rows.length;
		   if(rowCount <= 10){
            var row = table.insertRow(rowCount);
			row.className = 'edit';
            var colCount = table.rows[0].cells.length;
			document.getElementById("rowcount").value = rowCount;
            for(var i=0; i<colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[1].cells[i].innerHTML;
               
                switch(newcell.childNodes[0].type) {
                    case "text":
                    {
                         newcell.childNodes[0].value = "";
                         newcell.childNodes[0].name = newcell.childNodes[0].name.replace(1,rowCount);
                         newcell.childNodes[0].id = newcell.childNodes[0].id.replace(1,rowCount);
                         $("input[name='"+newcell.childNodes[0].name +"']").rules("add", {required:true});
                   	}
			 break;
			case "button":
				newcell.childNodes[0].name = newcell.childNodes[0].name.replace(1,rowCount);
                 break;	
                 }
                
      			if(newcell.children.length > 1 && newcell.childNodes[1].className == 'error')
				newcell.removeChild(newcell.childNodes[1]);
                  
			}	
			jQuery(".edit label").hide();
			
		         	
		var m = document.getElementsByName("fileupload2");
		m[m.length -1].innerHTML ='Select a file';
		m[m.length -1].id  = "customfileupload_two" +(rowCount);
		document.getElementsByName("data[visa1]")[1].value = '';
		document.getElementsByName("data[visa1]")[1].id  = "my_file_two" +(rowCount);
		document.getElementsByName("data[visa1]")[1].name= "data[visa" +rowCount+"]";
		$("#my_file_two" +(rowCount)).rules("add", {required:true,extension:true,filesize:true});
		}
		return false;
}


jQuery.validator.addMethod("alphanumeric", function(value, element) {
       	 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
});
			
jQuery.validator.addMethod("anyDate",
function(value, element) {
return value.match(/^(0?[1-9]|[12][0-9]|3[0-2])[.,/ -](0?[1-9]|1[0-2])[.,/ -](19|20)?\d{2}$/);
},
"Please enter valid date"
);

jQuery(document).ready(function($){
jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|png|jpe?g|gif|doc|docx|rtf";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));  

$.validator.addMethod('filesize', function(value, element,param) {
 param = "1048576";
 return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  
	jQuery("#extension1").validate({ 
		  rules: {
                 		 'data[name1]':{
          				  required:true,
          				  },
          				  'data[passportno1]': {
                            required: true,                        
                          },
                          'data[visa1]': {
                            required: true,  
                            extension:true,        
                            filesize:true             
                        	}
                       },
                      
	});
});

function killRow(src) {
var result = confirm("Do you really want to delete?");
if (result==true) {
	var dRow = src.parentElement.parentElement;  
	var row_index = dRow.rowIndex;	 
    var table = document.getElementById('form-table');
    var rowCount = table.rows.length;
    //alert(rowCount);
	if(rowCount == 2){
	
		document.getElementsByName('data[name1]')[0].value = '';
		document.getElementsByName('data[passportno1]')[0].value = '';
		document.getElementsByName('data[visa1]')[0].value = '';	
	}else{
	
	document.all("form-table").deleteRow(row_index);
	document.getElementById("rowcount").value = parseInt(row_index) - parseInt(1);	
	var count = parseInt(row_index) + parseInt(1);

	for(i = parseInt(row_index) + parseInt(1); i < parseInt(rowCount); i++){
	//alert('my_file_two'+(i - 1));
	$('#my_file_two'+i).attr('id','my_file_two'+(i - 1));
	$('#customfileupload_two'+i).attr('id','customfileupload_two'+(i - 1));
	//document.getElementsByName('data[name'+i+']')[0].id = 'my_file_two'+(i - 1);
		document.getElementsByName('data[name'+i+']')[0].name = 'data[name'+(i - 1)+']';
		
		document.getElementsByName('data[passportno'+i+']')[0].name = 'data[passportno'+(i - 1)+']';
		document.getElementsByName('data[visa'+i+']')[0].name = 'data[visa'+(i - 1)+']';
		
	}
	}
	}
}

function Getfile(id)
{
var newid = id.replace('customfileupload','my_file');
document.getElementById(newid).click();
}

function showName(newid)
{
var path = document.getElementById(newid).value;
p=path.split('\\');
var val1 = p[p.length - 1];
var id = newid.replace('my_file','customfileupload');
if (val1.length>0)
    jQuery('#'+id).html(val1);
    else
    jQuery('#'+id).html("Select a file");

}


function get_agent_ext(agent){
 		$('#form-table').find("tr:gt(1)").remove();
		var validator = $( "#form-table" ).validate();
		validator.resetForm();
		$('#rowcount').val(1);
    	document.getElementsByName('data[name1]')[0].value = '';
		document.getElementsByName('data[passportno1]')[0].value = '';
		document.getElementsByName('data[visa1]')[0].value = '';	
		$('.fileU').html('Select a file'); 
		
		 $.ajax({
		      url: "<?php echo $this->webroot; ?>usermgmt/users/get_ext_info",
		      dateType:'html',
		      type:'post',
		      data:'id='+agent,
		      success: function(data){
		      if(data != 'Error')
		       	$("#BalAmt").html(data);
		       else $("#BalAmt").html('');	
		      }
		    });  
		      
}
</script>