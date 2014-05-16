<?php
/**
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
class Inventory extends AppModel {
	var $name = 'Inventory';

	var $belongsTo = array('Item');

	var $actsAs = array('Containable');

	function getBag($bag_id = null) {
		$this->bindModel(array('belongsTo' => array('Item')));
		$this->Item->unbindModelAll();
		$inventories = $this->find('all', array(
			'conditions' => array('Inventory.bag_id' => $bag_id), 'order' => array('Inventory.index ASC'),
			'fields' => array('COUNT(Inventory.index) as count', 'Inventory.*', 'Item.*'),
			'group' => array('Inventory.index', 'Inventory.bag_id')
		));
		return $inventories;
	}

/**
 * Get an array with equiped items. [equip_slot] => array_iteminfo
 *
 * @param int $character_id the ID of the character
 * @param boolean $showStats whenever to get the stats of the items
 * @return array $items list of items
 */
	function getEquipedItems($character_id = null, $showStats = false) {
		$equiped = array();
		$conditions['Inventory.character_id'] = $character_id;
		$conditions['Inventory.equiped <>'] = 'none';
		if($showStats == false) {
			$this->contain(array('Item'));
		}
		else {
			$this->contain(array('Item' => array('Stat')));
		}
		$inventories = $this->find('all', array('conditions' => $conditions));
		foreach($inventories as $inventory) {
			$equiped[$inventory['Inventory']['equiped']] = $inventory['Item'];
		}
		return $equiped;
	}
}
?>