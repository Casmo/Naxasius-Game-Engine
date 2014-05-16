<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Sheets</h1>
<?php
echo $this->Form->create('Sheet', array('action' => 'delete'));
?>
<table class="summary">
<tr>
<th class="center small">&nbsp;</th>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Sheet.id'); ?></th>
<th><?php echo $this->Paginator->sort('Name', 'Sheet.name'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('type', 'Sheet.type'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($sheets as $sheet) {
	echo '<tr>';
	echo '<td class="center"><input type="checkbox" name="data[Sheet][id][]" value="'. $sheet['Sheet']['id'] .'"></td>';
	echo '<td class="center">'. $this->Html->link($sheet['Sheet']['id'], '/admin/sheets/edit/'. $sheet['Sheet']['id']) .'</td>';
	echo '<td>'. $this->Html->link($sheet['Sheet']['name'], '/admin/sheets/edit/'. $sheet['Sheet']['id']) .'</td>';
	echo '<td>'. $sheet['Sheet']['type'] .'</td>';
	echo '<td>';
	echo $this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/sheets/delete/'. $sheet['Sheet']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="6">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/sheets/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>
<?php
echo $this->Form->end(array('label' => 'delete selected', 'class' => 'delete'));
?>