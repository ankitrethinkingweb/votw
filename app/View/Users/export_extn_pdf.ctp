<body style="padding:25px;font:small courier;line-height:4px;">
<table  style="width:100%;font-size:12px;" border="1" cellspacing="0" cellpadding="0">
							<thead>
							<tr >
							<th style="background:#6698FF;line-height:15px;width: 30px;height:30px;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;line-height:15px;width: 100px;height:30px;"><?php echo __('User Name');?></th>
							<th style="background:#6698FF;line-height:15px;width: 86px;height:30px;"><?php echo __('Application Date');?></th>
							<th style="background:#6698FF;line-height:15px;width: 98px;height:30px;"><?php echo __('Visa App No');?></th>
							<th style="background:#6698FF;line-height:15px;width: 98px;height:30px;"><?php echo __('Extension No');?></th>
							<th style="background:#6698FF;line-height:15px;width: 320px;height:30px;"><?php echo __('Name');?></th>
							<th style="background:#6698FF;line-height:15px;width: 70px;height:30px;"><?php echo __('Passport No');?></th>
							<th style="background:#6698FF;line-height:15px;width: 100px;height:30px;"><?php echo __('Visa');?></th>
							<th style="background:#6698FF;line-height:15px;width: 50px;height:30px;"><?php echo __('Ext Amount');?></th>

							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
								$sl++;

								echo "<tr>";

								echo "<td align='center' style='height:30px;'>".$sl."</td>";
								echo "<td align='center' style='height:30px;'>".$row['username']."</td>";
								echo "<td align='center' style='height:30px;'>".substr($row['appli_date'],0,10)."</td>";
								echo "<td align='center' style='height:30px;'>".$row['app_no']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['ext_no']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['name']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['passport_no']."</td>";
								echo "<td align='center' style='height:30px;line-height:15px;'>".$row['visa_type']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['ext_amount']."</td>
								</tr>";
							}
						} ?>
					</tbody>
					</table>
					</body>