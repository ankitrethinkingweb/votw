<table border="1">
							<thead >
							<tr>
							<th style="background:#6698FF;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;"><?php echo __('Applied Date');?></th>
							<th style="background:#6698FF;"><?php echo __('User Name');?></th>
							<th style="background:#6698FF;"><?php echo __('Application No.');?></th>
							<th style="background:#6698FF;"><?php echo __('Name of Applicant');?></th>
							<th style="background:#6698FF;"><?php echo __('Passport Number');?></th>
							<th style="background:#6698FF;"><?php echo __('Visa Type');?></th>
							<th style="background:#6698FF;"><?php echo __('Tentative Date');?></th>
							<th style="background:#6698FF;"><?php echo __('Amount');?></th>
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

								echo "<td>".$sl."</td>";
								echo "<td>".$row['apply_date']."</td>";
								echo "<td>".$row['username']."</td>";
								echo "<td>".$row['app_no']."</td>";
								echo "<td>".$row['app_name']."</td>";
								echo "<td>".$row['pass_no']."</td>";
								echo "<td>".$row['visa_type']."</td>";
								echo "<td>".$row['tent_date']."</td>";
								echo "<td>".$row['amount']."</td>";
								echo "</tr>";
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
        	header ('Content-Disposition: attachment;filename="Visa Report.xls"');
        	header ("Content-Description: Generated Report" );
