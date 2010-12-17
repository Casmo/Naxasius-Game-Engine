<?php
/**
 * Loot
 *
 * Loot Items
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
class LootsController extends AppController {
	var $name = 'Loots';

	function game_loot($loot_id = null) {
		$this->render(false);
		$this->Loot->contain(array('Item'));
		$someLoot = $this->Loot->find('first', array('conditions' => array(
			'Loot.character_id' => $this->characterInfo['id'],
			'Loot.id' => $loot_id
			// I may check for area_id aswell...
		)));
		if(!empty($someLoot)) {
			$this->loadModel('Inventory');
			$this->loadModel('Drop');
			// Bagid en index opvragen
			if($bagIndex = $this->Drop->hasFreeSpace($this->characterInfo['id'], $someLoot['Item']['id'], true)) {
				$dataInventory['Inventory']['index'] = $bagIndex['index'];
				$dataInventory['Inventory']['bag_id'] = $bagIndex['bag_id'];
				$dataInventory['Inventory']['character_id'] = $this->characterInfo['id'];
				$dataInventory['Inventory']['item_id'] = $someLoot['Item']['id'];
				// Save to inventory
				if($this->Inventory->save($dataInventory)) {
					App::import('Model', 'Quest');
					$Quest = new Quest();
					$Quest->update(null, $this->characterInfo['id']);

					$someLoot['Loot']['looted'] = 'yes';
					$this->Loot->save($someLoot);

					// Kijken of dit item als eerst gevonden is voor deze gebruiker...
					if(isset($someLoot['Item']['character_id']) && $someLoot['Item']['character_id'] == 0) {
						$thisItem['Item']['character_id'] = $this->characterInfo['id'];
						$thisItem['Item']['discovered'] = date('Y-m-d H:i:s');
						$this->Item->save($thisItem);
					}
					if($someLoot['Item'][''])
					echo '1';
					exit;
				}
			}
		}
		echo '0';
		exit;
	}
}
?>