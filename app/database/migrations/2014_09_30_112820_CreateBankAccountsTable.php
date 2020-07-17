<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bank_accounts', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();  
		$table->integer('user_id')->unsigned();
		$table->integer('bank_id')->unsigned();
        $table->string('accountNumber');
        $table->string('accountName');
		$table->datetime('created_at');
		$table->datetime('updated_at');
		$table->foreign('user_id')->references('id')->on('users');
		$table->foreign('bank_id')->references('id')->on('banks');
    });    
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('bank_accounts');
    DB::table('bank_accounts')->delete();
  }

}
