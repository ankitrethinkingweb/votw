<h3>Register Here</h3>

<?php 
if(isset($error)) print_r($error);
echo $this->Form->create('Register', array('url' => array('controller'=>'users','action'=>'do_register'),'class'=>'form-horizontal','novalidate'=>'novalidate'));
echo '<div class="control-group"><label class="control-label" for="username">Username</label><div class="controls">'.$this->Form->input('User.username',array('label' => false)).'</div></div><br/>';

echo $this->Form->error('username');
echo '<div class="control-group"><label class="control-label" for="contact">Contact Number</label><div class="controls">'.$this->Form->input('User.contact',array('label' => false)).'</div></div><br/>';
echo $this->Form->error('contact');
echo '<div class="control-group"><label class="control-label" for="email">Email Id</label><div class="controls">'.$this->Form->input('User.email',array('label' => false)).'</div></div><br/>';
echo $this->Form->error('email');
echo '<div class="control-group"><label class="control-label" for="password">Password</label><div class="controls">'.$this->Form->input('User.password',array('label' => false,'type' => 'password')).'</div></div><br/>';
echo '<div class="control-group"><label class="control-label" for="cpassword">Confirm Password</label><div class="controls">'.$this->Form->input('User.cpassword',array('label' => false,'type' => 'password')).'</div></div><br/>';
echo $this->Form->end(array('label' => __('Register', true), 'class' => 'btn btn-primary'));
?>
<?php
echo $this->Html->link('Cancel','/users/login',array('class'=>'btn btn-link'));
?>

