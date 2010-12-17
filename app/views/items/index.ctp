<?php
/*
 * Created on Apr 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="header_c">
	<h1>What is the Item database?</h1>
	<p>The Item database is a vast searchable database for all the items in Naxasius. The items are straight from the real servers and presented in a user-friendly interface. Items what aren't discovered yet will not be shown.</p>
	<h2>Latest discovered items</h2>
	<p><?php echo $this->Ubb->output('Latest discovered item is [item]'. $lastItem['Item']['name'] .'[/item].'); ?></p>
	<p><i>Item discovered at <?php echo date('Y-m-d H:i', strtotime($lastItem['Item']['discovered'])); ?> by <?php echo $lastItem['Character']['name']; ?>.</i></p>
</div>
<div class="news_c">
<div class="menu_c">
	<div class="menu"><?php echo $html->link(__('Item database', true), '/items', array('class' => 'nostyle')); ?></div>
</div>
<table width="100%" cellspacing="10" cellpadding="0" class="summary">
<tr>
<th width="300"><?php echo $this->Paginator->sort('Item', 'Item.name'); ?></th>
<th><?php echo $this->Paginator->sort('Discovered', 'Character.name'); ?></th>
</tr>
<?php
foreach($items as $index => $item) {
?>
<tr class="content">
<td><?php echo $this->Html->image('/img/game/items/'. $item['Item']['icon']); ?> &nbsp; <span class="item_<?php echo $item['Item']['quality']; ?>" onmouseover="showMouseInfo(url + 'items/view/<?php echo $item['Item']['name']; ?>');" onmouseout="hideMouseInfo();">[<?php echo $item['Item']['name']; ?>]</span></td>
<td><?php echo date('Y-m-d H:i', strtotime($item['Item']['discovered'])); ?> by <?php echo $item['Character']['name']; ?></td>
</tr>
<?php
}
?>
</table>
<p><?php echo $this->Paginator->numbers(); ?></p>
</div>