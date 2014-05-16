<?php
/**
 * Tiles
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
class TilesController extends AppController {
	var $name = 'Tiles';

	var $helpers = array('Form');

	var $paginate = array(
		'limit' => 50,
		'order' => array('Tile.name' => 'asc'),
		'contain' => array('Group')
	);

	/**
	 * (Admin) overview of all tiles
	 */
	function admin_index() {
		$filters = array();
		if(isset($this->request->data['Group']['id']) && $this->request->data['Group']['id'] != 0) {
			$filters['Group.id'] = $this->request->data['Group']['id'];
		}
		elseif(isset($this->passedArgs['Group.id']) && $this->passedArgs['Group.id'] != 0) {
			$filters['Group.id'] = $this->passedArgs['Group.id'];
		}
		elseif(isset($this->request->data['Group']['id']) && $this->request->data['Group']['id'] == 0) {
			$this->Session->delete('Filters.tiles');
		}
		else {
			$filters = $this->Session->read('Filters.obstacles');
		}
		$tiles = $this->paginate($filters);

		// Check for doubles
		$tileIds = array();
		foreach($tiles as $tile) {
			$tileIds[] = $tile['Tile']['id'];
		}
		$doubleTiles = $this->Tile->find('all', array(
				'fields' => array(
					'Tile.id',
					'COUNT(Tile.sha1) as `doubles`'
				),
				'group' => 'Tile.sha1',
				'conditions' => array(
					'Tile.id' => $tileIds
				)
			)
		);
		// Set the $doubleTiles so we can merge it with $tiles
		$mixedTiles = array();
		foreach($doubleTiles as $tile) {
			$mixedTiles[$tile['Tile']['id']] = $tile[0]['doubles'];
		}
		foreach($tiles as $index => $tile) {
			$tiles[$index]['Tile']['doubles'] = isset($mixedTiles[$tile['Tile']['id']]) ? $mixedTiles[$tile['Tile']['id']] : 0;
		}
		$groups = $this->Tile->Group->find('list', array('conditions' => array('type' => 'tile')));
		$this->set('tiles', $tiles);
		$this->set('filters', $filters);
		$this->set('groups', $groups);
	}

	/*
	 * Function to search for tiles
	 */
	function admin_search() {
		$tiles = array();
		if(isset($this->data) && !empty($this->data)) {
			$tiles = $this->Tile->find('all', array('conditions' => array('Group.id' => $this->request->data['Group']['id'])));
		}
		$this->set('tiles', $tiles);
		$this->set('groups', $this->Tile->Group->find('list', array('conditions' => array('Group.type' => 'tile'))));
	}

	/**
	 * (Admin) add a new tile
	 */
	function admin_add() {
		$this->set('groups', $this->Tile->Group->find('list', array('conditions' => array('Group.type' => 'tile'))));
	}

	/**
	 * (Admin) edit a tile
	 */
	function admin_edit($id = null) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/admin/tiles');
			return false;
		}
		$tile = $this->Tile->find('first', array('conditions' => array('Tile.id' => $id)));
		if(empty($tile)) {
			$this->redirect('/admin/tiles');
			return false;
		}
		$this->set('groups', $this->Tile->Group->find('list', array('conditions' => array('Group.type' => 'tile'))));
		$this->data = $tile;
	}

	/**
	 * (Admin) save a (new) tile
	 */
	function admin_save() {

		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Tile']['id']) && !empty($this->request->data['Tile']['id'])) {
				$tile = $this->Tile->find('first', array('conditions' => array('Tile.id' => $this->request->data['Tile']['id'])));
			}
			if(empty($this->request->data['Tile']['image']['name'])) {
				unset($this->request->data['Tile']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Tile']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Tile']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'game'. DS .'tiles'. DS . $imageName);
				$this->request->data['Tile']['image'] = $imageName;
				if(isset($tile['Tile']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'tiles'. DS . $tile['Tile']['image']);
				}
				$this->request->data['Tile']['sha1'] = sha1_file(WWW_ROOT . 'img'. DS .'game'. DS .'tiles'. DS . $imageName);
			}
			$this->Tile->save($this->data);
			$this->redirect('/admin/tiles');
			return true;
		}
		else {
			$this->redirect('/admin/tiles');
		}
	}


	/**
	 * (Admin) delete an tile
	 */
	function admin_delete($id = null) {
		if(isset($id)) {
			$this->deleteAll($id);
		}
		elseif(isset($this->request->data['Tile']['id'])) {
			$this->deleteAll($this->request->data['Tile']['id']);
		}
		$this->redirect('/admin/tiles');
	}

	function deleteAll($id = null) {
		if(is_array($id)) {
			foreach($id as $tile_id) {
				$this->deleteAll($tile_id);
			}
		}
		elseif(!empty($id)) {
			$tile = $this->Tile->find('first', array('conditions' => array('Tile.id' => $id)));
			if(!empty($tile['Tile']['image'])) {
				@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'tiles'. DS . $tile['Tile']['image']);
			}
			$this->Tile->delete($id);
		}
	}

	function admin_import() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Tile']['save']) && $this->request->data['Tile']['save'] == '1') {
				$saveData = array();
				foreach($this->request->data['Tile']['images'] as $image) {
					if(rename(WWW_ROOT . 'img' . DS . 'admin' . DS . 'tmp' . DS . $image, WWW_ROOT . 'img' . DS . 'game' . DS . 'tiles' . DS . $image)) {
						$sha1 = sha1_file(WWW_ROOT . 'img'. DS .'game'. DS .'tiles'. DS . $image);
						$saveData[] = array('name' => '', 'image' => $image, 'group_id' => $this->request->data['Tile']['group_id'], 'sha1' => $sha1);
					}
				}
				$this->Tile->saveAll($saveData);
				$this->redirect('/admin/tiles');
			}
			else {
				$tile_width = Configure::read('Game.tile.width');
				$tile_height = Configure::read('Game.tile.height');
				$sizes = getimagesize($this->request->data['Tile']['image']['tmp_name']);
				$src_im = imagecreatefrompng($this->request->data['Tile']['image']['tmp_name']);
				$x = $sizes[0] / $tile_width;
				$y = $sizes[1] / $tile_height;
				$imagei = 1;
				$images = array();
				for($i = 0; $i < $x; $i++) {
					for($j = 0; $j < $y; $j++) {
						// Create a new image
						$dest_im  = imagecreatetruecolor($tile_width, $tile_height);
						imagealphablending($dest_im, false);
						imagesavealpha($dest_im, true);
						imagecopyresampled($dest_im, $src_im, 0, 0, ($i * $tile_width)  , ($j * $tile_height), $tile_width  , $tile_height, $tile_width  , $tile_height);
						$imageName = md5(uniqid(mt_rand(), true)) .'.png';
						imagepng($dest_im, WWW_ROOT . 'img' . DS . 'admin'. DS .'tmp'. DS . $imageName);
						$images[] = $imageName;
						$imagei++;
		    		}
				}
				$this->set('images', $images);
			}
		}
		$this->set('groups', $this->Tile->Group->find('list', array('conditions' => array('Group.type' => 'tile'))));
	}

	/*
	 * Merge tiles with the orginal and delete the others...
	 */
	function admin_merge($tile_id = null) {
		$originalTile = $this->Tile->find('first', array('conditions' => array('Tile.id' => $tile_id)));
		if(!empty($originalTile)) {
			App::import('Model', 'Area');
			$Area = new Area();
			// Get the same tiles
			$someTiles = $this->Tile->find('all',
				array(
					'conditions' => array(
						'Tile.sha1' => $originalTile['Tile']['sha1'],
						'Tile.id <>' => $originalTile['Tile']['id']
					)
				)
			);
			$tileIds = array();
			foreach($someTiles as $tile) {
				$tileIds[] = $tile['Tile']['id'];
			}
			$Area->updateAll(
				array('Area.tile_id' => $originalTile['Tile']['id']),
				array('Area.tile_id' => $tileIds)
			);
			$this->deleteAll($tileIds);
		}
		$this->redirect('/admin/tiles');
	}

	// This will give you an index of all the tiles witch you can select...
	function admin_magic_wand() {
		$this->Tile->unbindModelAll();
		$tiles = $this->Tile->find('all');
		$this->set('tiles', $tiles);
	}

}
?>