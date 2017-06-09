<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Item;
use App\Models\User;

use Auth;
use Illuminate\Http\Request;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    /**
     * Create a new instance of the DashboardController
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard page
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        // If logged in user is not an admin,
        // redirect to items page
        if (Auth::user()->isUser()) {
            return redirect('/items');
        }

    	$users = User::all();
    	$vendors = Vendor::all();
    	$items = Item::all();
        $latest_items = Item::orderBy('created_at', 'DESC')->take(5)->get();
    	$average_price = StatisticsService::getAveragePrice();
    	return view('dashboard.index', compact('vendors', 'items', 'users', 'average_price', 'latest_items'));
    }

    /**
     * Return data for drawing graph on dashboard
     * 
     * @return Illuminate\Http\Response
     */
    public function getItemsPercentages()
    {
    	return StatisticsService::getItemsByTypes();
    }
}
