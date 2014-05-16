<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Texts</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Text.id'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Name', 'Text.name'); ?></th>
<th><?php echo $this->Paginator->sort('Title', 'Text.title'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Page', 'Page.name'); ?></th>
<th class="small center"><?php echo $this->Paginator->sort('Order', 'Text.order'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($texts as $text) {
	echo "<tr>";
	echo "<td class=\"center small\">". $this->Html->link($text['Text']['id'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $this->Html->link($text['Text']['name'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $this->Html->link($text['Text']['title'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $this->Html->link($text['Page']['name'], '/admin/pages/edit/'. $text['Page']['id']) ."</td>";
	echo "<td>". $this->Html->link($text['Text']['order'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>".
	$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete text', 'onclick' => 'return confirm(\'Delete text?\')')), '/admin/texts/delete/'. $text['Text']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="7">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add text', true), '/admin/texts/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>