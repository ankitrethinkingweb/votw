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
<form action="<?php echo $this->webroot; ?>usermgmt/users/save_oktb" id="frm_data" name="frm_data" class="dropzone" novalidate="novalidate" enctype="multipart/form-data" method="post" accept-charset="utf-8" >					
<input type = "hidden" name = "rowcount" id = "rowcount" value = "1" />
<input type = "hidden" name = "curr_date" value = "<?php echo date('Y-m-d'); ?>"  id = "curr_date"/>
<input type = "hidden" name = "next_date" value = "<?php echo date('Y-m-d', strtotime(' +1 day')); ?>"  id = "next_date"/>
<input type = "hidden" name = "curr_time" value = "<?php echo date('H:i'); ?>"  id = "curr_time"/>
<input type = "hidden" name = "uCount" value = "<?php if(isset($uCount)) echo $uCount; else echo 2; ?>"  id = "uCount"/>


<?php if($this->UserAuth->getGroupName() != 'User'){ ?>
	<div class="control-group">
	<label class="control-label"><?php echo __('Select Agent');?></label>
		<div class="controls" style = "float:left;width:400px;">
		<?php if(!isset($agent)) $agent = array('select'=>'Select'); ?>
				<?php echo $this->Form->input("agent" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$agent,'style'=>'width:356px;','onchange'=>'get_agent_oktb(this.value)'))?>
		</div>
		<div style = "float:left;" id = "BalAmt"></div>
		<div style = "clear:both;" ></div>
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
<th scope="row"><label for="amount"><?php echo 'Amount'; if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></label></th>
<th scope="row" class = "delete"><label for="add">Action</label></th>
</tr>
<?php if(!isset($_SESSION['array_data'])){  ?>
	<tr> 
		<td><?php echo $this->Form->input("name1" ,array('label' => false,'div' => false,'placeholder'=>'Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("pnr1" ,array('label' => false,'div' => false,'placeholder'=>'PNR','onblur'=>"this.value=this.value.toUpperCase()",'onchange'=>'validatePNR(this.name);'))?></td>
		<td><?php echo $this->Form->input("d_o_j1" ,array('label' => false,'div' => false,'class'=>'datepicker','placeholder'=>'Date Of Journey','onchange'=>"check_date(this.name+','+this.value)",'readonly'=>true))?>
	
		<div class="input-append flight_time" id = "f_time1" name = "f_time1">
		<?php $date_hh = array('hh'=>'-hh-','00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fi=10;$fi<=23;$fi++){ $date_hh[$fi] = $fi; }?>
		<?php $date_mm = array('00'=>'mm','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fj=10;$fj<=59;$fj++){ $date_mm[$fj] = $fj; }?>
			<br/>
		<?php echo $this->Form->input("f_hh1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_hh,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)' ))?>
		<?php echo $this->Form->input("f_mm1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)' ))?>
			</div>		
		</td>
		
		<td><?php echo $this->Form->file("passport1" ,array('label' => false,'div' => false,'id'=>"my_file_one1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_one1" onclick="Getfile(this.id)" title="Select a Passport scanned copy or a photo" name="fileupload1">Select a file</div>
		<br/><?php echo $this->Form->input("passportno1" ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		
		<td><?php echo $this->Form->file("visa1" ,array('label' => false,'div' => false,'id'=>"my_file_two1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_two1" title="Select a Visa scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload2">Select a file</div></td>
		
		<td><?php echo $this->Form->file("from_ticket1" ,array('label' => false,'div' => false,'id'=>"my_file_three1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_three1" title="Select a From Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload3">Select a file</div></td>
		
		<td><?php echo $this->Form->file("to_ticket1" ,array('label' => false,'div' => false,'id'=>"my_file_four1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_four1" title="Select a To Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload4">Select a file</div></td>
		<?php 
			$airline2 = array('select'=>'Select','1'=>'Air India','2'=>'Jet Airways');
		?>
		
		<td>		<?php //echo $this->Form->input("airline1" ,array('type' => 'hidden','label' => false,'div' => false,'id' => 'air1')); ?>
 <!--<input type = "hidden" name = "airline1" id = "air1" value = "" />-->
<?php echo $this->Form->input("airline1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$airline,'class'=>'chzn-select airline_select','ONCHANGE'=>"get_Amt(this.name+','+this.value)"))?><br/>
		
		<td><?php echo $this->Form->input("amount1" ,array('label' => false,'div' => false,'placeholder'=>'Amount','readonly'=>true))?></td>
		
		<td class = "delete"><input type = "button" class = "delete" name = "delete1" onclick='killRow(this);' value = "Delete" /></td></tr>
		<?php }else{
		$i = 1; 
		foreach($_SESSION['array_data'] as $d){  ?>
		<tr>
	<td><input name="name<?php echo $i;?>" placeholder = "Name" class="validate[required] text-input" type="text" value="<?php echo $d[0]; ?>" /></td>
	<td><input name="pnr<?php echo $i;?>" placeholder = "PNR" class="validate[required,custom[onlyLetterNumber]] text-input" type="text" value="<?php echo $d[1]; ?>" /></td>
	<td><input name="d_o_j<?php echo $i;?>" placeholder = "Date of Journey" class="validate[required] text-input datepicker" type="text" value="<?php echo $d[2]; ?>" readonly/></td>
<td><input name="passportno<?php echo $i;?>" placeholder = "Passport No" class="validate[required] text-input" type="text" value="<?php echo $d[13]; ?>" /><br/>
<input name="passport<?php echo $i;?>" type="file" id="my_file_one<?php echo $i;?>" onchange="showName(this.name)" style="visibility:hidden;" /><div id="customfileupload_one<?php echo $i;?>"  onclick="Getfile(this.id)" name="fileupload1">Select a file</div>
<?php if(isset($_SESSION['array_data'])){ ?><label><?php echo $d[3]['name']; ?><br/><?php echo "<b style='color:red'>".$d[9]."</b>"; ?></label><?php } ?></td>

<td><input name="visa<?php echo $i;?>" class="validate[required]" type="file"  id="my_file_two1" onchange="showName(this.id)"  style="visibility:hidden;" />
<div id="customfileupload_two<?php echo $i;?>" onclick="Getfile(this.id)" name="fileupload2">Select a file</div><label><?php echo $d[4]['name']; ?><br/><?php echo  "<b style='color:red'>".$d[10]."</b>"; ?></label></td>

<td><input name="from_ticket<?php echo $i;?>" class="validate[required]" type = "file" id="my_file_three1" onchange="showName(this.id)"  style="visibility:hidden;" />
<div id="customfileupload_three<?php echo $i;?>" onclick="Getfile(this.id)" name="fileupload3">Select a file</div><label><?php echo $d[5]['name']; ?><br/><?php echo "<b style='color:red'>".$d[11]."</b>"; ?></label></td>
<td><input name="to_ticket<?php echo $i;?>" class="validate[required]" type = "file" id="my_file_four1" onchange="showName(this.id)"  style="visibility:hidden;" /><div id="customfileupload_four<?php echo $i;?>" onclick="Getfile(this.id)" name="fileupload4">Select a file</div><label><?php echo $d[6]['name']; ?><br/><?php echo "<b style='color:red'>".$d[12]."</b>"; ?></label></td>

		<td>
		<select type = "select-one" ONCHANGE="get_Amt(this.name+','+this.value)" name = "airline<?php echo $i;?>" class="validate[required]" value = "">
		<option value = "">Select</option>
		<?php $table_name = $wpdb->prefix . "airline"; $retrieve_data = $wpdb->get_results("SELECT * FROM $table_name"); foreach($retrieve_data as $airline){  ?>
		<option value = "<?php echo $airline->a_name; ?>" <?php if($d[7] == $airline->a_name){ ?>selected="selected"<?php } ?> ><?php echo $airline->a_name; ?></option>
		<?php } ?>
		</select></td>
		<td><input name="amount<?php echo $i;?>" placeholder = "Amount" type="text" value="<?php echo $d[8]; ?>" readonly /><img src="../../wp-content/plugins/wp_oktb/css/images/info.png" class="imgInfo" title="Charges for OK to Board service for selected airline" /></td>
		<td class="delete">
<input type="button" class = "delete" name = "delete<?php echo $i;?>" onclick='killRow(this);' value = "Delete" />
		</td>
		</tr>
		<?php $i++; } } 
		unset($_SESSION['array_data']);
		?>	
	
</table><br/>

<div id = "total_amt"><label>Total Amount <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></label> 
<input type="text" name="total" id ="total" readonly/></div>

<div class = "alert alert-danger message1" style = "display:none">Same Day OKTB requests must be atleast 6 hours before the flight time. </div>

<input type="button" class="btnoktbSubmit" value="Confirm" onclick="Submit_Form()" id ="submit_form" />
<input type="button" class="btnoktbEdit" value="Edit" onclick="Edit()" id="edit" />
<input type="submit" class="btnoktbPayment btnMakePayment" value="Pay Now" id ="payment" onclick = "disable()" />
</form>

<button id="add" class="btnAddMore" onclick="addRow()">+ Add More Passengers</button>	
<div style="clear:both;"></div>

</div>
<div style="clear:both;">&nbsp;</div>
</div></div></div></div></div>
<script type="text/javascript">
	
	function disable(){
	jQuery("select").attr("disabled", false);
	jQuery("input:text").prop('disabled', false);
	jQuery("input:file").prop('disabled', false);
	}
	
function killRow(src) {

var result = confirm("Do you really want to delete?");
if (result==true) {
	 var dRow = src.parentElement.parentElement;  
	var row_index = dRow.rowIndex;	 
	//alert(row_index);
    var table = document.getElementById('form-table');
    var rowCount = table.rows.length;
	if(rowCount == 2){
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
	}else{
	//alert(row_index); 
	document.all("form-table").deleteRow(row_index);
	document.getElementById("rowcount").value = parseInt(row_index)-parseInt(1);	
	for($i = row_index + 1; $i < rowCount; $i++){
		document.getElementsByName('data[name'+$i+']')[0].name = 'data[name'+($i - 1)+']';
		document.getElementsByName('data[pnr'+$i+']')[0].name = 'data[pnr'+($i - 1)+']';
		document.getElementsByName('data[d_o_j'+$i+']')[0].name = 'data[d_o_j'+($i - 1)+']';
		document.getElementsByName('data[f_hh'+$i+']')[0].name = 'data[f_hh'+($i - 1)+']';
		document.getElementsByName('data[f_mm'+$i+']')[0].name = 'data[f_mm'+($i - 1)+']';
		document.getElementsByName('data[passportno'+$i+']')[0].name = 'data[passportno'+($i - 1)+']';
		document.getElementsByName('data[passport'+$i+']')[0].name = 'data[passport'+($i - 1)+']';
		document.getElementsByName('data[visa'+$i+']')[0].name = 'data[visa'+($i - 1)+']';
		document.getElementsByName('data[from_ticket'+$i+']')[0].name = 'data[from_ticket'+($i - 1)+']';
		document.getElementsByName('data[to_ticket'+$i+']')[0].name = 'data[to_ticket'+($i - 1)+']';
		document.getElementsByName('data[airline'+$i+']')[0].id = 'airline'+($i - 1);
		document.getElementsByName('data[airline'+$i+']')[0].name = 'data[airline'+($i - 1)+']';
		document.getElementsByName('data[amount'+$i+']')[0].name = 'data[amount'+($i - 1)+']';
		$('#my_file_one'+$i).attr('id','my_file_one'+($i - 1));
		$('#customfileupload_one'+$i).attr('id','customfileupload_one'+($i - 1));
		$('#my_file_two'+$i).attr('id','my_file_two'+($i - 1));
		$('#customfileupload_two'+$i).attr('id','customfileupload_two'+($i - 1));
		$('#my_file_three'+$i).attr('id','my_file_three'+($i - 1));
		$('#customfileupload_three'+$i).attr('id','customfileupload_three'+($i - 1));
		$('#my_file_four'+$i).attr('id','my_file_four'+($i - 1));
		$('#customfileupload_four'+$i).attr('id','customfileupload_four'+($i - 1));
	}
	}
	}
}

jQuery(document).ready(function($){

$('#notice').show(); 
  var nowTemp = new Date();
  if (nowTemp.getHours()>=19) var daysToAdd = +1; else var daysToAdd = 0;
	 	   
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
  
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  
jQuery("#frm_data").validate({  
		
invalidHandler: function(event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message = errors == 1
        ? 'You missed 1 field. It has been highlighted'
        : 'You missed ' + errors + ' fields. They have been highlighted. Please Check...';
      $("div.message span").html(message);
 $('html, body').animate({ scrollTop: 400 }, 'fast');
      $("div.message").show();
    } else {
      $("div.message").hide();
    }
 
  },
                    rules: {
                     'data[agent]':{
          				  required:true,
          				  digits:true,
          				  },
                 		 'data[name1]':{
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
                         'data[passportno1]': {
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
          				   'data[agent]' :{ 
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
	  	   yearRange:'1947:'+ (new Date().getFullYear() + 2),
	  	   beforeShowDay: highlightDays,
		   beforeShow: function(input, inst) {       
       	   window.setTimeout(function(){
       	    	 $(inst.dpDiv).find('a.ui-state-highlight').removeClass('ui-state-highlight ui-state-hover')      
      		},0)     
   		},  
   		 minDate: 0,
	   });
$(".datepicker a.ui-state-highlight").removeClass("ui-state-highlight");
	  document.getElementById('edit').style.display = 'none';
	  document.getElementById('payment').style.visibility = 'hidden';
	  document.getElementById('total_amt').style.display = 'none';
		
		
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
     
function Submit_Form(){
if(jQuery("#frm_data").valid())
{
	jQuery("#submit_form").hide();
	jQuery("#edit").show();
	document.getElementById('payment').style.visibility = 'visible';
	jQuery("#total_amt").show();
	jQuery("#add").hide();
	jQuery(".delete").hide();
	
	jQuery("input:text").prop('disabled', true);
	jQuery("input:file").prop('disabled', true);
	jQuery("select").attr("disabled", true);
	//jQuery("select").addClass('disable_select');
	var table = document.getElementById('form-table');

	var rowCount = table.rows.length;
	var rowCount = $('#form-table tr').length;
	var v = 0;
	jQuery("#total").val('');
	for(i = 1; i < rowCount; i++){
		var amt = document.getElementsByName('data[amount'+i+']')[0].value;
		if(amt != ""){
			v = parseInt(v) + parseInt(amt);
			jQuery("#total").val(v); 
		}
	}
	return true;
	}
}
 
 
 
 function get_agent_oktb(agent){
 $('#form-table').find("tr:gt(1)").remove();
var validator = $( "#form-table" ).validate();
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
		$('#customfileupload_one1').html('Select a file'); 
		$('#customfileupload_two1').html('Select a file'); 
		$('#customfileupload_three1').html('Select a file'); 
		$('#customfileupload_four1').html('Select a file'); 
		
 var nowTemp = new Date();
 if (nowTemp.getHours()>=19) var daysToAdd = +1; else var daysToAdd = 0;
  if(agent != 'select'){
		 $.ajax({
		      url: "<?php echo $this->webroot; ?>usermgmt/users/get_oktb_info",
		      dateType:'json',
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

function Edit(){
	jQuery("#add").show();
	jQuery("#submit_form").show();
	jQuery(".delete").show();
	jQuery("#total_amt").hide();
	 
	document.getElementById('payment').style.visibility = 'hidden';
	jQuery("#edit").hide();
	jQuery("input:text").prop('disabled', false);
	jQuery("input:file").prop('disabled', false);
	jQuery("select").attr("disabled", false);
	//jQuery("select").removeClass('disable_select');
	return false;
}
 
	 Element.prototype.hasClass = function(className) {
				    return this.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(this.className);
				};
				
 function addRow(){
 
 		 var nowTemp = new Date();
	 	  if (nowTemp.getHours()>=19) 
		   var daysToAdd = +1;
	 	   else var daysToAdd = 0;
	 	   
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
                 	 //  alert(newcell.childNodes[0].name);
                         newcell.childNodes[0].value = "";
                         newcell.childNodes[0].name = newcell.childNodes[0].name.replace(1,rowCount);
                         //alert(newcell.childNodes[0].name);
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
			
		document.getElementsByName("data[f_hh1]")[1].name  = "data[f_hh"+rowCount+"]" ;	
		document.getElementsByName("data[f_hh"+rowCount+"]")[0].id="f_hh"+rowCount;
		$("#f_hh"+rowCount).closest('div').attr('id','f_time'+rowCount);
		
		document.getElementsByName("data[f_mm1]")[1].name  = "data[f_mm"+rowCount+"]" ;	
		document.getElementsByName("data[f_mm"+rowCount+"]")[0].id="f_mm"+rowCount;
		
		$("#f_hh"+rowCount).rules("add", {required:true});
		$("#f_hh"+rowCount).rules("add", {digits:true,
		messages: {
		        digits: "Please Select",
		    }
		});
		$("#f_mm"+rowCount).rules("add", {required:true,digits:true});
		
		
		$('#f_time'+rowCount).css('display','none');
	//	document.getElementsByName("data[flight_time1]")[1].value = '';
		
		var p = document.getElementsByName("fileupload1");
		
		p[p.length -1].innerHTML ='Select a file';
		p[p.length -1].id  = "customfileupload_one" +(rowCount);
		document.getElementsByName("data[passport1]")[1].value = '';
		document.getElementsByName("data[passport1]")[1].id  = "my_file_one" +(rowCount);
		document.getElementsByName("data[passport1]")[1].name= "data[passport" +rowCount+"]";
		document.getElementsByName("data[passportno1]")[1].name= "data[passportno" +rowCount+"]";
		$("input[name='data[passportno" +rowCount+"]']").rules("add", {required:true});
		$("#my_file_one" +(rowCount)).rules("add", {extension:true,filesize:true});
		         	
		var m = document.getElementsByName("fileupload2");
		m[m.length -1].innerHTML ='Select a file';
		m[m.length -1].id  = "customfileupload_two" +(rowCount);
		document.getElementsByName("data[visa1]")[1].value = '';
		document.getElementsByName("data[visa1]")[1].id  = "my_file_two" +(rowCount);
		document.getElementsByName("data[visa1]")[1].name= "data[visa" +rowCount+"]";
		$("#my_file_two" +(rowCount)).rules("add", {required:true,extension:true,filesize:true});
		
		var n = document.getElementsByName("fileupload3");
		n[n.length -1].innerHTML ='Select a file';
		n[n.length -1].id  = "customfileupload_three" +(rowCount);
		document.getElementsByName("data[from_ticket1]")[1].value = '';
		document.getElementsByName("data[from_ticket1]")[1].id  = "my_file_three" +(rowCount);
		document.getElementsByName("data[from_ticket1]")[1].name= "data[from_ticket" +rowCount+"]";
		$("#my_file_three" +(rowCount)).rules("add", {required:true,extension:true,filesize:true});
		
		var k= document.getElementsByName("fileupload4");
		k[k.length -1].innerHTML ='Select a file';
		k[k.length -1].id  = "customfileupload_four" +(rowCount);
		//document.getElementsByName("data[to_ticket1]")[1].value = '';
		document.getElementsByName("data[to_ticket1]")[1].id  = "my_file_four" +(rowCount);
		document.getElementsByName("data[to_ticket1]")[1].name= "data[to_ticket" +rowCount+"]";
		$("#my_file_four"+(rowCount)).rules("add", {required:true,extension:true,filesize:true});
		
		document.getElementsByName("data[airline1]")[1].name  = "data[airline"+rowCount+"]" ;		
		document.getElementsByName("data[airline"+rowCount+"]")[0].selectedIndex  = "";
		document.getElementsByName("data[airline"+rowCount+"]")[0].id="airline"+rowCount;
		$("#airline" +(rowCount)).rules("add", {required:true});
		$("#airline"+rowCount).rules("add", {digits:true,
		messages: {
		        digits: "Please Select",
		    }
		});
		
		//document.getElementsByName("airline1")[1].name = "airline"+rowCount;
		//document.getElementsByName("airline"+rowCount)[0].value = "";
		//document.getElementsByName("airline"+rowCount)[0].id = "air"+rowCount;
		
		$.ajax({
	      url: "<?php echo $this->webroot; ?>getAirline",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 $('#airline'+rowCount).html(data);
	      	}         
	    });
		
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
		//document.getElementsByTagName("label").style.visibility  = "hidden";	
		  }else{
			alert("Only 10 records can be added at a time");
		  }
}

function get_Amt(str){
var rows = $('#rowcount').val();
var agent = $('#agent').val();
var split = str.split(",");
var name = split[0];
var last_value = name.charAt(name.length - 2);
validatePNR(name);
var value = split[1];

if(value == 3 || value == 8){
$("#my_file_one" +(last_value)).rules("add", {required:true,extension:true,filesize:true});
}else{
$("#my_file_one" +(last_value)).rules("remove");
}

//$('#air'+last_value).val(value);

jQuery.ajax({
type: "POST",
url: '<?php echo $this->webroot; ?>get_airline_amt',
data: 'value='+value+'&agent='+agent,
success: function(response) {
//alert(airline2);
document.getElementsByName('data[amount'+last_value+']')[0].value = response;
}
});
//}
return false;
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

function check_date(str){
var data = get_curr_next_date();
var curr_date = data[0];
var next_date = data[1];
var split = str.split(",");
var name = split[0].replace("d_o_j","f_time");
var last_value = name.charAt(name.length - 2);
var j_date = split[1];

var data = validatePNR(name);
//alert(data);

if(data != 1){
$('#f_hh'+last_value).val(''); $('#f_mm'+last_value).val('');

var s_jDate = j_date.split('-');
var  x= new Date(s_jDate);
x.setHours(0, 0, 0, 0);
var date1 = x.getTime();
var s_date = curr_date.getTime();
var l_date = next_date.getTime();

if(s_date == date1){
$('#f_time'+last_value).css('display','block');
}else if(s_date >= date1){
document.getElementsByName('data[d_o_j'+last_value+']')[0].value = '';
alert('Date of Journey is Invalid')
}else if (date1 >= s_date && date1 <= l_date ) { 
	$.ajax({
	      url: "<?php echo $this->webroot; ?>getUrgAirline",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 $('#airline'+last_value).html(data);
	      	}         
	    });
	$('#f_time'+last_value).css('display','none');
	$('.message1').css('display','none');
}else{
$('#f_time'+last_value).css('display','none');

	$('.message1').css('display','none');
	//$('#submit_form').attr("disabled", false);
	$.ajax({
	      url: "<?php echo $this->webroot; ?>getAirline",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 $('#airline'+last_value).html(data);
	      	}         
	    });
}
}
}

function matchData(value){
var l_val = value.charAt(value.length - 2);
validatePNR(value);
var d_o_j_date = document.getElementsByName('data[d_o_j'+l_val+']')[0].value; //$('#d_o_j'+l_val).val();
var hh = $('#f_hh'+l_val).val();
var mm = $('#f_mm'+l_val).val()
var d_o_j_time = hh+':'+mm;
var curr_date = $('#curr_date').val();
var current = new Date();  
var hh = current.getHours()+':'+current.getMinutes();
var hh_6_date = new Date().addHours(6);
var hh_6 = hh_6_date.getHours()+':'+hh_6_date.getMinutes();

if(curr_date == d_o_j_date ){

if($('#f_hh'+l_val).val() != 'hh'){
	if(d_o_j_time>=hh_6 ){
	$.ajax({
	      url: "<?php echo $this->webroot; ?>getUrgAirline",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 $('#airline'+l_val).html(data);
	      	}         
	    });
	
		$('.message1').css('display','none');
	}else{
		
		document.getElementsByName('data[f_hh'+l_val+']')[0].value = 'hh';
		document.getElementsByName('data[f_mm'+l_val+']')[0].value = '00';
		$('.message1').css('display','block');
		$.ajax({
	      url: "<?php echo $this->webroot; ?>getAirline",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 $('#airline'+l_val).html(data);
	      	}         
	    });
	}
	}
}
}


function validatePNR(str){
var last_value = str.charAt(str.length - 2);
	var rows = $('#rowcount').val();
	var pnr2 = $('#pnr'+last_value).val();
	var d_o_j2 = document.getElementsByName('data[d_o_j'+last_value+']')[0].value;
	var hour = document.getElementsByName('data[f_hh'+last_value+']')[0].selectedIndex ;
	var min = document.getElementsByName('data[f_mm'+last_value+']')[0].selectedIndex ;
	var airline2 = document.getElementById("airline"+last_value).options[document.getElementById("airline"+last_value).selectedIndex].value;
	
		for(var j = 1;j <= rows; j++){
	if(j != last_value){
		var pnr1 = $('#pnr'+j).val();
		if(pnr2.length != 0 && pnr1.length != 0){
		var d_o_j1 = document.getElementsByName('data[d_o_j'+j+']')[0].value
		var hour1 = document.getElementsByName('data[f_hh'+j+']')[0].selectedIndex ;
		var min1 = document.getElementsByName('data[f_mm'+j+']')[0].selectedIndex ;
		var airline1 =  document.getElementById("airline"+j).options[document.getElementById("airline"+j).selectedIndex].value; //document.getElementsByName('data[airline'+j+']')[0].selectedIndex ;
		
				if(pnr1 == pnr2){
					if(d_o_j2 != d_o_j1 &&  d_o_j1.length != 0 &&  d_o_j2.length != 0){
					document.getElementsByName('data[d_o_j'+last_value+']')[0].value = '';
						alert('Journey Date Should be Same for Same PNR');
						var value = document.getElementsByName('data[d_o_j'+last_value+']')[0].value;
						return 1;
					}else{
					
						if(hour != 'hh' && hour1 != 'hh' && hour != 0 && hour1 != 0)
						{
							if(hour != hour1){
								document.getElementsByName('data[f_hh'+last_value+']')[0].selectedIndex = 0;
								document.getElementsByName('data[f_mm'+last_value+']')[0].selectedIndex = 0;
								alert('Journey Time Should be Same for Same PNR');
								
							}
							if(hour == hour1 && min != min1 && min != 'mm' && min != 0 && min1 != 'mm' && min1 != 0){
								document.getElementsByName('data[f_mm'+last_value+']')[0].selectedIndex = 0;
								alert('Journey Time Should be Same for Same PNR');
								}
						}
					}
					
					if(airline1 != airline2 && airline1 != 'select' && airline2 != 'select' && airline1 != 0 && airline2 != 0){
					document.getElementsByName('data[airline'+last_value+']')[0].selectedIndex = 'select';
					document.getElementsByName('data[amount'+last_value+']')[0].value = '';
						alert('Airline Should be Same for Same PNR');
						//var value = document.getElementsByName('data[airline'+last_value+']')[0].selectedIndex;
						//return 1;
					}
				}
			}
		}
	}
}

</script>