<?php

/**
 * Class Setting
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $key
 * @property string $default
 * @property string $value
 * @property string $available_values
 * @property string $is_public
 */
class Setting extends Eloquent {

	protected $table = 'settings';
	protected $visible = array('key', 'value');

	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	public function getValueAttribute($value)
	{
		return empty($value) ? $this->attributes['default'] : $value;
	}

}
