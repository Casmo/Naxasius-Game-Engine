<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Users</h1>

<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'User.id'); ?></th>
<th><?php echo $this->Paginator->sort('Username', 'User.username'); ?></th>
<th class="big"><?php echo $this->Paginator->sort('Email', 'User.email'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Activationcode', 'User.activation_code'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Role', 'User.role'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($users as $user) {
	echo '<tr>';
	echo '<td class="center">'. $this->Html->link($user['User']['id'], '/admin/users/edit/'. $user['User']['id']) .'</td>';
	echo '<td>'. $this->Html->link($user['User']['username'], '/admin/users/edit/'. $user['User']['id']) .'</td>';
	echo '<td>'. $this->Html->link($user['User']['email'], '/admin/users/edit/'. $user['User']['id']) .'</td>';
	echo '<td>'. $this->Html->link($user['User']['activation_code'], '/admin/users/edit/'. $user['User']['id']) .'</td>';
	echo '<td>'. $this->Html->link($user['User']['role'], '/admin/users/edit/'. $user['User']['id']) .'</td>';
	echo '<td>'. $this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/users/delete/'. $user['User']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="6">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/users/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>