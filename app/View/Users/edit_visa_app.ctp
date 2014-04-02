<?php 

//echo $this->Html->script('jquery.validate');
//echo $this->Html->script('visa_app_validation');
echo $this->Html->script('bootstrap-datetimepicker.min');
echo $this->fetch('script');	
?>
<style type="text/css">
label
{
display:inline-block;
margin-left:10px;
margin-right:20px;
}

input[type=text].error, .error
{
border:1px solid red;
}

.date_style{
width:73px;
}
</style>
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="stepy-widget">
						<div class="widget-container gray ">
							<div class="form-container">
							<?php echo $this->Session->flash(); ?>
<div class = 'message' style = "display:none;"><span></span> </div>
							<?php if(isset($_REQUEST['issubmit'])){ echo "<strong>Form is sumbitted</strong>"; } ?>
							<?php 	if(isset($application) && $application == 'all') $view = 2; else $view = 1;
							echo $this->Form->create('User', array('action' => 'edit_visa_app/'.$groupId.'/'.$view,'id'=>'visaform1','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); 
						    ?>					
										<input type = "hidden" value = "<?php if(isset($groupId)) echo $groupId; ?>" name = 'groupId' id = "groupId"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['count'])) echo $data['User']['count']; else echo 1; ?>" name = 'hid_count1' id = "hid_count1"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['adult'])) echo $data['User']['adult']; ?>" name = 'adult' id = "adult"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['children'])) echo $data['User']['children']; ?>" name = 'children' id = "children"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['infants'])) echo $data['User']['infants']; ?>" name = 'infants' id = "infants"/>
										
								<div class="accordion" id="accordion2">
						
								<?php if(isset($data['User']['count']))
								 $j = $data['User']['count']; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1;
								 for($i=1;$i<=$j;$i++){
								 $a = $data['User']['adult']; $b = $data['User']['adult']+$data['User']['children'];  
								
								 if($a != 0 && $i <= $a){ $heading = 'Adult - '.$ak; $id = '-A'.$ak; $ak++;}
								 else if($b != 0 && $i <= $b){$heading = 'Children - '.$bk;	$id = '-C'.$bk;	$bk++;}
								 else{ $heading = 'Infants - '.$ck; $id = '-I'.$ck;	$ck++;	}?>	

								<div class="accordion-group" >
								<div class="accordion-heading">
									<a href="#collapse<?php echo $i; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle"><?php echo $heading; ?><span class="caret whitecaret"></span></a>
								</div>
								<div class="accordion-body collapse <?php if($i == 1) echo 'in';?>"  id="collapse<?php echo $i; ?>">
									<div class="accordion-inner">
										<legend>Personal Details - <?php echo $i;?></legend>
									<div style = "float:left;width:50%">
									<?php echo $this->Form->input("app_no".$id ,array('type' => 'hidden','label' => false,'div' => false))?>
 									<div class="control-group">
											<label class="control-label"><?php echo __('Given Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("given_name".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
																				
										<div class="control-group">
											<label class="control-label"><?php echo __('Surname');?></label>
											<div class="controls">
												<?php echo $this->Form->input("surname".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group" id = 'marital<?php echo $id; ?>'>
											<?php $marital_option = $marital_status; ?>
											<label class="control-label"><?php echo __('Marital Status');?></label>
											<div class="controls">
												<?php echo $this->Form->input("marital_status".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$marital_option,'class'=>'chzn-select','onchange'=>'spouse_check()'))?>
											</div>
										</div>		
										
										<div class="control-group">
										<?php
										$options = array('male' => 'Male','female' => 'Female');
										if(isset($data['User']['gender'.$id])) $value = $data['User']['gender'.$id]; else $value = '';
										$attributes = array('legend' => false,'value'=>$value ,'onchange'=>'spouse_check()','onblur'=>"this.value=this.value.toUpperCase()" );?>
											<label class="control-label"><?php echo __('Gender');?></label>
											<div class="controls">
												<?php echo $this->Form->radio("gender".$id ,$options,$attributes);?>
												
											</div>
										</div>
										
										
										<div class="control-group" style = "display:none;" id = 'spouse<?php echo $id; ?>'>
											<label class="control-label"><?php echo __('Spouse Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("spouse_name".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Father Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("father_name".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Mother Name');?></label>
											<div class="controls">
												<?php echo $this->Form->input("mother_name".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
											
										<div class="control-group">
											<label class="control-label"><?php echo __('Select Profession');?></label>
											<div class="controls">
											<?php //if(is_array($emp_type)){ $other = array('other'=>'Other'); $emp_option = $emp_type + $other;  }?>
												<?php echo $this->Form->input("emp_type".$id ,array('type'=>'select','options'=>$empType,'label' => false,'onchange'=>'empChange(this.value,"'.$id.'")','div' => false))?>
											</div>
										</div>
											
									
									</div>	
									<div style = "float:right;width:50%">	
																		
										<div class="control-group">
											<label class="control-label"><?php echo __('Language');?></label>
											<div class="controls">
												<?php echo $this->Form->input("language".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$language,'class'=>'chzn-select'))?>
											</div>
										</div>
										
										<div class="control-group">
											<?php $country_option = $country; ?>
											<label class="control-label"><?php echo __('Previous Nationality');?></label>
											<div class="controls">
												<?php echo $this->Form->input("pre_nationality".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select'))?><br/>
											</div>
										</div>
										
										<div class="control-group">										
											<label class="control-label"><?php echo __('Date Of Birth');?></label>
										<?php $date_dd['dd'] = '-dd-'; for($fi=1;$fi<=31;$fi++){ $date_dd[$fi] = $fi; }?>
										<?php $date_mm['mm'] = '-mm-'; for($fj=1;$fj<=12;$fj++){ $date_mm[$fj] = $fj; }?>
										<?php $date_yy['yy'] = '-yy-'; $year = 1940; $curr_Year = date('Y'); for($fk=$year;$fk<=$curr_Year;$fk++){ $date_yy[$fk] = $fk; }?>
										
											<div class="controls">
											<?php echo $this->Form->input("dob_dd".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_dd,'class'=>'chzn-select date_style' ))?>
												<?php echo $this->Form->input("dob_mm".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_mm,'class'=>'chzn-select date_style' ))?>
												<?php echo $this->Form->input("dob_yy".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$date_yy,'class'=>'chzn-select date_style' ))?>											
											</div>
										</div>
			
										<div class="control-group">
											<label class="control-label"><?php echo __('Place of Birth');?></label>
											<div class="controls">
												<?php echo $this->Form->input("birth_place".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									
									<div class="control-group">
											<?php $country_option = $religion; ?>
											<label class="control-label"><?php echo __('Select Religion');?></label>
											<div class="controls">
												<?php echo $this->Form->input("religion".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select'))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Educational Qualification');?></label>
											<div class="controls">
												<?php echo $this->Form->input("education".$id ,array("type"=>"text",'label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
	
										<div class="control-group" id = "emp_other<?php echo $id; ?>" style = "display:none;">
											<label class="control-label"><?php echo __('If Selected Other ,Please Enter');?></label>
											<div class="controls">
												<?php echo $this->Form->input("emp_other".$id ,array('label' => false,'div' => false,'placeholder'=>'Employment Type','onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
									</div>	
									<div style="clear:both"></div>
									
										<legend>Passport Details - <?php echo $i;?> </legend>
										<div style="float:left;width:50%">
										
											<div class="control-group">
											<?php $country_option = $passport_type; ?>
											<label class="control-label"><?php echo __('Select Passport Type');?></label>
											<div class="controls">
												<?php echo $this->Form->input("passport_type".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select' ))?>
											</div>
										</div>
										
									
										
										<div class="control-group">
											<?php $country_option = $country; ?>
											<label class="control-label"><?php echo __('Issuing Country');?></label>
											<div class="controls">
												<?php echo $this->Form->input("issue_country".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select' ))?>
											</div>
										</div>
						
										<div class="control-group">
											<label class="control-label"><?php echo __('Date Of Issue');?></label>
											<?php $i_dd['dd'] = '-dd-'; for($ii=1;$ii<=31;$ii++){ $i_dd[$ii] = $ii; }?>
										<?php $i_mm['mm'] = '-mm-'; for($ij=1;$ij<=12;$ij++){ $i_mm[$ij] = $ij; }?>
										<?php $i_yy['yy'] = '-yy-'; $year = 1960; $curr_Year = date('Y'); for($ik=$year;$ik<=$curr_Year;$ik++){ $i_yy[$ik] = $ik; }?>
											<div class="controls">
												<?php echo $this->Form->input("doi_dd".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$i_dd,'class'=>'chzn-select date_style'))?>
												<?php echo $this->Form->input("doi_mm".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$i_mm,'class'=>'chzn-select date_style'  ))?>
												<?php echo $this->Form->input("doi_yy".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$i_yy,'class'=>'chzn-select date_style' ))?>
																						</div>
										</div>																											
										</div>
									<div style="float:left;width:50%">
									
										<div class="control-group">
											<label class="control-label"><?php echo __('Passport Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("passport_no".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Place of Issue');?></label>
											<div class="controls">
												<?php echo $this->Form->input("issue_place".$id ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Expiration Date');?></label>
											<?php $e_dd['dd'] = '-dd-'; for($ei=1;$ei<=31;$ei++){ $e_dd[$ei] = $ei; }?>
										<?php $e_mm['mm'] = '-mm-'; for($ej=1;$ej<=12;$ej++){ $e_mm[$ej] = $ej; }?>
										<?php $e_yy['yy'] = '-yy-'; $year = 1960; $curr_Year = date('Y') + 20; for($ek=$year;$ek<=$curr_Year;$ek++){ $e_yy[$ek] = $ek; }?>
											<div class="controls">
<?php echo $this->Form->input("doe_dd".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_dd,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?>
												<?php echo $this->Form->input("doe_mm".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_mm,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?>
												<?php echo $this->Form->input("doe_yy".$id ,array("type"=>"select",'label' => false,'div' => false,'options'=>$e_yy,'class'=>'chzn-select date_style','onchange'=>'monthDiff("'.$id.'")'  ))?>
<div id = 'i_err<?php echo $id; ?>' style = 'color:red'> </div>
										
											</div>
										</div>							
										</div>									
										<div style="clear:both"></div>

<a onclick = "openAcc(<?php echo $i; ?>)" style="margin-left: 10px;" class="btn btn-primary"><i class="icon-next"></i>Next</a>
	
									</div>
								</div>
							</div>
								<?php }  ?>	
							
								<div class="accordion-group" > 
								<div class="accordion-heading">
									<a href="#collapseTravel" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">Common Details<span class="caret whitecaret"></span></a>
								</div>
								<div class="accordion-body collapse" id="collapseTravel">
									<div class="accordion-inner">
										<legend>Residential Details</legend>
											<div style="float:left;width:50%">
										<div class="control-group">
											<label class="control-label"><?php echo __('Address 1');?></label>
											<div class="controls">
												<?php echo $this->Form->input("address1" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
											<div class="control-group">
											<label class="control-label"><?php echo __('Address 2');?></label>
											<div class="controls">
												<?php echo $this->Form->input("address2" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"><?php echo __('City');?></label>
											<div class="controls">
												<?php echo $this->Form->input("city" ,array('label' => false,'div' => false))?>
											</div>
										</div>
										
										<div class="control-group">
											<?php $country_option = $country; ?>
											<label class="control-label"><?php echo __('Country');?></label>
											<div class="controls">
												<?php echo $this->Form->input("country" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select' ))?>
											</div>
										</div>
								</div>
									<div style="float:left;width:50%">
									
									<div class="control-group">
											<label class="control-label"><?php echo __('Pincode');?></label>
											<div class="controls">
												<?php echo $this->Form->input("pin" ,array('label' => false,'div' => false,'maxlength'=>6))?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"><?php echo __('Mobile');?></label>
											<div class="controls">
												<?php echo $this->Form->input("mobile" ,array('label' => false,'div' => false,'maxlength'=>10))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Landline');?></label>
											<div class="controls">						
												<?php echo $this->Form->input("std_code" ,array('label' => false,'div' => false,'maxlength'=>5,'class'=>'span3','placeholder'=>'STD Code'))?>												
												<?php echo $this->Form->input("phone" ,array('label' => false,'div' => false,'maxlength'=>10,'class'=>'span6','placeholder'=>'Phone Number'))?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"><?php echo __('Email');?></label>
											<div class="controls">
												<?php echo $this->Form->input("email_id" ,array('type'=>'text','label' => false,'div' => false))?>
											</div>
										</div>										
									</div>
										<div style="clear:both"></div>
								
										<legend>Employment Details</legend>
										<div style="float:left;width:50%" >
										<div class="control-group">
											<?php $country_option = $emp_type; ?>
											<label class="control-label"><?php echo __('Employment Type');?></label>
											<div class="controls">
												<?php echo $this->Form->input("emp_type" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select','onchange'=>'emp_select()' ))?>
											</div>
										</div>
										
										
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Name Of Company');?></label>
											<div class="controls">
												<?php echo $this->Form->input("company_name" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Company Address');?></label>
											<div class="controls">
												<?php echo $this->Form->input("company_address" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										</div>
										<div style="float:left;width:50%">
										<div class="control-group">
											<label class="control-label"><?php echo __('Company Contact Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("company_contact" ,array('label' => false,'div' => false,'maxlength'=>12))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Designation');?></label>
											<div class="controls">
												<?php echo $this->Form->input("designation" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										
										</div>
								
										<div style="clear:both"></div>
									
										<legend>Travel Details</legend>
										<div id = 'arr_err' style = 'color:red'> </div>
										<div style="float:left;width:50%">
										
										<div class="control-group">
											<?php $country_option = $airline; ?>
											<label class="control-label"><?php echo __('Arrival Airline');?></label>
											<div class="controls">
												<?php echo $this->Form->input("arr_airline" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select' ))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Arrival Flight No');?></label>
											<div class="controls">
												<?php echo $this->Form->input("arrival_flight" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
											<div class="control-group">
											<label class="control-label"><?php echo __('Arrival Date');?></label>
										<?php $arr_dd['dd'] = '-dd-'; for($ai=1;$ai<=31;$ai++){ $arr_dd[$ai] = $ai; }?>
										<?php $arr_mm['mm'] = '-mm-'; for($aj=1;$aj<=12;$aj++){ $arr_mm[$aj] = $aj; }?>
										<?php $arr_yy['yy'] = '-yy-'; $year = date('Y'); $curr_Year = date('Y') + 20; for($ak=$year;$ak<=$curr_Year;$ak++){ $arr_yy[$ak] = $ak; }?>
											<div class="controls">
												<?php echo $this->Form->input("arr_date_dd" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$arr_dd,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>
												<?php echo $this->Form->input("arr_date_mm" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$arr_mm,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>
												<?php echo $this->Form->input("arr_date_yy" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$arr_yy,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>																
											</div>
										</div>
									
										<div class="control-group">
											<label class="control-label"><?php echo __('Arrival Time');?></label>
											<div class="controls">
											<div id="arr_time" class="input-append">
											<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span><?php echo $this->Form->input("arrival_time" ,array('label' => false,'div' => false,'data-format'=>'hh:mm:ss','style'=>array('width: 173px')))?><br/>
											</div>
										</div>
										</div>
											
										<div class="control-group">
											<label class="control-label"><?php echo __('Arrival PNR Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("arr_pnr_no" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
																			
										</div>
										
										<div style="float:left;width:50%">
											
										<div class="control-group">
											<?php $country_option = $airline; ?>
											<label class="control-label"><?php echo __('Departure Airline');?></label>
											<div class="controls">
												<?php echo $this->Form->input("dep_airline" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$country_option,'class'=>'chzn-select' ))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Departure Flight No');?></label>
											<div class="controls">
												<?php echo $this->Form->input("departure_flight" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Departure Date');?></label>
										<?php $dep_dd['dd'] = '-dd-'; for($di=1;$di<=31;$di++){ $dep_dd[$di] = $di; }?>
										<?php $dep_mm['mm'] = '-mm-'; for($dj=1;$dj<=12;$dj++){ $dep_mm[$dj] = $dj; }?>
										<?php $dep_yy['yy'] = '-yy-'; $year =date('Y'); $curr_Year = date('Y') + 20; for($dk=$year;$dk<=$curr_Year;$dk++){ $dep_yy[$dk] = $dk; }?>
											
										<div class="controls">
												<?php echo $this->Form->input("dep_date_dd" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$dep_dd,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>
												<?php echo $this->Form->input("dep_date_mm" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$dep_mm,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>
												<?php echo $this->Form->input("dep_date_yy" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$dep_yy,'class'=>'chzn-select date_style','onchange'=> 'CompareArrDates()' ))?>
												</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Departure Time');?></label>
										<div class="controls">
											<div id="dept_time" class="input-append">
												<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span><?php echo $this->Form->input("departure_time" ,array('label' => false,'div' => false,'data-format'=>'hh:mm:ss','style'=>array('width: 173px')))?><br/>
											</div>
										</div>
										</div>
										
										<div class="control-group">
											<label class="control-label"><?php echo __('Departure PNR Number');?></label>
											<div class="controls">
												<?php echo $this->Form->input("dep_pnr_no" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>							
										
										</div>
								<div style="clear:both"></div>

<legend>Applicant Details</legend>
<div style="float:left;width:50%">
<div class="control-group">
		<label class="control-label"><?php echo __('Name Of Applicant');?></label>
		<div class="controls">
		<?php echo $this->Form->input("applicant" ,array("type"=>"text",'label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
		</div>
		</div>
</div>
<div style="float:left;width:50%">
<div class="control-group">
											<label class="control-label"><?php echo __('Remarks');?></label>
											<div class="controls">
	<?php echo $this->Form->textarea("remarks" ,array('label' => false,'div' => false,'onblur'=>"this.value=this.value.toUpperCase()"))?>
											</div>
										</div>	
</div>
<div style = "clear:both" ></div>	
<button type="submit" style="margin-left: 10px;" class="btn btn-primary"><i class="icon-money"></i>Save</button>
								</div>
							</div>
						</div>
					</div>
					
									
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	
	<script type='text/javascript'>

function empChange(empVal,id){
	if(empVal == 'other') $('#emp_other'+id).css('display','block'); else $('#emp_other'+id).css('display','none');
}

	function openAcc(i){

var count1 = $('#hid_count1').val();
var j = parseInt(i + 1);
if(parseInt(j) <= parseInt(count1)){  
for(var c=1;c<=parseInt(count1);c++ ){ 
var a = document.getElementById("collapse"+c);
var d = document.getElementById("collapse"+j);
if(a == d){
d.className = 'accordion-body in collapse';
$('#collapse'+j).css('height','auto');
}else{
a.className = 'accordion-body collapse';
$('#collapse'+c).css('height','0px');
}
}
}else{ 
 for(var c=1;c<=parseInt(count1);c++ ){
var a = document.getElementById("collapse"+c);
a.className = '';
a.className = 'accordion-body collapse';
$('#collapse'+c).css('height','0px');
}
var d = document.getElementById('collapseTravel');
d.className = 'accordion-body in collapse';
$('#collapseTravel').css('height','auto');
}
$('html, body').animate({ scrollTop: 450 }, 'fast');
return true;
}


	function CompareArrDates() {
	
if($('#UserArrDateDd').val() != 'dd' && $('#UserArrDateMm').val() != 'mm' && $('#UserArrDateYy').val() != 'yy' && $('#UserDepDateDd').val() != 'dd' && $('#UserDepDateMm').val() != 'mm' && $('#UserDepDateYy').val() != 'yy' ){
    $('#arr_err').html('');
    var smallDt = $('#UserArrDateDd').val();
    var smallMt = $('#UserArrDateMm').val();
    var smallYr = $('#UserArrDateYy').val();  
    var largeDt = $('#UserDepDateDd').val();
    var largeMt = $('#UserDepDateMm').val();
    var largeYr = $('#UserDepDateYy').val();

if(smallYr>largeYr){ 
	$('#arr_err').html('Arrival Date Should be smaller than Departure Date');
	return false;
}else if(smallYr==largeYr && smallMt>largeMt){
	$('#arr_err').html('Arrival Date Should be smaller than Departure Date');
	return false;
}else if(smallYr==largeYr && smallMt==largeMt && smallDt>largeDt){
	$('#arr_err').html('Arrival Date Should be smaller than Departure Date');
	return false;
}else{
	$('#arr_err').html('');
	return true;
	}
 }
} 

function CompareDates(id) {
	
if($('#UserDoiDd'+id).val() != 'dd' && $('#UserDoiMm'+id).val() != 'mm' && $('#UserDoiYy'+id).val() != 'yy' && $('#UserDoeDd'+id).val() != 'dd' && $('#UserDoeMm'+id).val() != 'mm' && $('#UserDoeYy'+id).val() != 'yy' ){
    $('#i_err'+id).html('');
    var smallDt = $('#UserDoiDd'+id).val();
    var smallMt = $('#UserDoiMm'+id).val();
    var smallYr = $('#UserDoiYy'+id).val();  
    var largeDt = $('#UserDoeDd'+id).val();
    var largeMt = $('#UserDoeMm'+id).val();
    var largeYr = $('#UserDoeYy'+id).val();

if(smallYr>largeYr){ 
	$('#i_err'+id).html('Date of Issue Should be smaller than Date of Expiration');
	return false;
}else if(smallYr==largeYr && smallMt>largeMt){
	$('#i_err'+id).html('Date of Issue Should be smaller than Date of Expiration');
	return false;
}else if(smallYr==largeYr && smallMt==largeMt && smallDt>largeDt){
	$('#i_err'+id).html('Date of Issue Should be smaller than Date of Expiration');
	return false;
}else{
	$('#i_err'+id).html('');
	return true;
	}
 }
}  
 
function monthDiff(id){

if($('#UserTentDd').val() != 'dd' && $('#UserTentMm').val() != 'mm' && $('#UserTentYy').val() != 'yy' && $('#UserDoeDd'+id).val() != 'dd' && $('#UserDoeMm'+id).val() != 'mm' && $('#UserDoeYy'+id).val() != 'yy' ){

d1 = new Date();
 d2 = new Date($('#UserDoeYy'+id).val(), $('#UserDoeMm'+id).val(), $('#UserDoeDd'+id).val());

        var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth()+1  ;
    months += d2.getMonth();
    var data = months;

    if(data >= 0 && data <= 6){
    if(data == 0) 
    	alert('Your Passport will expire in this months'); 
    else 
        alert('Your Passport will expire in  '+data+' months');

return true;
    }else if(data < 0){
    $('#UserDoeYy'+id).val('dd');
    $('#UserDoeMm'+id).val('mm');
    $('#UserDoeDd'+id).val('yy');
      alert('Your Passport is Expired'); 
return false; 
}
else{

return true;}
   
}
}

function emp_select(){
alert($('#UserEmpType').val());
if($('#UserEmpType').val() == 3 || $('#UserEmpType').val() == 4){           
$("#UserCompanyContact").rules("remove", "required");	
$("#UserCompanyName").rules("remove", "required");	
$("#UserCompanyAddress").rules("remove", "required");	
$("#UserDesignation").rules("remove", "required");
}else{
$("#UserCompanyContact").rules("add", "required");	
$("#UserCompanyName").rules("add", "required");	
$("#UserCompanyAddress").rules("add", "required");
$("#UserDesignation").rules("add", "required");	
}
}
	  $(function () {
		$('#submit').html("Continue");
			 $("#arr_time,#dept_time").datetimepicker({
			 pickDate:false,
			 }); 
			 
              jQuery.validator.addMethod("alphanumeric", function(value, element) {
       	 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
			});
                $.validator.addMethod("anyDate",
function(value, element) {
return value.match(/^(0?[1-9]|[12][0-9]|3[0-2])[.,/ -](0?[1-9]|1[0-2])[.,/ -](19|20)?\d{2}$/);
},
"Please enter valid date"
);

$.validator.addMethod("File", function(value, element) {

    return this.optional(element) || /(?:^|\/|\\)((?:[a-z0-9_\s\(\)\[\]])*\.(?:pdf|gif|jpg|jpeg|png))$/i.test(value);
}, "Invalid file type");
                
             $("#visaform1").validate({  
				errorPlacement: function(error,element) {
//var group = element.parents('div.accordion-group');
//element.parents('div.accordion-group').css('background','#E4232A');
//element.closest('.accordion-heading').addClass('error');
//element.parents('div.accordion-heading').css('background','#E4232A');
				    return true;
				  },

 invalidHandler: function(event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message = errors == 1
        ? 'You missed 1 field. It has been highlighted'
        : 'You missed ' + errors + ' fields. They have been highlighted. Please Check...';
      $("div.message span").html(message);

 $('html, body').animate({ scrollTop: 400 }, 'fast');
      $("div.message").show();
    } else {
      $("div.message").hide();
    }
  },

                    rules: {
                  'data[User][religion-A1]':{
          				  required:true,
          				  digits:true,
          				  },
          				  'data[User][education-A1]':{
          				  required:true,
          				  
          				  },
                        'data[User][given_name-A1]': {
                            required: true,
                        },
                        'data[User][surname-A1]': {
                            required: true,                        
                        },
                        
                          'data[User][father_name-A1]': {
                            required: true,                       
                        },
                        
                           'data[User][mother_name-A1]': {
                            required: true,                        
                        },
                        
                        'data[User][marital_status-A1]' :{ 
                     	required :true,
                     	digits:true,
          				  }, 
          				  
          				   'data[User][language-A1]' :{ 
                     	required :true,
                     	 digits: true,
          				  }, 
      				     				           				  
     				    'data[User][pre_nationality-A1]' :{                   
                     	 digits: true,
          				  }, 
          				  
          				  'data[User][dob_dd-A1]':{
          				  digits:true,
          				  },
          				   'data[User][dob_mm-A1]':{
          				  digits:true,
          				  },
          				   'data[User][dob_yy-A1]':{
          				  digits:true,
          				  },
          				                            
                         'data[User][birth_place-A1]': {
                            required: true,
                         
                        },
                     
          				    'data[User][religion-A1]' :{ 
                     	required :true,
                     	 digits: true,
          				  }, 
          			          				  
          				      
          				   'data[User][passport_type-A1]' :{ 
                     	required :true,
                     	 digits: true,
          				  }, 
          				  
          				  'data[User][passport_no-A1]' :{ 
                     	required :true,
                      alphanumeric: true,
          				  }, 
     				   
          				   'data[User][issue_country-A1]' :{ 
                     	required :true,
                     	 digits: true,
          				  }, 
          				  
          				   'data[User][emp_type-A1]' :{ 
                     	required :true,
                     
                     }, 
          				  
          				   
          				   'data[User][emp_other-A1]' :{ 
                     	required :true,
                     }, 
                     
          				     'data[User][issue_place-A1]' :{ 
                     	required :true,
                     	
          				  }, 
          				  
          				  'data[User][doi_dd-A1]' :{ 
                     	required :true,
                     	digits:true,
                     	  
          				  },
          				   'data[User][doi_mm-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				   'data[User][doi_yy-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				   'data[User][doe_dd-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				   'data[User][doe_mm-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          				   'data[User][doe_yy-A1]' :{ 
                     	required :true,
                     	  digits:true,
          				  },
          			
                        'data[User][email_id]': {
                        required:true,
                           email: true,
                        },
                        
                       'data[User][emp_type]':{
                        required:true,
                        digits:true,
                        },


  
                        'data[User][company_name]':{
                        required:true,
                        },   
                        'data[User][designation]':{
                        required:true,
                        },  
                        'data[User][company_address]':{
                        required:true,
                        }, 
                        
                        'data[User][company_contact]' :{ 
                        required:true,
                     	number: true,
                     	minlength:10
          				  },
                        
                        'data[User][arr_pnr_no]': {  
                       		alphanumeric:true
                        }, 
                        'data[User][dep_pnr_no]': {
                       		alphanumeric:true
                        }, 

                     
                    },
                    messages: {
                                          				
          				        
                        'data[User][given_name-A1]': {
                            required: "Please enter a Given name",
                        },
                       'data[User][surname-A1]': {
                            required: "Please enter a Surname",
                        },
                        'data[User][religion-A1]':{
          				  required:"Please Select Religion",
          				  digits:"Please Select Religion",
          				  },
          				  'data[User][education-A1]':{
          				  required:"Please enter your Educational Qualification",         				  
          				  },
                        'data[User][father_name-A1]': {
                            required: "Please enter a father name",
                        },
                        
                        'data[User][mother_name-A1]': {
                            required: "Please enter a mother name",
                        },
                        'data[User][marital_status-A1]': {
                        required:"Please Select Marital Status",
                            digits: "Please select marital status",                      
                        },
                        
                         'data[User][language-A1]': {
                         required: "Please select language",             
                            digits: "Please select language",                       
                        },
                                            
                         'data[User][pre_nationality-A1]': {
                            digits: "Please select previous nationality",                      
                        },     
                         
          				  'data[User][dob_dd-A1]':{
          				  digits:"Please Select date",
          				  },
          				   'data[User][dob_mm-A1]':{
          				  digits:"Please Select month",
          				  },
          				   'data[User][dob_yy-A1]':{
          				  digits:"Please Select year",
          				  },
          				                       
                         'data[User][birth_place-A1]': {
                            required: "Please enter birth place",
                       
                        },
                        
                          'data[User][religion-A1]': {
                            digits: "Please select religion",                       
                        },
                      
                                          
                          
                         'data[User][passport_type-A1]': {
                              digits: "Please select passport type",
                        },
                        'data[User][passport_no-A1]': {
                            required: "Please enter valid passport number",
                            alphanumeric:"Please enter valid passport number",
                        },
                        
                         'data[User][issue_country-A1]': {                        
                          required: "Please select passport issue country",
                              digits: "Please select passport issue country"                                       
                        },
                                                           
                         'data[User][issue_place-A1]': {                       
                          required: "Please enter passport issue place",
                        },
                        
                         'data[User][doi_dd-A1]': {
                            required: "Please Select Date",
                            digits: "Please Select Date",
                        },
                        'data[User][doi_mm-A1]': {
                            required: "Please Select Month",
                            digits: "Please Select Date",
                        },
                         'data[User][doi_yy-A1]': {
                            required: "Please Select Year",
                            digits: "Please Select Date",
                        },
                          'data[User][doe_dd-A1]': {
                            required: "Please Select Date",
                            digits: "Please Select Date",
                        },                       
                         'data[User][doe_mm-A1]': {
                            required: "Please Select Month",
                            digits: "Please Select Date",
                        },
                         'data[User][doe_yy-A1]': {
                            required: "Please Select Year",
                            digits: "Please Select Date",
                        },
                        
                        
                          'data[User][email_id]': {
                          email: "Please enter valid email id",
                        },
                        
  		            'data[User][telephone]': {
                          required: "Please enter telephone number",
                            number: "Please enter valid telephone number",
                          minlength:"Please enter valid telephone number"
                        },
                     'data[User][emp_type]':{
                     digits:"Please Select Employment Type",
                     }, 
                    
                     'data[User][company_address]':{
                     required:"Please Enter Company Address",
                     },
                     'data[User][designation]':{
                       required:"Please Enter Designation",                     
                     },
                     'data[User][company_name]':{
                     required:"Please Enter Company Name", 
                     }, 
                     'data[User][email_id]':{
                     required:"Please Enter valid Email Id", 
                     }, 
                    
                         'data[User][company_contact]': {
                   		  number: "Please enter valid telephone number",
                          minlength:"Please enter valid telephone number"
                        },
                      'data[User][arr_pnr_no]': {  
                       		alphanumeric:"Please Enter Valid PNR No.",
                        }, 
                        'data[User][dep_pnr_no]': {
                       		alphanumeric:"Please Enter Valid PNR No.",
                        }, 
                        
                        'data[User][photograph]': {
                     required: "Please Upload Photograph",                   
                        },  
                        
                        'data[User][first_page]': {
                     required: "Please Upload passport First page",                   
                        },  
                        
                        'data[User][last_page]': {
                     required: "Please upload passport last page",                   
                        },  
                        
                        'data[User][addr_page]': {
                    	 required: "Please upload Address Page",                 
                        },
                        'data[User][obs_page]': {
                    	 required: "Please upload Observation Page",                 
                        },
                      
                    }  
                });
	
if($('#UserEmpType').val() == 3 || $('#UserEmpType').val() == 4){	 
$("#UserCompanyContact").rules("remove", "required");	
$("#UserCompanyName").rules("remove", "required");	
$("#UserCompanyAddress").rules("remove", "required");	
$("#UserDesignation").rules("remove", "required");
}else{
$("#UserCompanyContact").rules("add", "required");	
$("#UserCompanyName").rules("add", "required");	
$("#UserCompanyAddress").rules("add", "required");
$("#UserDesignation").rules("add", "required");	
}
	

if($('#UserVisaType').val() == 3 ){
$("#UserArrivalTime").rules("add", "required");
$("#UserDepartureTime").rules("add", "required");
$("#UserArrDateDd").rules("add", "digits");
$("#UserArrDateMm").rules("add", "digits");
$("#UserArrDateYy").rules("add", "digits");
$("#UserDepDateDd").rules("add", "digits");
$("#UserDepDateMm").rules("add", "digits");
$("#UserDepDateYy").rules("add", "digits");
}else{
$("#UserArrivalTime").rules("remove", "required");
$("#UserDepartureTime").rules("remove", "required");
$("#UserArrDateDd").rules("remove", "digits");
$("#UserArrDateMm").rules("remove", "digits");
$("#UserArrDateYy").rules("remove", "digits");
$("#UserDepDateDd").rules("remove", "digits");
$("#UserDepDateMm").rules("remove", "digits");
$("#UserDepDateYy").rules("remove", "digits");
}
		
      var hid_count1 = $('#hid_count1').val();
     // alert($("#UserEmpType-A1").val());
	if($("#UserEmpType-A1").val() == 'other') $("#emp_other-A1").css('display','block'); else $("#emp_other-A1").css('display','none');

         	if(hid_count1 > 1){
         	var ak = 1;
         	var bk = 1;
         	var ck = 1;
         	var a = $('#adult').val();
	        var b = $('#children').val();
	        var c = $('#infants').val(); 	
	        var ab = parseInt(a) + parseInt(b);
	     
	        for(var i=1;i<=hid_count1;i++ ){  
	      
	         	if(a != 0 && i <= a){ id = '-A'+ak; ak++;}
				else if(ab != 0 && i <= ab){ id = '-C'+bk; bk++;}
				else{ id = '-I'+ck;	ck++;	}
				if($("#UserEmpType"+id).val() == 'other') $("#emp_other"+id).css('display','block'); else $("#emp_other"+id).css('display','none');
				
		         	$("#UserGivenName"+id).rules("add", "required");
					$("#UserLanguage"+id).rules("add", "required");	 
					$("#UserSurname"+id).rules("add", "required");
					$("#UserFatherName"+id).rules("add", "required");	         	
					$("#UserMotherName"+id).rules("add", "required");					  
					$("#UserDobDd"+id).rules("add", "digits");       						
					$("#UserDobMm"+id).rules("add", "digits");					
					$("#UserDobYy"+id).rules("add", "digits");	         	
					$("#UserBirthPlace"+id).rules("add", "required");
					$("#UserReligion"+id).rules("add", "digits");	         	
					$("#UserMaritalStatus"+id).rules("add", "digits");
					$('#UserLanguage'+id).rules("add", "digits");
					$("#UserEducation"+id).rules("add", "required");	 					     
					$("#UserPassportType"+id).rules("add", "digits");
					$("#UserPassportNo"+id).rules("add", "required");	
					$("#UserPassportNo"+id).rules("add", "alphanumeric");	         	
					$("#UserIssueCountry"+id).rules("add", "digits");
					$("#UserIssuePlace"+id).rules("add", "required");	         	
					$("#UserDoiDd"+id).rules("add", "digits");
					$("#UserDoiMm"+id).rules("add", "digits");	         	
					$("#UserDoiYy"+id).rules("add", "digits");
					$("#UserDoeDd"+id).rules("add", "digits");	         	
					$("#UserDoeMm"+id).rules("add", "digits");
					$("#UserDoeYy"+id).rules("add", "digits");	
					$("#UserEmpType"+id).rules("add", "required");
					
					$("#UserEmpOther"+id).rules("add", "required");
					
					var m_id =  'UserGender'+id+'Female'      
           			if($('#UserMaritalStatus'+id).val() == 2 && document.getElementById(m_id).checked){
           			$('#spouse'+id).css('display','block');          
					}else 
					  $('#spouse'+id).css('display','none');   
					  
					  if(id.indexOf("C") == -1){
						$('#marital'+id).css('display','block');   
						}else{
						$('#marital'+id).css('display','none');   
			       }
						          	        	
	         	}
         	}  
         	
         	
         	
            });
            function spouse_check(){
         		
      var hid_count1 = $('#hid_count1').val();

         	if(hid_count1 >= 1){
         	var ak = 1;
         	var bk = 1;
         	var ck = 1;
         	var a = $('#adult').val();
	        var b = $('#children').val();
	        var c = $('#infants').val(); 	
	        var ab = parseInt(a) + parseInt(b);
	        for(var i=1;i<=hid_count1;i++ ){  
	         	
	         	if(a != 0 && i <= a){ id = '-A'+ak; ak++;}
				else if(ab != 0 && i <= ab){ id = '-C'+bk; bk++;}
				else{ id = '-I'+ck;	ck++;	}
				
			if(id.indexOf("C") == -1){
						$('#marital'+id).css('display','block');   
						}else{
						$('#marital'+id).css('display','none');   
			       }  
			
            var m_id =  'UserGender'+id+'Female'
            
            if($('#UserMaritalStatus'+id).val() == 2 && document.getElementById(m_id).checked){
           		$('#spouse'+id).css('display','block');          
					}else{
				$('#spouse'+id).css('display','none');	
					} 	 
				}
			}
            }
            
	</script>