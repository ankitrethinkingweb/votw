<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<style>
input[type=text]{
width:206px!important;
}

input.error,select.error
{
border:1px solid red;
}

tbody{
font-size:14px;
}
</style>	
		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
					<?php if(isset($viewhead)) { ?>
						<div class="widget-head orange">
							<h3>Edit Extension Date</h3>
						</div>
						<?php } ?>
						<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User',array('action' => 'save_visa_data','class'=>'form-horizontal','novalidate'=>'novalidate','id'=>'form_extension')); 
						 echo $this->Form->input("visa" ,array('type'=>"hidden",'label' => false,'div' => false,'class'=>"span6",'id'=>"visa",'value'=>$data[0]['b']['app_id'] ));?>
								 <table>
								 <tbody>
								 <tr>
									 <th>App No </th>
									 <td><?php if(isset($data[0]['b']['app_no'])) echo $data[0]['b']['app_no']; else echo 'NA';?></td>
								 </tr>
								 <tr>
									 <th>Tentative Date Of Travel</th>
									 <td><?php if(isset($data[0]['a']['tent_date'])) echo date('d M Y',strtotime($data[0]['a']['tent_date'])); else echo 'NA';?></td>
								 </tr>
								 <tr>
									 <th>Visa Type</th>
									 <td><?php if(isset($visa_type[$data[0]['a']['visa_type']])) echo $visa_type[$data[0]['a']['visa_type']]; else echo 'NA';?></td>
								 </tr>
								 <tr>
									 <th>Visa Fee</th>
									 <td><?php if(isset($fee)){ echo $fee; if(isset($currency)) echo ' '.$currency; else echo ' INR'; } else echo 'NA';?></td>
									 
								 </tr>
								 <tr>
									 <th>Date Of Exit</th>
									<td><?php echo $this->Form->input("last_doe" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"last_doe",'readonly'=>true,'value'=>$data[0]['b']['last_doe']))?></td>
								 </tr>
								 <tr>
									 <th>Last Date</th>
									 <td><?php echo $this->Form->input("d_o_e" ,array('label' => false,'div' => false,'class'=>"span6",'id'=>"d_o_e",'readonly'=>true,'value'=>$data[0]['b']['date_of_exit']))?></td>
								 </tr>
								 </tbody>
								 </table>
				              
								<div class="form-actions">
									<button type="submit" class="btn "><i class="icon-upload-alt"></i> Save </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	
<script type = "text/javascript">
$(document).ready(function(){

$("#form_extension").validate({  
					 rules: {
	                 		 'data[User][d_o_e]':{
	          				 	 required:true,
	          				  },
	          				  'data[User][last_doe]':{
	          				  	required:true,
	          				  },
          				  },
          				  messages:{
          				 	 'data[User][d_o_e]':{
	          				 	 required:'Date Of Entry is required',
	          				  },
	          				  'data[User][last_doe]':{
	          				  	required:'Last Date to Apply for extension is required',
	          				  },
          				  }
          				  
	});
	
$('#last_doe').datepicker({
	       showWeek: true, 
	       showButtonPanel: true, 
	       changeMonth: true, 
	       changeYear: true,
	       dateFormat: 'yy-mm-dd', 
	  	   yearRange:'1947:'+ (new Date().getFullYear() + 2),
	  	   minDate : 0,
	  	   onSelect:get_last_date,
});

	
});

function get_last_date(date){
var date1 = $("#last_doe").datepicker('getDate');
var date2 = new Date(date1.getTime() - 24 * 60 * 60 * 1000 * 10);
var d = ("0" + date2.getDate()).slice(-2);
var m = ("0" + (date2.getMonth() + 1)).slice(-2);
var y = date2.getFullYear();
var last_date = y+'-'+m+'-'+d;
$('#d_o_e').val(last_date);
return;
}


</script>
			