
<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3><?php if($app == 1) { echo "Approve Users"; }else { ?>All Users<?php } ?></h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('SL');?></th>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('Username');?></th>
							<th><?php echo __('Email');?></th>
							<th><?php echo __('Group');?></th>
							<th><?php echo __('Status');?></th>
							<th><?php echo __('Approval Status');?></th>
							<th><?php echo __('Created');?></th>
							<th><?php echo __('Action');?></th>
							</tr>
							</thead>
							<tbody>
			<?php if(!empty($users)) {
							$sl=0;
							foreach ($users as $row) {
								$sl++;
								echo "<tr>";
								echo "<td>".$sl."</td>";
								echo "<td>";
								if(isset($bus_name[$row['User']['id']])) 
								echo $bus_name[$row['User']['id']] ;
								else echo 'Not Mentioned';
								echo "</td>";
								echo "<td>".h($row['User']['username'])."</td>";
								echo "<td>".h($row['User']['email'])."</td>";
								echo "<td>".h($row['UserGroup']['name'])."</td>";
								echo "<td>";
								if ($row['User']['active']==1) {
									echo "Active";
								} else {
									echo "Inactive";
								}
								echo"</td>";
								echo "<td>";
								if ($row['User']['approve']==1) {
									echo "Approved";
								} else {
									echo "Not Approved";
								}
								echo"</td>";
								echo "<td>".date('d-M-Y',strtotime($row['User']['created']))."</td>";
								echo "<td>";
								echo "<a href='".$this->Html->url('/viewUser/'.$row['User']['id'])."'><button title= 'View' type='submit' class='btn btn-round-min btn-warning space'><span><i class='icon-zoom-in '></i></span></button></a>";
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_edit') == 0){}else
									echo "<a href='".$this->Html->url('/editUser/'.$row['User']['id'])."'><button title= 'Edit' type='submit' class='btn btn-round-min btn-inverse space'><span><i class='icon-edit'></i></span></button></a>";
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_change_pswd') == 0){}else
									echo "<a href='".$this->Html->url('/changeUserPassword/'.$row['User']['id'])."' target = '_blank'><button title= 'Change Password' type='submit' class='btn btn-round-min btn-inverse space'><span><i class='icon-cogs'></i></span></button></a>";
									
									if ($row['User']['id']!=1) {
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_status') == 0){}else{
										if($row['User']['approve'] ==  1){ 
								 	echo "<span id= 'change".$row['User']['id']."'><a href='#' onclick = 'approve({$row['User']['id']},0)'><button id = 'appr_button".$row['User']['id']."' title= 'Disapprove User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$row['User']['id']."' class='icon-thumbs-down'></i></span></button></a></span>"; 
									 }else{
										echo "<span id= 'change".$row['User']['id']."'><a href='#' onclick = 'approve({$row['User']['id']},1)'><button id = 'appr_button".$row['User']['id']."' title= 'Approve User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$row['User']['id']."' class='icon-thumbs-up'></i></span></button></a></span>";
									 }		
								 }			
								 if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_status') == 0){}else{							
									if ($row['User']['active']==0) {
										echo "<a href='".$this->Html->url('/makeActive/'.$row['User']['id'])."'><button title= 'Make Active' type='submit' class='btn btn-round-min btn btn-info space'><span><i class='icon-ok-sign'></i></span></button></a>";
									}
								}
									?>
									<?php  if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.login_as_agent') == 0){}else{	?>
									<a href='<?php echo $this->Html->url('/login_as_agent/'.$row['User']['id']);?>' onclick="return confirm('Are you sure you want to login ? Admin will logout.')" target="_blank">
									<button title= 'Login As Agent' type='submit' class='btn btn-round-min btn-info'><span><i class='icon-unlock'></i></span></button>
									</a><?php } ?>
									<?php  if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_delete') == 0){}else{	?>
									<a href='<?php echo $this->Html->url('/deleteUser/'.$row['User']['id']);?>' onclick="return confirm('Are you sure you want to delete this user?')" >
									<button title= 'Delete' type='submit' class='btn btn-round-min btn-danger'><span><i class='icon-remove-sign'></i></span></button>
									</a><?php } ?>
									<?php
									}
								echo "</td>";
								echo "</tr>";
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
 $(function () {
                $('#data-table').dataTable({
                    "sDom": "<'row-fluid'<'span6'l><'span6'fp>r>t<'row-fluid'<'span6'i><'span6'p>>"
                    /*"oTableTools": {
			"aButtons": [
				"copy",
				"print",
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			]
		}*/
                });
            });
			
			  function approve(id,status){
     
       	$.ajax({
	      url: "<?php echo $this->webroot; ?>/approve",
	      dateType:'html',
	      type:'post',
	      data:'id='+id+'&status='+status,
	      success: function(data){	    
	      	$("#change"+id).html(data);
	      },
         
	    });
	    return false;
       }     
</script>
