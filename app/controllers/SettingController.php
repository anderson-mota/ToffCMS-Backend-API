<?php

use App\Libraries\ResponseJson;
use App\Libraries\SaveRecipe;

class SettingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$settings = Setting::where('is_public', 'Y')
							->get();

		return ResponseJson::success('settings', $settings->toArray());
	}

    public function store()
    {
        return SaveRecipe::insert(new Setting);
    }

	/**
	 * @param string $key
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($key)
	{
	    $setting = Setting::where('key', $key)->first();
		return ResponseJson::success('settings', $setting->toArray());
	}
}
