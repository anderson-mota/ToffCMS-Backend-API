<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 29/07/2014
 * Time: 17:10
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

namespace App\Libraries;

interface SaveEloquentInterface {
	/**
	 * @param string $action
	 * @return void
	 */
	public function populate($action = 'insert');

	/**
	 * @param $input
	 * @param null $type
	 * @return \Illuminate\Validation\Validator
	 */
	public static function validate($input, $type = null);

	/**
	 * @return bool
	 */
	public function save();

	/**
	 * @return array[]
	 */
	public function toArray();
}