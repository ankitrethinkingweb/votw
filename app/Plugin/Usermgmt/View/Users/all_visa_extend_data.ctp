<style>
.drop_width{
width:164px;
}

.dataTables_filter{
text-align:left!important;
}

.form-horizontal textarea.error,
{
border:1px solid red;
}
span.errorMsg{
background-color:#DF302A!important;
}
</style>
<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>

<p><a class="btn btn-extend" href="<?php echo $this->webroot; ?>extension_date" >Add Date of Exit</a></p>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
					<div class="widget-head orange">
							<h3>Extension Date Logs</h3>
						</div>
						<div class=" information-container">
						 <?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('User Name');?></th>
							<th><?php echo __('App. No.');?></th>
							<th><?php echo __('Name / Passport No. ');?></th>
							<th><?php echo __('Visa Type');?></th>
							<th><?php echo __('Tentative Date of Travel');?></th>	
							<th><?php echo __('Date of Exit');?></th>
							<th><?php echo __('Last Date');?></th>
							<th><?php echo __('Action');?></th>
							</tr>
							</thead>
							<tbody>
			<?php   if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
							
								$sl++;
								
								echo "<tr id = 'visa-".$row['c']['app_id']."'>";	
								
								echo "<td>";								
								if(isset($row['b']['username'])) echo $row['b']['username']; else echo 'NA';
								echo "</td>";
									
								echo "<td>";								
								if(isset($row['c']['app_no'])) echo $row['c']['app_no']; else echo 'NA';
								echo "</td>";
									
								echo "<td>";
								if(isset($row['c']['first_name']) && isset($row['c']['last_name']) && isset($row['c']['passport_no']))
								echo $row['c']['first_name'] .' '. $row['c']['last_name'].' / '.$row['c']['passport_no'];
								else
								echo 'NA';
								echo "</td>";
													
								echo "<td>";
								if(isset($visa_type[$row['a']['visa_type']]))
								echo $visa_type[$row['a']['visa_type']];
								else
								echo 'NA';
								echo "</td>";
							
								echo "<td>";
								if(isset($row['a']['tent_date']) and strlen($row['a']['tent_date']) > 0)
								echo date('d M Y',strtotime($row['a']['tent_date']));
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['c']['date_of_exit']) and strlen($row['c']['date_of_exit']) > 0)
								echo date('d M Y',strtotime($row['c']['date_of_exit']));
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['c']['last_doe']) and strlen($row['c']['last_doe']) > 0)
								echo date('d M Y',strtotime($row['c']['last_doe']));
								else echo 'NA';
								echo "</td>";
								
								echo '<td><div class="btn-toolbar row-action"><div class="btn-group">';
								echo "<a href='".$this->webroot."editExtCost/".$row['c']['app_no']."' class='btn btn-warning' data-original-title='Edit Extension' ><i class='icon-pencil'></i></a>";
								echo "<a href='javascript:void(0);' class='btn btn-danger' data-original-title='Delete Extension' onclick='delete_ext_date(".$row['c']['app_id'].");'><i class='icon-remove-sign'></i></a>";
								echo '</div></td>';
                               							
								
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
               		"aaSorting": [],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
             		"bSortCellsTop": true,
   			"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns":[0,1,2,3],    
	            },
	            {
	               "sExtends": "xls",
	               "mColumns": [0,1,2,3],   
	            },
	            {
					"sExtends": "pdf",
		            "mColumns": [0,1,2,3],
				},
			]
		}
    });
});

function delete_ext_date(g_id)
       {
       if(confirm("Do you really want to delete this extension?")){
      		$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/delete_ext_date",
				dateType:'html',
				type:'post',
				data:'id='+g_id,
				success: function(data){
					if(data != 'Error')
						{
						$('#visa-'+g_id).html('');
						alert('Deleted Successfully');
						}else alert('Some Error Occured');
					}
				});
				}
				return false;
       }
</script>