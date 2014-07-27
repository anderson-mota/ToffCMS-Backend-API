<?php

/**
 * Class Page
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $status
 * @property string $language
 * @property integer $author_id
 */
class Page extends Eloquent {

	protected $table = 'pages';
	protected $hidden = array('updated_at', 'author_id');

	/**
	 * Validate the input
	 * @param  array $input
	 * @param  string $type
	 * @return \Illuminate\Validation\Validator
	 */
	public static function validate($input, $type = null)
	{
		return Validator::make($input, self::rulesValidator($type));
	}

	/**
	 * @param string|null $type
	 * @return array[]
	 */
	protected static function rulesValidator($type = null)
	{
		$allRules = array(
			'default' => array(
				'title'        => array('required', 'max:100'),
				'slug'         => array('required', 'max:100', 'unique:pages,slug,null,id,language,'. Input::get('language')),
				'status'       => array('required', 'in:draft,live'),
				'language'     => array('required', 'in:pt,en'),
			),
			'update' => array(
				'slug'         => array('required|max:100'),
			)
		);

		// Get the default rules
		$rules = $allRules['default'];

		// Marge in the specific rules
		if ($type !== null && isset($allRules[$type]))
		{
			$rules = array_merge($rules, $allRules[$type]);
		}

		return $rules;
	}

	/**
	 * @param string $persistType
	 */
	public function populate($persistType = 'insert'){
		$this->title = Input::get('title');
		$this->slug = Input::get('slug', Str::slug($this->title));
		$this->content = Input::get('content');

		if ($persistType == 'insert') {
			$this->status = Input::get('status', 'draft');
			$this->language = Input::get('language', 'pt');
			$this->author_id = isset(User::getCurrent()->id) ? User::getCurrent()->id : 1;
		} else {
			$this->status = Input::get('status');
			$this->language = Input::get('language');
		}
	}

	/**
	 * @return mixed
	 */
	public function author()
	{
		return $this->hasOne('User', 'id', 'author_id')
					->select('id', 'email');
	}
}
