<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Notifiable;
	
	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function isAdmin(){
		return $this->is_admin;
	}
	public function isModerator(){
		return $this->is_moderator;
	}
	
	public function avatar()
	{
		return $this->hasOne('App\Image', 'user_id');
	}
	
	public function articles()
	{
		return $this->hasMany('App\Article', 'user_id');
	}
}
