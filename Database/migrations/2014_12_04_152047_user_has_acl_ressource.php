<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserHasAclRessource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_ressources', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			                  $table->integer('ressource_id')->unsigned();
                        $table->foreign('ressource_id')->references('id')->on('ressources')->onDelete('cascade');
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
		Schema::drop('users_ressources');
	}

}
