<?php

use App\Libraries\ResponseJson;

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

		return ResponseJson::success('pages', $page->toArray());
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
			return ResponseJson::error('message', $validator->messages()->all());
		}

		$page = new Page;
		$page->title = Input::get('title');
		$page->slug = Input::get('slug');
		$page->body = Input::get('body');
		$page->status = Input::get('status', 'draft');
		$page->language = Input::get('language', 'en');
		$page->author_id = User::getCurrent()->id;

		$page->save();

		return ResponseJson::success('page', $page->toArray());
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

		return ResponseJson::success('pages', $page->toArray());
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
			return ResponseJson::error('message', 'Page with this ID doesn\'t exist.');
		}

		// Validate the input
		$validator = Page::validate(Input::all(), 'update');
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		// Set the input
		$page->title = Input::get('title');
		$page->slug = Input::get('slug');
		$page->body = Input::get('body');
		$page->status = Input::get('status');
		$page->language = Input::get('language');

		// Save
		$page->save();

		return ResponseJson::success('page', $page->toArray());
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
		return ResponseJson::success('status', true);
	}


}
