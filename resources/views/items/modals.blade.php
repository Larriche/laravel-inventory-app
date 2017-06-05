<!-- Pop-up modal for adding new items -->
<div class="modal custom-modal" id="add-item">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Add New Item</h4>
            </div>

            <form class="form" method="POST" action="/item_types" id="item-add-form">
            <div class="modal-body">
                <div id="types-add-errors-container">
                    @include('partials.modal_errors')
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item-image-placeholder">
                                    <img src="/images/item_image_placeholder.png" class="img img-responsive" id="uploaded-item-image">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Photo of Item</label>
                            
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-info">
                                        Browse&hellip; <input type="file" style="display: none;" name="image" data-image-element="#uploaded-item-image">
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Serial Number</label>
                            <input type="text" name="serial_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Price</label>
                                    <input type="text" name="price" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Weight</label>
                                    <input type="text" name="weight" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Color</label>
                                    <input type="text" name="color" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Type</label>

                                    <div class="select2-wrapper">
                                        <select name="type_id" class="form-control select2 select2-hidden-accessible">
                                            @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Tags</label>
                                    <input type="text" name="tags" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Release Date</label>

                                    <div class="form-group">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="submission_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Vendor</label>

                            <div class="select2-wrapper">
                                <select name="vendor_id" class="form-control select2 select2-hidden-accessible">
                                    @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-offset-1 col-md-offset-1">
                            <button type="submit" class="btn btn-primary btn-block">Add Type</button>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            
            </form>
        </div>
    </div>
</div>
