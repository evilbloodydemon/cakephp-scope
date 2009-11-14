<?php

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