<?php
include('maintsys.php');

$user = new maintsys();

if(!$user->is_login())
{
  header("location:".$user->base_url."");
}
if(!$user->is_tech())
{
  header("location:".$user->base_url."home.php");
}

?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        S&IT data
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">S&IT</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-body">
              
              <table id="saitList" class="table table-bordered table-responsive">
                <thead>
                  <th>Serial No</th>
                  <th>Problem_statement</th>
                  <th>Branch_from</th>
                  <th>Original_branch</th>
                  <th>Date_Tasked</th>
                  <!-- <th>Assigned To</th> -->
                  <th>History</th>                  
                  <th>Acknowlegment</th>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </div>
    
    </section>  
    <form id="sait_form">
      <input type="hidden" id="serial_number" name="serial_number"/>   
    </form>
 
  </div>

  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/history_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

function saitList() {
    if (!$.fn.DataTable.isDataTable('#saitList')) {
        $("#saitList").DataTable({
           // "processing":true,
          // "serverSide":true,
        //    rowReorder: {
        //     selector: 'td:nth-child(2)'
        // },
        // responsive: true,
            "ajax": {
                "url": "readSait",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "serial_number"},
                {"data": "problem_statement"},
                {"data": "branch_from"},
                {"data": "original_branch"},
                {"data": "tech_date"},
                // {"data": "name"},
                {"data": null,
                 "render": function (data, type, row) {
                        return   '<div class="btn btn-primary btn-sm history ">View history</div>'
                      }
              },
              // {"data": null,
              //    "render": function (data, type, row) {
              //           return   '<div class="btn btn-info btn-sm assign_to ">Assign to</div>'
              //         }
              // },
                {"data": "acknowlegement_status",
                
                 "render": function (data, type, row) {
                        if(data=="assigned"){
                      return '<button type="button" class="btn btn-warning btn-sm text-weight-bold ack_btn"  <strong>Ack. Receipt</strong></button>'

                    }else if(data=='techrecieved'){
                      return '<button type="button" class="btn btn-danger btn-sm text-weight-bold send_btn"><i class="fa fa-refresh fa-spin"></i> <strong>Working_On_It...</strong></button>'
                    }else if(data=='done'|| data=="sent"){
                      return '<button type="button" class="btn btn-success btn-sm text-weight-bold"  <strong>Done!</strong></button>'
                    }else if(data=='recieved'){
                      return '<button class="btn btn-success btn-sm "> <strong>Received_By_S&IT</strong></button>'
                    }
                  }
                 }
            ]
        });
    }
};
saitList();
var saitList = $("#saitList").DataTable();

  saitList.on('click', '.ack_btn', function () {
    $tr = $(this).closest('tr');
    var data = saitList.row($tr).data();
    var id = data.id;
    var acknowlegement_status = data.acknowlegement_status;
   
    var next_status;
    switch(acknowlegement_status){
      case 'assigned': next_status ='techrecieved';
      break;
      // case 'techrecieved': next_status ='techdone';
    }
       swal({
        title: "Are you sure?",
        text: "You want to "+next_status+"?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(function (willdelete) {
      if(willdelete){
        // alert(id);
        // alert(JSON.stringify({id:id, acknowlegement_status:next_status}));
            $.ajax({
          url:"updateSait.php",
          method:"POST",
          data:JSON.stringify({id:id, acknowlegement_status:next_status}),
          success:function(data)
                 {
                    swal(""+next_status+"d!", "User "+next_status+"d Successfully","success");
                    saitList.ajax.reload();
                }     
      });
          }
});
    });



var saitList = $('#saitList').DataTable();

saitList.on('click', '.send_btn', function (e) {
  event.preventDefault();
$tr = $(this).closest('tr');
    var data = saitList.row($tr).data();
    var id = data.id;
    var problem_statement = data.problem_statement;
    var acknowlegement_status = data.acknowlegement_status;
    var ispart_replaced = data.ispart_replaced;
    var part_replaced = data.part_replaced;
    
    $('#sait_ispart_replaced').val(ispart_replaced);
    $('#sait_problem_statement').val(problem_statement);


   // alert(part_replaced);
    var next_status;
    switch(acknowlegement_status){
      case 'techrecieved': next_status ='done';

      break;

      // case 'techrecieved': next_status ='techdone';
    }
if(ispart_replaced=="Yes"){
        $('#replace').show();
        $('#sait_part_replaced').show();
        $('#sait_part_replaced').val(part_replaced);
      }else{
        $('#replace').hide();
        $('#sait_part_replaced').hide();
        $('#sait_part_replaced').val('');
        $('#sait_part_replaced').prop('required',false);

      }

  $("#sait_ispart_replaced").change(function(){
  var value = $('#sait_ispart_replaced').val();
    if (value == "No") {
      $('#replace').hide();
      $('#sait_part_replaced').val('');
      $('#sait_part_replaced').prop('required',false);
    }else if(value == "Yes"){
      $('#sait_part_replaced').val(part_replaced);
     $('#replace').show();
     $('#sait_part_replaced').show();
     $('#sait_part_replaced').prop('required',true);
    }else{
      $('#replace').hide();
      $('#sait_part_replaced').hide();
      $('#sait_part_replaced').prop('required',false);
    }

   // alert($('#sait_part_replaced').val());

  });  
  $('#send_modal').modal('show');
   $('#sait_update').on('click', function (e) {
    e.preventDefault();
    var data = JSON.stringify({
    'id':id,
    'acknowlegement_status':next_status,
    'problem_statement':$('#sait_problem_statement').val(),
    'ispart_replaced':$('#sait_ispart_replaced').val(),
    'statuss':$('#sait_statuss').val(),
    'part_replaced':$('#sait_part_replaced').val()

  });
    // alert(data);
     $.ajax({
          url:"updateSait.php",
          method:"POST",
          data:data,
          success:function(data)
                 {
                    swal(""+next_status+"d!", "User "+next_status+"d Successfully","success");
                    saitList.ajax.reload();
                    $('#send_modal').modal('hide');

                }     
      });

   });


  });

 




saitList.on('click', '.history', function (e) {

  event.preventDefault();
  $tr = $(this).closest('tr');
    var data = saitList.row($tr).data();
    var serial_number = $('#serial_number').val(data.sait_serial_number);
    var formData = $("#sait_form").serialize();
    $("#table_div").empty();
    $.ajax({
  url: "maintenance_history_row", 
  method:"POST", 
  data:formData,
  // dataType: 'json',
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
  $("#table_div").append(`<table class="table table-striped" id="exportable">
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
  $("#table_div").append(`<table class="table table-striped" id="exportable">
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
$('#history').modal('show');
});
</script>
</body>
</html>


