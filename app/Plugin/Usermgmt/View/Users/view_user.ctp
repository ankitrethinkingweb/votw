  <div class="row-fluid " style ="width:97%; padding:10px; background-color:#fff;">
  <div class="span12">
	<div class="content-widgets gray">
        <div class="span3">
          <div class="profile-thumb"> <img class="img-polaroid" src="<?php echo $this->webroot;?>theme/Cakestrap/images/person.png" style="height:200px;width:100px;">
            <ul class="list-item">
              <?php if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.agent_edit') == 0){}else{ ?>
              <li><a href="<?php echo $this->webroot;?>editUser/<?php echo $user['User']['id']?>"><i class="icon-pencil"></i> Edit Profile </a></li>
              <?php } ?>
              <?php if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role2.agent_change_pswd') == 0){}else{ ?>
              <li><a href="<?php echo $this->webroot;?>changeUserPassword/<?php echo $user['User']['id']?>"><i class="icon-cogs"></i> Change Password</a></li>
              <?php } ?>
              <?php if($this->UserAuth->getGroupName() != 'User') { ?>
              <?php if(isset($user['User']['active'])) { if($user['User']['active'] == 0) {  if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_status') == 0){}else{ ?>
               <li><a href="<?php echo $this->webroot;?>makeActive/<?php echo $user['User']['id']?>"><i class="icon-ok-sign"></i> Make Active</a></li>
               <?php } }}?>
               <?php if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role2.agent_status') == 0){}else{ ?>
                <li><span id = "change<?php echo $user['User']['id']?>">
               <?php if($user['User']['approve'] ==  1){ ?>
 <a href='#' onclick = 'approve(<?php echo $user['User']['id']?>,0)'><i class="icon-thumbs-down"></i>Disapprove User</a> 
<?php }else{?><a href='#' onclick = 'approve(<?php echo $user['User']['id'] ?>,1)'><i class="icon-thumbs-up"></i>Approve User</a><?php } ?></span></li><?php } ?>
                <?php } ?>
            </ul>
          </div>
        </div>
        <div class="span9">
        
          <div class="profile-info">
            <div class="tab-widget">
          
              <ul class="nav nav-tabs" id="myTab1">
                <li class="active"><a href="#user"><i class="icon-user"></i> Profile Info :  <span style="font-size:15px;font-weight:bold;"><?php echo h(strtoupper($user['User']['username']))?></span></a></li>
              </ul>
            
           
              <div class="tab-content">
                <div class="tab-pane active" id="user">
                <div class=" information-container">
                <div style="float:left;width:50%">
                 <h4>Basic Details</h4>
                  <ul class="profile-intro">
                   <li>
                      <label>Username :</label>
                      <?php if(isset($user['User']['username'])) echo h($user['User']['username']); else echo 'Not Mentioned';?></li>
                      <li>
                      <li>
                      <label>Business Name :</label>
                    <?php if(isset($usermeta['bus_name'])) echo $usermeta['bus_name'];  else echo 'Not Mentioned'; ?>
                 	</li>
                 	 
                 	
                  <li>
                      <label>Email ID :</label>
                      <?php if(isset($user['User']['email'])) echo h($user['User']['email']); else echo 'Not Mentioned';?>
                 </li>
           		 <li>
                      <label>Contact Number :</label>
                     <?php if(isset($usermeta['contact_no'])) echo $usermeta['contact_no'];else echo 'Not Mentioned'; ?>
                 </li>
                 
                 
                  <li>
                      <label>Address :</label>
                      <?php if(isset($usermeta['address'])) echo $usermeta['address'];else echo 'Not Mentioned';?>
                 </li>
                  <li>
                      <label>City :</label>
                        <?php if(isset($usermeta['city'])) echo $usermeta['city'];else echo 'Not Mentioned';?>
                 </li>
                 
                  <li>
                      <label>State :</label>
                   <?php if(isset($usermeta['state'])) echo $usermeta['state'];else echo 'Not Mentioned';?>
                 </li>
                 
                 <li>
                      <label>Country :</label>
                     <?php if(isset($usermeta['country_name'])) echo $usermeta['country_name'];else echo 'Not Mentioned';?>
                 </li>
                 
                 <li>
                      <label>Pincode :</label>
                     <?php if(isset($usermeta['pin'])) echo $usermeta['pin'];else echo 'Not Mentioned';?>
                 </li>
                  </ul>
                  </div>
                     <div style="float:left;height:45%">
                  <h4>Contact Person Details</h4>
                  <ul class="profile-intro">
                  
                  <li>
                      <label>Person Name :</label>
                      <?php if(isset($usermeta['con_name'])) echo $usermeta['con_name'];else echo 'Not Mentioned';?>
                 </li>
                 <li>
                    <label>Email ID :</label>
                      <?php if(isset($usermeta['con_email'])) echo $usermeta['con_email'];else echo 'Not Mentioned';?>
                 </li>
                 
                 <li>
                    <label>Contact Number :</label>
                      <?php if(isset($usermeta['mob_no'])) echo $usermeta['mob_no'];else echo 'Not Mentioned';?>
                 </li>
                  </ul>
                  </div>
                  
                    <div style="float:left;height:54%;margin-top:20px;">
                     <h4>Registration & Login Details</h4>
                  <ul class="profile-intro">
                  
                  <li>
                      <label>Registration Date :</label>
                      <?php if(isset($user['User']['created'])) echo $user['User']['created'];else echo 'Not Mentioned';?>
                 </li>
                 <li>
                    <label>Last Profile Modified Date :</label>
                      <?php if(isset($user['User']['modified'])) echo $user['User']['modified'];else echo 'Not Mentioned';?>
                 </li>
                 
                  <li>
                    <label>Approve Status :</label>
                     <?php if(isset($user['User']['approve'])) { if($user['User']['approve'] == 1) echo 'Approved User';else echo 'Not Approved User'; } else echo 'Not Mentioned';?>
                 </li>
                 
                  <li>
                    <label>Active Status :</label>
                      <?php if(isset($user['User']['active'])) { if($user['User']['active'] == 1) echo 'Active User';else echo 'Inactive User';} else echo 'Not Mentioned';?>
                 </li>
                 
                 <li>
                    <label>Last Login :</label>
                      <?php if(isset($user['User']['last_login'])) echo $user['User']['last_login'];else echo 'Not Mentioned';?>
                 </li>
                  </ul>
                    </div>
                 
              </div>    
                
                </div>
               
                
              </div>
            </div>
   <a style="float:right;" class="btn-notification" href="<?php echo $this->webroot;?>/allUsers"><i class="icon-reply"></i></a>
           <div style="clear:both;"></div>
          </div>
        <div>	
        </div>
      </div>
    </div>
  </div>
  </div>
  <script type = "text/javascript">
 function approve(id,status){
     
       	$.ajax({
	      url: "<?php echo $this->webroot; ?>usermgmt/Users/approve_ind",
	      dateType:'html',
	      type:'post',
	      data:'id='+id+'&status='+status,
	      success: function(data){	    
	      	$("#change"+id).html(data);
	      },
         
	    });
	    return false;
       }     
</script>