<!-- Add -->
<div class="modal fadeIn" id="addnew" data-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content ">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Maintenance Record</b></h4>
          	</div>
          	<div class="modal-body">
                <form class="form-horizontal" method="post" id="maintenanceForm">
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Serial Number</label>
                    <div class="col-sm-9 search_select_box" >
                      <select class=" selectpicker  form-control" name="machine" id="machine" data-live-search="true" style="background-color:#ffff !important;" required>
                        <option value="" selected> Serial number</option>
                        <?php echo $user->load_machine_serial_number(); ?>
                      </select>
                    </div>
                </div>
                 <img src="img/sample.gif" class="spin" style="display:block;margin-left:auto;margin-right:auto; margin-top:-20px; height:30px; width:30px; display:none" alt="User Image" >
                <div id="description" hidden>
                  <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Original Branch</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="original_branch" name="branch_id" readonly>
                      <input type="hidden" class="form-control" id="hidden_original_branch" name="hidden_original_branch" readonly>
                    </div>
                </div>             
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="type"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Brand</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="brand" name="brand_id" readonly>
                      <input type="hidden" class="form-control" id="hidden_brand" name="hidden_brand" >
                    </div>
                </div>
                </div>     
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Current branch</label>
                    <div class="col-sm-9">
                      <select class="selectpicker  form-control" name="cur_branch" id="cur_branch" data-live-search="true" required>
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_branch(); ?>
                      </select>
                    </div>
                </div>   
                <?php
                    if($user->is_master_user())
                    {
                      echo '<div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Technician</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="technician" id="technician" >
                        <option value="" selected>- Select -</option>';
                      ?>
                        <?php echo $user->load_technician(); ?>
                     <?php   
                     echo '</select>
                    </div>
                </div>';
                    }
                    ?>                  
                 <div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" id="status" name="statuss"  required>
                        <option value="" selected>- Select -</option>
                        <option value="Good">Good</option>
                        <option value="Faulty">Faulty</option>
                      </select>
                    </div>
                </div> 
                <div class="form-group" id="problem" hidden>
                    <label for="contact" class="col-sm-3 control-label">Problem Statement</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="problem_statement" name="problem_statement" row="row" required></textarea>
                    </div>
                </div> 
                 <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Any part replaced?</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="ispart_replaced" id="ispart_replaced" required>
                        <option value="" selected>- Select -</option>
                        <option value="No">NO</option>
                        <option value="Yes">Yes</option>
                      </select>
                    </div>
                </div>
                <div class="form-group" id="replace" hidden>
                    <label for="contact" class="col-sm-3 control-label">Part Replaced</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="part_replaced" name="part_replaced" row="row" required></textarea>
                    </div>
                </div>  
                <div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Venue</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="venue" id="venue" required>
                        <option value="" selected>- Select -</option>
                        <option value="Routine">Routine</option>
                        <option value="Field">Field</option>
                        <option value="Shop">Shop</option>
                      </select>
                    </div>
                </div>
                 <div class="form-group" id="replace" >
                    <label for="contact" class="col-sm-3 control-label">Remarks</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" name ="recommendation" id="recommendation"  row="row" ></textarea>
                    </div>
                </div>   
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
              <input type="hidden" name="action" id="action" value="add_maintenance" />
              <input type="submit" name="submit" id="addMaintenance" class="btn btn-primary btn" value="Save" />
            	</form>
          	</div>
        </div>
</div>
</div>
</div>
<div class="modal fade" id="edit" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Maintenance</b></h4>
            </div>
            <div class="modal-body">
               <form class="form-horizontal"  >
               <input type="hidden" class="" name="maintid" id="maintid">
                <input type="hidden" class="" id="edit_cur_branch"> 
               <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Serial Number</label>
                    <div class="col-sm-9 search_select_box" >
                      <select class="   form-control" name="machine" id="edit_machine"  required>
                        <?php echo $user->load_machine_serial_number(); ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select class=" form-control" id="edit_branch" data-live-search="true" name="branch" required>
                        <?php echo $user->load_branch(); ?>
                      </select>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="edit_brand" class="col-sm-3 control-label">Brand</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_brand" name="brand" required>
                        <!-- <option selected  ></option> -->
                        <?php echo $user->load_brand(); ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit+machine_type" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="type" id="edit_machine_type" required>
                        <!-- <option value="" selected>- Select -</option> -->
                        <?php echo $user->load_machine_type(); ?>
                      </select>
                    </div>
                </div>  
                <?php
                    if($user->is_master_user())
                    {
                      echo '<div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Technician</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="technician" id="edit_technician" >
                        <option value="" selected>- Select -</option>';
                      ?>
                        <?php echo $user->load_technician(); ?>
                     <?php   
                     echo '</select>
                    </div>
                </div>';
                    }
                    ?>                  
                 <div class="form-group" >
                    <label for="edit_statu" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="statuss" id="edit_status" required>
                        <!-- <option value="" selected>- Select -</option> -->
                        <option value="Good">Good</option>
                        <option value="Faulty">Faulty</option>
                      </select>
                    </div>
                </div> 
                <div class="form-group" id="edit_problem_statement_div"  hidden>
                    <label for="contact" class="col-sm-3 control-label">Problem Statement</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="edit_problem_statement" name="problem_statement" required row="5" > </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Any part replaced?</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="ispart_replaced" id="edit_ispart_replaced" required>
                        <!-- <option value="" selected>- Select -</option> -->
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                      </select>
                    </div>
                </div>
                 <div class="form-group"  id="edit_part_replaced_div" hidden >
                    <label for="contact" class="col-sm-3 control-label">Part Replaced</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="edit_part_replaced" name="part_replaced" required row="5"> </textarea>
                    </div>
                </div>
                
                <div class="form-group" >
                    <label for="venue" class="col-sm-3 control-label">Venue</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="venue" id="edit_venue" required>
                        <option value="Routine">Routine</option>
                        <option value="Field">Field</option>
                        <option value="Shop">Shop</option>
                      </select>
                    </div>
                </div> 
                <div class="form-group" id="replace" >
                    <label for="contact" class="col-sm-3 control-label">Recommendation</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="recommendation_edit"  row="row" ></textarea>
                    </div>
                </div> 

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
              <button  class="btn btn-success btn" id="update"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="detail">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content rounded-5">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Maintenance Detail</b></h4>
            </div>
            <div class="modal-body">
               <form class="form-horizontal"  >
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Serial Number</label>
                    <div class="col-sm-9 search_select_box" >
                      <input type="text" class="form-control" id="serial_number_detail" readonly>
                    </div>
                </div>          
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="type_detail"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Brand</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="brand_detail"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Current branch</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="Cbranch_detail" readonly>
                    </div>
                </div>       
                 <?php
                    if($user->is_master_user())
                    {
                      echo '<div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Technician</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="technician_detail" name="technician" readonly>
                    </div>
                </div> ';
                    }
                    ?>
                 <div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="status_detail" name="statuss" readonly>
                    </div>
                </div> 
                <div class="form-group" id="probem_statement_detail_div">
                    <label for="contact" class="col-sm-3 control-label">Problem Statement</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="problem_statement_detail" readonly ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Any part replaced?</label>
                    <div class="col-sm-9"> 
                       <input type="text" class="form-control" id="ispart_replaced_detail"  readonly>
                    </div>
                </div>
                <div class="form-group" id="replace_detail" hidden>
                    <label for="contact" class="col-sm-3 control-label">Part Replaced</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="part_replaced_detail" readonly ></textarea>
                    </div>
                </div>  
                <div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Venue</label>
                    <div class="col-sm-9"> 
                       <input type="text" class="form-control" id="venue_detail" readonly>
                     </div>
               </div>
               <div class="form-group" id="recommendation" >
                    <label for="contact" class="col-sm-3 control-label">Remarks</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="recommendation_detail" readonly ></textarea>
                    </div>
                </div>  
         </form>
    </div>
</div>
</div>
</div>