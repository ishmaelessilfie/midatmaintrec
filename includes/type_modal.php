<!-- Add -->
<div class="modal fade" id="addnew" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add machine type</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form" id="addTypeForm">
                  	<div class="form_div">
                    	<input type="text" class="form_input" id="machine_type" name="machine_type" placeholder=" ">
                      <label for="title" class="form_label">Machine type</label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                  	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            	<button  class="btn btn-primary btn" id="addType"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Update Machine type</b></h4>
          	</div>
          	<div class="modal-body" >
            	<form class="form" id="editForm"y >
            		<input type="hidden" id="typeid" name="id">
                    <div class="form_div">
                      <input type="text" class="form_input" id="edit_machine_type" name="machine_type">
                       <label for="edit_machine_type" class="form_label">Machine type </label>
                       <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                    </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button  class="btn btn-success btn" id="update"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>