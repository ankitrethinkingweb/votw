
<style type="text/css">
label
{
display:inline-block;
margin-left:10px;
margin-right:20px;
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
						<div class="widget-container gray ">
							<div class="widget-head blue-violate">
								<h3>Download Documents</h3>
							</div>
							 <div class=" information-container">
							 <div class="accordion" id="accordion2">
							 <?php if(isset($count)) 
						 $j = $count; else $j=1;
								  $ak = 1; $bk = 1; $ck = 1; $app = $data['visa_tbl']['app_id'];
								 for($i= 1; $i<= $count;$i++){
								 $a = $data['visa_tbl']['adult']; $b = $data['visa_tbl']['adult']+$data['visa_tbl']['children'];
								   
								 if($a != 0 && $i <= $a){ $id = '-A'.$ak; $heading = 'Adult - '.$ak.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';  $ak++;}
								 else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $heading = 'Children - '.$bk.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')';		$bk++;}
								 else{ $id = '-I'.$ck; $heading = 'Infants - '.$ck.'( Application No. : '.$data['visa_tbl']['app_no'.$id].')'; 	$ck++;	}
								 $app++;
						?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapse<?php echo $id; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle"><?php echo $heading; ?><span class="caret whitecaret"></span></a>
							</div>
							<div class="accordion-body collapse " id="collapse<?php echo $id; ?>">
								<div class="accordion-inner">
								
							 		<table class="responsive table table-striped table-bordered" id="data-table">
								 	<td class="heading">Passport First Page</td>	
								    <td><?php if(isset($data['visa_tbl']['pfp'.$id]) and strlen($data['visa_tbl']['pfp'.$id]) > 0)
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pfp'.$id].'" download>View Passport First Page</a>';
														else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading">Passport Last Page</td>
                                                    <td><?php if(isset($data['visa_tbl']['plp'.$id]) and strlen($data['visa_tbl']['plp'.$id]) > 0)
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['plp'.$id].'" download>View Passport Last Page</a>';
														else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <tr>
                                                    <td class="heading">Photograph</td>
                                                   <td><?php if(isset($data['visa_tbl']['photograph'.$id]) and strlen($data['visa_tbl']['photograph'.$id]) > 0)
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['photograph'.$id].'" download>View Photograph</a>';
														else echo 'Not Mentioned'; ?></td>
                                                    <td class="heading" width="100px">Passport Observation Page</td>
                                                    <td><?php if(isset($data['visa_tbl']['pop'.$id]) and strlen($data['visa_tbl']['pop'.$id]) > 0)
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['pop'.$id].'" download>View Passport Observation Page</a>';
														else echo 'Not Mentioned'; ?></td>
                                                </tr>
                                                <tr>
                                                	<td class="heading">Address Page</td>
                                                    <td><?php if(isset($data['visa_tbl']['addr'.$id]) and strlen($data['visa_tbl']['addr'.$id]) > 0 and $data['visa_tbl']['addr'.$id] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['addr'.$id].'" download>View Address Document 1</a>';
														else echo 'Not Mentioned'; ?></td>
                                                   <td class="heading">Ticket 1</td>
                                                   <td ><?php if(isset($data['visa_tbl']['ticket1'.$id]) and strlen($data['visa_tbl']['ticket1'.$id]) > 0 and $data['visa_tbl']['ticket1'.$id] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket1'.$id].'" download>View Additional Document 2</a>';
														else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                  <tr>
                                                	 <td class="heading">Ticket 2</td>
                                                   <td ><?php if(isset($data['visa_tbl']['ticket2'.$id]) and strlen($data['visa_tbl']['ticket2'.$id]) > 0 and $data['visa_tbl']['ticket2'.$id] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket2'.$id].'" download>View Additional Document 2</a>';
														else echo 'Not Mentioned'; ?></td>
                                                   <td class="heading">Ticket 1</td>
                                                   <td ><?php if(isset($data['visa_tbl']['ticket3'.$id]) and strlen($data['visa_tbl']['ticket3'.$id]) > 0 and $data['visa_tbl']['ticket3'.$id] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['app_no'.$id].'/'.$data['visa_tbl']['ticket3'.$id].'" download>View Additional Document 2</a>';
														else echo 'Not Mentioned'; ?></td>
                                                 </tr>
                                                 <tr>
                                                  <td class="heading">Additional Document1</td>
                                                   <td ><?php if(isset($data['visa_tbl']['add_doc1']) and strlen($data['visa_tbl']['add_doc1']) > 0 and $data['visa_tbl']['add_doc1'] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc1'].'" download>View Additional Document 2</a>';
														else echo 'Not Mentioned'; ?></td>
                                                  <td class="heading">Additional Document2</td>
                                                   <td ><?php if(isset($data['visa_tbl']['add_doc2']) and strlen($data['visa_tbl']['add_doc2']) > 0 and $data['visa_tbl']['add_doc2'] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc2'].'" download>View Additional Document 2</a>';
														else echo 'Not Mentioned'; ?></td>
                                                    
                                                   
                                                </tr>
                                                <tr>
                                                <td class="heading">Additional Document3</td>
                                                    <td><?php if(isset($data['visa_tbl']['add_doc3']) and strlen($data['visa_tbl']['add_doc3']) > 0 and $data['visa_tbl']['add_doc3'] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc3'].'" download>View Additional Document 3</a>';
														else echo 'Not Mentioned'; ?></td>
                                                 <td class="heading">Additional Document4</td>
                                                    <td><?php if(isset($data['visa_tbl']['add_doc4']) and strlen($data['visa_tbl']['add_doc4']) > 0 and $data['visa_tbl']['add_doc4'] != 'Array')
														echo '<a href="'.$this->webroot.'app/webroot/uploads/'.$data['visa_tbl']['group_no'].'/'.$data['visa_tbl']['add_doc4'].'" download>View Additional Document 4</a>';
														else echo 'Not Mentioned'; ?></td>
                                                </tr>
							 
							
							 </table>
							    </div>
							   </div>
							 </div>
							 <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	