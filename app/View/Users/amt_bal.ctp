<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Users Amount Balance</h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('SL');?></th>
							<th><?php echo __('Username');?></th>
							<th><?php echo __('Amount Balance');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($amtData)) {
							$sl=0;
							foreach ($amtData as $k=>$t) {
						
								$sl++;
								echo "<tr>";
								echo "<td>".$sl."</td>";
								if(strlen($t['users']['username']) > 0) echo "<td>".$t['users']['username']."</td>";	else echo "<td>Not Mentioned</td>";

								if(strlen($t['user_wallet']['amount']) > 0 ){ echo "<td><a target = '_blank' href = '".$this->webroot."agent_trans/".$t['users']['id']."' >".$t['user_wallet']['amount']." ";
if(isset($currency[$t['users']['currency']])) 
echo $currency[$t['users']['currency']];
else echo 'INR';
echo "</a></td>";	}else echo "<td>Not Mentioned</td>";
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
$(function () {
	$('#data-table').dataTable({
	 "sDom": "<'row-fluid'<'span6'l><'span6'fp>r>t<'row-fluid'<'span6'i><'span6'p>>",
	});
});
</script>


