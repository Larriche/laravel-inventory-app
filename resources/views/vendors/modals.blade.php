<!-- Pop-up modal for adding new vendors -->
<div class="modal custom-modal" id="add-vendor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Add New Vendor</h4>
            </div>

            <form class="form" method="POST" action="/item_vendors" id="vendor-add-form" enctype="multipart/form-data">
            <div class="modal-body">
                <div id="vendors-add-errors-container">
                    @include('partials.modal_errors')
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}
                        
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <div class="vendor-logo-placeholder">
                                    <img src="/images/item_image_placeholder.png" class="img img-responsive" id="uploaded-logo">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Upload logo</label>
                            
                            <div class="input-group">
				                <label class="input-group-btn">
				                    <span class="btn btn-info">
				                        Browse&hellip; <input type="file" style="display: none;" name="logo" data-image-element="#uploaded-logo">
				                    </span>
				                </label>
				                <input type="text" class="form-control" readonly>
				            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-offset-1 col-md-offset-1">
                            <button type="submit" class="btn btn-primary btn-block">Add Vendor</button>
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

<!-- Pop-up modal for updating vendors-->
<div class="modal custom-modal" id="edit-vendor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Update Vendor</h4>
            </div>

            <form class="form" method="POST" action="" id="vendor-update-form" enctype="multipart/form-data">
            <div class="modal-body">
                <div id="vendors-update-errors-container">
                    @include('partials.modal_errors')
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <div class="vendor-logo-placeholder">
                                    <img src="/images/item_image_placeholder.png" class="img img-responsive" id="update-uploaded-logo">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" id="name-edit-field">
                        </div>

                        <div class="form-group">
                            <label>Upload logo</label>
                            
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-info">
                                        Browse&hellip; <input type="file" style="display: none;" name="logo" data-image-element="#update-uploaded-logo">
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-offset-1 col-md-offset-1">
                            <button type="submit" class="btn btn-primary btn-block">Update Vendor</button>
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