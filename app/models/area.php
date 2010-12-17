<?php
/**
 * Area
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
class Area extends AppModel {
	var $name = 'Area';

	var $belongsTo = array('Tile', 'Map');
	var $hasAndBelongsToMany = array(
		'Npc',
		'Obstacle',
		'Mob' => array(
			'conditions' => array(
				'or' => array(
					'and' => array(
						'AreasMob.last_killed < DATE_ADD(NOW(), INTERVAL -`AreasMob`.`spawn_time` SECOND)',
						'AreasMob.player_only' => '0'
					),
					'AreasMob.player_only' => '1'
				)
			)
		)
	);
	var $hasMany = array('AreasMob', 'AreasObstacle'); // TODO fix bug why AreasMob must be first...

	var $actsAs = array('Containable');


/**
 * Get actions for a specific area
 *
 * @param int $character_id the ID of the character
 * @param int $area_id the ID of the current location of the character
 * @return array a list of available actions
 */
	function getActions($character_id = null, $area_id = null) {
		if(!isset($area_id) || !isset($character_id)) {
			return array();
		}
		$actions = array();

		App::import('Model', 'Drop');
		$Drop = new Drop();

		App::import('Model', 'Quest');
		$Quest = new Quest();

		$this->contain(
			array(
				'AreasObstacle' => array(
					'Item',
					'Quest'
				),
				'Npc',
				'AreasMob' => array(
					'Mob'
				)
			)
		);
		$areaInfo = $this->find('first', array('conditions' => array('Area.id' => $area_id)));

		if($areaInfo['Area']['travel_to'] != 0) {
			if($this->canMove($area_id, $areaInfo['Area']['travel_to'], $character_id)) {
				$areaTo = $this->find('first', array('conditions' => array('Area.id' => $areaInfo['Area']['travel_to'])));
				$actions[] = array('type' => 'Area', 'data' => $areaTo);
			}
		}
		// Doorlopen van de Obstacles, en kijken of er iets te halen valt...
		foreach($areaInfo['AreasObstacle'] as $index => $obstacle) {
			// Looting items
			if(!empty($obstacle['Item'])) {
				foreach($obstacle['Item'] as $item) {
					if($Drop->canLoot($item['AreasObstaclesItem']['id'], $character_id, $area_id)) {
						$actions[] = array('type' => 'Item', 'data' => $item);
					}
				}
			}
			// Quest inleveren of ophalen
			if(!empty($obstacle['Quest'])) {
				foreach($obstacle['Quest'] as $quest) {
					if($Quest->canView($character_id, $quest['id'], $quest['ActionsObstacle']['type'])) {
						$actions[] = array('type' => 'Quest', 'data' => $quest);
					}
				}
			}
		}

		// Talking to npcs
		if(!empty($areaInfo['Npc'])) {
			foreach($areaInfo['Npc'] as $npc) {
				$actions[] = array('type' => 'Npc', 'data' => $npc);
			}
		}
		// Killing mobs
		if(!empty($areaInfo['AreasMob'])) {
			foreach($areaInfo['AreasMob'] as $index => $mob) {

				if($this->AreasMob->canAttack($mob['id'], $character_id, $area_id)) {
					$actions[] = array('type' => 'Mob', 'data' => $mob);
				}
			}
		}
		return $actions;
	}
/**
 * Check of a character can move from one area to the other
 *
 * @param int $area_id_from the ID of the current area
 * @param int $area_id_to the ID of the area where the character wanna go
 * @param int @character_id the current character ID
 * @return boolean whenever the character can move or not
 */
	function canMove($area_id_from = null, $area_id_to = null, $character_id = null) {
		$this->contain();
		$areaFrom = $this->find('first', array('conditions' => array('Area.id' => $area_id_from)));
		$areaTo = $this->find('first', array('conditions' => array('Area.id' => $area_id_to)));
		if($areaFrom['Area']['travel_to_quest_id'] != 0) {
			App::import('Model', 'CharactersQuest');
			$CharactersQuest = new CharactersQuest();
			$someQuest = $CharactersQuest->find('first', array('conditions' => array('CharactersQuest.quest_id' => $areaFrom['Area']['travel_to_quest_id'], 'CharactersQuest.character_id' => $character_id, 'CharactersQuest.completed' => 'finished')));
			if(empty($someQuest)) {
				return false;
			}
		}
		return true;
	}
}
?>