<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel', 'Model');
class Login extends AppModel {
	var $useTable = 'users';
		
	var $name = 'Login';	 

	  var $validate = array(
        'username' => array(
            'rule' => 'alphaNumeric',
            'message' => 'You have not entered your username.'
        ),
        'password' => array(
            'rule' => 'notEmpty',
            'message' => 'You did not enter a password.'
        )
    );
	/*var $validate = array( 
		 'username' => array(array(
	'rule' => 'notEmpty',
            'message' => 'Username Field Required.'
	
		),
	array(
            'rule' => 'alphaNumeric',
            'message' => 'Invalid Username.'
            )
        ),
        'password' => array(array(
	'rule' => 'notEmpty',
            'message' => 'Password Field Required.'
	
		),array(
            'rule' => 'alphaNumeric',
            'message' => 'Invalid Password.'
        )),
    ); */

}
