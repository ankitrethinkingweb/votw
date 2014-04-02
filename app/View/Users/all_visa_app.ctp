<?php 
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>
<style>
.dataTables_filter{
text-align:left!important;
}
</style>
<?php if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_add') == 0){ }else{ ?>
<p ><a class="btn btn-extend" href="<?php echo $this->webroot; ?>quick_app" >Add Visa Application</a></p>
<?php } ?>
<?php 	//echo $this->NumberToWord->convert_number_to_words(8769); ?>
<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3><?php if(isset($application) || $this->UserAuth->getGroupName() != 'Admin' ) { echo "All Visa Applications"; }else { ?>Paid Visa Applications<?php } ?></h3>
						</div>

						 <div class=" information-container">
						 <?php if(isset($visa_apps) && count($visa_apps) == 200){ ?>
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php if(isset($application) && $application == 'all'){ $url = $this->webroot.'all_visa_app2/all/1';  }else $url = $this->webroot.'all_visa_app/0/1';?>
				<i class="icon-exclamation-sign"></i>Only Recent 200 records are shown, To view all records. <a href = "<?php echo $url; ?>" >Click Here</a>.
			</div>
			<?php } ?>
						<?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('User Name');?></th>
							<?php } ?>
							<th><?php echo __('Group Number');?></th>
							<th><?php echo __('Name of Applicant');?></th>								
							<th><?php echo __('Visa Type');?></th>					
							<th><?php echo __('Tentative Date of Travel');?></th>	
							<th><?php echo __('No. of Travellers');?></th>						
							<th><?php echo __('Status');?></th>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('Admin Status');?></th>
							<?php } ?>
							<th><?php echo __('Actions');?></th>
							<th><?php echo __('Sort Date');?></th>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('Status');?></th>
							<?php } ?>
							<th><?php echo __('Applied Date');?></th>
							<th><?php echo __('Amount');?></th>
							
							</tr>
							<tr>
								
							<?php if($this->UserAuth->getGroupName()  != 'User') { ?><td></td><?php } ?>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<?php if($this->UserAuth->getGroupName()  != 'User') { ?><td></td><?php } ?>
									<td></td>
									<td></td>
									<?php if($this->UserAuth->getGroupName() != 'User') { ?><td></td><?php } ?>
									<td></td>
									<td></td>
								</tr>	
							
							</thead>
							<tbody>
			<?php       if (!empty($visa_apps)) {
							$sl=0;
							foreach ($visa_apps as $row) { //echo '<pre>'; print_r($username[$row['visa_app_group']['user_id']]); exit;
								$sl++;
								echo "<tr>";
										
								echo "<input type = 'hidden' name = 'groupId' value = '".$row['visa_app_group']['group_id']."'/>";
								if($this->UserAuth->getGroupName() != 'User') { 
								echo "<td>";
								if(isset($row['visa_app_group']['role_id']) && $row['visa_app_group']['role_id'] != null && strlen($row['visa_app_group']['role_id']) > 0)
								echo "<i class = 'icon-info-sign' style = 'color:red;' title = 'Offline' ></i>&nbsp;&nbsp;";								
								if(isset($username[$row['visa_app_group']['user_id']])) echo $username[$row['visa_app_group']['user_id']]; else echo 'NA';
								echo "</td>";
								}								
								echo "<td>";
								if(isset($row['visa_app_group']['group_no'])){
								
								if(isset($row['visa_app_group']['app_type']) && strlen($row['visa_app_group']['app_type']) > 0)
								echo '<span class="label label-info">(Quick App)</span><br/>'; 
								echo $row['visa_app_group']['group_no'] . ' ';
								if(isset($app[$row['visa_app_group']['group_id']])){
								echo '<br/><strong>Application No. :  </strong>'; $name = '';
									/*foreach($app[$row['visa_app_group']['group_id']] as $a_id){
									if(strlen($name) > 0)  $name .= ' ,<br/>';
										$name .= $appNo[$row['visa_app_group']['group_id']][$a_id].' ';
									}*/
									$name .= $appNo[$row['visa_app_group']['group_id']];
									echo $name; 
								}
								
								}else echo 'NA';
								echo "</td>";
echo "<td>";
								if(isset($gname[$row['visa_app_group']['group_id']])){ $name2 = '';
									echo $gname[$row['visa_app_group']['group_id']]; 
								}
								else echo 'NA';
								echo "</td>";	
																											
								echo "<td";
								if(isset($visa_status[$row['visa_app_group']['visa_type']]) && $visa_status[$row['visa_app_group']['visa_type']] == 0) echo " style='color:red'";
								echo ">";
								if(isset($visa_type[$row['visa_app_group']['visa_type']]) ) echo $visa_type[$row['visa_app_group']['visa_type']]; else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_app_group']['tent_date'])) echo date('d M Y',strtotime($row['visa_app_group']['tent_date'])); else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_app_group']['adult']) && isset($row['visa_app_group']['children']) && isset($row['visa_app_group']['infants'])) 
								echo 'Adult(s):'.$row['visa_app_group']['adult'].' <br/>Children:'.$row['visa_app_group']['children'].' <br/>Infants:'.$row['visa_app_group']['infants'] ;
								else echo 'NA';
								echo "</td>";
								
								echo "<td><span class = 'change_status".$row['visa_app_group']['group_id']."'>";
									if($this->UserAuth->getGroupName()  != 'User'){
if((isset($application) && $application == 'all')){
		if(isset($tr_status[$row['visa_app_group']['tr_status']])) 
			echo $tr_status[$row['visa_app_group']['tr_status']] ; else echo '-';
}else if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_status') == 0){
		if(isset($tr_status[$row['visa_app_group']['tr_status']])) 
			echo $tr_status[$row['visa_app_group']['tr_status']] ; else echo '-';
			}else{
			echo '<input type = "hidden" name = "app_date'.$row['visa_app_group']['group_id'].'" id = "app_date'.$row['visa_app_group']['group_id'].'" value = "'.$row['visa_app_group']['apply_date'].'" />';									
			echo '<input type = "hidden" name = "prev'.$row['visa_app_group']['group_id'].'" id = "prev'.$row['visa_app_group']['group_id'].'" value = "'.$row['visa_app_group']['tr_status'].'" />';									

echo $this->Form->input("status" ,array("style"=>"width:100px","type"=>"select",'label' => false,'div' => false,'class'=>'drop_width','options'=>$tr_status,'selected'=>$row['visa_app_group']['tr_status'],'id'=>'status'.$row['visa_app_group']['group_id'],'onchange'=>"approve_visa(".$row['visa_app_group']['group_id'].",".$row['visa_app_group']['user_id'].",".$row['visa_app_group']['visa_type'].")"));
echo '<img src =  "'.$this->webroot.'app/webroot/images/ajax-loader.gif" style = "display:none;" id = "action'.$row['visa_app_group']['group_id'].'" />';

if($tr_status[$row['visa_app_group']['tr_status']] == 'Approved'){
if($row['visa_app_group']['visa_path'] != '')
$link = 'Change Visa Uploaded'; else $link = 'Upload Visa'; 
echo '<br/><a href = "'.$this->webroot.'upload_visa/'.$row['visa_app_group']['group_id'].'" id = "appr_upload'.$row['visa_app_group']['group_id'].'" ">'.$link.'</a>';
}
}
}else {
if(isset($tr_status[$row['visa_app_group']['tr_status']])) 
							echo $tr_status[$row['visa_app_group']['tr_status']] ; else echo '-';
							}
if(strlen($row['visa_app_group']['app_comments']) > 0 && $row['visa_app_group']['app_comments'] != null && isset($row['visa_app_group']['app_comments']))
echo '<br/><a href="javascript:void(0);" onclick="show_comment(\''.$row['visa_app_group']['app_comments'].'\')">Show Comment</a>';
								
								echo "</span></td>";
								
								if($this->UserAuth->getGroupName() != 'User' ){
echo "<td><span class = 'change_astatus".$row['visa_app_group']['group_id']."'>";
if((isset($application) && $application == 'all') ){
	if(isset($atr_status[$row['visa_app_group']['admin_tr_status']]) && strlen($atr_status[$row['visa_app_group']['admin_tr_status']]) > 0) 
		echo $atr_status[$row['visa_app_group']['admin_tr_status']] ; else echo '-';
}else if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_status') == 0){
if(isset($atr_status[$row['visa_app_group']['admin_tr_status']]) && strlen($atr_status[$row['visa_app_group']['admin_tr_status']]) > 0) 
		echo $atr_status[$row['visa_app_group']['admin_tr_status']] ; else echo '-';
}else{
		echo '<input type = "hidden" name = "aprev'.$row['visa_app_group']['group_id'].'" id = "aprev'.$row['visa_app_group']['group_id'].'" value = "'.$row['visa_app_group']['admin_tr_status'].'" />';									
		echo $this->Form->input("astatus" ,array("style"=>"width:100px","type"=>"select",'label' => false,'div' => false,'class'=>'drop_width','options'=>$atr_status,'selected'=>$row['visa_app_group']['admin_tr_status'],'id'=>'astatus'.$row['visa_app_group']['group_id'],'onchange'=>"change_admin_tr_status(".$row['visa_app_group']['group_id'].")"));
		echo '<img src =  "'.$this->webroot.'app/webroot/images/ajax-loader.gif" style = "display:none;" id = "aaction'.$row['visa_app_group']['group_id'].'" />';
}
		echo "</span></td>"; }
								
					echo "<td>";
					echo '<div class="btn-toolbar row-action">
                        <div class="btn-group">';
                        if($row['visa_app_group']['tr_status'] == 1){ 
                        if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_apply') == 0){ }else
								echo "<a href='".$this->Html->url('/Users/apply_for_visa/'.$row['visa_app_group']['group_id'].'/'.$row['visa_app_group']['visa_type'])."' title= 'Apply For Visa' class='btn btn-success'><i class='icon-signout'></i></a>";
								}
								if($this->UserAuth->getGroupName() != 'User'){
								if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_export') == 0){ }
								else echo "<a href='".$this->Html->url('/zipData/'.$row['visa_app_group']['group_no'])."' class='btn' title= 'Export Application' ><i class='icon-download-alt' ></i></a>";
								}
								if(isset($application) && $application == 'all') $view = 2; else $view = 1;
								if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_view') == 0){ }
                        		else echo "<a href='".$this->Html->url('/view_visa_app/'.$row['visa_app_group']['group_id'].'/'.$view)."' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
                        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_export') == 0){ }
                        		else echo "<a href='javascript:void(0)' onclick='get_receipt(".$row['visa_app_group']['group_id'].")' class ='btn btn-info' title= 'Print' ><i class='icon-print '></i></a>";								
								
								if($row['visa_app_group']['tr_status'] >= 2 && strlen($row['visa_app_group']['inv_path']) > 0){
								if($this->UserAuth->getGroupName() == 'User'){
								
									if(isset($receipt[$row['visa_app_group']['user_id']]) && $receipt[$row['visa_app_group']['user_id']] == 'Yes'){
										if($receiptT[$row['visa_app_group']['user_id']] == 'Regular')
										 echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/visa/'.$row['visa_app_group']['inv_path'].'"  title= "Download Invoice" class="btn btn-success" download><i class="icon-download"></i></a>';
										else  echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/visa/'.$row['visa_app_group']['inv_admin_path'].'"  title= "Download Invoice" class="btn btn-success" download><i class="icon-download"></i></a>';
										
									}else { }
								
								}else
								   echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/visa/'.$row['visa_app_group']['inv_admin_path'].'"  title= "Download Invoice" class="btn btn-success" download><i class="icon-download"></i></a>';
								
							}
						 echo '</div>
                      </div>';	
                      echo '<div class="btn-toolbar row-action" style = "margin-top:5px;">
                        <div class="btn-group">';	
                        		if($this->UserAuth->getGroupName() == 'User' && $row['visa_app_group']['tr_status'] == 1 || $row['visa_app_group']['tr_status'] == 0){
									echo "<a href='".$this->Html->url('/edit_visa_app/'.$row['visa_app_group']['group_id'])."' title= 'Edit' class='btn btn-danger'><i class='icon-edit'></i></a>";
									echo "<a href='".$this->Html->url('/edit_upload_data/'.$row['visa_app_group']['group_id'])."' title= 'Edit Upload Data' class='btn btn-primary'><i class='icon-cloud-upload'></i></a>";							
								}
								if($this->UserAuth->getGroupName() != 'User' && $row['visa_app_group']['tr_status'] != 5){
								if(isset($application) && $application == 'all') $view = 2; else $view = 1;
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_edit') == 0){ }
									else echo "<a href='".$this->Html->url('/edit_visa_app/'.$row['visa_app_group']['group_id'].'/'.$view)."' title= 'Edit' class='btn btn-danger'><i class='icon-edit'></i></a>";
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_edit') == 0){ }
									else echo "<a href='".$this->Html->url('/edit_upload_data/'.$row['visa_app_group']['group_id'].'/'.$view)."' class='btn btn-inverse' title= 'Edit Upload Data'><i class='icon-cloud-upload'></i></a>";							
									
									if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.visa_delete') == 0){ }
									else echo "<a id = 'delete".$row['visa_app_group']['group_id']."' href='".$this->Html->url('/deleteVisa/'.$row['visa_app_group']['group_id'])."' onclick='return confirm(\"Are you sure you want to delete this application?\")' title= 'Delete Visa' class='btn btn-warning'><i class='icon-remove'></i></a>";
								}
							
							
								if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.visa_view') == 0){ }else{
										if((isset($tr_status[$row['visa_app_group']['tr_status']]) && $tr_status[$row['visa_app_group']['tr_status']] == 'Approved' && $row['visa_app_group']['visa_path'] != null && $row['visa_app_group']['visa_path'] != '')){
											echo "<a href='".$this->Html->url('/download/'.$row['visa_app_group']['group_id'])."' class='btn btn-danger' title= 'Download Visa'><i class='icon-download'></i></a>";
										}
									}
							
								echo "<span id = 'change1".$row['visa_app_group']['group_id']."' style = 'display:none' >";
								echo "<a href='".$this->Html->url('/download/'.$row['visa_app_group']['group_id'])."' title= 'Download Visa' class='btn btn-danger'><i class='icon-download'></i></a>";
								echo "</span>";
                        
                        if(isset($row['visa_app_group']['extend_status']) && $row['visa_app_group']['extend_status'] == 6){
                     		echo "<a href='javascript:void(0);' onclick = 'get_exit_info(".$row['visa_app_group']['group_id'].");' title= 'View Exit Info' class='btn btn-primary'><i class='icon-arrow-right'></i></a>";							
                        }
                          echo '</div>
                      	</div>';								
							echo "</td>";
		
								if(isset($sortDate[$row['visa_app_group']['group_id']]))	
								echo "<td>".$sortDate[$row['visa_app_group']['group_id']]."</td>";
								else echo "<td>0</td>";	
								
								if($this->UserAuth->getGroupName() != 'User'){	
								echo "<td>";
								if(isset($tr_status[$row['visa_app_group']['tr_status']]) && strlen($tr_status[$row['visa_app_group']['tr_status']]) > 0) echo $tr_status[$row['visa_app_group']['tr_status']]; else echo 'NA';
								echo "</td>";
								}
								
								echo "<td>";
								if(isset($row['visa_app_group']['app_date'])) echo date('d M Y',strtotime($row['visa_app_group']['app_date'])); else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['visa_app_group']['visa_fee'])){ echo $row['visa_app_group']['visa_fee']; 
								//if($this->UserAuth->getGroupName() != 'User') && isset($currency[$row['visa_app_group']['group_id']])) echo ' '.$currency[$row['visa_app_group']['group_id']]; 
								}else echo 'NA';
								echo "</td>";
								
								echo "</tr>";
							}
						}?>
					</tbody>
					</table>
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
<h4 class="modal-title">Approve Visa Application</h4>
</div>
<div id="divMsg"></div>
<form class='form-horizontal' novalidate='novalidate' id='frm'>

<div class="modal-body" id="m_bdy">
</div>

<!--<div class="modal-footer">
<button type="submit" class="btn btn-primary">Save Comment</button>
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

 $(function () {
 var hidVal = '<?php echo $this->UserAuth->getGroupName(); ?>';
 	 $("#frm").validate({
                    rules: {
                     	'data[comments]' :{ 
                     	required :true,
                     	 },
          			 },
          		  messages :
          		  {
          		  },
          		  submitHandler:function(form) {
          		   $("#action").show();
          		  var id = $('#appId').val();
          		   $("#action"+id).show(); 
					
          		   	$.ajax({
				      url: "<?php echo $this->webroot; ?>Users/approve_visa",
				      dateType:'json',
				      type:'post',
				      data:$('#frm').serialize(),
				      success: function(data){
				      //alert(data);
				      if(data == 'Success'){
				      		location.href="<?php echo $this->webroot; ?>all_visa_app";
						}else{ 
							alert('Some Error Occured'); 
						}
					 },complete:function(){
			         $("#action").hide();
			         }         
	 			   });
				return false;
          		  }
          		  });
          		  
          		  
			$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
				
				if ( typeof iColumn == "undefined" ) return new Array();
				
				if ( typeof bUnique == "undefined" ) bUnique = true;
				
				if ( typeof bFiltered == "undefined" ) bFiltered = true;
				
				if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
				
			
				var aiRows;
				
				if (bFiltered == true) aiRows = oSettings.aiDisplay; 
				
				else aiRows = oSettings.aiDisplayMaster; // all row numbers
			
				var asResultData = new Array();
				
				for (var i=0,c=aiRows.length; i<c; i++) {
					iRow = aiRows[i];
					var aData = this.fnGetData(iRow);
					var sValue = aData[iColumn];

					// ignore empty values?
					if (bIgnoreEmpty == true && sValue.length == 0) continue;
			
					// ignore unique values?
					else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
					
					// else push the value onto the result data array
					else asResultData.push(sValue);
				}
				return asResultData;
			};
			
			
			function fnCreateSelect( aData )
			{	
				var r='<select style = "width: 90px;"><option value=""></option>', i, iLen=aData.length;
				for ( i=0 ; i<iLen ; i++ )
				{
					r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
				}
				return r+'</select>';
			}
			
			if(hidVal != 'User'){
			
              var oTable =  $('#data-table').dataTable({
              "aoColumnDefs": [{ "bVisible": false, "aTargets": [9] },{ "bVisible": false, "aTargets": [10] },{ "bVisible": false, "aTargets": [11] },{ "bVisible": false, "aTargets": [12] }],
               "aaSorting": [[9, 'desc']],
                    "sDom":  "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                    "bSortCellsTop": true,
               "oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,2,3,4,5,10,11,12],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5,10,11,12],
	                         
	            },
				
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,2,3,4,5,10,11,12],   
					},
			]
		}
                });
                
                }else{
                
                  var oTable =  $('#data-table').dataTable({
	             "aoColumnDefs": [{ "bVisible": false, "aTargets": [7] },{ "bVisible": false, "aTargets": [8] },{ "bVisible": false, "aTargets": [9] }],
	               "aaSorting": [[7, 'desc']],
                    "sDom":  "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                    "bSortCellsTop": true,
                "oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,2,3,4,5,8,9],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5,8,9],
	            },
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ 
					{
						 "sExtends": "csv",
		                "mColumns": [0,1,2,3,4,5,6,9,10],   
					},
					{
						 "sExtends": "xls",
		                "mColumns": [0,1,2,3,4,5,6,9,10],   
					},
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,2,3,4,5,6,9,10],   
					},				
					]
				}
			]
		}
                });
                
                }
                
                	$("thead td").each( function ( i ) {
					
                	if(hidVal != 'User'){
					if(i!= 1 && i != 2 && i!= 5 && i !=6 && i!= 7 && i!= 8 ){
					this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
					$('select', this).change( function () {
						oTable.fnFilter( $(this).val(), i );
					} );
					}
					}else{
					if(i != 0 && i != 1  && i!= 4 && i !=5 && i!= 6 && i != 7){
					this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
					$('select', this).change( function () {
						oTable.fnFilter( $(this).val(), i );
					} );
					}
					}
				} );
            });

       function get_receipt(id)
       {
	       appdetail=window.open("<?php echo $this->webroot; ?>Users/get_receipt/"+id, "mywindow", ",left=50,top=100,location=0,status=0,scrollbars=0,width=600,height=600");
		   appdetail.focus();
	   }
	
	function approve_visa(id,userid,visa_type){  
	
var status = $('#status'+id).val();
var date = $('#app_date'+id).val();
var prev = $('#prev'+id).val();
if(status == 1 && date.length >= 0){
 alert('Invalid Status!!! Visa is already applied.');
 $("#status"+id).val(prev);
}else if(status == 'select'){
alert('Please select a valid status');
 $("#status"+id).val(prev);
}else{
       $.ajax({
				url: "<?php echo $this->webroot; ?>users/approve_visa_form",
				dateType:'html',
				type:'post',
				data:'id='+id+'&status='+status+'&userid='+userid+'&visa_type='+visa_type+'&prev='+prev,
				success: function(data){
					if(data != 'Error')
						{
							$('#divMsg').html('');
							$('#m_bdy').html(data);
							$("#myModal").modal('toggle');
						}
					}
				});
	    }
	    return false;
       }   
       
  function change_admin_tr_status(id){  
	$("#aaction"+id).show(); 
	var astatus = $('#astatus'+id).val();
	var prev_status = $('#aprev'+id).val();
//alert(date.length); alert(status);
if(astatus == 'select'){
alert('Please select a valid status');
$('#astatus'+id).val(prev_status);
 $("#aaction"+id).hide();
}else{

		$.ajax({
	      url: "<?php echo $this->webroot; ?>Users/approve_admin_visa",
	      dateType:'html',
	      type:'post',
	      data:'id='+id+'&astatus='+astatus+'&prev_status='+prev_status,
	      success: function(data){
	     	if(data != 'Error'){
	     	$('#prev'+id).val(astatus);
			alert('Admin Visa Status Changed to '+data);
			}else{
			alert('Some Error Occured');
			$('#astatus'+id).val(prev_status);
			}
		 },complete:function(){
       // $('#astatus'+id).val(prev_status);
 		$("#aaction"+id).hide();
         }         
	    });
	    }
	    return false;
       } 
       
       
       function get_exit_info(group){
	       $.ajax({
		      url: "<?php echo $this->webroot; ?>users/get_exit_info",
		      dateType:'html',
		      type:'post',
		      data:'id='+group,
		      success: function(data){
		     	bootbox.alert(data);
			 	}    
		    });
		    return false;
       }
      
        function show_comment(comment)
        {
       	 bootbox.alert(comment);
        }
        
</script>