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

	/**
	 * @return void
	 */
	public function testBasicAuthentication()
	{
	    $response =  $this->action("POST", "LoginController@getApiKey", ['email' => "anderson.mota@lqdi.net", 'password' => "dev123"]);
		$content = json_decode($response->getContent());
		$this->assertFalse($content->error);
		$this->assertNotEmpty($content->user->id);
		$this->assertNotEmpty($content->user->email);
		$this->assertNotEmpty($content->user->api_key);
	}

	public function testNegateAuthentication()
	{
		$response =  $this->action("POST", "LoginController@getApiKey", ['email' => "anderson.mota@lqdi.net", 'password' => "xxxxxx"]);
		$content = json_decode($response->getContent());
		$this->assertTrue($content->error);
	}
}
