<?php

use App\Libraries\RestResponse;

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

		return RestResponse::success('pages', $page->toArray());
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
			return RestResponse::error('message', $validator->messages()->all());
		}

		$page = new Page;
		$page->populate();

		$page->save();

		return RestResponse::success('page', $page->toArray());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function show($slug)
	{
		/** @var Page $page */
		$page = Page::where('slug', $slug)
		            ->where('status', 'live')
					->where('language', Input::get('language', 'pt'))
					->with('author')
					->take(1)
					->get();

		return RestResponse::success('pages', $page->toArray());
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
			return RestResponse::error('message', 'Page with this ID doesn\'t exist.');
		}

		// Validate the input
		$validator = Page::validate(Input::all(), 'update');
		if ($validator->fails())
		{
			return RestResponse::error('message', $validator->messages()->all());
		}

		// Set the input
		$page->populate(__FUNCTION__);

		// Save
		$page->save();

		return RestResponse::success('page', $page->toArray());
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
		return RestResponse::success('status', true);
	}


}
