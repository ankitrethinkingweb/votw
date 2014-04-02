
<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">FLAT</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>
				<li class='active'>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Dashboard</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->webroot; ?>allUsers" >Agents</a></li>
						<li><a href="<?php echo $this->webroot; ?>all_user_roles" >User Role Management</a></li>
						<li><a href="<?php echo $this->webroot; ?>search" >Reports</a></li>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app" >Paid Visa Application</a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb_apps/3" >Paid OKTB Application</a></li>
						<li><a href="<?php echo $this->webroot;?>extension_list" >Extension Request(s)</a></li>				
	                    <li><a href="<?php echo $this->webroot;?>transaction" >Bank Transactions</a></li>
						<li><a href="<?php echo $this->webroot;?>amt_bal" >Finance</a></li>					
						<li><a href="<?php echo $this->webroot;?>adocument" >Documentation</a></li>						
					</ul>
				</li>
				
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Users</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->webroot; ?>allUsers">All Users</a></li>
						<li><a href="<?php echo $this->webroot; ?>addUser">Add Users</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Visa</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->webroot; ?>all_visa_app">Paid Visa Application</a></li>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app2">All Visa Application</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Masters</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
							<li><a href="<?php echo $this->webroot; ?>rel_master">Relationship</a></li>
							<li><a href="<?php echo $this->webroot; ?>mar_status_master">Marital Status</a></li>
							<li><a href="<?php echo $this->webroot; ?>lang_master">Languages</a></li>
							<li><a href="<?php echo $this->webroot; ?>religion_master">Religion</a></li>
							<li><a href="<?php echo $this->webroot; ?>education_master">Education</a></li>
							<li><a href="<?php echo $this->webroot; ?>profession_master">Profession</a></li>
							<li><a href="<?php echo $this->webroot; ?>visit_master">Purpose of Visit</a></li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Masters</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
							<li><a href="<?php echo $this->webroot; ?>rel_master">Relationship</a></li>
							<li><a href="<?php echo $this->webroot; ?>mar_status_master">Marital Status</a></li>
							<li><a href="<?php echo $this->webroot; ?>lang_master">Languages</a></li>
							<li><a href="<?php echo $this->webroot; ?>religion_master">Religion</a></li>
							<li><a href="<?php echo $this->webroot; ?>education_master">Education</a></li>
							<li><a href="<?php echo $this->webroot; ?>profession_master">Profession</a></li>
							<li><a href="<?php echo $this->webroot; ?>visit_master">Purpose of Visit</a></li>
					</ul>
				</li>
			</ul>
		</div>
</div>				
<?php if($this->UserAuth->getGroupName() == 'Admin') { ?>
<div class="leftbar leftbar-close clearfix">
		<div class="admin-info clearfix">
			<div class="admin-thumb">
				<i class="icon-user"></i>
			</div>
			<div class="admin-meta">
				<ul>
					<li class="admin-username"><?php if($this->Session->read('UserAuth.User.username') == true) echo $this->Session->read('UserAuth.User.username'); else echo 'User';?></li>
					<?php if($this->UserAuth->getGroupName() != 'Admin') { ?>
					<li><a href="<?php echo $this->webroot;?>editUser/<?php echo $this->UserAuth->getUserId() ?>">Edit Profile</a></li>
					<li><a href="<?php echo $this->webroot;?>viewUser/<?php echo $this->UserAuth->getUserId() ?>">View Profile </a>
					<a href="<?php  echo $this->webroot; ?>logout"><i class="icon-lock"></i> Logout</a></li>
					<?php }else{ ?><li><a href="<?php  echo $this->webroot; ?>logout"><i class="icon-lock"></i> Logout</a></li>
					<li ><a href="<?php echo $this->webroot; ?>login" ><i class="icon-home"></i> Visa Home</a></li>	
<?php } ?>
				</ul>
			</div>
		</div>
		
		<div class="left-nav clearfix">
			<div class="left-primary-nav">
			
				<ul id="myTab">
					<li class="active"><a href="#main" class="icon-desktop" ></a></li>
					<li><a href="#users" class="icon-user" ></a></li>
					<li><a href="#ui-elements" class="icon-tasks" ></a></li>
					<li><a href="#forms" class="icon-th" ></a></li>
					<li><a href="#oktb" class="icon-group" ></a></li>
					<li><a href="#extension" class="icon-list-alt" ></a></li>
					<li><a href="#finance" class="icon-money" ></a></li>
				</ul>				
			</div>
			<div class="responsive-leftbar" style = "display:none">
				<i class="icon-globe"></i>
			</div>
			<div class="left-secondary-nav tab-content">
			
				<div class="tab-pane active" id="main">
					<h4 class="side-head">Dashboard</h4>
					
					<ul class="metro-sidenav clearfix">
						<li><a href="<?php echo $this->webroot; ?>allUsers" class="brown"><i class="icon-user"></i><span>Agents</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>all_user_roles" class="blue-violate"><i class="icon-user"></i><span>User Role Management</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>search" class="dark-yellow"><i class="icon-bar-chart"></i><span>Reports</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app" class="blue"><i class="icon-list"></i><span>Paid Visa Application</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb_apps/3" class="magenta"><i class="icon-list"></i><span>Paid OKTB Application</span></a></li>
						<li><a href="<?php echo $this->webroot;?>extension_list" class="green"><i class="icon-tasks"></i><span>Extension Request(s)</span></a></li>				
	                    <li><a href="<?php echo $this->webroot;?>transaction" class="orange"><i class="icon-shopping-cart"></i><span>Bank Transactions</span></a></li>
						<li><a href="<?php echo $this->webroot;?>amt_bal" class="bondi-blue"><i class="icon-copy"></i><span>Finance</span></a></li>					
						<li><a href="<?php echo $this->webroot;?>adocument" class="blue-violate"><i class="icon-cogs"></i><span>Documentation</span></a></li>						
					</ul>
				</div>
				
				<div class="tab-pane" id="users">
				<h4 class="side-head">Users</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>allUsers"><i class="icon-table"></i> All Users</a></li>
						<li><a href="<?php echo $this->webroot; ?>addUser"><i class="icon-table"></i> Add Users</a></li>
						
					</ul>
				</div>
			
				<div class="tab-pane" id="ui-elements">
					<h4 class="side-head">Visa Details </h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>all_visa_app"><i class="icon-table"></i> Paid Visa Application</a></li>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app2"><i class="icon-table"></i> All Visa Application</a></li>
						
					</ul>
				</div>	
				<div class="tab-pane" id="forms">
					<h4 class="side-head">Masters</h4>
					<ul id="nav" class="accordion-nav">
						<li><a href="#"><i class="icon-minus-sign"></i> User Details Masters</a>
						<ul>
							<li><a href="<?php echo $this->webroot; ?>rel_master"><i class=" icon-file-alt"></i> Relationship</a></li>
							<li><a href="<?php echo $this->webroot; ?>mar_status_master"><i class=" icon-file-alt"></i> Marital Status</a></li>
							<li><a href="<?php echo $this->webroot; ?>lang_master"><i class=" icon-file-alt"></i> Languages</a></li>
							<li><a href="<?php echo $this->webroot; ?>religion_master"><i class=" icon-file-alt"></i> Religion</a></li>
							<li><a href="<?php echo $this->webroot; ?>education_master"><i class=" icon-file-alt"></i> Education</a></li>
							<li><a href="<?php echo $this->webroot; ?>profession_master"><i class=" icon-file-alt"></i> Profession</a></li>
							<li><a href="<?php echo $this->webroot; ?>visit_master"><i class=" icon-file-alt"></i> Purpose of Visit</a></li>
						</ul>
						</li>
					
						<li><a href="#"><i class="icon-minus-sign"></i>Types Masters</a>
						<ul>
							<li><a href="<?php echo $this->webroot; ?>agent_master"><i class=" icon-file-alt"></i> Agent Types</a></li>
							<li><a href="<?php echo $this->webroot; ?>emp_master"><i class=" icon-file-alt"></i> Employment Types</a></li>
							<li><a href="<?php echo $this->webroot; ?>passport_master"><i class=" icon-file-alt"></i> Passport Types</a></li>
							<li><a href="<?php echo $this->webroot; ?>visa_master"><i class=" icon-file-alt"></i> Visa Types</a></li>
							
						</ul>
						</li>
						<li><a href="#"><i class="icon-minus-sign"></i>Tour Details Masters</a>
						<ul>
							<li><a href="<?php echo $this->webroot; ?>airline_master"><i class=" icon-file-alt"></i> Airlines </a></li>
							<li><a href="<?php echo $this->webroot; ?>oktb_airline_master"><i class=" icon-file-alt"></i> OKTB Airline </a></li>
							<li><a href="<?php echo $this->webroot; ?>cities_master"><i class=" icon-file-alt"></i> Travelling Cities</a></li>
							<li><a href="<?php echo $this->webroot; ?>country_master"><i class=" icon-file-alt"></i> Country</a></li>
						</ul>
						</li>
						
						<li><a href="#"><i class="icon-minus-sign"></i>Transaction Masters</a>
						<ul>
							<li><a href="<?php echo $this->webroot; ?>bank_master"><i class=" icon-file-alt"></i> Bank </a></li>
							<li><a href="<?php echo $this->webroot; ?>tr_mode_master"><i class=" icon-file-alt"></i> Transaction Mode </a></li>
							<li><a href="<?php echo $this->webroot; ?>currency_master"><i class=" icon-file-alt"></i> Currency</a></li>
							<li><a href="<?php echo $this->webroot; ?>tran_master"><i class=" icon-file-alt"></i> Transaction Status</a></li>
							<li><a href="<?php echo $this->webroot; ?>admin_tran_master"><i class=" icon-file-alt"></i>Admin Transaction Status</a></li>
						</ul>
						</li>
					</ul>
				</div>
				
			<div class="tab-pane" id="oktb">
				<h4 class="side-head">OKTB Details</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>oktb_apps"><i class="icon-table"></i> All OKTB Applications</a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb_apps/3"><i class="icon-table"></i> Paid OKTB Applications</a></li>
						
					</ul>
			</div>

			<div class="tab-pane" id="extension">
					<h4 class="side-head">Extension Details </h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot;?>all_visa_extend_data" ><i class="icon-tasks"></i>Add/Edit Extension Date</a></li>
						<li><a href="<?php echo $this->webroot; ?>extension_list"><i class="icon-table"></i>Extension Request(s)</a></li>
					</ul>
			</div>

			<div class="tab-pane" id="finance">
					<h4 class="side-head"> Finance </h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>amt_bal"><i class="icon-table"></i>User Amount Balance</a></li>
						<li><a href="<?php echo $this->webroot;?>threshold" ><i class="icon-table"></i>Set Credit Amount</a></li>
						<li><a href="<?php echo $this->webroot; ?>transaction"><i class="icon-table"></i>Bank Transaction</a></li>
						<li><a href="<?php echo $this->webroot; ?>extCost"><i class="icon-table"></i> Extension Cost Setting</a></li>
						<li><a href="<?php echo $this->webroot; ?>agent_airline_cost"><i class="icon-table"></i>Airline Cost Settings</a></li>
						<li><a href="<?php echo $this->webroot; ?>cost_settings"><i class="icon-table"></i> Visa Cost Setting</a></li>
					
					</ul>
			</div>
			
			</div>
			</div>
			</div>
			<?php }else if($this->UserAuth->getGroupName() == 'User')  { ?>
			<div class="leftbar leftbar-close clearfix">
		<div class="admin-info clearfix">
			<div class="admin-thumb">
				<i class="icon-user"></i>
			</div>
			<div class="admin-meta">
				<ul>
					<li class="admin-username"><?php if($this->Session->read('UserAuth.User.username') == true) echo $this->Session->read('UserAuth.User.username'); else echo 'User';?></li>
					<li><a href="<?php echo $this->webroot;?>edit_profile">Edit Profile</a></li>
				<li><a href="<?php echo $this->webroot;?>myprofile">View Profile </a><a href="<?php  echo $this->webroot; ?>logout"><i class="icon-lock"></i> Logout</a></li>
				<li ><a href="<?php echo $this->webroot; ?>login" ><i class="icon-home"></i> Visa Home</a></li>
				</ul>
			</div>
		</div>
			<div class="left-nav clearfix">
			<div class="left-primary-nav">
				<ul id="myTab">
					<li class="active"><a href="#main" class="icon-desktop"></a></li>
					<li><a href="#forms" class="icon-random" ></a></li>
					<li><a href="#features" class="icon-th" ></a></li>
					<li><a href="#ui-elements" class="icon-screenshot" ></a></li>
					<li><a href="#oktb" class="icon-group" ></a></li>
					<li><a href="#extension" class="icon-list-alt" ></a></li>
				</ul>
				
			</div>
			<div class="responsive-leftbar" style = "display:none">
				<i class="icon-globe"></i>
			</div>
			<div class="left-secondary-nav tab-content">
			
				<div class="tab-pane active" id="main">
					<h4 class="side-head">Dashboard</h4>
					
					<ul class="metro-sidenav clearfix">
					<li><a href="<?php echo $this->webroot;?>quick_app" class="blue-violate"><i class="icon-bolt"></i><span>Quick Visa App</span></a></li>
					<!--<li><a href="<?php echo $this->webroot; ?>visa_app" class=" blue-violate"><i class="icon-share"></i><span>New Visa Application</span></a></li>-->
						<li><a href="<?php echo $this->webroot; ?>all_visa_app" class="orange"><i class="icon-tasks"></i><span>My Visa Applications</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb" class="magenta"><i class="icon-share"></i><span>New OKTB Application</span></a></li>
						<li><a href="<?php echo $this->webroot;?>oktb_apps" class="bondi-blue"><i class="icon-tasks"></i><span>My OKTB Applications</span></a></li>
						<li><a href="<?php echo $this->webroot;?>all_extension" class="orange"><i class="icon-tasks"></i><span>My Extension Visa</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>search" class="dark-yellow"><i class="icon-search"></i><span>Search</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>agent_trans" class="blue"><i class="icon-shopping-cart"></i><span>All Transactions</span></a></li>
						<li></span><a href="<?php echo $this->webroot; ?>all_transaction" class="brown"><i class="icon-retweet"></i><span>Bank Transactions</span></a></li>
						<li><a href="<?php echo $this->webroot; ?>document" class="green"><i class="icon-list-alt"></i><span>Documentation</span></a></li>
						<!--<li><a href="<?php //echo $this->webroot;?>changePassword" class="bondi-blue"><i class="icon-edit"></i><span>Change Password</span></a></li>-->
						
					</ul>

				</div>
				<div class="tab-pane" id="forms">
					<h4 class="side-head">Bank Transactions</h4>
					<ul id="nav" class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>all_transaction"><i class="icon-retweet"></i>All Bank Transactions</a></li>
						<li><a href="<?php echo $this->webroot; ?>new_transaction"><i class="icon-share"></i>New Bank Transaction</a></li>
					</ul>
				</div>
				<div class="tab-pane" id="features">
					<h4 class="side-head">Visa Applications</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>all_visa_app"><i class="icon-table"></i> All Visa Applications</a></li>
						<li><a href="<?php echo $this->webroot; ?>visa_app"><i class="icon-share"></i> New Visa Application</a></li>
						<li><a href="<?php echo $this->webroot; ?>quick_app"><i class="icon-bolt"></i>Quick Visa App</a></li>
						
					</ul>
				</div>
				<div class="tab-pane" id="ui-elements">
					<h4 class="side-head">Transactions</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>agent_trans"><i class="icon-table"></i> All Transactions</a></li>
						

					</ul>
				</div>
				
				<div class="tab-pane" id="oktb">
				<h4 class="side-head">OKTB Details</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>oktb_apps"><i class="icon-table"></i> All OKTB Applications</a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb"><i class="icon-table"></i> New OKTB Applications</a></li>
					</ul>
			</div>

			<div class="tab-pane" id="extension">
					<h4 class="side-head">Extension Details </h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>all_extension"><i class="icon-table"></i> My Extensions</a></li>
						<li><a href="<?php echo $this->webroot; ?>extension_list"><i class="icon-table"></i>Extension Request(s)</a></li>
						<!--<li><a href="<?php //echo $this->webroot; ?>extension"><i class="icon-table"></i> Add Extensions </a></li>-->
					</ul>
			</div>
						
			</div>
			</div>
			</div>
			<?php }else if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User') { 
			//print_r($this->Session->read('role1.role_id')); exit;
			?>
			
<div class="leftbar leftbar-close clearfix">
		<div class="admin-info clearfix">
			<div class="admin-thumb">
				<i class="icon-user"></i>
			</div>
			<div class="admin-meta">
				<ul>
					<li class="admin-username"><?php if($this->Session->read('UserAuth.User.username') == true) echo $this->Session->read('UserAuth.User.username'); else echo 'User';?></li>
					<li ><a href="<?php echo $this->webroot; ?>login" ><i class="icon-home"></i> Visa Home</a></li>	
					<li><a href="<?php  echo $this->webroot; ?>logout"><i class="icon-lock"></i> Logout</a></li>
				</ul>
			</div>
		</div>
		
		<div class="left-nav clearfix">
			<div class="left-primary-nav">
				<ul id="myTab">
					<li class="active"><a href="#main" class="icon-desktop" ></a></li>
					<?php if($this->Session->read('role1.agent') && $this->Session->read('role1.agent') == 1){ ?><li><a href="#agents-ui" class="icon-tasks" ></a></li> <?php } ?>
					<?php if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1){ ?><li><a href="#ui-elements" class="icon-tasks" ></a></li> <?php } ?>
					<?php if($this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1){ ?><li><a href="#oktb" class="icon-group" ></a></li><?php } ?>
					<?php if($this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1){ ?><li><a href="#extension" class="icon-list-alt" ></a></li><?php } ?>
					<?php if($this->Session->read('role2.trans_amt_bal') == 1  || $this->Session->read('role2.trans_bank') == 1 || $this->Session->read('role2.visa_cost_settings') == 1 || $this->Session->read('role2.airline_cost_settings') == 1 || $this->Session->read('role2.ext_cost_settings') == 1 || $this->Session->read('role2.set_credit_limit') == 1){ ?>
					<li><a href="#finance" class="icon-money" ></a></li>
					<?php } ?>
				</ul>				
			</div>
			<div class="responsive-leftbar" style = "display:none">
				<i class="icon-globe"></i>
			</div>
			<div class="left-secondary-nav tab-content">
			
				<div class="tab-pane active" id="main">
					<h4 class="side-head">Dashboard</h4>
					<ul class="metro-sidenav clearfix">
						<?php if($this->Session->read('role1.agent') && $this->Session->read('role1.agent') == 1){ ?><li><a href="<?php echo $this->webroot; ?>allUsers" class="brown"><i class="icon-user"></i><span>Agents</span></a></li><?php } ?>
						<?php if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1){  if($this->session->read('role2.visa_status') == 1){ ?>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app" class="blue-violate"><i class="icon-list"></i><span>Paid Visa Application</span></a></li>
						<?php }else { ?>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app2" class="blue-violate"><i class="icon-list"></i><span>Paid Visa Application</span></a></li>
						<?php } } ?>
						<?php if($this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1){ ?><li><a href="<?php echo $this->webroot; ?>oktb_apps/3" class="magenta"><i class="icon-list"></i><span>Paid OKTB Application</span></a></li><?php } ?>
						<?php if($this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1){ ?><li><a href="<?php echo $this->webroot;?>extension_list" class="green"><i class="icon-tasks"></i><span>Extension Request(s)</span></a></li> <?php } ?>				
	                    <?php if($this->Session->read('role2.trans_bank') && $this->Session->read('role2.trans_bank') == 1){ ?><li><a href="<?php echo $this->webroot;?>transaction" class="orange"><i class="icon-shopping-cart"></i><span>Bank Transactions</span></a></li><?php } ?>
						<?php if($this->Session->read('role2.trans_amt_bal') == 1 ){ ?><li><a href="<?php echo $this->webroot;?>amt_bal" class="bondi-blue"><i class="icon-copy"></i><span>Finance</span></a></li><?php } ?>					
					</ul>
				</div>
				<?php if($this->Session->read('role1.agent') && $this->Session->read('role1.agent') == 1){ ?>
				<div class="tab-pane" id="agents-ui">
				<h4 class="side-head">Users</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>allUsers"><i class="icon-table"></i> All Users</a></li>
						<?php if($this->Session->read('role2.agent_add') && $this->Session->read('role2.agent_add') == 1){ ?>	<li><a href="<?php echo $this->webroot; ?>addUser"><i class="icon-table"></i> Add Users</a></li><?php } ?>
					</ul>
				</div>
				<?php } ?>
			
				<?php if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1){ ?>
				<div class="tab-pane" id="ui-elements">
					<h4 class="side-head">Visa Details </h4>
					<ul class="accordion-nav">
					<?php if($this->session->read('role2.visa_status') == 1){ ?>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app"><i class="icon-table"></i> Paid Visa Application</a></li>
						<?php }else { ?>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app2"><i class="icon-table"></i> Paid Visa Application</a></li>						
						<?php } ?>
						<li><a href="<?php echo $this->webroot; ?>all_visa_app2"><i class="icon-table"></i> All Visa Application</a></li>
					</ul>
				</div>	
				<?php } ?>
			<?php if($this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1){ ?>	
			<div class="tab-pane" id="oktb">
				<h4 class="side-head">OKTB Details</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>oktb_apps"><i class="icon-table"></i> All OKTB Applications</a></li>
						<li><a href="<?php echo $this->webroot; ?>oktb_apps/3"><i class="icon-table"></i> Paid OKTB Applications</a></li>
					</ul>
			</div>
			<?php } ?>
			<?php if($this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1){ ?>
			<div class="tab-pane" id="extension">
					<h4 class="side-head">Extension Details </h4>
					<ul class="accordion-nav">
						<?php if($this->Session->read('role2.ext_edit') == 1){ ?><li><a href="<?php echo $this->webroot;?>all_visa_extend_data" ><i class="icon-tasks"></i>Add/Edit Extension Date</a></li><?php } ?>
						<li><a href="<?php echo $this->webroot; ?>extension_list"><i class="icon-table"></i>Extension Request(s)</a></li>
					</ul>
			</div>
			<?php } ?>
			<?php if($this->Session->read('role2.trans_amt_bal') == 1  || $this->Session->read('role2.trans_bank') == 1 || $this->Session->read('role2.visa_cost_settings') == 1 || $this->Session->read('role2.airline_cost_settings') == 1 || $this->Session->read('role2.ext_cost_settings') == 1 || $this->Session->read('role2.set_credit_limit') == 1){ ?>
			<div class="tab-pane" id="finance">
					<h4 class="side-head"> Finance </h4>
					<ul class="accordion-nav">
						<?php if($this->Session->read('role2.trans_amt_bal') == 1){ ?><li><a href="<?php echo $this->webroot; ?>amt_bal"><i class="icon-table"></i>User Amount Balance</a></li><?php } ?>
						<?php if($this->Session->read('role2.set_credit_limit') == 1){ ?><li><a href="<?php echo $this->webroot;?>threshold" ><i class="icon-table"></i>Set Credit Amount</a></li><?php } ?>
						<?php if($this->Session->read('role2.trans_bank') == 1){ ?><li><a href="<?php echo $this->webroot; ?>transaction"><i class="icon-table"></i>Bank Transaction</a></li><?php } ?>
						<?php if($this->Session->read('role2.ext_cost_settings') == 1){ ?><li><a href="<?php echo $this->webroot; ?>extCost"><i class="icon-table"></i> Extension Cost Setting</a></li><?php } ?>
						<?php if($this->Session->read('role2.airline_cost_settings') == 1){ ?><li><a href="<?php echo $this->webroot; ?>agent_airline_cost"><i class="icon-table"></i>Airline Cost Settings</a></li><?php } ?>
						<?php if($this->Session->read('role2.visa_cost_settings') == 1){ ?><li><a href="<?php echo $this->webroot; ?>cost_settings"><i class="icon-table"></i> Visa Cost Setting</a></li><?php } ?>
					</ul>
			</div>
			<?php } ?>
			</div>
			</div>
			</div>
			<?php } ?>
			
			<script type="text/javascript">
			
			$('.responsive-leftbar').click(function(){
			 var width = $('div.leftbar.clearfix').width();
			 var left = $('div.leftbar.clearfix').css("left");
			if(left == '0px' || left =='auto')
			{
			  $('div.leftbar.clearfix').stop().animate({left: - width  },500); 
			  $('body').css('background-color','#FFF');
			  
			  if (document.documentElement.clientWidth > 768) {
	
			  $('div.main-wrapper').css('margin-left','0px');
			  $('div.main-wrapper').css('margin-right',width+'px');
			}else
			{
			$('div.main-wrapper').css('margin-left','0px');
			  $('div.main-wrapper').css('margin-right','0px');
			}
			  }
  			else
  			{
      		  $('div.leftbar.clearfix').animate({left:"0px"},500); 
      		   $('body').css('background-color','#E1E1E1');
      		   if (document.documentElement.clientWidth > 768) {
			  $('div.main-wrapper').css('margin-left',width+'px');  
			  $('div.main-wrapper').css('margin-right','0px');  
			 }else
			 {
			 $('div.main-wrapper').css('margin-left','0px');
			  $('div.main-wrapper').css('margin-right','0px');
			 }
			  }
			 
			});
			
		$(document).ready(function(){
				menu_highlight();
			});
			function menu_highlight()
			{
				var loc = window.location.href;
				var piece =loc.split('/');
				var str = piece[piece.length -2]+'/'+piece[piece.length -1];
				//var str = piece[piece.length -1];
				var str1 = piece[piece.length -2];
				
				if(piece[piece.length -1] != 'edit_profile' && piece[piece.length -1] != 'myprofile' && $('a[href$="' + str + '"]').length !== 0 && str1 != "edit_visa_app")
				{
					 $("li").removeClass('active');
					 $("div").removeClass('active');
					
					 if($('a[href$="' + str + '"]').length > 0){					  
						 $('a[href$="' + str + '"]').last().closest('li').addClass('active');
						 $('a[href$="' + str + '"]').last().closest('div').addClass('active');
						 var id = $('a[href$="' + str + '"]').last().closest('div').attr('id');
						 $('a[href$="' + id + '"]').parents('li').addClass('active');
					 }
				}else{
					 $('a[href$="main"]').last().closest('li').addClass('active');
						 $('a[href$="main"]').last().closest('div').addClass('active');
				}
			}
			</script>
			
			