<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEloquentStorageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Build the table
        Schema::create('oauth_data', function($table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->text('service');
            $table->text('status');
            $table->text('token');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop the token table
		Schema::drop('oauth_data');
	}

}
