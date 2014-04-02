
<STYLE type="text/css">
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
<table>
	<tr>
		<td class="tableTdContent"><h3>Visa Application Detail</h3></td>
	</tr>
	<tr>
		<td ><b>Date:</b></td>
		<td ><?php echo date("F j, Y, g:i a"); ?></td>
	</tr>
	
	<tr><td></td></tr><tr><td></td></tr>
	
	<tr>
	<td class="tableTdContent"><b>Application Details</b></td>
	</tr>
											<tr>
                                            	 <td class="tableTd">Group No</td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['group_no']) and strlen($data['visa_tbl']['group_no']) > 0) echo $data['visa_tbl']['group_no'];else echo 'Not Mentioned';?></td>
                                         		 <td class="tableTd">Visa Type</td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['visa_type']) and strlen($data['visa_tbl']['visa_type']) > 0) echo $data['visa_tbl']['visa_type'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr>
                                            	<td class="tableTd">Tentative Date of Traveller</td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['tent_date']) and strlen($data['visa_tbl']['tent_date']) > 0) echo date('F j, Y',strtotime($data['visa_tbl']['tent_date']));else echo 'Not Mentioned';?></td>
                                         		 <td class="tableTd">Destination </td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['destination']) and strlen($data['visa_tbl']['destination']) > 0) echo $data['visa_tbl']['destination'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr>
                                            	<td class="tableTd">Citizenship</td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['citizenship']) and strlen($data['visa_tbl']['citizenship']) > 0) echo $data['visa_tbl']['citizenship'];else echo 'Not Mentioned';?></td>
                                         		 <td class="tableTd">No. Of Travellers  </td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['adult']) and isset($data['visa_tbl']['children']) and isset($data['visa_tbl']['infants'])) echo 'Adult(s):'.$data['visa_tbl']['adult'].'<br/>Children(s):'.$data['visa_tbl']['children'].'<br/>Infants:'.$data['visa_tbl']['infants'];else echo 'Not Mentioned';?></td>
                                           </tr>
                                           <tr><td class="tableTd">Name Of Applicant</td>
                                                 <td class="tableTdContent"><?php if(isset($data['visa_tbl']['applicant']) and strlen($data['visa_tbl']['applicant']) > 0) echo $data['visa_tbl']['applicant'];else echo 'Not Mentioned';?></td></tr>
                                       
	<tr><td></td></tr><tr><td></td></tr>
	
	<?php if(isset($count) and isset($data))
						 $j = $count; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1; $app = $data['visa_tbl']['app_id'];
								 for($i= 1; $i<= $count;$i++){
								 $a = $data['visa_tbl']['adult']; $b = $data['visa_tbl']['adult']+$data['visa_tbl']['children'];
								   
								 if($a != 0 && $i <= $a){ $id = '-A'.$ak; $heading = 'Adult - '.$ak.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';  $ak++;}
								 else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $heading = 'Children - '.$bk.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';		$bk++;}
								 else{ $id = '-I'.$ck; $heading = 'Infants - '.$ck.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')'; 	$ck++;	}
								 $app++;
						?>
						<tr><td></td></tr>
	<tr>
	<td class="tableTdContent"><strong><?php echo $heading;?></strong></td>
	</tr>
	<tr><td>-</td></tr>
	<tr>
	<td class="tableTdContent">Personal Details</td>
	</tr>					
	
	<tr>
                                                	<td class="tableTd">Given Name</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['given_name'.$id]) and strlen($data['visa_tbl']['given_name'.$id]) > 0) echo $data['visa_tbl']['given_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Surname</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['surname'.$id]) and strlen($data['visa_tbl']['surname'.$id]) > 0) echo $data['visa_tbl']['surname'.$id];else echo 'Not Mentioned'; ?></td>
                                                 </tr>
							 					<tr>
                                                	<td class="tableTd">Father Name</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['father_name'.$id]) and strlen($data['visa_tbl']['father_name'.$id]) > 0) echo $data['visa_tbl']['father_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Mother Name</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['mother_name'.$id]) and strlen($data['visa_tbl']['mother_name'.$id]) > 0) echo $data['visa_tbl']['mother_name'.$id];else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                  <tr>      
                                                	<td class="tableTd">Gender</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['gender'.$id]) and strlen($data['visa_tbl']['gender'.$id]) > 0) echo $data['visa_tbl']['gender'.$id];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Maritial Status</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['marital_status'.$id]) and strlen($data['visa_tbl']['marital_status'.$id]) > 0) echo $data['visa_tbl']['marital_status'.$id];else echo 'Not Mentioned'; ?></td>                                                    
                                                </tr>
                                                <tr>
                                                	 <td class="tableTd">Religion</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['religion'.$id]) and strlen($data['visa_tbl']['religion'.$id]) > 0) echo $data['visa_tbl']['religion'.$id];else echo 'Not Mentioned'; ?></td>         
                                                    <td class="tableTd">Language Spoken</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['language'.$id]) and strlen($data['visa_tbl']['language'.$id]) > 0) echo $data['visa_tbl']['language'.$id];else echo 'Not Mentioned'; ?>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                	<td class="tableTd">Previous Nationality</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['pre_nationality'.$id]) and strlen($data['visa_tbl']['pre_nationality'.$id]) > 0) echo $data['visa_tbl']['pre_nationality'.$id];else echo 'Not Mentioned'; ?></td>
                                                  	<td class="tableTd">Education</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['education'.$id]) and strlen($data['visa_tbl']['education'.$id]) > 0) echo $data['visa_tbl']['education'.$id];else echo 'Not Mentioned'; ?></td>
                                                
                                                   </tr>
                                                <tr>
                                                	<td class="tableTd">Date of Birth</td>
  <td class="tableTdContent"><?php if(strlen($data['visa_tbl']['dob_dd'.$id]) > 0 and strlen($data['visa_tbl']['dob_mm'.$id]) > 0 and strlen($data['visa_tbl']['dob_yy'.$id]) > 0) {
  $dobirth = $data['visa_tbl']['dob_yy'.$id].'-'.$data['visa_tbl']['dob_mm'.$id].'-'.$data['visa_tbl']['dob_dd'.$id];  
  echo $dobirth;}else echo 'Not Mentioned'; ?></td>                                                   
   <td class="tableTd">Place of Birth</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['birth_place'.$id]) and strlen($data['visa_tbl']['birth_place'.$id]) > 0) echo $data['visa_tbl']['birth_place'.$id];else echo 'Not Mentioned'; ?></td>
                                                    	</tr>
                                                    	
                                                    	 <tr>
                                                	<td class="tableTd">Profession</td>
  <td class='tableTdContent'><?php if(isset($data['visa_tbl']['emp_type'.$id]) && strlen($data['visa_tbl']['emp_type'.$id]) > 0 ) {
  echo $data['visa_tbl']['empType'.$id];
  }else echo 'Not Mentioned'; ?></td>                                                   
   <td class="tableTd">If Other</td>
   <td class='tableTdContent'>
   <?php if(isset($data['visa_tbl']['emp_type'.$id]) && $data['visa_tbl']['emp_type'.$id] == 'other' && isset($data['visa_tbl']['emp_other'.$id]) and strlen($data['visa_tbl']['emp_other'.$id]) > 0) echo $data['visa_tbl']['emp_other'.$id];else echo 'Not Mentioned'; ?></td>
                                                    	</tr> 
                                                    	
             <tr><td ></td></tr><tr><td></td></tr>
             <tr>
	<td class="tableTdContent">Passport Details</td>
	</tr>
            
             <tr>
                                            	<td class="tableTd">Passport Type</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['passport_type'.$id]) and strlen($data['visa_tbl']['passport_type'.$id]) > 0) echo $data['visa_tbl']['passport_type'.$id];else echo 'Not Mentioned'; ?></td>                                                
                                                	<td class="tableTd">Passport Number</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['passport_no'.$id]) and strlen($data['visa_tbl']['passport_no'.$id]) > 0) echo $data['visa_tbl']['passport_no'.$id];else echo 'Not Mentioned'; ?></td>
                                                   </tr>
                                                   <tr>
                                                    <td class="tableTd">Date Of Issue</td>
                                                    <td class="tableTdContent"><?php if(strlen($data['visa_tbl']['doi_dd'.$id]) > 0 and strlen($data['visa_tbl']['doi_mm'.$id]) > 0 and strlen($data['visa_tbl']['doi_yy'.$id]) > 0){$issue_date = $data['visa_tbl']['doi_yy'.$id].'-'.$data['visa_tbl']['doi_mm'.$id].'-'.$data['visa_tbl']['doi_dd'.$id] ; echo $issue_date;}else echo 'Not Mentioned'; ?></td>
                                                   
                                                    <td class="tableTd">Expiration Date</td>
                                                    <td class="tableTdContent"><?php if(strlen($data['visa_tbl']['doe_dd'.$id]) > 0 and strlen($data['visa_tbl']['doe_mm'.$id]) > 0 and strlen($data['visa_tbl']['doe_yy'.$id]) > 0 ){$exp_date = $data['visa_tbl']['doe_yy'.$id].'-'.$data['visa_tbl']['doe_mm'.$id].'-'.$data['visa_tbl']['doe_dd'.$id] ;echo $exp_date;}else echo 'Not Mentioned'; ?></td>
                                                    </tr>
                                                <tr>
                                                	<td class="tableTd">Issuing Country</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['issue_country'.$id]) and strlen($data['visa_tbl']['issue_country'.$id]) > 0) echo $data['visa_tbl']['issue_country'.$id];else echo 'Not Mentioned'; ?></td>
                                                   <td class="tableTd">Place of Issue</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['issue_place'.$id]) and strlen($data['visa_tbl']['issue_place'.$id]) > 0) echo $data['visa_tbl']['issue_place'.$id];else echo 'Not Mentioned'; ?></td>  													
                                                   </tr>
                                                                                                          
	
	
	
                                                <?php } ?>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr>
	<td class="tableTdContent"><b>Residential Details</b></td>
	</tr>
                                          
                                                <tr>
                                                	<td class="tableTd">Address 1</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['address1']) and strlen($data['visa_tbl']['address1']) > 0) echo $data['visa_tbl']['address1'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Address 2</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['address2']) and strlen($data['visa_tbl']['address2']) > 0) echo $data['visa_tbl']['address2'];else echo 'Not Mentioned'; ?></td>
                                                  </tr>
                                                 <tr>
                                                    <td class="tableTd">City</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['city']) and strlen($data['visa_tbl']['city']) > 0) echo $data['visa_tbl']['city'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Country</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['country']) and strlen($data['visa_tbl']['country']) > 0) echo $data['visa_tbl']['country'];else echo 'Not Mentioned'; ?></td> 
                                                </tr>
                                                <tr>
                                                	<td class="tableTd">Pin Code</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['pin']) and strlen($data['visa_tbl']['pin']) > 0) echo $data['visa_tbl']['pin'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Telephone</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['std_code']) and strlen($data['visa_tbl']['std_code']) > 0 and isset($data['visa_tbl']['phone']) and strlen($data['visa_tbl']['phone']) > 0) echo $data['visa_tbl']['std_code'].' - '.$data['visa_tbl']['phone'] ;else echo 'Not Mentioned'; ?></td>
                                                  </tr>
                                                  <tr>
													<td class="tableTd">Mobile</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['mobile']) and strlen($data['visa_tbl']['mobile']) > 0) echo $data['visa_tbl']['mobile'];else echo 'Not Mentioned'; ?></td>
													<td class="tableTd">Email</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['email_id']) and strlen($data['visa_tbl']['email_id']) > 0) echo $data['visa_tbl']['email_id'];else echo 'Not Mentioned'; ?></td>
                                                </tr> 
                                                
                         <tr><td></td></tr><tr><td></td></tr>
                         <tr>
	<td class="tableTdContent"><b>Employment Details</b></td>
	</tr>
                        
                        <tr>
                                            	 <td class="tableTd">Employment Type</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['emp_type']) and strlen($data['visa_tbl']['emp_type']) > 0) echo $data['visa_tbl']['emp_type'];else echo 'Not Mentioned'; ?></td>
                                               <td class="tableTd">Name of Company</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['company_name']) and strlen($data['visa_tbl']['company_name']) > 0) echo $data['visa_tbl']['company_name'];else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	
                                                    <td class="tableTd">Address of Business</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['company_address']) and strlen($data['visa_tbl']['company_address']) > 0) echo $data['visa_tbl']['company_address'];else echo 'Not Mentioned'; ?></td>
                                                     <td class="tableTd">Designation</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['designation']) and strlen($data['visa_tbl']['designation']) > 0) echo $data['visa_tbl']['designation'];else echo 'Not Mentioned'; ?></td>
                                                 </tr> 
                                                 
                         <tr><td></td></tr><tr><td></td></tr>
                         <tr>
	<td class="tableTdContent"><b>Travel Details</b></td>
	</tr>
                       
                        
                        <tr>
                                            	 <td class="tableTd">Arrival Airline</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['arr_airline']) and strlen($data['visa_tbl']['arr_airline']) > 0) echo $data['visa_tbl']['arr_airline'];else echo 'Not Mentioned'; ?></td>                                                    
                                                    <td class="tableTd">Departure Airline</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['dep_airline']) and strlen($data['visa_tbl']['dep_airline']) > 0) echo $data['visa_tbl']['dep_airline'];else echo 'Not Mentioned'; ?></td>                                                    
                                                  </tr>
                                                  <tr>  
                                                	<td class="tableTd">Arrival PNR Number</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['arr_pnr_no']) and strlen($data['visa_tbl']['arr_pnr_no']) > 0) echo $data['visa_tbl']['arr_pnr_no'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Departure PNR Number</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['dep_pnr_no']) and strlen($data['visa_tbl']['dep_pnr_no']) > 0) echo $data['visa_tbl']['dep_pnr_no'];else echo 'Not Mentioned'; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <td class="tableTd">Arrival Flight No</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['arrival_flight']) and strlen($data['visa_tbl']['arrival_flight']) > 0) echo $data['visa_tbl']['arrival_flight'];else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Departure Flight No</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['departure_flight']) and strlen($data['visa_tbl']['departure_flight']) > 0) echo $data['visa_tbl']['departure_flight'];else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	<td class="tableTd">Arrival Date</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['arr_date_dd']) and isset($data['visa_tbl']['arr_date_mm']) and isset($data['visa_tbl']['arr_date_yy']) and strlen($data['visa_tbl']['arr_date_dd']) > 0 and strlen($data['visa_tbl']['arr_date_mm']) > 0 and strlen($data['visa_tbl']['arr_date_yy']) > 0){ $arr_date = $data['visa_tbl']['arr_date_yy'].'-'.$data['visa_tbl']['arr_date_mm'].'-'.$data['visa_tbl']['arr_date_dd']; echo $arr_date;}else echo 'Not Mentioned'; ?></td>
                                                    <td class="tableTd">Departure Date</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['dep_date_dd']) and isset($data['visa_tbl']['dep_date_mm']) and isset($data['visa_tbl']['dep_date_yy']) and strlen($data['visa_tbl']['dep_date_dd']) > 0 and strlen($data['visa_tbl']['dep_date_mm']) > 0 and strlen($data['visa_tbl']['dep_date_yy']) > 0){ $dep_date = $data['visa_tbl']['dep_date_yy'].'-'.$data['visa_tbl']['dep_date_mm'].'-'.$data['visa_tbl']['dep_date_dd']; echo $dep_date;}else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <tr>
                                                    <td class="tableTd">Arrival Time</td>
                                                   <td class="tableTdContent"><?php if((isset($data['visa_tbl']['arrival_time']) and strlen($data['visa_tbl']['arrival_time']) > 0 )) echo $data['visa_tbl']['arrival_time'];else echo 'Not Mentioned'; ?></td>
													<td class="tableTd">Departure Time</td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['departure_time']) and strlen($data['visa_tbl']['departure_time']) > 0) echo $data['visa_tbl']['departure_time'];else echo 'Not Mentioned'; ?></td>  
                                                </tr>
                                                <tr>
                                                <td class="tableTd">Remarks </td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['remarks']) and strlen($data['visa_tbl']['remarks']) > 0) echo $data['visa_tbl']['remarks'];else echo 'Not Mentioned'; ?></td>
                                               	 <td class="tableTd">Visa Fee <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></td>
                                                    <td class="tableTdContent"><?php if(isset($data['visa_tbl']['visa_fee'])) echo $data['visa_tbl']['visa_fee']; ?></td>
                                                  </tr>
    												<tr> <td class="tableTd">Total Fee <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></td>
                                                  <td class="tableTdContent"><?php if(isset($data['visa_tbl']['visa_fee'])) echo $data['visa_tbl']['visa_fee']; ?></td></tr>
											
</table>
