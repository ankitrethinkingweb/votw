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
echo $this->Html->script('ajaxfileupload');
echo $this->Html->script('jquery.validate');
echo $this->fetch('script');	
?>

<?php //if($this->UserAuth->getGroupName() == 'User') { ?>
<p><a class="btn btn-extend" href="<?php echo $this->webroot; ?>extension" >Add Extension(s)</a></p>
<?php //} ?>

<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
					<div class="widget-head orange">
							<h3>All Extensions</h3>
						</div>
						<div class=" information-container">
						 <?php echo $this->Session->flash(); ?>
						 
						 	<input type = "hidden" name = "selected" value = 0 />
							<table class="table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<?php if($this->UserAuth->getGroupName() != 'User') { ?>
							<th><?php echo __('User Name');?></th>
							<?php } ?>
							<th><?php echo __('Extension No');?></th>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('Visa App No');?></th>
							<th><?php echo __('Visa');?></th>
							<th><?php echo __('Application Date');?></th>
							<th><?php echo __('Ext Amount');  ?></th>
							<th><?php echo __('Ext Status');?></th>
							<th><?php echo __('Action');?></th>
							</tr>
							<?php if($this->UserAuth->getGroupName()  != 'User') { ?>
							<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php } ?>	
							</thead>
							<tbody>
			<?php       if (!empty($data)) {
							$sl=0;
							foreach ($data as $row) {  
								$sl++;
								echo "<tr id = 'ext".$row['ext_details']['ext_id']."' >";	
								if($this->UserAuth->getGroupName() != 'User') {
								echo "<td>";								
								if(isset($user[$row['ext_details']['ext_user_id']])) echo $user[$row['ext_details']['ext_user_id']]; else echo 'NA';
								echo "</td>";
								}	
								
								echo "<td>";
								if(isset($row['ext_details']['ext_no']))
								echo $row['ext_details']['ext_no'];
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($name[$row['ext_details']['ext_group_id']]))
								echo $name[$row['ext_details']['ext_group_id']];
								else if(isset($row['ext_details']['ext_name']))
								echo $row['ext_details']['ext_name'];
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if(isset($appNo[$row['ext_details']['ext_group_id']]))
								echo $appNo[$row['ext_details']['ext_group_id']];
								else echo 'NA';
								echo "</td>";
								
								echo "<td>";
								if($row['ext_details']['ext_group_id'] != null  && isset($visa_type[$visa[$row['ext_details']['ext_group_id']]]))
								echo $visa_type[$visa[$row['ext_details']['ext_group_id']]];
								else
								echo 'NA';
								echo "</td>";
													
								echo "<td>";
								if(isset($row['ext_details']['ext_apply_date']) && strlen($row['ext_details']['ext_apply_date']) > 0)
								echo date('d M Y',strtotime($row['ext_details']['ext_apply_date']));
								else
								echo 'NA';
								echo "</td>";
								
                                echo "<td>";
								if(isset($row['ext_details']['ext_amt']) and strlen($row['ext_details']['ext_amt']) > 0)
								echo$row['ext_details']['ext_amt'];
								else echo 'NA';
								echo "</td>";	
							
								echo "<td>";
								if(isset($tr_status[$row['ext_details']['ext_payment_status']]) and strlen($tr_status[$row['ext_details']['ext_payment_status']]) > 0){
								echo $tr_status[$row['ext_details']['ext_payment_status']];
								
								if($row['ext_details']['ext_payment_status'] == 5 && isset($row['ext_details']['ext_last_date']) && $row['ext_details']['ext_last_date'] != null) echo '<br/><strong>Last Date</strong> : '.date('d M Y', strtotime($row['ext_details']['ext_last_date'])); 
								if( $row['ext_details']['ext_payment_status'] == 5 &&  isset($row['ext_details']['ext_comments']) && $row['ext_details']['ext_comments'] != null ) echo '<input type = "hidden" name = "comment" id = "comment" value = "'.$row['ext_details']['ext_comments'].'" /><br/><a href = "javascript:void(0);" name = "view_cmt" id = "view_cmt" onclick = "view_comment()">View Comments</a>';
								
								}else echo 'NA';
								echo "</td>";	
							
								echo '<td><div class="btn-toolbar row-action"><div class="btn-group">';
								
								if($this->UserAuth->getGroupName() != 'User' && $this->UserAuth->getGroupName() != 'Admin'  && $this->Session->read('role2.visa_view') == 0 ){}else{
								if($row['ext_details']['ext_group_id'] != null)
								echo "<a href='".$this->Html->url('/view_visa_app/'.$row['ext_details']['ext_group_id'])."' target = '_blank' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
								else
								echo "<a href='javascript:void(0);' onclick = 'view_ext_details(".$row['ext_details']['ext_id'].")' class='btn btn-warning' title= 'View'><i class='icon-zoom-in '></i></a>";
								}
								
								if($row['ext_details']['ext_payment_status'] == 1)
		                        {
		                         if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.ext_apply') == 0){ }else{
		                        echo '<a href="'.$this->webroot.'apply_extension_old/'.$row['ext_details']['ext_no'].'"  data-original-title= "Apply Extension" class="btn btn-success"><i class="icon-signout"></i></a>';
		                      	 }
		                        }
							if($this->UserAuth->getGroupName() != 'User' and $row['ext_details']['ext_payment_status'] == 2 ){
 		                         if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.ext_status') == 0){ }else{
    echo "<a href = 'javascript:void(0);' onclick = 'approve_ext_form(".$row['ext_details']['ext_id'].")' class='btn btn-success' data-original-title='Approve Extension'><i class='icon-thumbs-up'></i></a>";	
    }						
   //echo "<a href='javascript:void(0);' class='btn btn-danger' data-original-title='Delete Extension' onclick='delete_extension(".$row['ext_details']['ext_id'].");'><i class='icon-remove-sign'></i></a>";
							}
					if($row['ext_details']['ext_payment_status'] > 1 && strlen($row['ext_details']['inv_path']) > 0){
			if($this->UserAuth->getGroupName() != 'User'){
				 echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/ext/'.$row['ext_details']['inv_apath'].'"  title= "Download Invoice" class="btn btn-warning" download><i class="icon-download"></i></a>';
			}else{
				 echo '<a href="'.$this->webroot.'app/webroot/uploads/receipt/ext/'.$row['ext_details']['inv_path'].'"  title= "Download Invoice" class="btn btn-warning" download><i class="icon-download"></i></a>';
			}
		}				
							if($row['ext_details']['ext_payment_status'] <= 2 ){
   echo "<a href='javascript:void(0);' class='btn btn-danger' data-original-title='Delete Extension' onclick='delete_extension(".$row['ext_details']['ext_id'].");'><i class='icon-remove-sign'></i></a>";							
							}
									
if($row['ext_details']['ext_payment_status'] == 5 && strlen($row['ext_details']['ext_visa_path']) > 0 && $row['ext_details']['ext_visa_path'] != NULL){
	echo "<a href = '".$this->webroot."app/webroot/uploads/Extension/visa/".trim($row['ext_details']['ext_no'])."/".$row['ext_details']['ext_visa_path']."' download class='btn btn-info' data-original-title='Download Extension'><i class='icon-download'></i></a>";
}

if($this->UserAuth->getGroupName() != 'User' and $row['ext_details']['ext_payment_status'] == 5 ){
if(strlen($row['ext_details']['ext_visa_path']) > 0) $upload = 'Change Uploaded Extension'; else $upload = 'Upload Extension';
 if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.ext_status') == 0){ }else{
 echo "<a href='".$this->webroot."uploadExtVisa/".$row['ext_details']['ext_id']."' class='btn btn-danger' data-original-title='".$upload."' ><i class='icon-upload'></i></a>";
 }
}
echo '<img src =  "'.$this->webroot.'app/webroot/images/ajax-loader.gif" style = "display:none;" id = "action'.$row['ext_details']['ext_id'].'" />';
			                     echo '</div></td>';
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
			<h4 class="modal-title">Approve Extension Application</h4>
			</div>
			<div id="divMsg"></div>
			<form class='form-horizontal' novalidate='novalidate' id='frm' enctype = multipart/form-data>
			
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
function view_comment(){
       		var comment = $('#comment').val();
       		//alert(comment);
       		bootbox.alert(comment); 
       		return false;
       }
     
 $(function () {
 
 jQuery.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|png|jpe?g|gif|doc|docx|rtf";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));  

  $("#frm").validate({

                    rules: {
	                     	'data[last_date]' :{ 
	                     		required :true,
	          				  },
	          				  'data[comments]' :{ 
	                     		required :true,
	          				  },
	          				  'data[upload]':{
	          				  	required:true,
	          				  	extension:true,
	          				  },
          				  },
          		  messages :
          		  {
          		  
          		  },
          		  submitHandler:function(form) {
          		  $("#action").show();
          		  $.ajaxFileUpload({
		            url             :"<?php echo $this->webroot; ?>usermgmt/users/approve_ext",	     
		            fileElementId   :'upload',
		            dataType        : 'json',
		            data            :  {
		                'last_date': $('#last_date').val(),
		                'comments': $('#comments').val(),
		                'ext_id': $('#ext_id').val(),
		            },
		            success : function (data, status){
		            //alert(data.status);
		               if(data.status == 'Success')
						{
							location.href = "<?php echo $this->webroot; ?>extension_list";
							alert('Extension Approved Successfully');
						}else alert('Some Error Occured');
		            	},complete:function(){
				        	 $("#action").hide();
				        } 
		       		})
					
	          		}
	          	});
	          	
    var hidVal = '<?php echo $this->UserAuth->getGroupName(); ?>';    
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
    
    if(hidVal != 'User'){
    	$("thead td").each( function ( i ) {
					if(i == 0){
					this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
					$('select', this).change( function () {
						oTable.fnFilter( $(this).val(), i );
					} );
					}
				});
				}
});


function delete_extension(ext_id)
       {
       if(confirm("Do you really want to delete this extension?")){
			$("#action"+ext_id).show();
      		$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/delete_ext",
				dateType:'html',
				type:'post',
				data:'id='+ext_id,
				success: function(data){
					if(data != 'Error')
						{
							$('#ext'+ext_id).html('');
							alert('Extension Deleted Successfully');
						}else alert('Some Error Occured');
					},complete:function(){
				         $("#action"+ext_id).hide();
				         } 
				});
				}
				return false;
       }
     
     
     function approve_extension(ext_id)
       {
      $("#action"+ext_id).show();
      		$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/approve_ext",
				dateType:'html',
				type:'post',
				data:'id='+ext_id,
				success: function(data){
					if(data == 'Success')
						{
							location.href = "<?php echo $this->webroot; ?>all_extension";
							alert('Extension Approved Successfully');
						}else alert('Some Error Occured');
					},complete:function(){
				         $("#action"+ext_id).hide();
				         } 
				});
				
				return false;
       }
         
       function approve_ext_form(ext_id)
       {
      		$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/approve_ext_form",
				dateType:'html',
				type:'post',
				data:'id='+ext_id,
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
       }  
       
       
       function view_ext_details(ext){
       
       	$.ajax({
				url: "<?php echo $this->webroot; ?>usermgmt/users/view_ext",
				dateType:'html',
				type:'post',
				data:'id='+ext,
				success: function(data){
					if(data != 'Error')
						{
							bootbox.alert(data); 	
						}
					}
				});
				return false;
       }
       
</script>
