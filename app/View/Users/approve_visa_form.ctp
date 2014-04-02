	<?php if(isset($data)) $arr_data = implode(',',$data); ?>
	<input type="hidden" name="group" value="<?php if(isset($arr_data)) echo $arr_data; ?>"/>
	<input type="hidden" name="id" id = 'appId' value="<?php if(isset($id)) echo $id; ?>"/>
	<div class="control-group">
		<label class="control-label"><?php echo __('Comments');?></label>
			<div class="controls">
			<?php echo $this->Form->input("comments" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()",'id'=>'comments'))?>
		</div>
	</div>
	
	<button type="submit" class="btn btn-primary">Save</button>			
	<img src =  "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" style = "display:none;" id = "action" />
	