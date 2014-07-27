<?php
/**
 * Created by PhpStorm.
 * User: Mota
 * Date: 26/07/2014
 * Time: 14:32
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class AuthenticationTest extends TestCase {


	/**
	 * @return array
	 */
	public function providerLogin()
	{
		return [
			["anderson.mota12@gmail.com", "dev123"]
		];
	}

	/**
	 * @dataProvider providerLogin
	 * @param $email
	 * @param $password
	 */
	public function testBasicAuthentication($email, $password)
	{
		$response = $this->action("POST", "LoginController@getApiKey", ['email' => $email, 'password' => $password]);
		$content = json_decode($response->getContent());
		$this->assertResponseStatus(200);
		$this->assertFalse($content->error);
	}

	/**
	 * @dataProvider providerLogin
	 * @param $email
	 */
	public function testFailAuthentication($email)
	{
	    $response = $this->action("POST", "LoginController@getApiKey", ['email' => $email, 'password' => '123456']);
		$content = json_decode($response->getContent());
		$this->assertResponseStatus(406);
		$this->assertTrue($content->error);
	}
}
