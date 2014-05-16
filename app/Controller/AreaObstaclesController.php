<?php
/**
 * Area-Obstacle Controller
 *
 * This file is used for modifying Obstacles on an Area and displaying them in the game
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
class AreasObstaclesController extends AppController {
	var $name = 'AreasObstacles';

	var $helpers = array('Form', 'Html');

	var $uses = array('AreasObstacle', 'Group');

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '' && isset($this->characterInfo) && !empty($this->characterInfo)) {
			$this->Auth->allow('view');
		}
	}

	/**
	 * This is an unique obstacle in a area. We will check if here is any drops for the character...
	 */
	function view($id = null) {
		if(isset($id) && !empty($id)) {
			$AreasObstacle = $this->AreasObstacle->find('first', array('conditions' => array('AreasObstacle.id' => $id)));

			// Kijken of deze items geloot mogen worden...
			App::import('Model', 'Drop');
			$Drop = new Drop();
			foreach($AreasObstacle['Item'] as $index => $item) {
				if(!$Drop->canLoot($this->characterInfo, $item['AreasObstaclesItem']['id'])) {
					unset($AreasObstacle['Item'][$index]);
				}
			}
			// Kijken voor questen om in te leveren
			App::import('Model', 'Quest');
			$Quest = new Quest();
			foreach($AreasObstacle['Quest'] as $index => $quest) {
				if(!$Quest->canView($this->characterInfo['Character']['id'], $quest['id'], $quest['ActionsObstacle']['type'])) {
					unset($AreasObstacle['Quest'][$index]);
				}
			}
			$this->set('AreasObstacle', $AreasObstacle);
		}
		else {
			$this->render(false);
		}

	}


	function admin_edit_area($area_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			#$this->AreasObstacle->deleteAll(array('area_id' => $this->request->data['Area']['id']));
			$savedObstacles = array();
			foreach($this->request->data['Obstacle'] as $obstacle) {

				if(isset($obstacle['id']) && $obstacle['id'] != '0' || $obstacle['id'] == 'add') {
					// Checkbox is selected
					if($obstacle['id'] == 'add') {
						unset($obstacle['id']); // insert.
					}
					$savedObstacles[] = $obstacle;
				}
				else {
					$this->AreasObstacle->delete($obstacle['delete_id']);
					$this->AreasObstacle->AreasObstaclesItem->deleteAll(array('areas_obstacle_id' => $obstacle['delete_id']));
				}
			}
			$this->AreasObstacle->saveAll($savedObstacles);
			$this->render(false);
		}
		else {

			$someObstacles = $this->AreasObstacle->find('all', array('conditions' => array('AreasObstacle.area_id' => $area_id)));
			$selectedObstacles = array();
			$obstaclesIds = array();
			foreach($someObstacles as $obstacle) {
				$obstacle['AreasObstacle']['image'] = $obstacle['Obstacle']['image'];
				$selectedObstacles[] = $obstacle['AreasObstacle'];
				$obstaclesIds[] = $obstacle['AreasObstacle']['obstacle_id'];
			}

			#$this->Group->bindModel(array('hasMany' => array('Obstacle' => array('conditions' => array('Obstacle.id' => $obstaclesIds)))));
			$groups = $this->Group->find('all');

			$this->set('selectedObstacles', $selectedObstacles);
			$this->set('area_id', $area_id);
			$this->set('groups', $groups);
		}
	}
}
?>
