<?php

class PageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$page = Page::with('author')
					->get();

		return static::response('pages', $page->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Set up the validator
		$validator = Page::validate(Input::all());
		if ($validator->fails())
		{
			return static::response('message', $validator->messages()->all(), true);
		}

		$page = new Page;
		$page->title = Input::get('title');
		$page->slug = Input::get('slug');
		$page->body = Input::get('body');
		$page->status = Input::get('status', 'draft');
		$page->language = Input::get('language', 'en');
		$page->author_id = User::getCurrent()->id;

		$page->save();

		return static::response('page', $page->toArray());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$page = Page::where('slug', $slug)
		            ->where('status', 'live')
					->where('language', Input::get('language', 'en'))
					->with('author')
					->take(1)
					->get();

		return static::response('pages', $page->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$page = Page::find($id);

		// Does the page exist?
		if ($page->exists() === false)
		{
			return static::response('message', 'Page with this ID doesn\'t exist.', true);
		}

		// Validate the input
		$validator = Page::validate(Input::all(), 'update');
		if ($validator->fails())
		{
			return static::response('message', $validator->messages()->all(), true);
		}

		// Set the input
		$page->title = Input::get('title');
		$page->slug = Input::get('slug');
		$page->body = Input::get('body');
		$page->status = Input::get('status');
		$page->language = Input::get('language');

		// Save
		$page->save();

		return static::response('page', $page->toArray());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Page::destroy($id);
		return static::response('status', true);
	}


}
