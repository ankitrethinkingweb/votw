<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');
?>		


<style>
input.error,select.error
{
border:1px solid red;
}

.selectError
{
border:1px solid red;
}

.user_roles_table td{
padding-left:15px;
}

#visa_type_chzn, #oktb_airline_chzn,#visa_type_chzn .chzn-drop,#oktb_airline_chzn .chzn-drop {
width : 321px!important;
}

</style>

		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head orange">
							<h3> Edit User Roles </h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'save_edit_roles/'.$role_id,'id'=>'save_user_roles','class'=>'form-horizontal','novalidate'=>'novalidate'));  ?>
								<input type = "hidden" value = "<?php if(isset($visa_select)) echo $visa_select; else echo 0 ;?>" name = "visa_select"  id = "visa_select"/>
								<input type = "hidden" value = "<?php if(isset($oktb_select)) echo $oktb_select; else echo 0 ;?>" name = "oktb_select"  id = "oktb_select"/>
							
								<?php if(!isset($visa)) $visa = 0 ; if(!isset($oktb)) $oktb = 0 ; if(!isset($extension)) $extension = 0 ; if(!isset($agent)) $agent = 0 ;?>
								
								<?php echo $this->Form->input("visa" ,array('type'=>'hidden','label' => false,'class'=>"span8",'div' => false,'id'=>"visa",'value'=>$visa))?>
								<?php echo $this->Form->input("oktb" ,array('type'=>'hidden','label' => false,'class'=>"span8",'div' => false,'id'=>"oktb1",'value'=>$oktb))?>
								<?php echo $this->Form->input("extension" ,array('type'=>'hidden','label' => false,'class'=>"span8",'div' => false,'id'=>"extension1",'value'=>$extension))?>
								<?php echo $this->Form->input("agent" ,array('type'=>'hidden','label' => false,'class'=>"span8",'div' => false,'id'=>"agent1",'value'=>$agent))?>
								
								<?php //print_r($data['User']['visa_type']); exit;?>
								<div style = "width:48%; float:left;" >
								
									<div class="control-group">
										<label class="control-label">Enter Name</label>
										<div class="controls">
											<?php echo $this->Form->input("role_name" ,array('label' => false,'class'=>"span8",'div' => false,'id'=>"role_name"))?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Enter Email Id</label>
										<div class="controls">
											<?php echo $this->Form->input("role_email" ,array('label' => false,'div' => false,'class'=>"span8",'id'=>"role_email"))?>
										<?php if(isset($emailMsg)) { ?><div class="error-message"><?php echo $emailMsg; ?></div><?php } ?>
										</div>
									</div>
									<div class="control-group" id = 'visaDisp' <?php if(isset($visa_select) && $visa_select == 0) { ?> style = "display:none;" <?php } ?>>
										<label class="control-label">Select Visa Type</label>
										<div class="controls">
										<?php if(isset($data['User']['visa_type'])){  if(count($data['User']['visa_type']) > 0) $vvalue = $data['User']['visa_type']; else $vvalue = ''; }else $vvalue = '';?>
											<?php echo $this->Form->input("visa_type" ,array('type'=>'select','label' => false,'div' => false,'class'=>"chzn-select span8",'options'=>$visa_type,'id'=>"visa_type",'data-placeholder'=>"Choose a Visa Type...",'multiple' => true,'selected'=>$vvalue))?>
										</div>
									</div>
								</div>
								
								<div style = "width:48%; float:left;" >
									<div class="control-group">
										<label class="control-label">Enter Contact no.</label>
										<div class="controls">
											<?php echo $this->Form->input("role_contact" ,array('label' => false,'div' => false,'class'=>"span8",'id'=>"role_contact"))?>
										</div>
									</div>
									<div class="control-group" id = 'oktbDisp' <?php if(isset($oktb_select) && $oktb_select == 0) { ?> style = "display:none;" <?php } ?>>
										<label class="control-label">Select OKTB Airline</label>
										<div class="controls">	
												<?php if(isset($data['User']['oktb_airline'])){  if(count($data['User']['oktb_airline']) > 0) $ovalue = $data['User']['oktb_airline']; else $ovalue = array('all'=>'All'); }else $ovalue = '';?>
											<?php echo $this->Form->input("oktb_airline" ,array('type'=>'select','label' => false,'div' => false,'class'=>"chzn-select span8",'options'=>$airline,'id'=>"oktb_airline",'data-placeholder'=>"Choose OKTB Airline...",'multiple' => true,'selected'=>$ovalue))?>
										</div>
									</div>
								</div>
								
								<div class = 'clearfix'></div>
								
								<h4><i class = "icon-lock "></i> Access Rights</h4>
								<table class = "user_roles_table"> 
								<tr>
								<th>Agent</th>
								<td><?php echo $this->Form->input("agent_add" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"agent_add",'onchange'=>'VisaSelect()')); ?> Add </td>								
								<td><?php echo $this->Form->input("agent_edit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"agent_edit",'onchange'=>'VisaSelect()')); ?> Edit </td>
								<td><?php echo $this->Form->input("agent_status" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"agent_status",'onchange'=>'VisaSelect()')); ?> Change Status </td>
								<td><?php echo $this->Form->input("agent_delete" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"agent_delete",'onchange'=>'VisaSelect()')); ?> Delete </td>
								<td><?php echo $this->Form->input("agent_change_pswd" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"agent_change_pswd",'onchange'=>'VisaSelect()')); ?> Change Password </td>
								<td><?php echo $this->Form->input("login_as_agent" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"login_as_agent",'onchange'=>'VisaSelect()')); ?> Login as Agent </td>
								</tr>	
								
								<tr>
								<th>Visa Application</th>
								<td><?php echo $this->Form->input("visa_add" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_add",'onchange'=>'VisaSelect()')); ?> Add </td>																
								<td><?php echo $this->Form->input("visa_apply" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_apply",'onchange'=>'VisaSelect()')); ?> Apply </td>
								<td><?php echo $this->Form->input("visa_edit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_edit",'onchange'=>'VisaSelect()')); ?> Edit </td>
								<td><?php echo $this->Form->input("visa_delete" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_delete",'onchange'=>'VisaSelect()')); ?> Delete </td>
								<td><?php echo $this->Form->input("visa_status" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_status",'onchange'=>'VisaSelect()')); ?> Change Status </td>
								<td><?php echo $this->Form->input("visa_export" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_export",'onchange'=>'VisaSelect()')); ?> Export </td>
								</tr>	
								
								<tr>
								<th>OKTB Application</th>
								<td><?php echo $this->Form->input("oktb_add" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_add",'onchange'=>'VisaSelect()')); ?> Add </td>																
								<td><?php echo $this->Form->input("oktb_apply" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_apply",'onchange'=>'VisaSelect()')); ?> Apply </td>
								<td><?php echo $this->Form->input("oktb_edit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_edit",'onchange'=>'VisaSelect()')); ?> Edit </td>
								<td><?php echo $this->Form->input("oktb_delete" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_delete",'onchange'=>'VisaSelect()')); ?> Delete </td>
								<td><?php echo $this->Form->input("oktb_status" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_status",'onchange'=>'VisaSelect()')); ?> Change Status </td>
								<td><?php echo $this->Form->input("oktb_download" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"oktb_download",'onchange'=>'VisaSelect()')); ?> Download Documents </td>
								</tr>			
								
								<!--<tr>
								<th>Group OKTB Application</th>
								<td><?php //echo $this->Form->input("goktb_view" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"goktb_view",'onchange'=>'VisaSelect()')); ?> View </td>
								<td><?php //echo $this->Form->input("goktb_edit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"goktb_edit",'onchange'=>'VisaSelect()')); ?> Edit </td>
								<td><?php //echo $this->Form->input("goktb_delete" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"goktb_delete",'onchange'=>'VisaSelect()')); ?> Delete </td>
								<td><?php //echo $this->Form->input("goktb_status" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"goktb_status",'onchange'=>'VisaSelect()')); ?> Change Status </td>
								<td><?php //echo $this->Form->input("goktb_download" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"goktb_download",'onchange'=>'VisaSelect()')); ?> Download Documents </td>
								</tr>-->		
								
								<tr>
								<th>Extension Application</th>
								<td><?php echo $this->Form->input("ext_add" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_add",'onchange'=>'VisaSelect()')); ?> Add </td>																								
								<td><?php echo $this->Form->input("ext_apply" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_apply",'onchange'=>'VisaSelect()')); ?> Apply </td>																								
								<td><?php echo $this->Form->input("ext_delete" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_delete",'onchange'=>'VisaSelect()')); ?> Delete </td>
								<td><?php echo $this->Form->input("ext_status" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_status",'onchange'=>'VisaSelect()')); ?> Change Status </td>
								<td><?php echo $this->Form->input("ext_edit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_edit",'onchange'=>'VisaSelect()')); ?> Add/Edit extension Date </td>
								</tr>		
								
								<tr>
								<th>Transactions </th>
								<td><?php echo $this->Form->input("trans_amt_bal" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"trans_amt_bal",'onchange'=>'VisaSelect()')); ?> User Amount Balance </td>
								<td><?php echo $this->Form->input("trans_bank" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"trans_bank",'onchange'=>'VisaSelect()')); ?> Bank Transactions </td>
								<td><?php echo $this->Form->input("visa_cost_settings" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"visa_cost_settings",'onchange'=>'VisaSelect()')); ?> Visa Cost Settings </td>
								<td><?php echo $this->Form->input("airline_cost_settings" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"airline_cost_settings",'onchange'=>'VisaSelect()')); ?> Airline Cost Settings </td>
								<td><?php echo $this->Form->input("ext_cost_settings" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"ext_cost_settings",'onchange'=>'VisaSelect()')); ?> Extension Cost Settings </td>
								<td><?php echo $this->Form->input("set_credit_limit" ,array('type'=>'checkbox','label' => false,'div' => false,'id'=>"set_credit_limit",'onchange'=>'VisaSelect()')); ?> Set Credit Limit </td>
								</tr>	
										
								</table>
								
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-save"></i>Save User Roles</button>
										<a href = "<?php echo $this->webroot; ?>all_user_roles" class="btn ">Cancel</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
$(document).ready(function(){
var visa_select = $('#visa_select').val();
var oktb_select = $('#oktb_select').val();



$(".chzn-select").chosen();

	$("#save_user_roles").validate({  
	errorPlacement: function(error,element) {
				    return true;
				  },
				  highlight: function(element) {
				 // alert(element.type);
				 if(element.type == 'select-multiple')
				  {
				  name =element.name;
				  name1= name.replace("data[User][",'');
				  name1 =name1.replace("][]",'');
				 $('#'+name1+'_chzn').addClass("selectError");
				  }else
				  $(element).addClass('error');
    },
    
    unhighlight: function(element) {
				  if(element.type == 'select-multiple')
				  {
				//  alert(element.name);
				  name =element.name;
				  name1= name.replace("data[User][",'');
				  name1 =name1.replace("][]",'');
				  $('#'+name1+'_chzn').removeClass("selectError");
				  }else
				  $(element).removeClass('error');
    },
     ignore: ":hidden:not(select)",
       
			 rules: {
                  		'data[User][role_name]':{
          				  required:true,
          				  },
          				'data[User][role_contact]':{
          				  required:true,
          				  digits:true
          				  },
          				  'data[User][role_email]':{
          				  required:true,
          				  email:true
          				  },
          			
          		},
	});
	
if(oktb_select == 1)   $('#oktb_airline').rules('add','required');
if(visa_select == 1)  $('#visa_type').rules('add','required');

VisaSelect();
});

function VisaSelect(){

if( $('#visa_add').is(":checked") || $('#visa_apply').is(":checked") || $('#visa_edit').is(":checked") || $('#visa_delete').is(":checked") || $('#visa_status').is(":checked") || $('#visa_export').is(":checked") ){   
	 if( $('#visa_add').is(":checked") || $('#visa_apply').is(":checked") || $('#visa_edit').is(":checked") || $('#visa_delete').is(":checked") || $('#visa_status').is(":checked") || $('#visa_export').is(":checked"))
	 $('#visa').val(1); else  $('#visa').val(0);
	 $('#visaDisp').css('display','block'); 
	 $('#visa_type').rules('add','required');
 }else {
 	  $('#visa').val(0);
	  $('#visaDisp').css('display','none');
	  $('#visa_type').rules('remove','required');
	  $("#visa_type").val([]);
  }
if( $('#oktb_add').is(":checked") || $('#oktb_apply').is(":checked") || $('#oktb_edit').is(":checked") || $('#oktb_delete').is(":checked") || $('#oktb_status').is(":checked") || $('#oktb_download').is(":checked") ){   
	  $('#oktb1').val(1);
	  $('#oktbDisp').css('display','block');
	  $('#oktb_airline').rules('add','required');
  }else{ 
 	  $('#oktb1').val(0);
	  $('#oktb_airline').rules('remove','required');
	  $('#oktbDisp').css('display','none');
	  $("#oktb_airline").val([]);
  }

if( $('#ext_add').is(":checked") || $('#ext_edit').is(":checked") || $('#ext_delete').is(":checked") || $('#ext_status').is(":checked") || $('#ext_apply').is(":checked")){ 
		$('#extension1').val(1);
	} else
		$('#extension1').val(0);
		
if( $('#login_as_agent').is(":checked") || $('#agent_add').is(":checked") || $('#agent_change_pswd').is(":checked") || $('#agent_edit').is(":checked") || $('#agent_status').is(":checked") || $('#agent_delete').is(":checked") ){ 
$('#agent1').val(1);
} else
$('#agent1').val(0);


}

</script>