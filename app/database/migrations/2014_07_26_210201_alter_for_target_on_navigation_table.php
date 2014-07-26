<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForTargetOnNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("navigation", function(Blueprint $table){
			$table->dropColumn("target");
		});
		Schema::table("navigation", function(Blueprint $table){
			$table->enum('target', array('_self', '_blank'))->default('_self');
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
