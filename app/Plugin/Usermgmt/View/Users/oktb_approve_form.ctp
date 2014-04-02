	<input type="hidden" name="oktb_id" value="<?php echo $oktb_id;?>"/>
	<div class="control-group">
	
		<label class="control-label"><?php echo __('Write Comment Here');?></label>
			<div class="controls">
			<?php echo $this->Form->textarea("comment" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
		</div>
	</div>
	
	<button type="submit" class="btn btn-primary">Save changes</button>