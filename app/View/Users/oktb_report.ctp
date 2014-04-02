<style>
.dataTables_filter{
text-align:left!important;
}
</style>

					<div class="widget-head blue">
							<h3>Search Results</h3>
						</div>
						
						<div class=" information-container">
						
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('User Name');?></th>
							<th><?php echo __('OKTB Number');?></th>
							<th><?php echo __('OKTB Group No');?></th>
							<th><?php echo __('Name of Applicant');?></th>
							<th><?php echo __('Passport No');?></th>
							<th><?php echo __('Date of Journey');?></th>
							<th><?php echo __('Airline');?></th>
							<th><?php echo __('PNR No.');?></th>
							<th><?php echo __('Amount');?></th>
							<th><?php echo __('Status');?></th>
							<th><?php echo __('Actions');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
								$sl++;

								echo "<tr>";

								echo "<td>".$row['username']."</td>";
								echo "<td>".$row['oktb_no']."</td>";
								echo "<td>".$row['group_no']."</td>";
								echo "<td>".$row['noa']."</td>";
								echo "<td>".$row['passport']."</td>";
								echo "<td>".$row['doj']."</td>";
								echo "<td>".$row['air_name']."</td>";
								echo "<td>".$row['pnr']."</td>";
								echo "<td>".$row['amount']."</td>";
								echo "<td>".$row['status']."</td>";
								echo '<td><a href="'.$this->webroot.'viewOktb/'.$row['oktbid'].'" target = "_blank" class="btn btn-primary" title="View"><i class="icon-zoom-in "></i></a></td>';
								echo "</tr>";
							}
						} ?>
					</tbody>
					</table>
					</div>
				
					
<script>
$(document).ready(function(){
var oTable =  $('#data-table').dataTable({
               		"aaSorting": [],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
             		"bSortCellsTop": true,
   			"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns":[0,1,2,3,4,5],    
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
    });
});
              
</script>