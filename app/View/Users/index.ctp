<h1>Cake Php Users</h1>
<table>
<tr>
<th>Id</th>
<th>User</th>
<th>Password</th>
</tr>
<!-- Here is where we loop through our $posts array, printing out post info -->
<?php if ( ! empty($users) ) : foreach ($users as $post): ?>
<tr>
<td><?php echo $post['User']['id']; ?></td>
<td>
<?php echo $this->Html->link($post['User']['user'],
array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
</td>
<td><?php echo $post['User']['pass']; ?></td>
</tr>
<?php endforeach; endif; ?>
<?php unset($post); ?>
</table>