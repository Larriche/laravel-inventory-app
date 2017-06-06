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
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <form method="POST" action="" class="items-filter-form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-5">
                                    <input type="text" name="price" class="form-control" placeholder="Price">
                                </div>

                                <div class="col-md-5">
                                    <input type="text" name="color" class="form-control" placeholder="Color">
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success input-custom-height"><i class="fa fa-refresh" title="Filter"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-5 col-lg-5 col-sm-12">
                        <form method="POST" action="" class="items-filter-form">
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