<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Characters</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Character.id'); ?></th>
<th><?php echo $this->Paginator->sort('Name', 'Character.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Type', 'Type.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('User', 'User.username'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($characters as $character) {
	echo '<tr>';
	echo '<td class="center">'. $this->Html->link($character['Character']['id'], '/admin/characters/edit/'. $character['Character']['id']) .'</td>';
	echo '<td>'. $this->Html->link($character['Character']['name'], '/admin/characters/edit/'. $character['Character']['id']) .'</td>';
	echo '<td>'. $this->Html->link($character['Type']['name'], '/admin/types/edit/'. $character['Type']['id']) .'</td>';
	echo '<td>'. $this->Html->link($character['User']['username'], '/admin/users/edit/'. $character['User']['id']) .'</td>';
	echo '<td>';
	echo $this->Html->link($this->Html->image('/img/admin/icons/small/pencil.png', array('alt' => 'edit')), '/admin/characters/edit/'. $character['Character']['id'], array('escape' => false));
	echo '&nbsp;';
	echo $this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete')), '/admin/characters/delete/'. $character['Character']['id'], array('escape' => false), __('Delete?', true));
	echo '</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add'), '/admin/characters/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>