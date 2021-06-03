<!-- Add -->
<div class="modal fade" id="addnew" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Branch</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form" id="addBranchForm">
          		  
                  	<div class="form_div">
                    	<input type="text" class=" form_input" id="branch_name" name="branch_name" placeholder=" " >
                      <label for="title" class="form_label">Branch Name</label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                  	 </div>

                    <div class="form_div" >
                      <input type="text" class="form_input" id="contact_info" placeholder=" " name="contact_info" >
                      <label for="rate" class=" form_label">Contact</label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                    </div>
                    
                
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            	<button  class="btn btn-primary btn" id="add_branch"><i class="fa fa-save"></i> Save</button>
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
            	<h4 class="modal-title"><b>Update Branch</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form" id="editBranchForm">
            		<input type="hidden" id="branchid" name="id">
                    
                    <div class="form_div">
                      <input type="text" class="form_input" id="branch_name_edit" name="branch_name" placeholder=" ">
                      <label for="edit_branch" class="form_label">Branch Name </label>
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i>
                      <small>Error message</small>
                    </div>
                    <div class="form_div">
                      <input type="text" class="form_input" id="contact_info_edit" name="contact_info" placeholder=" ">
                      <label for="edit_contact_info" class="form_label">Contact</label>
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



     