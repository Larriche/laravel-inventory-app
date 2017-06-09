<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username','role_id', 'status_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Declare a relationship between a user and his role
     * 
     * @return App\Models\Role The user's role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Declare a relationship between a user and status
     * 
     * @return App\Models\UserStatus The status
     */
    public function status()
    {
        return $this->belongsTo(UserStatus::class);
    }

    
    /**
     * Determines if a user is active
     * 
     * @return boolean
     */
    public function isActivated()
    {
        return strtolower($this->status->name) === 'active';
    }

    /**
     * Determines if a user is pending activation
     * 
     * @return boolean
     */
    public function isPendingActivation()
    {
        return strtolower($this->status->name) === 'pending activation';
    }

    /**
     * Determines if a user account has been made inactive
     *
     * @return  boolean Status of test
     */
    public function isInActive()
    {
        return strtolower($this->status->name) === 'inactive';
    }

    /**
     * Determines if a user is an admin
     * 
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role->name == 'Admin';
    }

    /**
     * Determines if a user is regular user
     * 
     * @return boolean
     */
    public function isUser()
    {
        return $this->role->name == 'User';
    }
}
