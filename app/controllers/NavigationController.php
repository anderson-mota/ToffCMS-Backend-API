<?php

use App\Libraries\ResponseJson;

class NavigationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$nav = Navigation::where('parent_id', 0)
					->with('children')
					->orderBy('order_id')
					->get();

		return ResponseJson::success('navigation', $nav->toArray());
	}


	/**
	 * Save the order
	 * @return Response
	 */
	public function saveOrder()
	{
		Navigation::updateOrder(Input::get('data'));
		return ResponseJson::success('message', 'Successfully saved the order');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Set up the validator
		$validator = Navigation::validate(Input::all());
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		$nav = new Navigation;
		$nav->title = Input::get('title');
		$nav->type = Input::get('type');
		$nav->uri = Input::get('uri');
		$nav->page_id = Input::get('page_id');
		$nav->url = Input::get('url');
		$nav->target = Input::get('target');
		$nav->language = Input::get('language');

		$nav->save();

		return ResponseJson::success('page', $nav->toArray());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  string $language
	 * @return Response
	 */
	public function show($language)
	{
		$nav = Navigation::where('language', $language)
					->where('parent_id', 0)
					->with('children')
					->orderBy('order_id')
					->get();

		return ResponseJson::success('navigation', $nav->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nav = Navigation::find($id);

		// Does the item exist?
		if ($nav === null || $nav->exists() === false)
		{
			return ResponseJson::error('message', 'Navigation instance with this ID doesn\'t exist.');
		}

		// Validate the input
		$validator = Navigation::validate(Input::all(), 'update');
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		// Set the input
		$nav->title = Input::get('title');
		$nav->type = Input::get('type');
		$nav->uri = Input::get('uri');
		$nav->page_id = Input::get('page_id');
		$nav->url = Input::get('url');
		$nav->target = Input::get('target');
		$nav->language = Input::get('language');

		// Save
		$nav->save();

		return ResponseJson::success('page', $nav->toArray());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Navigation::destroy($id);
		return ResponseJson::success('status', true);
	}

}
