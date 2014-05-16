<?php
/**
 * Area Mob
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
class AreasMob extends AppModel {
	var $name = 'AreasMob';

	var $belongsTo = array('Mob', 'Quest');

	var $actsAs = array('Containable');

/**
 * Returns whenever a Character can attack a mob
 *
 * @param int $character_id the ID of the character
 * @param int $area_id the ID of the current location of the character
 * @return boolean
 */
	function canAttack($areas_mobs_id = null, $character_id = null, $area_id = null) {
		$someMob = $this->find('first', array(
			'conditions' =>	array(
				'AreasMob.id' => $areas_mobs_id,
				'AreasMob.area_id' => $area_id
			)
		));
		if(empty($someMob)) {
			return false;
		}
		// Check if Quest is needed...
		// When player_only = 1 we need to check the killing table if the player can kill this mob again
		if($someMob['AreasMob']['player_only'] == '1') {
			App::import('Model', 'Kill');
			$Kill = new Kill();
			$lastKill = $Kill->find('first',
				array(
					'conditions' => array(
						'Kill.character_id' => $character_id,
						'Kill.target_id' => $someMob['AreasMob']['id'],
						'Kill.type' => 'mob',
						'Kill.created >= ' => date('Y-m-d H:i:s', strtotime('-'. $someMob['AreasMob']['spawn_time'] .' seconds'))
					)
				)
			);
			if(empty($lastKill)) {
				// Controleer de kill limit. Kill_limit is een limit op de areas_mobs.id en niet op de mob_id.
				if($someMob['AreasMob']['kill_limit'] > 0) {
					$amountKills = $Kill->find('count', array(
						'conditions' => array(
							'Kill.character_id' => $character_id,
							'Kill.target_id' => $someMob['AreasMob']['id'],
							'Kill.type' => 'mob'
						)
					));
					if($someMob['AreasMob']['kill_limit'] > $amountKills) {
						return true;
					}
				}
				else {
					return true;
				}
			}
		}
		elseif($someMob['AreasMob']['last_killed'] < date('Y-m-d H:i:s', strtotime('-'. $someMob['AreasMob']['spawn_time'] .' seconds'))) {
			if($someMob['AreasMob']['kill_limit'] > 0) {
				$amountKills = $Kill->find('count', array(
					'conditions' => array(
						'Kill.target_id' => $someMob['AreasMob']['id'],
						'Kill.type' => 'mob'
					)
				));
				if($someMob['AreasMob']['kill_limit'] < $amountKills) {
					return true;
				}
			}
			else {
				return true;
			}
		}
		return false;
	}
}
?>