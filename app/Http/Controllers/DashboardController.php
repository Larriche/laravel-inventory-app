<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Item;
use App\Models\User;

use Illuminate\Http\Request;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    public function index()
    {
    	$users = User::all();
    	$vendors = Vendor::all();
    	$items = Item::all();
        $latest_items = Item::orderBy('created_at', 'DESC')->take(5)->get();
    	$average_price = StatisticsService::getAveragePrice();
    	return view('dashboard.index', compact('vendors', 'items', 'users', 'average_price', 'latest_items'));
    }

    public function getItemsPercentages()
    {
    	return StatisticsService::getItemsByTypes();
    }
}
