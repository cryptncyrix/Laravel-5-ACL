<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AclRoleHasRessource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles_ressources', function(Blueprint $table)
		{
			$table->integer('role_id')->unsigned();
                        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
		Schema::drop('roles_ressources');
	}

}
