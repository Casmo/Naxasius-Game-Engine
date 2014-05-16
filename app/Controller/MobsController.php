<?php
/**
 * Mobs
 *
 * Enemies
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
class MobsController extends AppController {
	var $name = 'Mobs';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Mob.name' => 'asc')
	);

	function admin_index() {
		$mobs = $this->paginate();
		$this->set('mobs', $mobs);
	}

	function admin_add() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Mob']['image']['name']) && !empty($this->request->data['Mob']['image']['name'])) {
				// Upload die shit
				eregi('((.)([A-Z]+))$', $this->request->data['Mob']['image']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Mob']['image']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name);
				$this->request->data['Mob']['image'] = $file_name;
			}
			else {
				unset($this->request->data['Mob']['image']);
			}
			if(isset($this->request->data['Mob']['icon']['name']) && !empty($this->request->data['Mob']['icon']['name'])) {
				// Upload die shit
				eregi('((.)([A-Z]+))$', $this->request->data['Mob']['icon']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Mob']['icon']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name);
				// resize
				App::import('Vendor', 'Image', array('file' => 'image.php'));
				$Image = new Image();
				$Image->resize(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name, WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '32' . DS . $file_name, 32, 32);
				$Image->resize(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name, WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '100' . DS . $file_name, 100, 100);
				$this->request->data['Mob']['icon'] = $file_name;
			}
			else {
				unset($this->request->data['Mob']['icon']);
			}
			$this->Mob->save($this->data);
			$this->redirect('/admin/mobs');
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$someMob = $this->Mob->find('first', array('conditions' => array('Mob.id' => $this->request->data['Mob']['id'])));
			if(isset($this->request->data['Mob']['image']['name']) && !empty($this->request->data['Mob']['image']['name'])) {
				// Oude verwijderen
				if(isset($someMob['Mob']['image']) && !empty($someMob['Mob']['image'])) {
					@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $someMob['Mob']['image']);
				}
				// Upload die shit
				eregi('((.)([A-Z]+))$', $this->request->data['Mob']['image']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Mob']['image']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name);
				$this->request->data['Mob']['image'] = $file_name;
			}
			else {
				unset($this->request->data['Mob']['image']);
			}
			if(isset($this->request->data['Mob']['icon']['name']) && !empty($this->request->data['Mob']['icon']['name'])) {
				// Oude verwijderen
				if(isset($someMob['Mob']['icon']) && !empty($someMob['Mob']['icon'])) {
					@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $someMob['Mob']['icon']);
					@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '32' . DS . $someMob['Mob']['icon']);
					@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '100' . DS . $someMob['Mob']['icon']);
				}
				// Upload die shit
				eregi('((.)([A-Z]+))$', $this->request->data['Mob']['icon']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Mob']['icon']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name);
				// resize
				App::import('Vendor', 'Image', array('file' => 'image.php'));
				$Image = new Image();
				$Image->resize(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name, WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '32' . DS . $file_name, 32, 32);
				$Image->resize(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $file_name, WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '100' . DS . $file_name, 100, 100);
				$this->request->data['Mob']['icon'] = $file_name;
			}
			else {
				unset($this->request->data['Mob']['icon']);
			}
			if($this->Mob->save($this->data)) {
				foreach($this->request->data['MobsStat'] as $index => $MobsStat) {
					if($MobsStat['check'] != 1) {
						unset($this->request->data['MobsStat'][$index]);
					}
					else {
						$this->request->data['MobsStat'][$index]['mob_id'] = $id;
					}
				}
				$this->Mob->MobsStat->deleteAll(array('mob_id' => $id));
				$this->Mob->MobsStat->saveAll($this->request->data['MobsStat']);
				foreach($this->request->data['ItemsMob'] as $index => $ItemsMob) {
					if($ItemsMob['check'] != 1) {
						unset($this->request->data['ItemsMob'][$index]);
					}
					else {
						$this->request->data['ItemsMob'][$index]['mob_id'] = $id;
						$this->request->data['ItemsMob'][$index]['chance'] = $this->request->data['ItemsMob'][$index]['chance'] * 100;
					}
				}
				$this->Mob->ItemsMob->deleteAll(array('mob_id' => $id));
				$this->Mob->ItemsMob->saveAll($this->request->data['ItemsMob']);
			}
			$this->redirect('/admin/mobs');
		}

		$this->loadModel('Quest');
		$this->set('stats', $this->Mob->Stat->find('list'));
		$this->set('quests', $this->Quest->find('list'));
		$this->set('items', $this->Mob->Item->find('list'));
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->data = $this->Mob->find('first', array('conditions' => array('Mob.id' => $id)));
	}

	function admin_delete($id = null) {
		$someMob = $this->Mob->find('first', array('conditions' => array('Mob.id' => $id)));
		if(isset($someMob['Mob']['image']) && !empty($someMob['Mob']['image'])) {
			@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $someMob['Mob']['image']);
		}
		if(isset($someMob['Mob']['icon']) && !empty($someMob['Mob']['icon'])) {
			@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . 'org' . DS . $someMob['Mob']['icon']);
			@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '32' . DS . $someMob['Mob']['icon']);
			@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'mobs' . DS . '100' . DS . $someMob['Mob']['icon']);
		}
		$this->Mob->delete($id);
		$this->redirect('/admin/mobs');
	}
}
?>