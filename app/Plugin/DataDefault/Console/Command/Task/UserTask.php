<?php
/**
 * Insert User Task
 *
 * @copyright    copyright 2012 Passbolt.com
 * @license      http://www.passbolt.com/license
 * @package      app.plugins.DataDefault.Console.Command.Task.UserTask
 * @since        version 2.12.11
 */

require_once(ROOT . DS . APP_DIR . DS . 'Console' . DS . 'Command' . DS . 'Task' . DS . 'ModelTask.php');

App::uses('User', 'Model');

class UserTask extends ModelTask {

	public $model = 'User';

	public static function getAlias() {

		$aliases = array (
			'adm' => Common::uuid('user.id.admin'),
			'ano' => Common::uuid('user.id.anonymous'),
		);
		return $aliases;
	}
	
	protected function getData() {
		// admin
		$us[] = array('User' => array(
			'id' => Common::uuid('user.id.admin'),
			'username' => 'admin@passbolt.com',
			'role_id' => Common::uuid('role.id.admin'),
			'password' => 'password',
			'active' => 1,
			'created_by' => Common::uuid('user.id.admin')
		));

		// anonymous user
		$us[] = array('User' => array(
			'id' => Common::uuid('user.id.anonymous'),
			'username' => 'anonymous@passbolt.com',
			'role_id' => Common::uuid('role.id.anonymous'),
			'password' => 'password',
			'active' => 1,
			'created_by' => Common::uuid('user.id.admin')
		));

		return $us;
	}
}