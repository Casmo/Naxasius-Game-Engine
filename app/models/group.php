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
class Group extends AppModel {
	var $name = 'Group';

	var $hasMany = array(
		'Tile' => array(
	#		'conditions' => array(
	#			'Group.type' => 'tile'
	#		)
		),
		'Obstacle' => array(
	#		'conditions' => array(
	#			'Group.type' => 'obstacle'
	#		)
		)
	);

	var $actsAs = array('Containable');
}
?>