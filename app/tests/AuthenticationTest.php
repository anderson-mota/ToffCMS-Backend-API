<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 22/07/2014
 * Time: 15:03
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class AuthenticationTest extends TestCase {

	/** @var  User */
	public static $user;

	/**
	 * @return array[]
	 */
	public function providerAuthenticate()
	{
	    return [
		    ["anderson.mota@lqdi.net", "dev123"]
	    ];
	}

	/**
	 * @dataProvider providerAuthenticate
	 * @param string $email
	 * @param string $password
	 * @return void
	 */
	public function testBasicAuthentication($email, $password)
	{
	    $response = $this->action("POST", "LoginController@getApiKey", ['email' => $email, 'password' => $password]);
		$content = json_decode($response->getContent());
		$this->assertFalse($content->error);
		$this->assertNotEmpty($content->user->id);
		$this->assertNotEmpty($content->user->email);
		$this->assertNotEmpty($content->user->api_key);
		self::$user = $content->user;
	}

	/**
	 * @dataProvider providerAuthenticate
	 * @param string $email
	 * @return void
	 */
	public function testNegateAuthentication($email)
	{
		$response =  $this->action("POST", "LoginController@getApiKey", ['email' => $email, 'password' => "xxxxxx"]);
		$content = json_decode($response->getContent());
		$this->assertTrue($content->error);
	}
}
