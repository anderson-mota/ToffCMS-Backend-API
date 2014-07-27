<?php
/**
 * Created by PhpStorm.
 * User: Mota
 * Date: 27/07/2014
 * Time: 00:35
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

namespace App\Libraries;

use Illuminate\Support\Facades\Response;

class RestResponse extends Response
{
	const codeSuccess = 200;
	const codeError = 406;

	/**
	 * @param string $key
	 * @param mixed $data
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public static function success($key, $data)
	{
		return self::deliver($key, $data, self::codeSuccess);
	}

	/**
	 * @param string $key
	 * @param mixed $data
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public static function error($key, $data)
	{
		return self::deliver($key, $data, self::codeError);
	}

	/**
	 * @param string $key
	 * @param mixed $data
	 * @param int $status
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public static function deliver($key, $data, $status = self::codeSuccess)
	{
		return self::json(array('error' => ($status == self::codeSuccess ? false : true), $key => $data), $status);
	}
}