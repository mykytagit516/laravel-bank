<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransactionsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bank_transactions', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();  
        $table->integer('bankAccount_id')->unsigned();
        $table->integer('bankBranch_id')->unsigned();
        $table->integer('atm_id')->unsigned();
        $table->string('TotalAmountWithdrawn')->nullable();
        $table->string('TotalAmountDeposited')->nullable();
        $table->date('date')->nullable();
        $table->string('C2')->nullable();
        $table->string('C1')->nullable();
        $table->string('sourceDestination')->nullable();
        $table->string('type');
        $table->string('filename');
        $table->string('filepath');
        $table->datetime('created_at');
        $table->datetime('udpated_at');
        $table->foreign('bankAccount_id')->references('id')->on('bank_accounts');
        $table->foreign('bankBranch_id')->references('id')->on('bank_branchs');
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
    Schema::drop('bank_transactions');
    DB::table('bank_transactions')->delete();
  }

}
