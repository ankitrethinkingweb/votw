<?php echo $this->Form->input("app_type" ,array('type'=>'hidden','label' => false,'div' => false,'hidden'=>'true','value'=>'extn'))?>
<?php echo $this->Form->input("oktb_no" ,array('type'=>'hidden','label' => false,'div' => false,'hidden'=>'true','value'=>''))?>
<?php echo $this->Form->input("pnr_no" ,array('type'=>'hidden','label' => false,'div' => false,'hidden'=>'true','value'=>''))?>
<?php echo $this->Form->input("doe" ,array('type'=>'hidden','label' => false,'div' => false,'hidden'=>'true','value'=>''))?>
<div style="float:left;width:33%;">
								<div class="control-group">
											<label class="control-label"><?php echo __('Extension No');?></label>
											<div class="controls">
												<?php echo $this->Form->input("app_no" ,array('type'=>'text','label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
	<div class="control-group" >
											<label class="control-label"><?php echo __('Select Visa Type');?></label>
											<div class="controls">
											<?php if(!isset($visa_type)) $visa_type = array('select'=>'Select'); ?>
												<?php echo $this->Form->input("visa_type" ,array('type'=>'select','label' => false,'div' => false,'class'=>"chzn-select span8",'options'=>$visa_type,'id'=>"visa_type",'data-placeholder'=>"Choose a Visa Type...",'multiple' => true))?>
											<span id = "BalAmt"></span>
											</div>
											
									</div> 
									<div class="control-group">
											<label class="control-label"><?php echo __('From Date');?></label>
											<div class="controls">
												<?php echo $this->Form->input("from_date" ,array('label' => false,'readonly'=>'readonly','div' => false,'class'=>"span6",'id'=>"from_date"))?>
											</div>
										</div>
										</div>
										<div style="float:left;width:33%">
										<div class="control-group">
											<label class="control-label"><?php echo __('Passport No.');?></label>
											<div class="controls">
												<?php echo $this->Form->input("passport_no" ,array('type'=>'text','label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
											<div class="control-group" >
											<label class="control-label"><?php echo __('Select Agent Name');?></label>
											<div class="controls">
											<?php if(!isset($select_agent)) $select_agent = array('select'=>'Select'); ?>
												<?php echo $this->Form->input("agent_name" ,array('type'=>'select','label' => false,'div' => false,'class'=>"chzn-select span8",'options'=>$select_agent,'id'=>"agent_name",'data-placeholder'=>"Choose a Agent Name...",'multiple' => true))?>
											<span id = "BalAmt"></span>
											</div>
											
									</div> 
										<div class="control-group" >
											<label class="control-label"><?php echo __('To Date');?></label>
											<div class="controls">
											<?php if(!isset($external_status)) $external_status = array('select'=>'Select'); ?>
												<?php echo $this->Form->input("to_date" ,array('label' => false,'readonly'=>'readonly','div' => false,'class'=>"span6",'id'=>"to_date"))?>
											<span id = "BalAmt"></span>
											</div>
											
									</div> 
										
								</div>
								<div style="float:left;width:33%">
										<div class="control-group">
											<label class="control-label"><?php echo __('Name of Passenger');?></label>
											<div class="controls">
												<?php echo $this->Form->input("psg_name" ,array('type'=>'text','label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
											<div class="control-group" >
											<label class="control-label"><?php echo __('Select External Status');?></label>
											<div class="controls">
											<?php if(!isset($external_status)) $external_status = array('select'=>'Select'); ?>
												<?php echo $this->Form->input("external_status" ,array('type'=>'select','label' => false,'div' => false,'class'=>"chzn-select span8",'options'=>$external_status,'id'=>"external_status",'data-placeholder'=>"Choose a External Status...",'multiple' => true))?>
											<span id = "BalAmt"></span>
											</div>
											
									</div> 
									
										</div>



<script>
										$('#from_date,#to_date,#doe').datepicker({
	       showWeek: true, 
	       showButtonPanel: true, 
	       changeMonth: true, 
	       changeYear: true,
	       dateFormat: 'yy-mm-dd', 
	  	   yearRange:'1947:'+ (new Date().getFullYear() + 2),
	  	   maxDate : 0,
});
$(document).ready(function(){
$(".chzn-select").chosen();
});
</script>