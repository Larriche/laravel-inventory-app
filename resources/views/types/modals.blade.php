<!-- Pop-up modal for adding new item types -->
<div class="modal custom-modal" id="add-type">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Add New Type</h4>
            </div>

            <form class="form" method="POST" action="/item_types" id="type-add-form">
            <div class="modal-body">
                <div id="types-add-errors-container">
                    @include('partials.modal_errors')
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}
                
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
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

<!-- Pop-up modal for updating vendors-->
<div class="modal custom-modal" id="edit-type">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Update Item Type</h4>
            </div>

            <form class="form" method="POST" action="" id="type-update-form">
            <div class="modal-body">
                <div id="types-update-errors-container">
                    @include('partials.modal_errors')
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" id="name-edit-field">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-offset-1 col-md-offset-1">
                            <button type="submit" class="btn btn-primary btn-block">Update Type</button>
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