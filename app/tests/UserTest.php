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

    public static $data;

	/**
	 * @return array[]
	 */
	public function providerDataSuccess()
	{
	    return [
		    ["test%s@lqdi.net", "q1w2e3r4%s"],
		    ["test%s@test.com", "qwe123@!?a%s"],
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
     */
    public function testBasicCreate($email, $password)
    {
        $user = $this->createBasic(sprintf($email, uniqid("_")), $password);
        $this->assertNotEmpty($user->id);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|stdClass
     */
    public function createBasic($email, $password)
    {
        $response = $this->action("POST", "UserController@store",
            ['email' => $email, 'password' => $password, 'password_confirmation' => $password]);
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? join("\n",  $content->message) : null);

        return $content->user;
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

    /**
     * @dataProvider providerDataSuccess
     * @param string $email
     * @param string $password
     */
    public function testBasicUpdate($email, $password)
    {
        $user = $this->createBasic(sprintf($email, uniqid("_")), $password);
        $this->assertNotEmpty($user->id);
        $response = $this->action("PUT", "UserController@update", ['user' => $user->id, 'email' => sprintf($email, uniqid("_"))]);
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? join("\n",  $content->message) : null);
        $this->assertEquals($content->user->id, $user->id);
        $this->assertNotEquals($content->user->email, $user->email);

        $newPassword = sprintf($password, uniqid("_"));
        $response = $this->action("PUT", "UserController@update",
            ['user' => $user->id, 'email' => $email, 'password' => $newPassword, 'password_confirmation' => $newPassword]);
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? join("\n",  $content->message) : null);
    }
}
