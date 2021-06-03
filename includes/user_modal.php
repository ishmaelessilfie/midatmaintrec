<div id="userModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
      <form method="post" id="user_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">User Name <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                      <input type="text" name="name" id="name" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup"  />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">User Contact No. <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                      <input type="text" name="contact" id="contact" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">User Email <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                      <input type="text" name="email" id="email" class="form-control" required data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                    </div>
                  </div>
                </div>

                <!-- <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">User Password <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                      <input type="password" name="password" id="password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup" />
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">Authorization type <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                      <select name="type" id="type" class="form-control" required data-parsley-trigger="keyup">
                        <option value="">Select authorization type</option>
                        <option value="Admin">Administrator</option>
                        <option value="Technician">Technician</option>
                        <option value="Sait">S&IT</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-4 text-right">User Profile</label>
                    <div class="col-md-8">
                      <input type="file" name="photo" id="photo" />
                <span id="user_uploaded_image"></span>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
      </form>
    </div>
</div>
