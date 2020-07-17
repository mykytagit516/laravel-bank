<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATMinteractionsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('atm_interactions', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();  
		$table->integer('user_id')->unsigned();
		$table->integer('atm_id')->unsigned();
        $table->string('totalDeposited')->nullable();
		$table->string('C1loaded');
		$table->string('sourceMoney');
		$table->string('CashSourceID');
		$table->string('C1dispensed');
		$table->string('C1remaining');
		$table->string('C1rejects');
		$table->string('C1tests');
		$table->string('C2loaded');
		$table->string('C2dispensed');
		$table->string('C2remaining');
		$table->string('C2rejects');
		$table->string('C2tests');
		$table->string('totalRebankAmount');
        $table->string('type');
        $table->string('filename');
        $table->string('filepath');
        $table->datetime('created_at');
		$table->datetime('updated_at');
		$table->foreign('user_id')->references('id')->on('users');
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
    Schema::drop('atm_interactions');
    DB::table('atm_interactions')->delete();
  }

}
