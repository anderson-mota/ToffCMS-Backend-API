<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForSettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("settings", function(Blueprint $table){
			$table->dropColumn("description");
			$table->dropColumn("available_values");
			$table->dropColumn("value");
		});
		Schema::table("settings", function(Blueprint $table){
			$table->string('description')->nullable();
			$table->string('available_values')->nullable();
			$table->string('value')->nullable();
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
