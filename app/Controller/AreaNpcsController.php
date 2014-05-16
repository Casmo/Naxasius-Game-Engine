<?php
/**
 * Area-Npc Controller
 *
 * This file is used for modifying NPCs on an Area
 *
 * Naxasius : a CakePHP powered Game Engine to create a MMORPG (http://www.naxasius.com)
 * Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 *
 * Licensed under Creative Commons 3.0
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 * @link		http://www.naxasius.com Game Engine to create a Browser MMORPG
 * @author		Mathieu (mathieu@fellicht.nl)
 * @license		Creative Commons 3.0 (http://creativecommons.org/licenses/by/3.0/)
 */
class AreasNpcsController extends AppController {
	var $name = 'AreasNpcs';

	var $uses = array('AreasNpc', 'Npc');

	var $helpers = array('Form');

	function admin_edit_area($area_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			foreach($this->request->data['Npc'] as $npc) {
				if(isset($npc['id'])) {
					// Checkbox is selected
					$npc['npc_id'] = $npc['id'];
					$npc['id'] = $npc['unique_id'];
					// Let's check if there may be an image...
					if(empty($npc['image']['name'])) {
						unset($npc['image']);
					}
					else {
						$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $npc['image']['name']);
						$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
						move_uploaded_file($npc['image']['tmp_name'], WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS .'map'. DS . $imageName);
						$npc['image'] = $imageName;

					}
					$this->AreasNpc->save($npc);
				}
				else {
					$someNpc = $this->AreasNpc->find('first', array('conditions' => array('area_id' => $npc['area_id'], 'npc_id' => $npc['npc_id'])));

					// Remove old image
					if(isset($someNpc['AreasNpc']['image']) && !empty($someNpc['AreasNpc']['image'])) {
						@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . 'map' . DS .  $someNpc['AreasNpc']['image']);
					}
					$this->AreasNpc->deleteAll(array('area_id' => $npc['area_id'], 'npc_id' => $npc['npc_id']));
				}
			}
			$this->render(false);
		}
		else {
			$someNpcs = $this->AreasNpc->find('all', array('conditions' => array('AreasNpc.area_id' => $area_id)));
			$selectedNpcs = array();
			foreach($someNpcs as $npc) {
				$selectedNpcs[$npc['AreasNpc']['npc_id']] = $npc['AreasNpc'];
			}
			$allNpcs = $this->Npc->find('all');
			$this->set('selectedNpcs', $selectedNpcs);
			$this->set('npcs', $allNpcs);
			$this->set('area_id', $area_id);
		}
	}
}
?>