<?php

namespace App\Models;

use URL;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    /**
     * Create a relationship between an item and its type
     * 
     * @return App\Models\Type
     */
    public function type()
    {
    	return $this->belongsTo(Type::class, 'type_id');
    }

    /**
     * Create a relationship between an item and its vendor
     * 
     * @return App\Models\Vendor
     */
    public function vendor()
    {
    	return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Mutator for returning full server path to uploaded item images
     * 
     * @param  string $value The image path as stored in the DB
     * @return string The mutated value
     */
    public function getImageUrlAttribute($value)
    {
        return $value ? URL::asset(Storage::url($value)) : null;
    }
}
