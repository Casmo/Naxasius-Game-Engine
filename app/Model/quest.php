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
class Quest extends AppModel {
	var $name = 'Quest';

	var $hasAndBelongsToMany = array(
		'Item' => array(
			'className' => 'Item',
			'joinTable' => 'items_quests',
			'foreignKey' => 'quest_id',
			'associationForeignKey' => 'item_id',
			'conditions' => array(
				'ItemsQuest.type' => array('needed')
			)
		),
		'Reward' => array(
			'className' => 'Item',
			'joinTable' => 'items_quests',
			'foreignKey' => 'quest_id',
			'associationForeignKey' => 'item_id',
			'conditions' => array(
				'ItemsQuest.type' => array('reward')
			)
		),
		'Stat',
		'Mob'
	);

	var $actsAs = array('Containable');

	// Check if a quest can be viewed with the current character...
	// @param $type == enum ('getquest', 'completequest')
	function canView($character_id = null, $quest_id = null, $type = 'getquest') {
		$this->bindModel(array('hasOne' => array('CharactersQuest')));
		$this->contain(array('CharactersQuest'));
		$CharactersQuest = $this->find('first', array('conditions' => array(
				'CharactersQuest.quest_id' => $quest_id,
				'CharactersQuest.character_id' => $character_id
			)
		));
		if(empty($CharactersQuest) && $type == 'getquest') {
			return true;
		}
		if(isset($CharactersQuest['CharactersQuest']['completed']) && $CharactersQuest['CharactersQuest']['completed'] == 'yes' && $type == 'completequest') {
			return true;
		}
		return false; // Default not visiable...
	}

/**
 * Updates a Quest for a Character. If the Quest is completed and turned in
 * the Character may receive some Quest rewards.
 *
 * @param int $quest The ID of the quest
 * @param int $character_id The ID of the Character
 * @param boolean $turnIn Whenever this quest is turning in
 */
	function update($quest_id = null, $character_id = null, $turnIn = false) {
		App::import('Model', 'CharactersQuest');
		$CharactersQuest = new CharactersQuest();
		$conditions = array();
		$conditions['CharactersQuest.completed !='] = 'finished';
		if(isset($quest_id)) {
			$conditions['CharactersQuest.quest_id'] = $quest_id;
		}
		if(isset($character_id)) {
			$conditions['CharactersQuest.character_id'] = $character_id;
		}

		$quests = $CharactersQuest->find('all', array(
				'conditions' => array(
					$conditions
				)
			)
		);
		if(!empty($quests)) {
			// Inventory, Kill maybe needed
			App::import('Model', 'Inventory');
			$Inventory = new Inventory();
			App::import('Model', 'Kill');
			$Kill = new Kill();

			$charactersQuestsData = array();
			$i = 0;
			foreach($quests as $quest) {
				$charactersQuestsData[$i]['id'] = $quest['CharactersQuest']['id'];
				// Get the needed things (items, object, whatever) here
				$itemsNeeded = $this->ItemsQuest->find('list', array(
					'conditions' => array(
						'ItemsQuest.quest_id' => $quest['CharactersQuest']['quest_id'],
						'ItemsQuest.type' => 'needed'
					),
					'fields' => array(
						'ItemsQuest.item_id',
						'ItemsQuest.amount'
					)
				));
				$mobsNeeded = $this->MobsQuest->find('list', array(
					'conditions' => array(
						'MobsQuest.quest_id' => $quest['CharactersQuest']['quest_id']
					),
					'fields' => array(
						'MobsQuest.mob_id',
						'MobsQuest.amount'
					)
				));
				$itemsRewards = $this->ItemsQuest->find('list', array(
					'conditions' => array(
						'ItemsQuest.quest_id' => $quest['CharactersQuest']['quest_id'],
						'ItemsQuest.type' => 'reward'
					),
					'fields' => array(
						'ItemsQuest.item_id',
						'ItemsQuest.amount'
					)
				));
				$statsRewards = $this->QuestsStat->find('list', array(
					'conditions' => array(
						'QuestsStat.quest_id' => $quest['CharactersQuest']['quest_id']
					),
					'fields' => array(
						'QuestsStat.stat_id',
						'QuestsStat.amount'
					)
				));
				$completed = '';
				if(empty($itemsNeeded) && empty($mobsNeeded)) {
					// Geen items nodig.. Omdat er op het moment niks anders is om te controleren updaten we deze quest...
					if($turnIn == true && isset($character_id) && isset($quest_id)) {
						$charactersQuestsData[$i]['completed'] = 'finished';
					}
					else {
						$charactersQuestsData[$i]['completed'] = 'yes';
					}
				}
				else {
					$completed = 'yes'; // Default it's completed.
					$itemList = array();
					$mobList = array();
					foreach($itemsNeeded as $item_id => $amount) {
						$itemList[] = $item_id;
					}
					foreach($mobsNeeded as $mob_id => $amount) {
						$mobList[] = $mob_id;
					}
					// Er zijn items nodig voor deze quest..  Kijken of deze al gehaald zijn...
					// ItemsNeeded: item_id => aantal_needed
					$characterInventories = $Inventory->find('all', array(
							'conditions' => array(
								'Inventory.character_id' => $quest['CharactersQuest']['character_id'],
								'Inventory.item_id' => $itemList
							),
							'fields' => array(
								'Inventory.item_id',
								'COUNT(Inventory.item_id) as amount'
							),
							'group' => array(
								'Inventory.item_id'
							)
						)
					);
					// Er zijn mobs nodig voor deze quest. Kijken of ze gekilled zijn NADAT de quest is geaccepteerd...
					$characterKills = $Kill->find('all', array(
							'conditions' => array(
								'Kill.character_id' => $quest['CharactersQuest']['character_id'],
								'Kill.mob_id' => $mobList,
								'Kill.type' => 'mob',
								'Kill.created >=' => $quest['CharactersQuest']['created']
							),
							'fields' => array(
								'Kill.mob_id',
								'COUNT(Kill.target_id) as amount'
							),
							'group' => array(
								'Kill.target_id'
							)
						)
					);

					// We hebben een lijst met items wat nodig is..
					// En dit wordt een lijst met wat we hebben...
					$itemsHave = array();
					foreach($characterInventories as $characterInventory) {
						$itemsHave[$characterInventory['Inventory']['item_id']] = $characterInventory[0]['amount'];
					}
					// Opslaan yes/no of de quest compleet is...
					foreach($itemsNeeded as $item_id => $amount) {
						if(!isset($itemsHave[$item_id]) || (isset($itemsHave[$item_id]) && $itemsHave[$item_id] < $itemsNeeded[$item_id])) {
							$completed = 'no';
						}
					}
					// We hebben nu een lijst met mobs die nodig zijn, en een lijst met kills
					$mobsHave = array();
					foreach($characterKills as $characterKill) {
						$mobsHave[$characterKill['Kill']['mob_id']] = $characterKill[0]['amount'];
					}
					// Opslaan yes/no of de quest compleet is...
					foreach($mobsNeeded as $mob_id => $amount) {
						if(!isset($mobsHave[$mob_id]) || (isset($mobsHave[$mob_id]) && $mobsHave[$mob_id] < $mobsNeeded[$mob_id])) {
							$completed = 'no';
						}
					}

					// Maybe the character is turning in the quest...
					if($completed == 'yes' && $turnIn == true && isset($character_id) && isset($quest_id)) {
						$completed = 'finished';
					}
					// Als de quest 'finished' is, dan moeten eventuele items uit de inventory verwijderd worden...
					// Dat kan hier.
					if($completed == 'finished' && !empty($itemsNeeded)) {
						foreach($itemsNeeded as $item_id => $amount) {
							for($j = 1; $j <= $amount; $j++) {
								$Inventory->deleteAll(array('Inventory.character_id' => $quest['CharactersQuest']['character_id'], 'Inventory.item_id' => $item_id));
							}
						}
					}
					$charactersQuestsData[$i]['completed'] = $completed;
				}

				// En voor het mooi, natuurlijk ook even de rewards geven...
				if($completed == 'finished' && !empty($itemsRewards)) {
					App::import('Model', 'Drop');
					$Drop = new Drop();
					foreach($itemsRewards as $item_id => $amount) {
						for($j = 1; $j <= $amount; $j++) {
							$data = array();
							// Bagid en index opvragen
							$bagIndex = $Drop->hasFreeSpace($quest['CharactersQuest']['character_id'], $item_id, true);
							$data['character_id'] = $quest['CharactersQuest']['character_id'];
							$data['item_id'] = $item_id;
							$data['index'] = $bagIndex['index'];
							$data['bag_id'] = $bagIndex['bag_id'];
							$Inventory->create();
							$Inventory->save($data);
						}
					}
				}
				if($completed == 'finished' && !empty($statsRewards)) {
					App::import('Model', 'CharactersStat');
					$CharactersStat = new CharactersStat();
					foreach($statsRewards as $stat_id => $amount) {
						$statData = array();
						$statData['character_id'] = $quest['CharactersQuest']['character_id'];
						// Kijken of deze stat al in de database bestaat
						$someStat = $CharactersStat->find('first', array('conditions' => array('CharactersStat.stat_id' => $stat_id, 'CharactersStat.character_id' => $quest['CharactersQuest']['character_id'])));
						if(!empty($someStat)) {
							$statData['id'] = $someStat['CharactersStat']['id'];
							$statData['amount'] = $someStat['CharactersStat']['amount'] + $amount;
						}
						else {
							$statData['amount'] = $amount;
							$statData['stat_id'] = $stat_id;
						}
						$CharactersStat->create();
						$CharactersStat->save($statData);
					}
				}
				$i++;
			}
			$CharactersQuest->saveAll($charactersQuestsData);
		}
	}
}
?>