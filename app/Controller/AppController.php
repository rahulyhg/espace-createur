<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
/* External Libraries */
	require_once APP."Vendor/php-github-api/vendor/autoload.php";
	require_once APP."Vendor/magento-client-php/vendor/autoload.php";
	require_once APP."Vendor/Api/Main.php";

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Session', 'Auth' => array(
		"loginRedirect" => array(
			"controller" => 'Users',
			"action" => "index"
		),
		"logoutRedirect" => array(
			"controller" => "Users",
			"action" => "index"
		),
		"loginAction" => array(
			"controller" => "Users",
			"action" => "logIn"
		),
		"authenticate" => array(
			"Form" => array(
				'fields' => array("username" => "email")
			)
		)
	), 'Cookie', 'RequestHandler');

	function beforeFilter() {
		$this->Auth->allow('*', 'logIn', 'signUp', 'getSales', 'forgotPassword');
		$this->Auth->userModel = 'User';
		if ($this->RequestHandler->isAjax())
			$this->layout = null;

		/* Notifications count */
		if (AuthComponent::user('type') == 0) {
			$conditions = array(
				"isAdmin" => 1,
				"isRead" => 0
			);
			$salesConditions = array(
				"status" => 0
			);
		} else {
			$conditions = array(
				"userId" => AuthComponent::user('id'),
				"isRead" => 0
			);
			$salesConditions = array(
				"status" => 0,
				"creatorId" => AuthComponent::user('id')
			);
		}
		if (AuthComponent::user('id') != 0) {
			$this->loadModel('Notification');
			$this->loadModel('Sales');
			$number = $this->Notification->find('count', array(
				"conditions" => $conditions
			));
			$sales = $this->Sales->find('count', array(
				"conditions" => $salesConditions
			));
			$this->set('Notifications', $number);
			$this->set('Sales', $sales);
		}
	}
}
