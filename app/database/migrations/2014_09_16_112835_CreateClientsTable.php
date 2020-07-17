<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('clients', function(Blueprint $table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id')->unsigned();    
      $table->string('name');
      $table->string('address');
      $table->string('ABN');
      $table->string('phone');
      $table->string('email');
	  $table->string('region');
      $table->tinyInteger('published');
      $table->datetime('created_at');
      $table->datetime('updated_at');
    });

    DB::table('clients')->insert(
      array(  
          array(  'published' => 1, 
              'name'=> 'Client A',
              'address' => '123 Laidback Dr Byronia NSW',                               
              'ABN'=> '123456789',   
              'phone'=> '0412345678', 
              'email'=> 'clientA@email.com', 
              'region'=> 'Byronia',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));
    DB::table('clients')->insert(
      array(  
          array(  'published' => 1, 
              'name'=> 'Client B',
              'address' => '456 Laidback Dr Byronia NSW',                               
              'ABN'=> '987654321',   
              'phone'=> '0412345678', 
              'email'=> 'clientB@email.com', 
              'region'=> 'Byronia',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('clients');
  }

}
