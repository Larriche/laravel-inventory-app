@extends('layouts.app')

@section('title')
	Item types
@endsection

@section('page_title')
	Item Types
@endsection

@section('content') 
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
	        <div class="x_panel">
	             <div class="x_title">
	                 <div class="row">
	                     <div class="col-lg-12 col-md-12 col-sm-12">
	                         <button class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#add-type"><i class="fa fa-plus"></i> Add New Type</button>

	                         <p class="undertext">You can add, update and delete item types</p>
	                     </div>
	                 </div>
	             </div>

	             <div class="x_content" id="types-container">
	                 @include('types.table')
	             </div>
	        </div>
	    </div>
	</div>

	@include('types.modals')
@endsection

@section('scripts')
<script src="/js/types.js"></script>
@endsection