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
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
	var $name = 'User';

	var $hasMany = array('Character');

	var $actsAs = array('Containable');

	function __construct() {
		parent::__construct();
		$this->validate = array (
			'username' => array (
				'notEmpty' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Fill in a username' ,true)
				),
				'isUnique' => array (
					'rule' => 'isUnique',
					'message' => __('Username already exists', true)
				),
				'alphaNumeric' => array (
					'rule' => 'alphaNumeric',
					'message' => __('Use characters and numbers only', true)
				)
			),
			'email' => array (
				'notEmpty' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => __('Fill in a e-mail', true)
				),
				'isUnique' => array (
					'rule' => 'isUnique',
					'message' => __('E-mail already exists', true)
				),
				'email' => array(
					'rule' => 'email',
					'message' => __('Enter a valid e-mail', true)
				)
			)
		);
	}

    public function beforeSave($options = array()) {
        if (!empty($this->data['User']['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data['User']['password'] = $passwordHasher->hash(
                $this->data['User']['password']
            );
        }
        return true;
    }

	/**
	 * Generate a password with an given length
	 * return (string) password
	 */
	function generatePassword($length = 10) {
		$chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','!','@','#','$','%','^','&','*','(',')','-','=','+','_');
		$password = '';
		for($i = 0; $i < $length; $i++) {
			$password .= $chars[rand(0,count($chars)-1)];
		}
		return $password;
	}
}
?>