<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserToClientsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('userclients', function(Blueprint $table)
    {
		$table->engine = 'InnoDB';
		$table->increments('id')->unsigned();    
		$table->integer('user_id')->unsigned(); 
		$table->integer('client_id')->unsigned();
		$table->datetime('created_at');
		$table->foreign('user_id')->references('id')->on('users');
		$table->foreign('client_id')->references('id')->on('clients');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('userclients');
  }

}
