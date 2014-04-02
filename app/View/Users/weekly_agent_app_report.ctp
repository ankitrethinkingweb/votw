<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body style="font:normal courier;">

<center><h3>Weekly Report</h3></center>

<div class="widget-container">

<div style = "width:45%;float:left;">
<p ><span style= "font-weight:bold;"><?php if(isset($user['bus_name'])) echo $user['bus_name'];?></p>
<p style="line-height:3px;"><?php if(isset($user['city'])) echo $user['city']; if(isset($user['pin'])) echo ' - '.$user['pin']; ?></p>
<p style="line-height:3px;"><?php if(isset($user['state'])) echo $user['state'];?></p>
<p style="line-height:3px;"><?php if(isset($user['mob_no'])) echo "Ph No. : ".$user['mob_no'];?></p>
</div>
<div style = "float:left;">
<b>Period Covered </b>  : <?php echo date('d-m-Y', strtotime('-7 days')).' to '. date('d-m-Y')  ?><br/>
<b>Cash A/c Balance </b>: <?php if(isset($user['wallet'])) echo $user['wallet']; if(isset($user['curr'])) echo ' '.$user['curr']; ?>
</div>
<div style = "clear:both;"></div>

						 
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-bordered" border = 1 style=" border-collapse: collapse;" id="data-table">
							<thead>
							<tr>		
							<th style = "padding: 6px;"><?php echo __('Sr. No.');?></th>					
							<th style = "padding: 6px;"><?php echo __('Date');?></th>
							<th style = "padding: 6px;"><?php echo __('App. No.');?></th>
							<th style = "padding: 6px;"><?php echo __('Particulars');?></th>
							<th style = "padding: 6px;"><?php echo __('Debit');?></th>
							<th style = "padding: 6px;"><?php echo __('Credit');?></th>
							</tr>
							<tr>		
							<th style = "padding: 6px;">&nbsp;</th>					
							<th style = "padding: 6px;">&nbsp;</th>
							<th style = "padding: 6px;">&nbsp;</th>
							<th style = "padding: 6px;">&nbsp;</th>
							<th style = "padding: 6px;">Opening Balance</th>
							<th style = "padding: 6px;"><?php if(isset($user['openBal'])) echo $user['openBal']; if(isset($user['curr'])) echo ' '.$user['curr'];?></th>
							</tr>
							</thead>
							<tbody>
			<?php if (!empty($res)) { //echo '<pre>'; print_r($res); exit;
							$sl=0;
							foreach ($res as $k=>$row) {
								$sl++;
								echo "<tr>";
								echo "<td style = 'padding: 6px;'>".$sl."</td>";
								if(isset($row['date'])) echo "<td style = 'padding: 6px;'>".date('d M Y',strtotime($row['date']))."</td>"; else echo "<td style = 'padding: 6px;'>-</td>";
								
								if(isset($row['group_no'])){ echo "<td style = 'padding: 6px;'>";
								if(isset($row['added_by']) && $row['added_by'] == 1)
								echo "<i class = 'icon-info-sign' style = 'color:red;' title = 'Offline' ></i>";
								echo " ".$row['group_no']."</td>"; 
								}else echo "<td style = 'padding: 6px;'>-</td>";	
								echo "<td style = 'padding: 6px;'>";
								if(isset($row['type'])){ echo $row['type']; if(isset($row['app_no'])) echo " ".$row['app_no']; 
								echo "</td>";
								}else echo "<td style = 'padding: 6px;'>-</td>";
								
								if(isset($row['debit'])) echo "<td style = 'padding: 6px;'>".$row['debit']."</td>"; else echo "<td style = 'padding: 6px;'>-</td>";
								
								if(isset($row['credit'])) echo "<td style = 'padding: 6px;'>".$row['credit']."</td>"; else echo "<td style = 'padding: 6px;'>-</td>";
								
								echo "</tr>";
							}
						} ?>
					</tbody>
					</table>
					</div>
		</body>
</html>