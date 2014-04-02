<?php 
	echo $this->Html->script('jquery.ui.datepicker');
	echo $this->Html->script('jquery.validate');
	echo $this->fetch('script');	
?>
<?php $date_dd['dd'] = '-dd-'; for($i=1;$i<=31;$i++){ $date_dd[$i] = $i; }?>
<?php $date_mm['mm'] = '-mm-'; for($j=1;$j<=12;$j++){ $date_mm[$j] = $j; }?>
<?php $date_yy['yy'] = '-yy-'; $year = date('Y'); for($k=$year;$k<=2080;$k++){ $date_yy[$k] = $k; }?>
<style type="text/css">
.date_style{
width:73px;
}

</style>
<div class="container-fluid" style='margin-top:34px;'>
	<div class="row-fluid">
		<div class="span12 code-example">
			<div class="content-widgets light-gray">
						<div class="widget-head green">
							<h3>New Bank Transaction</h3>
						</div>
						
						<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php echo $this->Form->create('User', array('class'=>'form-horizontal','novalidate'=>'novalidate','enctype'=>'multipart/form-data')); ?>							
								<div style = "float:left;width:45%">
								<?php $user_id = $this->UserAuth->getUserId();
								if(!$is_admin){
								echo $this->Form->input("user_id" ,array('value'=>$user_id,'type' => 'hidden', 'label' => false,'div' => false));
								}
								
								?>
											<div class="alert" style = "width:931px;">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<i class="icon-exclamation-sign"></i><strong>*</strong> If you attached a receipt of the payment, Approval will be faster.
									</div>
											<?php if($is_admin) { ?>
											<div class="control-group">
										<?php $trans_option = $tr_mode; ?>
											<label class="control-label"><?php echo __('Select Agent');?></label>
											<div class="controls">
												<?php echo $this->Form->input("agent_select" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$users_list,'id'=>'agent_select'))?>
											</div>
											</div>
											<?php } ?>
											
											<div class="control-group">
										<?php $trans_option = $tr_mode; ?>
											<label class="control-label"><?php echo __('Transaction Mode');?></label>
											<div class="controls">
												<?php echo $this->Form->input("trans_mode" ,array("onclick"=>'check_mode()',"type"=>"select",'label' => false,'div' => false,'options'=>$trans_option))?>
											</div>
											</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Amount'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></label>
											<div class="controls">
												<?php echo $this->Form->input("amt" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									</div>
								
									<div id = "bank_mode" style = "display:none;float:left;width:45%;margin-top: 72px;">	
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
												<?php echo $this->Form->input("account_no" ,array("type"=>"text",'label' => false,'div' => false,'maxlength'=>255))?>
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
											<label class="control-label"><?php echo __('Receipt Scan Copy');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>																	
									<div class="controls">
									<?php echo $this->Form->file("receipt" ,array('label' => false,'div' => false,'id'=>'receipt'))?>
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
									</div>
									
<?php 
if(!empty($users)){
foreach($users as $row){

?>
										
<input type="hidden" name="firstname" value="<?php echo $row['users']['username'];?>" /> 
<input type="hidden" name="email" value="<?php echo $row['users']['email'];?>" />
<input type="hidden" name="phone" value="1234567890" />
<input type="hidden" name="key" value="tCFLTu" />
<input type="hidden" name="amount" value="" />
<input type="hidden" name="productinfo" value="travel"/>
<input type="hidden" name="surl" value="<?php echo SITE_URL; ?>after_payment/1" />
<input type="hidden" name="furl" value="<?php echo SITE_URL; ?>after_payment/2" />
			<?php } } ?>											
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	
	
<script type="text/javascript">


function check_mode()
			{
	
			$('#slip').css('display','none');
			$("#receipt").rules("remove"); 
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
		
			
			
			if($('#UserTransMode').val() == 1 || $('#UserTransMode').val() == 6 || $('#UserTransMode').val() == 2)
			{
				if($('#UserTransMode').val() == 6)
					$('#tr_no').text('DD Number');
				if($('#UserTransMode').val() == 1)
				{
					$('#tr_no').text('Receipt Number');
					$('#slip').css('display','block');
					$("#receipt").rules("add", "required");  
					$("#receipt").rules("add", "extension"); 
					$("#receipt").rules("add", "filesize"); 
				}
				if($('#UserTransMode').val() == 2)
					$('#tr_no').text('Cheque Number');
			}
			else
			$('#tr_no').text('Transaction Number');
			}
			
		
			
            $(function () {  
/*$.validator.addMethod("File", function(value, element) {
return this.optional(element) || /(?:^|\/|\\)((?:[a-z0-9_\s\(\)\[\]])*\.(?:pdf|gif|jpg|jpeg|png))$/i.test(value);
}, "Invalid file type");*/

jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|png|jpe?g|gif";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));

$.validator.addMethod('filesize', function(value, element, param) {
     param = "102400"
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  

            $(".form-horizontal").validate({
                 rules: {
                     	'data[User][bank_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
                     	'data[User][amt]':{
                            required: true,
                            digits: true,
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
						'data[User][agent_select]': {
                            required: true,
                           digits:true
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
                         'data[User][trans_date]': {
                            required: true,
                        },
                       'data[User][trans_id]': {
                            required: true,
                        },
                          'data[User][cheque_no]': {
                            required: true,
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
                        'data[User][account_no]':{
                        required:"Please enter a valid email address",
                        alphanumeric:"Invalid Account No."
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
                        'data[User][trans_date]': "Please Select Transaction Date",
                        'data[User][trans_id]':"Please enter Transaction id for DD",
                        'data[User][cheque_no]':"Please enter Cheque No. for DD",
                        
                        'data[User][tent_dd]':"Please Select Date",
                        
                        'data[User][tent_mm]':"Please Select Month",
                        
                        'data[User][tent_yy]':"Please Select Year",
                       
                       }
                });

            });
            
             $(function () {
		     $("#UserTransDate").datepicker({ 
			   showWeek: true, 
			   showButtonPanel: true, 
		       changeMonth: true, 
		       changeYear: true,
			   dateFormat: 'yy-mm-dd', 
		       yearRange:'1947:' + (new Date().getFullYear() + 2),
			   minDate: 0
			   });
   			 });
           
        </script>	