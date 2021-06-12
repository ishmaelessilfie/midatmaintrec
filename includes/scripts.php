<!-- jQuery 3 -->
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/jquery/dist/jquery.min.js"></script>
<!-- DataTables -->
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/rowReorder.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/responsive.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/jszip.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/vfs_fonts.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/datatables.net-bs/js/buttons.print.min.js"></script> 
<script type="text/javascript" src="parsley/dist/parsley.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- datepicker -->
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/select2/dist/js/select2.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/select2/dist/js/bootstrap-select.js"></script>
<script src="https://midatlanticmaintsys.herokuapp.com/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="https://midatlanticmaintsys.herokuapp.com/dist/js/adminlte.min.js"></script>
<!-- <script src="dist/js/demo.js"></script> -->
<script src="https://midatlanticmaintsys.herokuapp.com/dist/js/sweetalert2.js"></script>
<!--"fnDrawCallback": function(oSettings){-->
<script>

$('.loaderbody').addClass('hide');

 $(document).on('cick','a.link', function(e){
   e.preventDefault();
   var pageURL=$(this).attr('href');
   
    history.pushState(null, '', pageURL);
    $.ajax({    
       type: "GET",
       url: "page-content.php", 
       data:{page:pageURL},            
       dataType: "html",                  
       success: function(data){ 
         
        $('#pageContent').html(data);    
               
       }
   });
});
</script>
<script>
$(function(){
  //Date picker
  $('#start_date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#end_date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
});
 
$('#close').click(function(){
  $("#table_div1").empty();
 maintenance_statistics();
});

 function maintenance_statistics(){
  $.ajax({
  url: "https://midatlanticmaintsys.herokuapp.com/maintenance_history_row_all", 
  method:"GET", 
  dataType: 'json',
  success: function(result){
// alert(result);
if(result.length>0) {
$.each(result, function(data,value) {
 if (result[data].status=="Good"){
    var Statuss ='<span class="label label-success ">Good</span>';
  }else{
    var Statuss= '<span class="label label-danger ">Faulty</span>';
  };
  if(result[data].problem_statement==""){
    var problem_statement="n/a";
    
  }else{
    problem_statement = result[data].problem_statement;
  };
   if(result[data].part_replaced==""){
    var part_replaced="n/a";
    
  }else{
    part_replaced = result[data].part_replaced;
  }
  $("#table_div1").append(`<table class="table table-striped" >
                        <tr style="background-color: rgb(192,192,192);">
                        <th class="text-right"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                       </tr>
                     <tr>  
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Serial Number</th>
                        <th colspan="6" class="text-left">${result[data].serial_number}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Branch</th>
                        <th colspan="6" class="text-left">${result[data].branch_name}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Brand</th>
                        <th colspan="6" class="text-left"></td>${result[data].brand_name}</th>
                     </tr>
                     <tr >
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Make/model</th>
                        <th colspan="6" class="text-left"></td>${result[data].machine_type}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Date_of_maintenance</th>
                        <th colspan="6" class="text-left"></td>${result[data].date_added}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Worked_ON_By</th>
                        <th colspan="6" class="text-left"></td>${result[data].name}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Venue</th>
                        <th colspan="6" class="text-left"></td>${result[data].venue}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Zone</th>
                        <th colspan="6" class="text-left">Accra</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Status</th>
                        <th colspan="6" class="text-left"></td>${Statuss}</th>
                     </tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Received_by</th>
                        <th colspan="6" class="text-left">Unknown</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Problem statement</th>
                         <th colspan="6" class="text-left"></td>${problem_statement}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Part replaced</th>
                        <th colspan="6" class="text-left"></td>${part_replaced}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Remarks</th>
                        <th colspan="6" class="text-left"></td>${result[data].recommendation}</th>
                     </tr>
                      </table>`) ;
});     
}else{
  $("#table_div1").append(`<table class="table table-striped" id="exportable">
                      <td colspan="8" ><strong></strong> <span style="margin-left: 10px; margin-right:10px"></span></td>
                      <tr style="background-color: rgb(192,192,192);">
                        <th class="text-right"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                      </tr>
                     <tr> 
                        <th colspan="6" class="text-left" style="color:red; text-align:center;padding-left:100px; ">No Records to dispay</th>
                     </tr>
                     </table>`) ;
}
}

});
}
maintenance_statistics(); 
// var displayname = $("#attendancemember").find('option:selected').text();
$('.serial_number').change(function(event){  
  event.preventDefault();
   var formData = $("#report").serialize();
$("#table_div1").empty();
$.ajax({
  url: "maintenance_history_row.php", 
  method:"POST", 
  data :formData,
  dataType: 'json',
  success: function(result){

if(result.length>0) {
$.each(result, function(data,value) {
 
  if (result[data].status=="Good"){
    var Statuss ='<span class="label label-warning ">Good</span>';
  }else{
    var Statuss= '<span class="label label-danger ">Faulty</span>';
  };
  if(result[data].problem_statement==""){
    var problem_statement="n/a";
    
  }else{
    problem_statement = result[data].problem_statement;
  };
   if(result[data].part_replaced==""){
    var part_replaced="n/a";
    
  }else{
    part_replaced = result[data].part_replaced;
  }
  $("#table_div1").append(`<table class="table table-striped" id="exportable">
                      <td colspan="8" ><strong style="color:red;">Maintenance Total =</strong> <span style="margin-left: 10px; margin-right:10px">${result[data].countt}</span></td>
                        <tr style="background-color: rgb(192,192,192);">
                        <th class="text-right"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                       </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Serial Number</th>
                        <th colspan="6" class="text-left">${result[data].serial_number}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Branch</th>
                        <th colspan="6" class="text-left">${result[data].branch_name}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Brand</th>
                        <th colspan="6" class="text-left"></td>${result[data].brand_name}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Make/model</th>
                        <th colspan="6" class="text-left"></td>${result[data].machine_type}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Date_of_maintenance</th>
                        <th colspan="6" class="text-left"></td>${result[data].date_added}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Worked_ON_By</th>
                        <th colspan="6" class="text-left"></td>${result[data].name}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Venue</th>
                        <th colspan="6" class="text-left"></td>${result[data].venue}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Zone</th>
                        <th colspan="6" class="text-left">Accra</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Status</th>
                        <th colspan="6" class="text-left"></td>${Statuss}</th>
                     </tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Received_by</th>
                        <th colspan="6" class="text-left">Unknown</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Problem statement</th>
                         <th colspan="6" class="text-left"></td>${problem_statement}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Part replaced</th>
                        <th colspan="6" class="text-left"></td>${part_replaced}</th>
                     </tr>
                     <tr>
                        <th colspan="2" class="text-left"></th>
                        <th class="text-left">Remarks</th>
                        <th colspan="6" class="text-left"></td>${result[data].recommendation}</th>
                     </tr>
                      </table>`) ;
});     
}else{
  $("#table_div1").append(`<table class="table table-striped" id="exportable">
                      <td colspan="8" ><strong></strong> <span style="margin-left: 10px; margin-right:10px"></span></td>
                      <tr style="background-color: rgb(192,192,192);">
                        <th class="text-right"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                      </tr>
                     <tr> 
                        <th colspan="6" class="text-left" style="color:red; text-align:center;padding-left:100px; ">No Records to dispay</th>
                     </tr>
                     </table>`) ;
}
$(".detail_table1").hide();
$(".datail_table2").show();
}
});
});
                    
</script>



