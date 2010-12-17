<?php
/**
 * Fighter
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
class FighterBehavior extends ModelBehavior {

	function setup(&$Model, $settings) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = array(
				'StatsKey' => 'CharactersStat',
				'type' => 'character'
			);
		}
		$this->settings[$Model->alias] = array_merge(
			$this->settings[$Model->alias], (array)$settings);
	}

	/**
	 * Simple battle between to fighters.
	 *
	 * @param array $attacker an array with at least a ['name'], ['battle_key'] and ['Stat'] = array() of the attacker
	 * @param array $defender @see $attacker
	 * @param array $log array with the attacks and logs for human reads
	 * @param array $log_system array with commando's to show to the interface
	 *
	 * @return array Returns the new values of the Stats, and a array with the Log
	 */
	function battle(&$Model, &$attacker = array(), &$defender = array(), &$log = array(), &$log_system = array()) {
		if(!isset($attacker['Stat']['hp']) || !isset($defender['Stat']['hp']) || !isset($defender['battle_key']) || !isset($attacker['battle_key'])) {
			return array(
				'log' => $log,
				'log_system' => $log_system,
				'attacker' => $attacker,
				'defender' => $defender
			);
		}
		if(is_numeric($defender['Stat']['hp']) && $defender['Stat']['hp'] > 0) {
			$attackInfo = $this->attack($Model, $attacker, $defender, $log, $log_system);
			$attacker = $attackInfo['attacker'];
			$defender = $attackInfo['defender'];
			$log = $attackInfo['log'];
			$log_system = $attackInfo['log_system'];
		}
		// If defender lives, attack back.
		if(is_numeric($defender['Stat']['hp']) && $defender['Stat']['hp'] > 0 && is_numeric($attacker['Stat']['hp']) && $attacker['Stat']['hp'] > 0) {
			$attackInfo = $this->attack($Model, $defender, $attacker, $log, $log_system);
			$attacker = $attackInfo['defender'];
			$defender = $attackInfo['attacker'];
			$log = $attackInfo['log'];
			$log_system = $attackInfo['log_system'];
		}
		// If they still both life, battle continues
		if(is_numeric($defender['Stat']['hp']) && $defender['Stat']['hp'] > 0 && is_numeric($attacker['Stat']['hp']) && $attacker['Stat']['hp'] > 0) {
			$this->battle($Model, $attacker, $defender, $log, $log_system);
		}
		return array(
				'log' => $log,
				'log_system' => $log_system,
				'attacker' => $attacker,
				'defender' => $defender
			);
	}

/**
 * An attack between 2 fighters.
 *
 * @param array $attacker an array with at least a ['name'] and ['Stat'] = array() of the attacker
 * @param array $defender @see $attacker
 *
 * @return array Return the new values of the Stats, and an array with the Log
 */
	function attack(&$Model, $attacker = array(), $defender = array(), $log = array(), $log_system = array()) {
		if(isset($attacker['Stat']['min_damage']) && isset($attacker['Stat']['max_damage'])) {
			$base_damage = rand($attacker['Stat']['min_damage'], $attacker['Stat']['max_damage']);
		}
		else {
			$base_damage = 1;
		}
		// Do calculation of armor, resists, bonussen, dodge, crit, etc
		if(isset($defender['Stat']['armor'])) {
			$percent = $base_damage / 100;
			$amountReduced = $percent * $this->damageReduction($defender['Stat']['armor'], $attacker['Stat']['level']);
			$base_damage = $base_damage - $amountReduced;
		}
		$damage = $base_damage;

		$defender['Stat']['hp'] = $defender['Stat']['hp'] - $damage;
		$log[] = __(sprintf('%s deals %s damage to %s.', $attacker['name'], $damage, $defender['name']), true);
		$log_system[] = array('battle_key' => $attacker['battle_key'], 'damage' => $damage, 'type' => 'normal');
		if($defender['Stat']['hp'] <= 0) {
			$log[] = __(sprintf('%s died.', $defender['name']), true);
			$log_system[] = array('battle_key' => $defender['battle_key'], 'damage' => 0, 'type' => 'dead');
			$defender['Stat']['hp'] = 0;
		}

		return array(
			'log' => $log,
			'log_system' => $log_system,
			'attacker' => $attacker,
			'defender' => $defender
		);
	}


/**
 * In the afterFind we add the stats of a character to a more useable array
 * [key] => value
 */
	function makeStats(&$Model, $results = array(), $equipement = array()) {
		if(empty($results) || !is_array($results)) {
			return $results;
		}

		$new_stats = array();
		foreach($results as $stat) {
			$new_stats[$stat['key']] = $stat[$this->settings[$Model->alias]['StatsKey']]['amount'];
		}
		if(isset($equipement) && !empty($equipement)) {
			foreach($equipement as $slot => $item) {
				if(isset($item['Stat']) && !empty($item['Stat'])) {
					foreach($item['Stat'] as $stat) {
						isset($new_stats[$stat['key']]) ? $new_stats[$stat['key']] = $new_stats[$stat['key']] + $stat['ItemsStat']['value'] : $new_stats[$stat['key']] = $stat['ItemsStat']['value'];
					}
				}
			}
		}
		if($this->settings[$Model->alias]['type'] == 'character') {
			if(!isset($new_stats['xp'])) {
				$new_stats['xp'] = 0;
			}
			// Override some stats if there are functions needed...
			$new_stats['level'] = isset($new_stats['level']) ? $new_stats['level'] : $this->calcLevel($Model, $new_stats['xp']);
			$new_stats['xp_needed'] = $this->calcXp($Model, ($new_stats['level'])) - $this->calcXp($Model, $new_stats['level'] - 1);
			$new_stats['xp_real'] = $new_stats['xp'] - $this->calcXp($Model, $new_stats['level'] - 1);

			$new_stats['hp_max'] = $this->calcHp($Model, $new_stats['level']); // @TODO add stats from weapons at it...
		}

		return $new_stats;

	}

/**
 * Returns the amount of XP earned after defeating a Mob
 *
 * The calculation is the following:
 * $factor = 20 * (($current_character_level / 10) + 1);
 * ($current_level_xp_needed / $factor)
 *
 * @param $character_level the current level of the Character
 * @param $mob_level the current level of the mob
 */
	function earnedXp(&$Model, $character_level = null, $mob_level = null) {
		$xp = $this->calcXp($Model, $character_level) / (20 * (($character_level / 10) + 1));
		// Eventuele bonus. Hogere mob = meer xp.
		$diff = $character_level - $mob_level;
		if($diff < -2) {
			$xp = $xp * 1.2;
		}
		elseif($diff == -2) {
			$xp = $xp * 1.1;
		}
		elseif($diff == -1) {
			$xp = $xp * 1.05;
		}
		elseif($diff == 1) {
			$xp = $xp * 0.75;
		}
		elseif($diff == 2) {
			$xp = $xp * 0.5;
		}
		elseif($diff == 3) {
			$xp = $xp * 0.25;
		}
		elseif($diff > 3) {
			// Te groot verschil, geen xp
			$xp = 0;
		}
		$xp = ceil($xp);
		return $xp;
	}

/**
 * Returns the level
 *
 * @author Michel Peters and Mathieu de Ruiter
 * @param int $xp the amount of XP
 * @return int $level the level
 */
	function calcLevel(&$Model, $xp = 0) {
		$level = $xp < 1 ? 0 : ceil(pow($xp / 150, 1/1.01));
		if($level == 0) { $level = 1; }
		if($xp == $this->calcXp($Model, $level)) { $level++; }
		return $level;
	}

	// Calculate the xp needed for the next level
	function calcXp(&$Model, $current_level)	{
		return $current_level < 1 ? 0 : ceil(150 * pow($current_level, 1.17));
	}

	// Returns the max hp of the current level
	function calcHp(&$Model, $current_level) {
		return $current_level < 1 ? 0 : ceil(80 * pow($current_level,0.15));
	}

/**
 * Calculates the damage reduction of an attack.
 *
 * @see http://rehfeld.us/wow/damage-reduction.html
 *
 * @param int the current armor of the defender
 * @param int the level of the attacker
 * @return double the percent of damage reduction
 */
	function damageReduction(&$Model, $armor = null, $attackersLevel = null) {
		if($attackersLevel > 59) {
			$attackersLevel = $attackersLevel + (4.5 * ($attackersLevel - 59));
		}
		$damageReduction = (0.1 * $armor) / ((8.5 * $attackersLevel) + 40);
		$damageReduction /= 1 + $damageReduction;
		if($damageReduction > 0.75) {
			$damageReduction = 0.75;
		}
		$percent = round($damageReduction * 100000) / 1000;
		return $percent;
	}
}
?>