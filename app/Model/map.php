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
class Map extends AppModel {
	var $name = 'Map';

	var $hasMany = array('Area');

	var $actsAs = array('Containable');

	/**
	 * This function allows you to generate a list of areas in order Y,X
	 * @param $area_id The area id where we standing
	 * @param $map_id Get the whole map
	 * @param $limit The limit of the borders around the $area_id. 1 = 3x3, 2 = 5x5, 3 = 7x7, etc
	 *
	 * @return mixed false when nothing found. Else array with areas sorted by y,x (so we can make td's')
	 */
	function getMap($area_id = null, $map_id = null, $limit_x = 5, $limit_y = 2, $params = array()) {
		#$this->bindModel(array('hasMany' => array('Area')));
		if(isset($area_id) && !empty($area_id)) {
			// Get the area where is asked for
			$area = $this->Area->find('first', array('conditions' => array('Area.id' => $area_id)));
			if(empty($area)) {
				return false;
			}
			$map_id = $area['Area']['map_id'];
			#$this->Area->bindModel(array('hasAndBelongsToMany' => array('Npc')));
			#$this->Area->bindModel(array('hasAndBelongsToMany' => array('Obstacle')));
		}
		else {
			$limit_x = 0; // Override the limit because when asked for a map, show the whole map...
			$limit_y = 0;
		}
		if($limit_x > 0) {
			$min_x = $area['Area']['x'] - $limit_x;
			$max_x = $area['Area']['x'] + $limit_x;
		}
		if($limit_y > 0) {
			$min_y = $area['Area']['y'] - $limit_y;
			$max_y = $area['Area']['y'] + $limit_y;
		}
		if($limit_y > 0 || $limit_x > 0) {
		// Get the neighbours of the area
		$conditions = array (
						'Area.x >=' =>  $min_x,
						'Area.x <' =>  $max_x,
						'Area.y >=' =>  $min_y,
						'Area.y <=' =>  $max_y,
						'Area.map_id' => $map_id
					);
		}
		else {
			$conditions = array('Area.map_id' => $map_id);
		}
		$order		= array (
						'Area.y ASC', 'Area.x ASC'
					);

		$this->Area->contain(array('Npc', 'Obstacle', 'Tile'));
		#$this->Area->bindModel(array('hasAndBelongsToMany' => array('Npc')));
		#$this->Area->bindModel(array('hasAndBelongsToMany' => array('Obstacle' => array('order' => array('AreasObstacle.z ASC')))));
		#$this->Area->unbindModel(array('belongsTo' => array('Map')));
		$areas = $this->Area->find('all', array('conditions' => $conditions, 'order' => $order));
		return $areas;
	}

	/**
	 * An array of usefull map info, like the x and y of the map
	 * return array with information
	 */
	 function mapInfo($id = null) {
	 	$this->bindModel(array('hasMany' => array('Area')));
	 	$mapInfo = array('x' => 0, 'y' => 0);
	 	if(!isset($id) || empty($id)) {
	 		return $mapInfo;
	 	}
	 	$conditions = array('Area.map_id' => $id);
	 	$order = array('Area.x DESC', 'Area.y DESC');
	 	$thisMap = $this->Area->find('first', array('conditions' => $conditions, 'order' => $order));

	 	$mapInfo['x'] = $thisMap['Area']['x'];
	 	$mapInfo['y'] = $thisMap['Area']['y'];

	 	return $mapInfo;
	 }
}
?>