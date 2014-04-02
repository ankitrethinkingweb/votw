<STYLE type="text/css">
	th {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	td{
		border-width: 0.5pt; 
		border: solid;
	}
	.highL{
		background-color:#E2E6E7!important;
	}
   
</STYLE>

<?php if(isset($data)) { ?>
<tr>
	<td ><b>Date:</b></td>
	<td ><?php echo date("F j, Y, g:i a"); ?></td>
</tr>

<table class="table table-striped table-bordered" id="data-table">
<thead>
	<tr>
							<th><?php echo __('User Name');?></th>
							<th><?php echo __('Agent');?></th>	
							<th><?php echo __('Type');?></th>								
							<th><?php echo __('Action Type');?></th>					
							<th><?php echo __('App No.');?></th>
							<th><?php echo __('Transaction Id');?></th>		
							<th><?php echo __('Airline/Visa Type');?></th>					
							<th><?php echo __('Previous Value');?></th>
							<th><?php echo __('Updated Value');?></th>
							<th><?php echo __('Date');?></th>
	</tr>
</thead>
<tbody>
<?php foreach($data as $d){ //print_r($d); exit;?>
<tr <?php if(isset($d['user_action']['status']) && $d['user_action']['status'] == 1){ echo "class = 'highL'"; } ?> >

<td><?php if(isset($role[$d['user_action']['role_id']])) echo $role[$d['user_action']['role_id']]; else echo '-';?></td>

<td><?php if(isset($user[$d['user_action']['user_id']])) echo $user[$d['user_action']['user_id']]; else echo '-';?></td>

<td><?php if(isset($d['user_action']['type'])) echo $d['user_action']['type']; else echo 'NA';?></td>

<td><?php if(isset($d['user_action']['action_type'])) echo $d['user_action']['action_type']; else echo '-';?></td>

<td><?php if(isset($role[$d['user_action']['role_id']])){ if($d['user_action']['type'] == 'Visa' && isset($visa[$d['user_action']['app_no']])) echo $visa[$d['user_action']['app_no']]; else if($d['user_action']['type'] == 'OKTB' && isset($oktb[$d['user_action']['app_no']])) echo $oktb[$d['user_action']['app_no']]; else if($d['user_action']['type'] == 'Extension' && isset($ext[$d['user_action']['app_no']])) echo $ext[$d['user_action']['app_no']]; else echo '-'; } else echo '-';?></td>

<td><?php if(isset($trans[$d['user_action']['trans_id']])) echo $trans[$d['user_action']['trans_id']]; else echo '-';?></td>

<td><?php if(isset($d['user_action']['type'])){ if($d['user_action']['type'] == 'Change Airline Cost' && isset($airline[$d['user_action']['other_id']])) echo $airline[$d['user_action']['other_id']]; else if($d['user_action']['type'] == 'Change Visa Cost' && isset($visa_type[$d['user_action']['other_id']])) echo $visa_type[$d['user_action']['other_id']]; else echo '-'; }else echo '-';?></td>

<td><?php if(isset($tr_status[$d['user_action']['prev_value']])){
 if($d['user_action']['type'] == 'Visa' || $d['user_action']['type'] == 'OKTB' || $d['user_action']['type'] == 'Extension' ){
 echo $tr_status[$d['user_action']['prev_value']]; 
 } else if($d['user_action']['type'] == 'Bank Transaction'){
 if($d['user_action']['prev_value'] == 'A') echo 'Approved'; else if($d['user_action']['prev_value'] == 'D') echo 'Rejected'; 
 elseif($d['user_action']['prev_value'] == 'P') echo 'Pending'; else echo $d['user_action']['prev_value'];  }else echo $d['user_action']['prev_value']; } else echo '-';?></td>

<td><?php if(isset($tr_status[$d['user_action']['updated_value']])){ 
if($d['user_action']['type'] == 'Visa' || $d['user_action']['type'] == 'OKTB' || $d['user_action']['type'] == 'Extension')
 echo $tr_status[$d['user_action']['updated_value']];
 else if($d['user_action']['type'] == 'Bank Transaction'){
 if($d['user_action']['updated_value'] == 'A') echo 'Approved'; else if($d['user_action']['updated_value'] == 'D') echo 'Rejected'; 
 elseif($d['user_action']['updated_value'] == 'P') echo 'Pending'; else echo $d['user_action']['updated_value']; }else echo $d['user_action']['updated_value'];  }else echo '-';?></td>
<td><?php if(isset($d['user_action']['date'])) echo date('d M Y H:i:s',strtotime($d['user_action']['date'])); else echo '-';?></td>
</tr>
<?php } ?> 			
</tbody>
</table>
<?php } ?>	