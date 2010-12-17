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
class Loot extends AppModel {
	var $name = 'Loot';

	var $belongsTo = array('Area', 'Character', 'Item', 'Party', 'Mob');

	var $actsAs = array('Containable');

/**
 * Creates an list a loot in `loots` for a player/party.
 * The chance is in calculated from 1 to 10000. So 1 = 0.01%, 100 = 1%, etc
 *
 * @todo if there is a party. Then the quest items have to drop for every character who has the quest.
 *
 * @param int $mob_id The ID of the killed mob
 * @param int $area_id The ID where the loot took place
 * @param int $character_id The ID of the character
 * @param int $party_id @todo the ID of the party group.
 * @return void
 */
	function createLootFromMob($mob_id = null, $area_id = 0, $character_id = 0, $party_id = 0) {
		if(!isset($mob_id) || empty($mob_id)) {
			return;
		}
		App::import('Model', 'Mob');
		$Mob = new Mob();
		$Mob->contain('Item');
		$someMob = $this->Mob->find('first', array('conditions' => array('Mob.id' => $mob_id)));
		if(empty($Mob)) {
			return;
		}
		$itemsLoot = array();
		foreach($someMob['Item'] as $item) {
			// As the chance is higher then 100% (>10000) we have to decrease this number
			// by the factor of 10000 and will the factor number will be dropped. For example:
			// If a item has 250% (25000) chance to drop. You will have 50% chance for 2 of that item
			// and 50% of 3 of that item.
			if($item['ItemsMob']['chance'] > 10000) {
				for($i = $item['ItemsMob']['chance']; $i > 10000; $i-= 10000) {
					$itemsLoot[] = array(
						'party_id' => $party_id,
						'character_id' => $character_id,
						'item_id' => $item['id'],
						'area_id' => $area_id,
						'mob_id' => $mob_id
					);
				}
				$item['ItemsMob']['chance'] = $i;
			}
			// Let's roll if this item is dropped.
			// For example: $chance is 25% chance. so if($chance <= rand(1,10000)) { drop(); }
			if($item['ItemsMob']['chance'] <= rand(1,10000)) {
				$itemsLoot[] = array(
					'party_id' => $party_id,
					'character_id' => $character_id,
					'item_id' => $item['id'],
					'area_id' => $area_id,
					'mob_id' => $mob_id
				);
			}
		}
		$this->saveAll($itemsLoot);
		return;
	}

/**
 * Get a list of loot.
 * Only loot witch is not looted and is newer then 5 minutes ago will be looted.
 *
 * @param $conditions array list of conditions. E.g. Loot.character_id = 1;
 *
 * @return array list of items
 */
	function getLoot($conditions = array()) {
		$conditions['Loot.created >='] = date('Y-m-d H:i:s', strtotime('-5 minutes'));
		$conditions['Loot.looted'] = 'no';
		$this->contain(array('Item'));
		return $this->find('all', array('conditions' => $conditions));
	}
}
?>