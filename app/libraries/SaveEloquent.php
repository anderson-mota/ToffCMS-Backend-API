<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 29/07/2014
 * Time: 16:50
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

namespace App\Libraries;

class SaveEloquent {

	/** @var bool */
	private static $isUpdate = false;

	/**
	 * @param SaveEloquentInterface $builder
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function insert(SaveEloquentInterface $builder)
	{
		$builder->populate(self::$isUpdate ? "update" : __FUNCTION__);

		// Set up the validator
		$validator = $builder::validate($builder->toArray(), self::$isUpdate ? "update" : __FUNCTION__);
		if ($validator->fails())
		{
			return ResponseJson::error('message', $validator->messages()->all());
		}

		$builder->save();

		return ResponseJson::success(strtolower(get_class($builder)), $builder->toArray());
	}

	/**
	 * @param SaveEloquentInterface $builder
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function update(SaveEloquentInterface $builder)
	{
		// Does the page exist?
		if (!isset($builder->id))
		{
			return ResponseJson::error('message', 'Page with this ID doesn\'t exist.');
		}

		self::$isUpdate = true;

		return self::insert($builder);
	}

}