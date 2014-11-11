<?php

use App\Libraries\ResponseJson;

class GalleryItemController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Upload an image
	 *
	 * @return Response
	 */
	public function upload()
	{
		$gallery = Gallery::find(Input::get('id'));

		if ($gallery === NULL)
		{
			return ResponseJson::error('message', array('Gallery with the given ID doesn\'t exist.'));
		}

		$destinationPath = Config::get('assets.images.paths.input');
		$file = Input::file('file');

		if (!is_a($file, 'Symfony\Component\HttpFoundation\File\UploadedFile'))
		{
			return ResponseJson::error('message', array('Unknown error occurred.'));
		}

		$validator = Validator::make(
			array('file' => $file),
			array('file' => 'required|mimes:jpeg,png,jpg|image|max:2048')
		);

		if ($validator->passes() === false)
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		$filename = str_random(8) . '.' . $file->guessExtension();

		$status = $file->move(
			Config::get('assets.images.paths.input'),
			$filename
		);

		if (!$status)
		{
			return ResponseJson::error('message', 'File upload failed');
		}

		$item = new Gallery_Item;
		$item->gallery_id = $gallery->id;
		$item->content = $filename;
		$item->type = 'image';
		$item->save();

		return ResponseJson::success('item', $item->toArray());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Gallery_Item::destroy($id);
		return ResponseJson::success('status', true);
	}


	/**
	 * Save the order
	 * @return Response
	 */
	public function saveOrder()
	{
		Gallery_Item::updateOrder(Input::get('data'));
		return ResponseJson::success('message', 'Successfully saved the order');
	}


}
