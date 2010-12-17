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
class Item extends AppModel {
	var $name = 'Item';
	var $hasAndBelongsToMany = array('Stat');
	var $belongsTo = array(
		'Group' => array('conditions' => array('Group.type' => 'item')),
		'Character'
	);

	var $actsAs = array('Containable');

	// Making Stats usable for code
	function afterFind($results, $primary) {
		$new_results = array();
		if(isset($results[0]) && !empty($results[0])) {
			foreach($results as $index => $result) {
				if(isset($result['Item']['Stat'])) {
					$result['StatNamed'] = array();
					foreach($result['Item']['Stat'] as $stat) {
						$result['Item']['StatNamed'][$stat['key']] = $stat['ItemsStat']['value'];
					}
				}
				$new_results[$index] = $result;
			}
		}
		else {
			if(isset($results['Stat']) && !empty($results['Stat'])) {
				$results['StatNamed'] = array();
				foreach($results['Stat'] as $stat) {
					$results['StatNamed'][$stat['key']] = $stat['ItemsStat']['value'];
				}
			}
			$new_results = $results;
		}
		return $new_results;
	}
}
?>