
							<table border="1">
							<thead>
							<tr>
							<th style="background:#6698FF;"><?php echo __('Sr No.');?></th>
							<th style="background:#6698FF;"><?php echo __('User Name');?></th>
							<?php
							//OKTB N Group No
							if($this->Session->read('User.group') == '1'){
							echo '<th style="background:#6698FF;"> OKTB Group No </th>';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;"> OKTB No </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;"> OKTB Group No </th>';
							echo '<th style="background:#6698FF;"> OKTB No </th>';
							}
							
							//Date n Time
							if($this->Session->read('User.group') == '1'){
							echo '<th style="background:#6698FF;"> Applied Date | Time </th>';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;"> Applied Date </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;"> Applied Date | Time </th>';
							}
							?>
							<th style="background:#6698FF;"><?php echo __('Name of Applicant');?></th>
							<th style="background:#6698FF;"><?php echo __('Passport Number');?></th>
							<th style="background:#6698FF;"><?php echo __('Date/Time of Journey');?></th>
							<th style="background:#6698FF;"><?php echo __('Airline');?></th>
							<?php
							
							// PNR & Amount
							if($this->Session->read('User.group') == '1'){
							echo '';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;"> PNR No </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;"> PNR No </th>';
							}
							
							if($this->Session->read('User.group') == '1'){
							echo '';
							} elseif($this->Session->read('User.group') == '2'){
							echo '<th style="background:#6698FF;"> Amount </th>';
							} elseif($this->Session->read('User.group') == '3'){
							echo '<th style="background:#6698FF;"> Amount </th>';
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

								echo "<td>".$sl."</td>";
								echo "<td>".$row['username']."</td>";
								//OKTB N Group No
								if($this->Session->read('User.group') == '1'){
								echo  '<td>'.$row['group_no'].'</td>';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td>'.$row['oktb_no'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo  '<td>'.$row['group_no'].'</td>';
								echo '<td>'.$row['oktb_no'].'</td>';
								}
								
								//Date n Time
								if($this->Session->read('User.group') == '1'){
								echo '<td>'.substr($row['appli_date_time'],0,10).' | '.substr($row['appli_date_time'],11,5).'</td>';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td>'.date('d-M-y', strtotime(substr($row['appli_date_time'],0,10))).'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td>'.substr($row['appli_date_time'],0,10).' | '.substr($row['appli_date_time'],11,5).'</td>';
								}

								echo "<td>".$row['noa']."</td>";
								echo "<td>".$row['passport']."</td>";
								echo "<td>".$row['doj']."</td>";
								echo "<td>".$row['air_name']."</td>";
								// PNR & Amount
								if($this->Session->read('User.group') == '1'){
								echo '';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td>'.$row['pnr'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td>'.$row['pnr'].'</td>';
								}
								
								if($this->Session->read('User.group') == '1'){
								echo '';
								} elseif($this->Session->read('User.group') == '2'){
								echo '<td>'.$row['amount'].'</td>';
								} elseif($this->Session->read('User.group') == '3'){
								echo '<td>'.$row['amount'].'</td>';
								}

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
        	header ('Content-Disposition: attachment;filename="OKTB Report.xls"');
        	header ("Content-Description: Generated Report" );