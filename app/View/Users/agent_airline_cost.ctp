<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Airline Cost Settings</h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-striped table-bordered" id="data">
							<thead>
							<tr>
							<th><?php echo __('SL');?></th>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('Username');?></th>
							<th><?php echo __('Email');?></th>
							<th><?php echo __('Updated Date');?></th>
							<th><?php echo __('Action');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($users)) {
							$sl=0;
							foreach ($users as $row) {
						
								$sl++;
								echo "<tr>";
								echo "<td>".$sl."</td>";
								echo "<td>";
								if(isset($bus_name[$row['users']['id']])) 
								echo $bus_name[$row['users']['id']] ;
								else echo 'Not Mentioned';
								echo "</td>";
								echo "<td>".h($row['users']['username'])."</td>";
								echo "<td>".h($row['users']['email'])."</td>";
								echo "<td>";
								if(isset($cr_date[$row['users']['id']])) 
								echo date('d-M-Y',strtotime($cr_date[$row['users']['id']])) ;
								else echo 'Not Mentioned';
								echo "</td>";
								
								echo "<td>"; ?>
								<a href='javascript:void;' >
<button title= 'View' onclick = 'view(<?php echo $row["users"]["id"]; ?>)' type='submit' class='alert-box btn btn-round-min btn-warning space'><span><i class='icon-zoom-in '></i></span></button></a>
							<a href='<?php echo $this->Html->url("/change_airline_cost/".$row["users"]["id"]);?>' >
									<button title= 'cost' type='submit' class='btn btn-round-min btn-success'><span><i class='icon-edit'></i></span></button>
									</a>
									<?php
									
								echo "</td>";
								echo "</tr>";
							}
						} ?>
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

function view(id){
$.ajax({
	      url: "<?php echo $this->webroot; ?>viewAirlineCost",
	      dateType:'html',
	      type:'post',
	      data:'id='+id,
	      success: function(data){	    
	      	 bootbox.alert(data, function () {
        
   			 });
	      },         
	    })
}

 $(function () {
                $('#data').dataTable({
                  "sDom": "<'row-fluid'<'span6'l><'span6'fp>r>t<'row-fluid'<'span6'i><'span6'p>>",
                });
            });
		
</script>
