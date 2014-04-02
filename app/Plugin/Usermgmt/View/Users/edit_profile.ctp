
<?php 
echo $this->Html->script('jquery.validate');
		echo $this->fetch('script');	
?>
<div class="container-fluid">
			<div class="row-fluid ">
				<div class="span12">
					<div class="primary-head">
						<h3 class="page-header">Edit Profile</h3>
					</div>
				</div>
			</div>
			
				<div class="row-fluid">
				<div class="span12">
					
						<div class="widget-head clearfix orange">
							<div id="top_tabby" class="pull-right">
							</div>
						</div>
						<div class="widget-container gray ">
							<div class="form-container">
							<?php echo $this->Session->flash(); ?>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php echo $this->Form->create('User', array('action'=>'save_profile','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>					
								
									<fieldset title="Step 1">
										<legend>Basic Details</legend>
										<div style = "float:left;width:45%">	
								
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Business Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("bus_name" ,array('label' => false,'div' => false))?>
											</div>
										</div>
											
																
									</div>
									<div style = "float:left;width:45%">	
																
										<div class="control-group">
											<label class="control-label"><?php echo __('Contact No');?></label>
											<div class="controls">
												<?php echo $this->Form->input("contact_no" ,array('label' => false,'div' => false,'maxlength'=>10))?>
											</div>
										</div>
			
										
									
										<div class="control-group">
											<label class="control-label"><?php echo __('Address');?></label>
											<div class="controls">
												<?php echo $this->Form->input("address" ,array('label' => false,'div' => false))?>
											</div>
										</div>
											
										</div>
									<div style="clear:both"></div>		
									</fieldset>
									
									
									<fieldset title="Step 2">
										<legend>Other Details</legend>
									<div style = "float:left;width:45%">	
										<div class="control-group">
											<label class="control-label"><?php echo __('City');?></label>
											<div class="controls">
												<?php echo $this->Form->input("city" ,array("type"=>"text",'label' => false,'div' => false))?>
											</div>
										</div>
									
										<div class="control-group">
											<label class="control-label"><?php echo __('State');?></label>
											<div class="controls">
												<?php echo $this->Form->input("state" ,array("type"=>"text",'label' => false,'div' => false))?>
											</div>
										</div>
								
										<div class="control-group">
											<?php $country_option = $country; ?>
											<label class="control-label"><?php echo __('Country');?></label>
											<div class="controls">
												<?php echo $this->Form->input("country" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option ))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Pin');?></label>
											<div class="controls">
												<?php echo $this->Form->input("pin" ,array("type"=>"text",'label' => false,'div' => false,'maxlength'=>6))?>
											</div>
										</div>
						
									</div>	
									<div style = "float:left;width:45%">
									<div class="control-group">
											<label class="control-label"><?php echo __('Contact Person Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("con_name" ,array('label' => false,'div' => false))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Contact Person Email Id');?></label>
											<div class="controls">
												<?php echo $this->Form->input("con_email" ,array('label' => false,'div' => false))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Mobile No.');?></label>
											<div class="controls">
												<?php echo $this->Form->input("mob_no" ,array('label' => false,'div' => false,'maxlength'=>10))?>
											</div>
										</div>			

										
									</div>	
									</fieldset>
									<div style="clear:both"></div>
									<div class="form-actions">
									<button type="submit" class="btn btn-primary"> Save</button>
									<a href="<?php $this->webroot; ?>myprofile" class="btn btn-extend" style="margin-left:10px;">Cancel</a>
									</div>
									
									
									
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	
	
<script type="text/javascript">

            $(function () {            
            $(".form-horizontal").validate({
                 rules: {
                     	'data[User][agent_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
                     	'data[User][bus_name]':"required",
                     
                       'data[User][username]': {
                            required: true,
                            minlength: 2
                        },
                       
                        'data[User][email]': {
                            required: true,
                            email: true
                        },
                        'data[User][contact_no]': {
                            required: true,
                             number: true
                        },
                      	'data[User][address]': {
                            required: true,
                            minlength: 2
                        },
                      	'data[User][city]': {
                            required: true,
                            minlength: 2
                        },
                        'data[User][state]': {
                            required: true,
                            minlength: 2
                        }, 
                        'data[User][country]': {
                            required: true,
                            digits: true,                            
                        }, 
                         'data[User][pin]': {
                            required: true,
                             number: true
                        }, 
                         'data[User][con_name]': {
                            required: true,
                              minlength: 2
                        }, 
                         'data[User][con_email]': {
                            required: true,
                              email: true
                        }, 
                         'data[User][mob_no]': {
                            required: true,
                             number: true
                        }, 
                    },
                    messages: {
                    'data[User][agent_type]':{
                    required : "Please Select Agent-type",
                    digits : "Please Select Agent-type",
                    },
                    'data[User][bus_name]':"Please Enter Business Name",                   
                        'data[User][username]': {
                            required: "Please enter a username",
                            minlength: "Your username must consist of at least 2 characters"
                        },
                        'data[User][email_id]': "Please enter a valid email address",
                        'data[User][contact_no]':"Please enter a valid contact no",
                        'data[User][city]':"Please enter a city",
                        'data[User][state]':"Please enter a state",
                        'data[User][country]': {
                        required : "Please Select a Country",
                        digits :  "Please Select a Country",
                        },
                        'data[User][pin]': "Please enter the pincode",
                        'data[User][con_name]':"Please enter the ContactPerson name",
                        'data[User][con_email]':"Please enter a valid email address ",
                        'data[User][mob_no]':"Please enter a valid mobile no."
                    }
                });

            });
            
           
        </script>	


