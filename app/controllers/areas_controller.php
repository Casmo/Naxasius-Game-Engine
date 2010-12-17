<?php
/**
 * Area Controller.
 *
 * This file allows Characters to move and display specific actions available for Areas.
 * Admins can add and edit Areas in this file.
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
class AreasController extends AppController {
	var $name = 'Areas';

/**
 * Moves a character in a specific direction.
 *
 * @param string|int direction or area_id where character is heading
 *
 * @return redirects to /game/maps, even if the character isn't moved.
 */
	function game_move($direction = null) {
		if(!isset($direction) && empty($direction)) {
			$this->redirect('/game/maps');
		}
		$updateModels = array('Character');
		$this->Area->contain();
		$conditions = array('Area.id' => $this->characterInfo['area_id']);
		$currentArea = $this->Area->find('first', array('conditions' => $conditions));
		$conditions = array();
		$conditions['Area.access'] = 1;
		switch($direction) {

			case "left":
			if($currentArea['Area']['restriction'] == 'left') {
				$this->redirect('/game/maps');
				exit;
			}
			$conditions['Area.map_id'] = $currentArea['Area']['map_id'];
			$conditions['Area.x'] = $currentArea['Area']['x'] - 1;
			$conditions['Area.y'] = $currentArea['Area']['y'];
			break;

			case "right":
			if($currentArea['Area']['restriction'] == 'right') {
				$this->redirect('/game/maps');
				exit;
			}
			$conditions['Area.map_id'] = $currentArea['Area']['map_id'];
			$conditions['Area.x'] = $currentArea['Area']['x'] + 1;
			$conditions['Area.y'] = $currentArea['Area']['y'];
			break;

			case "up":
			if($currentArea['Area']['restriction'] == 'up') {
				$this->redirect('/game/maps');
				exit;
			}
			$conditions['Area.map_id'] = $currentArea['Area']['map_id'];
			$conditions['Area.y'] = $currentArea['Area']['y'] - 1;
			$conditions['Area.x'] = $currentArea['Area']['x'];
			break;

			case "down":
			if($currentArea['Area']['restriction'] == 'down') {
				$this->redirect('/game/maps');
				exit;
			}
			$conditions['Area.map_id'] = $currentArea['Area']['map_id'];
			$conditions['Area.y'] = $currentArea['Area']['y'] + 1;
			$conditions['Area.x'] = $currentArea['Area']['x'];
			break;

			default:
			if($direction == $currentArea['Area']['travel_to']) {
				$conditions['Area.id'] = $currentArea['Area']['travel_to'];
				$direction = $this->characterInfo['last_move'];
				$updateModels[] = 'Map';
			}
		}
		$areaTo = $this->Area->find('first', array('conditions' => $conditions));
		if(!empty($areaTo)) {
			$data['Character']['id'] = $this->characterInfo['id'];
			$data['Character']['area_id'] = $areaTo['Area']['id'];
			$data['Character']['last_move'] = $direction;
			App::import('Model', 'Character');
			$Character = new Character();
			$Character->save($data['Character'], array('validate' => false));
			$this->updateGame($updateModels);
		}
		$this->redirect('/game/maps');
	}

/**
 * This displays an tile where the player may be moved to.
 *
 * @param int $area_id the area_id where the player may move to
 *
 * @return renders a Area or a 404 error
 */
	function game_action($area_id = null) {
		$this->helpers[] = 'World';
		if($this->Area->canMove($this->characterInfo['area_id'], $area_id, $this->characterInfo)) {
			$this->Area->contain(array('Npc', 'Obstacle', 'Tile', 'Map'));
			$area = $this->Area->find('first', array('conditions' => array('Area.id' => $area_id)));
			$this->set('area', $area);
		}
		else {
			$this->render('/pages/view/notfound');
		}
	}

/**
 * View a single Area for admin.
 *
 * This is used when one Area is edit through and ajax call.
 *
 * @param int $area_id the ID of the area to render
 *
 * @return renders a Area view
 */
	function admin_view($area_id = null) {
		$this->helpers[] = 'World';
		$someArea = $this->Area->find('first', array('conditions' => array('Area.id' => $area_id)));
		if(empty($someArea)) {
			$this->render(false);
			return false;
		}
		$this->set('area', $someArea);
	}

/**
 * Add a new side lines of Areas to a Map.
 *
 * @param int $map_id the ID of the map
 * @param string $direction the side of the new Areas (right,left,bottom,top)
 *
 * @return redirects to /admin/maps
 */
	function admin_add($map_id = null, $direction = 'right') {
		if(!isset($map_id) || empty($map_id)) {
			$this->redirect('/admin/maps');
		}
		// Get the map
		$map = $this->Area->Map->find('first', array('conditions' => array('Map.id' => $map_id)));
		if(empty($map)) {
			$this->redirect('/admin/maps');
		}

		// Get the x and y as of the map
		$mapInfo = $this->Area->Map->mapInfo($map['Map']['id']);
		// Add a row of areas to a direction of the map
		$index = 0;
		$this->data = array();
		switch($direction) {

			case 'right':
			for($i = 0; $i < $mapInfo['y']; $i++) {
				$this->data['Area'][$index]['access'] = 1;
				$this->data['Area'][$index]['x'] = $mapInfo['x'] + 1;
				$this->data['Area'][$index]['y'] = $i + 1;
				$this->data['Area'][$index]['tile_id'] = 1;
				$this->data['Area'][$index]['map_id'] = $map['Map']['id'];
				$index++;
			}
			$this->Area->saveAll($this->data['Area']);
			break;

			case 'bottom':
			for($i = 0; $i < $mapInfo['x']; $i++) {
				$this->data['Area'][$index]['access'] = 1;
				$this->data['Area'][$index]['y'] = $mapInfo['y'] + 1;
				$this->data['Area'][$index]['x'] = $i + 1;
				$this->data['Area'][$index]['tile_id'] = 1;
				$this->data['Area'][$index]['map_id'] = $map['Map']['id'];
				$index++;
			}
			$this->Area->saveAll($this->data['Area']);
			break;

			case 'top':
			$this->Area->updateAll(array('Area.y' => 'Area.y + 1'), array('Area.map_id' => $map['Map']['id']));
			for($i = 0; $i < $mapInfo['x']; $i++) {
				$this->data['Area'][$index]['access'] = 1;
				$this->data['Area'][$index]['y'] = 1;
				$this->data['Area'][$index]['x'] = $i + 1;
				$this->data['Area'][$index]['tile_id'] = 1;
				$this->data['Area'][$index]['map_id'] = $map['Map']['id'];
				$index++;
			}
			$this->Area->saveAll($this->data['Area']);
			break;

			case 'left':
			$this->Area->updateAll(array('Area.x' => 'Area.x + 1'), array('Area.map_id' => $map['Map']['id']));
			for($i = 0; $i < $mapInfo['y']; $i++) {
				$this->data['Area'][$index]['access'] = 1;
				$this->data['Area'][$index]['x'] = 1;
				$this->data['Area'][$index]['y'] = $i + 1;
				$this->data['Area'][$index]['tile_id'] = 1;
				$this->data['Area'][$index]['map_id'] = $map['Map']['id'];
				$index++;
			}
			$this->Area->saveAll($this->data['Area']);
			break;

			default:
			break;
		}
		$this->redirect('/admin/maps/edit/'. $map['Map']['id']);
	}

/**
 * Edits an Area
 *
 * @param int $id the ID of the Area
 */
	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$this->Area->save($this->data);
		}
		else {
			App::import('Model', 'Quest');
			$Quest = new Quest();
			$this->set('quests', $Quest->find('list'));
			$this->data = $this->Area->find('first', array('conditions' => array('Area.id' => $id)));
		}
	}

/**
 * Ajax function to change a Tile on an Area (magic wand tool in admin)
 */
	function admin_change_tile($area_id = null, $tile_id = null, $access = null) {
		$this->render(false);
		$data = array(
			'id' => $area_id,
			'tile_id' => $tile_id,
			'access' => isset($access) && !empty($access) ? $access : null
		);
		$this->Area->save($data);
	}
}
?>