<?php
/**
 * Game world
 *
 * Shows and manage game Maps
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
class MapsController extends AppController {
	var $name = 'Maps';

	var $helpers = array('World');

	var $paginate = array(
		'limit' => 20,
		'order' => array('Map.name' => 'asc')
	);

	function game_index() {
		$areas = $this->Map->getMap($this->characterInfo['area_id']);
		$actions = $this->Map->Area->getActions($this->characterInfo['id'], $this->characterInfo['area_id']);
		$this->set('areas', $areas);
		$this->set('actions', $actions);
	}

	/**
	 * (Admin) overview of all the maps
	 */
 	function admin_index() {
 		$this->layout = 'admin';
 		$this->paginate['contain'] = array();
 		$maps = $this->paginate();
 		$this->set('maps', $maps);
 	}

	/**
	 * (Admin) Add a new map
	 */
 	function admin_add() {
 		if(isset($this->data) && !empty($this->data)) {
 			if(!empty($this->data['Map']['name'])) {
 				$this->data['Map']['description'] = '';
 				$this->Map->bindModel(array('hasMany' => array('Area')));
 				$this->data['Area'][0]['x'] = 1;
 				$this->data['Area'][0]['y'] = 1;
 				$this->data['Area'][0]['tile_id'] = 1;
 				$this->data['Area'][0]['access'] = 1;
 				$this->Map->saveAll($this->data);
 			}
 			$this->redirect('/admin/maps');
 		}
 	}

 	/**
 	 * (Admin) Edit function for editing a map
 	 */
 	function admin_edit($id = null) {
 		if(isset($this->data) && !empty($this->data)) {
			$this->Map->save($this->data);
			$this->redirect('/admin/maps');
 		}
 		else {
	 		if(!isset($id) || empty($id)) {
	 			$this->redirect('/admin/maps');
	 			return false;
	 		}
	 		$map = $this->Map->find('first', array('conditions' => array('Map.id' => $id)));
	 		if(empty($map)) {
	 			$this->redirect('/admin/maps');
	 			return false;
	 		}
			$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
			$this->javascripts[] = '/js/admin/map.js';
	 		$areas = $this->Map->getMap(null, $map['Map']['id']);
	 		$this->data = $map;
	 		$this->set('map', $map);
	 		$this->set('areas', $areas);
 		}
 	}

 	/**
 	 * (Admin) Delete a map and it's areas
 	 */
 	function admin_delete($id = null) {
 		if(isset($id) && !empty($id)) {
 			$this->Map->bindModel(array('hasMany' => array('Area')));
 			$this->Map->Area->deleteAll(array('Area.map_id' => $id));
 			$this->Map->delete($id, true);
 		}
 		$this->redirect('/admin/maps');
 	}

 	/**
 	 * Genereren van een minimap
 	 */
 	function admin_generateminimap($map_id = null) {
 		$someMap = $this->Map->find('first', array('conditions' => array('Map.id' => $map_id)));
 		if(empty($someMap)) {
 			$this->redirect('/admin/maps');
 		}

		App::import('Vendor', 'Image', array('file' => 'image.php'));
		$Image = new Image();
		$mapAreas = $this->Map->getMap(null, $someMap['Map']['id']);
 		// Posities etc berekenen
 		$highest_x = 0;
		$highest_y = 0;
		$areas = array();
		foreach($mapAreas as $area) {
			if($highest_x < $area['Area']['x']) {
				$highest_x = $area['Area']['x'];
			}
			if($highest_y < $area['Area']['y']) {
				$highest_y = $area['Area']['y'];
			}
			$areas[$area['Area']['x']][$area['Area']['y']] = $area;
		}
		$width_org = Configure::read('Game.tile.width') * $highest_x;
		$height_org = Configure::read('Game.tile.height') * $highest_y;

		// Originele grootte
		$im_org = imagecreatetruecolor($width_org, $height_org);
		imageAlphaBlending($im_org, true);
		imageSaveAlpha($im_org, true);
		// Zwarte achtergrond
		//$black = imagecolorallocate($im_org, 0,0,0);
		// Doorlopen van de x,y areas
		for($i = 1; $i <= $highest_x; $i++) {
			for($j = 1; $j <= $highest_y; $j++) {
				// tile plakken op het origineel
				$tile_x = (($i-1) * Configure::read('Game.tile.width'));
				$tile_y = (($j-1) * Configure::read('Game.tile.height'));
				if($tile = @imagecreatefrompng(WWW_ROOT .'img'. DS .'game'. DS .'tiles'. DS . $areas[$i][$j]['Tile']['image'])) {
					imageAlphaBlending($tile, true);
					imageSaveAlpha($tile, true);
					// bool imagecopymerge  (  resource $dst_im  ,  resource $src_im  ,  int $dst_x  ,  int $dst_y  ,  int $src_x  ,  int $src_y  ,  int $src_w  ,  int $src_h  ,  int $pct  )
					imagecopymerge($im_org, $tile, $tile_x, $tile_y, 0, 0, Configure::read('Game.tile.width'), Configure::read('Game.tile.height'), 100);
					imagedestroy($tile);
				}
				// Obstacles...
				foreach($areas[$i][$j]['Obstacle'] as $obstacle) {
					if($im_obstacle = @imagecreatefrompng(WWW_ROOT .'img'. DS .'game'. DS .'obstacles'. DS .$obstacle['image'])) {
						imageAlphaBlending($im_obstacle, true);
						imageSaveAlpha($im_obstacle, true);
						list($o_width, $o_height) = getimagesize(WWW_ROOT .'img'. DS .'game'. DS .'obstacles'. DS .$obstacle['image']);
						$obstacle_x = $tile_x + $obstacle['AreasObstacle']['x'];
						$obstacle_y = $tile_y + $obstacle['AreasObstacle']['y'];
						// bool imagecopymerge  (  resource $dst_im  ,  resource $src_im  ,  int $dst_x  ,  int $dst_y  ,  int $src_x  ,  int $src_y  ,  int $src_w  ,  int $src_h  ,  int $pct  )
						$Image->imagecopymerge_alpha($im_org, $im_obstacle, $obstacle_x, $obstacle_y, 0, 0, $o_width, $o_height);
						imagedestroy($im_obstacle);
					}
				}
			}
		}

		if(!empty($someMap['Map']['image'])) {
			// Oude verwijderen
			@unlink(WWW_ROOT .'img'. DS .'game'. DS .'maps'. DS . 'small'. DS . $someMap['Map']['image']);
			@unlink(WWW_ROOT .'img'. DS .'game'. DS .'maps'. DS . 'big'. DS . $someMap['Map']['image']);
			@unlink(WWW_ROOT .'img'. DS .'game'. DS .'maps'. DS . 'medium'. DS . $someMap['Map']['image']);
		}
		$imageName = md5(uniqid(mt_rand(), true)) .'.png';
		if(imagepng($im_org, WWW_ROOT .'img'. DS . 'game'. DS .'maps'. DS .'original'. DS . $imageName)) {
			// Copies maken
			$Image->resize(WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'original'. DS . $imageName, WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'small'. DS . $imageName, 100, 100);
			$Image->resize(WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'original'. DS . $imageName, WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'medium'. DS . $imageName, 123, 123);
			$Image->resize(WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'original'. DS . $imageName, WWW_ROOT . 'img'. DS .'game'. DS .'maps'. DS . 'big'. DS . $imageName, 250, 250);
		}
		$someMap['Map']['image'] = $imageName;
		$this->Map->save($someMap);
		$this->redirect('/admin/maps');
 	}
}
?>