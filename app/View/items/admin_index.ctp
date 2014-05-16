<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Items</h1>

<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Item.id'); ?></th>
<th class="center small">Image</th>
<th><?php echo $this->Paginator->sort('Name', 'Item.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Group', 'Group.name'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($items as $item) {
	echo '<tr>';
	echo '<td class="center">'. $this->Html->link($item['Item']['id'], '/admin/items/edit/'. $item['Item']['id']) .'</td>';
	echo '<td>'. $this->Html->link($this->Html->image('/img/game/items/'. $item['Item']['image']), '/admin/items/edit/'. $item['Item']['id'], array('escape' => false)) .'</td>';
	echo '<td>'. $this->Html->link($item['Item']['name'], '/admin/items/edit/'. $item['Item']['id']) .'</td>';
	echo '<td>'. $this->Html->link($item['Group']['name'], '/admin/group/edit/'. $item['Group']['id']) .'</td>';
	echo '<td>'. $this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/items/delete/'. $item['Item']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add'), '/admin/items/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>