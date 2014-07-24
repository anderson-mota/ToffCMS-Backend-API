<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUriAndUrlToNullableOnNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('navigation', function(Blueprint $table){
			$table->dropColumn(["uri", "url"]);
		});

		Schema::table('navigation', function(Blueprint $table){
			$table->string('uri')->nullable();
			$table->string('url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
