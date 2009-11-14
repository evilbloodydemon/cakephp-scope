<?php 
class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'email' => array('type'=>'text', 'null' => true, 'default' => null),
		'site_id' => array('type'=>'integer', 'null' => false, 'default' => null),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(
	    array(
			'id' => 1,
			'email' => 'evilbloodydemon@gmail.com',
			'site_id' => 1,
		),
	    array(
			'id' => 2,
			'email' => 'vasya-juikin@gmail.com',
			'site_id' => 1,
		),
	    array(
			'id' => 3,
			'email' => 'medvedev@gmail.com',
			'site_id' => 1,
		),
		array(
			'id' => 4,
			'email' => 'evilbloodydemon@gmail.com',
			'site_id' => 2,
		),
	);
}