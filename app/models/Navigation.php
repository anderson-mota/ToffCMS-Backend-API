<?php

/**
 * Class Navigation
 *
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property string $uri
 * @property string $url
 * @property integer $page_id
 * @property integer $order_id
 * @property string $language
 */
class Navigation extends Eloquent {

	protected $table = 'navigation';
	protected $hidden = array('order_id', 'created_at', 'updated_at', 'page', 'parent_id');
	protected $appends = array('full_url');

	/**
	 * Validate the input
	 * @param  array $input
	 * @param  string $type
	 * @return \Illuminate\Validation\Validator
	 */
	public static function validate($input, $type = null)
	{
		$allRules = array(
			'default' => array(
				'title'        => array('required', 'max:100'),
				'uri'          => array('max:250'),
				'page_id'      => array('integer'),
				'url'          => array('max:250'),
				'target'       => array('in:,_blank'),
				'type'         => array('required', 'in:uri,page,website'),
				'language'     => array('required', 'in:pt,en'),
			),
		);

		// Get the default rules
		$rules = $allRules['default'];

		// Marge in the specific rules
		if ($type !== null && isset($allRules[$type]))
		{
			$rules = array_merge($rules, $allRules[$type]);
		}

		return Validator::make($input, $rules);
	}

	public function populate()
	{
		$this->title = Input::get('title');
		$this->type = Input::get('type');
		$this->uri = Input::get('uri');
		$this->page_id = Input::get('page_id');
		$this->url = Input::get('url');
		$this->target = Input::get('target');
		$this->language = Input::get('language');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function page()
	{
		return $this->hasOne('Page', 'id', 'page_id');
	}

	/**
	 * Get the children of this navigation instance
	 * @return array
	 */
	public function children()
	{
		return $this->hasMany('Navigation', 'parent_id', 'id');
	}

	/**
	 * @param $value
	 * @return int
	 */
	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * @param $value
	 * @return int
	 */
	public function getPageIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * @param $value
	 * @return int
	 */
	public function getParentIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * @param $value
	 * @return int
	 */
	public function getOrderIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * @return null|string
	 * @throws Exception
	 */
	public function getFullUrlAttribute()
	{
		switch ($this->attributes['type'])
		{
			case 'uri':
				return $this->attributes['uri'];

			case 'website':
				return $this->attributes['url'];

			case 'page':
				if ($this->page === null) {
					return null;
				}

				return '/' . $this->page->slug;

			default:
				throw new Exception("Error Processing Request");
		}
	}

	/**
	 * Update the item order
	 * @param  array $items
	 * @param int $parent_id
	 * @return boolean
	 */
	public static function updateOrder(array $items, $parent_id = 0)
	{
		$index = 0;

		foreach ($items as $row)
		{
			// $row = (object) $row;
			Navigation::where('id', '=', $row['id'])
			          ->update(array('order_id' => ++$index, 'parent_id' => $parent_id));

			if ($row['children'])
			{
				self::updateOrder($row['children'], $row['id']);
			}
		}

		return true;
	}

}
