@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('page_title')
    Dashboard
@endsection

@section('content') 
	<div class="row">
	    <div class="col-md-12 col-lg-12 col-sm-12">
		    <div class="row tile_count">
		        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		            <span class="count_top"><i class="fa fa-institution"></i> Vendors</span>
		            <div class="count">{{ count($vendors) }}</div>
		        </div>

		        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		            <span class="count_top"><i class="fa fa-gift"></i> Items</span>
		            <div class="count">{{ count($items) }}</div>
		        </div>

		        <div class="col-md-3 col-sm-5 col-xs-6 tile_stats_count">
		            <span class="count_top"><i class="fa fa-money"></i> Average Price</span>
		            <div class="count">${{ $average_price }}</div>
		        </div>

		        <div class="col-md-3 col-sm-5 col-xs-6 tile_stats_count">
		            <span class="count_top"><i class="fa fa-user"></i> Users</span>
		            <div class="count">{{ count($users) }}</div>
		        </div>
		    </div> 
        </div>
	</div>

	<div class="row">
        <div class="col-md-12 col-lg-12 col-sm-6 col-xs-6">
            <div class="dashboard_graph">
                <div class="row x_title">
                    <div class="col-md-12 col-lg-12 col-sm-6">
                        <h3>Item Types</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="item-percentages" class="demo-placeholder" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-6 col-xs-6">
            <div class="row x_title">
                <div class="col-md-12 col-lg-12 col-sm-6">
                    <h3>Latest Items</h3>
                </div>
            </div>

            <table class="table table-bordered">
                <tr>
                    <td colspan="2">Item</td>
                    <td colspan="2">Vendor</td>
                    <td>Price</td>
                    <td>Tags</td>
                </tr>

                @foreach($latest_items as $item)
                <tr>
                    <td><img src="{{ $item->image_url }}" class="vendor-logo img img-responsive"></td>
                    <td>{{ $item->name }}</td>
                    <td><img src="{{ $item->vendor->logo_url }}" class="vendor-logo img img-responsive"></td>
                    <td>{{ $item->vendor->name }}</td>
                    <td>${{ $item->price }}</td>
                    <td>{{ $item->tags }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script src="/js/dashboard.js"></script>
@endsection

