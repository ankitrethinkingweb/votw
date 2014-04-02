<?php 
echo $this->Html->script('jquery.validate');
//echo $this->Html->script('visa_app_validation');
echo $this->fetch('script');	
?>
<style>
.date_style{
width:64px;
margin-bottom:5px!important;
}

.date_style2{
width:100px;
}
/*.error
{
border:1px solid red;
}
*/
</style>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
				<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Quick Visa Application</h3>
						</div>
			<div class="widget-container">
<div id = "add_data" class="site">
<?php echo $this->Session->flash(); 						
echo $this->Form->create('User', array('id'=>'visaform','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); ?>					
<?php $date_dd['dd'] = 'dd'; for($i=1;$i<=31;$i++){ $date_dd[$i] = $i; }?>
<?php $date_mm['mm'] = 'mm'; for($j=1;$j<=12;$j++){ $date_mm[$j] = $j; }?>
<?php $date_yy['yy'] = 'yy'; $year = date('Y'); for($k=$year;$k<=2080;$k++){ $date_yy[$k] = $k; }?>
<input type = 'hidden' name = 'hide_count' id = 'hide_count' value = '' />	
<input type = "hidden" value = "<?php if(isset($groupId)) echo $groupId; ?>" name = 'groupId' id = "groupId"/>
									<?php if($this->UserAuth->getGroupName() != 'User'){ ?>
									<div class="control-group" >
											<label class="control-label"><?php echo __('Select Agent');?></label>
											<div class="controls">
											<?php if(!isset($agent)) $agent = array('select'=>'Select'); ?>
												<?php echo $this->Form->input("agent" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$agent,'style'=>'width:356px;','onchange'=>'get_agent_visa(this.value)'))?>
											<span id = "BalAmt"></span>
											</div>
											
									</div> 
									
									<?php } ?>
									<div style="float:left;width:33%;">
										<div class="control-group">
											<?php if(isset($visa_type)) $country_option = $visa_type; else $country_option = array('select'=>'Select'); ?>
											<label class="control-label"><?php echo __('Visa Type');?></label>
											<div class="controls">
												<?php echo $this->Form->input("visa_type" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option, 'onchange'=>'get_elegebility(this.value)'))?>
											<span id = "visa_error" style = "color:red;"></span>
											</div>
										</div>
										</div>
										
									<div style = "float:left;width:33%">
									<div class="control-group">										
											<label class="control-label"><?php echo __('Tentative Date of Travel');?></label>
											<div class="controls">
												<?php echo $this->Form->input("tent_dd" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_dd,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("tent_mm" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'date_style' ))?>
												<?php echo $this->Form->input("tent_yy" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_yy,'class'=>'date_style' ))?>
											</div>
										</div>
									</div>
									
									<div style = "float:left;width:33%">	
										<div class="control-group">		
										<?php  for($i=1;$i<=9;$i++) $acount[$i] = $i; ?>				
										<?php $ccount[0] = 'Children(s)'; for($i=1;$i<=9;$i++) $ccount[$i] = $i; ?>				
										<?php $icount[0] = 'Infant(s)'; for($i=1;$i<=9;$i++) $icount[$i] = $i; ?>								
											<label class="control-label"><?php echo __('No. of Travellers');?></label>
											<div class="controls">
												<?php echo $this->Form->input("adult" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$acount,'class'=>'date_style2' ))?>
												<?php echo $this->Form->input("children" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$ccount,'class'=>'date_style2' ))?>
												<?php echo $this->Form->input("infants" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$icount,'class'=>'date_style2'))?>
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
                            <div id = 'change'></div>


</div>
<div style="clear:both;">&nbsp;</div>
</div></div></div></div></div>
<script type="text/javascript">
$(function () {
$(".chzn-select").chosen();

$('.responsive-leftbar').css('display','block');
  var width = $('div.leftbar.clearfix').width();
  var left = $('div.leftbar.clearfix').css("left");
	$('div.leftbar.clearfix').stop().animate({left: - width  },500); 
		$('body').css('background-color','#FFF');
		if (document.documentElement.clientWidth > 768) {
			  $('div.main-wrapper').css('margin-left','0px');
			  $('div.main-wrapper').css('margin-right',width+'px');
			  $('.container-fluid').css('width','120%');
			}else
			{
			$('div.main-wrapper').css('margin-left','0px');
			  $('div.main-wrapper').css('margin-right','0px');
			}	
			
					  
                $("#visaform").validate({
               /*errorPlacement: function(error,element) {
				    return true;
				  },*/
                 rules: {
                     	'data[User][visa_type]' :{ 
                     	required :true,
                     	 digits: true,
          				  },
          				  'data[User][agent]':{
          				  required:true,
          				  digits:true,
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
                     	   
                    },
                    messages: {
                    'data[User][visa_type]': "Please Select Visa-type",
                    'data[User][tent_dd]': "Please Select Tentative Date",
                    'data[User][tent_mm]': "Please Select Tentative Month",
                    'data[User][tent_yy]':  "Please Select Tentative Year",
                    },
                    
                    submitHandler:function()
					{
					$('#submit').html("<b>Loading </b><img src = '<?php echo $this->webroot; ?>app/webroot/images/loader.gif' > ");
						var count = parseInt($('#UserAdult').val()) + parseInt($('#UserChildren').val()) + parseInt($('#UserInfants').val());
						
							$('#hide_count').val(count);
							 	$.ajax({
						      url: "<?php echo $this->webroot; ?>save_quick_app",
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

				function get_agent_visa(agent){
						$.ajax({
						      url: "<?php echo $this->webroot; ?>users/get_agent_visa",
						      dateType:'json',
						      type:'post',
						      data:'id='+agent,
						      success: function(data){	
						     
						      if(data != 'Error'){
						      var obj = jQuery.parseJSON(data);
						      	$("#UserVisaType").html(obj[0]);
						      	$("#BalAmt").html(obj[1]);
						      	$('#visa_error').html('');
						      	}else{
						      	$('#visa_error').html('<br/>Please Select a valid data.');
						      	$("#BalAmt").html('');
						      	}
						      },complete:function(){
         						$('#submit').html("Continue");
         					}    										         
					 });
		}
		
		function get_elegebility(elegib){
$.ajax({
	      url: "<?php echo $this->webroot; ?>users/elegibility",
	      dateType:'html',
	      type:'post',
	      data:'id='+elegib,
	      success: function(data){	 
	      if(data.length > 0)
	      
	       bootbox.alert(data, function () {
   			 });
	      },         
	    })
}
</script>
