<style>
.dataTables_filter{
text-align:left!important;
}
</style>
<?php if($this->UserAuth->getGroupName() == 'User') { ?>
<p >
	<a class="btn btn-extend" href="<?php echo $this->webroot; ?>visa_app" >Visa Application</a>
</p>
<?php } ?>
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3><?php if(isset($application) || $this->UserAuth->getGroupName() != 'Admin' ) { echo "All Visa Applications"; }else { ?>Paid Visa Applications<?php } ?></h3>
						</div>
						 <div class=" information-container">
						 <?php if(isset($visa_apps) && count($visa_apps) == 200){ ?>
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php if(isset($application) && $application == 'all'){ $url = $this->webroot.'all_visa_app2/all/1';  }else $url = $this->webroot.'all_visa_app/0/1';?>
				<i class="icon-exclamation-sign"></i>Only Recent 200 records are shown, To view all records. <a href = "<?php echo $url; ?>" >Click Here</a>.
			</div>
			<?php } ?>
						<?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('Username');?></th>
							<th><?php echo __('Group Number');?></th>
							<th><?php echo __('Name of Applicant');?></th>								
							<th><?php echo __('Visa Type');?></th>					
							<th><?php echo __('Tentative Date of Travel');?></th>	
							<th><?php echo __('No. of Travellers');?></th>						
							<th><?php echo __('Actions');?></th>
							</tr>
							</thead>
							<tbody>
						
						<?php  if (!empty($visa_apps)) {
							$sl=0;
							foreach ($visa_apps as $row) { //echo '<pre>'; print_r($username[$row['visa_app_group']['user_id']]); exit;
								$sl++;
								echo "<tr class = 'visa1' id = 'visa-".$row['visa_app_group']['group_id']."' onclick = 'show_app(".$row['visa_app_group']['group_id'].",\"".$row['visa_app_group']['group_no']."\")'>";
								echo '<input type = "hidden" id = "hdata-'.$row['visa_app_group']['group_id'].'" name = "hdata-'.$row['visa_app_group']['group_id'].'" value = 0 />';	
								echo "<input type = 'hidden' name = 'groupId' value = '".$row['visa_app_group']['group_id']."'/>";
								if($this->UserAuth->getGroupName() != 'User') { 
								echo "<td>";								
								if(isset($username[$row['visa_app_group']['user_id']])) echo $username[$row['visa_app_group']['user_id']]; else echo 'NA';
								echo "</td>";
								}								
								echo "<td>";
								if(isset($row['visa_app_group']['group_no'])){
								if(isset($row['visa_app_group']['app_type']) && strlen($row['visa_app_group']['app_type']) > 0)
								echo '<span class="label label-info">(Quick App)</span><br/>'; 
								echo $row['visa_app_group']['group_no'] . ' ';
								if(isset($app[$row['visa_app_group']['group_id']])){
								echo '<br/><strong>Application No. :  </strong>'; $name = '';
									/*foreach($app[$row['visa_app_group']['group_id']] as $a_id){
									if(strlen($name) > 0)  $name .= ' ,<br/>';
										$name .= $appNo[$row['visa_app_group']['group_id']][$a_id].' ';
									}*/
									$name .= $appNo[$row['visa_app_group']['group_id']];
									echo $name; 
								}
								
								}else echo 'NA';
								echo "</td>";
echo "<td>";
								if(isset($app[$row['visa_app_group']['group_id']])){ $name2 = '';
									foreach($app[$row['visa_app_group']['group_id']] as $a_id){
										if(strlen($name2) > 0)  $name2 .= ',<br/>';
										$name2 .=  $givenName[$row['visa_app_group']['group_id']][$a_id].' '.$surName[$row['visa_app_group']['group_id']][$a_id];
									}
									echo $name2; 
								}
								else echo 'NA';
								echo "</td>";	
																											
								echo "<td>";
								if(isset($visa_type[$row['visa_app_group']['visa_type']])) echo $visa_type[$row['visa_app_group']['visa_type']]; else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_app_group']['tent_date'])) echo date('d M Y',strtotime($row['visa_app_group']['tent_date'])); else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_app_group']['adult']) && isset($row['visa_app_group']['children']) && isset($row['visa_app_group']['infants'])) 
								echo 'Adult(s):'.$row['visa_app_group']['adult'].' <br/>Children:'.$row['visa_app_group']['children'].' <br/>Infants:'.$row['visa_app_group']['infants'] ;
								else echo 'NA';
								echo "</td>";
								
					echo "<td>";
					echo '<div class="btn-toolbar row-action">
                        <div class="btn-group">';
                        if($this->UserAuth->getGroupName() != 'Admin' && $row['visa_app_group']['tr_status'] == 1)
								echo "<a href='".$this->Html->url('/Users/apply_for_visa/'.$row['visa_app_group']['group_id'].'/'.$row['visa_app_group']['visa_type'])."' title= 'Apply For Visa' class='btn btn-success'><i class='icon-signout'></i></a>";
								if($this->UserAuth->getGroupName() != 'User'){
								if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_export') == 0){ }
								else echo "<a href='".$this->Html->url('/zipData/'.$row['visa_app_group']['group_no'])."' class='btn btn-success' title= 'Export Application' ><i class='icon-download-alt' ></i></a>";
								}
								if(isset($application) && $application == 'all') $view = 2; else $view = 1;
								if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_view') == 0){ }
                        		else echo "<a href='".$this->Html->url('/view_visa_app/'.$row['visa_app_group']['group_id'].'/'.$view)."' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
                        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_export') == 0){ }
                        		else echo "<a href='javascript:void(0)' onclick='get_receipt(".$row['visa_app_group']['group_id'].")' class ='btn btn-info' title= 'Print' ><i class='icon-print '></i></a>";								
								
						 echo '</div>
                      </div>';	
                      echo '<div class="btn-toolbar row-action" style = "margin-top:5px;">
                        <div class="btn-group">';	
                        		if($this->UserAuth->getGroupName() != 'Admin' && $row['visa_app_group']['tr_status'] == 1 || $row['visa_app_group']['tr_status'] == 0){
									echo "<a href='".$this->Html->url('/edit_visa_app/'.$row['visa_app_group']['group_id'])."' title= 'Edit' class='btn btn-danger'><i class='icon-edit'></i></a>";
									echo "<a href='".$this->Html->url('/edit_upload_data/'.$row['visa_app_group']['group_id'])."' title= 'Edit Upload Data' class='btn btn-primary'><i class='icon-cloud-upload'></i></a>";							
								}
								if($this->UserAuth->getGroupName() != 'User' && $row['visa_app_group']['tr_status'] != 5){
								if(isset($application) && $application == 'all') $view = 2; else $view = 1;
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_edit') == 0){ }
									else echo "<a href='".$this->Html->url('/edit_visa_app/'.$row['visa_app_group']['group_id'].'/'.$view)."' title= 'Edit' class='btn btn-danger'><i class='icon-edit'></i></a>";
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_edit') == 0){ }
									else echo "<a href='".$this->Html->url('/edit_upload_data/'.$row['visa_app_group']['group_id'].'/'.$view)."' class='btn btn-inverse' title= 'Edit Upload Data'><i class='icon-cloud-upload'></i></a>";							
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_delete') == 0){ }
									else echo "<a id = 'delete".$row['visa_app_group']['group_id']."' href='".$this->Html->url('/deleteVisa/'.$row['visa_app_group']['group_id'])."' onclick='return confirm(\"Are you sure want to delete?\")' title= 'Delete Visa' class='btn btn-warning'><i class='icon-remove'></i></a>";
								}
							
								if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_view') == 0){ }else{
										if((isset($tr_status[$row['visa_app_group']['tr_status']]) && $tr_status[$row['visa_app_group']['tr_status']] == 'Approved' && $row['visa_app_group']['visa_path'] != null && $row['visa_app_group']['visa_path'] != '')){
											echo "<a href='".$this->Html->url('/download/'.$row['visa_app_group']['group_id'])."' class='btn btn-danger' title= 'Download Visa'><i class='icon-download'></i></a>";
										}
									}
							
								echo "<span id = 'change1".$row['visa_app_group']['group_id']."' style = 'display:none' >";
								echo "<a href='".$this->Html->url('/download/'.$row['visa_app_group']['group_id'])."' title= 'Download Visa' class='btn btn-danger'><i class='icon-download'></i></a>";
								echo "</span>";
                        
                          echo '</div>
                      </div>';								
							echo "</td>";
						
								echo "</tr>";
							echo '<tr class = "hfirst" id = "hfirst-'.$row['visa_app_group']['group_id'].'" >';
							
							echo '<td colspan = "7" id = "hfirsttd-'.$row['visa_app_group']['group_id'].'" ></td>';
						
							echo '</tr>';
							}
						}?>
						
						
							
							</tbody>
					</table>
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
$(document).ready(function(){
	$('tr.hfirst').css('display','none');
});
function show_app(group,groupNo){
$('tr.visa1 td').css('background-color','#F9F9F9');

$('tr.hfirst').css('display','none');
var hdata = $('#hdata-'+group).val();
	if(hdata == 0){
		$('#hdata-'+group).val(1);
		$('#visa-'+group+' td').css('background-color','#F0FFFF');
		$("#hfirst-"+group).css('background-color','#F0FFFF');
		$.ajax({
	      url: "<?php echo $this->webroot; ?>users/getVisaApp",
	      dateType:'html',
	      type:'post',
	      data:'group='+group+'&groupNo='+groupNo,
	      success: function(data){	
	           $('td#hfirsttd-'+group).html(data);
	      }         
	    });
	    
		$("#hfirst-"+group).css('display','table-row');
		
	}else{
		//$('#visa-'+group+' td').css('background-color','#F9F9F9');
		//$("#hfirst-"+group).css('background-color','#F9F9F9');
		$('td#hfirsttd-'+group).html('');
		$('#hdata-'+group).val(0);
		$("#hfirst-"+group).css('display','none');
	}
}


   
</script>