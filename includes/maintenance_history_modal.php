<div class="modal popup " id="maintenance_history" data-backdrop="static">
    <div class="modal-dialog " style="width:85% !important; margin-top:52px!important; margin-left: 214px !important" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Maintenance History</b></h4>
            </div>
             <div class="modal-body">
        <div class="row">
          <div style="margin-top: 5px; margin-left:-18px;" class="col-md-12" >
            <p>     
          <form id="report">
            <div class="form-group">
               <div class="col-md-4 col-xs-11">
                  <select class=" selectpicker  form-control  dropdown-toggle serial_number" name="serial_number"  data-live-search="true">
                        <option value="" selected> Serial number</option>
                        <?php echo $user->load_machine_serial_number(); ?>
                      </select>
               </div>
            </div>
          </form>
          </p>
      </div>
    </div>
  </br>

   <div style="margin-top: 10px; margin-right:13px;" >
         <div class="panel panel-default">
            <div class="panel-header"></div>
            <div class="panel-body">
               <div class="table-responsive" >
                  <table class="table table-striped">
                     <tr>
                        <h3 style="font-size:13px;"><STRONG>
                           <u>MAINTENANCE DETAIL REPORT</u>
                           </STRONG>
                        </h3>
                        
                     </tr>
                  <div id="table_div1">
                 </div>

                </table>
               </div>
         </div>
      </div>
   </div>
    <div style="margin-top: 10px;margin-right:13px;"  id="datail_table2" hidden>
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
                  <div id="table_div1">
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
