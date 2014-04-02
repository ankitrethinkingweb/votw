					<?php if(isset($groupNo)) $groupNo = $groupNo; else $groupNo = 0;?>
					<input type = "hidden" name = "groupNo" id="groupNo" value = "<?php if(isset($groupNo)) echo $groupNo; ?>" />
					<table class="table table-striped table-bordered" >
							<thead>
							<tr>
							<th><?php echo __('App No');?></th>
							<th><?php echo __('Name of Applicant');?></th>								
							<th><?php echo __('Passport No');?></th>					
							<th><?php echo __('Date Of Birth');?></th>	
							<th><?php echo __('Profession');?></th>						
							<th><?php echo __('Actions');?></th>
							</tr>
							</thead>
							<tbody>
						
						<?php  if (!empty($value)) {
							$sl=0;
							foreach ($value as $row) { //echo '<pre>'; print_r($value); exit;
								$sl++;
								echo "<tr onclick = 'show_doc(".$row['visa_tbl']['app_id'].",\"".$groupNo."\")'>";
								echo '<input type = "hidden" id = "appd-'.$row['visa_tbl']['app_id'].'" name = "appd-'.$row['visa_tbl']['app_id'].'" value = 0 />';	
								
								echo "<td>";
								if(isset($row['visa_tbl']['app_no'])) echo $row['visa_tbl']['app_no']; else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_tbl']['first_name']) && isset($row['visa_tbl']['last_name'])){ 
									echo $row['visa_tbl']['first_name'].' '. $row['visa_tbl']['last_name']; 
								}else echo 'NA';
								echo "</td>";	
								
								echo "<td>";
								if(isset($row['visa_tbl']['passport_no'])) echo $row['visa_tbl']['passport_no']; else echo 'NA';
								echo "</td>";
																											
								echo "<td>";
								if(isset($value2[$row['visa_tbl']['app_id']]['dob_dd']) && isset($value2[$row['visa_tbl']['app_id']]['dob_mm']) && isset($value2[$row['visa_tbl']['app_id']]['dob_yy'])) 
								echo $value2[$row['visa_tbl']['app_id']]['dob_dd'].'-'.$value2[$row['visa_tbl']['app_id']]['dob_mm'].'-'.$value2[$row['visa_tbl']['app_id']]['dob_yy']; 
								else echo 'NA';
								
								echo "</td>";
								
								echo "<td>";
								if(isset($value2[$row['visa_tbl']['app_id']]['emp_type'])){
								if($value2[$row['visa_tbl']['app_id']]['emp_type'] != 'other')
								 echo $emp_type[$value2[$row['visa_tbl']['app_id']]['emp_type']]; 
								 else 
								 echo $value2[$row['visa_tbl']['app_id']]['emp_other'];
								 }else echo 'NA';
								echo "</td>";
								
								echo "<td>";
							echo 11;
								echo "</td>";
								
								echo "</tr>";
							
								echo "<tr class = 'doc_dd' id = 'doc_tr-".$row['visa_tbl']['app_id']."'>";
								echo "<td colspan = '6' id = 'doc_td-".$row['visa_tbl']['app_id']."'></td>";
								echo "</tr>";
							}
						}?>
						
						
							
							</tbody>
					</table>

<script type = "text/javascript">
$(document).ready(function(){
	$('tr.doc_dd').css('display','none');
});
function show_doc(app,groupNo){
$('tr.doc_dd').css('display','none');
var appd = $('#appd-'+app).val();
	if(appd == 0){
		$('#appd-'+app).val(1);
		$.ajax({
	      url: "<?php echo $this->webroot; ?>users/getAppDoc",
	      dateType:'html',
	      type:'post',
	      data:'app='+app+'&groupNo='+groupNo,
	      success: function(data){	
	     	   if(data != 'Error')
	           	$('td#doc_td-'+app).html(data);
	           else alert('Some Error Occured');
	      }         
	    });
		$("#doc_tr-"+app).css('display','table-row');
	}else{
		$('td#doc_td-'+app).html('');
		$('#appd-'+app).val(0);
		$("#doc_tr-"+app).css('display','none');
	}
}
</script>