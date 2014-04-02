<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>OKTB Airline Cost</h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('SL');?></th>
							<th><?php echo __('Airline Name');?></th>
							<th><?php echo __('Cost Price'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )' ; }?></th>
							<th><?php echo __('Selling Price'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )' ; }?></th>
							
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($airline)) {
							$sl=0;
							foreach ($airline as $k=>$t) {
						
								$sl++;
								echo "<tr>";
								echo "<td>".$sl."</td>";
								echo "<td>".$t."</td>";
								echo "<td>".$cost[$k]."</td>";
								echo "<td>".$scost[$k]."</td>";
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



