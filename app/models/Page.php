<?php

use App\Libraries\SaveEloquentInterface;

/**
 * Class Page
 *
 * @property $id
 * @property $title
 * @property $slug
 * @property $content
 * @property $status
 * @property $language
 * @property $author_id
 */
class Page extends Eloquent implements SaveEloquentInterface {

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
		return Validator::make($input, self::rulesValidate($type));
	}

	/**
	 * @param string|null $type
	 * @return array
	 */
	public static function rulesValidate($type = null)
	{
		$allRules = array(
			'default' => array(
				'title'        => array('required', 'max:100'),
				'slug'         => array('required', 'max:100', 'unique:pages,slug,null,id,language,'. Input::get('language')),
				'status'       => array('required', 'in:draft,live'),
				'language'     => array('required', 'in:pt,en'),
			),
			'update' => array(
				'slug'         => array('required', 'max:100'),
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

	public function author()
	{
		return $this->hasOne('User', 'id', 'author_id')
					->select('id', 'email');
	}

	/**
	 * @param string|null $action
	 * @return void
	 */
	public function populate($action = 'insert')
	{
		$this->title = Input::get('title');
		$this->slug = Input::get('slug', Str::slug($this->title));
		$this->content = Input::get('body');

		if ($action == 'insert') {
			$this->status = Input::get('status', 'draft');
			$this->language = Input::get('language', 'pt');
			$this->author_id = Input::exists("author_id") ? Input::get('author_id') : User::getCurrent()->id;
		} else {
			$this->status = Input::get('status');
			$this->language = Input::get('language');
		}
	}
}
