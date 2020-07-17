<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('contracts', function(Blueprint $table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');
	  $table->integer('atm_id')->unsigned(); 
      $table->date('billingPeriodEnd');
      $table->boolean('fixedPriceContractYN')->nullable();
      $table->boolean('monthlyTransSummaryYN')->nullable();   
      $table->string('lowThreshold')->nullable();
      $table->string('highThreshold')->nullable();
      $table->string('thresholdRate')->nullable();
      $table->string('fixedPriceAmount');  
      $table->datetime('created_at');
      $table->datetime('updated_at');
	  $table->foreign('atm_id')->references('id')->on('atm');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('contracts');
  }

}
