<style>
.dataTables_filter{
text-align:left!important;
}

.bootboxWidth{
left:29%!important;
width:1118px!important;
}
</style>

<p >
	<a class="btn btn-extend" href="<?php echo $this->webroot; ?>user_roles" >Add New User</a>
</p>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>All User Roles</h3>
						</div>

						 <div class=" information-container">
					
						<?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('User Name');?></th>								
							<th><?php echo __('Email Id');?></th>	
							<th><?php echo __('Contact No');?></th>						
							<th><?php echo __('Applied Date');?></th>
							<th><?php echo __('Actions');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($user_roles)) {
							$sl=0;
							foreach ($user_roles as $row) { //echo '<pre>'; print_r($row); exit;
								$sl++;
								echo "<tr>";
								
								echo "<td>";
								if(isset($row['user_roles']['role_name'])){
									echo $row['user_roles']['role_name'];									
								}else echo 'NA';
								echo "</td>";

								echo "<td>";
								if(isset($row['user_roles']['role_username'])){
									echo $row['user_roles']['role_username'];									
								}else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['user_roles']['role_email'])){
									echo $row['user_roles']['role_email'];									
								}else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['user_roles']['role_contact'])){
									echo $row['user_roles']['role_contact'];									
								}else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['user_roles']['role_date'])){
									echo $row['user_roles']['role_date'];									
								}else echo 'NA';
								echo "</td>";
								
					echo "<td>";
					echo '<div class="btn-toolbar row-action">
                        <div class="btn-group">';
	                        echo "<a href='javascript:void(0)' onclick = 'access_right(".$row['user_roles']['role_id'].")' class='btn btn-warning' title= 'Access Rights'><i class='icon-lock'></i></a>";
	                        echo "<a href='".$this->Html->url('/edit_user_roles/'.$row['user_roles']['role_id'])."' class='btn btn-info' title= 'Edit'><i class='icon-pencil'></i></a>";
	                        echo "<a href='".$this->webroot."changeUserPassword/".$row['user_roles']['role_id']."/1' target = '_blank' class='btn btn-success' title= 'Change Password'><i class='icon-lock'></i></a>";
	                        echo "<a href='".$this->Html->url('/delete_user_roles/'.$row['user_roles']['role_id'])."' onclick='return confirm(\"Are you sure want to delete?\")' class='btn btn-danger' title= 'Delete'><i class='icon-remove'></i></a>";
                        echo '</div>
                      </div>';	
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
 var oTable =  $('#data-table').dataTable({
	             
                    "sDom":  "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                    "bSortCellsTop": true,
                	"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,2,3,4,5],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5],
	                         
	            },
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ 
					{
						 "sExtends": "csv",
		                "mColumns": [0,1,2,3,4,5],   
					},
					{
						 "sExtends": "xls",
		                "mColumns": [0,1,2,3,4,5],   
					},
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,2,3,4,5],   
					},				
					]
				}
			]
		}
                });
              
            });

      function access_right(role_id){
      $.ajax({
	      url: "<?php echo $this->webroot; ?>access_rights",
	      dateType:'html',
	      type:'post',
	      data:'role_id='+role_id,
	      success: function(data){
	      if(data != 'Error')	    
	      	 bootbox.alert(data, function () {  
	      	
	      	 	});
	      },         
	    })
   
      }
</script>