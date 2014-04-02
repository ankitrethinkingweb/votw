		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head green">
							<h3> Change Airline Cost For User :  <?php if(isset($username)) echo strtoupper($username);?></h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'save_airline_cost','class'=>'form-horizontal','novalidate'=>'novalidate')); 
						 echo $this->Form->input("user_id" ,array('type'=>"hidden",'label' => false,'div' => false,'class'=>"span6",'id'=>"airline_cost",'value'=>$user_id ));?>
								<div class="control-group">
									<label class="control-label">Airline Name</label>
								
									<div class="controls">
										<?php echo $this->Form->input("a_name" ,array('options'=>$airline,'label' => false,'div' => false,'class'=>"span6",'id'=>"a_name",'maxlength'=>4 ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Airline Cost Price</label>
									<div class="controls">
										<?php echo $this->Form->input("cost_price" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"cost_price",'maxlength'=>7))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Airline Selling Price</label>
									<div class="controls">
										<?php echo $this->Form->input("sell_price" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"sell_price",'maxlength'=>7))?>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn "><i class="icon-upload-alt"></i> Save </button>
									 <a href="<?php echo $this->webroot;?>Users/agent_airline_cost" class="btn btn-danger">Cancel</a>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
document.getElementById("visa_cost").focus();
</script>