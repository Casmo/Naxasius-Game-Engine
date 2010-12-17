<?php
/**
 * Manage your Inventory
 *
 * This file is used to manage your Items in your Inventory (Bags)
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
class BagsController extends AppController {
	var $name = 'Bags';

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '' && isset($this->characterInfo) && !empty($this->characterInfo)) {
			$this->Auth->allow('index','view', 'change');
		}
	}

	function game_index() {
		$bags = $this->Bag->find('all', array('conditions' => array('Bag.character_id' => $this->characterInfo['id']), 'order' => array('Bag.index ASC')));
		$this->set('bags', $bags);
	}

	function game_view($id = null) {
		if(!isset($id)) {
			$this->render('/pages/view/notfound');
			exit;
		}
		$this->Bag->recursive = 2;
		$this->Bag->Item->unbindModel(array('belongsTo' => array('Group')));
		$bag = $this->Bag->find('first', array('conditions' => array('Bag.character_id' => $this->characterInfo['id'], 'Bag.id' => $id)));
		if(empty($bag)) {
			$this->render('/pages/view/notfound');
			exit;
		}
		App::import('Model', 'Inventory');
		$Inventory = new Inventory();
		$inventories = $Inventory->getBag($bag['Bag']['id']);
		$new_inventories = array();
		foreach($inventories as $inv) {
			$new_inventories[$inv['Inventory']['index']] = $inv;
		}
		$this->set('inventories', $new_inventories);
		$this->set('bag', $bag);
	}

/**
 * Moving an Item from one spot to the other in a Bag
 */
	function game_change($from_bag_id = null, $from_bag_index = null, $to_bag_id = null, $to_bag_index = null) {
		$this->render(false);

		App::import('Model', 'Inventory');
		$Inventory = new Inventory();
		$Inventory->unbindModelAll();
		$fromInventory = $Inventory->find('first', array('conditions' => array(
			'Inventory.character_id' => $this->characterInfo['id'],
			'Inventory.bag_id' => $from_bag_id,
			'Inventory.index' => $from_bag_index
			)));
		if(!empty($fromInventory)) {
			// KLijken of het vakje leeg is waar we heen gaan
			$toInventory = $Inventory->find('first', array('conditions' => array(
				'Inventory.character_id' => $this->characterInfo['id'],
				'Inventory.bag_id' => $to_bag_id,
				'Inventory.index' => $to_bag_index
			)));
			if(!empty($toInventory)) {
				// Niks aan de hand, wisselen
				// to => from
				$oldIds = $Inventory->find('list', array('conditions' => array(
					'Inventory.character_id' => $this->characterInfo['id'],
					'Inventory.bag_id' => $from_bag_id,
					'Inventory.index' => $from_bag_index
					)));
				$Inventory->updateAll(
					array('Inventory.bag_id' => $fromInventory['Inventory']['bag_id'], 'Inventory.index' => $fromInventory['Inventory']['index']),
					array('Inventory.bag_id' => $toInventory['Inventory']['bag_id'], 'Inventory.index' => $toInventory['Inventory']['index'])
				);
				// from => to
				$Inventory->updateAll(
					array('Inventory.bag_id' => $toInventory['Inventory']['bag_id'], 'Inventory.index' => $toInventory['Inventory']['index']),
					array('Inventory.id' => $oldIds)
				);
			}
			else {
				// kijken of er in de nieuwe bag slot wel ruimte is
				$this->Bag->recursive = 2;
				$toBag = $this->Bag->find('first', array('conditions' => array(
					'Bag.id' => $to_bag_id,
					'Bag.character_id' => $this->characterInfo['id']))
				);
				if(!empty($toBag)) {
					// Kijken of de index lager is dan het aantal vrije slots
					if($toBag['Item']['StatNamed']['slots'] >= $to_bag_index) {
						// Mag naar de lege plek
						$Inventory->updateAll(
							array('Inventory.bag_id' => $to_bag_id, 'Inventory.index' => $to_bag_index),
							array('Inventory.bag_id' => $fromInventory['Inventory']['bag_id'], 'Inventory.index' => $fromInventory['Inventory']['index'])
						);
					}
				}
			}
		}
		$this->redirect('/game/bags/view/'. $to_bag_id);
		exit;
	}
}
?>