<?php
/**
 * Scope Behavior for CakePHP 1.2
 *
 * @copyright     Copyright 2009, Igor Fomin (http://evilbloodydemon.wordpress.com/)
 * @link          http://github.com/evilbloodydemon/cakephp-scope/
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * This behavior allows you define a 'scope' for model that applies then for find and save.
 * It can be useful, say, for situations when multiple sites use one database and
 * distinguish their records by special field.
 *
 * Example:
 *
 *	var $actsAs = array(
 *		'Scope.Scope' => array(
 *			'field' => 'site_id',
 *			'value' => 1,
 *		)
 *	);
 */
 
class ScopeBehavior extends ModelBehavior {
	function setup($model, $settings = array()) {
		if(!isset($settings['field']) || !isset($settings['value'])) {
			$error = sprintf('ScopeBehavior: invalid params for model %s', $model->alias);
			trigger_error($error, E_USER_WARNING);
		}
		$this->settings[$model->alias] = $settings;
	}

	function beforeFind($model, $query) {
		$options = $this->settings[$model->alias];
		$conditions = array(
			"{$model->alias}.{$options['field']}" => $options['value'],
		);

		$query['conditions'] = Set::merge($query['conditions'], $conditions);
		return $query;
	}

	function beforeSave($model) {
		$options = $this->settings[$model->alias];
		$model->data[$model->alias][$options['field']] = $options['value'];

		return true;
	}
}