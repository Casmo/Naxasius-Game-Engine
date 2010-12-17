<?php
/**
 * Area-Obstacle-Item Controller
 *
 * This file is used for displaying Items of a specific Obstacle in an Area
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
class AreasObstaclesItemsController extends AppController {
	var $name = 'AreasObstaclesItems';

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '' && isset($this->characterInfo) && !empty($this->characterInfo)) {
			$this->Auth->allow('action');
		}
	}

	function game_action($id = null) {
		$this->helpers[] = 'Ubb';
		$this->loadModel('Drop');
		if($this->Drop->canLoot($id, $this->characterInfo['id'], $this->characterInfo['area_id'])) {
			$this->AreasObstaclesItem->contain('Item');
			$itemDetail = $this->AreasObstaclesItem->find('first', array('conditions' => array('AreasObstaclesItem.id' => $id)));
			$this->set('item', $itemDetail);
		}
		else {
			$this->render('/pages/view/notfound');
		}
	}
}
?>