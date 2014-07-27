<?php

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

		return \App\Libraries\RestResponse::success('settings', $return);

	}


}
