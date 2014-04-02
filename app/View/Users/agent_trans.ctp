<style>
.dataTables_filter{
text-align:left!important;
}
</style>
<div class="container-fluid">
	
			<div class="row-fluid">

				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Transactions <?php if(isset($username)) echo ' by '.$username;?></h3>
						</div>
<?php if($this->UserAuth->getGroupName() == 'Admin') { ?>						
	<?php if(isset($balance) && strlen($balance) > 0){ ?>
<button <?php if($balance == 0){ ?> style = "margin:10px;padding:10px;color:#fff;background-color:#FF5A5A" <?php }else{ ?>style = "margin:10px;padding:10px;color:#fff;background-color:#3C9C48" <?php } ?> class="btn" type="button"><i class = "icon-copy"></i><strong> Wallet Amount <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }else echo '( in INR )';?> : <?php echo $balance; ?></strong></button>
<?php } ?>
<?php if(isset($threshold) && strlen($threshold) > 0){ ?>
<button <?php if($threshold1 > $threshold){ ?> style = "margin:10px;padding:10px;color:#fff;background-color:#FF5A5A" <?php }else{ ?> style = "margin:10px;padding:10px;color:#fff;background-color:#3C9C48" <?php } ?> class="btn" type="button"><i class = "icon-copy"></i><strong> Credit Limit <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }else echo '( in INR )';?> : <?php echo $threshold; ?></strong></button>
<?php } ?>

<?php if(isset($amtBal) && strlen($amtBal) > 0){ ?>
<button style = "margin:10px;color:#fff;padding:10px;background-color:#9B96A0;" class="btn" type="button"><i class = "icon-copy"></i><strong> Total Amount <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }else echo '( in INR )';?> : <?php echo $amtBal; ?></strong></button>
<?php }  ?>
<?php if(($outstanding) > 0){ ?>
<button style = "margin:10px;color:#fff;padding:10px;background-color:#9B96A0;" class="btn" type="button"><i class = "icon-copy"></i><strong> Outstanding <?php if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }else echo '( in INR )';?> : <?php echo $outstanding[1]; ?></strong></button>
<?php } } ?>
						 <div class="widget-container">
						<?php echo $this->Session->flash(); ?>
							<table class="responsive table table-bordered" id="data-table">
							<thead>
							<tr>							
							<th><?php echo __('S. No');?></th>
							<th><?php echo __('Date');?></th>
							<th><?php echo __('SDate');?></th>
							<th><?php echo __('Type (App No.)');?></th>
							<th><?php echo __('Bank Name');?></th>
							<th><?php echo __('Name / Passport No.');?></th>
							<th><?php echo __('Visa Type / Airline');?></th>
							<th><?php echo __('Opening Balance'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></th>
							<th><?php echo __('Credit'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></th>
							<th><?php echo __('Debit'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; }?></th>
							<th><?php echo __('Closing Balance'); if(isset($currency) && strlen($currency) > 0){ echo '( in '.$currency.' )'; } ?></th>
							</tr>
							</thead>
							<tbody>
			<?php if (!empty($transaction)) {
							$sl=0;
							foreach ($transaction as $k=>$row) {
								$sl++;
								echo "<tr>";
								echo "<td>".$sl."</td>";
								if(isset($row['date'])) echo "<td>".date('d M Y',strtotime($row['date']))."</td>"; else echo "<td>-</td>";
								if(isset($k)) echo "<td>".$k."</td>"; else echo "<td>-</td>";
								if(isset($row['type'])) echo "<td>".$row['type']."</td>"; else echo "<td>-</td>";
								if(isset($row['bank_name'])) echo "<td>".$row['bank_name']."</td>"; else echo "<td>-</td>";
								if(isset($row['group_no'])){ echo "<td>";
								if(isset($row['added_by']) && $row['added_by'] == 1)
								echo "<i class = 'icon-info-sign' style = 'color:red;' title = 'Offline' ></i>";
								echo " ".$row['group_no']."</td>"; 
								}else echo "<td>-</td>";
								if(isset($row['other'])) echo "<td>".$row['other']."</td>"; else echo "<td>-</td>";
								if(isset($row['opening_bal'])) echo "<td>".$row['opening_bal']."</td>"; else echo "<td>-</td>";
								if(isset($row['credit'])) echo "<td>".$row['credit']."</td>"; else echo "<td>-</td>";
								if(isset($row['debit'])) echo "<td>".$row['debit']."</td>"; else echo "<td>-</td>";
								if(isset($row['closing_bal'])) echo "<td>".$row['closing_bal']."</td>"; else echo "<td>-</td>";
								echo "</tr>";
							}
						} ?>
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
 $(function () {
                $('#data-table').dataTable({
              
                 "aaSorting": [],
 "aoColumns": [
				{"bSortable": true},
				{"iDataSort": 2},
				{"bVisible": false},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true}
				],

                    "sDom": "<'row-fluid'<'span6'fl><'span6'p>rT>t<'row-fluid'<'span6'i><'span6'p>>",
                    "oTableTools": {
                    "sSwfPath": "<?php echo $this->webroot;?>app/webroot/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
	                "sExtends": "copy",
	                "mColumns": [0,1,3,4,5,6,7,8,9,10],               
	            },
	            {
	                "sExtends": "xls",
	               "mColumns": [0,1,3,4,5,6,7,8,9,10],
	                         
	            },
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ 
					{
						 "sExtends": "csv",
		                "mColumns": [0,1,3,4,5,6,7,8,9,10],   
					},
					{
						 "sExtends": "xls",
		                "mColumns": [0,1,3,4,5,6,7,8,9,10],   
					},
					{
						 "sExtends": "pdf",
		                "mColumns": [0,1,3,4,5,6,7,8,9,10],   
					},
					
					
					 ]
				}
			]
		}
           
                });
            });
       
</script>