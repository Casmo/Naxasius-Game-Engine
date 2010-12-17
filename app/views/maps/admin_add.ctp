<?php
/*
 * Created on Nov 18, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
echo '<h1>'. __('Add map', true) .'</h1>';
echo $form->create('Map', array('action' => 'add'));
echo $form->input('Map.name');
echo $form->input('Map.subname');
echo $form->input('Map.battle_system', array('options' => array('pve' => 'pve','pvp' => 'pvp','ffa' => 'ffa','faction' => 'faction','guild' => 'guild','race' => 'race')));
echo $form->end('Save');
?>