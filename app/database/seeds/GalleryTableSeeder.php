<?php

class GalleryTableSeeder extends Seeder {

	public function run()
	{
		DB::table('gallery')->delete();
		DB::table('gallery_items')->delete();

		Gallery::create(array(
			'title' => 'Test',
			'slug' => 'test',
			'status' => 'live'
		));

		Gallery::create(array(
			'title' => 'Test 2',
			'slug' => 'test-2',
			'status' => 'live'
		));

		Gallery_Item::create(array(
			'type' => 'video',
			'content' => 'test',
			'gallery_id' => DB::getPdo()->lastInsertId(),
			'order_id' => 1,
		));
	}

}
