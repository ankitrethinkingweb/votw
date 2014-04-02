		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> Change User Password : <?php if(isset($name)) echo strtoupper($name);?></h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Form->create('User',array('class'=>'form-horizontal','novalidate'=>'novalidate')); ?>
								<div class="control-group">
									<label class="control-label">Password</label>
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
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
document.getElementById("UserPassword").focus();
</script>