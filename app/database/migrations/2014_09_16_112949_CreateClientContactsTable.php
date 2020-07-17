<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientContactsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('clientcontacts', function(Blueprint $table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');    
      $table->integer('clients_id')->unsigned(); 
      $table->string('name');
      $table->string('mobile');
      $table->string('phone')->nullable();
      $table->string('email');      
      $table->datetime('created_at');
      $table->datetime('updated_at');
      $table->foreign('clients_id')->references('id')->on('clients');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('clientcontacts');
  }

}
