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
use App\Libraries\SaveRecipeInterface;

/**
 * Class Setting
 *
 * @property String $name
 * @property String $description
 * @property String $key
 * @property String $default
 * @property String $value
 * @property String $available_values
 * @property String $is_public
 * @property String $created_at
 * @property String $updated_at
 */
class Setting extends Eloquent implements SaveRecipeInterface {

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

    /**
     * @param null $type
     * @return \Illuminate\Validation\Validator
     */
    public function validate($type = null)
    {
        $rules = new \App\Libraries\RulesCollection();
        $rules->add('key', ['required', 'max:255'])
            ->add('name', ['required', 'max:255'])
            ->add('description', ['max:255'])
            ->add('default', ['max:255'])
            ->add('value', ['max:255'])
            ->add('available_values', ['max:255'])
            ->add('is_public', ['required', 'max:255']);

        return Validator::make($this->toArray(), $rules->make($type));
    }

    /**
     * @param string $action
     */
    public function populate($action = 'insert')
    {
        $this->name = Input::get('name');
        $this->description = Input::get('description');
        $this->key = Input::get('key');
        $this->default = Input::get('default');
        $this->value = Input::get('value');
        $this->available_values = Input::get('available_values');
        $this->is_public = Input::get('is_public', 'N');
    }
}
