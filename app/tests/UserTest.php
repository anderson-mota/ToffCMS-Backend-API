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
		    ["test@lqdi.net", "q1w2e3r4", "q1w2e3r4"],
		    ["test@test.com", "qwe123@!?a", "qwe123@!?a"],
	    ];
	}

	/**
	 * @return array[]
	 */
	public function providerDataFail()
	{
		return [
			[null, "123123", null],
			["foo@test.com", null, null],
			["bar@test.com", "123456", "123c56"],
		];
	}

    /**
     * @dataProvider providerDataSuccess
     * @param string $email
     * @param string $password
     * @param string $confirmation
     */
    public function testBasicCreate($email, $password, $confirmation)
    {
       $response = $this->action("POST", "UserController@store",
            ['email' => $email, 'password' => $password, 'password_confirmation' => $confirmation]);
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? join("\n",  $content->message) : null);
    }

    /**
     * @dataProvider providerDataFail
     * @param string $email
     * @param string $password
     * @param string $confirmation
     */
    public function testFailCreate($email, $password, $confirmation)
    {
        $response = $this->action("POST", "UserController@store",
            ['email' => $email, 'password' => $password, 'password_confirmation' => $confirmation]);
        $content = json_decode($response->getContent());

        $this->assertTrue($content->error);
        $this->assertResponseStatus(406);
    }
}
