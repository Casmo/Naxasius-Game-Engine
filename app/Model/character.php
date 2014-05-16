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
class Character extends AppModel {
	var $name = 'Character';

	var $belongsTo 	= array(
						'User',
						'Avatar',
						'Type'
						);
	var $hasAndBelongsToMany = array('Stat');

	var $hasMany = array('Inventory');

	var $actsAs = array('Containable', 'Fighter');

	function __construct() {
		parent::__construct();
		$this->validate = array (
			'name' => array (
				'notEmpty' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Fill in a charactername' ,true)
				),
				'isUnique' => array (
					'rule' => 'isUnique',
					'message' => __('Charactername already exists', true)
				),
				'alphaNumeric' => array(
					'rule' => 'alphaNumeric',
					'message' => __('Only alphabets and numbers allowed', true)
				),
				'minLength' => array(
					'rule' => array('minLength', 3),
					'message' => __('Name must be at least 3 characters long', true)
				),
				'maxLength' => array(
					'rule' => array('maxLength', 15),
					'message' => __('Name can\'t be more then 15 characters long', true)
				)
			),
			'type_id' => array (
				'notEmpty' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Choose a class', true)
				)
			),
			'avatar_id' => array (
				'notEmpty' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Choose an avatar', true)
				)
			)
		);
	}

	/**
	 * Adds stats to a character
	 *
	 * @param $stats_key the key of the stat. @see `stats`
	 * @param $amount the amount added. Can be negative value
	 * @param $character_id the unique ID of the character
	 *
	 * @return boolean whenever the stat is added or not.
	 */
	function addStat($stats_key = null, $amount = null, $character_id = null) {
		$someStat = $this->Stat->find('first', array('conditions' => array('Stat.key' => $stats_key)));
		if(empty($someStat)) {
			return false;
		}
		$charactersStat = $this->CharactersStat->find('first', array('conditions' => array('CharactersStat.stat_id' => $someStat['Stat']['id'], 'CharactersStat.character_id' => $character_id)));
		if(!empty($charactersStat)) {
			$charactersStat['CharactersStat']['amount'] = $charactersStat['CharactersStat']['amount'] + $amount;
		}
		else {
			// Nieuwe stat voor de character toevoegen
			$charactersStat['CharactersStat']['amount'] = $amount;
			$charactersStat['CharactersStat']['stat_id'] = $someStat['Stat']['id'];
			$charactersStat['CharactersStat']['character_id'] = $character_id;
		}
		return $this->CharactersStat->save($charactersStat['CharactersStat']);
	}

/**
 * Function to add stats after a character did level up.
 * This function will calculate the different stats between the current
 * level and the previous level. The different will be added by the
 * current stats.
 *
 * @param int $character_id the ID of the character
 * @return void
 */
	function ding($character_id = null) {
		$this->contain(array('Stat'));
		$someCharacter = $this->find('first', array('conditions' => array('Character.id' => $character_id)));
		$someCharacter['Stat'] = $this->makeStats($someCharacter['Stat']);
		if(empty($someCharacter)) {
			return;
		}
		App::import('Model', 'CharactersStat');
		$CharactersStat = new CharactersStat();
		$addHp = $this->calcHp($someCharacter['Stat']['level']) - $this->calcHp(($someCharacter['Stat']['level']-1));
		$someStat = $CharactersStat->find('first', array('conditions' =>
			array(
					'CharactersStat.character_id' => $character_id,
					'CharactersStat.stat_id' => Configure::read('Stats.hp')
				)
			)
		);
		$someStat['CharactersStat']['amount'] += $addHp;
		$CharactersStat->save($someStat);
		return;
	}
}
?>