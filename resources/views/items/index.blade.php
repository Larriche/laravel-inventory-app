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

	                         <p class="undertext">You can add, update and delete items frominventory</p>
	                     </div>
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
<script src="/js/types.js"></script>
@endsection