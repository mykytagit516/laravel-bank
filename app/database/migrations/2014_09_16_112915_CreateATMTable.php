<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATMTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('atm', function(Blueprint $table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');    
      $table->integer('clients_id')->unsigned(); 
      $table->string('terminalID');
      $table->string('name');
      $table->string('totalTransactions')->nullable();
	  $table->string('modem');
	  $table->date('startDate');
	  $table->string('serial');
	  $table->string('address');
	  $table->string('site');
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
    Schema::drop('atm');
  }

}
