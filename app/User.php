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
		'name', 'email', 'password', 'is_admin', 'is_moderator'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function isBlessed(){
		return $this->isSuperAdmin() || $this->isAdmin() || $this->isModerator();
	}
	
	public function isSuperAdmin(){
		return $this->is_super_admin;
	}
	
	public function isAdmin(){
		return $this->is_admin;
	}
	public function isModerator(){
		return $this->is_moderator;
	}
	
	public function articles()
	{
		return $this->hasMany('App\Article', 'user_id');
	}
}
