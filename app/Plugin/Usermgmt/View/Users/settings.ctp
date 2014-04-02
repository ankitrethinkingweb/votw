
<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<div class="container-fluid" style='margin-top:34px;'>
<div class="row-fluid">
				<div class="span12 code-example">
					<div class="content-widgets light-gray">
						<div class="widget-head green">
							<h3>Admin Settings</h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User', array('action' => 'settings','class'=>"form-horizontal",'novalidate'=>'novalidate')); ?>
									<div class="control-group">
										<label class="control-label">Admin Email Settings</label>
										<div class="controls">
											<?php echo $this->Form->input("admin_email" ,array('value'=>$admin_email,'label' => false,'placeholder'=>'Enter Email Address','div' => false))?>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Visa From Email</label>
										<div class="controls">
											<?php echo $this->Form->input("visa_from" ,array('value'=>$visa_from,'label' => false,'placeholder'=>'Enter Visa From Email Address','div' => false))?>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">OKTB From Email</label>
										<div class="controls">
											<?php echo $this->Form->input("oktb_from" ,array('value'=>$oktb_from,'label' => false,'placeholder'=>'Enter OKTB From Email Address','div' => false))?>
										</div>
									</div>
										 <label class="checkbox"><?php echo $this->Form->input("admin_approve" ,array('checked'=>$admin_approve,'type'=>'checkbox','label' => false,'div' => false))?>
										  Approve Agent Registrations</label>
															<div class="form-actions">
											<button type="submit" class="btn btn-primary">Save</button>	
											<?php echo $this->Form->end(); ?>
									</div>
											
							</form>
                            
						</div>
					</div>
				</div>
			</div>
</div>



<script>

$(document).ready(function(){

$(".form-horizontal").validate({  
					 rules: {
	                 		 'data[User][admin_email]':{
	          				 	 required:true,
	          				 	 email:true
	          				  },
	          				  'data[User][visa_from]':{
	          				  	required:true,
	          				  	email:true
	          				  },
	          				  'data[User][oktb_from]':{
	          				  	required:true,
	          				  	email:true
	          				  },
          				  },
          				  messages:{
          				 	 'data[User][admin_email]':{
	          				 	 required:'Please Enter Admin Email',
	          				 	 email:'Please Enter valid email'
	          				  },
	          				   'data[User][oktb_from]':{
	          				 	 required:'Please Enter OKTB From Email',
	          				 	 email:'Please Enter valid email'
	          				  },
	          				   'data[User][visa_from]':{
	          				 	 required:'Please Enter Visa From Email',
	          				 	 email:'Please Enter valid email'
	          				  },
	          				  
          				  }
          				  
	});
	});
</script>