<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'name',
        'email',
        'password',
        'is_admin',
        'is_moderator',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * Check if user has at least admin, moderator or super-admin role.
     * @return bool
     */
    public function isBlessed(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isModerator();
    }
    
    /**
     * Check if user has super admin role.
     * @return mixed
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }
    
    /**
     * Check if user has admin role.
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    
    /**
     * Check if user has moderator role.
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->is_moderator;
    }
    
    /**
     * Relationship with articles.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany('App\Article', 'user_id');
    }
}
