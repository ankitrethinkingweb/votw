<?php 
$type['select'] = 'Select';
$type[0] = 'Currency Change';
$type[1] = 'Wallet Adjustment';
$type[2] = 'No. of Urgent Days';
$type[3] = 'Lowest Wallet Balance';
$type[4] = 'Send Invoice';

echo $this->Html->script('jquery.validate');
echo $this->fetch('script');
?>	

<style>
input.error,select.error
{
border:1px solid red;
}

.selectError
{
border:1px solid red;
}
</style>
		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> Agent Settings </h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'save_settings','class'=>'form-horizontal','novalidate'=>'novalidate'));  ?>
							
								<div class="control-group">
									<label class="control-label">Select Agent</label>
									<?php if(!isset($agent)) $agent = ''; if(!isset($agent_val)) $agent_val = 'select';?>
									<div class="controls">
										<?php echo $this->Form->input("agent" ,array('options'=>$agent,'label' => false,'div' => false,'class'=>"chzn-select span6",'id'=>"agent",'value'=>$agent_val,'onchange'=>'get_value()' ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Select Type</label>
									<div class="controls">
										<?php echo $this->Form->input("type" ,array('options'=>$type,'label' => false,'div' => false,'class'=>"chzn-select span6",'id'=>"type",'onchange'=>'getData(this.value)'))?>
									</div>
								</div>
								
								<div class="control-group" id = 'currData' style = "display:none;">
									<label class="control-label">Select Currency</label>
									<div class="controls">
										<?php echo $this->Form->input("currency" ,array('options'=>$currency,'label' => false,'div' => false,'class'=>"chzn-select span6",'style'=>'width:491px','id'=>'currency'))?>
									</div>
								</div>
								<div id = 'selectInvoice' style = "display:none;">
									<div class="control-group" >
										<label class="control-label">Select Value</label>
										<div class="controls">
											<?php echo $this->Form->input("receipt" ,array('options'=>array(''=>'Select','Yes'=>'Yes','No'=>'No'),'label' => false,'div' => false,'class'=>"chzn-select span6",'style'=>'width:491px','id'=>'receipt','onchange'=>'selectType(this.value)'))?>
										</div>
									</div>
								
									<div class="control-group" id = "selectRecVal" style = "display:none;">
										<label class="control-label">Select Value</label>
										<div class="controls">
											<?php echo $this->Form->input("receiptType" ,array('options'=>array(''=>'Select','Regular'=>'Regular Invoice','With Addn. Tax'=>'Invoice With Addn. Tax'),'label' => false,'div' => false,'class'=>"chzn-select span6",'style'=>'width:491px','id'=>'receiptType'))?>
										</div>
									</div>
								</div>
								<div class="control-group" id = 'urgData' style = "display:none;">
									<label class="control-label" id = 'urgLabel'>Enter No.Of Urgent Days</label>
									<div class="controls">
										<?php echo $this->Form->input("urgent" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>'urgent'))?>
									</div>
								</div>
								
								<div id = 'adjustData' style = "display:none;">
									<div class="control-group" >
										<label class="control-label">Enter Amount to be deducted</label>
										<div class="controls">
											<?php echo $this->Form->input("amount" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"amount"))?>
										</div>
									</div>
									
									<div class="control-group" >
										<label class="control-label">Enter Narration</label>
										<div class="controls">
											<?php echo $this->Form->input("narration" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"narration"))?>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-info">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>


$(document).ready(function(){
$(".chzn-select").chosen();
$(".form-horizontal").validate({
errorPlacement: function(error,element) {
				    return true;
				  },
highlight: function(element) {
				  if(element.type == 'select-one')
				  {
				  name =element.name;
				  name1= name.replace("data[User][",'');
				  name1 =name1.replace("]",'');
				 $('#'+name1+'_chzn').addClass("selectError");
				  }else
				  $(element).addClass('error');
    },
    
    unhighlight: function(element) {
				  if(element.type == 'select-one')
				  {
				  name =element.name;
				  name1= name.replace("data[User][",'');
				  name1 =name1.replace("]",'');
				 $('#'+name1+'_chzn').removeClass("selectError");
				  }else
				  $(element).removeClass('error');
    },
     ignore: ":hidden:not(select)",
       
					 rules: {
					  'data[User][agent]':{
	          				 	 required:true,
	          				 	 digits:true
	          				  },
	          				   'data[User][type]':{
	          				 	 required:true,
	          				 	 digits:true
	          				  },
	                 		 'data[User][currency]':{
	          				 	 required:true,
	          				 	 digits:true
	          				  },
	          				  'data[User][amount]':{
	          				  	required:true,
	          				  	digits:true
	          				  },
	          				   'data[User][narration]':{
	          				  	required:true,
	          				  },
	          				   'data[User][urgent]':{
	          				  	required:true,
	          				  	digits:true
	          				  },
	          				  'data[User][receipt]':{
	          				  	required:true,
	          				  },
	          				  'data[User][receiptType]':{
	          				  	required:true,
	          				  },
	          				  
          				  },
          				  messages:{
          				   'data[User][agent]':{
	          				 	 required:'Please Select Agent',
	          				 	 digits:'Please Select Agent'
	          				  },
	          				   'data[User][type]':{
	          				 	 required:'Please Select Type',
	          				 	 digits:'Please Select Type'
	          				  },
	          				  
          				 	 'data[User][currency]':{
	          				 	 required:'Please Select Currency',
	          				 	 digits:'Please Select Currency'
	          				  },
	          				  'data[User][amount]':{
	          				  	required:'Please Enter Amount to be Deducted ',
	          				  	digits:'Please Enter valid Amount'
	          				  },
	          				  'data[User][narration]':{
	          				  	required:'Please Enter Narration ',
	          				  },
	          				  'data[User][receipt]':{
	          				  	required:'Please Select a Value ',
	          				  },
	          				  'data[User][receiptType]':{
	          				  	required:'Please Select a Receipt Type ',
	          				  },
	          				  
          				  }
          				  
	});
});

function getData(value){

var agent_id = $('#agent').val();

$('#settingType').val(value);
$('#urgData').css('display','none');
$('#currData').css('display','none');
$('#adjustData').css('display','none');
$('#selectInvoice').css('display','none');
$('#currency').rules('remove','required');
$('#currency').rules('remove','digits');
$('#receipt').rules('remove','required');
$('#receiptType').rules('remove','required');
	if(value == 0){
		$('#currData').css('display','block');
		$('#currency').rules('add','required');
		$('#currency').rules('add','digits');
	}else if(value == 1){
		$('#adjustData').css('display','block');	
	}else if(value == 2 || value == 3){
		if(value == 2){
		
		if(agent_id != 'select'){
		$.ajax({
	      url: "<?php echo $this->webroot; ?>users/getLowestBalData",
	      dateType:'html',
	      type:'post',
	      data:'id='+agent_id+'&value='+value ,
	      success: function(data){
	      if(data != 0 )
	    		 $("#urgent").val(data);
	    		 else $('#urgent').val('');
				}
	    });
	    }
		$('#urgLabel').html('Enter No.Of Urgent Days');
		}else {
		$('#urgLabel').html('Enter Lowest Balance Limit');
		if(agent_id != 'select'){
		$.ajax({
	      url: "<?php echo $this->webroot; ?>users/getLowestBalData",
	      dateType:'html',
	      type:'post',
	      data:'id='+agent_id+'&value='+value ,
	      success: function(data){
	      if(data != 0 )
	    		 $("#urgent").val(data);
	    		 else $('#urgent').val('');
				}
	    });
	    }
		}
		$('#urgData').css('display','block');
		
		}else if(value == 4){
		$('#receipt').rules('add','required');
		$('#selectInvoice').css('display','block');
		}
	}

function get_value(){
var agent_id = $('#agent').val();
var value = $('#type').val();

if(agent_id != 'select' && (value == 2 || value == 3)){
		$.ajax({
	      url: "<?php echo $this->webroot; ?>users/getLowestBalData",
	      dateType:'html',
	      type:'post',
	      data:'id='+agent_id+'&value='+value ,
	      success: function(data){
	       if(data != 0 )
	    		 $("#urgent").val(data);
	    		 else $('#urgent').val('');
				}
	    });
		}
}

function selectType(type){
	if(type == 'Yes')
	{
	$('#receiptType').rules('add','required');
		$('#selectRecVal').css('display','block');
	}else{
	$('#receiptType').rules('remove','required');
		$('#selectRecVal').css('display','none');
	}
}

</script>