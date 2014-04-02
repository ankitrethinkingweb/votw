<body style="margin-right:10px;padding:5px;font:small courier;line-height:4px;">
<table  style="width:100%;font-size:12px;" border="1" cellspacing="0" cellpadding="0">
							<thead>
							<tr>
							<th style="background:#6698FF;line-height:15px;width:1px;height:30px;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;line-height:15px;width:95px;height:30px;"><?php echo __('User Name');?></th>
							<?php
							//OKTB N Group No
							if($this->Session->read('User.group') == '1'){
							echo '<th style="background:#6698FF;line-height:15px;width:83px;height:30px;"> OKTB Group No </th>';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;line-height:15px;width: 82px;height:30px;"> OKTB No </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;line-height:15px;width: 82px;height:30px;"> OKTB Group No </th>';
							echo '<th style="background:#6698FF;line-height:15px;width: 82px;height:30px;"> OKTB No </th>';
							}
							
							//Date n Time
							if($this->Session->read('User.group') == '1'){
							echo '<th style="background:#6698FF;line-height:15px;width: 127px;height:30px;"> Applied Date | Time </th>';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;line-height:15px;width: 127px;height:30px;"> Applied Date </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;line-height:15px;width: 127px;height:30px;"> Applied Date | Time </th>';
							}
							?>
							<th style="background:#6698FF;line-height:15px;width: 300px;height:30px;"><?php echo __('Name of Applicant');?></th>
							<th style="background:#6698FF;line-height:15px;width: 100px;height:30px;"><?php echo __('Passport Number');?></th>
							<th style="background:#6698FF;line-height:15px;width: 90px;height:30px;"><?php echo __('Date/Time of Journey');?></th>
							<th style="background:#6698FF;line-height:15px;width: 120px;height:30px;"><?php echo __('Airline');?></th>
							<?php
							
							// PNR & Amount
							if($this->Session->read('User.group') == '1'){
							echo '';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;line-height:15px;width: 75px;height:30px;"> PNR No </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;line-height:15px;width: 75px;height:30px;"> PNR No </th>';
							}
							
							if($this->Session->read('User.group') == '1'){
							echo '';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;line-height:15px;width: 60px;height:30px;"> Amount </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;line-height:15px;width: 60px;height:30px;"> Amount </th>';
							}
							?>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {
								$sl++;

								echo "<tr>";

								echo '<td align="center" style="height:30px;">'.$sl.'</td>';
								echo '<td align="center" style="height:30px;">'.$row['username'].'</td>';
								//OKTB N Group No
								if($this->Session->read('User.group') == '1'){
								echo  '<td align="center" style="height:30px;">'.$row['group_no'].'</td>';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td align="center" style="height:30px;">'.$row['oktb_no'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo  '<td align="center" style="height:30px;">'.$row['group_no'].'</td>';
								echo '<td align="center" style="height:30px;">'.$row['oktb_no'].'</td>';
								}
								
								//Date n Time
								if($this->Session->read('User.group') == '1'){
								echo '<td align="center" style="height:30px;line-height:15px;">'.substr($row['appli_date_time'],0,10).' | '.substr($row['appli_date_time'],11,5).'</td>';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td align="center" style="height:30px;line-height:15px;">'.date('d-M-y', strtotime(substr($row['appli_date_time'],0,10))).'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td align="center" style="height:30px;line-height:15px;">'.substr($row['appli_date_time'],0,10).' | '.substr($row['appli_date_time'],11,5).'</td>';
								}

								echo '<td align="center" style="height:30px;line-height:15px;">'.$row['noa'].'</td>';
								echo '<td align="center" style="height:30px;">'.$row['passport'].'</td>';
								echo '<td align="center" style="height:30px;">'.$row['doj'].'</td>';
								echo '<td align="center" style="height:30px;">'.$row['air_name'].'</td>';
								// PNR & Amount
								if($this->Session->read('User.group') == '1'){
								echo '';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td align="center" style="height:30px;">'.$row['pnr'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td align="center" style="height:30px;">'.$row['pnr'].'</td>';
								}
								
								if($this->Session->read('User.group') == '1'){
								echo '';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td align="center" style="height:30px;">'.$row['amount'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td align="center" style="height:30px;">'.$row['amount'].'</td>';
								}

								echo "</tr>";
							}
						} ?>
					</tbody>
</table>
</body>