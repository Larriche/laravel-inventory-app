@extends('layouts.app')

@section('title')
	Vendors
@endsection

@section('page_title')
	Vendors
@endsection

@section('content') 
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
	        <div class="x_panel">
	             <div class="x_title">
	                 <div class="row">
	                     <div class="col-lg-12 col-md-12 col-sm-12">
	                         <button class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#add-vendor"><i class="fa fa-plus"></i> Add New Vendor</button>

	                         <p class="undertext">You can add, update and delete item vendors</p>
	                     </div>
	                 </div>
	             </div>

	             <div class="x_content" id="products-container">
	                 @include('vendors.table')
	             </div>
	        </div>
	    </div>
	</div>

	@include('vendors.modals')
@endsection

@section('scripts')
<script src="/js/vendors.js"></script>
@endsection