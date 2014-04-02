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


	<?php echo $this->Form->create('User', array('action' => 'login','class'=>'form-signin','novalidate'=>'novalidate')); ?>
	<?php echo $this->Session->flash(); ?>
			<h3 class="form-signin-heading">Please sign in</h3>
			<div class="controls input-icon">
				<i class=" icon-user-md"></i>
				<?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"input-block-level",'placeholder'=>"Email address",'type'=>'text'))?>
			</div>
			<div class="controls input-icon">
				<i class=" icon-key"></i>
				<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"input-block-level",'placeholder'=>"Password"))?>
			</div>
			<?php   if(!isset($this->request->data['User']['remember']))
								$this->request->data['User']['remember']=true;
					?>
			<label class="checkbox">
			<input name="remember" type="checkbox" value="remember-me"> Remember me </label>

			<?php echo $this->Form->Submit(__('Sign In'),array('class'=>'btn btn-inverse btn-block'));?>
			<!--<button class="btn btn-inverse btn-block" type="submit">Sign in</button>-->
			<h4>Forgot your password ?</h4>
			<p>
			<?php echo $this->Html->link(__("Click Here ",true),"/forgotPassword") ?>to reset your password.
			</p>
			<h5>Don't have an account yet ?</h5>
			<?php echo $this->Html->link(__("Create Account",true),"/register",array('class'=>'btn btn-success btn-block')); ?>
		</form>
<script>
document.getElementById("UserEmail").focus();
</script>