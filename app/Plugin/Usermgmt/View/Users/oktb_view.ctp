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
<div class="container-fluid" id = "whole">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class=" information-container">
		<?php if(isset($oktb_apps) && count($oktb_apps) == 500){ ?>
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<input type = "hidden" name = "val" id = 'value' value = "<?php if(isset($value)) echo $value ; else 1;?>" />
				<input type = "hidden" name = "pay" id = 'pay' value = "<?php if(isset($paid)) echo $paid ; else 0;?>" />
				<i class="icon-exclamation-sign"></i>Only Recent 500 records are shown, To view all records. <a href = "javascript:void(0)" onclick = "getData()" >Click Here</a>.
			</div>
			<?php }
			if(isset($value) && $value == 2){
			echo '<p><a class = "btn btn-warning" href = "'.$this->webroot.'export_group_oktb" name = "export_group" >Export Group OKTB App</a></p>';
			} ?>
			
						 <?php echo $this->Session->flash(); ?>
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('User Name');?></th>
							<?php } ?>
							<th><?php echo __('OKTB No');?></th>
							<th><?php echo __('Name of Applicant');?></th>	
							<th><?php echo __('Date/Time of Journey');?></th>			
							<th><?php echo __('Airline');?></th>											
							<th><?php echo __('PNR No');?></th>					
							<th><?php echo __('Passport No');?></th>	
							<th><?php echo __('Amount'); if($this->UserAuth->getGroupName() != 'Admin' && isset($curr) && strlen($curr) > 0){ echo '( in '.$curr.' )'; } ?></th>					
							<th><?php echo __('Status');?></th>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('Admin Status');?></th>
							<?php } ?>
							<th><?php echo __('Applied Date');?></th>
							<th><?php echo __('Action');?></th>
							<th>Sort Date</th>			
							</tr>
							
							<tr>
							
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>	<td></td>	<?php } ?>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>	<td></td>	<?php } ?>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($oktb_apps)) { 
							$sl=0;
							foreach ($oktb_apps as $row) {  
								$sl++;
								echo "<tr>";	
								
								echo "<input type = 'hidden' name = 'oktbId' value = '".$row['oktb_details']['oktb_id']."'/>";
								if($this->UserAuth->getGroupName() != 'User') {
								echo "<td>";								
								if(isset($row['users']['username'])) echo $row['users']['username']; else echo 'NA';
								echo "</td>";
								}	
													
								echo "<td>";
								if(isset($row['oktb_details']['oktb_no']))
								echo $row['oktb_details']['oktb_no'];
								else
								echo 'NA';
								echo "</td>";
								
                                echo "<td>";
								if(isset($row['oktb_details']['oktb_name']) and strlen($row['oktb_details']['oktb_name']) > 0)
								echo $row['oktb_details']['oktb_name'];
								else echo 'NA';
								echo "</td>";	
							
								echo "<td>";
								if(isset($row['oktb_details']['oktb_d_o_j']) and strlen($row['oktb_details']['oktb_d_o_j']) > 0){
								echo $row['oktb_details']['oktb_d_o_j'];
if(isset($row['oktb_details']['oktb_doj_time']) && strlen(strstr($row['oktb_details']['oktb_doj_time'],'hh')) == 0 ) echo ' '.$row['oktb_details']['oktb_doj_time'];
								}else echo 'NA';
								echo "</td>";	
									
								echo "<td";
								if(isset($air_status[$row['oktb_details']['oktb_airline_name']]) && $air_status[$row['oktb_details']['oktb_airline_name']] == 0) echo " style='color:red'";
								echo ">";
								if(isset($airline[$row['oktb_details']['oktb_airline_name']]) and strlen($airline[$row['oktb_details']['oktb_airline_name']]) > 0)
								echo $airline[$row['oktb_details']['oktb_airline_name']];
								else echo 'NA';
								echo "</td>";																		
								echo "<td>";
								if(isset($row['oktb_details']['oktb_pnr']) and strlen($row['oktb_details']['oktb_pnr']) > 0)
								echo $row['oktb_details']['oktb_pnr'];
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['oktb_details']['oktb_passportno']) and strlen($row['oktb_details']['oktb_passportno']) > 0)
								echo $row['oktb_details']['oktb_passportno'];
								else echo 'NA';
								echo "</td>";
								
								
								if( isset($value) && $value == 2){
									echo "<td>";
									if(isset($oktb_fee[$row['oktb_details']['oktb_id']]) and strlen($oktb_fee[$row['oktb_details']['oktb_id']]) > 0){
									if( $this->UserAuth->getGroupName() != 'User' && isset($currency[$row['users']['currency']]))
									echo $oktb_fee[$row['oktb_details']['oktb_id']] .'('.$currency[$row['users']['currency']].')';
									else echo $oktb_fee[$row['oktb_details']['oktb_id']];
									}else echo 'NA';
									echo "</td>";
								}else{
									echo "<td>";
									if(isset($row['oktb_details']['oktb_airline_amount']) and strlen($row['oktb_details']['oktb_airline_amount']) > 0){
									if( $this->UserAuth->getGroupName() != 'User' && isset($currency[$row['users']['currency']]))
									echo $row['oktb_details']['oktb_airline_amount'] .'('.$currency[$row['users']['currency']].')';
									else echo $row['oktb_details']['oktb_airline_amount'];
									}else echo 'NA';
									echo "</td>";
								}
					
								
								echo "<td>"; 
								if(isset($row['oktb_details']['oktb_payment_status']) and strlen($row['oktb_details']['oktb_payment_status']) > 0)
								{
								echo $trans[$row['oktb_details']['oktb_payment_status']];
								if($row['oktb_details']['oktb_payment_status'] == 5)
								echo '<br/><a href="javascript:void(0)" onclick="show_comment('.$row['oktb_details']['oktb_id'].')">Show Comment</a>';
								}
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($row['oktb_details']['payment_date']) and strlen($row['oktb_details']['payment_date']) > 0)
								echo date('d M Y',strtotime($row['oktb_details']['payment_date']));
								else echo 'NA';
								echo "</td>";	
								
								echo '<td>
					<div class="btn-toolbar row-action">
                        <div class="btn-group">';
                        if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.oktb_view') == 0){ }else{
                       echo '<a href="'.$this->webroot.'viewOktb/'.$row['oktb_details']['oktb_id'];
                        
                        if(isset($value) && $value == 2){
                        echo '/1"'; 
                        }else echo '"';
                        echo ' target = "_blank" class="btn btn-primary" title="View"><i class="icon-zoom-in "></i></a>';
                        }
                        
                        if($row['oktb_details']['oktb_payment_status'] == 1)
                        {
	                        if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.oktb_apply') == 0){ }else{
	                        	echo '<a href="'.$this->webroot.'apply_oktb_apps/'.$row['oktb_details']['oktb_no'].'"  title= "Apply For OKTB" class="btn"><i class="icon-signout"></i></a>';
	                        }
                        }
                   
                     if($this->UserAuth->getGroupName() != 'User' and isset($trans[$row['oktb_details']['oktb_payment_status']]) and $row['oktb_details']['oktb_payment_status'] !=5 and $value == 1){
                         if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.oktb_edit') == 0){ }else{
                     	 	echo '<a href="'.$this->webroot.'edit_oktb/'.$row['oktb_details']['oktb_no'].'"  title= "Edit OKTB App" class="btn btn-warning"><i class="icon-edit"></i></a>';
                     	 }
                     }
                    
                     if($row['oktb_details']['oktb_payment_status'] > 1){
                        if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.oktb_download') == 0){} 
                        else{
	                     	echo "<a href='".$this->webroot;
							if(isset($value) && $value == 2) echo "download_group/".$row['oktb_details']['oktb_group_no']; else echo "download_oktb_doc/".$row['oktb_details']['oktb_no'];
							echo "' title= 'Download Documents' class='btn btn-danger'><i class='icon-download'></i></a>";
							}
							/*if(strlen($row['oktb_details']['inv_path']) > 0){
						if($this->UserAuth->getGroupName() != 'Admin')
                     	 	echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/oktb/'.$row['oktb_details']['inv_path'].'"  title= "Download Invoice" class="btn btn-info" download><i class="icon-download"></i></a>';
					    else
					        echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/oktb/'.$row['oktb_details']['inv_admin_path'].'"  title= "Download Invoice" class="btn btn-info" download><i class="icon-download"></i></a>';
						}*/
					}
                      if($this->UserAuth->getGroupName() != 'User' and $row['oktb_details']['oktb_payment_status'] != 5)
                     {
                      if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.oktb_status') == 0){ }else{
                      echo "<a href='javascript:void(0);' class='btn btn-success' title='Approve OKTB' onclick='approve_oktb(".$row['oktb_details']['oktb_id'].");'><i class='icon-thumbs-up'></i></a>"; }
                      if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.oktb_delete') == 0){ }else{
	                      echo '<a onclick="return confirm(\'Are you sure want to delete?\')" href="'.$this->webroot.'delete_oktb/'.$row['oktb_details']['oktb_id'];
		                  if(isset($value) && $value == 2) echo '/G';
		                  echo '"  title= "Delete OKTB App" class="btn btn-info" ><i class="icon-remove"></i></a>';  
                   	  }	     
                     }
                     
						echo ' </div>
						</td>';
						
						if(isset($sortDate[$row['oktb_details']['oktb_id']]))	
								echo "<td>".$sortDate[$row['oktb_details']['oktb_id']]."</td>";
								else echo "<td>0</td>";		 			
						
						if( isset($value) && $value == 2){
									echo "<td>";
									if(isset($oktb_fee[$row['oktb_details']['oktb_id']]) and strlen($oktb_fee[$row['oktb_details']['oktb_id']]) > 0){
										echo $oktb_fee[$row['oktb_details']['oktb_id']];
									}else echo 0;
									echo "</td>";
								}else{
									echo "<td>";
									if(isset($row['oktb_details']['oktb_airline_amount']) and strlen($row['oktb_details']['oktb_airline_amount']) > 0){
										echo $row['oktb_details']['oktb_airline_amount'];
									}else echo 0;
										echo "</td>";
								}
								echo "</tr>";
						} }?>
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
<h4 class="modal-title">Approve OKTB Application</h4>
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
                     	'data[comment]' :{ 
                     	required :true,
                     
          				  },
          				  },
          		  messages :
          		  {
          		  },
          		  submitHandler:function(form) {
          		  $.ajax({
						url: "<?php echo $this->webroot; ?>approve_oktb",
						dateType:'html',
						type:'post',
						data:$('#frm').serialize(),
						success: function(data){
							if(data != 'error')
							{
								location.href="<?php echo $this->webroot; ?>oktb_apps/3"
							} 
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
                "aoColumnDefs": [
                        { "bVisible": false, "aTargets": [11] },
                        { "bVisible": false, "aTargets": [9] },
                        { "bVisible": false, "aTargets": [12] }
                    ],
              		 "aaSorting": [[11, 'desc']],
              		 "aoColumns": [
							null,
							null,
							null,
							null,
							null,
							null,
							null,
							{"iDataSort": 12, "sType": "numeric"},
							null,
							null,
							null,
							null,
						],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
             		"bSortCellsTop": true,
   "oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,2,3,4,5,6,7,8,9],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5,6,7,8,9],
	                         
	            },
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ 
					{
						 "sExtends": "csv",
		                "mColumns": [0,1,2,3,4,5,6,7,8,9],   
					},
					{
						 "sExtends": "xls",
		                "mColumns": [0,1,2,3,4,5,6,7,8,9],   
					},
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,2,3,4,5,6,7,8,9],   
					},
					
					
					 ]
				}
			]
		}
                });
                
                }else{
                
                var oTable =  $('#data-table').dataTable({
               "aoColumnDefs": [
                        { "bVisible": false, "aTargets": [10] },
                        { "bVisible": false, "aTargets": [8] },
                        { "bVisible": false, "aTargets": [11] }
                    ],
                    "aaSorting": [[10, 'desc']],
                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                     "aoColumns": [
							null,
							null,
							null,
							null,
							null,
							null,
							{"iDataSort": 11, "sType": "numeric"},
							null,
							null,
							null,
							null,
						],
             		"bSortCellsTop": true,
   			"oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,2,3,4,5,6,7,8],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,2,3,4,5,6,7,8],
	                         
	            },
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ 
					{
						 "sExtends": "csv",
		                "mColumns": [0,1,2,3,4,5,6,7,8],   
					},
					{
						 "sExtends": "xls",
		                "mColumns": [0,1,2,3,4,5,6,7,8],   
					},
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,2,3,4,5,6,7,8],   
					},
					
					
					 ]
				}
			]
		}
                });
                
                }
                $("thead tr td").each( function ( i ) {
                	if(hidVal != 'User'){ 
					if(i == 4){
					this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
					$('select', this).change( function () {
						oTable.fnFilter( $(this).val(), i );
					} );
					}
					}else{
					if(i == 3){
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
	
	 function approve_visa(id,userid){  
	 $("#action"+id).show(); 
var status = $('#status'+id).val();
var date = $('#app_date'+id).val();
//alert(date.length); alert(status);
if(status == 1 && date.length >= 0){
alert('Invalid Status!!! Visa is already applied.');
 $("#action"+id).hide();
 $("#status"+id).val($('#prev'+id).val());
}else{
       	$.ajax({
	      url: "<?php echo $this->webroot; ?>Users/approve_visa",
	      dateType:'json',
	      type:'post',
	      data:'id='+id+'&status='+status+'&userid='+userid,
	      success: function(data){
	      var jdata = jQuery.parseJSON(data);
	      $('#prev'+id).val(status);	
	      if(jdata['status1'] == 'Approved'){
	     	 $("#change"+id).css('display','block');      	
			}else{
			$('#appr_upload'+id).css('display','none');
			}	
			alert('Visa Status Changed to '+jdata['status1']);
		 },complete:function(){
         $("#action"+id).hide();
         }         
	    })
	    }
	    return false;
       }   
       
       function approve_oktb(oktb_id)
       {
      		$.ajax({
				url: "<?php echo $this->webroot; ?>get_approve_form",
				dateType:'html',
				type:'post',
				data:'id='+oktb_id,
				success: function(data){
					if(data != 'Error')
						{
							$('#divMsg').html('');
							$('#m_bdy').html(data);
							$("#myModal").modal('toggle') ;
						}
					}
				});
				return false;
       }
       
        function show_comment(oktb_id)
        {
       	 $.ajax({
				url: "<?php echo $this->webroot; ?>get_oktb_comment",
				dateType:'html',
				type:'post',
				data:'id='+oktb_id,
				success: function(data){
					if(data != 'error')
						{
						bootbox.alert(data);
						}
					}
				});
        }
        
        
        /*function getData(){
        alert(window.location.href+'/'+1);
        }*/
        
 function getData(){
$('#whole').css('display','none');

 var paid = $('#pay').val();
 var value = $('#value').val();
 
        $("#load").show();
        $.ajax({
			url: "<?php echo $this->webroot; ?>oktb_view",
			dateType:'html',
			data: 'value='+value+'&paid='+paid+'&status=1',
			type:'post',
				success: function(data){
				$('#whole').html('');
				$('#whole').html(data);
				$('#whole').css('display','block');
					 
				},complete:function(){
					$("#load").hide();
				}    			
			});
				return false;
            }    
       
</script>