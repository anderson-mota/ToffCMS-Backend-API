<?php

use App\Libraries\SaveRecipeInterface;
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
 * @property-read \User $author
 */
class Page extends Eloquent implements SaveRecipeInterface {

	protected $table = 'pages';
	protected $hidden = array('updated_at', 'author_id');

	/**
	 * Validate the input
	 * @param  string $type
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($type = null)
	{
        $rules = new RulesCollection();
        $rules->add('title', ['required', 'max:100'])
            ->add('slug', ['required', 'max:100', 'unique:pages,slug,null,id,language,'. Input::get('language')])
            ->add('status', ['required', 'in:draft,live'])
            ->add('language', ['required', 'in:pt,en'])
            ->addByType('update', 'slug', ['required', 'max:100']);

		return Validator::make($this->toArray(), $rules->make($type));
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
		$this->content = Input::get('content');

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
