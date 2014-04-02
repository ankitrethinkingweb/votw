<style>
.date_style{
width:73px;
}

.error
{
border:1px solid red;
}

</style>
<?php 
echo $this->Html->script('jquery.ui.datepicker');
echo $this->Html->script('jquery.validate');
//echo $this->Html->script('visa_app_validation');
echo $this->fetch('script');
//echo $this->Html->tag('b','Global Voyages | the. Travel. archer.');	
?>
<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Add Visa Application</h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Session->flash(); 
						
							echo $this->Form->create('User', array('id'=>'visaform','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); ?>					

									<?php $date_dd['dd'] = '-dd-'; for($i=1;$i<=31;$i++){ $date_dd[$i] = $i; }?>
										<?php $date_mm['mm'] = '-mm-'; for($j=1;$j<=12;$j++){ $date_mm[$j] = $j; }?>
										<?php $date_yy['yy'] = '-yy-'; $year = date('Y'); for($k=$year;$k<=2080;$k++){ $date_yy[$k] = $k; }?>
									<input type = 'hidden' name = 'hide_count' id = 'hide_count' value = '' />	
									<input type = "hidden" value = "<?php if(isset($groupId)) echo $groupId; ?>" name = 'groupId' id = "groupId"/>
									
						<div style="float:left;width:50%;">
						
								<div class="control-group">
											<?php $country_option = $visa_type; ?>
											<label class="control-label"><?php echo __('Visa Type');?></label>
											<div class="controls">
												<?php echo $this->Form->input("visa_type" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'onchange'=>'enable_dest()'))?>
											</div>
										</div>
										
										<div class="control-group">										
											<label class="control-label"><?php echo __('Tentative Date of Travel');?></label>
											<div class="controls">
												<?php echo $this->Form->input("tent_dd" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_dd,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("tent_mm" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("tent_yy" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_yy,'class'=>'date_style' ))?>
											
											</div>
										</div>
										
										<div class="control-group">
											<?php $country_option = $country; ?>
											<label class="control-label"><?php echo __('Citizenship');?></label>
											<div class="controls">
												<?php echo $this->Form->input("citizenship" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option ))?>
											</div>
										</div>
										
										</div>
										
										<div style="float:left;width:50%">
										<?php $city_option = $country; ?>
										<div class="control-group">
											<label class="control-label"><?php echo __('Destination');?></label>
											<div class="controls">
												<?php echo $this->Form->input("destination" ,array('type'=>'select','label' => false,'div' => false,'options'=>$city_option,'onblur'=>"this.value=this.value.toUpperCase()",'disabled'=>true))?>
											</div>
										</div>
										
										<div class="control-group">		
										<?php  for($i=1;$i<=9;$i++) $acount[$i] = $i; ?>				
										<?php $ccount[0] = 'Children(s)'; for($i=1;$i<=9;$i++) $ccount[$i] = $i; ?>				
										<?php $icount[0] = 'Infant(s)'; for($i=1;$i<=9;$i++) $icount[$i] = $i; ?>								
											<label class="control-label"><?php echo __('No. of Travellers');?></label>
											<div class="controls">
												<?php echo $this->Form->input("adult" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$acount,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("children" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$ccount,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("infants" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$icount,'class'=>'date_style'))?>
												<p><span style="font-size: 11px; font-weight: normal; color: Black"> (Above 12 Yrs) </span>&nbsp;&nbsp;
												<span style="font-size: 11px; font-weight: normal; color: Black"> (6-12 Yrs) </span>&nbsp;&nbsp;&nbsp;
												<span style="font-size: 11px; font-weight: normal; color: Black"> (Below 6 Yrs) </span></p>
												
											</div>
											
										</div>
										
								</div>
								<div style="clear:both;"></div>		
								
											<div class="form-actions">
											<button type="submit" class="btn btn-primary" id = "submit">Continue</button>
<span>( Please read the <a href = '<?php echo $this->webroot; ?>document' target = '_blank'>documentation</a> before applying.)</span>	
											<?php echo $this->Form->end(); ?>
									</div>
											
							</form>
                            <div id = 'change'></div>
						</div>
					
				</div>				
			</div>
		</div>
	</div>

<style>
.space{
margin:5px;
}
</style>


<script type = "text/javascript">
function enable_dest(){
if($('#UserVisaType').val() != 'select' )
document.getElementById("UserDestination").removeAttribute("disabled");
else
document.getElementById("UserDestination").setAttribute("disabled");
}

$(".chzn-select").chosen();

 $(function () {
                $("#visaform").validate({
                errorPlacement: function(error,element) {
				    return true;
				  },
                 rules: {
                     	'data[User][visa_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
                     	'data[User][tent_dd]':{
                     	required :true,
          				  digits:true,
          				  },
          				  'data[User][tent_mm]':{
          				  required :true,
          				  digits:true,
          				  },
          				  'data[User][tent_yy]':{
          				  required :true,
          				  digits:true,
          				  },
                     	'data[User][citizenship]' :{    
                     		required :true,                
                     		 digits: true,
          				  }, 
                       'data[User][destination]': {
                            required: true,
                            digits: true,
                        },                     
                    },
                    messages: {
                    'data[User][visa_type]': "Please Select Visa-type",
                    'data[User][tent_dd]': "Please Select Tentative Date",
                    'data[User][tent_mm]': "Please Select Tentative Month",
                    'data[User][tent_yy]':  "Please Select Tentative Year",
                    'data[User][citizenship]' :'Please Select Citizenship',  
          			'data[User][destination]' :'Please Select destination',                   
                    },
                    
                    submitHandler:function()
					{
					$('#submit').html("<b>Loading </b><img src = '<?php echo $this->webroot; ?>app/webroot/images/loader.gif' > ");
						var count = parseInt($('#UserAdult').val()) + parseInt($('#UserChildren').val()) + parseInt($('#UserInfants').val());
						
							$('#hide_count').val(count);
							 	$.ajax({
						      url: "<?php echo $this->webroot; ?>save_app",
						      dateType:'html',
						      type:'post',
						      data:$('#visaform').serialize(),
						      success: function(data){	    
						      if(data != 'Error')
						      	$("#change").html(data);
						      	else
						      	$('#error').html('Some Errors occured.');
						      },complete:function(){
         $('#submit').html("Continue");
         }    										         
						    });
						    return false;
					}
                });
            });
            
              function get_receipt(id)
		       {
		       appdetail=window.open("<?php echo $this->webroot; ?>Users/get_receipt/"+id, "mywindow", ",left=50,top=100,location=0,status=0,scrollbars=0,width=600,height=600");
			   appdetail.focus();
				}
				
			
         				
		
</script>