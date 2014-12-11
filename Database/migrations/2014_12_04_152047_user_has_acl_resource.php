<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AclRoleHasResource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles_resources', function(Blueprint $table)
		{
			$table->integer('role_id')->unsigned();
                        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                        $table->integer('resource_id')->unsigned(); 
                        $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
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
		Schema::drop('roles_resources');
	}

}
