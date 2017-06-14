<?php

namespace App\Services;

/*
|--------------------------------------------------------------------------
| StatisticsService
|--------------------------------------------------------------------------
|
| This is a helper class for getting stats data to display on dashboard
|
*/

use DB;
use App\Models\Item;
use App\Models\Type;
use App\Models\Vendors;

class StatisticsService
{
	/**
	 * Returns item type - percentage items pairs
	 * 
	 * @return array Item Percentage Item pairs
	 */
	public static function getItemsByTypes()
	{
		$data = [];

		$items_count = count(Item::all());

		if (!$items_count) {
			return $data;
		};

		$types = Type::all();

		foreach ($types as $type) {
			$data[$type->name] =  round((double)(count($type->items)) / (double)$items_count  * 100, 2);
		}

		return $data;
	}

    /**
	 * Returns the average price of all items
	 * 
	 * @return double average_price
	 */
	public static function getAveragePrice()
	{
		$total_price = 0;

		$prices = Item::pluck('price');

		if (!count($prices)) {
			return 0;
		}

		foreach( $prices as $price){
			$total_price += (double)$price;
		}

		return number_format($total_price / (double)count(Item::all()), 2, '.', ',');
	}
}
	