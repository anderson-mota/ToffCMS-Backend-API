<?php

use App\Libraries\SaveEloquentInterface;
use App\Libraries\RulesCollection;

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
        $rules = new RulesCollection();
        $rules->add('title', ['required', 'max:100'])
            ->add('slug', ['required', 'max:100', 'unique:pages,slug,null,id,language,'. Input::get('language')])
            ->add('status', ['required', 'in:draft,live'])
            ->add('language', ['required', 'in:pt,en'])
            ->addByType('update', 'slug', ['required', 'max:100']);

		return Validator::make($input, $rules->make($type));
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
