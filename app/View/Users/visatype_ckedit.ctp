<?php
echo $this->Html->script('jquery.validate');
echo $this->Html->script('ckeditor/ckeditor');
	echo $this->fetch('script');
?>
<script type = "text/javascript">

 $(".form-horizontal").validate({
                 rules: {
                 'document':{
                 required: true,
                 },
                 },
                   messages: {
                    required: "Please add Documentation data",
                   }
                 });

</script>
<div class="container-fluid">

<div class="row-fluid">
				<div class="span12">
				
				
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3>Eligibility Criteria <?php if(isset($v_name)) echo '( '. $v_name .' )'; ?></h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Form->create('User', array('action'=>'update_visatype','id'=>'update_visatype','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>	
							<label class="control-label">Add / Edit Eligibility Criteria</label>
								<div class="control-group">
									
									<div class="controls">
										<input type="hidden" name="visa_type_id" value="<?php if(isset($v_id)) echo $v_id?>" />
										<textarea name="document" id = "document" rows="10" cols="80" style="width: 80%" class="ckeditor"><?php if(isset($doc)) echo $doc; ?></textarea>
			
								
									</div>
								</div>
								<div class="form-actions">		
				<button type="submit" class="btn btn-primary" style="margin-left: 10px;"> Save</button>	
				<a href = "<?php echo $this->webroot; ?>visa_master" class="btn btn-primary" style="margin-left: 10px;"> Cancel</a>						 
				</div>			
							<?php echo $this->Form->end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>		
<style>
.space{
margin:5px;
}
</style>



