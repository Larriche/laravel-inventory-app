<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];

    /**
     * Declare a relationship between an item type and items of that
     * type
     * 
     * @return App\Models\Item The items
     */
    public function items()
    {
    	return $this->hasMany(Item::class, 'type_id');
    }
}
