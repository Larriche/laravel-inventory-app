<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Name should be in title (pascal) case
     * 
     * @param string $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }

    /**
     * Declares relationship that a user status has many users
     * 
     * @return Illuminate\Database\Eloquent
     */
    public function users()
    {
        return $this->hasMany(User::class, 'status_id');
    }
}
