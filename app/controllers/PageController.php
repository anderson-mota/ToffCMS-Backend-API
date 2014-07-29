<?php

use App\Libraries\ResponseJson;
use \App\Libraries\SaveEloquent;

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
		return SaveEloquent::insert(new Page);
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

		return SaveEloquent::update($page);
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
