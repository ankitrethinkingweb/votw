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
							<th><?php echo __('Application Date');?></th>
							<th><?php echo __('Visa App No');?></th>
							<th><?php echo __('Extension No');?></th>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('Passport No');?></th>
							<th><?php echo __('Visa');?></th>
							<th><?php echo __('Ext Amount');?></th>
							<th><?php echo __('Ext Status');?></th>
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
								echo "<td>".substr($row['appli_date'],0,10)."</td>";
								echo "<td>".$row['app_no']."</td>";
								echo "<td>".$row['ext_no']."</td>";
								echo "<td>".$row['name']."</td>";
								echo "<td>".$row['passport_no']."</td>";
								echo "<td>".$row['visa_type']."</td>";
								echo "<td>".$row['ext_amount']."</td>";
								echo "<td>".$row['status']."</td><td>";
								if($row['app_no'] != 'NA')
								echo "<a href='".$this->Html->url('/view_visa_app/'.$row['group_id'])."' target = '_blank' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
								else
								echo "<a href='javascript:void(0);' onclick = 'view_ext_details(".$row['ext_id'].")' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
								echo "</td></tr>";
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
	                "mColumns":[0,1,2,3,4,5,6,7],    
	            },
	            {
	               "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5,6,7],   
	            },
	            {
					"sExtends": "pdf",
		            "mColumns": [0,1,2,3,4,5,6,7],
				},
			]
		}
    });
});
              
			  function view_ext_details(ext){
       
       	$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/view_ext",
				dateType:'html',
				type:'post',
				data:'id='+ext,
				success: function(data){
					if(data != 'Error')
						{
							bootbox.alert(data); 	
						}
					}
				});
				return false;
       }
</script>