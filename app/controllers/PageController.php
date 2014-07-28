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
		$page = new Page;
		$page->populate('insert');

		// Set up the validator
		$validator = Page::validate($page->toArray());
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

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
		/** @var Page $page */
		$page = Page::find($id);

		// Does the page exist?
		if ($page->exists() === false)
		{
			return ResponseJson::error('message', 'Page with this ID doesn\'t exist.');
		}

		// Set the input
		$page->populate();

		// Validate the input
		$validator = Page::validate($page->toArray(), 'update');
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

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
