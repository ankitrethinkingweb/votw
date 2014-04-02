<style>
.dataTables_filter{
text-align:left!important;
}
</style>
<p >
	<a class="btn btn-extend" href="<?php echo $this->webroot; ?>new_transaction" >Add New Bank Transactions</a>
</p>
<div class="container-fluid">	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Bank Transactions</h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
							<th><?php echo __('Transaction Id');?></th>
							<th><?php echo __('SL');?></th>
							<th><?php echo __('Bank Name');?></th>
							<th><?php echo __('Remarks');?></th>
							<th><?php echo __('Account No');?></th>
							<th><?php echo __('Amount'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></th>
							<th><?php echo __('Transaction Mode');?></th>
							<th><?php echo __('Transaction Date');?></th>
							<th><?php echo __('Status');?></th>
							<th><?php echo __('Action');?></th>
							</tr>
							</thead>
							<tbody>
			<?php       if (!empty($trans)) {
							$sl=0;
							foreach ($trans as $row) {
							
								$sl++;
								echo "<tr>";
								echo "<td>".$row['new_transaction']['trans_id']."</td>";
								echo "<td>".$sl."</td>";
								if($row['new_transaction']['bank_name']!= '')
								echo "<td>".h($row['new_transaction']['bank_name'])."</td>";
								else echo "<td>-</td>";
								if($row['new_transaction']['remarks']!= '')
								echo "<td>".h($row['new_transaction']['remarks'])."</td>";
								else echo "<td>-</td>";
								if($row['new_transaction']['account_no'] != '')
								echo "<td>".h($row['new_transaction']['account_no'])."</td>";
								else echo "<td>-</td>";		
								echo "<td>".h($row['new_transaction']['amt'])."</td>";
								echo "<td>".h($row['new_transaction']['tr_mode'])."</td>";
								echo "<td>".date('d-M-Y',strtotime($row['new_transaction']['trans_date']))."</td>";
								echo "<td>";
								if($row['new_transaction']['trans_status'] == 'A') echo 'Approved';
								else if($row['new_transaction']['trans_status'] == 'D') echo 'Rejected';
								else if($row['new_transaction']['trans_status'] == 'F') echo 'Failed Transaction';
								else echo 'Pending';
								echo "</td>";
								echo "<td>";
								if(isset($row['new_transaction']['trans_mode']) && $row['new_transaction']['trans_mode'] != 7)
								echo "<a href='javascript:void(0);'><button title= 'View' onclick = 'alert({$row['new_transaction']['trans_id']})' type='submit' class='alert-box btn btn-round-min btn-warning space'><span><i class='icon-zoom-in '></i></span></button></a>";
								if($row['new_transaction']['trans_status'] == 'P'){
								echo "<a href='".$this->Html->url('/Users/editTrans/'.$row['new_transaction']['trans_id'])."'><button title= 'Edit' type='submit' class='btn btn-round-min btn-inverse space'><span><i class='icon-edit'></i></span></button></a>";
									}?>
									<?php if(isset($row['new_transaction']['trans_mode']) and isset($row['new_transaction']['receipt']) and strlen($row['new_transaction']['receipt']) > 0 and $row['new_transaction']['trans_mode'] == 1) { ?>
									<a href="<?php echo $this->webroot.'app/webroot/uploads/'.$username.'/'.$row['new_transaction']['receipt']; ?>" target="_blank">
								<button title= 'View Receipt' type='submit' class='btn btn-round-min btn-danger'><span><i class='icon-copy'></i></span></button>
								</a>
								<?php } ?>
								<a href='<?php echo $this->Html->url('/Users/deleteTrans/'.$row['new_transaction']['trans_id']);?>' onclick="return confirm('Are you sure you want to delete this transaction?')" >
								<button title= 'Delete' type='submit' class='btn btn-round-min btn-danger'><span><i class='icon-remove-sign'></i></span></button>
								</a>
							<?php									
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
<style>
.space{
margin:5px;
}
</style>


<script type = "text/javascript">
function alert(id){
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
   
}

 $(function () {
                $('#data-table').dataTable({
                 "aoColumnDefs": [{ "bVisible": false, "aTargets": [0] }],
                "aaSorting": [[0,'desc']],
                      "sDom":  "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                    "oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				"copy",
				"xls",
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			]
		}
                });
            });
</script>
