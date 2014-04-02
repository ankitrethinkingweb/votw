<?php echo $this->Session->flash(); ?>
<?php if($this->UserAuth->getGroupName() == 'User') { ?>
<?php if(isset($extension) && $extension > 0){ ?>
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert">ï¿½</button>
				<i class="icon-exclamation-sign"></i><strong>Info!</strong> <?php echo $extension; ?> Visa Application needs to be applied for Extension. Check Email  
</div>
<?php } ?>
<div class="switch-board gray">
		<div class="row-fluid ">
			<?=$outstanding?>
			<div class = "span7">
				
					<h6 class="page-header" style="float:left;width: 100%;"> Visa Applications </h6>
						
				<div class="span3">
					<div class="board-widgets blue-violate">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['visa_app'])) echo $count['visa_app']; ?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app">All<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets green">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_process'])) echo $count['app_process']; ?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/2">In Process <i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
			
				  <div class="span3">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_approve'])) echo $count['app_approve']; ?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
			</div>
				 <div class = "span5">
				
				
				<h6 class="page-header" style="float:left;width: 100%;"> OKTB Applications </h6>
						
				<div class="span4">
					<div class="board-widgets bondi-blue">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['oktb_process'])) echo $count['oktb_process']; ?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span4">
					<div class="board-widgets blue-violate">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['oktb_approve'])) echo $count['oktb_approve']; ?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
           </div>
          </div>
           
			
			<div class="row-fluid ">	
			
			
			<div class="span7">
					<h6 class=" page-header"> Extensions </h6>
				<div class="span3">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['all_ext'])) echo $count['all_ext']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list">All Extensions<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets green">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_process'])) echo $count['ext_in_process']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_approve'])) echo $count['ext_in_approve']; ?></span><span class="n-sources">Extensions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				</div>
				
				
				
			<div class="span5">
					<h6 class=" page-header"> Group OKTB</h6>
				
			<div class="span4">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_process'])) echo $count['group_oktb_process']; ?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/2/na/1">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_approve'])) echo $count['group_oktb_approve'];?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/5/na/1">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				</div>		
			</div>	

 <div class="row-fluid ">
	<div class="span5">
					<h6 class=" page-header"> Wallet Transactions</h6>
				
				<div class="span4">
					<div class="board-widgets orange">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['user_trans'])) echo $count['user_trans']; ?></span><span class="n-sources">Transactions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_transaction">Transactions<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets green">
						<div class="board-widgets-content">
							<span class="n-counter" ><?php if(isset($count['amt'])) echo $count['amt']; ?></span><span class="n-sources">Balance<?php if(isset($currency) && strlen($currency) > 0) echo ' in '.$currency;?> </span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>agent_trans">Your Wallet<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>

				</div>
</div>
      </div>   
<?php }else if($this->UserAuth->getGroupName() == 'Admin'){ ?>
<div class="switch-board gray">
		
		 <div class="row-fluid ">
			<div class="span7">
					<h6 class=" page-header"> Visa Applications </h6>
						
				<div class="span3">
					<div class="board-widgets blue">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['visa_app'])) echo $count['visa_app'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app">Visa Applications<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets bondi-blue">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_process'])) echo $count['app_process'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets orange">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_approve'])) echo $count['app_approve'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				</div>	
				<div class="span5">
					<h6 class=" page-header"> OKTB Applications </h6>
					<div class="span4">
						<div class="board-widgets green">
							<div class="board-widgets-content">
								<span class="n-counter"><?php if(isset($count['oktb_process'])) echo $count['oktb_process']; ?></span><span class="n-sources">Applications</span>
							</div>
							<div class="board-widgets-botttom">
								<a href="<?php echo $this->webroot; ?>oktb_apps/2">In Process<i class="icon-double-angle-right"></i></a>
							</div>
						</div>
					</div>
						
					<div class="span4">
						<div class="board-widgets magenta">
							<div class="board-widgets-content">
								<span class="n-counter"><?php if(isset($count['oktb_approve'])) echo $count['oktb_approve']; ?></span><span class="n-sources">Applications</span>
							</div>
							<div class="board-widgets-botttom">
								<a href="<?php echo $this->webroot; ?>oktb_apps/5">Approved<i class="icon-double-angle-right"></i></a>
							</div>
						</div>
					</div>
				</div>	
			</div>
			
		<div class="row-fluid ">
		
		
				<div class="span7">
					<h6 class=" page-header"> Extensions </h6>
				<div class="span3">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['all_ext'])) echo $count['all_ext']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list">All Extensions<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets green">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_process'])) echo $count['ext_in_process']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_approve'])) echo $count['ext_in_approve']; ?></span><span class="n-sources">Extensions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				</div>
				
				
				<div class="span5">
					<h6 class=" page-header"> Group OKTB</h6>
				
				<div class="span4">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_process'])) echo $count['group_oktb_process']; ?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/2/na/1">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_approve'])) echo $count['group_oktb_approve'];?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/5/na/1">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
			 </div>
           </div>

<div class ="row-fluid">
<div class="span5">
					<h6 class=" page-header"> Transaction </h6>
				
				<div class="span4">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['user_trans'])) echo $count['user_trans']; ?></span><span class="n-sources">Transactions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>transaction">All Transaction<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['user_transapp'])) echo $count['user_transapp'];?></span><span class="n-sources">Transactions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>transaction/1">Approval Pending <i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
			 </div>
</div>
           </div>
<?php } else{ ?>
<div class="switch-board gray">
		 <?php if($this->Session->read('role1.visa') == 1 || $this->Session->read('role1.oktb') == 1){ ?>
		 <div class="row-fluid ">
		 <?php if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1){
		 ?>
			<div class="span7">
					<h6 class=" page-header"> Visa Applications </h6>
						
				<div class="span3">
					<div class="board-widgets blue">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['visa_app'])) echo $count['visa_app'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app">Visa Applications<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets bondi-blue">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_process'])) echo $count['app_process'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets orange">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['app_approve'])) echo $count['app_approve'];?></span><span class="n-sources">Visa Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>all_visa_app/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				</div>	
				<?php } ?>
				<?php if($this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 ){ ?>
				<div class="span5">
					<h6 class=" page-header"> OKTB Applications </h6>
					<div class="span4">
						<div class="board-widgets green">
							<div class="board-widgets-content">
								<span class="n-counter"><?php if(isset($count['oktb_process'])) echo $count['oktb_process']; ?></span><span class="n-sources">Applications</span>
							</div>
							<div class="board-widgets-botttom">
								<a href="<?php echo $this->webroot; ?>oktb_apps/2">In Process<i class="icon-double-angle-right"></i></a>
							</div>
						</div>
					</div>
						
					<div class="span4">
						<div class="board-widgets magenta">
							<div class="board-widgets-content">
								<span class="n-counter"><?php if(isset($count['oktb_approve'])) echo $count['oktb_approve']; ?></span><span class="n-sources">Applications</span>
							</div>
							<div class="board-widgets-botttom">
								<a href="<?php echo $this->webroot; ?>oktb_apps/5">Approved<i class="icon-double-angle-right"></i></a>
							</div>
						</div>
					</div>
				</div>	
				<?php } ?>
			</div>
		<?php } ?>
		<?php if($this->Session->read('role1.oktb') == 1 || $this->Session->read('role1.extension') == 1 ){ ?>		
		<div class="row-fluid ">
		
		<?php if($this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1 ){ ?>
				<div class="span7">
					<h6 class=" page-header"> Extensions </h6>
				<div class="span3">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['all_ext'])) echo $count['all_ext']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list">All Extensions<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets green">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_process'])) echo $count['ext_in_process']; ?></span><span class="n-sources">Extension</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/2">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				<div class="span3">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['ext_in_approve'])) echo $count['ext_in_approve']; ?></span><span class="n-sources">Extensions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>extension_list/5">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				
				</div>
				<?php } ?>
				
				<?php if($this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 ){ ?>	
				<div class="span5">
					<h6 class=" page-header"> Group OKTB</h6>
				
				<div class="span4">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_process'])) echo $count['group_oktb_process']; ?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/2/na/1">In Process<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['group_oktb_approve'])) echo $count['group_oktb_approve'];?></span><span class="n-sources">Applications</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>oktb_apps/5/na/1">Approved<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
			 </div>
			 <?php } ?>
           </div>
           <?php } ?>
<?php if($this->Session->read('role2.trans_bank') == 1 ){ ?>	
<div class ="row-fluid">
<div class="span5">
					<h6 class=" page-header"> Transaction </h6>
				
				<div class="span4">
					<div class="board-widgets magenta">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['user_trans'])) echo $count['user_trans']; ?></span><span class="n-sources">Transactions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>transaction">All Transaction<i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="board-widgets dark-yellow">
						<div class="board-widgets-content">
							<span class="n-counter"><?php if(isset($count['user_transapp'])) echo $count['user_transapp'];?></span><span class="n-sources">Transactions</span>
						</div>
						<div class="board-widgets-botttom">
							<a href="<?php echo $this->webroot; ?>transaction/1">Approval Pending <i class="icon-double-angle-right"></i></a>
						</div>
					</div>
				</div>
			 </div>
</div>
           </div>
           <?php } ?>
<?php } ?>  