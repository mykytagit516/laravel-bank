<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATMtransactionsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('atm_transactions', function(Blueprint $table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');    
      $table->integer('ATM_id')->unsigned(); 
      $table->date('date');
      $table->string('numberTransactions');
      $table->string('amount');
      $table->text('description');
      $table->datetime('created_at');
      $table->foreign('ATM_id')->references('id')->on('atm');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('atm_transactions');
  }

}
