<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Groups</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Grup.id'); ?></th>
<th><?php echo $this->Paginator->sort('Name', 'Group.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Type', 'Group.type'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($groups as $group) {
	echo '<tr>';
	echo '<td class="center">'. $this->Html->link($group['Group']['id'], '/admin/groups/edit/'. $group['Group']['id']) .'</td>';
	echo '<td>'. $this->Html->link($group['Group']['name'], '/admin/groups/edit/'. $group['Group']['id']) .'</td>';
	echo '<td>'. $group['Group']['type'] .'</td>';
	echo '<td>'. $this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/groups/delete/'. $group['Group']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="6">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add'), '/admin/groups/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>