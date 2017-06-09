<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
     * Name should be in title case
     * 
     * @param string $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }

    /**
     * Declares relationship that a role has many users
     * 
     * @return Illuminate\Database\Eloquent
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
