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
class Drop extends AppModel {
	var $name = 'Drop';

	var $actsAs = array('Containable');

	//var $belongsTo = array('Quest');
	//var $useTable = false;

/**
 * Get an array of droppable items (from a area-obstacle or mob)
 * @return array with items
 */
	function get($characterInfo = array(), $area_obstacle_id = null) {
		$drops = array();
		$conditions = array();

		// step 1. Get all the loot from this area-obstacle
		App::import('Model', 'AreasObstaclesItem');
		$AreasObstaclesItem = new AreasObstaclesItem();
		$AreasObstaclesItem->bindModel(array('belongsTo' => array('Item')));
		$someDrops = $AreasObstaclesItem->find('all', array('conditions' => array('AreasObstaclesItem.areas_obstacle_id' => $area_obstacle_id)));
		// step 2. Loop through drops and check if we can loot it...
		foreach($someDrops as $drop) {
			if($this->canLoot($drop['AreasObstaclesItem']['id'], $characterInfo['id'], $characterInfo['area_id'])) {
				$drop['Item']['areas_obstacles_item_id'] = $drop['AreasObstaclesItem']['id'];
				$drops[] = $drop['Item'];
			}
		}
		return $drops;
	}

/**
 * Looting an Item from an Obstacle in the game map
 *
 * @param int the id of the character
 * @param int the id of the areas_obstacles_item
 */
	function loot($characterInfo = null, $areas_obstacles_item_id = null) {
		if($this->canLoot($areas_obstacles_item_id, $characterInfo['id'], $characterInfo['area_id'])) {
			// Opslaan die handel
			App::import('Model', 'AreasObstaclesItem');
			$AreasObstaclesItem = new AreasObstaclesItem();
			$drop = $AreasObstaclesItem->find('first', array('conditions' => array('AreasObstaclesItem.id' => $areas_obstacles_item_id)));
			$data['Drop']['areas_obstacle_item_id'] = $drop['AreasObstaclesItem']['id'];
			$data['Drop']['item_id'] = $drop['AreasObstaclesItem']['item_id'];
			$data['Drop']['character_id'] = $characterInfo['id'];
			$dataInventory['Inventory']['item_id'] = $drop['AreasObstaclesItem']['item_id'];
			$dataInventory['Inventory']['character_id'] = $characterInfo['id'];
			if($this->save($data)) {
				// Item opvragen, en eventueel de character_id invullen als deze character de eerste is...
				App::import('Model', 'Item');
				$Item = new Item();
				$Item->unbindModelAll();
				$thisItem = $Item->find('first', array('conditions' => array('Item.id' => $drop['AreasObstaclesItem']['item_id'])));
				if(isset($thisItem['Item']['character_id']) && $thisItem['Item']['character_id'] == 0) {
					$thisItem['Item']['character_id'] = $characterInfo['id'];
					$thisItem['Item']['discovered'] = date('Y-m-d H:i:s');
					$Item->save($thisItem);
				}
				App::import('Model', 'Inventory');
				$Inventory = new Inventory();
				// Bagid en index opvragen
				$bagIndex = $this->hasFreeSpace($characterInfo['id'], $drop['AreasObstaclesItem']['item_id'], true);
				$dataInventory['Inventory']['index'] = $bagIndex['index'];
				$dataInventory['Inventory']['bag_id'] = $bagIndex['bag_id'];
				// Save to inventory
				if($Inventory->save($dataInventory)) {
					App::import('Model', 'Quest');
					$Quest = new Quest();
					$Quest->update(null, $characterInfo['id']);
					// Item is nu in de inventory... We kunnen eventueel questen updaten nu
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

/**
 * Check if a character can loot a item
 *
 * There are a several conditions before an item can be looted.
 * If the field `Item.unique` is greater then 0 the item may not be looted if
 * the character has already the number of `unique` in it's bags. In case of
 * the field `AreasObstaclesItem.max_drop` is greater than 0 the item may not
 * be looted again. If `AreasObstaclesItem.player_only` this last conditions is
 * per Character and not per game. So it is possible to loot an very rarely item
 * witch can be looted X times in a game.
 * There is also a field called `AreasObstaclesItem.spawn_time`. This is the time
 * in seconds between the item can looted. If `AreasObstaclesItem.player_only` is
 * set to 1 this only counts for the player.
 * If the character doesn't have enough space in it's back the item cannot be
 * loaded aswell.
 * An item can only be looted if the character is at the same location of the item.
 * Some items can only be looted if the character is on a quest (and not completed).
 *
 * @param int $character_id the current character ID
 * @param int $areas_obstacles_item_id the ID of the Area_Obstacle_Item @see `areas_obstacles_items`
 * @param int $area_id the current area of the character
 * @return boolean whenever the character can loot or not
 */
	function canLoot($areas_obstacles_item_id = null, $character_id = null, $area_id = null) {
		if(!isset($character_id) || !isset($areas_obstacles_item_id)) {
			return false;
		}
		$conditions = array();
		$conditions['Drop.character_id'] = $character_id;
		App::import('Model', 'AreasObstaclesItem');
		$AreasObstaclesItem = new AreasObstaclesItem();
		$AreasObstaclesItem->contain(array('AreasObstacle'));
		$drop = $AreasObstaclesItem->find('first', array('conditions' => array('AreasObstaclesItem.id' => $areas_obstacles_item_id)));

		if($drop['AreasObstacle']['area_id'] != $area_id) {
			return false;
		}
		if($drop['AreasObstaclesItem']['quest_id'] != 0) {
			App::import('Model', 'CharactersQuest');
			$CharactersQuest = new CharactersQuest();
			$hasQuest = $CharactersQuest->find('first', array(
					'conditions' => array(
						'CharactersQuest.character_id' => $character_id,
						'CharactersQuest.quest_id' => $drop['AreasObstaclesItem']['quest_id'],
						'CharactersQuest.completed' => 'no'
					)
				)
			);
			if(empty($hasQuest)) {
				return false;
			}
		}
		if(isset($drop['AreasObstaclesItem']['item_id'])) {
			$conditions['Drop.item_id'] = $drop['AreasObstaclesItem']['item_id'];
		}
		$allDrops = $this->find('count', array('conditions' => array(
					'Drop.character_id' => $character_id,
					'Drop.item_id' => $drop['AreasObstaclesItem']['item_id'],
					'Drop.areas_obstacle_item_id' => $drop['AreasObstaclesItem']['id']
				)));

		App::import('Model', 'Inventory');
		$Inventory = new Inventory();
		$Inventory->contain();
		$hasAmount = $Inventory->find(
			'count', array(
				'conditions' => array(
					'Inventory.character_id' => $character_id,
					'Inventory.item_id' => $drop['AreasObstaclesItem']['item_id']
				)
			)
		);
		if(isset($drop['AreasObstaclesItem']['max_drop']) && $drop['AreasObstaclesItem']['max_drop'] > 0) {
			if($allDrops >= $drop['AreasObstaclesItem']['max_drop'] && $hasAmount >= $drop['AreasObstaclesItem']['max_drop']) {
				return false;
			}
		}

		if(isset($drop['AreasObstaclesItem']['spawn_time']) && $drop['AreasObstaclesItem']['spawn_time'] > 0) {
			$conditions['Drop.created >'] = date('Y-m-d H:i:s', strtotime("-". $drop['AreasObstaclesItem']['spawn_time'] ." seconds"));
		}
		$conditions['Drop.areas_obstacle_item_id'] = $drop['AreasObstaclesItem']['id'];
		$someDrops = $this->find('first', array('conditions' => $conditions));

		if(!$this->hasFreeSpace($character_id, $drop['AreasObstaclesItem']['item_id'])) {
			return false;
		}

		if(empty($someDrops)) {
			return true;
		}
		else {
			if($hasAmount < $drop['AreasObstaclesItem']['max_drop']) {
				return true;
			}
			else {
				return false;
			}
		}
	}

/**
 * Calculates the free space of a character. If the item can stack
 * to another item it will be allowed to loot.
 * @todo set this place somewhere else. E.g. bag.
 *
 * @param int $character_id the ID of the current character
 * @param int $item_id the ID of the lootable item
 * @param boolean $returnBagIndex set true to return an array with a `bag_id` and `index`
 * @return array|boolean if there is not space left it returns a false. @see $returnBagIndex for array
 */
	function hasFreeSpace($character_id = null, $item_id = null, $returnBagIndex = false) {
		App::import('Model', 'Bag');
		$Bag = new Bag();
		$Bag->unbindModelAll();
		$Bag->bindModel(array('belongsTo' => array('Item')));
		$Bag->Item->unbindModelAll();
		$Bag->Item->bindModel(array('hasAndBelongsToMany' => array('Stat')));
		$Bag->recursive = 2;
		$bags = $Bag->find('all', array('conditions' => array('Bag.character_id' => $character_id)));
		$total_slots = 0;
		$total_slots_filled = 0;
		$bag_ids = array();

		$firstBagIndex = array();
		$bag_counts = array();
		$bag_indexes = array();
		foreach($bags as $bag) {
			$bag_ids[] = $bag['Bag']['id'];
			$total_slots += $bag['Item']['StatNamed']['slots'];
			$bag_counts[$bag['Bag']['id']] = $bag['Item']['StatNamed']['slots'];
		}
		App::import('Model', 'Inventory');
		$Inventory = new Inventory();
		$inventories = $Inventory->getBag($bag_ids);
		foreach($inventories as $inventory) {
			if($inventory['Item']['id'] == $item_id && $inventory['Item']['stackable'] > $inventory[0]['count']) {
				if($returnBagIndex == true) {
					return array('bag_id' => $inventory['Inventory']['bag_id'], 'index' => $inventory['Inventory']['index']);
				}
				else {
					return true;
				}
			}
			$bag_indexes[$inventory['Inventory']['bag_id']][$inventory['Inventory']['index']] = 1;
			$total_slots_filled++;
		}
		if($total_slots_filled < $total_slots) {
			if($returnBagIndex == true) {
				foreach($bag_counts as $bag_id => $count) {
					if($count > 0) {
						asort($bag_indexes);
						$last_index = 0;
						for($i = 1; $i <= $bag_counts[$bag_id]; $i++) {
							if(!isset($bag_indexes[$bag_id][$i])) {
								$firstBagIndex = array('bag_id' => $bag_id, 'index' => $i);
								break 2;
							}
						}
					}
				}
				$firstBagIndex['bag_id'] = !isset($firstBagIndex['bag_id']) || $firstBagIndex['bag_id'] == 0 ? $bag_ids[0] : $firstBagIndex['bag_id'];
				$firstBagIndex['index'] = !isset($firstBagIndex['index']) || $firstBagIndex['index'] == 0 ? 1 : $firstBagIndex['index'];
				return $firstBagIndex;
			}
			else {
				return true;
			}
		}
		return false;
	}
}
?>