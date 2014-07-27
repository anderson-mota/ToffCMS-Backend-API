<?php
/**
 * Created by PhpStorm.
 * User: Mota
 * Date: 27/07/2014
 * Time: 02:40
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class PageTest extends TestCase
{

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
	 * @return array[]
	 */
	public function providerDataPageSuccess()
	{
	    return [
		    ['Cum abactus brevis toruses.', null, 'Fermiums crescere! Racanas favere! Favere foris ducunt ad azureus accola.', 'live', 'pt'],
		    ['Always agreeable shape the secret lord.', "always-agreeable-shape-the-secret-lord", 'Yarr, taste me pirate, ye swashbuckling scallywag!', 'draft', 'pt'],
		    ['The x-ray vision is a harmless c-beam.', null, null, 'draft', 'pt'],
		    ['Abactus de secundus capio, imperium racana.', "abactus-de-secundus-capio-imperium-racana", null, 'live', 'pt'],
		    ['Gloss sunt parss de salvus messor.', null, null, 'live', 'en'],
		    ["Domuss messis in hortus!", "The salty cannibal? Begrudginçly burns the comrade.", "Lagoons die from powers like undead pins.", 'live', 'en'],
		    ["Pol, a bene acipenser.", null, "Pol, a bene repressor, fluctui!", null, 'pt'],
		    ["Cum lacta congregabo, omnes diatriaes imperium fatalis, bi-color castores.", "domina-de-grandis-humani-generis-acquirere-pes", null, 'draft', null],
		    ["Devirginatos sunt fidess de domesticus magister.", null, null, null, null],
	    ];
	}

	/**
	 * @return array[]
	 */
	public function providerDataPageFail()
	{
		return [
			[null, null, null, 'live', 'en'],
			[null, null, null, 'draft', 'zx'],
			[null, "in-hell-all-followers-desire-blessing", null, 'live', 'en'],
			["Est barbatus eleates, cesaris!", "est-barbatus-eleates-cesaris", "Lagoons die from powers like undead pins.", 'soft', 'pt'],
			["Est bassus pars, cesaris!", null, "Orexiss sunt guttuss de brevis homo.", 'soft', 'zx'],
			['Abactus de secundus capio, imperium racana. Nunquam consumere magister. Heu, verpa! Apolloniates brevis zelus est.', null, null, 'live', 'pt'],
			["Brevis bursa.", "sunt-racanaes-dignus-bassus-secundus-torquises-historia-dexter-exsul-est-parmas-mori-in-cirpi-noster-rumor-rare-quaestios-liberi-est", null, 'live', 'en']
		];
	}

	/**
	 * @param string $title
	 * @param string $slug
	 * @param string $content
	 * @param string $status
	 * @param string $language
	 * @return mixed
	 */
	public function requestStore($title, $slug, $content, $status, $language)
	{
		$response = $this->action("POST", "PageController@store", ['title' => $title, 'slug' => $slug, 'content' => $content, 'status' => $status, 'language' => $language]);
		return json_decode($response->getContent());
	}

	/**
	 * @dataProvider providerDataPageSuccess
	 * @param string $title
	 * @param string $slug
	 * @param string $content
	 * @param string $status
	 * @param string $language
	 */
	public function testBasicStore($title, $slug, $content, $status, $language)
	{
		$dataContent = $this->requestStore($title, $slug, $content, $status, $language);

		$this->assertResponseStatus(200);
		$this->assertFalse($dataContent->error, $dataContent->error ? $dataContent->message : null);
	}

	/**
	 * @dataProvider providerDataPageFail
	 * @param $title
	 * @param $slug
	 * @param $content
	 * @param $status
	 * @param $language
	 */
	public function testFailStore($title, $slug, $content, $status, $language)
	{
		$dataContent = $this->requestStore($title, $slug, $content, $status, $language);

		$this->assertResponseStatus(406);
		$this->assertTrue($dataContent->error);
	}
}