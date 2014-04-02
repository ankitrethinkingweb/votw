<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> Add Group </h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Form->create('UserGroup',array('action' => 'addGroup','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>
								<div class="control-group">
									<label class="control-label">Group Name</label>
									<div class="controls">
										<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"span12" ))?>
										<div >for ex. Business User (Must not contain space)</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Alias Group Name</label>
									<div class="controls">
									<?php echo $this->Form->input("alias_name" ,array('label' => false,'div' => false,'class'=>"span12" ))?>
									<div >for ex. Business_User (Must not contain space)</div>
									</div>
								</div>
								
								<?php   if (!isset($this->request->data['UserGroup']['allowRegistration'])) {
							$this->request->data['UserGroup']['allowRegistration']=true;
						}   ?>
							<div class="control-group">
									<label class="control-label">Allow Registration</label>
									<div class="controls">
									<?php echo $this->Form->input("allowRegistration" ,array("type"=>"checkbox",'label' => false))?>
									
									</div>
								</div>
								
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-upload-alt"></i> Add Group</button>
									 <a href="<?php echo $this->webroot;?>/allGroups" class="btn btn-danger">Cancel</a>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
<script>
document.getElementById("UserUserGroupId").focus();
</script>