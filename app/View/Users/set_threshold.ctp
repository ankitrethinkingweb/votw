<?php 
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
						<div class="widget-head orange">
							<h3> Set Credit Amount</h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'set_threshold','id'=>'threshold','class'=>'form-horizontal','novalidate'=>'novalidate'));  ?>
								<div class="control-group">
									<label class="control-label">Select Agent</label>
								<?php if(!isset($agent)) $agent = ''; if(!isset($agent_val)) $agent_val = 'select';?>
									<div class="controls">
										<?php echo $this->Form->input("agent" ,array('options'=>$agent,'label' => false,'div' => false,'class'=>"chzn-select span6",'id'=>"agent",'value'=>$agent_val ))?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Enter Credit Amount</label>
									<div class="controls">
									<?php if(!isset($ext_cost)) $threshold_cost = '';?>
										<?php echo $this->Form->input("threshold_cost" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"threshold_cost",'value'=>$threshold_cost ))?>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-save"></i>Save Credit Amount</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
<script>
$(document).ready(function(){
$(".chzn-select").chosen();
	$("#threshold").validate({  
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
          				  digits:true,
          				  },
          			'data[User][threshold_cost]':{
          				  required:true,
          				  digits:true,
          				  },
          		},
          		
	});
	
});

</script>