<?php

use \app\libraries\ResponseJson;

class GalleryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$galleries = Gallery::with(array('items' => function ($query) {
				$query->orderBy('order_id');
			}))->get();

		return ResponseJson::success('galleries', $galleries->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$gallery = new Gallery;

		// Set up the validator
		$validator = $gallery->validate(Input::all());
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		$gallery->title = Input::get('title');
		$gallery->slug = Input::get('slug');
		$gallery->save();

		return ResponseJson::success('gallery', $gallery->toArray());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$gallery = Gallery::where('slug', $slug)
					->with(array('items' => function ($query) {
						$query->orderBy('order_id');
					}))
					->take(1)
					->first();

		if ($gallery === NULL)
		{
			return ResponseJson::error('message', 'Gallery with this slug doesn\'t exist.');
		}

		return ResponseJson::success('gallery', $gallery->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$gallery = Gallery::find($id);

		// Does the item exist?
		if ($gallery === null || $gallery->exists() === false)
		{
			return ResponseJson::error('message', 'Gallery with this ID doesn\'t exist.');
		}

		// Validate the input
		$validator = $gallery->validate(Input::all());
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		// Set the input
		$gallery->title = Input::get('title');
		$gallery->slug = Input::get('slug');

		// Save
		$gallery->save();

		return ResponseJson::success('gallery', $gallery->toArray());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Gallery::destroy($id);
		return ResponseJson::success('status', true);
	}


}
