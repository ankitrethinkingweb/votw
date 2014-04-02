	<input type="hidden" name="group_id" value="<?php echo $group_id;?>"/>
	<div class="control-group">
	
		<label class="control-label"><?php echo __('Write Comment Here');?></label>
			<div class="controls">
			<?php echo $this->Form->textarea("comment" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
		</div>
	</div>
	
	<button type="submit" class="btn btn-primary">Save changes</button>