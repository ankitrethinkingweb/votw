<?php 
//echo $this->Html->script('jquery.ui.datepicker');
echo $this->Html->script('jquery.validate');
//echo $this->Html->script('visa_app_validation');
echo $this->fetch('script');	
?>
<style type="text/css">
label
{
display:inline-block;
margin-left:10px;
margin-right:20px;
}

input[type=text].error,
{
border:1px solid red;
}

p{
margin:0 0 -22px;
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
							<?php 
							echo $this->Form->create('User', array('action' => 'save_upload','id'=>'attachment','class'=>'form-horizontal','novalidate'=>'novalidate', 'enctype'=>'multipart/form-data')); ?>					
								
										<input type = "hidden" value = "<?php if(isset($groupId)) echo $groupId; ?>" name = 'groupId' id = "groupId"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['count'])) echo $data['User']['count']; ?>" name = 'hid_count1' id = "hid_count1"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['adult'])) echo $data['User']['adult']; ?>" name = 'adult' id = "adult1"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['children'])) echo $data['User']['children']; ?>" name = 'children' id = "children1"/>
										<input type = "hidden" value = "<?php if(isset($data['User']['infants'])) echo $data['User']['infants']; ?>" name = 'infants' id = "infants1"/>
			
		<div class="accordion" id="accordion2">
						
								<?php if(isset($data['User']['count']))
								 $j = $data['User']['count']; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1;
								 for($i=1;$i<=$j;$i++){
								 $a = $data['User']['adult']; $b = $data['User']['adult']+$data['User']['children'];  
								
								 if($a != 0 && $i <= $a){ $heading = 'Adult - '.$ak; $id = '-A'.$ak; $ak++;}
								 else if($b != 0 && $i <= $b){$heading = 'Children - '.$bk;	$id = '-C'.$bk;	$bk++;}
								 else{ $heading = 'Infants - '.$ck; $id = '-I'.$ck;	$ck++;	}?>	
								
								<?php echo $this->Form->input("app_no".$id ,array('type' => 'hidden','label' => false,'div' => false,'value'=>$data['User']['app_no'.$id]))?> 
								<div class="accordion-group">
								<div class="accordion-heading">
									<a href="#collapse<?php echo $i; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle"><?php echo $heading; ?><span class="caret whitecaret"></span></a>
								</div>
								<div class="accordion-body collapse <?php if($i == 1) echo 'in'; ?>" id="collapse<?php echo $i; ?>">
									<div class="accordion-inner">
										<legend>Required documents - <?php echo $i;?></legend>
<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Passport First Page');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:150Kb) </span></label>
											
									<div class="controls">
										
												<?php echo $this->Form->file("pfp".$id ,array('label' => false,'div' => false,'id'=>"pfp".$id))?>
												
									</div>
								
								</div>

								<div class="control-group">
											<label class="control-label"><?php echo __('Passport Last Page');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:150Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("plp".$id ,array('label' => false,'div' => false,'id'=>"plp".$id))?>
												
									</div>
								</div>

								<div class="control-group">
											<label class="control-label"><?php echo __('Passport Observation Page');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("pop".$id ,array('label' => false,'div' => false,'id'=>"pop".$id))?>
												
									</div>
								</div>
</div>
<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Address Page');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("addr".$id ,array('label' => false,'div' => false,'id'=>"addr".$id))?>
												
									</div>
								</div>

								<div class="control-group">
											<label class="control-label"><?php echo __('Photograph');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:30Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("photograph".$id ,array('label' => false,'div' => false,'id'=>"photograph".$id))?>
												
									</div>
								</div>
</div>
<div style="clear:both;"></div>
<legend>Optional documents - <?php echo $i;?></legend>
<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Ticket 1');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("ticket1".$id ,array('label' => false,'div' => false,'id'=>"ticket1".$id))?>
												
									</div>
								</div>
								
								<div class="control-group">
											<label class="control-label"><?php echo __('Ticket 2');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("ticket2".$id ,array('label' => false,'div' => false,'id'=>"ticket2".$id))?>
												
									</div>
								</div>
								</div>
								<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Ticket 3');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>																	</label>
									<div class="controls">
										
												<?php echo $this->Form->file("ticket3".$id ,array('label' => false,'div' => false,'id'=>"ticket3".$id))?>
												
									</div>
								</div>
									</div>
										<div style="clear:both"></div>
										</div>
								</div>
							</div>
								<?php }  ?>	
							
						
					</div>
					<div class="accordion-group">
								<div class="accordion-heading">
									<a href="#collapse<?php echo $i; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle"><?php echo 'Additional Details'; ?><span class="caret whitecaret"></span></a>
								</div>
								<div class="accordion-body collapse <?php if($i == 1) echo 'in'; ?>" id="collapse<?php echo $i; ?>">
									<div class="accordion-inner">
										
<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Additional Document  1');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("add_doc1",array('label' => false,'div' => false))?>
												
									</div>
									</div>
									<div class="control-group">
											<label class="control-label"><?php echo __('Additional Document  2');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("add_doc2",array('label' => false,'div' => false))?>
												
									</div>
								</div>
								</div>
								<div style="float:left;width:50%">
								<div class="control-group">
											<label class="control-label"><?php echo __('Additional Document  3');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("add_doc3",array('label' => false,'div' => false))?>
												
									</div>
									</div>
									<div class="control-group">
											<label class="control-label"><?php echo __('Additional Document  4');?><span style="font-size: 11px; font-weight: normal; color: Black">&nbsp;&nbsp; (Filesize:100Kb) </span></label>
									<div class="controls">
										
												<?php echo $this->Form->file("add_doc4",array('label' => false,'div' => false))?>
												
									</div>
								</div>
								</div>
								<div style="clear:both"></div>
								</div>
								</div>
								</div>
									<button type="submit" class="finish btn btn-extend"> Finish!</button>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	
	<script type='text/javascript'>
	  $(function () {


$.validator.addMethod("File", function(value, element) {

    return this.optional(element) || /(?:^|\/|\\)((?:[a-z0-9_\s\(\)\[\]])*\.(?:pdf|gif|jpg|jpeg|png))$/i.test(value);
}, "Invalid file type");
jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|png|jpe?g|gif";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));
              $.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
},jQuery.format("Please check file size"));  
             $("#attachment").validate({  
			
			invalidHandler: function(event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message = errors == 1
        ? 'You missed 1 field. It has been highlighted'
        : 'You missed ' + errors + ' fields. They have been highlighted. Please Check...';
      $("div.message span").html(message);
 $('html, body').animate({ scrollTop: 130 }, 'fast');
      $("div.message").show();
    } else {
      $("div.message").hide();
    }
  },
  	
                    rules: {
				'data[User][photograph-A1]': {
                         required: true,
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "30720"  
	                        }, 
	                        
	                        'data[User][pfp-A1]': {
                         required: true,
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "153600"  
	                        }, 
	                        
	                        'data[User][plp-A1]': {
                         required: true,
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "153600"  
	                        }, 
	                        'data[User][addr-A1]': {
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
	                        'data[User][pop-A1]': {
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
                                       
				 
				 'data[User][ticket1-A1]': {
                        
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
	                        'data[User][ticket2-A1]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
	                        'data[User][ticket3-A1]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
	                        'data[User][add_doc1]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },
	                        'data[User][add_doc2]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },
	                        'data[User][add_doc3]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        },
	                        'data[User][add_doc4]': {
                         
                       	  extension: "pdf|png|jpe?g|gif", 
                       	  filesize: "102400"  
	                        }, 
                    
					  
                    }  
                });
				
      var hid_count1 = $('#hid_count1').val();
         
         	if(hid_count1 > 1){
         	var ak = 2;
         	var bk = 1;
         	var ck = 1;
	         	for(var i=2;i<=hid_count1;i++ ){  
	         	var a = $('#adult1').val();
	         	var b = $('#children1').val();
	         	var c = $('#infants1').val(); 	
	         	var ab = parseInt(a) + parseInt(b);
	         	
				if(a != 0 && i <= a){ id = '-A'+ak; ak++;}
				else if(ab != 0 && i <= ab){ id = '-C'+bk; bk++;}
				else{ id = '-I'+ck;	ck++;	}

		         	//$("#photograph"+id).rules("add", "required");
		         	$("#photograph"+id).rules("add", {
		         	required:true,
		         	extension:"png|jpe?g|gif",
		         	filesize:"30720"
		         	});
		         	
					//$("#pfp"+id).rules("add", "required");	
					$("#pfp"+id).rules("add", {
					required:true,
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"153600"
		         	});
					//$("#plp"+id).rules("add", "required");
					$("#plp"+id).rules("add", {
					required:true,
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"153600"
		         	});
				//	$("#pop"+id).rules("add", "required");
					$("#pop"+id).rules("add", {
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});
					//$("#addr"+id).rules("add", "required");	  
					$("#addr"+id).rules("add", {
					
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});   	
					
					
		         	$("#ticket1"+id).rules("add", {
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});			  
					
					$("#ticket2"+id).rules("add", {
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});     						
					
					$("#ticket3"+id).rules("add", {
		         	extension:"pdf|png|jpe?g|gif",
		         	filesize:"102400"
		         	});				
						           	        	
	         	}
         	}      	
         	
         	
            });
	</script>