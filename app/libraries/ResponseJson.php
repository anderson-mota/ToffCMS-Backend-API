<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 22/07/2014
 * Time: 17:33
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

namespace App\Libraries;


class ResponseJson extends \Response {

	/**
	 * @param string $key
	 * @param mixed $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function error($key, $data)
	{
		return self::deliver($key, $data, true);
	}

	/**
	 * @param string $key
	 * @param mixed $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function success($key, $data)
	{
		return self::deliver($key, $data);
	}

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ok()
    {
        return self::json(array('error' => false), 200);
    }

	/**
	 * @param string $key
	 * @param mixed $data
	 * @param bool $error
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function deliver($key, $data, $error = false)
	{
		return self::json(array(
				'error' => $error,
				$key => $data),
			($error ? 406 : 200)
		);
	}

}