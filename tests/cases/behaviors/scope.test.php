<?php

App::import('Core', array('AppModel', 'Model'));

class User extends CakeTestModel {
	var $name = 'User';

}
/**
 * @property User $User
 */
class ScopeTest extends CakeTestCase {
	var $fixtures = array(
		'plugin.scope.user'
	);

	function startTest() {
		$this->User = ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	function testErrorWithInvalidParams() {
		$this->expectError();
		$this->User->Behaviors->attach('Scope.Scope');
		$this->User->Behaviors->detach('Scope');

		$this->expectError();
		$this->User->Behaviors->attach('Scope.Scope', array(
			'field' => 'site_id',
		));
		$this->User->Behaviors->detach('Scope');

		$this->expectError();
		$this->User->Behaviors->attach('Scope.Scope', array(
			'value' => 1,
		));
		$this->User->Behaviors->detach('Scope');
	}

	function testFindScoped() {
		$this->User->Behaviors->attach('Scope.Scope', array(
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

		$result = $this->User->find('all', array(
			'conditions' => array(
				'User.email' => 'evilbloodydemon@gmail.com',
				'User.site_id' => 2,
			)
		));
		$this->assertTrue(Set::matches('/User[id=1]', $result));
	}

	function testSaveScoped() {
		$this->User->Behaviors->attach('Scope.Scope', array(
			'field' => 'site_id',
			'value' => 2,
		));
		$this->User->save(array(
			'User' => array(
				'email' => 'newuser@gmail.com',
			),
		));
		$result = $this->User->find('all');
		$expected = array(
			'evilbloodydemon@gmail.com',
			'newuser@gmail.com',
		);
		$this->assertEqual($expected, Set::extract('/User/email', $result));
	}

	function testDeleteAllScoped() {
		$this->User->Behaviors->attach('Scope.Scope', array(
			'field' => 'site_id',
			'value' => 2,
		));
		$this->User->deleteAll(array(
			'User.email' => 'evilbloodydemon@gmail.com',
		));
		$this->User->Behaviors->detach('Scope.Scope');
		$this->User->Behaviors->attach('Scope.Scope', array(
			'field' => 'site_id',
			'value' => 1,
		));
		$result = $this->User->find('count', array(
			'conditions' => array(
				'User.email' => 'evilbloodydemon@gmail.com',
			),
		));
		$this->assertTrue($result === 1);
	}
}