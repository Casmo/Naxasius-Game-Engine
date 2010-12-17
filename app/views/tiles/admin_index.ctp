<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
$this->Paginator->options(array('url' => $filters));
?>
<?php echo $this->Form->create('Tile', array('action' => 'admin_index')); ?>
<div class="filters">
<?php echo $this->Form->input('Group.id', array('options' => $groups, 'empty' => array(0 => __('Select group', true)), 'label' => false, 'div' => false)); ?>
<?php echo $this->Form->end(array('label' => __('Apply filter', true), 'class' => 'blue', 'div' => false)); ?>
</div>
<?php
echo $form->create('Tile', array('action' => 'delete'));
?>
<h1>Tiles</h1>
<table class="summary">
<tr>
<th class="center small">&nbsp;</th>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Tile.id'); ?></th>
<th class="center small">Image</th>
<th><?php echo $this->Paginator->sort('Name', 'Tile.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Group', 'Group.name'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>

<?php
foreach($tiles as $tile) {
		echo '<tr>';
		echo '<td><input type="checkbox" name="data[Tile][id][]" value="'. $tile['Tile']['id'] .'"></td>';
		echo '<td class="center">'. $this->Html->link($tile['Tile']['id'], '/admin/tiles/edit/'. $tile['Tile']['id']) .'</td>';
		echo '<td class="center">'. $this->Html->link($html->image('/img/game/tiles/'. $tile['Tile']['image']), '/admin/tiles/edit/'. $tile['Tile']['id'], array('escape' => false)) .'</td>';
		echo '<td>'.  $this->Html->link($tile['Tile']['name'], '/admin/tiles/edit/'. $tile['Tile']['id']) .'</td>';
		echo '<td>'.  $this->Html->link($tile['Group']['name'], '/admin/groups/edit/'. $tile['Group']['id']) .'</td>';
		echo '<td>';
		echo $tile['Tile']['doubles'] > 1 ? $html->link($html->image('/img/admin/icons/small/image-blur.png', array('onclick' => 'return confirm(\'Merge '. $tile['Tile']['doubles'] .' tiles?\')')), '/admin/tiles/merge/'. $tile['Tile']['id'], array('escape' => false)) .' ' : '';
		echo $this->Html->link($html->image('/img/admin/icons/small/minus-button.png', array('onclick' => 'return confirm(\'Delete this tile?\')')), '/admin/tiles/delete/'. $tile['Tile']['id'], array('escape' => false));
		echo '</td>';
		echo '</tr>';
}
?>

<tfoot>
<tr><td colspan="6">
<?php echo $this->Html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' Add', '/admin/tiles/add', array('escape' => false)); ?>
&nbsp;
<?php echo $this->Html->link($html->image('/img/admin/icons/small/image-import.png', array('alt' => 'import', 'class' => 'icon')). ' Import', '/admin/tiles/import', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>
<?php
echo $form->end(array('label' => 'delete selected', 'class' => 'delete'));
?>