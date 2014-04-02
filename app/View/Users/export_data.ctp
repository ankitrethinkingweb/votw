
<STYLE type="text/css">
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE> 
<table>

	<tr>
		<td ><b>Date  :  <?php echo date("F j, Y, g:i a"); ?></b></td>
		
	</tr>
	<?php if(isset($vdata)) { ?>	
	<tr><td class="tableTdContent"><h3>Visa Application Detail</h3></td></tr>
	
	<tr><td ></td></tr><tr><td></td></tr>

	<thead>
	<tr>
	<th class="tableTd"><?php echo __('Group Number');?></th>
	<th class="tableTd"><?php echo __('Name of Applicant');?></th>								
	<th class="tableTd"><?php echo __('Visa Type');?></th>					
	<th class="tableTd"><?php echo __('Tentative Date of Travel');?></th>	
	<th class="tableTd"><?php echo __('No. of Travellers');?></th>						
	<th class="tableTd"><?php echo __('Amount');?></th>
	<th class="tableTd"><?php echo __('Applied Date');?></th>
	<th class="tableTd"><?php echo __('Status');?></th>
	
	</tr>
	</thead>
	
	<tbody>
	<?php foreach($vdata as $row){ ?>
	<tr>
	<td class="tableTdContent">
	<?php 
	if(isset($row['visa_app_group']['group_no'])){
		if(isset($row['visa_app_group']['app_type']) && strlen($row['visa_app_group']['app_type']) > 0)
			echo '<span class="label label-info">(Quick App)</span><br/>'; 
				echo $row['visa_app_group']['group_no'] . ' ';
				}else echo 'NA';
		?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($visa_name[$row['visa_app_group']['group_id']])) echo $visa_name[$row['visa_app_group']['group_id']]; else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($visa_type[$row['visa_app_group']['visa_type']])) echo $visa_type[$row['visa_app_group']['visa_type']]; else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['visa_app_group']['tent_date'])) echo date('d M Y',strtotime($row['visa_app_group']['tent_date'])); else echo 'NA'; ?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['visa_app_group']['adult']) && isset($row['visa_app_group']['children']) && isset($row['visa_app_group']['infants'])) 
			echo 'Adult(s):'.$row['visa_app_group']['adult'].' <br/>Children:'.$row['visa_app_group']['children'].' <br/>Infants:'.$row['visa_app_group']['infants'] ;
			else echo 'NA'; ?>
	</td>
		
	<td class="tableTdContent">
	<?php if(isset($row['visa_app_group']['visa_fee'])) echo $row['visa_app_group']['visa_fee']; else echo 'NA'; ?>
	</td>
								
	
	<td class="tableTdContent">
	<?php if(isset($row['visa_app_group']['app_date'])) echo date('d M Y',strtotime($row['visa_app_group']['app_date'])); else echo 'NA';
	?>
	<td class="tableTdContent">
	<?php if(isset($tr_status[$row['visa_app_group']['tr_status']])) echo $tr_status[$row['visa_app_group']['tr_status']]; else echo 'NA';?>
	</td>
	
	</td>
	</tr>	<?php  } ?>
	</tbody>
	<?php }  ?>
	
	<?php if(isset($odata)) { ?>		
	<tr><td ></td></tr><tr><td></td></tr>	
			
	<tr><td class="tableTdContent"><h3>OKTB Application Detail</h3></td></tr>
	
	<tr><td ></td></tr><tr><td></td></tr>									
	
	<thead>
	<tr>
	<th class="tableTd"><?php echo __('Group No');?></th>
	<th class="tableTd"><?php echo __('OKTB No');?></th>
	<th class="tableTd"><?php echo __('Name of Applicant');?></th>	
	<th class="tableTd"><?php echo __('Date/Time of Journey');?></th>			
	<th class="tableTd"><?php echo __('Airline');?></th>											
	<th class="tableTd"><?php echo __('PNR No');?></th>					
	<th class="tableTd"><?php echo __('Passport No');?></th>	
	<th class="tableTd"><?php echo __('Amount'); ?></th>					
	<th class="tableTd"><?php echo __('Status');?></th>
	<th class="tableTd"><?php echo __('Applied Date');?></th>
	</tr>
	</thead>
	
	<tbody>
	<?php foreach($odata as $row){ ?>
	<tr>
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_group_no']) && $row['oktb_details']['oktb_group_no'] != null && strlen( $row['oktb_details']['oktb_group_no']) > 0)	echo $row['oktb_details']['oktb_no']; else	echo 'NA'; ?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_no'])) echo $row['oktb_details']['oktb_no']; else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_name']) and strlen($row['oktb_details']['oktb_name']) > 0)
								echo $row['oktb_details']['oktb_name'];
								else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_d_o_j']) and strlen($row['oktb_details']['oktb_d_o_j']) > 0){
								echo $row['oktb_details']['oktb_d_o_j'];
		if(isset($row['oktb_details']['oktb_doj_time']) && strlen(strstr($row['oktb_details']['oktb_doj_time'],'hh')) == 0 ) echo ' '.$row['oktb_details']['oktb_doj_time'];
								}else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($airline[$row['oktb_details']['oktb_airline_name']]) and strlen($airline[$row['oktb_details']['oktb_airline_name']]) > 0)
								echo $airline[$row['oktb_details']['oktb_airline_name']];
								else echo 'NA';?>
	</td>
		
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_pnr']) and strlen($row['oktb_details']['oktb_pnr']) > 0)
								echo $row['oktb_details']['oktb_pnr'];
								else echo 'NA';?>
	</td>
								
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_passportno']) and strlen($row['oktb_details']['oktb_passportno']) > 0)
								echo $row['oktb_details']['oktb_passportno'];
								else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_airline_amount']) and strlen($row['oktb_details']['oktb_airline_amount']) > 0)
								echo $row['oktb_details']['oktb_airline_amount'];
								else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($tr_status[$row['oktb_details']['oktb_payment_status']]))
								echo $tr_status[$row['oktb_details']['oktb_payment_status']];
								else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['oktb_details']['oktb_posted_date']) and strlen($row['oktb_details']['oktb_posted_date']) > 0)
								echo date('d M Y',strtotime($row['oktb_details']['oktb_posted_date']));
								else echo 'NA'; ?>
	</td>
	</tr>	<?php  } ?>
	</tbody>
	<?php }  ?>			
	
	<?php if(isset($edata)) { ?>
	<tr><td ></td></tr><tr><td ></td></tr>	
			
	<tr><td class="tableTdContent"><h3>Extension Application Detail</h3></td></tr>
	
	<tr><td ></td></tr><tr><td ></td></tr>									
	
	<thead>
	<tr>
	<th class="tableTd"><?php echo __('Ext No');?></th>
	<th class="tableTd"><?php echo __('Name');?></th>			
	<th class="tableTd"><?php echo __('Passport No');?></th>	
	<th class="tableTd"><?php echo __('Date');?></th>
	<th class="tableTd"><?php echo __('Amount');  ?></th>
	<th class="tableTd"><?php echo __('Status');?></th>
	</tr>
	</thead>
	
	<tbody>
	<?php foreach($edata as $row){ ?>
	<tr>
	<td class="tableTdContent">
	<?php if(isset($row['extension']['ext_no'])) echo $row['extension']['ext_no']; else	echo 'NA'; ?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['extension']['ext_name'])) echo $row['extension']['ext_name']; else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['extension']['ext_passportno'])) echo $row['extension']['ext_passportno']; else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['extension']['ext_date'])){ echo $row['extension']['ext_date']; 	}else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($row['extension']['ext_amt']) and strlen($row['extension']['ext_amt']) > 0){ echo $row['extension']['ext_amt']; 	}else echo 'NA';?>
	</td>
	
	<td class="tableTdContent">
	<?php if(isset($tr_status[$row['extension']['ext_payment_status']])){ echo $tr_status[$row['extension']['ext_payment_status']];	}else echo 'NA';?>
	</td>
		

	</tr>	<?php  } ?>
	</tbody>
	<?php }  ?>										
</table>
