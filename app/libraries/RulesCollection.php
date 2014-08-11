<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 08/08/2014
 * Time: 11:54
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

namespace App\Libraries;


class RulesCollection {

    /** @var array */
    public $rules = [];

    /** @var array */
    public $types = [];

    /**
     * @param string $name
     * @param array $rules
     * @return $this
     */
    public function add($name, $rules = [])
    {
        $this->types[] = 'default';
        return $this->addByType('default', $name, $rules);
    }

    /**
     * @param string $type
     * @param string $name
     * @param array $rules
     * @return $this
     */
    public function addByType($type, $name, $rules = [])
    {
        $this->types[] = $type;
        $this->rules[$type][$name] = $rules;
        return $this;
    }

    /**
     * @param string|null $type
     * @return array[]
     */
    public function make($type = null)
    {
        if (!array_key_exists('default', $this->rules)) {
            return $this->rules;
        }

        // Get the default rules
        $rules = $this->rules['default'];

        // Marge in the specific rules
        if ($type !== null && array_key_exists($type, $this->rules))
        {
            $rules = array_merge($rules, $this->rules[$type]);
        }

        return $rules;
    }
}