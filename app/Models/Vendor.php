<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = [];

    /**
     * Create a relationship between a vendor and the items 
     * sold by her
     * 
     * @return App\Models\Items The items
     */
    public function items()
    {
    	return $this->hasMany(Item::class, 'vendor_id');
    }
}
