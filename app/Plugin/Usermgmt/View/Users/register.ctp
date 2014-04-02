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
<?php 
echo $this->Html->script('jquery.validate');
		echo $this->fetch('script');	
?>
<div class="container-fluid">
			<div class="row-fluid ">
				<div class="span12">
					<div class="primary-head">
						<h3 class="page-header">Sign Up</h3>
					</div>
				</div>
			</div>

			<p id="UserLogin" >
			<a id="UserLogin" href="<?php $this->webroot; ?>login" class="btn btn-extend">Go To Login Page</a>
			</p>
			
				<div class="row-fluid">
				<div class="span12">
					<div class="stepy-widget">
						<div class="widget-head clearfix orange">
							<div id="top_tabby" class="pull-right">Sign Up
							</div>
						</div>
						<div class="widget-container gray ">
							<div class="form-container">
							<?php echo $this->Session->flash(); ?>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php echo $this->Form->create('User', array('action' => 'register','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>					
								
									<fieldset title="Step 1">
										<legend>Login Details</legend>

										<div class="control-group">
											<label class="control-label"><?php echo __('Business Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("bus_name" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									
										<div class="control-group">
											<label class="control-label"><?php echo __('Username');?></label>
											<div class="controls">
												<?php echo $this->Form->input("username" ,array('label' => false,'div' => false))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Password');?></label>
											<div class="controls">
												<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false))?>
											</div>
										</div>
															
									<div class="control-group">
											<label class="control-label"><?php echo __('Confirm Password');?></label>
											<div class="controls">
												<?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false))?>
											</div>
										</div>
									</fieldset>
									<fieldset title="Step 2">
										<legend>Contact Details</legend>
									<div style = "float:left;width:45%">	
										<div class="control-group">
											<label class="control-label"><?php echo __('Email Id');?></label>
											<div class="controls">
												<?php echo $this->Form->input("email" ,array('type'=>'text','label' => false,'div' => false))?>
											</div>
										</div>
						
										<div class="control-group">
											<label class="control-label"><?php echo __('Contact No');?></label>
											<div class="controls">
												<?php echo $this->Form->input("contact_no" ,array('label' => false,'div' => false,'maxlength'=>10))?>
											</div>
										</div>
									
										<div class="control-group">
											<label class="control-label"><?php echo __('Address');?></label>
											<div class="controls">
												<?php echo $this->Form->input("address" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									</div>	
									<div style = "float:right;width:45%">		
										<div class="control-group">
											<label class="control-label"><?php echo __('City');?></label>
											<div class="controls">
												<?php echo $this->Form->input("city" ,array("type"=>"text",'label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									
										<div class="control-group">
											<label class="control-label"><?php echo __('State');?></label>
											<div class="controls">
												<?php echo $this->Form->input("state" ,array("type"=>"text",'label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
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
												<?php echo $this->Form->input("pin" ,array("type"=>"text",'label' => false,'div' => false,'maxlength'=>10))?>
											</div>
										</div>
									</div>	
									<div style="clear:both"></div>
									</fieldset>
									<fieldset title="Step 3">
										<legend>Other Details</legend>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Contact Person Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("con_name" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
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
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Currency Type');?></label>
											<div class="controls">
												<?php echo $this->Form->input("currency" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$currency ))?>
											</div>
										</div>		
									</fieldset>
									<button type="submit" class="finish btn btn-extend"> Finish!</button>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	
	
<script type="text/javascript">

            $(function () {
                /*==JQUERY STEPY==*/
            jQuery.validator.addMethod("alphanumeric", function(value, element) {
       	 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
			}); 
                $('.form-horizontal').stepy({
                    backLabel: 'Back',
                    nextLabel: 'Next',
                    errorImage: true,
                    block: true,
                    description: true,
                    legend: false,
                    titleClick: true,
                    titleTarget: '#top_tabby',
                    validate: true
                });
                
                                 $(".form-horizontal").validate({

                    rules: {
                     	'data[User][agent_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
                     	'data[User][bus_name]':"required",
                     
                       'data[User][username]': {
                            required: true,
                            minlength: 2,
                           alphanumeric:true
                        },
                        'data[User][password]': {
                            required: true,
                            minlength: 5
                        },
                        'data[User][cpassword]': {
                            required: true,
                            minlength: 5,
                            equalTo: "#UserPassword"
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
                        'data[User][currency]': {
                            required: true,
                            digits: true,                            
                        }, 
                         'data[User][pin]': {
                            required: true,  
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
                            minlength: "Your username must consist of at least 2 characters",
                          alphanumeric: "Invalid Username"
                        },
                       'data[User][password]': {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        'data[User][cpassword]': {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        },
                        'data[User][email_id]': "Please enter a valid email address",
                        'data[User][contact_no]':"Please enter a valid contact no",
                        'data[User][currency]': {
                        required : "Please Select Currency",
                        digits :  "Please Select Currency",
                        },
                        'data[User][city]':"Please enter a city",
                        'data[User][state]':"Please enter a state",
                        'data[User][country]': {
                        required : "Please Select a Country",
                        digits :  "Please Select a Country",
                        },
                        'data[User][pin]': "Please enter a valid pincode",
                        'data[User][con_name]':"Please enter the ContactPerson name",
                        'data[User][con_email]':"Please enter a valid email address ",
                        'data[User][mob_no]':"Please enter a valid mobile no."
                    }
                });

            });
            
           
        </script>	
