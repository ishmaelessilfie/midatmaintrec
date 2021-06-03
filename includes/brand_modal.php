<!-- Add -->
<div class="modal fade" id="addnew" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Brand</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form" id="brandForm">
                  	<div class="form_div">
                    	<input type="text" class="form_input" id="brand_name" name="brand_name" placeholder=" ">
                      <label for="title" class="form_label">Brand Name</label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                  	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            	<button  class="btn btn-primary btn" id="addBrand"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Update Brand</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form" id="editBrandForm">
            		<input type="hidden" id="brandid" name="id">                                
                    <div class="form_div">
                      <input type="text" class="form_input" id="edit_brand_name" name="brand_name">
                      <label for="edit_brand" class="form_label">Brand Name </label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                    </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            	<button  class="btn btn-success btn" id="update"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>  