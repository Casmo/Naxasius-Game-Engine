<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $form->create('Map', array('action' => 'admin_edit')); ?>
<h1>Edit map "<?php echo $this->data['Map']['name']; ?>"</h1>
<fieldset>
<legend onclick="$('div#map_detail').toggle();">Map details</legend>
<div id="map_detail" style="display:none;">
<?php echo $form->input('Map.id'); ?>
<?php echo $form->input('Map.name'); ?>
<?php echo $form->input('Map.subname'); ?>
<?php echo $form->input('Map.battle_system', array('options' => array('pve' => 'pve','pvp' => 'pvp','ffa' => 'ffa','faction' => 'faction','guild' => 'guild','race' => 'race'))); ?>
<?php echo $form->input('Map.description', array('class' => 'tinymce')); ?>
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
<?php echo $html->image('/img/admin/icons/small/wand.png', array('id' => 'magic_wand')); ?>
</fieldset>
<fieldset>
<legend>Options</legend>
<?php echo $html->link($html->image('/img/admin/icons/small/arrow-180.png', array('alt' => 'arrow-left')) .' '. __('Add areas to the left', true), '/admin/areas/add/'. $map['Map']['id'] .'/left', array('escape' => false)); ?><br />
<?php echo $html->link($html->image('/img/admin/icons/small/arrow-090.png', array('alt' => 'arrow-top')) .' '. __('Add areas at the top', true), '/admin/areas/add/'. $map['Map']['id'] .'/top', array('escape' => false)); ?><br />
<?php echo $html->link($html->image('/img/admin/icons/small/arrow.png', array('alt' => 'arrow-right')) .' '. __('Add areas to the right', true), '/admin/areas/add/'. $map['Map']['id'] .'/right', array('escape' => false)); ?><br />
<?php echo $html->link($html->image('/img/admin/icons/small/arrow-270.png', array('alt' => 'arrow-bottom')) .' '. __('Add areas at the bottom', true), '/admin/areas/add/'. $map['Map']['id'] .'/bottom', array('escape' => false)); ?>
</fieldset>
<?php echo $form->end(array('label' => 'Save', 'div' => false)); ?>