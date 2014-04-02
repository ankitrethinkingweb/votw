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
</style>
<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
					<div class="widget-head orange">
							<h3>My Extensions</h3>
						</div>
						<div class=" information-container">
						 <?php echo $this->Session->flash(); ?>
						 	<?php echo $this->Form->create('User', array('action'=>'apply_extension_for_visa','id'=>'extension_visa','class'=>'form-horizontal','novalidate'=>'novalidate')); ?>	
						 	<input type = "hidden" name = "selected" value = 0 />
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><input type = "checkbox" name = "select_all" id = "select_all"  /></th>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('User Name');?></th>
							<?php } ?>
							<th><?php echo __('Visa App No');?></th>
							<th><?php echo __('Name');?></th>			
							<th><?php echo __('Visa');?></th>
							<th><?php echo __('Last Date of Exit');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {  
								$sl++;
								echo "<tr id = 'ext".$row['a']['app_id']."' >";	
								echo "<td ><input class = 'chk' type = 'checkbox' id = 'select-".$row['a']['app_id']."' name = 'select[]' value = '".$row['a']['app_id']."'/></td>";
								
								if($this->UserAuth->getGroupName() != 'User') {
								echo "<td>";								
								if(isset($username[$row['b']['user_id']])) echo $username[$row['b']['user_id']]; else echo 'NA';
								echo "</td>";
								}	
								
								echo "<td>";
								if(isset($row['a']['app_no']))
								echo $row['a']['app_no'];
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['a']['first_name']) && isset($row['a']['last_name']))
								echo $row['a']['first_name'] . ' '.$row['a']['last_name'];
								else
								echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($visa_type[$row['b']['visa_type']]))
								echo $visa_type[$row['b']['visa_type']];
								else
								echo 'NA';
								echo "</td>";
													
								echo "<td>";
								if(isset($row['a']['last_doe']) && strlen($row['a']['last_doe']) > 0){
								echo date('d M Y',strtotime($row['a']['last_doe']));
								//$date3 = strtotime($row['a']['date_of_exit']);
								$date1 = date('Y-m-d',strtotime($row['a']['date_of_exit']));
								$date1 = strtotime( '+10 day' , strtotime ( $date1 ) );
								$date2 = strtotime(date('Y-m-d'));
								$date3 = abs($date1 - $date2);
								$date4 = floor($date3/(24*60*60));
								echo "<br/><b style = 'color:red;'>Remaining Day(s) : ".$date4.' days</b>'; 
								}else
								echo 'NA';
								echo "</td>";
						
							echo "</tr>";
							}
						}?>
							</tbody>
						</table>
					
						<div class="form-actions">		
						<button type="submit" class="btn btn-primary" style="margin-left: 10px;"> Apply </button>	
						<button type="button" class="btn btn-primary" style="margin-left: 10px;" onclick = "not_apply();" > Exit </button>						 
						</div>	
						<?php echo $this->Form->end(); ?>		
					</div>
				</div>
			</div>	
		</div>
	</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style = "background-color:#fff">&times;</button>
			<h4 class="modal-title">Do Not Apply For Extension</h4>
			</div>
			<div id="divMsg"></div>
			<form class='form-horizontal' novalidate='novalidate' id='frm'>
			
			<div class="modal-body" id="m_bdy">
			</div>
			
		<!--<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Save Date</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>-->
			</form>
		</div>
	</div>
</div>	

<style>
.space{
margin:5px;
}
</style>

<script type = "text/javascript">

$('#select_all').change(function() {
    var checkboxes = $(this).closest('table').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.attr('checked', 'checked');
    } else {
        checkboxes.removeAttr('checked');
    }
});

       
 $(function () {
  $("#frm").validate({

                    rules: {
	                     	'data[exit_date]' :{ 
	                     		required :true,
	          				  },
	          				  'data[reason]' :{ 
	                     		required :true,
	          				  },
          				  },
          		  messages :
          		  {
          		  
          		  },
          		  submitHandler:function(form) {
          		  $("#action").show();
          		  $.ajax({
					url: "<?php echo $this->webroot; ?>usermgmt/users/do_not_apply",
					dateType:'html',
					type:'post',
					data:$('#frm').serialize(),
					success: function(data){
					if(data == 'Success')
						{
							location.href = "<?php echo $this->webroot; ?>all_extension";
						}else alert('Some Error Occured');
						},complete:function(){
				        	 $("#action").hide();
				         } 
					});
						return false;
          		  }
          		  });
          		  
			
              var oTable =  $('#data-table').dataTable({
               		"aaSorting": [],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
             		"bSortCellsTop": true,
   			"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns":[0,1,2,3],    
	            },
	            {
	               "sExtends": "xls",
	               "mColumns": [0,1,2,3],   
	            },
	            {
					"sExtends": "pdf",
		            "mColumns": [0,1,2,3],
				},
			]
		}
    });
});
   
       function not_apply(){
          var chkId = '';
        $('.chk:checked').each(function() {
        var chk = $(this).val();
        if(chk.length  > 0)
          chkId += $(this).val() + ",";
        });
        chkId =  chkId.slice(0,-1)// Remove last comma
        if(chkId.length > 0 ){
        $.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/do_not_apply_form",
				dateType:'html',
				type:'post',
				data:'id='+chkId,
				success: function(data){
					if(data != 'Error')
						{
							$('#divMsg').html('');
							$('#m_bdy').html(data);
							$("#myModal").modal('toggle');
						}
					}
				});
				return false;
				}else alert('Select a Application');
       }
       
</script>