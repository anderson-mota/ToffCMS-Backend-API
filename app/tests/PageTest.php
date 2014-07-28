<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 22/07/2014
 * Time: 19:31
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class PageTest extends TestCase {

	/**
	 * @var User
	 */
	private $user;

	/**
	 * Return: E-mail, Password
	 *
	 * @return array[string, string] | E-mail, Password
	 */
	public function providerAuthenticate()
	{
		return [
			["anderson.mota@lqdi.net", "dev123"]
		];
	}

	/**
	 * Return: Title, Slug, Body, Status, Language
	 *
	 * @return array[]
	 */
	public function providerDataPageSuccess()
	{
	    return [
		    ["Agripetas favere, tanquam talis visus.", "agripetas-favere-tanquam-talis-visus",
			    "Processors view from definitions like futile spacecrafts.", "live", "pt"],
		    ["Where is the devastated captain.", "where-is-the-devastated-captain", "Queens wobble from minds like lunar sensors.", "draft",
			    "pt"],
		    ["Harmless nanomachines, to the ready room.", null, "The colorful vogon patiently imitates the kahless.", "live", "pt"],
		    ["Proud sensors lead to the energy.", null, null, "live", "pt"],
		    ["Hur'qs yell with future!", null, "Why does the pathway reproduce?", null, null],
		    ["Wobble wihtout love, and we won’t transform a species.", null, null, null, null],
	    ];
	}

	/**
	 * Return: Title, Slug, Body, Status, Language
	 *
	 * @return array
	 */
	public function providerDataPageFail()
	{
		return [
			[null, null, null, null, null],
			[null, null, "X-ray vision at the alpha quadrant that is when ship-wide parasites warp.", "draft", "pt"],
			["Est secundus vortex, cesaris.", null, "Adiurators favere in rugensis civitas!", null, "zx"],
			["Liberi faveres, tanquam festus boreas.", null, "A falsis, lixa teres hydra.", "public", "pt"],
			["Saga potuss, tanquam fortis diatria. Fidess sunt parmas de lotus adiurator. Cur ad apolloniates nocere?", null, null, null, null],
			["Eheu.", "gloss-ortum-prarere-cito-ducunt-ad-teres-diatria-crescere-inciviliter-ducunt-ad-bassus-mineralis-cur-byssus-prarere",
				null, "draft", "en"],
		];
	}

	/**
	 * @dataProvider providerAuthenticate
	 * @param $email
	 * @param $password
	 */
	public function testBasicAuthentication($email, $password)
	{
		$response = $this->action("POST", "LoginController@getApiKey", ['email' => $email, 'password' => $password]);
		$content = json_decode($response->getContent());
		$this->assertFalse($content->error);
		$this->user = $content->user;
	}

	/**
	 * @param string $title
	 * @param string $slug
	 * @param string $body
	 * @param string $status
	 * @param string $language
	 * @return mixed
	 */
	public function requestStore($title, $slug, $body, $status, $language)
	{
		$response = $this->action("POST", "PageController@store",
			['title' => $title, 'slug' => $slug, 'body' => $body, 'status' => $status, 'language' => $language]);
		return json_decode($response->getContent());
	}

	/**
	 * @dataProvider providerDataPageSuccess
	 * @depends      testBasicAuthentication
	 * @param $title
	 * @param $slug
	 * @param $body
	 * @param $status
	 * @param $language
	 */
	public function testBasicCreate($title, $slug, $body, $status, $language)
	{
		$content = $this->requestStore($title, $slug, $body, $status, $language);

		$this->assertResponseStatus(200);
		$this->assertFalse($content->error, $content->error ? $content->message : null);
		$this->assertEquals($content->page->title, $title);
	}

	/**
	 * @dataProvider providerDataPageFail
	 * @param string $title
	 * @param string $slug
	 * @param string $body
	 * @param string $status
	 * @param string $language
	 */
	public function testFailCreate($title, $slug, $body, $status, $language)
	{
		$content = $this->requestStore($title, $slug, $body, $status, $language);

		$this->assertResponseStatus(406);
		$this->assertTrue($content->error);
	}
}
