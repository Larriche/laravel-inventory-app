<?php

namespace App\Models;

use URL;
use Storage;
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

    /**
     * Mutator for returning full server path to uploaded logo images
     * 
     * @param  string $value The logo path as stored in the DB
     * @return string The mutated value
     */
    public function getLogoUrlAttribute($value)
    {
        return $value ? URL::asset(Storage::url($value)) : null;
    }
}
