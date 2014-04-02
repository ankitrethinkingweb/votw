<style>
.drop_width{
width:164px;
}

.dataTables_filter{
text-align:left!important;
}

.form-horizontal textarea.error,
{
border:1px solid red;
}
span.errorMsg{
background-color:#DF302A!important;
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

<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<?php if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.oktb_add') == 0){ }else{ ?>
<p><a class="btn btn-extend" href="<?php echo $this->webroot; ?>oktb" >Add OKTB Application(s)</a></p>
<?php } ?>
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<input type = "hidden" name = "paid" id = "paid" value = "<?php if(isset($paid)) echo $paid ; else echo 0;?>" />
							<h3><?php if(isset($all_app) || $this->UserAuth->getGroupName() == 'User' ) { echo "All OKTB Application(s)"; }else { ?>Paid OKTB Application(s)<?php } ?></h3>
						</div>

					<div class=" information-container">
						<div class="tab-widget">
							<ul class="nav nav-tabs" id="myTab2">
								<li id = "act1"><a href="#notify1" onclick = "single()"> Individual OKTB </a></li>
								<li id = "act2"><a href="#notify2" onclick = "group()"> Group OKTB </a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane " id="notify1"></div>
								<div class="tab-pane" id="notify2"> </div>
							</div>	
						</div>	
						<center><img src =  "<?php echo $this->webroot; ?>app/webroot/images/load.gif" style = "display:none" id = "load" /></center>						
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	
<style>
.space{
margin:5px;
}

</style>


<script type = "text/javascript">

 $(function () {
 var paid = $('#paid').val();
 var hidVal = '<?php echo $this->UserAuth->getGroupName(); ?>';
var groupView = '<?php if(isset($group)) echo $group; else echo 0; ?>';
//var groupView = 1;
  
 $("#load").show();
 
 if(groupView == 1){
$('#myTab2 #act2').addClass('active');
$('#notify2').addClass('active');

 $.ajax({
			url: "<?php echo $this->webroot; ?>oktb_view",
			dateType:'html',
			data: 'value='+2+'&paid='+paid+'&status=0',
			type:'post',
				success: function(data){
					 $('#notify2').html(data);
					  $('#notify1').html('');
				},complete:function(){
					 $("#load").hide();
				}    			
			});
 }else{
 $('#myTab2 #act1').addClass('active');
$('#notify1').addClass('active');

  $("#load").show();
 $.ajax({
			url: "<?php echo $this->webroot; ?>oktb_view",
			dateType:'html',
			data: 'value='+1+'&paid='+paid+'&status=0',
			type:'post',
				success: function(data){
					 $('#notify1').html(data);
					  $('#notify2').html('');
				},complete:function(){
					 $("#load").hide();
				}    			
			});
		}	
    });

 function single(){

 var paid = $('#paid').val();
 
  $('#notify1').html('');
        $("#load").show();
		$.ajax({
			url: "<?php echo $this->webroot; ?>oktb_view",
			dateType:'html',
			data: 'value='+1+'&paid='+paid+'&status=0',
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
            
 function group(){
 
 $('#notify2').html('');
 var paid = $('#paid').val();
        $("#load").show();
		
        $.ajax({
			url: "<?php echo $this->webroot; ?>oktb_view",
			dateType:'html',
			data: 'value='+2+'&paid='+paid+'&status=0',
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