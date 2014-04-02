	<input type="hidden" name="ext_id" id = "ext_id" value="<?php if(isset($extId)) echo $extId;?>"/>
	<div class="control-group">
	
		<label class="control-label"><?php echo __('Select Last Date');?></label>
			<div class="controls">
			<?php echo $this->Form->input("last_date" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()",'id'=>'last_date','readonly'=>true))?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo __('Comments');?></label>
			<div class="controls">
			<?php echo $this->Form->input("comments" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()",'id'=>'comments'))?>
		</div>
	</div>
	
							<div class="control-group">
									<label class="control-label"><?php echo __('Upload Extension Visa');?></label>
									<div class="controls">
										<?php echo $this->Form->file("upload" ,array('label' => false,'div' => false,'id'=>"upload"))?>
									</div>
								</div>	
	
	<button type="submit" class="btn btn-primary">Save</button>			
	<img src =  "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" style = "display:none;" id = "action" />
	
	
<script type = "text/javascript">
$(document).ready(function(){
	$('#last_date').datepicker({
		   	   showWeek: true, 
		       showButtonPanel: true, 
		       changeMonth: true, 
		       changeYear: true,
		       dateFormat: 'yy-mm-dd', 
		  	   yearRange:'1947:'+ (new Date().getFullYear() + 2),
		  	   minDate: 0,
	});
}); 
</script>	