<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<style>
#my_file {
    display: none;
}
/*input.error,select.error
{
border:1px solid red;
}
.error
{
border:none!important;
}*/
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
</style>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-container">
						<div class = 'message' style = "display:none;"><span></span> </div>
						
<?php echo $this->Form->create('User', array('action' => 'quick_visa_app','id'=>'visa_quick_app','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); ?>					

<input type = "hidden" value = "<?php if(isset($groupId)) echo $groupId; ?>" name = 'groupId' id = "groupId"/>
<input type = "hidden" value = "<?php if(isset($data['hide_count'])) echo $data['hide_count']; ?>" name = 'hid_count1' id = "hid_count1"/>
<input type = "hidden" value = "<?php if(isset($data['User']['adult'])) echo $data['User']['adult']; ?>" name = 'adult' id = "adult"/>
<input type = "hidden" value = "<?php if(isset($data['User']['children'])) echo $data['User']['children']; ?>" name = 'children' id = "children"/>
<input type = "hidden" value = "<?php if(isset($data['User']['infants'])) echo $data['User']['infants']; ?>" name = 'infants' id = "infants"/>
			
			
<?php echo $this->Session->flash();  ?>						
<table class = 'table table-striped table-bordered dataTable' id="form-table">

<tr class="form-field_header ">
<th scope="row"><label for="name"><?php echo 'Given Name';?></label></th>
<th scope="row"><label for="name"><?php echo 'Surname';?></label></th>
<th scope="row"><label for="passport"><?php echo 'Passport No';?></label></th>
<th scope="row"><label for="d_o_e"><?php echo 'Passport Date of Expiry';?></label></th>
<th scope="row"><label for="d_o_b"><?php echo 'Date of Birth';?></label></th>
<th scope="row"><label for="d_o_b"><?php echo 'Profession';?></label></th>
<th scope="row"><label for="pfp"><?php echo 'Upload'; ?></label></th>
</tr>
			<?php if(isset($data['hide_count']))
								 $j = $data['hide_count']; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1;
								 for($i=1;$i<=$j;$i++){
								 $a = $data['User']['adult']; $b = $data['User']['adult']+$data['User']['children'];  
								
								 if($a != 0 && $i <= $a){ $heading = 'Adult - '.$ak; $id = '-A'.$ak; $ak++;}
								 else if($b != 0 && $i <= $b){$heading = 'Children - '.$bk;	$id = '-C'.$bk;	$bk++;}
								 else{ $heading = 'Infants - '.$ck; $id = '-I'.$ck;	$ck++;	}?>	
								 
		<tr> 
			<td><?php echo $this->Form->input("given_name".$id ,array('label' => false,'div' => false,'placeholder'=>'Given Name','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
			<td><?php echo $this->Form->input("surname".$id ,array('label' => false,'div' => false,'placeholder'=>'Surname','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
			<td><?php echo $this->Form->input("passport_no".$id ,array('label' => false,'div' => false,'placeholder'=>'Passport No','onblur'=>"this.value=this.value.toUpperCase()"))?></td>
		
		<td>
			<?php $e_dd['dd'] = 'dd'; for($ei=1;$ei<=31;$ei++){ $e_dd[$ei] = $ei; }?>
			<?php $e_mm['mm'] = 'mm'; for($ej=1;$ej<=12;$ej++){ $e_mm[$ej] = $ej; }?>
			<?php $e_yy['yy'] = 'yy'; $year = date('Y'); $curr_Year = date('Y')+ 20 ; for($ek=$year;$ek<=$curr_Year;$ek++){ $e_yy[$ek] = $ek; }?>
			<?php echo $this->Form->input("doe_dd".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_dd,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?></br>
			<?php echo $this->Form->input("doe_mm".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_mm,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?></br>
			<?php echo $this->Form->input("doe_yy".$id,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_yy,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?>
		</td>
																						
		<td>
			<?php $date_dd['dd'] = 'dd'; for($fi=1;$fi<=31;$fi++){ $date_dd[$fi] = $fi; }?>
			<?php $date_mm['mm'] = 'mm'; for($fj=1;$fj<=12;$fj++){ $date_mm[$fj] = $fj; }?>
			<?php $date_yy['yy'] = 'yy'; $year = 1900; $curr_Year = date('Y'); for($fk=$year;$fk<=$curr_Year;$fk++){ $date_yy[$fk] = $fk; }?>
			<?php echo $this->Form->input("dob_dd".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_dd,'class'=>'chzn-select date_style' ))?></br>
			<?php echo $this->Form->input("dob_mm".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style' ))?></br>
			<?php echo $this->Form->input("dob_yy".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_yy,'class'=>'chzn-select date_style' ))?>	
		</td>										
			
		<td>
		<?php echo $this->Form->input("emp_type".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$empType,'class'=>'chzn-select','onchange'=>'empChange(this.value,"'.$id.'")' ))?>													
		</br></br><?php echo $this->Form->input("emp_other".$id ,array('label' => false,'div' => false,'placeholder'=>'Employment Type','onblur'=>"this.value=this.value.toUpperCase()",'style'=>"display:none;"))?>
		<td>

			<?php echo $this->Form->file("photograph".$id ,array('label' => false,'div' => false,'class'=>"btn btn-primary",'id'=>"photograph".$id,'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
			<div id="Aphotograph<?php echo $id; ?>" onclick="Getfile(this.id)" name="fileupload3">Upload Photograph<br/>(Filesize:30Kb)</div>
<br/>

		<?php echo $this->Form->file("pfp".$id ,array('label' => false,'div' => false,'id'=>"pfp".$id,'class'=>"btn btn-primary",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="Apfp<?php echo $id; ?>" onclick="Getfile(this.id)" title="Select Passport First Page scanned copy or a photo" name="fileupload1">Upload Passport First Page<br/>(Filesize:150Kb)</div><br/>
		
		<?php echo $this->Form->file("plp".$id ,array('label' => false,'div' => false,'id'=>"plp".$id,'class'=>"btn btn-primary",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<div id="Aplp<?php echo $id; ?>" onclick="Getfile(this.id)" name="fileupload2">Upload_Passport Last Page<br/>(Filesize:150Kb)</div><br/>
		
		<?php //echo $this->Form->file("ticket".$id ,array('label' => false,'div' => false,'id'=>"ticket".$id,'class'=>"btn btn-primary",'onchange'=>"showName(this.id)", 'style'=>"visibility:hidden;position: absolute;width:40px;"))?>
		<!--<div id="Aticket<?php echo $id; ?>" onclick="Getfile(this.id)" name="fileupload3">Upload Tickets</div>--></td>
		
		
	</tr>	
		
	<?php } ?>
</table><br/>
<legend>Additional documents </legend>
	<div style = "float:left;width:30%">
		<div class="control-group">
			<label class="control-label"><?php echo __('Additional Document  1');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
				<div class="controls">
					<?php echo $this->Form->file("add_doc1",array('label' => false,'div' => false))?>
				</div>
			</div>
			</div>
			<div style = "float:left;width:30%">
			<div class="control-group">
			<label class="control-label"><?php echo __('Additional Document  2');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
					<div class="controls">
						<?php echo $this->Form->file("add_doc2",array('label' => false,'div' => false))?>
					</div>
			</div>
			</div>
			<div style = "float:left;width:30%">
			<div class="control-group">
			<label class="control-label"><?php echo __('Additional Document  3');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
					<div class="controls">
						<?php echo $this->Form->file("add_doc3",array('label' => false,'div' => false))?>
					</div>
			</div>
			</div> 
<br/><br/>
<div style="clear:both;"></div>		
 <p><input type = "checkbox" name = 'agree' value = "agree" />
&nbsp;&nbsp;Accept the <a href="javascript:void(0);" onclick = "get_terms()" class='alert-box'>terms and conditions</a> and privacy policy</p>
					 
<div class="form-actions">
		<button type="submit" class="btn btn-primary" id = "submit">Apply For Visa</button>	
</div>	
<?php echo $this->Form->end(); ?>
</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">

function empChange(empVal,id){

	if(empVal == 'other') $('#UserEmpOther'+id).css('display','block'); else $('#UserEmpOther'+id).css('display','none');
}

function monthDiff(id){

if($('#UserTentDd').val() != 'dd' && $('#UserTentMm').val() != 'mm' && $('#UserTentYy').val() != 'yy' && $('#UserDoeDd'+id).val() != 'dd' && $('#UserDoeMm'+id).val() != 'mm' && $('#UserDoeYy'+id).val() != 'yy' ){


d1 = new Date();
 d2 = new Date($('#UserDoeYy'+id).val(), $('#UserDoeMm'+id).val(), $('#UserDoeDd'+id).val());

        var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth()+1  ;
    months += d2.getMonth();
    var data = months;

    if(data >= 0 && data <= 6){
    if(data == 0) 
    	alert('Your Passport will expire in this months'); 
    else 
        alert('Your Passport will expire in  '+data+' months');
return true;
    }else if(data < 0){
    $('#UserDoeYy'+id).val('yy');
    $('#UserDoeMm'+id).val('mm');
     $('#UserDoeDd'+id).val('dd');
     alert('Your Passport is Expired'); return false; }
else{ return true; }   
}
}

$(document).ready(function($){
$('.responsive-leftbar').css('display','block');
 $('#submit').html("Continue");  	


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
 //param = "1048576";
 // element = element to validate (<input>)
 // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  

jQuery("#visa_quick_app").validate({  
			/*	errorPlacement: function(error,element) {
				    return true;
				  },*/
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
                     'agree':{
							required:true,
							},
					 'data[User][given_name-A1]': {
                            required: true,
                        },
                        'data[User][surname-A1]': {
                            required: true,                        
                        },
						 'data[User][dob_dd-A1]':{
          				  digits:true,
          				  },
          				   'data[User][dob_mm-A1]':{
          				  digits:true,
          				  },
          				   'data[User][dob_yy-A1]':{
          				  digits:true,
          				  },
          				  'data[User][passport_no-A1]':{
          				  required:true,
          				  alphanumeric:true,
          				  },
						     'data[User][doe_dd-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				'data[User][emp_type-A1]' :{ 
                     		required :true,
                     	},
                     	'data[User][emp_other-A1]' :{ 
                     		required :true,
                     	},
          				   'data[User][doe_mm-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				   'data[User][doe_yy-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
						 
							
							'data[User][photograph-A1]': {
                         required: true,
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "30720"  
	                        }, 
	                        
	                        'data[User][pfp-A1]': {
                         required: true,
                       	 extension: "pdf|png|jpe?g|gif", 
                       	 filesize: "153600"  
	                        }, 
	                        
	                        'data[User][plp-A1]': {
                         required: true,
                       	 extension: "pdf|png|jpe?g|gif", 
                       	 filesize: "153600"  
	                        }, 
							 'data[User][ticket-A1]': {
                        
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
							  'data[User][add_doc1]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },
	                        'data[User][add_doc2]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },
	                        'data[User][add_doc3]': {
                         	extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },

},
                    messages: {
						'agree':{
						required : "Please Accept the Terms and Conditions",
						}
                    }
                });
              //  $("#UserAgree").rules("add", "required");

				
 var hid_count1 = $('#hid_count1').val();
         
         	if(hid_count1 > 1){
         	var ak = 1;
         	var bk = 1;
         	var ck = 1;
	         	for(var i=1;i<=hid_count1;i++ ){  
	         	var a = $('#adult').val();
	         	var b = $('#children').val();
	         	var c = $('#infants').val(); 	
	         	var ab = parseInt(a) + parseInt(b);
	         	
				if(a != 0 && i <= a){ id = '-A'+ak; ak++;}
				else if(ab != 0 && i <= ab){ id = '-C'+bk; bk++;}
				else{ id = '-I'+ck;	ck++;	}
				
		         	$("#UserGivenName"+id).rules("add", "required");
					$("#UserSurname"+id).rules("add", "required");
					$("#UserEmpType"+id).rules("add", "required");
					$("#UserEmpOther"+id).rules("add", "required");
					$("#UserDobDd"+id).rules("add", "digits");       						
					$("#UserDobMm"+id).rules("add", "digits");					
					$("#UserDobYy"+id).rules("add", "digits");	         	
					$("#UserPassportNo"+id).rules("add", "required");	
					$("#UserPassportNo"+id).rules("add", "alphanumeric");	         	
					$("#UserDoeDd"+id).rules("add", "digits");	         	
					$("#UserDoeMm"+id).rules("add", "digits");
					$("#UserDoeYy"+id).rules("add", "digits");	
					
					/*$("#photograph"+id).rules("add", {required:true,extension:true,filesize:true});*/
					$("#photograph"+id).rules("add", {
		         	required:true,
		         	extension:"png|jpe?g|gif",
		         	filesize:"30720"
		         	});    
		         	
		         	$("#pfp"+id).rules("add", {
					required:true,
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"153600"
		         	});
		         	
					$("#plp"+id).rules("add", {
					required:true,
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"153600"
		         	}); 
		         	
		         	/*$("#ticket"+id).rules("add", {
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});	*/
		         
	         	}
         	}       
         	
 });



 

 /*function addRow(){
 
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
                           $("input[name='"+newcell.childNodes[0].name +"']").rules("add", {required:true});
                   	}
							
                            break;
					
		case "button":
		newcell.childNodes[0].name = newcell.childNodes[0].name.replace(1,rowCount);
                 break;	
                          						
                }
			}	
			jQuery(".edit label").hide();
			
		document.getElementsByName("data[airline1]")[1].name  = "data[airline"+rowCount+"]" ;
		//document.getElementsByName("fileupload1")[1].id  = "customfileupload" +(rowCount);
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
				
		document.getElementsByName("data[airline"+rowCount+"]")[0].selectedIndex  = "";
		document.getElementsByName("data[airline"+rowCount+"]")[0].id="airline"+rowCount;
		$("#airline"+rowCount).rules("add", {required:true,digits:true});
		
		jQuery('.datepicker').removeClass('hasDatepicker').removeAttr('id').datepicker({ 
	   showWeek: true, 
	   showButtonPanel: true, 
       changeMonth: true, 
       changeYear: true,
	   dateFormat: 'yy-mm-dd', 
       yearRange:'1947:' + (new Date().getFullYear() + 2),
	   minDate: +1
	   });
		//document.getElementsByTagName("label").style.visibility  = "hidden";	
		  }else{
			alert("Only 10 records can be added at a time");
		  }
}*/



 
function Getfile(id)
{
var newid = id.substring(1);
document.getElementById(newid).click();
}

function showName(newid)
{
var path = document.getElementById(newid).value;
p=path.split('\\');
var val1 = p[p.length - 1];
var id = 'A'+newid;
if (val1.length>0)
    jQuery('#'+id).html(val1);
    else
    jQuery('#'+id).html("Select a file");
}
function get_terms(){
	$.ajax({
	      url: "<?php echo $this->webroot; ?>get_terms",
	      dateType:'html',
	      type:'post',
	      success: function(data){	    
	      	 bootbox.alert(data, function () {  
   			 });
	      }         
	    })
   
}
</script>
