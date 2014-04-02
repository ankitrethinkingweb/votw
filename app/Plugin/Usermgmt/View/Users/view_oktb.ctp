 <style>
 .heading{
 font-weight:bold;
 }
 </style>
 
 <div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
						<?php if(isset($oktb_apps) && is_array($oktb_apps)){ foreach ($oktb_apps as $row) {?>
							<h3>OKTB Application : <?php if(isset($row['oktb_details']['oktb_group_no']) && strlen($row['oktb_details']['oktb_group_no']) > 0 && $row['oktb_details']['oktb_group_no'] != null) echo $row['oktb_details']['oktb_group_no']; else echo $row['oktb_details']['oktb_no'];?></h3>
							<?php } } ?>
						</div>
						
			<div class="widget-container gray ">			
            <div class="tab-widget ">
          
              <ul class="nav nav-tabs" id="myTab1">
                <li class="active"><a href="#user"><i class="icon-user"></i> OK To Board Details <span style="font-size:15px;font-weight:bold;"></span></a></li>
                <li><a href="#attach"><i class="icon-user"></i> Attachments  <span style="font-size:15px;font-weight:bold;"></span></a></li>
              
              </ul>
            
            <div class="tab-content">
              <?php if(isset($oktb_apps) && is_array($oktb_apps)){ foreach ($oktb_apps as $row) {?>
                <div class="tab-pane active" id="user">
                
                <table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                                            	<tbody>
                                            	
                                            	<tr>
                                                	<td class="heading">OK To Board Application No</td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_no'])) echo $row['oktb_details']['oktb_no']; else echo 'NA';?></td>
                                                </tr>
                                                <tr>
                                                	<td class="heading">Name of the Applicant</td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_name'])) echo $row['oktb_details']['oktb_name']; else echo 'NA';?></td>
                                                </tr>
                                                 <tr>
                                                	<td class="heading">PNR No</td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_pnr'])) echo $row['oktb_details']['oktb_pnr']; else echo 'NA';?></td>
                                                </tr>
                                                 <tr>
                                                	<td class="heading">Passport No</td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_passportno'])) echo $row['oktb_details']['oktb_passportno']; else echo 'NA';?></td>
                                                </tr>
                                                <tr>
                                                	<td class="heading">Date Of Journey</td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_d_o_j'])) echo $row['oktb_details']['oktb_d_o_j']; else echo 'NA';?></td>
                                                </tr>
                                                <?php if(isset($row['oktb_details']['oktb_doj_time']) && $row['oktb_details']['oktb_doj_time'] != 'hh:00' && $row['oktb_details']['oktb_doj_time'] != null){ ?>
                                                <tr>
                                                	<td class="heading">Time Of Journey</td>
                                                    <td class='upper'><?php echo $row['oktb_details']['oktb_doj_time']; ?></td>
                                                </tr>
                                                <?php } ?>
                                                 <tr>
                                                	<td class="heading">Airline </td>
                                                    <td class='upper'><?php if(isset($airline[$row['oktb_details']['oktb_airline_name']])) echo $airline[$row['oktb_details']['oktb_airline_name']]; else echo 'NA';?></td>
                                                </tr>
                                                 <tr>
                                                	<td class="heading">OK To Board Fee <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }else echo '( in INR )'; ?></td>
                                                    <td class='upper'><?php if(isset($oktb_fee) && strlen($oktb_fee) > 0) echo $oktb_fee; else if(isset($row['oktb_details']['oktb_airline_amount'])) echo $row['oktb_details']['oktb_airline_amount']; else echo 'NA';?></td>
                                                </tr>
                                                 <tr>
                                                	<td class="heading">Date Of Application </td>
                                                    <td class='upper'><?php if(isset($row['oktb_details']['oktb_posted_date']) && strlen($row['oktb_details']['oktb_posted_date']) > 0) echo date('d M Y',strtotime($row['oktb_details']['oktb_posted_date'])); else echo 'NA';?></td>
                                                </tr>
											</tbody></table>
				 </div>
				 
				 <div class="tab-pane" id="attach">
				   
                <table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                <tbody>
				 <tr>
				 <td class="heading">Passport </td>
				 <td>
					<?php if(isset($row['oktb_details']['oktb_passport']) and strlen($row['oktb_details']['oktb_passport']) > 0)
								echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$row['oktb_details']['oktb_no']."/".$row['oktb_details']['oktb_passport']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download Passport'></a>";
								else echo 'NA'; ?>
								</td>
				 </tr>
				 
				 <tr>
				 <td class="heading">Visa</td>
					 <td>
					 		<?php if(isset($row['oktb_details']['oktb_visa']) and strlen($row['oktb_details']['oktb_visa']) > 0)
								echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$row['oktb_details']['oktb_no']."/".$row['oktb_details']['oktb_visa']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download Visa'></a>";
								else echo 'NA'; ?>
					 </td>
				 </tr>
				 
				  <tr>
				  <td class="heading">From Ticket</td>
					 <td>
						<?php if(isset($row['oktb_details']['oktb_from_ticket']) and strlen($row['oktb_details']['oktb_from_ticket']) > 0)
								echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$row['oktb_details']['oktb_no']."/".$row['oktb_details']['oktb_from_ticket']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download From Ticket'></a>";
								else echo 'NA'; ?>
					 </td>
				 </tr>
				 
					<tr>
					<td class="heading">To Ticket</td>
					 <td>
						<?php if(isset($row['oktb_details']['oktb_to_ticket']) and strlen($row['oktb_details']['oktb_to_ticket']) > 0)
								echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$row['oktb_details']['oktb_no']."/".$row['oktb_details']['oktb_to_ticket']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download To Ticket'></a>";
								else echo 'NA'; ?>
					 </td>
				 </tr>
				 </tbody>
				 </table>
				 </div>
				  <?php } } ?>
              </div> 
             </div>
			 <?php if(isset($group) && count($group) > 0){ ?>
			 <div class=" information-container">
				 <div class="widget-head orange" style = "margin-bottom:5px;">
			 		<h3>Group Details</h3>
			 	 </div>
						<?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('OKTB No');?></th>
							<th><?php echo __('Name of Applicant');?></th>	
							<th><?php echo __('Passport No');?></th>	
							<th><?php echo __('Download Passport');?></th>
							<th><?php echo __('Download Visa');?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($group as $g){ 
							echo '<tr>';
							echo '<td>';
							if(isset($g['oktb_details']['oktb_no']) && strlen($g['oktb_details']['oktb_no']) > 0)
							echo $g['oktb_details']['oktb_no']; else echo 'NA';
							echo '</td>';
							
							echo '<td>';
							if(isset($g['oktb_details']['oktb_name']) && strlen($g['oktb_details']['oktb_name']) > 0)
							echo $g['oktb_details']['oktb_name']; else echo 'NA';
							echo '</td>';
							
							echo '<td>';
							if(isset($g['oktb_details']['oktb_passportno']) && strlen($g['oktb_details']['oktb_passportno']) > 0)
							echo $g['oktb_details']['oktb_passportno']; else echo 'NA';
							echo '</td>';
							
							echo '<td>';
							if(isset($g['oktb_details']['oktb_passport']) and strlen($g['oktb_details']['oktb_passport']) > 0)
							echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$g['oktb_details']['oktb_no']."/".$g['oktb_details']['oktb_passport']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download Passport'></a>";
							else echo 'NA'; 
							echo '</td>';
							
							echo '<td>';
							if(isset($g['oktb_details']['oktb_visa']) and strlen($g['oktb_details']['oktb_visa']) > 0)
							echo "<a href = '".$this->webroot."app/webroot/uploads/OKTB/".$g['oktb_details']['oktb_no']."/".$g['oktb_details']['oktb_visa']."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download Visa'></a>";
							else echo 'NA'; 
							echo '</td>';
							echo '</tr>';
							} ?>
							</tbody>
							</table>
						</div>	
						<script>
						$('#data-table').dataTable();
						</script>
			 <?php } ?>
            </div>
          </div>   
          </div>
          </div>
          </div>