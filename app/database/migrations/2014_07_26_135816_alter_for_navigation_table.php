<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("navigation", function(Blueprint $table){
			$table->dropColumn("title");
			$table->dropColumn("uri");
			$table->dropColumn("url");
			$table->dropColumn("page_id");
			$table->dropColumn("language");
		});
		Schema::table("navigation", function(Blueprint $table){
			$table->string('name');
			$table->string('uri')->nullable();
			$table->string('url')->nullable();
			$table->integer('page_id')->nullable();
			$table->enum('language', array('pt', 'en'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
