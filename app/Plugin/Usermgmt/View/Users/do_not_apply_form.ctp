	<input type="hidden" name="check_id" value="<?php if(isset($check_id))echo $check_id;?>"/>
	<div class="control-group">
	
		<label class="control-label"><?php echo __('Select Date of Exit');?></label>
			<div class="controls">
			<?php echo $this->Form->input("exit_date" ,array('label' => false,'div' => false,'id'=>'exit_date'))?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo __('Reason');?></label>
			<div class="controls">
			<?php echo $this->Form->input("reason" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()",'id'=>'reason'))?>
		</div>
	</div>
	
	<button type="submit" class="btn btn-primary">Save</button>			
	<img src =  "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" style = "display:none;" id = "action" />
	
	
<script type = "text/javascript">
$(document).ready(function(){
	$('#exit_date').datepicker({
		   	   showWeek: true, 
		       showButtonPanel: true, 
		       changeMonth: true, 
		       changeYear: true,
		       dateFormat: 'yy-mm-dd', 
		  	   yearRange:'1947:'+ (new Date().getFullYear() + 2),
		  	   maxDate:0,
	});
}); 
</script>	