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

interface SaveRecipeInterface {
	/**
	 * @param string $action
	 * @return void
	 */
	public function populate($action = 'insert');

	/**
	 * @param null $type
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($type = null);

	/**
	 * @return bool
	 */
	public function save();

	/**
	 * @return array[]
	 */
	public function toArray();
}