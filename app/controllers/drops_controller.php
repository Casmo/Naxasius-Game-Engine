<?php
/**
 * Drop system
 *
 * Dropping and looting Items from an Obstacle in a Area
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
class DropsController extends AppController {
	var $name = 'Drops';

	var $uses = array('AreasObstacle', 'Drop');

/**
 * This is an unique obstacle in a area. We will check if here is any drops for the character...
 * Moved to areas_obstacles -> view
 */
	function game_view($area_obstacle_id = null) {
		$drops = array();
		if(isset($area_obstacle_id) && !empty($area_obstacle_id)) {
			// Let's find if the user can loot something here...
			$drops = $this->Drop->get($this->Session->read('Game.Character'), $area_obstacle_id);
		}
		$this->set('drops', $drops);
		$this->set('area_obstacle_id', $area_obstacle_id);
	}

/**
 * Loot an item. echo 1 or 0 on succes.
 */
	function game_loot($areas_obstacles_item_id = null) {
		Configure::write('debug', 0);
		if($this->Drop->loot($this->Session->read('Game.Character'), $areas_obstacles_item_id)) {
			echo '1';exit;
		}
		else {
			echo '0';exit;
		}
	}

/**
 * (Admin) add a drop to a `area_obstacle`.`id`
 */
	function admin_edit($areaobstacle_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$this->AreasObstacle->bindModel(array('hasOne' => array('AreasObstaclesItem')));
			$this->AreasObstacle->AreasObstaclesItem->deleteAll(array('areas_obstacle_id' => $this->data['areaobstacle_id']));
			$savedata = array();
			foreach($this->data['AreasObstaclesItem'] as $data) {
				if($data['check'] == 1) {
					$data['areas_obstacle_id'] = $this->data['areaobstacle_id'];
					$savedata[] = $data;
				}
			}
			$this->AreasObstacle->bindModel(array('hasMany' => array('AreasObstaclesItem')));
			$this->AreasObstacle->AreasObstaclesItem->saveAll($savedata);

		}
		else {
			$this->AreasObstacle->bindModel(array('hasAndBelongsToMany' => array('Item')));
			$drops = $this->AreasObstacle->find('first', array('conditions' => array('AreasObstacle.id' => $areaobstacle_id)));
			$this->data = $drops;
			// Get all the items
			$this->AreasObstacle->bindModel(array('hasAndBelongsToMany' => array('Item')));
			$items = $this->AreasObstacle->Item->find('list');
			$this->set('items', $items);
			$this->set('areaobstacle_id', $areaobstacle_id);
			App::import('Model', 'Quest');
			$Quest = new Quest();
			$quests = array_merge(array(0 => ''));
			$someQuests = $Quest->find('all', array('fields' => array('Quest.id', 'Quest.name')));
			foreach($someQuests as $index => $quest) {
				$quests[$quest['Quest']['id']] = $quest['Quest']['name'];
			}
			$this->set('quests', $quests);
		}
	}
}
?>