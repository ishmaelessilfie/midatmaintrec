<!-- Add -->
<div class="modal fade" id="addnew" data-backdrop="static">
    <div class="modal-dialog">
      <form class="form-horizontal" id="machineForm"  >
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add Machine</b></h4>
            </div>
            <div class="modal-body">
              
                <div class="form-group">
                    <label for="serial_number" class="col-sm-3 control-label">Serial Number</label>

                    <div class="col-sm-9">
                      <input type="text" style="width:100%" class="form-control" id="serial_number" name="serial_number" >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select class=" selectpicker form-control" name="branch" id="branch" data-live-search="true" required>
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_branch(); ?>
                      </select>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Zone</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="zone" id="zone" required>
                        <option value="" selected>- Select -</option>
                        <option value="Accra" >Accra</option>
                        <option value="Cape Coast" >Cape Coast</option>
                        <option value="Ho" >Ho</option>
                        <option value="Koforidua" >Koforidua</option>
                        <option value="Kumasi" >Kumasi</option>
                        <option value="Sunyani" >Sunyani</option>
                        <option value="Takoradi" >Takoradi</option>
                        <option value="Tamale" >Tamale</option>
                        <option value="Tema" >Tema</option>
                        
                       
                      </select>
                    </div>
                </div>    

                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Brand</label>

                    <div class="col-sm-9">
                      <select class="form-control" name="brand" id="brand" required>
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_brand(); ?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Type</label>

                    <div class="col-sm-9">
                      <select class="form-control" name="type" id="type" required>
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_machine_type(); ?>
                      </select>
                    </div>
                </div>  

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cance</button>
              <button type="submit" class="btn btn-primary btn" id="addMachine"><i class="fa fa-save"></i> Save</button>
             
            </div>
        </div>
         </form>
    </div>
</div>

<!-- Edit -->

<div class="modal fade" id="edit" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="serial_number"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" >
                 <input type="hidden" class="machineid" name="id">
                <div class="form-group">
                    <label for="edit_serial_number" class="col-sm-3 control-label">Serial Number</label>

                    <div class="col-sm-9">
                      <input type="text"  class="form-control " id="edit_serial_number"  name="serial_number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select class="form-control edit_branch" name="branch" >
                        <option selected  id="branch_val"></option>
                        <?php echo $user->load_branch(); ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Brand</label>

                    <div class="col-sm-9">
                      <select class=" form-control edit_brand" name="brand"  >
                        <option selected selectpicker id="brand_val"></option>
                        <?php echo $user->load_brand(); ?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_zone" class="col-sm-3 control-label">Zone</label>

                    <div class="col-sm-9">
                      <!-- <input type="text" class="form-control " id="edit_zone"  name="zone"> -->
                      <select class="form-control" name="zone" id="edit_zone" required>
                        <option value="" selected>- Select -</option>
                        <option value="Accra" >Accra</option>
                        <option value="Cape Coast" >Cape Coast</option>
                        <option value="Ho" >Ho</option>
                        <option value="Koforidua" >Koforidua</option>
                        <option value="Kumasi" >Kumasi</option>
                        <option value="Sunyani" >Sunyani</option>
                        <option value="Takoradi" >Takoradi</option>
                        <option value="Tamale" >Tamale</option>
                        <option value="Tema" >Tema</option>
                        
                       
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Type</label>

                    <div class="col-sm-9">
                      <select class="form-control edit_type" name="type" >
                        <option selected  id="machine_type_val"></option>
                       <?php echo $user->load_machine_type(); ?>
                      </select>
                    </div>
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
