<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php echo __('Maps'); ?></h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Map.id'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Name', 'Map.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Subname', 'Map.subname'); ?></th>
<th><?php echo $this->Paginator->sort('Battle type', 'Map.battle_system'); ?></th>
<th class="options"><?php echo __('Options'); ?></th>
</tr>
<?php
foreach($maps as $map) {
	echo "<tr>";
	echo "<td class=\"center\">". $map['Map']['id'] ."</td>";
	echo "<td>". $this->Html->link($map['Map']['name'], '/admin/maps/edit/'. $map['Map']['id']) ."</td>";
	echo "<td>". $this->Html->link($map['Map']['subname'], '/admin/maps/edit/'. $map['Map']['id']) ."</td>";
	echo "<td>". $this->Html->link($map['Map']['battle_system'], '/admin/maps/edit/'. $map['Map']['id']) ."</td>";
	echo "<td>".
	$this->Html->link($this->Html->image('/img/admin/icons/small/camera.png', array('alt' => 'Generate Screenshot', 'title' => 'Generate Screenshot')), '/admin/maps/generateminimap/'. $map['Map']['id'], array('escape' => false))
	. " ".
	$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/maps/delete/'. $map['Map']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add map', true), '/admin/maps/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>