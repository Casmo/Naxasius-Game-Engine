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
class News extends AppModel {
	var $name = 'News';
	var $belongsTo = array('User');
	var $hasMany = array('Reply' => array('foreignKey' => 'target_id', 'conditions' => array('Reply.type' => 'news'), 'order' => array('Reply.created ASC')));

	var $actsAs = array('Containable');
}
?>