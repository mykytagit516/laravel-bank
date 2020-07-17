<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankBranchsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bank_branchs', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();  
        $table->integer('bank_id')->unsigned();
        $table->string('bankAddress');
        $table->string('bankPhone');
        $table->string('bankContactName');
        $table->datetime('created_at');
        $table->datetime('updated_at');
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
    Schema::drop('bank_branchs');
    DB::table('bank_branchs')->delete();
  }

}
