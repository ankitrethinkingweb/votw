<div class="container-fluid">
			
				<div class="row-fluid">
				<div class="span12">					
						<div class="widget-container gray ">
							<div class="form-container">
							<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="icon-exclamation-sign"></i><strong>In case of multiple Visa Applications, upload zip file</strong>

			</div>
							<?php echo $this->Session->flash(); ?>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php 
							echo $this->Form->create('User', array('action'=>'upload_ext_visa1/'.$extId,'id'=>'extUpload','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); ?>					
										<legend>Upload Extension Visa</legend>
										<?php if(isset($err)){?><div class = 'alert alert-error'><?php echo $err;?> </div>
										<?php } if(isset($msg)){ ?><div class = 'alert alert-success'><?php echo $msg;?> </div><?php } ?>
								<div class="control-group">
									<label class="control-label"><?php echo __('Upload Visa');?></label>
									<div class="controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="input-append" style="width: 100px;">
												<div class="uneditable-input span2">
													<i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
												</div>
												<span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
												<?php echo $this->Form->file("upload" ,array('label' => false,'div' => false,'id'=>"upload"))?>
												</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>										
											</div>	
												
										</div>
									</div>
								</div>						
									<div style="clear:both"></div>

				<div class="form-actions">		
				<button type="submit" class="btn btn-primary" style="margin-left: 10px;"> Save Visa</button>
									<a href="<?php echo $this->webroot; ?>extension_list" class="btn btn-extend" style="margin-left: 10px;">Cancel</a>									
						 
				</div>
		<?php echo $this->Form->end(); ?>
								  
								</div>	
										</div>
									</div>
								</div>			
								</div>
								
								
								
<script type = 'text/javascript'>
			
	</script>


			