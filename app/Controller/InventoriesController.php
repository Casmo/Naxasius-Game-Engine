<?php
/**
 * Inventory
 *
 * Shows an Inventory of a player
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
class InventoriesController extends AppController {
	var $name = 'Inventories';

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '' && isset($this->characterInfo) && !empty($this->characterInfo)) {
			$this->Auth->allow('index');
		}
	}

	function index() {
		$this->Inventory->bindModel(array('belongsTo' => array('Item')));
		$items = $this->Inventory->find('all', array('conditions' => array('Inventory.character_id' => $this->Session->read('character.Character.id'))));
		$this->set('items', $items);
	}
}
?>