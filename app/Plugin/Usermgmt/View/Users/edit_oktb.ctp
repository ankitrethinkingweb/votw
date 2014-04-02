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
</style>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
				<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Edit OKTB</h3>
						</div>
							 	<div class="widget-container">
							 	<?php //echo '<pre>'; print_r($data); ?> 
<div id = "add_data" class="site">


<form action="<?php echo $this->webroot; ?>save_edit_oktb" id="frm_data" name="frm_data" class="dropzone" novalidate="novalidate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<input type = "hidden" name = "oktb_no" id = "oktb_no" value = "<?php echo $oktb_no; ?>" />
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
</tr>
	<tr> 
		<td><?php echo $this->Form->input("oktb_name" ,array('label' => false,'div' => false,'placeholder'=>'Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("oktb_pnr" ,array('label' => false,'div' => false,'placeholder'=>'PNR','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		<td><?php echo $this->Form->input("oktb_d_o_j" ,array('label' => false,'div' => false,'class'=>'datepicker','placeholder'=>'Date Of Journey','onblur'=>"this.value=this.value.toUpperCase()",'readonly'=>true))?>
		
		<div class="input-append flight_time" id = "f_time1" name = "f_time1">
		<?php $date_hh = array('hh'=>'-hh-','00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fi=10;$fi<=24;$fi++){ $date_hh[$fi] = $fi; }?>
		<?php $date_mm = array('00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09'); for($fj=10;$fj<=60;$fj++){ $date_mm[$fj] = $fj;  } 
		$time = explode(':',$data['oktb_doj_time']); ?>
			<br/>
		<?php echo $this->Form->input("f_hh1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_hh,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)','selected'=>$time[0],'disabled'=>true))?>
		<?php echo $this->Form->input("f_mm1" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style','onchange'=>'matchData(this.name)','selected'=>$time[1],'disabled'=>true ))?>
			</div>		
		</td>
		
		<td><?php echo $this->Form->file("oktb_passport" ,array('label' => false,'div' => false,'id'=>"my_file_one1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_one1" onclick="Getfile(this.id)" title="Select a Passport scanned copy or a photo" name="fileupload1">Select a file</div>
		<br/><?php
		if(strlen($data['oktb_passport']) > 0)
		echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$oktb_no."/".$data['oktb_passport']."' download>Download Passport</a>";
		echo $this->Form->input("oktb_passportno" ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		
		<td><?php echo $this->Form->file("oktb_visa" ,array('label' => false,'div' => false,'id'=>"my_file_two1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_two1" title="Select a Visa scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload2">Select a file</div><br/>
		<?php 
		if(strlen($data['oktb_visa']) > 0)
		echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$oktb_no."/".$data['oktb_visa']."' download>Download Visa</a>";
		 ?></td>
		
		<td><?php echo $this->Form->file("oktb_from_ticket" ,array('label' => false,'div' => false,'id'=>"my_file_three1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_three1" title="Select a From Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload3">Select a file</div><br/>
		<?php 
		if(strlen($data['oktb_from_ticket']) > 0)
		echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$oktb_no."/".$data['oktb_from_ticket']."' download>Download From Ticket</a>";
		?></td>
		
		<td><?php echo $this->Form->file("oktb_to_ticket" ,array('label' => false,'div' => false,'id'=>"my_file_four1",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="customfileupload_four1" title="Select a To Ticket scanned copy or a photo" onclick="Getfile(this.id)" name="fileupload4">Select a file</div><br/>
		<?php 	
		if(strlen($data['oktb_to_ticket']) > 0)							
		echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$oktb_no."/".$data['oktb_to_ticket']."' download>Download To Ticket</a>";
		 ?></td>
		
		<td><?php
		if(isset($airline[$data['oktb_airline_name']])) 
		$airline = $airline[$data['oktb_airline_name']];
		else $airline = '';
		echo $this->Form->input("oktb_airline_name" ,array('label' => false,'div' => false,'value'=>$airline,'readonly'=>true))?><br/>
		
		<td><?php echo $this->Form->input("oktb_airline_amount" ,array('id'=>'airline_amount','label' => false,'div' => false,'placeholder'=>'Amount','readonly'=>true))?></td>
</table><br/>

<input type="submit" value="Save" id ="save" />

</form>
<div style="clear:both;"></div>

</div>
<div style="clear:both;">&nbsp;</div>
</div></div></div></div></div>
<script type="text/javascript">

jQuery(document).ready(function($){
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
			/*	errorPlacement: function(error,element) {
				    return true;
				  },*/
/*invalidHandler: function(event, validator) {
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
  },*/
                    rules: {
                 		 'data[oktb_name]':{
          				  required:true,
          				  },
          				  'data[oktb_pnr]':{
          				  required:true,
          				  alphanumeric:true
          				  },
                        'data[oktb_d_o_j]': {
                            required: true,
                        },
                        'data[oktb_passport]': {
                         extension:true   ,
                         filesize:true                
                        },
                        'data[oktb_passportno]': {
                            required: true,                        
                        },
                        'data[oktb_visa]': {
                         
                            extension:true,        
                            filesize:true             
                        },
                        
                           'data[oktb_from_ticket]': {
                           
                            extension:true  ,
                            filesize:true                  
                        },
                        
                        'data[oktb_to_ticket]' :{ 
                     	
                     	extension:true,
                     	filesize:true
          				  }, 
          				  
          			

},
                    messages: {
                                          				        
                       'data[oktb_pnr]':{
                       required:"PNR is required",
                       alphanumeric:"PNR should be alphanumeric",
                       }
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
	   minDate: +1
	   });

	 // document.getElementById('edit').style.display = 'none';
	//  document.getElementById('payment').style.visibility = 'hidden';
	 // document.getElementById('total_amt').style.display = 'none';
		
 });
 

function Submit_Form(){

if(jQuery("#frm_data").valid())
{
	jQuery("#submit_form").hide();
	jQuery("#edit").show();
	document.getElementById('payment').style.visibility = 'visible';
	jQuery("#total_amt").show();
	jQuery("#add").hide();
	jQuery(".delete").hide();
	
	jQuery("input:text").prop('readonly', true);
	jQuery("input:file").prop('readonly', true);
	jQuery("select").prop('readonly', true);
	
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

function get_Amt(str){

var split = str.split(",");
var name = split[0];
var last_value = name.charAt(name.length - 2);
var value = split[1];
if(value != 'select'){
	jQuery.ajax({
         type: "POST",
         url: '<?php echo $this->webroot; ?>get_airline_amt',
         data: 'value='+value,
         success: function(response) {
			$('#airline_amount').val(response);
         }
    });	
    }else $('#airline_amount').val(0);
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


</script>