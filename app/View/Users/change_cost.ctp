		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> Change Visa Cost For User :  <?php if(isset($username)) echo strtoupper($username);?></h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'save_cost','class'=>'form-horizontal','novalidate'=>'novalidate')); 
						 echo $this->Form->input("user_id" ,array('type'=>"hidden",'label' => false,'div' => false,'class'=>"span6",'id'=>"visa_cost",'value'=>$user_id ));?>
								<div class="control-group">
									<label class="control-label">Visa Type</label>
								
									<div class="controls">
										<?php echo $this->Form->input("visa_type" ,array('options'=>$visa_type,'label' => false,'div' => false,'class'=>"span6",'id'=>"visa_type",'maxlength'=>4 ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Visa Cost Price</label>
									<div class="controls">
										<?php echo $this->Form->input("visa_cost" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"visa_cost",'maxlength'=>7))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Visa Selling Price</label>
									<div class="controls">
										<?php echo $this->Form->input("visa_scost" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"visa_scost",'maxlength'=>7))?>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-upload-alt"></i> Change Visa Cost</button>
									 <a href="<?php echo $this->webroot;?>Users/visa_cost_settings" class="btn btn-danger">Cancel</a>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
document.getElementById("visa_cost").focus();
</script>