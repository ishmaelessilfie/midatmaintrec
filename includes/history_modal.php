<!-- Add -->
<div class="modal popup " id="history" data-backdrop="static">
    <div class="modal-dialog " style="width:84% !important; margin-top:52px!important; margin-left: 230px !important" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Maintenance History</b></h4>
            </div>
            <div class="modal-body">
            
      
    <div style="margin-top: 10px;"  id="datail_table2" >
         <div class="panel panel-default">
            <div class="panel-header"></div>
            <div class="panel-body">
               <div class="table-responsive" >
                  <table class="table table-striped">
                     <tr>
                        <h3 style="font-size:13px;"><STRONG>
                           <u>MACHINE MAINTENANCE HISTORY</u>
                           </STRONG>
                        </h3>
                        
                     </tr>
                  <div id="table_div">
                 </div>

                </table>
               </div>
         </div>
      </div>
            </div>
   
       </div>
    </div>
   </div>
</div>


<div class="modal fadeIn" id="send_modal" data-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add Maintenance Record</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" id="saitForm">
                 <div class="form-group" >
                    <label for="gender" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" id="sait_statuss" required>
                        <option value="" selected>- Select -</option>
                        <option value="Good">Good</option>
                        <option value="Faulty">Faulty</option>
                      </select>
                    </div>
                </div> 
                <div class="form-group" id="problem" >
                    <label for="contact" class="col-sm-3 control-label">Problem Statement</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="sait_problem_statement" name="problem_statement" row="row" required></textarea>
                    </div>
                </div> 
                 <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Any part replaced?</label>
                    <div class="col-sm-9"> 
                      <select class="form-control" name="ispart_replaced" id="sait_ispart_replaced" required>
                        <option value="" selected>- Select -</option>
                        <option value="No">NO</option>
                        <option value="Yes">Yes</option>
                      </select>
                    </div>
                </div>
                <div class="form-group" id="replace" hidden>
                    <label for="contact" class="col-sm-3 control-label">Part Replaced</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="sait_part_replaced" name="part_replaced" row="row" required></textarea>
                    </div>
                </div>  
                
                 <div class="form-group" id="replace" >
                    <label for="contact" class="col-sm-3 control-label">Remarks</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" name ="recommendation" id="sait_recommendation"  row="row" ></textarea>
                    </div>
                </div>   
           <div class="modal-footer">
              <button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
              <button  class="btn btn-primary" id="sait_update"><i class="fa fa-save"></i> Save</button>
              
            </div>
            </form>
        </div>
</div>
</div>
</div>



<div class="modal fadeIn" id="assign_to_tech">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Task Technician</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" id="assign_form">
                   <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Technician</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="technician" id="technician" >
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_technician(); ?>
                     </select>
                    </div>
                </div> 
           <div class="modal-footer">
              <button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
              <button  class="btn btn-primary" id="assign_btn"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
</div>
</div>


<div class="modal fade" id="edit">
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
                        <!-- <option value="" selected> Serial number</option> -->
                        <?php echo $user->load_machine_serial_number(); ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select class=" form-control" id="edit_branch" data-live-search="true" name="branch" required>
                        <!-- <option selected  ></option> -->
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
               <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Technician</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="technician" id="edit_technician" >
                        <option value="" selected>- Select -</option>
                        <?php echo $user->load_technician(); ?>
                     </select>
                    </div>
                </div>                 
       
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
              <button type="button" class="btn btn-danger btn pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button  class="btn btn-danger btn" id="update"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>


 
                   

