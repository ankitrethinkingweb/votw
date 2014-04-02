<style>
.dataTables_filter{
text-align:left!important;
}
</style>

					<div class="widget-head blue">
							<h3>Search Results</h3>
						</div>
				
						<div class=" information-container">
							<table class="responsive table table-striped table-bordered data-table" >
							<thead>
							<tr>
							<th><?php echo __('User Name');?></th>
							<th><?php echo __('Application No.');?></th>
							<th><?php echo __('Group No.');?></th>
							<th><?php echo __('Name of Applicant');?></th>
							<th><?php echo __('Passport Number');?></th>
							<th><?php echo __('Profession');?></th>
							<th><?php echo __('Visa Type');?></th>
							<th><?php echo __('Tentative Date');?></th>
							<th><?php echo __('Date of Exit');?></th>
							<th><?php echo __('Amount');?></th>
							<th><?php echo __('Status');?></th>
							<th><?php echo __('Admin Status');?></th>
							<th><?php echo __('Actions');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
								$sl++;
								if(strlen($row['admin_status']) > 0){
								$a_status = $row['admin_status'];
								} else {
								$a_status = 'NA';
								}
								echo "<tr>";

								echo "<td>".$row['off'].$row['username']."</td>";
								echo "<td>".$row['app_no']."</td>";
								echo "<td>".$row['group_no']."</td>";
								echo "<td>".$row['app_name']."</td>";
								echo "<td>".$row['pass_no']."</td>";
								echo "<td>".$row['profession']."</td>";
								echo "<td>".$row['visa_type']."</td>";
								echo "<td>".$row['tent_date']."</td>";
								echo "<td>".$row['date_of_exit']."</td>";
								echo "<td>".$row['amount']."</td>";
								echo "<td>".$row['status']."</td>";
								echo "<td>".$a_status ."</td>";
								echo "<td><a href='".$this->Html->url('/view_visa_app/'.$row['group_id'])."' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a></td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
					</table>
					</div>
					
					
<script>
$(document).ready(function(){
var oTable =  $('.data-table').dataTable({
               		"aaSorting": [],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
             		"bSortCellsTop": true,
   			"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns":[0,1,3,5,6,8],    
	            },
	            {
	               "sExtends": "xls",
	               "mColumns": [0,1,3,5,6,8],   
	            },
	            {
					"sExtends": "pdf",
		            "mColumns": [0,1,3,5,6,8],
				},
			]
		}
    });
});
              
</script>