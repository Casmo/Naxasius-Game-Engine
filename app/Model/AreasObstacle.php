<?php
/**
 * Area Obstacle
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
class AreasObstacle extends AppModel {
	var $name = 'AreasObstacle';

	var $belongsTo = array('Area', 'Obstacle');
	var $hasMany = array('AreasObstaclesItem');
	var $hasAndBelongsToMany = array(
		'Quest' => array(
			'joinTable' => 'actions_obstacles',
			'foreignKey' => 'areas_obstacle_id',
			'associationForeignKey' => 'target_id',
			'conditions' => array(
				'ActionsObstacle.type' => array('getquest','completequest')
			)
		),
		'Item'
	);
	var $actsAs = array('Containable');
}
?>