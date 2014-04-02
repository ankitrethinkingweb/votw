  <div class="row-fluid ">
      
        <div class="span9" style = "width: 511px;">
          <div class="profile-info">
            <div class="tab-widget">
          <?php if(isset($trans)) { foreach ($trans as $row) {?>
         
              <ul class="nav nav-tabs" id="myTab1">
                <li class="active"><a href="#user"><i class="icon-user"></i> Transaction Details :  <span style="font-size:15px;font-weight:bold;"><?php echo h(strtoupper($row['new_transaction']['user']))?></span></a></tr>
              </ul>
            <?php } } ?>
           
              <div class="tab-content">
                <div class="tab-pane active" id="user">
                <div class=" information-container">
                                                
                  <table class="table table-striped">
                 
                      <tr>
                      <td>Bank Name :</td>
                    	<td><?php if(isset($row['new_transaction']['bank_name']) && strlen($row['new_transaction']['bank_name']) > 0) echo $row['new_transaction']['bank_name'];  else echo 'Not Mentioned'; ?></td>
                 	</tr>
                 	 <tr>
                      <td>Bank Branch :</td>
                    	<td><?php if(isset($row['new_transaction']['bank_branch']) && strlen($row['new_transaction']['bank_branch']) > 0) echo $row['new_transaction']['bank_branch'];  else echo 'Not Mentioned'; ?></td>
                 	</tr>
                 	
                  <tr>
                      <td>Country :</td>
                      <td><?php if(isset($row['new_transaction']['cntry'])) echo h($row['new_transaction']['cntry']); else echo 'Not Mentioned';?></td>
                 </tr>
           		 <tr>
                      <td>Amount <?php if(isset($row['new_transaction']['currency']) && strlen($row['new_transaction']['currency']) > 0){ echo '( in '.$row['new_transaction']['currency'].' )'; }?>:</td>
                    <td><?php if(isset($row['new_transaction']['amt'])) echo $row['new_transaction']['amt'];else echo 'Not Mentioned'; ?></td>
                 </tr>
				
                 <tr>
                      <td>Transaction Mode:</td>
                    <td><?php if(isset($row['new_transaction']['tr_mode'])) echo $row['new_transaction']['tr_mode'];else echo 'Not Mentioned';?></td>
                 </tr>
                 
                  <tr>
                      <td>Transaction No. :</td>
                      <td><?php if(isset($row['new_transaction']['trans_no'])) echo $row['new_transaction']['trans_no'];else echo 'Not Mentioned';?></td>
                 </tr>
                  <tr>
                      <td>Transaction Date :</td>
                       <td> <?php if(isset($row['new_transaction']['trans_date'])) echo date('d-m-Y',strtotime($row['new_transaction']['date']));else echo 'Not Mentioned';?></td>
                 </tr>
                 
                  <tr>
                      <td>Remarks :</td>
                  <td> <?php if(isset($row['new_transaction']['remarks'])) echo $row['new_transaction']['remarks'];else echo 'Not Mentioned';?></td>
                 </tr>
                 
                 <tr>
                      <td>Transaction Status:</td>
                     <td><?php if($row['new_transaction']['trans_status'] == 'A') echo 'Approved';
								else if($row['new_transaction']['trans_status'] == 'D') echo 'Rejected';
								else if($row['new_transaction']['trans_status'] == 'F') echo 'Failed Transaction';
								else echo 'Pending';?></td>
                 </tr>
               </table>
                
                 
              </div>    
   			</div>
       	</div>
     </div>
          </div>
        
        </div>
      </div>
    </div>
 