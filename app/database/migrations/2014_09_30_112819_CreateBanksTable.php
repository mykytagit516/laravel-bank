<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('banks', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();  
        $table->string('bankName');
    		$table->datetime('created_at');
    		$table->datetime('updated_at');
    }); 

      DB::table('banks')->insert(
      array(  
          array( 
              'bankName'=> 'Bank A',              
              'created_at'=> $date = date('Y-m-d H:i:s'),
              'updated_at'=> $date = date('Y-m-d H:i:s')),                        
      ));  

      DB::table('banks')->insert(
      array(  
          array( 
              'bankName'=> 'Bank B',              
              'created_at'=> $date = date('Y-m-d H:i:s'),
              'updated_at'=> $date = date('Y-m-d H:i:s')),                        
      )); 

      DB::table('banks')->insert(
      array(  
          array( 
              'bankName'=> 'Bank C',              
              'created_at'=> $date = date('Y-m-d H:i:s'),
              'updated_at'=> $date = date('Y-m-d H:i:s')),                        
      ));                    
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('banks');
    DB::table('banks')->delete();
  }

}
