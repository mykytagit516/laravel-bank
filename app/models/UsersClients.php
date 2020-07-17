<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UsersClients extends Eloquent {

	protected $table = 'userclients';


	public function setUpdatedAtAttribute($value)
	{
		// Do nothing.
	}
}