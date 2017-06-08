<div class="modal" id="restore-modal">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">
	                <span aria-hidden="true">x</span>
	            </button>

	            <h4>Restore Database</h4>
	        </div>

            <form class="form" method="POST" action="/restore" id="db-restore-form" enctype="multipart/form-data">
	        <div class="modal-body">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Select backup sql file</label>
                            
                            <div class="input-group">
				                <label class="input-group-btn">
				                    <span class="btn btn-info">
				                        Browse&hellip; <input type="file" style="display: none;" name="sql_file">
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
                            <button type="submit" class="btn btn-primary btn-block">Restore Database</button>
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