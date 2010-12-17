<?php
/**
 * Area-Mob Controller
 *
 * This file is used for displaying and modifying Mobs on an Area.
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
class AreasMobsController extends AppController {
	var $name = 'AreasMobs';

	var $helpers = array('Form');

/**
 * Displays the actions of a Mob in the map
 *
 * @param int $areas_mobs_id the ID of the `areas_mobs`.`id` field
 * @return boolean
 */
	function game_action($areas_mobs_id = null) {
		if(empty($areas_mobs_id) || !is_numeric($areas_mobs_id)) {
			$this->render('/errors/actionnotfound');
			return false;
		}
		if($this->AreasMob->canAttack($areas_mobs_id, $this->characterInfo['id'], $this->characterInfo['area_id'])) {
			$this->AreasMob->contain(array('Mob'));
			$areasMob = $this->AreasMob->find('first', array('conditions' => array('AreasMob.id' => $areas_mobs_id)));
			$this->set('areasMob', $areasMob);
		}
		else {
			$this->render('/errors/actionnotfound');
			return false;
		}
	}

	function game_view($areas_mobs_id = null) {
		if(empty($areas_mobs_id) || !is_numeric($areas_mobs_id)) {
			$this->render('/errors/notfound');
			return false;
		}

		if($this->AreasMob->canAttack($areas_mobs_id, $this->characterInfo['id'], $this->characterInfo['area_id'])) {
			$this->AreasMob->contain(array('Mob' => array('Stat')));
			$areasMob = $this->AreasMob->find('first', array('conditions' => array('AreasMob.id' => $areas_mobs_id)));
			$areasMob['Mob']['Stat'] = $this->AreasMob->Mob->makeStats($areasMob['Mob']['Stat']);
			$this->set('areasMob', $areasMob);
		}
		else {
			$this->render('/errors/notfound');
			return false;
		}
	}

/**
 * Attack a Mob.
 *
 * This function will auto attack a Mob if possible. After that it may give XP, lose HP, get loot on the current area_id.
 *
 * @param $areas_mobs_id the ID of mob/area combination @see `areas_mobs`.`id`
 * @see /app/models/mob.php battle()
 */
	function game_attack($areas_mobs_id = null) {
		if(empty($areas_mobs_id) || !is_numeric($areas_mobs_id)) {
			$this->render('/errors/notfound');
			return false;
		}
		$this->updateGame(array('Character', 'Stat'));

		if($this->AreasMob->canAttack($areas_mobs_id, $this->characterInfo['id'], $this->characterInfo['area_id'])) {
			$this->AreasMob->contain(array('Mob' => array('Stat')));
			$areasMob = $this->AreasMob->find('first', array('conditions' => array('AreasMob.id' => $areas_mobs_id)));
			$areasMob['Mob']['Stat'] = $this->AreasMob->Mob->makeStats($areasMob['Mob']['Stat']);
			$areasMob['Mob']['Stat']['hp_org'] = $areasMob['Mob']['Stat']['hp'];
			$areasMob['Mob']['battle_key'] = 'mob';
			$currentCharacter = $this->characterInfo;
			$currentCharacter['Stat'] = $this->Session->read('Game.Stat');
			$currentCharacter['Stat']['hp_org'] = $currentCharacter['Stat']['hp'];
			$currentCharacter['battle_key'] = 'you';
			$battleInfo = $this->AreasMob->Mob->battle($currentCharacter, $areasMob['Mob']);
			$loot = array(); // List of loot (items)
			if($battleInfo['defender']['Stat']['hp'] <= 0) {
			#	debug($battleInfo);
				// Player wins
				$areasMob['AreasMob']['last_killed'] = date('Y-m-d H:i:s');
				$this->AreasMob->save($areasMob['AreasMob']);

				App::import('Model', 'Kill');
				$Kill = new Kill();
				$someKill['character_id'] = $this->characterInfo['id'];
				$someKill['target_id'] = $areasMob['AreasMob']['id'];
				$someKill['mob_id'] = $areasMob['Mob']['id'];
				$someKill['type'] = 'mob';
				$Kill->save($someKill);

				$addXp = $this->AreasMob->Mob->earnedXp($currentCharacter['Stat']['level'], $areasMob['Mob']['level']);
				$this->Character->addStat('xp', $addXp, $this->characterInfo['id']);

				// Show the loot
				$this->loadModel('Loot');
				$this->Loot->createLootFromMob($areasMob['Mob']['id'], $this->characterInfo['area_id'], $this->characterInfo['id']);
				$this->Loot->contain(array('Item'));
				$loot = $this->Loot->getLoot(array('Loot.character_id' => $this->characterInfo['id'], 'Loot.mob_id' => $areasMob['Mob']['id']));

				$this->loadModel('Quest');
				$this->Quest->update(null, $this->characterInfo['id']);
			}
			elseif($battleInfo['attacker']['Stat']['hp'] <= 0) {
				// Player loses
				// @todo reset it?
			}
			// Update the stats
			$addHp = $battleInfo['attacker']['Stat']['hp'] - $this->Session->read('Game.Stat.hp');
			$this->loadModel('Character');
			$this->Character->addStat('hp', $addHp, $this->characterInfo['id']);
			$this->updateGame(array('Character', 'Stat'));

			$this->set('battleInfo', $battleInfo);
			$this->set('loot', $loot);
		}
		else {
			$this->render('/errors/notfound');
			return false;
		}
	}

	function admin_edit_area($area_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			foreach($this->data['AreasMob'] as $mob) {
				if(isset($mob['index']) && $mob['index'] == '1') {
					$this->AreasMob->create();
					$this->AreasMob->save($mob);
				}
				elseif(isset($mob['id'])) {
					$this->AreasMob->deleteAll(array('AreasMob.id' => $mob['id']));
				}
			}
			$this->render(false);
		}
		else {
			$selectedMobs = $this->AreasMob->find('all', array('conditions' => array('AreasMob.area_id' => $area_id)));
			$mobs = $this->AreasMob->Mob->find('list');
			$quests = $this->AreasMob->Quest->find('list');
			$this->set('selectedMobs', $selectedMobs);
			$this->set('mobs', $mobs);
			$this->set('quests', $quests);
			$this->set('area_id', $area_id);
		}
	}
}
?>