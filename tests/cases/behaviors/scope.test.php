<?php

App::import('Core', array('AppModel', 'Model'));

class User extends CakeTestModel {
	var $name = 'User';

	var $actsAs = array(
		'Scope.Scope'
	);
}
/**
 * @property User $User
 */
class ScopeTest extends CakeTestCase {
	var $fixtures = array(
		'plugin.scope.user'
	);

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	function testFindScoped() {
		$this->User->Behaviors->attach('Scope', array(
			'field' => 'site_id',
			'value' => 1,
		));
		$result = $this->User->find('all');
		$expected = array(
			'evilbloodydemon@gmail.com',
			'vasya-juikin@gmail.com',
			'medvedev@gmail.com',
		);
		$this->assertEqual($expected, Set::extract('/User/email', $result));
	}
}