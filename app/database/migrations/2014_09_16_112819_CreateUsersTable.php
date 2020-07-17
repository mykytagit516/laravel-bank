<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function(Blueprint $table)
    {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();          
        $table->string('permission', 15);
        $table->string('fname');
        $table->string('lname');
        $table->string('password');        
        $table->string('email');
        $table->string('mobile');
        $table->string('title')->nullable();
        $table->string('token');
        $table->string('remember_token', 256);
        $table->tinyInteger('published');
        $table->datetime('created_at');
        $table->datetime('updated_at');
    });

    DB::table('users')->insert(
      array(  
          array(  'published' => 1, 
              'fname'=> 'admin',                               
              'lname'=> 'admin',   
              'password'=> Hash::make('password'), 
              'permission'=> 'administrator', 
              'email'=> 'administrator@gmail.com',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));
    DB::table('users')->insert(
      array(  
          array(  'published' => 1, 
              'fname'=> 'master',                               
              'lname'=> 'master',   
              'password'=> Hash::make('password'), 
              'permission'=> 'master', 
              'email'=> 'master@gmail.com',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));  
    DB::table('users')->insert(
      array(  
          array(  'published' => 1, 
              'fname'=> 'manager',                               
              'lname'=> 'manager',   
              'password'=> Hash::make('password'), 
              'permission'=> 'manager', 
              'email'=> 'manager@gmail.com',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));  
    DB::table('users')->insert(
      array(  
          array(  'published' => 1, 
              'fname'=> 'contractor',                               
              'lname'=> 'contractor',   
              'password'=> Hash::make('password'), 
              'permission'=> 'contractor', 
              'email'=> 'contractor@gmail.com',
              'created_at'=> $date = date('Y-m-d H:i:s')), 
              
      ));  
    DB::table('users')->insert(
      array(  
          array(  'published' => 1, 
              'fname'=> 'clients',                               
              'lname'=> 'clients',   
              'password'=> Hash::make('password'), 
              'permission'=> 'client', 
              'email'=> 'clients@gmail.com',
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
    Schema::drop('users');
    DB::table('users')->delete();
  }

}
