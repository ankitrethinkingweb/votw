		
		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> Change Password </h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array(array('action' => 'changePassword'),'class'=>'form-horizontal','novalidate'=>'novalidate')); ?>
								<div class="control-group">
									<label class="control-label">Old Password</label>
									<div class="controls">
										<?php echo $this->Form->input("old_password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"span12",'id'=>'old_password' ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">New Password</label>
									<div class="controls">
										<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"span12" ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Confirm Password</label>
									<div class="controls">
									<?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"span12" ))?>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-upload-alt"></i> Change Password</button>
									 <a href="<?php echo $this->webroot;?>/allUsers" class="btn btn-danger">Cancel</a>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
document.getElementById("old_password").focus();
</script>