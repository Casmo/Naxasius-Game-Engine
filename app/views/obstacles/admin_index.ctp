<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
$paginator->options(array('url' => $filters));
?>
<?php echo $this->Form->create('Obstacle', array('action' => 'admin_index')); ?>
<div class="filters">
<?php echo $this->Form->input('Group.id', array('options' => $groups, 'empty' => array(0 => __('Select group', true)), 'label' => false, 'div' => false)); ?>
<?php echo $this->Form->end(array('label' => __('Apply filter', true), 'class' => 'blue', 'div' => false)); ?>
</div>
<h1>Obstacles</h1>
<?php
echo $form->create('Obstacle', array('action' => 'delete'));
?>
<table class="summary">
<tr>
<th class="center small">&nbsp;</th>
<th class="center small"><?php echo $paginator->sort('#', 'Obstacle.id'); ?></th>
<th class="center small">Image</th>
<th><?php echo $paginator->sort('Name', 'Obstacle.name'); ?></th>
<th class="medium"><?php echo $paginator->sort('Group', 'Group.name'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($obstacles as $obstacle) {
	echo '<tr>';
	echo '<td class="center"><input type="checkbox" name="data[Obstacle][id][]" value="'. $obstacle['Obstacle']['id'] .'"></td>';
	echo '<td class="center">'. $html->link($obstacle['Obstacle']['id'], '/admin/obstacles/edit/'. $obstacle['Obstacle']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/game/obstacles/'. $obstacle['Obstacle']['image']), '/admin/obstacles/edit/'. $obstacle['Obstacle']['id'], array('escape' => false)) .'</td>';
	echo '<td>'. $html->link($obstacle['Obstacle']['name'], '/admin/obstacles/edit/'. $obstacle['Obstacle']['id']) .'</td>';
	echo '<td>'. $html->link($obstacle['Group']['name'], '/admin/groups/edit/'. $obstacle['Group']['id']) .'</td>';
	echo '<td>';
	echo $obstacle['Obstacle']['doubles'] > 1 ? $html->link($html->image('/img/admin/icons/small/image-blur.png', array('alt' => 'merge', 'onclick' => 'return confirm(\'Merge '. $obstacle['Obstacle']['doubles'] .' obstacles?\')')), '/admin/obstacles/merge/'. $obstacle['Obstacle']['id'], array('escape' => false)) .' ' : '';
	echo $html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/obstacles/delete/'. $obstacle['Obstacle']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="6">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/obstacles/add', array('escape' => false)); ?>
&nbsp;
<?php echo $this->Html->link($html->image('/img/admin/icons/small/image-import.png', array('alt' => 'import', 'class' => 'icon')). ' Import', '/admin/obstacles/import', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>
<?php
echo $form->end(array('label' => 'delete selected', 'class' => 'delete'));
?>