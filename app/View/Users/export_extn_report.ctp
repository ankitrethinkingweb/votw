
							<table border="1" >
							<thead>
							<tr >
							<th style="background:#6698FF;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;"><?php echo __('User Name');?></th>
							<th style="background:#6698FF;"><?php echo __('Application Date');?></th>
							<th style="background:#6698FF;"><?php echo __('Visa App No');?></th>
							<th style="background:#6698FF;"><?php echo __('Extension No');?></th>
							<th style="background:#6698FF;"><?php echo __('Name');?></th>
							<th style="background:#6698FF;"><?php echo __('Passport No');?></th>
							<th style="background:#6698FF;"><?php echo __('Visa');?></th>
							<th style="background:#6698FF;"><?php echo __('Ext Amount');?></th>

							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
								$sl++;

								echo "<tr>";

								echo "<td>".$sl."</td>";
								echo "<td>".$row['username']."</td>";
								echo "<td>".substr($row['appli_date'],0,10)."</td>";
								echo "<td>".$row['app_no']."</td>";
								echo "<td>".$row['ext_no']."</td>";
								echo "<td>".$row['name']."</td>";
								echo "<td>".$row['passport_no']."</td>";
								echo "<td>".$row['visa_type']."</td>";
								echo "<td>".$row['ext_amount']."</td>
								</tr>";
							}
						} ?>
					</tbody>
					</table>
				<?php
        	header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
        	header ("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
        	header ("Cache-Control:  max-age=0, must-revalidate");
        	header ("Pragma: no-cache");
        	header ("Content-type: application/vnd.ms-excel");
        	header ('Content-Disposition: attachment;filename="Extension Report.xls"');
        	header ("Content-Description: Generated Report" );