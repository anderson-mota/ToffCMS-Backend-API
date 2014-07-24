<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetAvailableValuesToNullableOnSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("settings", function(Blueprint $table){
			$table->dropColumn("available_values");
		});
		Schema::table("settings", function(Blueprint $table){
			$table->string("available_values")->nullable();
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
