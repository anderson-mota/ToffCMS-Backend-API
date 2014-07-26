<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("pages", function(Blueprint $table){
			$table->dropColumn('body');
			$table->dropColumn('language');
		});
		Schema::table("pages", function(Blueprint $table){
			$table->text('content')->nullable();
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
