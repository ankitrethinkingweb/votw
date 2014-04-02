<?php
echo $this->Html->script('jquery.prettyPhoto');
echo $this->fetch('script');
echo $this->Html->css('prettyPhoto');
echo $this->fetch('css');

?>
<style type="text/css">
ul.nav-tabs li
{
width: 12%;
text-align: center;
}
table tr td
{
width:25%;
}

table tr td.heading
{
font-weight:bold;
}

.tab-widget .tab-content div.tab-pane
{
padding:30px;
}

.upper{
text-transform:uppercase;
}
</style>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Visa Application : <?php if(isset($data['visa_tbl']['group_no']) and strlen($data['visa_tbl']['group_no']) > 0) echo $data['visa_tbl']['group_no'];?></h3>
						</div>
						 <div class=" information-container">
		
		<div class="accordion" id="accordion2">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseApp" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">Application Details <span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse in" id="collapseApp">
								<div class="accordion-inner">
							<table class="responsive table table-striped table-bordered tbl-paper-theme">
                                       <tbody>
                                           <tr>
                                            	<td class="heading">Group No</td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['group_no']) and strlen($data['visa_tbl']['group_no']) > 0) echo $data['visa_tbl']['group_no'];else echo 'Not Mentioned';?></td>
                                         		 <td class="heading">Visa Type</td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['visa_type']) and strlen($data['visa_tbl']['visa_type']) > 0) echo $data['visa_tbl']['visa_type'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr>
                                            	<td class="heading">Tentative Date of Travel</td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['tent_date']) and strlen($data['visa_tbl']['tent_date']) > 0) echo date('d M Y',strtotime($data['visa_tbl']['tent_date']));else echo 'Not Mentioned';?></td>
                                         		 <td class="heading">Destination </td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['destination']) and strlen($data['visa_tbl']['destination']) > 0) echo $data['visa_tbl']['destination'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr>
                                            	<td class="heading">Citizenship</td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['citizenship']) and strlen($data['visa_tbl']['citizenship']) > 0) echo $data['visa_tbl']['citizenship'];else echo 'Not Mentioned';?></td>
                                         		 <td class="heading">No. Of Travellers  </td>
                                                 <td class='upper'><?php if(isset($data['visa_tbl']['adult']) and isset($data['visa_tbl']['children']) and isset($data['visa_tbl']['infants'])) echo 'Adult(s):'.$data['visa_tbl']['adult'].'<br/>Children(s):'.$data['visa_tbl']['children'].'<br/>Infants:'.$data['visa_tbl']['infants'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr>
                                           <td class="heading">Name Of Applicant</td>
                                           <td class='upper'><?php if(isset($data['visa_tbl']['applicant']) and strlen($data['visa_tbl']['applicant']) > 0) echo $data['visa_tbl']['applicant'];else echo 'Not Mentioned';?></td>
                                       	   <td class="heading">Quick App</td>
                                           <td class='upper'><?php if(isset($data['visa_tbl']['app_type']) and $data['visa_tbl']['app_type'] == 'quick_app') echo 'Yes';else echo 'No';?></td>
                                         
                                         </tr>
                                       </tbody>
                           </table>
								</div>
							</div>
						</div>
						
						<?php if(isset($count)) 
						 $j = $count; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1; $app = $data['visa_tbl']['app_id'];
								 for($i= 1; $i<= $count;$i++){
								 $a = $data['visa_tbl']['adult']; $b = $data['visa_tbl']['adult']+$data['visa_tbl']['children'];
								   
								 if($a != 0 && $i <= $a){ $id = '-A'.$ak; $heading = 'Adult - '.$ak.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';  $ak++;}
								 else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $heading = 'Children - '.$bk.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';		$bk++;}
								 else{ $id = '-I'.$ck; $heading = 'Infants - '.$ck.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')'; 	$ck++;	}
								 $app++;
						?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapse<?php echo $id; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle"><?php echo $heading; ?><span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse " id="collapse<?php echo $id; ?>">
								<div class="accordion-inner">

						<div class="tab-widget">
						<ul class="nav nav-tabs" id="myTab2">
							<li><a href="#personal<?php echo $id; ?>"><i class="icon-user-md"></i> Personal Details</a></li>
							<li><a href="#passport<?php echo $id; ?>"><i class=" icon-envelope-alt"></i> Passport Details</a></li>
							<li><a href="#attachments<?php echo $id; ?>"><i class="icon-cloud-upload"></i>Attachments</a></li>
						</ul>
							  
							<div class="tab-content">
							<div class="tab-pane active" id="personal<?php echo $id; ?>">
							<table class="responsive table table-striped table-bordered tbl-paper-theme">
                                       <tbody>
                                      			 <tr>
                                                	<td class="heading">Given Name</td>
                                                    <td align="left"><?php if(isset($data['visa_tbl']['given_name'.$id]) and strlen($data['visa_tbl']['given_name'.$id]) > 0) echo $data['visa_tbl']['given_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Surname</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['surname'.$id]) and strlen($data['visa_tbl']['surname'.$id]) > 0) echo $data['visa_tbl']['surname'.$id];else echo 'Not Mentioned'; ?></td>
                                                 </tr>
							 					<tr>
                                                	<td class="heading">Father Name</td>
                                                    <td align="left"><?php if(isset($data['visa_tbl']['father_name'.$id]) and strlen($data['visa_tbl']['father_name'.$id]) > 0) echo $data['visa_tbl']['father_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Mother Name</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['mother_name'.$id]) and strlen($data['visa_tbl']['mother_name'.$id]) > 0) echo $data['visa_tbl']['mother_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                  <tr>      
                                                	<td class="heading">Gender</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['gender'.$id]) and strlen($data['visa_tbl']['gender'.$id]) > 0) echo $data['visa_tbl']['gender'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Maritial Status</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['marital_status'.$id]) and strlen($data['visa_tbl']['marital_status'.$id]) > 0) echo $data['visa_tbl']['marital_status'.$id];else echo 'Not Mentioned'; ?></td>                                                    
                                                </tr>
                                                <tr>
                                                	 <td class="heading">Religion</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['religion'.$id]) and strlen($data['visa_tbl']['religion'.$id]) > 0) echo $data['visa_tbl']['religion'.$id];else echo 'Not Mentioned'; ?></td>         
                                                    <td class="heading">Language Spoken</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['language'.$id]) and strlen($data['visa_tbl']['language'.$id]) > 0) echo $data['visa_tbl']['language'.$id];else echo 'Not Mentioned'; ?>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                	<td class="heading">Previous Nationality</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['pre_nationality'.$id]) and strlen($data['visa_tbl']['pre_nationality'.$id]) > 0) echo $data['visa_tbl']['pre_nationality'.$id];else echo 'Not Mentioned'; ?></td>
                                                  	<td class="heading">Education</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['education'.$id]) and strlen($data['visa_tbl']['education'.$id]) > 0) echo $data['visa_tbl']['education'.$id];else echo 'Not Mentioned'; ?></td>
                                                
                                                   </tr>
                                                <tr>
                                                	<td class="heading">Date of Birth</td>
  <td class='upper'><?php if(strlen($data['visa_tbl']['dob_dd'.$id]) > 0 and strlen($data['visa_tbl']['dob_mm'.$id]) > 0 and strlen($data['visa_tbl']['dob_yy'.$id]) > 0) {
  $dobirth = $data['visa_tbl']['dob_yy'.$id].'-'.$data['visa_tbl']['dob_mm'.$id].'-'.$data['visa_tbl']['dob_dd'.$id];  
  echo date('d M Y',strtotime($dobirth));}else echo 'Not Mentioned'; ?></td>                                                   
   <td class="heading">Place of Birth</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['birth_place'.$id]) and strlen($data['visa_tbl']['birth_place'.$id]) > 0) echo $data['visa_tbl']['birth_place'.$id];else echo 'Not Mentioned'; ?></td>
                                                    	</tr>
                                                 <tr>
                                                	<td class="heading">Profession</td>
  <td class='upper'><?php if(isset($data['visa_tbl']['emp_type'.$id]) && strlen($data['visa_tbl']['emp_type'.$id]) > 0 ) {
  echo $data['visa_tbl']['empType'.$id];
  }else echo 'Not Mentioned'; ?></td>                                                   
   <td class="heading">If Other</td>
   <td class='upper'>
   <?php if(isset($data['visa_tbl']['emp_type'.$id]) && $data['visa_tbl']['emp_type'.$id] == 'other' && isset($data['visa_tbl']['emp_other'.$id]) and strlen($data['visa_tbl']['emp_other'.$id]) > 0) echo $data['visa_tbl']['emp_other'.$id];else echo 'Not Mentioned'; ?></td>
                                                    	</tr>                                    
                                                  </tbody>
                           </table>
							</div>
							<div class="tab-pane " id="passport<?php echo $id; ?>">
							
							<table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                                            	<tbody>
                                            	<tr>
                                            	<td class="heading">Passport Type</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['passport_type'.$id]) and strlen($data['visa_tbl']['passport_type'.$id]) > 0) echo $data['visa_tbl']['passport_type'.$id];else echo 'Not Mentioned'; ?></td>                                                
                                                	<td class="heading">Passport Number</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['passport_no'.$id]) and strlen($data['visa_tbl']['passport_no'.$id]) > 0) echo $data['visa_tbl']['passport_no'.$id];else echo 'Not Mentioned'; ?></td>
                                                   </tr>
                                                   <tr>
                                                    <td class="heading">Date Of Issue</td>
                                                    <td class="upper"><?php if(strlen($data['visa_tbl']['doi_dd'.$id]) > 0 and strlen($data['visa_tbl']['doi_mm'.$id]) > 0 and strlen($data['visa_tbl']['doi_yy'.$id]) > 0){$issue_date = $data['visa_tbl']['doi_yy'.$id].'-'.$data['visa_tbl']['doi_mm'.$id].'-'.$data['visa_tbl']['doi_dd'.$id] ; echo date('d M Y',strtotime($issue_date));}else echo 'Not Mentioned'; ?></td>
                                                   
                                                    <td class="heading">Expiration Date</td>
                                                    <td class='upper'><?php if(strlen($data['visa_tbl']['doe_dd'.$id]) > 0 and strlen($data['visa_tbl']['doe_mm'.$id]) > 0 and strlen($data['visa_tbl']['doe_yy'.$id]) > 0 ){$exp_date = $data['visa_tbl']['doe_yy'.$id].'-'.$data['visa_tbl']['doe_mm'.$id].'-'.$data['visa_tbl']['doe_dd'.$id] ;echo date('d M Y',strtotime($exp_date));}else echo 'Not Mentioned'; ?></td>
                                                    </tr>
                                                <tr>
                                                	<td class="heading">Issuing Country</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['issue_country'.$id]) and strlen($data['visa_tbl']['issue_country'.$id]) > 0) echo $data['visa_tbl']['issue_country'.$id];else echo 'Not Mentioned'; ?></td>
                                                   <td class="heading">Place of Issue</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['issue_place'.$id]) and strlen($data['visa_tbl']['issue_place'.$id]) > 0) echo $data['visa_tbl']['issue_place'.$id];else echo 'Not Mentioned'; ?></td>  													
                                                   </tr>
                                                 
											</tbody></table>
							
							</div>
							<div class="tab-pane " id="attachments<?php echo $id; ?>">
							<table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                                            	<tbody>
                                            	<tr>
                                                	<td class="heading">Passport First Page</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['pfp'.$id]) and strlen($data['visa_tbl']['pfp'.$id]) > 0){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pfp'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pfp'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Passport Last Page</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['plp'.$id]) and strlen($data['visa_tbl']['plp'.$id]) > 0){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['plp'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['plp'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														}else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <tr>
                                                    <td class="heading">Photograph</td>
                                                   <td class='upper'><?php if(isset($data['visa_tbl']['photograph'.$id]) and strlen($data['visa_tbl']['photograph'.$id]) > 0){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['photograph'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['photograph'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading" width="100px">Passport Observation Page</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['pop'.$id]) and strlen($data['visa_tbl']['pop'.$id]) > 0){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pop'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pop'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	<td class="heading">Address Page</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['addr'.$id]) and strlen($data['visa_tbl']['addr'.$id]) > 0 and $data['visa_tbl']['addr'.$id] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['addr'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['addr'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
													}else echo 'Not Mentioned'; ?></td>
                                                   <td class="heading">Ticket 1</td>
                                                   <td class="upper"><?php if(isset($data['visa_tbl']['ticket1'.$id]) and strlen($data['visa_tbl']['ticket1'.$id]) > 0 and $data['visa_tbl']['ticket1'.$id] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket1'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket1'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                  <tr>
                                                	 <td class="heading">Ticket 2</td>
                                                   <td class="upper"><?php if(isset($data['visa_tbl']['ticket2'.$id]) and strlen($data['visa_tbl']['ticket2'.$id]) > 0 and $data['visa_tbl']['ticket2'.$id] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket2'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket2'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                   <td class="heading">Ticket 3</td>
                                                   <td class="upper"><?php if(isset($data['visa_tbl']['ticket3'.$id]) and strlen($data['visa_tbl']['ticket3'.$id]) > 0 and $data['visa_tbl']['ticket3'.$id] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket3'.$id].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket3'.$id].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <?php if($i == 1) { ?>
                                                 <tr>
                                                  <td class="heading">Additional Document1</td>
                                                   <td class="upper"><?php if(isset($data['visa_tbl']['add_doc1']) and strlen($data['visa_tbl']['add_doc1']) > 0 and $data['visa_tbl']['add_doc1'] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc1'].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc1'].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                  <td class="heading">Additional Document2</td>
                                                   <td class="upper"><?php if(isset($data['visa_tbl']['add_doc2']) and strlen($data['visa_tbl']['add_doc2']) > 0 and $data['visa_tbl']['add_doc2'] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc2'].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc2'].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														
														}else echo 'Not Mentioned'; ?></td>
                                                    
                                                   
                                                </tr>
                                                <tr>
                                                <td class="heading">Additional Document3</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['add_doc3']) and strlen($data['visa_tbl']['add_doc3']) > 0 and $data['visa_tbl']['add_doc3'] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc3'].'" target="_blank"><button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc3'].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';

														}else echo 'Not Mentioned'; ?></td>
                                                 <td class="heading">Additional Document4</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['add_doc4']) and strlen($data['visa_tbl']['add_doc4']) > 0 and $data['visa_tbl']['add_doc4'] != 'Array'){
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc4'].'" target="_blank"> <button class="btn btn-primary" type="button"><i class="icon-folder-close"></i> View</button></a>';
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc4'].'" download><button class="btn" type="button"><i class="icon-download-alt"></i> Download</button></a>';
														}else echo 'Not Mentioned'; ?></td>
                                                </tr><?php } ?>
											</tbody></table>
							
							</div>
							</div>


								</div>
							</div>
						</div>
						</div>
						<?php } ?>
						
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseAddress" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">Residential Details<span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse " id="collapseAddress">
								<div class="accordion-inner">
								<table class="responsive table table-striped table-bordered tbl-paper-theme">
                                       <tbody>
 											<tr>
                                                	<td class="heading">Address 1</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['address1']) and strlen($data['visa_tbl']['address1']) > 0) echo $data['visa_tbl']['address1'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Address 2</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['address2']) and strlen($data['visa_tbl']['address2']) > 0) echo $data['visa_tbl']['address2'];else echo 'Not Mentioned'; ?></td>
                                                  </tr>
                                                 <tr>
                                                    <td class="heading">City</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['city']) and strlen($data['visa_tbl']['city']) > 0) echo $data['visa_tbl']['city'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Country</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['country']) and strlen($data['visa_tbl']['country']) > 0) echo $data['visa_tbl']['country'];else echo 'Not Mentioned'; ?></td> 
                                                </tr>
                                                <tr>
                                                	<td class="heading">Pin Code</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['pin']) and strlen($data['visa_tbl']['pin']) > 0) echo $data['visa_tbl']['pin'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Telephone</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['std_code']) and strlen($data['visa_tbl']['std_code']) > 0 and isset($data['visa_tbl']['phone']) and strlen($data['visa_tbl']['phone']) > 0) echo $data['visa_tbl']['std_code'].' - '.$data['visa_tbl']['phone'] ;else echo 'Not Mentioned'; ?></td>
                                                  </tr>
                                                  <tr>
													<td class="heading">Mobile</td>
                                                    <td ><?php if(isset($data['visa_tbl']['mobile']) and strlen($data['visa_tbl']['mobile']) > 0) echo $data['visa_tbl']['mobile'];else echo 'Not Mentioned'; ?></td>
													<td class="heading">Email</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['email_id']) and strlen($data['visa_tbl']['email_id']) > 0) echo $data['visa_tbl']['email_id'];else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                 </tbody>
                           </table>
								</div>
							</div>
						</div>
						
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseEmp" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">Employment Details<span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse " id="collapseEmp">
								<div class="accordion-inner">
						<table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                                            	<tbody>
                                            	<tr>
                                            	 <td class="heading">Employment Type</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['emp_type']) and strlen($data['visa_tbl']['emp_type']) > 0) echo $data['visa_tbl']['emp_type'];else echo 'Not Mentioned'; ?></td>
                                               <td class="heading">Name of Company</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['company_name']) and strlen($data['visa_tbl']['company_name']) > 0) echo $data['visa_tbl']['company_name'];else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	
                                                    <td class="heading">Address of Business</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['company_address']) and strlen($data['visa_tbl']['company_address']) > 0) echo $data['visa_tbl']['company_address'];else echo 'Not Mentioned'; ?></td>
                                                     <td class="heading">Designation</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['designation']) and strlen($data['visa_tbl']['designation']) > 0) echo $data['visa_tbl']['designation'];else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                               
					</tbody></table>
								</div>
							</div>
						</div>
						
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseTravel" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">Travel Details<span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse " id="collapseTravel">
								<div class="accordion-inner">
								<table width="100%" cellpadding="5" class="responsive table table-striped table-bordered tbl-paper-theme">
                                            	<tbody><tr>
                                            	 <td class="heading">Arrival Airline</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['arr_airline']) and strlen($data['visa_tbl']['arr_airline']) > 0) echo $data['visa_tbl']['arr_airline'];else echo 'Not Mentioned'; ?></td>                                                    
                                                    <td class="heading">Departure Airline</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['dep_airline']) and strlen($data['visa_tbl']['dep_airline']) > 0) echo $data['visa_tbl']['dep_airline'];else echo 'Not Mentioned'; ?></td>                                                    
                                                  </tr>
                                                  <tr>  
                                                	<td class="heading">Arrival PNR Number</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['arr_pnr_no']) and strlen($data['visa_tbl']['arr_pnr_no']) > 0) echo $data['visa_tbl']['arr_pnr_no'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Departure PNR Number</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['dep_pnr_no']) and strlen($data['visa_tbl']['dep_pnr_no']) > 0) echo $data['visa_tbl']['dep_pnr_no'];else echo 'Not Mentioned'; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <td class="heading">Arrival Flight No</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['arrival_flight']) and strlen($data['visa_tbl']['arrival_flight']) > 0) echo $data['visa_tbl']['arrival_flight'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Departure Flight No</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['departure_flight']) and strlen($data['visa_tbl']['departure_flight']) > 0) echo $data['visa_tbl']['departure_flight'];else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	<td class="heading">Arrival Date</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['arr_date_dd']) and isset($data['visa_tbl']['arr_date_mm']) and isset($data['visa_tbl']['arr_date_yy']) and strlen($data['visa_tbl']['arr_date_dd']) > 0 and strlen($data['visa_tbl']['arr_date_mm']) > 0 and strlen($data['visa_tbl']['arr_date_yy']) > 0){$arr_date = $data['visa_tbl']['arr_date_yy'].'-'.$data['visa_tbl']['arr_date_mm'].'-'.$data['visa_tbl']['arr_date_dd']; if($arr_date == 'yy-mm-dd') echo 'Not Mentioned'; else echo date('d M Y',strtotime($arr_date)); }else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Departure Date</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['dep_date_dd']) and isset($data['visa_tbl']['dep_date_mm']) and isset($data['visa_tbl']['dep_date_yy']) and strlen($data['visa_tbl']['dep_date_dd']) > 0 and strlen($data['visa_tbl']['dep_date_mm']) > 0 and strlen($data['visa_tbl']['dep_date_yy']) > 0){ $dep_date = $data['visa_tbl']['dep_date_yy'].'-'.$data['visa_tbl']['dep_date_mm'].'-'.$data['visa_tbl']['dep_date_dd']; if($dep_date == 'yy-mm-dd') echo 'Not Mentioned'; else echo date('d M Y',strtotime($dep_date));}else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <tr>
                                                    <td class="heading">Arrival Time</td>
                                                   <td ><?php if((isset($data['visa_tbl']['arrival_time']) and strlen($data['visa_tbl']['arrival_time']) > 0 )) echo $data['visa_tbl']['arrival_time'];else echo 'Not Mentioned'; ?></td>
													<td class="heading">Departure Time</td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['departure_time']) and strlen($data['visa_tbl']['departure_time']) > 0) echo $data['visa_tbl']['departure_time'];else echo 'Not Mentioned'; ?></td>  
                                                </tr>
                                                <tr>
                                                <td class="heading">Remarks </td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['remarks']) and strlen($data['visa_tbl']['remarks']) > 0) echo $data['visa_tbl']['remarks'];else echo 'Not Mentioned'; ?></td>
                                               	<td class="heading">Visa Fee <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></td>
                                                    <td class='upper'><?php if(isset($data['visa_tbl']['visa_fee'])) echo $data['visa_tbl']['visa_fee']; else echo 0; ?></td>
                                                   </tr>
                                                  <tr> <td class="heading">Total Fee <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></td>
                                                  <td align="left"><?php if(isset($data['visa_tbl']['visa_fee'])) echo $data['visa_tbl']['visa_fee']; else echo 0;?></td></tr>
											</tbody></table>
								</div>
							</div>
						</div>
						
						
				</div>		
				
				<div class="form-actions">
							   <?php if( $data['visa_tbl']['tr_status'] == 1){ ?>
							   <a href="<?php echo $this->webroot; ?>Users/apply_for_visa/<?php echo $data['visa_tbl']['app_id']; ?>" style="margin-left: 10px;" class="btn btn-primary"><i class="icon-money"></i> Apply For Visa</a>
							   <?php } ?>
							   <a href="javascript:void()" onclick="get_receipt(<?php echo $data['visa_tbl']['group_id'];?>)" style="margin-left: 10px;" class="btn btn-info"><i class="icon-print"></i> Print</a>
							    <?php if( $data['visa_tbl']['transaction'] == 1 || $data['visa_tbl']['transaction'] == 0 ){ ?>
							   <a href="<?php echo $this->webroot; ?>edit_visa_app/<?php echo $data['visa_tbl']['group_id']; ?>" style="margin-left: 10px;" class="btn btn-warning"><i class="icon-edit"></i> Edit</a>
							   <a href="<?php echo $this->webroot; ?>edit_upload_data/<?php echo $data['visa_tbl']['group_id']; ?>" style="margin-left: 10px;" class="btn btn-warning"><i class="icon-cloud-upload"></i> Edit Upload Data</a>
							   <?php } if($this->UserAuth->getGroupName() != 'Admin' && $data['visa_tbl']['tr_status'] == 'Approved' && $data['visa_tbl']['visa_path'] != null && $data['visa_tbl']['visa_path'] != ''){ ?>
							   <a href="<?php echo $this->webroot; ?>download/<?php echo $data['visa_tbl']['group_id']; ?>" style="margin-left: 10px;" class="btn btn-warning"><i class="icon-download"></i> Download Visa</a>
							   <?php } if($this->UserAuth->getGroupName() == 'Admin')
							   echo "<a href='".$this->Html->url('/export_xls/'.$data['visa_tbl']['group_id'].'/'.$data['visa_tbl']['group_no'])."' style='margin-left: 10px;' class='btn btn-warning'><i class='icon-save'></i>Export Excel</a>";
							   ?>
							  <?php if(isset($application) && $application == 'all'){ ?>
							   <a href="<?php echo $this->webroot; ?>all_visa_app2" style="margin-left: 10px;" class="btn btn-extend">Cancel</a>								 
							   <?php } else{ ?>
							   <a href="<?php echo $this->webroot; ?>all_visa_app" style="margin-left: 10px;" class="btn btn-extend">Cancel</a>	
							   <?php } ?>							 
				    			</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<script type="text/javascript">
		$("area[rel^='prettyPhoto']").prettyPhoto();
		
		 function get_receipt(id)
       {
       appdetail=window.open("<?php echo $this->webroot; ?>Users/get_receipt/"+id, "mywindow", ",left=50,top=100,location=0,status=0,scrollbars=0,width=600,height=600");
	   appdetail.focus();
		}
		</script>