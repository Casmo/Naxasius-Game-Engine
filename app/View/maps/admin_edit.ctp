<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->create('Map', array('action' => 'admin_edit')); ?>
<h1>Edit map "<?php echo $this->data['Map']['name']; ?>"</h1>
<fieldset>
<legend onclick="$('div#map_detail').toggle();">Map details</legend>
<div id="map_detail" style="display:none;">
<?php echo $this->Form->input('Map.id'); ?>
<?php echo $this->Form->input('Map.name'); ?>
<?php echo $this->Form->input('Map.subname'); ?>
<?php echo $this->Form->input('Map.battle_system', array('options' => array('pve' => 'pve','pvp' => 'pvp','ffa' => 'ffa','faction' => 'faction','guild' => 'guild','race' => 'race'))); ?>
<?php echo $this->Form->input('Map.description', array('class' => 'tinymce')); ?>
</div>
</fieldset>
<fieldset>
<legend>Map</legend>
<?php echo $world->show($areas, $map, array('inGame' => false, 'showTitle' => false)); ?>
</fieldset>
<fieldset>
<legend>Magic wand tool</legend>
<div class="wand_area" id="wand_area">&nbsp;</div>
<select name="access" id="access">
<option value="1">yes</option>
<option value="0">no</option>
</select>
<?php echo $this->Html->image('/img/admin/icons/small/wand.png', array('id' => 'magic_wand')); ?>
</fieldset>
<fieldset>
<legend>Options</legend>
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/arrow-180.png', array('alt' => 'arrow-left')) .' '. __('Add areas to the left'), '/admin/areas/add/'. $map['Map']['id'] .'/left', array('escape' => false)); ?><br />
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/arrow-090.png', array('alt' => 'arrow-top')) .' '. __('Add areas at the top'), '/admin/areas/add/'. $map['Map']['id'] .'/top', array('escape' => false)); ?><br />
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/arrow.png', array('alt' => 'arrow-right')) .' '. __('Add areas to the right'), '/admin/areas/add/'. $map['Map']['id'] .'/right', array('escape' => false)); ?><br />
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/arrow-270.png', array('alt' => 'arrow-bottom')) .' '. __('Add areas at the bottom'), '/admin/areas/add/'. $map['Map']['id'] .'/bottom', array('escape' => false)); ?>
</fieldset>
<?php echo $this->Form->end(array('label' => 'Save', 'div' => false)); ?>