<?php

Use app\libraries\ResponseJson;

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

		$return = array();

		foreach ($settings as $setting)
		{
			$return[$setting->key] = $setting->value;
		}

		return ResponseJson::success('settings', $return);
	}
}
