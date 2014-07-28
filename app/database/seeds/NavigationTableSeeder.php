<?php

class NavigationTableSeeder extends Seeder {

	protected $languages = array(
		'pt',
		'en'
	);

	public function run()
	{
		DB::table('navigation')->delete();

		$i = 0;

		foreach ($this->languages as $lang)
		{
			/** @var Page $page */
			$page = Page::where('language', $lang)->first();

			$parent = Navigation::create(array(
				'name' => 'Home (' . $lang . ')',
				'type' => 'uri',
				'uri' => '',
				'language' => $lang,
				'order_id' => ++$i
			));

			if ($page)
			{
				Navigation::create(array(
					'name' => $page->title . ' (' . $lang . ')',
					'type' => 'page',
					'page_id' => $page->id,
					'language' => $lang,
					'order_id' => ++$i
				));
			}

			Navigation::create(array(
				'name' => 'Google (' . $lang . ')',
				'type' => 'website',
				'target' => '_blank',
				'url' => 'http://www.google.com/',
				'language' => $lang,
				'order_id' => ++$i
			));

			Navigation::create(array(
				'name' => '404 (' . $lang . ')',
				'type' => 'uri',
				'uri' => '/404',
				'language' => $lang,
				'order_id' => ++$i
			));

			for ($j = 1; $j <= rand(2, 6); $j++)
			{
				Navigation::create(array(
					'name' => 'Item #' . $j,
					'type' => 'uri',
					'uri' => '',
					'language' => $lang,
					'order_id' => ++$i,
					'parent_id' => $parent->id,
				));
			}
		}
	}
}
