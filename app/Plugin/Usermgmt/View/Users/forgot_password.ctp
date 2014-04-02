<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<div class="container-fluid" style='margin-top:34px;'>
<div class="row-fluid">
				<div class="span12 code-example">
					<div class="content-widgets light-gray">
						<div class="widget-head green">
							<h3>Forgot Password</h3>
						</div>
						<div class="widget-container">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->Form->create('User', array('action' => 'forgotPassword','class'=>"form-inline",'novalidate'=>'novalidate')); ?>
									
										<?php echo $this->Form->input("email" ,array('label' => false,'placeholder'=>'Enter Email Address','div' => false))?>
											<div class="form-actions">
											<button type="submit" class="btn btn-primary">Send Email</button>	
											<?php echo $this->Form->end(); ?>
											<a id="UserLogin" href="<?php $this->webroot; ?>login" class="btn btn-extend" style="margin-left:10px;">Cancel</a>
									</div>
											
							</form>
                            
						</div>
					</div>
                 
				</div>
			</div>
</div>



<script>
document.getElementById("UserEmail").focus();
</script>