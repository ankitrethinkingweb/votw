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
<style type="text/css">
.date_style{
width:73px;
}

</style>
<?php 
	echo $this->Html->script('jquery.validate');
	echo $this->fetch('script');	
?>

<?php $date_dd['dd'] = '-dd-'; for($i=1;$i<=31;$i++){ $date_dd[$i] = $i; }?>
<?php $date_mm['mm'] = '-mm-'; for($j=1;$j<=12;$j++){ $date_mm[$j] = $j; }?>
<?php $date_yy['yy'] = '-yy-'; $year = date('Y'); for($k=$year;$k<=2080;$k++){ $date_yy[$k] = $k; }?>
<div class="container-fluid" style='margin-top:34px;'>

	<div class="row-fluid">
		<div class="span12 code-example">
			<div class="content-widgets light-gray">
						<div class="widget-head green">
							<h3>Edit Bank Transaction</h3>
						</div>
						
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php echo $this->Form->create('User', array('class'=>'form-horizontal','novalidate'=>'novalidate','enctype'=>'multipart/form-data')); 
							?>							
								<div style = "float:left;width:45%">
										<div class="control-group">
										<?php $trans_option = $tr_mode; ?>
											<label class="control-label"><?php echo __('Transaction Mode');?></label>
											<div class="controls">
												<?php echo $this->Form->input("trans_mode" ,array("onclick"=>'check_mode()',"type"=>"select",'label' => false,'div' => false,'options'=>$trans_option))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Amount');?></label>
											<div class="controls">
												<?php echo $this->Form->input("amt" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										</div>
										<div id = "bank_mode" style = "<?php if(isset($user['User']['trans_mode']) and $user['User']['trans_mode'] == 1) {?>display:block;<?php }else { ?>display:none;<?php } ?>float:right;width:45%">		
										<div id="bankdiv" style="display:none;">
											<div class="control-group">
												<label class="control-label"><?php echo __('Transaction Id for DD');?></label>
												<div class="controls">
													<?php echo $this->Form->input("trans_id_dd" ,array('label' => false,'type'=>'text','div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
												</div>
											</div>
										</div>
																	
										<div class="control-group">
											<label class="control-label"><?php echo __('Deposit Bank Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("bank_name" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
			
										<div class="control-group">
											<label class="control-label"><?php echo __('Deposit Bank Branch');?></label>
											<div class="controls">
												<?php echo $this->Form->input("bank_branch" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
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
											<label class="control-label"><?php echo __('Your A/c Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("account_no" ,array("type"=>"text",'label' => false,'div' => false,'maxlength'=>255,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
							
								
										<div class="control-group">
											<label class="control-label" id="tr_no"><?php echo __('Transaction Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("trans_no" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										
										<div id="slip" style="display:none;">
												<div class="control-group">
											<label class="control-label"><?php echo __('Receipt Scan Copy');?></label>
											<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="input-append" style="width: 100px;">
												<div class="uneditable-input span2">
													<i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
												</div>
												<span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
												<?php echo $this->Form->file("receipt" ,array('label' => false,'div' => false,'id'=>'receipt'))?>
												</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
											</div>
												<?php if(isset($user['User']['receipt']) && $user['User']['receipt'] != 'Array' && strlen($user['User']['receipt'] ) > 0 && file_exists(WWW_ROOT.'uploads/'.$user['User']['username'].'/'.$user['User']['receipt'])) 
												
																								echo '<br/><a href="'.$this->webroot.'app/webroot/uploads/'.$user['User']['username'].'/'.$user['User']['receipt'].'" target="_blank">View Receipt</a>'; ?>
											
										</div>
												
											</div>
										</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Transaction Date');?></label>
											<div class="controls">
												<?php //echo $this->Form->input("trans_date" ,array("type"=>"text",'label' => false,'div' => false,'readonly'=>true))?>
											<?php echo $this->Form->input("tent_dd" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_dd,'class'=>'chzn-select date_style' ))?>
<?php echo $this->Form->input("tent_mm" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style' ))?>
<?php echo $this->Form->input("tent_yy" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_yy,'class'=>'chzn-select date_style' ))?>
											</div>
										</div>
															
										<div class="control-group">
											<label class="control-label"><?php echo __('Remarks');?></label>
											<div class="controls">
												<?php echo $this->Form->input("remarks" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
									</div>	
									<div style="clear:both"></div>
									<div class = "form-actions">
									<button type="submit" class="btn btn-primary"> Save</button>
									<a href = "<?php echo $this->webroot; ?>Users/all_transaction" style = "margin-left: 10px;" class="btn btn-extend">Cancel</a>
																
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	
	
<script type="text/javascript">
$(document).ready(function(){
	if($('#UserTransMode').val() == 1 || $('#UserTransMode').val() == 6 || $('#UserTransMode').val() == 2)
			{
				if($('#UserTransMode').val() == 6)
					$('#tr_no').text('DD Number');
				if($('#UserTransMode').val() == 1)
				{
					$('#tr_no').text('Receipt Number');
					$('#slip').css('display','block');
					//$("#receipt").rules("add", "required");  
				//	$("#receipt").rules("add", "File"); 
				}
				if($('#UserTransMode').val() == 2)
					$('#tr_no').text('Cheque Number');
			}
			else
			$('#tr_no').text('Transaction Number');
});
            $(function () {
             jQuery.validator.addMethod("alphanumeric", function(value, element) {
       	 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
			}); 
            if($('#UserTransMode').val() == 7 || $('#UserTransMode').val() == 'select'){		
	            $('#bank_mode').css('display','none');
	            $("#relation").rules("remove"); 
				}else{
				$('#bank_mode').css('display','block');
				}
						
				if($('#UserTransMode').val() == 6)
				$('#bankdiv').css('display','block');
				else
				$('#bankdiv').css('display','none');
				
				
				
				            
            $(".form-horizontal").validate({
                 rules: {
                     	'data[User][bank_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
                     	'data[User][amt]':{
                            required: true,
                             number: true
                        },                  
                       'data[User][bank_name]': {
                            required: true,
                            minlength: 2
                        },
                       
                        'data[User][bank_branch]': {
                            required: true,
                        },
                        'data[User][account_no]': {
                            required: true,
                             alphanumeric:true
                        },
                      	
                        'data[User][country]': {
                            required: true,
                            digits: true,                            
                        }, 
                        'data[User][trans_mode]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
          		 'data[User][trans_no]': {
                            required: true,
                             alphanumeric:true
                        },
                         'data[User][tent_dd]':{
digits:true,
},
'data[User][tent_mm]':{
digits:true,
},
'data[User][tent_yy]':{
digits:true,
},
                     
                    },
                    messages: {
                    'data[User][bank_type]':{
                    required : "Please Select Bank-type",
                    digits : "Please Select Bank-type",
                    },
                    'data[User][amt]': "Please Select a valid Amount",
                    'data[User][bank_name]':{
                    required:"Please Enter Bank Name",
                      minlength: "Your bank name must consist of at least 2 characters"
                    },                   
                        'data[User][bank_branch]': {
                            required:"Please Enter Bank Branch",
                        },
                        'data[User][account_no]': {
                            required:"Please enter a valid email address",
                            alphanumeric:"Invalid Account no.",
                        },
                        'data[User][country]': {
                        required : "Please Select a Country",
                        digits :  "Please Select a Country",
                        },
                        'data[User][trans_mode]': {
                        required : "Please Select a Transaction Mode",
                        digits :  "Please Select a Transaction Mode",
                        },
                        'data[User][trans_no]': "Please Select a valid Transaction Number",
                          'data[User][tent_dd]':"Please Select Date",
                        
                        'data[User][tent_mm]':"Please Select Month",
                        
                        'data[User][tent_yy]':"Please Select Year",
                    }
                });

            });
          
			function check_mode()
			{
	            if($('#UserTransMode').val() == 7 || $('#UserTransMode').val() == 'select'){		
	            $('#bank_mode').css('display','none');
	            $("#relation").rules("remove"); 
				}else{
				$('#bank_mode').css('display','block');
				}
						
				if($('#UserTransMode').val() == 6)
				$('#bankdiv').css('display','block');
				else
				$('#bankdiv').css('display','none');
				
				alert($('#UserTransMode').val());
			if($('#UserTransMode').val() == 1 || $('#UserTransMode').val() == 6 || $('#UserTransMode').val() == 2)
			{
				if($('#UserTransMode').val() == 6)
					$('#tr_no').text('DD Number');
				if($('#UserTransMode').val() == 1)
				{
					$('#tr_no').text('Receipt Number');
					$('#slip').css('display','block');
				//	$("#receipt").rules("add", "required");  
				//	$("#receipt").rules("add", "File"); 
				}
				if($('#UserTransMode').val() == 2)
					$('#tr_no').text('Cheque Number');
			}
			else
			$('#tr_no').text('Transaction Number');
				
			}
			
			 
             $(function () {
		     $("#UserTransDate").datepicker({ 
			   showWeek: true, 
			   showButtonPanel: true, 
		       changeMonth: true, 
		       changeYear: true,
			   dateFormat: 'yy-mm-dd', 
		       yearRange:'1947:' + (new Date().getFullYear() + 2),
			   minDate: +1
			   });
   			 });
           
        </script>	