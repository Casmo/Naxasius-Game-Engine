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
class Topic extends AppModel {
	var $name = 'Topic';

	var $belongsTo = array(
		'User',
		'Forum'
	);
	var $hasOne = array(
		'FirstReply' => array(
			'className' => 'Reply',
			'order' => array(
				'FirstReply.created ASC'
			),
			'foreignKey' => 'target_id'
		),
		'LastReply' => array(
			'className' => 'Reply',
			'order' => array(
				'LastReply.created DESC'
			),
			'foreignKey' => 'target_id'
		)
	);
	var $hasMany = array('Reply' => array('foreignKey' => 'target_id', 'conditions' => array('Reply.type' => 'topic')));

	var $actsAs = array('Containable');

	var $validate = array(
	    'title' => array(
	    	'alphaNumeric' => array(
            	'rule' => array('minLength', 3),
            	'message' => 'Topic must contain at least 3 characters'
        	)
	    )
	);

}
?>