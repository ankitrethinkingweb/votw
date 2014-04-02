<h3>Login Users</h3>
<?php 
echo $this->Form->create('Login', array('url' => array('controller'=>'users','action'=>'do_login'),'novalidate'=>'novalidate','class'=>'form-horizontal'));
echo '<div class="control-group"><label class="control-label" for="username">Username</label><div class="controls">'.$this->Form->input('username',array('label' => false)).'</div></div><br/>';
echo '<div class="control-group"><label class="control-label" for="password">Password</label><div class="controls">'.$this->Form->input('password',array('label' => false,'type' => 'password')).'</div></div><br/>';
//echo $this->Form->end('Login',array('class'=>'btn btn-primery'));
echo $this->Form->end(array('label' => __('Login', true), 'class' => 'btn btn-primary'));
?>
<?php
echo $this->Html->link('New User? Register Here','/users/register',array('class'=>'btn btn-link'));
?>
