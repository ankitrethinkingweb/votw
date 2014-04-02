<!--<body style="padding:25px;font:small courier;line-height:4px;">
<div><img src="<?=WWW_ROOT?>images/logo.jpg" width="128px" height="50px" align="left" /></div>
<div align="right"><b>Export Date : <?=date('Y-M-d', time())?></b></div><br/><br/><br/><br/>-->
<table  style="width:100%;font-size:12px;" border="1" cellspacing="0" cellpadding="0">
							<thead >
							<tr>
							<th style="background:#6698FF;line-height:15px;width:1px;height:30px;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;line-height:15px;width:80px;height:30px;"><?php echo __('Applied Date');?></th>
							<th style="background:#6698FF;line-height:15px;width:140px;height:30px;"><?php echo __('User Name');?></th>
							<th style="background:#6698FF;line-height:15px;width:75px;height:30px;"><?php echo __('Application No.');?></th>
							<th style="background:#6698FF;line-height:15px;width:300px;height:30px;"><?php echo __('Name of Applicant');?></th>
							<th style="background:#6698FF;line-height:15px;width:85px;height:30px;"><?php echo __('Passport Number');?></th>
							<th style="background:#6698FF;line-height:15px;width:200px;height:30px;"><?php echo __('Visa Type');?></th>
							<th style="background:#6698FF;line-height:15px;width:71px;height:30px;"><?php echo __('Tentative Date');?></th>
							<th style="background:#6698FF;line-height:15px;width: 50px;height:30px;"><?php echo __('Amount');?></th>
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

								echo "<td align='center' style='height:30px;'>".$sl."</td>";
								echo "<td align='center' style='height:30px;'>".$row['apply_date']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['username']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['app_no']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['app_name']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['pass_no']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['visa_type']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['tent_date']."</td>";
								echo "<td align='center' style='height:30px;'>".$row['amount']."</td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
					</table>

</body>