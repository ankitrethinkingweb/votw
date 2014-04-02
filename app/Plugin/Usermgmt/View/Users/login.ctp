	<h1 style = "margin-top:50px;"><a href="index.html"><img src="img/logo-big.png" alt="" class='retina-ready' width="59" height="49">FLAT</a></h1>
	<div class="login-body">
			<h2>SIGN IN</h2>
			<?php echo $this->Form->create('User', array('action' => 'login','class'=>'form-signin','novalidate'=>'novalidate','class'=>'form-validate')); ?>
				<div class="control-group">
					<div class="email controls">
						<?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"input-block-level",'placeholder'=>"Email address",'type'=>'text'))?>
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"input-block-level",'placeholder'=>"Password"))?>
					</div>
				</div>
				<div class="submit">
					<div class="remember">
					<?php   if(!isset($this->request->data['User']['remember'])) $this->request->data['User']['remember']=true;	?>
						<input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="blue" id="remember"> <label for="remember">Remember me</label>
					</div>
					<input type="submit" value="Sign me in" class='btn btn-primary'>
				</div>
			</form>
			<div class="forget">
				<?php echo $this->Html->link(__("Forgot Password ",true),"/forgotPassword") ?>			
			</div>
		</div>
		
		
		

<script>
document.getElementById("UserEmail").focus();
</script>