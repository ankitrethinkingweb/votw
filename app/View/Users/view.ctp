<h1>Users</h1>
<?php if ( ! empty($user) ) :?>
<label>Username : <?php echo $user['User']['user']; ?></label>

<label>Password : <?php echo $user['User']['pass']; ?></label>
<?php endif; ?>