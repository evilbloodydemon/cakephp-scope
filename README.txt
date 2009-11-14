Scope Behavior for CakePHP 1.2

Copyright 2009, Igor Fomin (http://evilbloodydemon.wordpress.com/)
The MIT License (http://www.opensource.org/licenses/mit-license.php)

This behavior allows you define a 'scope' for model that applies then for find and save.
It can be useful, say, for situations when multiple sites use one database and
distinguish their records by special field.

Example:

	var $actsAs = array(
		'Scope.Scope' => array(
			'field' => 'site_id',
			'value' => 1,
		)
	);