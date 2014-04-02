<style>
tbody{
font-size:14px;
}


</style>
	
		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head blue-violate">
							<h3>Add/Edit Extension Date</h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
								
								<div class="control-group" id = "Visa1">
									<label class="control-label">Select Visa</label>
									<div class="controls">
									<?php if(!isset($opt_val)) $opt_val = 'select'; ?>
										<?php echo $this->Form->input("visa" ,array('options'=>$extend,'label' => false,'div' => false,'class'=>"chzn-select span6",'id'=>"visa","onchange"=>'checkData()','value'=>$opt_val  ))?>
<img src =  "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" style = "display:none;margin-bottom: 28px;margin-left: 10px;" id = "load" />		
									</div>
								</div>
				
						
								<div class="control-group" id = "Visa2" style = "display:none;">
								<label class="control-label">Enter App No.</label>
									<div class="controls">
										<?php echo $this->Form->input("group_no" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"group_no","onblur"=>'getVisaData(this.value)' ))?><br/><span id = "msgVisa"></span>
									</div>
								</div>	
								
								<div id= 'visaData' ></div>
						</div>
					</div>
				</div>
			</div>
			
<script>
$(document).ready(function(){
$('.chzn-select').chosen();
});

function checkData(){
	var visa = $('#visa').val();
	if(visa == 'other'){
		$('#Visa2').css('display','block');
		$('#visaData').html('');
	}else{
		$('#Visa2').css('display','none');
		getVisaData(visa);
	}
}

function getVisaData(visa){
var selVal = visa.toUpperCase();
$('#load').show();
	$.ajax({
	      url: "<?php echo $this->webroot; ?>getVisaData",
	      dateType:'html',
	      type:'post',
	      data:'visaId='+selVal,
	      success: function(data){	    
	      if(data != 'Error'){
			      	$('#visaData').html(data);
			      	$('#visaData').css('display','block');
			      	$('#msgVisa').html('');
		      	}else{
		      		$('#msgVisa').html('<strong style = "color:red;font-size:13px;">Incorrect App No.</strong>');
		      	}
	      	},complete:function(){
	      	$('#load').hide();
	      	}         
	    });
	    return false;
}
</script>