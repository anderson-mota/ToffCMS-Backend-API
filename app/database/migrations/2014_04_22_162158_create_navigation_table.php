<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('uri')->nullable();
			$table->string('url')->nullable();
			$table->enum('target', array('_self', '_blank'))->default('_self');
			$table->integer('page_id')->nullable();
			$table->enum('language', array('pt', 'en', 'es'));
			$table->enum('type', array('page', 'website', 'uri'));
			$table->integer('parent_id')->nullable();
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
		Schema::drop('navigation');
	}

}
