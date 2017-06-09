@extends('layouts.app')

@section('title')
	Items
@endsection

@section('page_title')
    Items In Inventory
@endsection

@section('content') 
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
	        <div class="x_panel">
	             <div class="x_title">
	                 <div class="row">
	                     <div class="col-lg-12 col-md-12 col-sm-12">
	                         <button class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i> Add New Item</button>

	                         <p class="undertext">You can add, update and delete items from inventory</p>
	                     </div>
	                 </div>
	             </div>

	             <div class="row margin-bottom">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <form method="POST" action="" class="items-filter-form" id="items-filter-form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-5">
                                    <input type="text" name="price" class="form-control input-custom-height" placeholder="Price">
                                </div>

                                <div class="col-md-5">
                                    <input type="text" name="color" class="form-control input-custom-height" placeholder="Color">
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success input-custom-height"><i class="fa fa-refresh" title="Filter"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <form>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label style="margin-top: 10px">Sort By</label>
                                </div>

                                <div class="col-md-9">
                                    <div class="select2-wrapper">
                                        <select name="sort_by" class="form-control select2 select2-hidden-accessible" id="sort-by">
                                            <option value="name">Name</option>
                                            <option value="serial_number">Serial Number</option>
                                            <option value="price">Price</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <form method="POST" action="" class="items-filter-form" id="items-search-form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-10">
                                    <input type="text" class="form-control input-custom-height" placeholder="Search For Item" name="name">
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success input-custom-height"><i class="fa fa-search" title="Search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

	             <div class="x_content" id="items-container">
	                 @include('items.table')
	             </div>
	        </div>
	    </div>
	</div>

	@include('items.modals')
@endsection

@section('scripts')
<script src="/js/items.js"></script>
@endsection