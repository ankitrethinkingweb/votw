<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<style>
#my_file {
    display: none;
}
input.error,select.error
{
border:1px solid red;
}
#get_file {
width: 10px;
position: absolute;
cursor: pointer;
margin-left: 40px;
background:red;
}
#customfileupload
{
background: #f5f5f5;
margin: 0;
padding: 1px;
border: 1px solid #ebebeb;
vertical-align: top;
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
color: #646464;
resize: none;
width: 75px;
}
.notify-info{
margin:5px;
font-size:12px!important;
}

.date_style{
width: 59px;
font-size: 12px;
margin-left:2px;
} 

.airline_select{
min-width : 100px!important;
}

.message1{
padding:7px 13px!important;
}

.nav-tabs {
font-weight: bold;
font-size: 13px;
}

.nav-tabs > li {
width: 49%;
text-align: center;
}
</style>


		
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>OK To Board</h3>
						</div>
							 	<div class="widget-container">
						<?php echo "<h3>OKTB Verification</h3>
						<div class='alert alert-info'>
						<span class = 'notify-info'>1. You can apply for OK to Board services ONLY if you have CONFIRMED return tickets.</span><br/>
						<span class = 'notify-info'>2. Please call 0222693251 for urgent OKTB request.</span><br/>
						<span class = 'notify-info'>3. Also, Oman Air OKTB requires return tickets from Oman Air only.</span><br/>
						<span class = 'notify-info'>4. Please send online OKTB request 24 hours before the departure date. Excepts Sundays & National Holidays.</span><br/>
						<span class = 'notify-info'>5. Please request for the following airlines 48 hours prior to the traveling time. 
						<strong>( Kuwait Airlines, Gulf Airlines, Eithad Airlines, Qatar Airlines, Oman Airlines )</strong> 
						</span><br/>
						<span id = 'notice' class = 'notify-info'><strong>IMPORTANT NOTICE</strong> : If  5 or more passenger with same PNR numbers/Group request. Please send Such OKTB application on OKTB@gbmgulf.com. Also, please notify the OKTB desk.</span></div>";?>
						<div class="tab-widget">
						<ul class="nav nav-tabs" id="myTab2">
							<li id = "act"><a href="#notify1" onclick = "apply()"> Individual OKTB </a></li>
							<li><a href="#notify2" onclick = "group_oktb()"> Group OKTB </a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane " id="notify1"></div>
							<div class="tab-pane" id="notify2"> </div>
						</div>	
					</div>
					<center><img src =  "<?php echo $this->webroot; ?>app/webroot/images/load.gif" style = "display:none" id = "load" /></center>						
					
				</div>
			</div>	
<div style="clear:both;">&nbsp;</div>
			</div>
</div>
</div>
<script type="text/javascript">
	
	$(document).ready(function(){
	 $("#load").show();
	$.ajax({
			url: "<?php echo $this->webroot; ?>apply_oktb",
			dateType:'html',
			type:'post',
				success: function(data){
					 $('#notify1').html(data);
					  $('#notify2').html('');
				},complete:function(){
					 $("#load").hide();
				}    			
			});
			
$('#myTab2 li:first').addClass('active');
$('#notify1').addClass('active');
	});
	
	 function apply(){
        $("#load").show();
		$('#notify1').html('');
        $.ajax({
			url: "<?php echo $this->webroot; ?>apply_oktb",
			dateType:'html',
			type:'post',
				success: function(data){
					$('#notify2').html('');
					$('#notify1').html(data);
				},complete:function(){
					 $("#load").hide();
				}    			
			});
				return false;
            }    
            

	 function group_oktb(){
        $("#load").show();
		 $('#notify2').html('');
        $.ajax({
			url: "<?php echo $this->webroot; ?>group_oktb",
			dateType:'html',
			type:'post',
				success: function(data){
				  $('#notify1').html('');
				 $('#notify2').html(data);
				},complete:function(){
					 $("#load").hide();
				}    			
			});
				return false;
            }   

</script>