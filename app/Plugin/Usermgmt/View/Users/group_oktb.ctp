<?php 
echo $this->Html->script('jquery.validate');
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
						<div class="widget-container">
<div id = "add_data" class="site">
<div class = "alert alert-danger message1" style = "display:none">Same Day OKTB requests must be atleast 6 hours before the flight time. </div>
<form action="<?php echo $this->webroot; ?>usermgmt/users/save_group_oktb" id="frm_data2" name="frm_data2" class="dropzone" novalidate="novalidate" enctype="multipart/form-data" method="post" accept-charset="utf-8" >
<input type = "hidden" name = "rowcount" id = "rowcount" value = "1" />
<input type = "hidden" name = "group" id = "group" value = "1" />
<input type = "hidden" name = "curr_date" value = "<?php echo date('Y-m-d'); ?>"  id = "curr_date"/>
<input type = "hidden" name = "next_date" value = "<?php echo date('Y-m-d', strtotime(' +1 day')); ?>"  id = "next_date"/>
<input type = "hidden" name = "curr_time" value = "<?php echo date('H:i'); ?>"  id = "curr_time"/>
<input type = "hidden" name = "uCount" value = "<?php if(isset($uCount)) echo $uCount; else echo 2; ?>"  id = "uCount"/>

<?php if($this->UserAuth->getGroupName() != 'User'){ ?>
	<div class="control-group">
	<label class="control-label"><?php echo __('Select Agent');?></label>
		<div class="controls">
		<?php if(!isset($agent)) $agent = array('select'=>'Select'); ?>
				<?php echo $this->Form->input("agent" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$agent,'style'=>'width:356px;','onchange'=>'get_agent_oktb(this.value)'))?>
		<span id = "BalAmt"></span>
		</div>
		
	</div>
	
<?php } ?>

<table class = 'table table-striped table-bordered dataTable' id="form-table">

<tr class="form-field_header ">
<th scope="row"><label for="name"><?php echo 'Name';?></label></th>
<th scope="row"><label for="pnr"><?php echo 'PNR';?></label></th>
<th scope="row"><label for="d_o_j"><?php echo 'Date of Journey';?></label></th>
<th scope="row"><label for="passport"><?php echo 'Passport';?></label></th>
<th scope="row"><label for="visa"><?php echo 'Visa'; ?></label></th>
<th scope="row"><label for="from_ticket"><?php echo 'From Ticket';?></label></th>
<th scope="row"><label for="to_ticket"><?php echo 'To Ticket';?></label></th>
<th scope="row"><label for="airline"><?php echo 'Select Airline'; ?></label></th>
</tr>
	<tr> 
		<td><?php echo $this->Form->input("name1" ,array('label' => false,'div' => false,'placeholder'=>'Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("pnr1" ,array('label' => false,'div' => false,'placeholder'=>'PNR','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("d_o_j1" ,array('label' => false,'div' => false,'class'=>'datepicker','placeholder'=>'Date Of Journey','onchange'=>"check_date(this.name+','+this.value)",'readonly'=>true))?>
	
		<div class="input-append flight_time" id = "f_time1" name = "f_time1">
		<?php $date_hh = array('hh'=>'-hh-','00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fi=10;$fi<=23;$fi++){ $date_hh[$fi] = $fi; }?>
		<?php $date_mm = array('00'=>'-mm-','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fj=10;$fj<=59;$fj++){ $date_mm[$fj] = $fj; }?>
			<br/>
		<?php echo $this->Form->input("f_hh1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_hh,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)' ))?>
		<?php echo $this->Form->input("f_mm1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)' ))?>
			</div>		
		</td>
		
		<td><?php echo $this->Form->file("passport1" ,array('label' => false,'div' => false,'id'=>"my_file_one1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_one1" class = "fileU" onclick="Getfile(this.id)" title="Select a Passport scanned copy or a photo" name="fileupload1" class>Select a file</div>
		<br/><?php echo $this->Form->input("passportno1" ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		
		<td><?php echo $this->Form->file("visa1" ,array('label' => false,'div' => false,'id'=>"my_file_two1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_two1" class = "fileU" title="Select a Visa scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload2">Select a file</div></td>
		
		<td><?php echo $this->Form->file("from_ticket1" ,array('label' => false,'div' => false,'id'=>"my_file_three1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_three1"  class = "fileU" title="Select a From Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload3">Select a file</div></td>
		
		<td><?php echo $this->Form->file("to_ticket1" ,array('label' => false,'div' => false,'id'=>"my_file_four1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_four1" class = "fileU" title="Select a To Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload4">Select a file</div></td>
		
		<td><?php echo $this->Form->input("airline1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$airline,'class'=>'chzn-select airline_select','ONCHANGE'=>"get_Amt(this.name+','+this.value)"))?><br/>
		<?php echo $this->Form->input("amount1" ,array('label' => false,'div' => false,'placeholder'=>'Amount','readonly'=>true))?>
		</tr>
</table><br/>

<table class = 'table table-striped table-bordered dataTable' id = "form-table2">
<tr class="form-field_header ">
		<th scope="row"><label for="name"><?php echo 'Name';?></label></th>
		<th scope="row"><label for="passport"><?php echo 'Passport No';?></label></th>
		<th scope="row"><label for="passport"><?php echo 'Upload Passport';?></label></th>
		<th scope="row"><label for="visa"><?php echo 'Upload Visa'; ?></label></th>
		<th scope="row" class = "delete"><label for="add">Action</label></th>
</tr>
<tbody>
<tr>
		<td><?php echo $this->Form->input("name2" ,array('label' => false,'div' => false,'placeholder'=>'Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("passportno2" ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->file("passport2" ,array('label' => false,'div' => false,'id'=>"my_file_one2",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_one2" class = "fileU" onclick="Getfile(this.id)" title="Select a Passport scanned copy or a photo" name="fileupload1">Select a file</div></td>
		<td><?php echo $this->Form->file("visa2" ,array('label' => false,'div' => false,'id'=>"my_file_two2",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_two2" class = "fileU" title="Select a Visa scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload2">Select a file</div></td>
		<td class = "delete"><input type = "button" class = "delete" name = "delete1" onclick='killRow(this);' value = "Delete" /></td></tr>
</tr>
</tbody>
</table>

<div id = "total_amt2"><label>Total Amount <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></label> 
<input type="text" name="total2" id ="total2" readonly/></div>

<div class = "alert alert-danger message1" style = "display:none">Same Day OKTB requests must be atleast 6 hours before the flight time. </div>

<input type="button" class="btnoktbSubmit" value="Confirm" onclick="Submit_Form()" id ="confirm2" />
<input type="button" class="btnoktbEdit" value="Edit" onclick="Edit()" id="edit2" />
<input type="submit" class="btnoktbpayment2 btnMakepayment2" value="Pay Now" id ="payment2" onclick = "disable()" />
</form>

<button id="add2" class="btnAddMore" onclick="addRow2()">+ Add More Passengers</button>	
<div style="clear:both;"></div>

</div>
</div></div></div></div></div>

<script type = "text/javascript">

function disable(){
	jQuery("select").attr("disabled", false);
	jQuery("input:text").prop('disabled', false);
	jQuery("input:file").prop('disabled', false);
	}
	
$(document).ready(function(){
$('#notice').hide(); 
  var nowTemp = new Date();
  if (nowTemp.getHours()>=19) var daysToAdd = +1; else var daysToAdd = 0;
  
  document.getElementById('edit2').style.display = 'none';
  document.getElementById('payment2').style.visibility = 'hidden';
  document.getElementById('total_amt2').style.display = 'none';
  
  $(".flight_time").css('display','none');
  
jQuery.validator.addMethod("alphanumeric", function(value, element) {
       	 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
			});
			
jQuery.validator.addMethod("anyDate",
function(value, element) {
return value.match(/^(0?[1-9]|[12][0-9]|3[0-2])[.,/ -](0?[1-9]|1[0-2])[.,/ -](19|20)?\d{2}$/);
},
"Please enter valid date"
);

jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|png|jpe?g|gif|doc|docx|rtf";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));  

 $.validator.addMethod('filesize', function(value, element,param) {
 param = "1048576";
 return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  

$("#frm_data2").validate({  

                    rules: {
                 		 'data[name1]':{
          				  required:true,
          				  },
          				   'data[name2]':{
          				  required:true,
          				  },
          				  'data[pnr1]':{
          				  required:true,
          				  alphanumeric:true
          				  },
                        'data[d_o_j1]': {
                            required: true,
                        },
                         'data[flight_time1]': {
                            required: true,
                        },
                        'data[passport1]': {
                         extension:true   ,
                         filesize:true                
                        },
                        'data[passportno1]': {
                            required: true,                        
                        },
                       'data[passport2]': {
                         extension:true   ,
                         filesize:true                
                        },
                        'data[passportno2]': {
                            required: true,                        
                        },
                         'data[f_hh1]': {
                            required: true,  
                            digits:true,                      
                        },
                         
                        'data[visa1]': {
                            required: true,  
                            extension:true,        
                            filesize:true             
                        },
                         'data[visa2]': {
                            required: true,  
                            extension:true,        
                            filesize:true             
                        },
                           'data[from_ticket1]': {
                            required: true,    
                            extension:true  ,
                            filesize:true                  
                        },
                        
                        'data[to_ticket1]' :{ 
                     	required :true,
                     	extension:true,
                     	filesize:true
          				  }, 
          				  
          				   'data[airline1]' :{ 
                     	required :true,
                     	 digits: true,
          				  }, 
      				     				           				  
     				    'data[amount1]' :{       
     				    required :true,            
                     	 digits: true,
          				  }, 

},
                    messages: {
                                          				        
                       'data[pnr1]':{
                       required:"PNR is required",
                       alphanumeric:"PNR should be alphanumeric",
                       },
                         'data[airline1]' :{ 
                     	required :"Please Select",
                     	 digits: "Please Select",
          				  }, 
          		 'data[f_hh1]' :{ 
                     	required :"Please Select",
                     	 digits: "Please Select",
          				  }, 
                    }
                });
                
        
       
jQuery('.page-id-781 .primary_content_wrap .grid_16').css('background','none');

	   jQuery(".datepicker").datepicker({ 
		   showWeek: true, 
		   showButtonPanel: true, 
		   changeMonth: true, 
		   changeYear: true,
		   dateFormat: 'yy-mm-dd', 
	       yearRange:'1947:' + (new Date().getFullYear() + 2),
		   minDate: daysToAdd,
		   beforeShowDay: highlightDays,
		   beforeShow: function(input, inst) {       
       	   window.setTimeout(function(){
          	 $(inst.dpDiv).find('a.ui-state-highlight').removeClass('ui-state-highlight ui-state-hover')      
      		},0)     
   },  
	   });   
});

function get_curr_next_date(){

var uCount = $('#uCount').val(); 
var curr_date = new Date();
curr_date.setHours(0, 0, 0, 0);

if(uCount == 0) 
var next_date = curr_date;
else{
var uCnt = parseInt(uCount) - 1;
var next_date = new Date(curr_date.getTime() + 24 * 60 * 60 * 1000 * uCnt);
next_date.setHours(0, 0, 0, 0);
}
var data = [curr_date,next_date];
 return data;
}

function highlightDays(date) {

var data =  get_curr_next_date();
     	var date1 = date.getTime();
     	var s_date = data[0].getTime();
     	var l_date = data[1].getTime();
     	if (date1 >= s_date && date1 <= l_date ) { 
                return [true, 'ui-state-highlight','Urgent'];
            }
        return [true, ''];
     } 
     
function addRow2(){
           var table = document.getElementById('form-table2');
           var rowCount = table.rows.length;
			if(rowCount <= 30){
            var row = table.insertRow(rowCount);
			row.className = 'edit';
            var colCount = table.rows[0].cells.length;
           
			document.getElementById("rowcount").value = rowCount;
			 var rowCount = rowCount + 1;
            for(var i=0; i<colCount; i++) {
           	   
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[1].cells[i].innerHTML;
               
                switch(newcell.childNodes[0].type) {
                    case "text":
                    {
                 	 //  alert(newcell.childNodes[0].name);
                         newcell.childNodes[0].value = "";
                         newcell.childNodes[0].name = newcell.childNodes[0].name.replace(2,rowCount);
                         newcell.childNodes[0].id = newcell.childNodes[0].id.replace(2,rowCount);
                    //   alert(newcell.childNodes[0].name);
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
			jQuery(".edit2 label").hide();
	
		var p = document.getElementsByName("fileupload1");
		
		p[p.length -1].innerHTML ='Select a file';
		p[p.length -1].id  = "customfileupload_one" +(rowCount);
		document.getElementsByName("data[passport2]")[1].value = '';
		document.getElementsByName("data[passport2]")[1].id  = "my_file_one" +(rowCount);
		document.getElementsByName("data[passport2]")[1].name= "data[passport" +rowCount+"]";
		var aData = $('#airline1').val();
		if(aData == 3 || aData == 6 || aData == 8){
			$("#my_file_one" +(rowCount)).rules("add", {required:true,extension:true,filesize:true});
			}else{
			$("#my_file_one" +(rowCount)).rules("remove");
			}
		$("#my_file_one" +(rowCount)).rules("add", {extension:true,filesize:true});
		         	
		var m = document.getElementsByName("fileupload2");
		m[m.length -1].innerHTML ='Select a file';
		m[m.length -1].id  = "customfileupload_two" +(rowCount);
		document.getElementsByName("data[visa2]")[1].value = '';
		document.getElementsByName("data[visa2]")[1].id  = "my_file_two" +(rowCount);
		document.getElementsByName("data[visa2]")[1].name= "data[visa" +rowCount+"]";
		$("#my_file_two" +(rowCount)).rules("add", {required:true,extension:true,filesize:true});
		 }else{
			alert("Only 30 records can be added at a time");
		  }
}

function killRow(src) {
if(confirm("Do you really want to delete?")){
    var dRow = src.parentElement.parentElement;  
	var row_index = dRow.rowIndex;	 
    var table = document.getElementById('form-table2');
    var rowCount = table.rows.length;
 // alert(row_index);
	if(rowCount == 2){
		document.getElementsByName('data[name2]')[0].value = '';
		document.getElementsByName('data[passport2]')[0].value = '';
		document.getElementsByName('data[passportno2]')[0].value = '';
		document.getElementsByName('data[visa2]')[0].value = '';
	}else{
	document.all("form-table2").deleteRow(row_index);
	document.getElementById("rowcount").value = parseInt(row_index)-parseInt(1);
    var count = parseInt(row_index) + parseInt(2);
	for($i = count; $i <= rowCount; $i++){
	
		document.getElementsByName('data[name'+$i+']')[0].name = 'data[name'+($i - 1)+']';
		document.getElementsByName('data[passportno'+$i+']')[0].name = 'data[passportno'+($i - 1)+']';
		document.getElementsByName('data[passport'+$i+']')[0].name = 'data[passport'+($i - 1)+']';
		document.getElementsByName('data[visa'+$i+']')[0].name = 'data[visa'+($i - 1)+']';
		$('#my_file_one'+$i).attr('id','my_file_one'+($i - 1));
		$('#customfileupload_one'+$i).attr('id','customfileupload_one'+($i - 1));
		$('#my_file_two'+$i).attr('id','my_file_two'+($i - 1));
		$('#customfileupload_two'+$i).attr('id','customfileupload_two'+($i - 1));
	}
	}
	}
}

function get_Amt(str){
var agent = $('#agent').val();
var split = str.split(",");
var name = split[0];
var last_value = name.charAt(name.length - 2);
var value = split[1];
var row = $('#rowcount').val();
//alert(value);
if(value == 3 || value == 8){
for(var i = 2 ; i <= parseInt(row) + parseInt(1); i++){
$("#my_file_one"+i).rules("add", {required:true});
}
$("#my_file_one" +(last_value)).rules("add", {required:true});
}else{
for(var i = 2 ; i <= parseInt(row) + parseInt(1); i++){
$("#my_file_one"+i).rules("remove");
}
$("#my_file_one" +(last_value)).rules("remove");
}

jQuery.ajax({
type: "POST",
url: '<?php echo $this->webroot; ?>get_airline_amt',
data: 'value='+value+'&agent='+agent,
success: function(response) {
document.getElementsByName('data[amount'+last_value+']')[0].value = response;
}
});
return false;
}


function Submit_Form(){
if(jQuery("#frm_data2").valid())
{
	jQuery("#confirm2").hide();
	jQuery("#edit2").show();
	document.getElementById('payment2').style.visibility = 'visible';
	jQuery("#total_amt2").show();
	jQuery("#add2").hide();
	jQuery(".delete").hide();
	
	jQuery("input:text").prop('disabled', true);
	jQuery("input:file").prop('disabled', true);
	jQuery("select").attr("disabled", true);
	//var table = document.getElementById('form-table2');
	//var rowCount = table.rows.length;
	//var rowCount = $('#form-table tr').length;
	var rowCount = $('#rowcount').val();
	var v = 0;
	jQuery("#total2").val('');
	var row = parseInt(rowCount) + 1;
	
	var amt = document.getElementsByName('data[amount1]')[0].value;
		if(amt != ""){
			v = parseInt(amt) * parseInt(row);
			jQuery("#total2").val(v); 
		}
	
	return true;
	}
}

function Edit(){
	jQuery("#add2").show();
	jQuery("#confirm2").show();
	jQuery(".delete").show();
	jQuery("#total_amt2").hide();
	 
	document.getElementById('payment2').style.visibility = 'hidden';
	jQuery("#edit2").hide();
	jQuery("input:text").prop('disabled', false);
	jQuery("input:file").prop('disabled', false);
	jQuery("select").attr("disabled", false);
	return false;
}


 function get_agent_oktb(agent){
 $('#form-table2').find("tr:gt(1)").remove();
var validator = $( "#form-table2" ).validate();
validator.resetForm();
 $('#rowcount').val(1);
        document.getElementsByName('data[name1]')[0].value = '';
		document.getElementsByName('data[pnr1]')[0].value = '';
		document.getElementsByName('data[d_o_j1]')[0].value = '';
		document.getElementsByName('data[f_hh1]')[0].value = '';
		document.getElementsByName('data[f_mm1]')[0].value = '';
		document.getElementsByName('data[passport1]')[0].value = '';
		document.getElementsByName('data[passportno1]')[0].value = '';
		document.getElementsByName('data[visa1]')[0].value = '';
		document.getElementsByName('data[from_ticket1]')[0].value = '';
		document.getElementsByName('data[to_ticket1]')[0].value = '';
		document.getElementsByName('data[airline1]')[0].selectedIndex = 0;
		document.getElementsByName('data[amount1]')[0].value = '';
		document.getElementsByName('data[name2]')[0].value = '';
		document.getElementsByName('data[passportno2]')[0].value = '';
		$('.fileU').html('Select a file');
		
 var nowTemp = new Date();
 if (nowTemp.getHours()>=19) var daysToAdd = +1; else var daysToAdd = 0;
 if(agent != 'select'){
		 $.ajax({
		      url: "<?php echo $this->webroot; ?>usermgmt/users/get_oktb_info",
		      dateType:'html',
		      type:'post',
		      data:'id='+agent,
		      success: function(data){
		     	if(data != 'Error'){
		     	var obj = jQuery.parseJSON(data);
		     	$('#uCount').val(obj[0]);
		     	 $("#BalAmt").html(obj[1]);
		     	uCount = $('#uCount').val(obj[0]);
		     jQuery('.datepicker').removeClass('hasDatepicker').removeAttr('id').datepicker({ 
	   showWeek: true, 
	   showButtonPanel: true, 
       changeMonth: true, 
       changeYear: true,
	   dateFormat: 'yy-mm-dd', 
       yearRange:'1947:' + (new Date().getFullYear() + 2),
	   minDate: daysToAdd,
	   beforeShowDay: highlightDays,
		  beforeShow: function(input, inst) {       
       	   window.setTimeout(function(){
          	 $(inst.dpDiv).find('a.ui-state-highlight').removeClass('ui-state-highlight ui-state-hover')      
      		},0)     
   },  
	   });
	   }
			 	}    
		    });
		    }else{
		     $("#BalAmt").html('');
		    }
		    return false;
}

</script>