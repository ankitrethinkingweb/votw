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
							<h3>Documentation</h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Form->create('User', array('action'=>'add_doc','id'=>'add_doc','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>	
							<label class="control-label">Add / Edit Documentation</label>
								<div class="control-group">
									
									<div class="controls">
										<textarea name="document" id = "document" rows="10" cols="80" style="width: 80%" class="ckeditor"><?php if(isset($doc)) echo $doc; ?></textarea>
			
								
									</div>
								</div>
								<div class="form-actions">		
				<button type="submit" class="btn btn-primary" style="margin-left: 10px;"> Save</button>						 
				</div>			
							<?php echo $this->Form->end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>