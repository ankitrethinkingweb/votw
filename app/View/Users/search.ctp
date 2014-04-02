<div class="container-fluid">

			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Reporting</h3>
						</div>
							 	<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User', array('action' => 'search_result3','class'=>"form-inline",'novalidate'=>'novalidate','id'=>'kuch_bhi')); ?>
						<div class="control-group" >
											<label class="control-label"><?php echo __('Select Application Type');?></label>
											<div class="controls">
											<?php if(!isset($app_type)) $app_type = array('select'=>'Select'); ?>
											<?php echo $this->Form->input("agent" ,array("type"=>"select",'label' => false,'div' => false,'options'=>$app_type,'style'=>'float:left;width:356px;','onchange'=>'get_app_type(this.value)'))?>
											<img src = "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" id = "load" style = "margin: 10px;float:left;display:none;"/>
											</div>
									</div> 
									<div style = "clear:both"></div>
						
										<div id="categotySelect">
										
										</div>
										
								
								
										
								<div style="clear:both;"></div>		
											<div class="form-actions" id="buttonDiv" style="display:none;">
											<input type="Button" class="btn btn-primary" onclick="getReportx()" id="searchButton" value="Search Applications" />	
											<input type="Button" class="btn btn-primary" onclick="getXml()"  value="Export XLS Report" />	
											<input type="Button" class="btn btn-primary" onclick="getPdf()"  value="Export PDF Report" />	
											<img src = "<?php echo $this->webroot; ?>app/webroot/images/ajax-loader.gif" id = "load" style = "margin: 10px;float:left;display:none;"/>
										
								</div>
								
							</form>
                            <div id="searchResult" class="row-fluid"></div>
						</div>
						<div>
						</div>
						<img src = "<?php echo $this->webroot; ?>app/webroot/images/load.gif"  id = "loadx" style = "margin: 10px;margin-left:45%;display:none;"/>
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
$(document).ready(function(){


});
function getReportx(){
 $('#searchResult').html('');
var app_no = '';
var visa_type = $('#visa_type').val();
var internal_status = $('#internal_status').val();
var agent_name = $('#agent_name').val();
var pnr_no = $('#pnr_no').val();
var external_status = $('#external_status').val();
var app_type = $('#app_type').val();
var app_no = $('#app_no').val();
var oktb_no = $('#oktb_no').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var airline_type = $('#airline_type').val();
var passport_no = $('#passport_no').val();
var psg_name = $('#psg_name').val();
var doe = $('#doe').val();
var export_type = $('#export_type').val();
if(visa_type == null  && agent_name == null && external_status == null && internal_status == null &&  app_no.length == 0 && passport_no.length == 0 && psg_name.length == 0 && from_date.length == 0 && doe.length == 0 && to_date.length == 0 && airline_type == undefined && oktb_no.length == 0 && pnr_no.length == 0){
alert("Choose atleast 1 filter");
} else {
$("#loadx").css('display','block');
$.ajax({
	      url: "<?php echo $this->webroot; ?>users/search_result2",
	      dateType:'html',
	      type:'post',
		  data:'type='+app_type+'&agent_name='+agent_name+'&internal_status='+internal_status+'&external_status='+external_status+'&visa_type='+visa_type+'&app_no='+app_no+'&passport_no='+passport_no+'&psg_name='+psg_name+'&from_date='+from_date+'&to_date='+to_date+'&airline_type='+airline_type+'&oktb_no='+oktb_no+'&doe='+doe+'&pnr_no='+pnr_no+'&export_type='+export_type,
	      success: function(data){	    
	      	 $('#searchResult').html(data);
	      },complete:function(){
 		$("#loadx").css('display','none');
         }             
	    });
		
}
}




function getXml(){
var app_no = '';
var visa_type = $('#visa_type').val();
var internal_status = $('#internal_status').val();
var pnr_no = $('#pnr_no').val();
var agent_name = $('#agent_name').val();
var external_status = $('#external_status').val();
var app_type = $('#app_type').val();
var app_no = $('#app_no').val();
var oktb_no = $('#oktb_no').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var airline_type = $('#airline_type').val();
var passport_no = $('#passport_no').val();
var psg_name = $('#psg_name').val();
var doe = $('#doe').val();
var export_type = $('#export_type').val();
if(visa_type == null  && agent_name == null && external_status == null && internal_status == null &&  app_no.length == 0 && passport_no.length == 0 && psg_name.length == 0 && from_date.length == 0 && doe.length == 0 && to_date.length == 0 && airline_type == undefined && oktb_no.length == 0 && pnr_no.length == 0){
alert("Choose atleast 1 filter");
}else {
document.location.href = '<?php echo $this->webroot; ?>users/search_result3/?type='+app_type+'&agent_name='+agent_name+'&internal_status='+internal_status+'&external_status='+external_status+'&visa_type='+visa_type+'&app_no='+app_no+'&passport_no='+passport_no+'&psg_name='+psg_name+'&from_date='+from_date+'&to_date='+to_date+'&airline_type='+airline_type+'&oktb_no='+oktb_no+'&doe='+doe+'&pnr_no='+pnr_no+'&export_type='+export_type+'&ex_type=xls';
		
}
}



function getPdf(){
var app_no = '';
var visa_type = $('#visa_type').val();
var internal_status = $('#internal_status').val();
var pnr_no = $('#pnr_no').val();
var agent_name = $('#agent_name').val();
var external_status = $('#external_status').val();
var app_type = $('#app_type').val();
var app_no = $('#app_no').val();
var oktb_no = $('#oktb_no').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var airline_type = $('#airline_type').val();
var passport_no = $('#passport_no').val();
var psg_name = $('#psg_name').val();
var doe = $('#doe').val();
var export_type = $('#export_type').val();
if(visa_type == null  && agent_name == null && external_status == null && internal_status == null &&  app_no.length == 0 && passport_no.length == 0 && psg_name.length == 0 && from_date.length == 0 && doe.length == 0 && to_date.length == 0 && airline_type == undefined && oktb_no.length == 0 && pnr_no.length == 0){
alert("Choose atleast 1 filter");
}else {
document.location.href = '<?php echo $this->webroot; ?>users/search_result3/?type='+app_type+'&agent_name='+agent_name+'&internal_status='+internal_status+'&external_status='+external_status+'&visa_type='+visa_type+'&app_no='+app_no+'&passport_no='+passport_no+'&psg_name='+psg_name+'&from_date='+from_date+'&to_date='+to_date+'&airline_type='+airline_type+'&oktb_no='+oktb_no+'&doe='+doe+'&pnr_no='+pnr_no+'&export_type='+export_type+'&ex_type=pdf';
		
}
}


$(".chzn-select").chosen();
function alertx(id){
	$.ajax({
	      url: "<?php echo $this->webroot; ?>viewTrans",
	      dateType:'html',
	      type:'post',
	      data:'id='+id,
	      success: function(data){	    
	      	 bootbox.alert(data, function () {
        
   			 });
	      },         
	    })
   
} $("#arrival_date,#departure_date").datepicker({ 
			   showWeek: true, 
			   showButtonPanel: true, 
		       changeMonth: true, 
		       changeYear: true,
			   dateFormat: 'dd-mm-yy', 
		       yearRange:'1947:' + (new Date().getFullYear() + 2),
			   });

 $(function () {
                
            });
            
              function get_receipt(id)
       {
       appdetail=window.open("<?php echo $this->webroot; ?>Users/get_receipt/"+id, "mywindow", ",left=50,top=100,location=0,status=0,scrollbars=0,width=600,height=600");
	 	appdetail.focus();
		}
		
function get_app_type(id){
if(id != 'select'){
$("#buttonDiv").css('display','block');
} else {
$("#buttonDiv").css('display','none');
}
$("#load").css('display','block');
	$.ajax({
	      url: "<?php echo $this->webroot; ?>users/app_report_filter",
	      dateType:'html',
	      type:'post',
	      data:'id='+id,
	      success: function(data){	    
	      	 $('#categotySelect').html(data);
	      	 $('#searchResult').html(' ');
	      },complete:function(){
 		$("#load").css('display','none');
         }            
	    })
		}
</script>