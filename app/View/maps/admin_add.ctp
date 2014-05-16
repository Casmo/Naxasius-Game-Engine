<?php
/*
 * Created on Nov 18, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
echo '<h1>'.__('Add map') .'</h1>';
echo $this->Form->create('Map', array('action' => 'add'));
echo $this->Form->input('Map.name');
echo $this->Form->input('Map.subname');
echo $this->Form->input('Map.battle_system', array('options' => array('pve' => 'pve','pvp' => 'pvp','ffa' => 'ffa','faction' => 'faction','guild' => 'guild','race' => 'race')));
echo $this->Form->end('Save');
?>