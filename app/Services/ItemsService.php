<?php

namespace App\Services;

/*
|--------------------------------------------------------------------------
| ItemsService
|--------------------------------------------------------------------------
|
| This is a helper class for managing the CRUD operations regarding items in 
| the inventory
|
*/

use App\Models\Item;

use Exception;
use App\Services\FileUploadManager;
use App\Services\DatetimeParser;

class ItemsService
{
    /**
     * Get a listing of items in the inventory after filtering using all the params 
     * passed in the request
     * 
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return array A collection of items
     */
    public function getItems($request)
    {
        $name = ($request->has('name') && $request->name) ? $request->name : null;
        $color = ($request->has('color') && $request->color) ? $request->color : null;
        $price = ($request->has('price') && $request->price) ? $request->price : null;

        $per_page = ($request->has('per_page') && $request->price) ? $request->per_page : 20;

        $order_field = ($request->has('order_field') && $request->order_field) ? 
            $request->order_field : 'name';
        
        $ranking = ($request->has('ranking_order') && $request->ranking_order) ? 
            $request->ranking_order : 'ASC';

        $query = Item::with('type', 'vendor');
   
        if ($name) {
            $keywords = explode(" ", $name);
            
            foreach ($keywords as $keyword) {
                $query = $query->where('name', 'LIKE', '%'.$keyword.'%');
            }
        }

        $query = $color ? $query->where('color', '=', $color) : $query;
        $query = $price ? $query->where('price', '=', $price) : $query;

        return $query->orderBy($order_field, $ranking)->paginate($per_page);
    }

    /**
     * Add a new item to the inventory.This method is called after all validation
     * has been done by the controller
     * 
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function addItem($request)
    {
        // Correct date format for entry into MySQL
        $date = DateTimeParser::getDateTime($request->release_date);

        // Data for creating a new item
        $data = [
            'name' => $request->name,
            'vendor_id' => $request->vendor_id,
            'type_id' => $request->type_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'serial_number' => $request->serial_number,
            'color' => $request->color,
            'release_date' => $date,
            'tags' => $request->tags,
            'image_url' => ''
        ];

        $item = Item::create($data);

        if ($request->file('image')) {
            $destination = $this->uploadItemImage($item->id, $request->file('image'));

            if ($destination) {
                $item->image_url = $destination;
                $item->save();
            }
        }

        return $item;
    }

    /**
     * Get the item with the given ID
     * 
     * @param  int $item_id The ID of the item to get
     * @return App\Models\Item The item with the given ID or null if not existing
     */
    public function getItem($item_id)
    {
        $item = Item::find($item_id);

        return $item;
    }

    /**
     * Update the given item with new data in the request
     *
     * @param  App\Models\Item $item The item to update
     * @param  Illuminate\Http\Request  $request The HTTP request
     */
    public function updateItem($item, $request)
    {
        // Data for updating item
        $data = [];

        $editables = ['name', 'vendor_id', 'type_id', 'price', 'weight', 'serial_number', 'color', 'release_date', 'tags'];

        foreach ($editables as $editable) {
            if ($request->has($editable)) {
                if ($editable =='release_date') {
                    // Correct date format for entry into MySQL
                    $date = DateTimeParser::getDateTime($request->release_date);

                    $data[$editable] = $date;
                } else {
                    $data[$editable] = $request->$editable;
                }
            }
        }

        $item->update($data);

        if ($request->file('image')) {
            $destination = $this->uploadItemImage($item->id, $request->file('image'));

            if ($destination) {
                $item->image_url = $destination;
                $item->save();
            }
        }

        return $item;
    }

    /**
     * Delete the given item
     * 
     */
    public function deleteItem($item)
    {
        $item->delete();
        // Delete item image
        try {
            unlink(storage_path('app\\'.$item->getOriginal('image_url')));
        } catch (Exception $ex) {

        }
    }

    /**
     * Upload a new image for the item with the given ID
     * 
     * @param  int $item_id  The ID of the item
     * @param  string $uploaded_file The uploaded file
     * @return string $destination The storage path after the image is uploaded
     */
    public function uploadItemImage($item_id, $uploaded_file)
    {
        $file = new FileUploadManager($uploaded_file);

        // Delete existing item image if any
        $item = Item::find($item_id);

        if ($item->image_url) {
            try {
                unlink(storage_path('app\\'.$item->getOriginal('image_url')));
            } catch (Exception $ex) {

            }
        }

        // Name of folder to save item image in
        $path = 'item_images';
        
        // Move the file to the specified folder saving it with name 'item_' 
        // with ID of item appended
        // We also append timestamps to force reload of images by browser after updates
        $name = 'item_'.$item_id.'_'.time();;
        $destination = $file->move($path, $name, 'jpg');
        
        return $destination;
    }
}