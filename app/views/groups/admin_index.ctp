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
<th class="center small"><?php echo $paginator->sort('#', 'Grup.id'); ?></th>
<th><?php echo $paginator->sort('Name', 'Group.name'); ?></th>
<th class="medium"><?php echo $paginator->sort('Type', 'Group.type'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($groups as $group) {
	echo '<tr>';
	echo '<td class="center">'. $html->link($group['Group']['id'], '/admin/groups/edit/'. $group['Group']['id']) .'</td>';
	echo '<td>'. $html->link($group['Group']['name'], '/admin/groups/edit/'. $group['Group']['id']) .'</td>';
	echo '<td>'. $group['Group']['type'] .'</td>';
	echo '<td>'. $html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/groups/delete/'. $group['Group']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="6">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/groups/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>