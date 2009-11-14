<?php

class ScopeBehavior extends ModelBehavior {
	private $_settings = array();

	function setup($model, $settings = array()) {
		$this->_settings[$model->alias] = $settings;
	}

	function beforeFind($model, $query) {
		$options = $this->_settings[$model->alias];
		$conditions = array(
			"{$model->alias}.{$options['field']}" => $options['value'],
		);

		$query['conditions'] = Set::merge($query['conditions'], $conditions);
		return $query;
	}
}