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

.user_roles_table td{
padding-left:15px;
}

#visa_type_chzn, #oktb_airline_chzn,#visa_type_chzn .chzn-drop,#oktb_airline_chzn .chzn-drop {
width : 321px!important;
}


</style>

		<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head orange">
							<h3> Access Rights </h3>
						</div>
						<div class="widget-container">
							<?php echo $this->Session->flash(); ?>
					
					<?php if(isset($meta_info)){  ?>
								<table id = "access" class = "table table-bordered user_roles_table"> 
			<thead>
        <tr class = "table-heading">
          <th class="center heading"><span class="plan"><center>Rights</center></span><br/> <span class="price">Access To</span></th>
          <th class="center divPop"> <span class="plan">Agent</span>
          <th class="center divPop"> <span class="plan">Visa Application</span>
          <th class="center"> <span class="plan">OKTB Application</span> 
          <th class="center divPop"> <span class="plan">Extension Application</span> 
          <th class="center divPop"> <span class="plan">Transactions</span> 
         </tr>
      </thead>
      				<tbody>
								<tr>
								<th>Add</th>
									<td><?php if(isset($meta_info['agent_add'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['agent_add']== 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
									<td><?php if(isset($meta_info['visa_add'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_add']== 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
									<td><?php if(isset($meta_info['oktb_add'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_add'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  </td> <?php } ?></td> 
									<td><?php if(isset($meta_info['ext_add'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['ext_add'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  </td> <?php } ?></td>
									<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>View</th>
									<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
									<td><?php if(isset($meta_info['visa_view'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_view']== 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
									<td><?php if(isset($meta_info['oktb_view'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_view'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  </td> <?php } ?></td> 
									<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
									<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Edit</th>
								<td><?php if(isset($meta_info['agent_edit'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['agent_edit']== 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
								<td><?php if(isset($meta_info['visa_edit'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_edit']== 1) echo 'selected.png'; else echo 'not_selected.png'?>" />   <?php } ?></td>
								<td><?php if(isset($meta_info['oktb_edit'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_edit'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								<td><?php if(isset($meta_info['ext_edit'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['ext_edit'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Delete</th>
								<td><?php if(isset($meta_info['agent_delete'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['agent_delete'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['visa_delete'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_delete'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['oktb_delete'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_delete'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['ext_delete'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['ext_delete'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Change Status</th>
								<td><?php if(isset($meta_info['agent_status'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['agent_status'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['visa_status'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_status'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['oktb_status'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_status'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><?php if(isset($meta_info['ext_status'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['ext_status'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Change Password</th>
								<td><?php if(isset($meta_info['agent_change_pswd'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['agent_change_pswd'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Login as Agent</th>
								<td><?php if(isset($meta_info['login_as_agent'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['login_as_agent'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>Download Documents</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>								
								<td><?php if(isset($meta_info['visa_export'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_export'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?> </td>
								<td><?php if(isset($meta_info['oktb_download'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['oktb_download'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?> </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								</tr>
								
								<tr>
								<th>User Amount Balance</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['trans_amt_bal'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['trans_amt_bal'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								</tr>
								
								<tr>
								<th>Bank Transactions</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['trans_bank'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['trans_bank'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
								</tr>
								
								<tr><th>Visa Cost Settings</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['visa_cost_settings'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['visa_cost_settings'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
								</tr>
								
								<tr><th>Airline Cost Settings</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['airline_cost_settings'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['airline_cost_settings'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /> <?php } ?></td> 
								</tr>
								
								<tr><th>Extension Cost Settings</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['ext_cost_settings'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['ext_cost_settings'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" /><?php } ?></td>
								</tr>
								
								<tr>
								<th>Set Credit Limit</th>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><img src = "<?php echo $this->webroot; ?>app/webroot/images/not_selected.png" />  </td>
								<td><?php if(isset($meta_info['set_credit_limit'])){ ?><img src = "<?php echo $this->webroot; ?>app/webroot/images/<?php if($meta_info['set_credit_limit'] == 1) echo 'selected.png'; else echo 'not_selected.png'?>" />  <?php } ?></td>
								</tr>
								
								
					</tbody>					
								</table>
								<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
<script>
$(document).ready(function(){
//$('#access').dataTable();
});

</script>