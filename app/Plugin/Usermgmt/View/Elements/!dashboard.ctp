
<div class="leftbar leftbar-close clearfix">
		<div class="admin-info clearfix">
			<div class="admin-thumb">
				<i class="icon-user"></i>
			</div>
			<div class="admin-meta">
				<ul>
					<li class="admin-username"><?php if($this->Session->read('UserAuth.User.last_name') == true or $this->Session->read('UserAuth.User.first_name') == true ) {echo $this->Session->read('UserAuth.User.first_name').' '.$this->Session->read('UserAuth.User.last_name'); } else echo 'User';?></li>
					<li><a href="<?php echo $this->webroot;?>editUser/<?php echo $this->UserAuth->getUserId() ?>">Edit Profile</a></li>
					<li><a href="<?php echo $this->webroot;?>viewUser/<?php echo $this->UserAuth->getUserId() ?>">View Profile </a><a href="<?php  echo $this->webroot; ?>logout"><i class="icon-lock"></i> Logout</a></li>
				</ul>
			</div>
		</div>
		<div class="left-nav clearfix">
			<div class="left-primary-nav">
				<ul id="myTab">
					<li class="active"><a href="#main" class="icon-desktop" ></a></li>
					<li><a href="#forms" class="icon-th" ></a></li>
					<li><a href="#features" class="icon-user" ></a></li>
					<li><a href="#ui-elements" class="icon-group" ></a></li>
					
				</ul>
				
			</div>
			<div class="responsive-leftbar">
				<i class="icon-list"></i>
			</div>
			<div class="left-secondary-nav tab-content">
				<div class="tab-pane active" id="main">
					<h4 class="side-head">Dashboard</h4>
					
					<ul class="metro-sidenav clearfix">
						<li><a href="#" class="brown"><i class="icon-user"></i><span>Users</span></a></li>
						<li><a href="#" class="orange"><i class="icon-group"></i><span>Groups</span></a></li>
						<li><a href="#" class=" blue-violate"><i class="icon-book"></i><span>Visa Application</span></a></li>
						<li><a href="#" class=" magenta"><i class="icon-thumbs-up"></i><span>Approvals</span></a></li>
						<li><a href="#" class="green"><i class="icon-shopping-cart"></i><span>Transactions</span></a></li>
						<li><a href="<?php echo $this->webroot;?>changePassword" class="bondi-blue"><i class="icon-edit"></i><span>Change Password</span></a></li>
					</ul>

				</div>
				<div class="tab-pane" id="forms">
					<h4 class="side-head">Masters</h4>
					<ul id="nav" class="accordion-nav">
						<li><a href="#"><i class="icon-minus-sign"></i> User Details Masters</a>
						<ul>
							<li><a href="<?php echo $this->webroot; ?>admins/rel_master"><i class=" icon-file-alt"></i> Relationship</a></li>
							<li><a href="<?php echo $this->webroot; ?>admins/mar_status_master"><i class=" icon-file-alt"></i> Marital Status</a></li>
							<li><a href="<?php echo $this->webroot; ?>admins/lang_master"><i class=" icon-file-alt"></i> Languages</a></li>
							<li><a href="page-500.html"><i class=" icon-file-alt"></i> Religion</a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Education</a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Profession</a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Purpose of Visit</a></li>
						</ul>
						</li>
					
						<li><a href="#"><i class="icon-minus-sign"></i>Types Masters</a>
						<ul>
							<li><a href="page-403.html"><i class=" icon-file-alt"></i> Agent Types</a></li>
							<li><a href="page-404.html"><i class=" icon-file-alt"></i> Employment Types</a></li>
							<li><a href="page-405.html"><i class=" icon-file-alt"></i> Passport Types</a></li>
							<li><a href="page-500.html"><i class=" icon-file-alt"></i> Visa Types</a></li>
							
						</ul>
						</li>
						<li><a href="#"><i class="icon-minus-sign"></i>Tour Details Masters</a>
						<ul>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Airlines </a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Travelling Cities</a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Country</a></li>
						</ul>
						</li>
						
						<li><a href="#"><i class="icon-minus-sign"></i>Transaction Masters</a>
						<ul>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Currency</a></li>
							<li><a href="page-503.html"><i class=" icon-file-alt"></i> Transaction Status</a></li>
						
						</ul>
						</li>
					</ul>
				</div>
				<div class="tab-pane" id="features">
					<h4 class="side-head">User Details</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>allUsers"><i class="icon-table"></i> All Users</a></li>
						<li><a href="<?php echo $this->webroot; ?>addUser"><i class="icon-table"></i> Add User</a></li>
						
					</ul>
				</div>
				<div class="tab-pane" id="ui-elements">
					<h4 class="side-head">Group Details</h4>
					<ul class="accordion-nav">
						<li><a href="<?php echo $this->webroot; ?>allGroups"><i class="icon-table"></i> All Groups</a></li>
						<li><a href="<?php echo $this->webroot; ?>addGroup"><i class="icon-table"></i> Add Group</a></li>
					<li><a href="<?php echo $this->webroot; ?>permissions"><i class="icon-table"></i> Permissions</a></li>

					</ul>
				</div>
						
			</div>
			</div>
			</div>