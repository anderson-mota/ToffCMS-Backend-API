<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 29/07/2014
 * Time: 16:22
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class UserTest extends TestCase {

	/**
	 * @return array[]
	 */
	public function providerDataSuccess()
	{
	    return [
		    ["test@lqdi.net", "q1w2e3r4", sha1("key#99")],
		    ["test@test.com", "qwe123@!?a", sha1("key#123")],
	    ];
	}

	/**
	 * @return array[]
	 */
	public function providerDataFail()
	{
		return [
			[null, "123123", null],
			["foo@test.com", null, sha1("fox@5.4")],
			["bar@test.com", "123456"]
		];
	}

	public function testBasic()
	{
	    $this->assertTrue(true);
	}
}
