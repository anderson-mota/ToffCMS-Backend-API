<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 100);
			$table->string('slug', 100)->unique();
			$table->enum('status', array('live', 'draft'));
			$table->timestamps();
		});

		Schema::create('gallery_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->enum('type', array('video', 'image'));
			$table->string('content', 250);
			$table->integer('gallery_id');
			$table->integer('order_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gallery');
		Schema::drop('gallery_items');
	}

}
